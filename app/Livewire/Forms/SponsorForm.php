<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Enums\PaymentType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;
use NotchPay\NotchPay;
use NotchPay\Payment;
use Throwable;

final class SponsorForm extends Form
{
    #[Validate('required|email')]
    public ?string $email = null;

    #[Validate('required|min:5|max:75')]
    public ?string $name = null;

    #[Validate('required')]
    public string $profile = 'developer';

    #[Validate('nullable|url')]
    public ?string $website = null;

    #[Validate('required')]
    public string $currency = 'xaf';

    #[Validate('required|integer|min:1')]
    public ?int $amount = null;

    public function setUser(?User $user): void
    {
        if ($user instanceof User) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->website = $user->website;
        }
    }

    public function support(): string
    {
        /** @var string $apiKey */
        $apiKey = config('lcm.notch-pay-public-token');
        NotchPay::setApiKey(apiKey: $apiKey);
        /** @var string $supportEmail */
        $supportEmail = config('lcm.support_email');

        /** @var User $user */
        $user = Auth::check()
            ? Auth::user()
            : User::findByEmailAddress($supportEmail);

        $transaction = Transaction::query()->create([
            'amount' => $this->amount,
            'status' => TransactionStatus::PENDING,
            'transaction_reference' => '',
            'user_id' => $user->id,
            'fees' => 0,
            'type' => TransactionType::ONETIME,
        ]);

        try {
            /** @var object{authorization_url: string, transaction: object} $payload */
            $payload = Payment::initialize([
                'amount' => $this->amount,
                'email' => $this->email,
                'name' => $this->name,
                'currency' => $this->currency,
                'reference' => $transaction->id,
                'callback' => route('notchpay-callback'),
                'description' => __('Soutien de la communauté Laravel & PHP Cameroun.'),
            ]);

            $transaction->update([
                'transaction_reference' => $payload->transaction->reference, // @phpstan-ignore-line
                'status' => $payload->transaction->status, // @phpstan-ignore-line
                'fees' => $payload->transaction->fees->fee ?? 0,
                'metadata' => [
                    'currency' => $payload->transaction->currency, // @phpstan-ignore-line
                    'reference' => $payload->transaction->reference, // @phpstan-ignore-line
                    'merchant' => [
                        'reference' => $payload->transaction->merchant_reference, // @phpstan-ignore-line
                        'customer' => $payload->transaction->customer, // @phpstan-ignore-line
                        'name' => $this->name,
                        'email' => $this->email,
                        'laravel_cm_id' => Auth::id(),
                        'profile' => $this->profile,
                    ],
                    'initiated_at' => $payload->transaction->created_at, // @phpstan-ignore-line
                    'description' => $payload->transaction->description, // @phpstan-ignore-line
                    'for' => PaymentType::SPONSORING->value,
                ],
            ]);

            return $payload->authorization_url;
        } catch (Throwable $throwable) {
            $transaction->update(['status' => TransactionStatus::Failed]);

            throw $throwable;
        }
    }
}
