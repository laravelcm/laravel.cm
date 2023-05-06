<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Enums\PaymentType;
use App\Enums\TransactionType;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use NotchPay\NotchPay;

class SponsorSubscription extends Component
{
    public string $option = 'one-time';
    public string $amount = '';

    public function chooseOption(string $option): void
    {
        $this->option = $option;
    }

    public function subscribe(): void
    {
        $this->validate(
            ['amount' => 'required'],
            ['amount.required' => __('Votre montant est requis')],
        );

        if (!Auth::check()) {
            $this->emit('openModal', 'modals.anonymous-sponsors', [
                'amount' => $this->amount,
                'option' => $this->option,
            ]);
            return;
        }

        $notchPay = new NotchPay(config('lcm.notch-pay-public-token'));

        try {
            // @phpstan-ignore-next-line
            $payload = $notchPay->payment->initialize([
                'amount' => $this->amount,
                'email' => Auth::user()?->email,
                'name' => Auth::user()?->name,
                'currency' => 'XAF',
                'reference' => Auth::id() . '-' . Auth::user()?->username() . '-' . uniqid(),
                'callback' => route('notchpay-callback'),
            ]);

            Transaction::query()->create([
                'amount' => $this->amount,
                'status' => $payload->transaction->status,
                'transaction_reference' => $payload->transaction->reference,
                'user_id' => Auth::id(),
                'fees' => $payload->transaction->fee,
                'type' => $this->option === 'one-time'
                    ? TransactionType::ONETIME->value
                    : TransactionType::RECURSIVE->value,
                'metadata' => [
                    'currency' => $payload->transaction->currency,
                    'reference' => $payload->transaction->reference,
                    'merchant' => [
                        'reference' => $payload->transaction->merchant_reference,
                        'name' => $payload->transaction->customer->name,
                        'email' => $payload->transaction->customer->email,
                        'phone' => $payload->transaction->customer->phone,
                        'laravel_cm_id' => Auth::id(),
                    ],
                    'initiated_at' => $payload->transaction->initiated_at,
                    'description' => $payload->transaction->description,
                    'for' => PaymentType::SPONSORING->value,
                ]
            ]);

            $this->redirect($payload->authorization_url);
        } catch (NotchPay\Exception\ApiException $e) {
            session()->flash('error', __('Impossible de procéder au paiement, veuillez recommencer plus tard. Merci'));
        }
    }

    public function render(): View
    {
        return view('livewire.sponsor-subscription');
    }
}
