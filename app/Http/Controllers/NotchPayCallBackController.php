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
use Illuminate\Support\Facades\Log;
use NotchPay\NotchPay;
use NotchPay\Payment;

final class NotchPayCallBackController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::query()
            ->where('transaction_reference', $request->get('reference'))
            ->firstOrFail();
        /** @var string $apiKey */
        $apiKey = config('lcm.notch-pay-public-token');

        NotchPay::setApiKey($apiKey);

        try {
            $verifyTransaction = Payment::verify(reference: $request->get('reference'));
            $transaction->update(['status' => $verifyTransaction->transaction->status]); // @phpstan-ignore-line

            // @phpstan-ignore-next-line
            if ($verifyTransaction->transaction->status === TransactionStatus::CANCELED->value) {
                notify()
                    ->error()
                    ->title(__('pages/sponsoring.payment.failed_title'))
                    ->message(__('pages/sponsoring.payment.failed_message'))
                    ->send();
            } else {
                event(new SponsoringPaymentInitialize($transaction));

                Cache::forget(key: 'sponsors');

                notify()
                    ->success()
                    ->title(__('pages/sponsoring.payment.success_title'))
                    ->message(__('pages/sponsoring.payment.success_message'))
                    ->send();
            }

        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            notify()
                ->error()
                ->title(__('pages/sponsoring.payment.error_title'))
                ->message(__('pages/sponsoring.payment.error_message'))
                ->send();
        }

        return redirect(route('sponsors'));
    }
}
