<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Events\SponsoringPaymentInitialize;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotchPayCallBackController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::query()
            ->where('transaction_reference', $request->get('reference'))
            ->firstOrFail();
        $transaction->update(['status' => $request->get('status')]);

        if ($request->get('status') === TransactionStatus::CANCELED->value) {
            session()->flash('error', __('Votre paiement a été annulé veuillez relancer si vous souhaitez soutenir Laravel Cameroun, Merci.'));
        } else {
            // @ToDO Envoie de mail de notification de remerciement pour le sponsoring si l'utilisateur est dans la base de données
            event(new SponsoringPaymentInitialize($transaction));

            session()->flash('status', __('Votre paiement a été pris en compte merci de soutenir Laravel Cameroun.'));
        }


        return redirect(route('sponsors'));
    }
}
