<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Events\SponsoringPaymentInitialize;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use NotchPay\NotchPay;
use NotchPay\Payment;

final class NotchPayCallBackController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $reference = $request->string('reference')->toString();

        if ($reference === '') {
            return redirect(route('sponsors'));
        }

        /** @var Transaction $transaction */
        $transaction = Transaction::query()
            ->where('transaction_reference', $reference)
            ->firstOrFail();

        if ($transaction->status === TransactionStatus::COMPLETE) {
            return redirect(route('sponsors'));
        }

        /** @var string $apiKey */
        $apiKey = config('lcm.notch-pay-public-token');
        NotchPay::setApiKey($apiKey);

        try {
            $verifyTransaction = Payment::verify(reference: $reference);
            /** @var string $remoteStatus */
            $remoteStatus = $verifyTransaction->transaction->status; // @phpstan-ignore-line

            $shouldDispatchPayment = DB::transaction(function () use ($transaction, $remoteStatus): bool {
                /** @var Transaction $fresh */
                $fresh = Transaction::query()
                    ->lockForUpdate()
                    ->findOrFail($transaction->id);

                if ($fresh->status === TransactionStatus::COMPLETE) {
                    return false;
                }

                $fresh->update(['status' => $remoteStatus]);

                return $remoteStatus === TransactionStatus::COMPLETE->value;
            });

            if ($remoteStatus === TransactionStatus::CANCELED->value) {
                notify()
                    ->error()
                    ->title(__('pages/sponsoring.payment.failed_title'))
                    ->message(__('pages/sponsoring.payment.failed_message'))
                    ->send();

                return redirect(route('sponsors'));
            }

            if ($shouldDispatchPayment) {
                /** @var Transaction $refreshed */
                $refreshed = $transaction->fresh();
                event(new SponsoringPaymentInitialize($refreshed));

                Cache::forget(key: 'sponsors');

                notify()
                    ->success()
                    ->title(__('pages/sponsoring.payment.success_title'))
                    ->message(__('pages/sponsoring.payment.success_message'))
                    ->send();
            }
        } catch (Exception $exception) {
            Log::error('NotchPay verification failed', [
                'reference' => $reference,
                'message' => $exception->getMessage(),
            ]);

            notify()
                ->error()
                ->title(__('pages/sponsoring.payment.error_title'))
                ->message(__('pages/sponsoring.payment.error_message'))
                ->send();
        }

        return redirect(route('sponsors'));
    }
}
