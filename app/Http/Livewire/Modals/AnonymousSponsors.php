<?php

declare(strict_types=1);

namespace App\Http\Livewire\Modals;

use App\Enums\PaymentType;
use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\ModalComponent;
use NotchPay\NotchPay;

class AnonymousSponsors extends ModalComponent
{
    public ?string $amount = null;
    public ?string $option = null;
    public ?string $name = null;
    public ?string $email = null;
    public string $type = 'company';
    public ?string $url = null;

    public function mount(string $amount, string $option): void
    {
        $this->amount = $amount;
        $this->option = $option;
    }

    public function submit(): void
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ], [
            'name.required' => 'Votre nom est requis',
            'email.required' => 'Une adresse e-mail est requise',
            'email.email' => 'Veuillez renseigner une adresse e-mail valide',
        ]);

        $adminUser = User::findByEmailAddress('support@laravel.cm');

        $notchPay = new NotchPay(config('lcm.notch-pay-public-token'));

        try {
            // @phpstan-ignore-next-line
            $payload = $notchPay->payment->initialize([
                'amount' => $this->amount,
                'email' => $this->email,
                'name' => $this->name,
                'currency' => config('notchpay-toolkit.currency.default'),
                'reference' => $adminUser->id . '-' . $adminUser->username() . '-' . uniqid(),
                'callback' => route('notchpay-callback'),
            ]);

            Transaction::query()->create([
                'amount' => $this->amount,
                'status' => $payload->transaction->status,
                'transaction_reference' => $payload->transaction->reference,
                'user_id' => $adminUser->id,
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
                        'laravel_cm_id' => null,
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

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function render(): View
    {
        return view('livewire.modals.anonymous-sponsors');
    }
}
