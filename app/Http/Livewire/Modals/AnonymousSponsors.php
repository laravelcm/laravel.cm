<?php

declare(strict_types=1);

namespace App\Http\Livewire\Modals;

use App\Enums\PaymentType;
use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;
use NotchPay\NotchPay;
use NotchPay\Payment;

final class AnonymousSponsors extends ModalComponent
{
    public ?string $amount = null;

    public ?string $option = null;

    public ?string $name = null;

    public ?string $email = null;

    public string $type = 'company';

    public string $currency = 'XAF';

    public ?string $url = null;

    public function mount(string $amount, string $option, string $currency): void
    {
        $this->amount = $amount;
        $this->option = $option;
        $this->currency = $currency;
    }

    public function submit(): void
    {
        $this->validate(
            rules: [
                'name' => 'required',
                'email' => 'required|email',
            ],
            messages: [
                'name.required' => __('Votre nom est requis'),
                'email.required' => __('Une adresse e-mail est requise'),
                'email.email' => __('Veuillez renseigner une adresse e-mail valide'),
            ]
        );

        $adminUser = User::findByEmailAddress(
            emailAddress: app()->environment('production') ? 'support@laravel.cm' : 'user@laravel.cm'
        );

        NotchPay::setApiKey(
            apiKey: config('lcm.notch-pay-public-token')
        );

        try {
            $payload = Payment::initialize([
                'amount' => $this->amount,
                'email' => $this->email,
                'name' => $this->name,
                'currency' => $this->currency,
                'reference' => $adminUser->id.'-'.$adminUser->username().'-'.uniqid(),
                'callback' => route('notchpay-callback'),
                'description' => __('Soutien de la communauté Laravel & PHP Cameroun.'),
            ]);

            Transaction::query()->create([
                'amount' => $this->amount,
                'status' => $payload->transaction->status,
                'transaction_reference' => $payload->transaction->reference,
                'user_id' => $adminUser->id,
                'fees' => $payload->transaction->fee,
                'type' => 'one-time' === $this->option
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

            $this->redirect($payload->authorization_url); // @phpstan-ignore-line
        } catch (\NotchPay\Exceptions\ApiException $e) {
            Log::error($e->getMessage());
            session()->flash(
                key: 'error',
                value: __('Impossible de procéder au paiement, veuillez recommencer plus tard. Merci')
            );
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
