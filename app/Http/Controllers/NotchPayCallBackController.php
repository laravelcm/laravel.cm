<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Events\SponsoringPaymentInitialize;
use App\Models\Transaction;
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

        NotchPay::setApiKey(
            apiKey: config('lcm.notch-pay-public-token')
        );

        try {
            $verifyTransaction = Payment::verify(reference: $request->get('reference'));
            $transaction->update(['status' => $verifyTransaction->transaction->status]); // @phpstan-ignore-line

            // @phpstan-ignore-next-line
            if ($verifyTransaction->transaction->status === TransactionStatus::CANCELED->value) {
                session()->flash(
                    key: 'error',
                    value: __('Votre paiement a été annulé veuillez relancer pour soutenir Laravel DRC, Merci.')
                );
            } else {
                // @ToDO: Envoie de mail de notification de remerciement pour le sponsoring si l'utilisateur est dans la base de données
                event(new SponsoringPaymentInitialize($transaction));

                Cache::forget(key: 'sponsors');

                session()->flash(
                    key: 'status',
                    value: __('Votre paiement a été pris en compte merci de soutenir Laravel DRC.')
                );
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());

            session()->flash(
                key: 'error',
                value: __('Une erreur s\'est produite lors de votre paiement. Veuillez relancer Merci.')
            );
        }

        return redirect(route('sponsors'));
    }
}
