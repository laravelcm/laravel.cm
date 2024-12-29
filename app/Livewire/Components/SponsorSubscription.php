<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Enums\PaymentType;
use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use NotchPay\Exceptions\ApiException;
use NotchPay\NotchPay;
use NotchPay\Payment;

/**
 * @property-read Form $form
 */
final class SponsorSubscription extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $auth = Auth::user();

        $this->form->fill([
            'email' => $auth?->email,
            'name' => $auth?->name,
            'website' => $auth?->website,
            'profile' => 'developer',
            'currency' => 'xaf',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('validation.attributes.name'))
                    ->minLength(5)
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label(__('validation.attributes.email'))
                    ->email()
                    ->required(),
                Forms\Components\ToggleButtons::make('profile')
                    ->label(__('pages/sponsoring.sponsor_form.profile'))
                    ->options([
                        'developer' => __('validation.attributes.freelance'),
                        'company' => __('validation.attributes.company'),
                    ])
                    ->icons([
                        'developer' => 'phosphor-dev-to-logo-duotone',
                        'company' => 'phosphor-buildings-duotone',
                    ])
                    ->grouped(),
                Forms\Components\TextInput::make('website')
                    ->label(__('global.website'))
                    ->prefixIcon('heroicon-m-globe-alt')
                    ->url(),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Select::make('currency')
                            ->label(__('validation.attributes.currency'))
                            ->live()
                            ->native()
                            ->options([
                                'xaf' => 'XAF',
                                'eur' => 'EUR',
                                'usd' => 'USD',
                            ]),
                        Forms\Components\TextInput::make('amount')
                            ->label(__('validation.attributes.amount'))
                            ->integer()
                            ->required()
                            ->afterStateUpdated(fn (?int $state) => $state ? abs($state) : 0)
                            ->prefix(fn (Forms\Get $get) => match ($get('currency')) {
                                'usd' => '$',
                                default => null
                            })
                            ->suffix(fn (Forms\Get $get) => match ($get('currency')) {
                                'eur' => '€',
                                'xaf' => 'FCFA',
                                default => null,
                            })
                            ->columnSpan(3),
                    ])
                    ->columns(4)
                    ->columnSpanFull(),
            ])
            ->statePath('data')
            ->columns();
    }

    public function submit(): void
    {
        $this->validate();

        $email = data_get($this->form->getState(), 'email');
        $amount = data_get($this->form->getState(), 'amount');
        $name = data_get($this->form->getState(), 'name');

        /** @var User $user */
        $user = Auth::check() ? Auth::user() : User::findByEmailAddress(config('lcm.support_email'));

        NotchPay::setApiKey(apiKey: config('lcm.notch-pay-public-token'));

        try {
            $payload = Payment::initialize([
                'amount' => $amount,
                'email' => $email,
                'name' => $name,
                'currency' => data_get($this->form->getState(), 'currency'),
                'reference' => $user->id.'-'.$user->username().'-'.uniqid(),
                'callback' => route('notchpay-callback'),
                'description' => __('Soutien de la communauté Laravel & PHP RDC.'),
            ]);

            Transaction::query()->create([
                'amount' => $amount,
                'status' => $payload->transaction->status,
                'transaction_reference' => $payload->transaction->reference,
                'user_id' => $user->id,
                'fees' => $payload->transaction->fee,
                'type' => TransactionType::ONETIME->value,
                'metadata' => [
                    'currency' => $payload->transaction->currency,
                    'reference' => $payload->transaction->reference,
                    'merchant' => [
                        'reference' => $payload->transaction->merchant_reference,
                        'customer' => $payload->transaction->customer,
                        'name' => $name,
                        'laravel_cm_id' => Auth::id() ?? null,
                        'profile' => data_get($this->form->getState(), 'profile'),
                    ],
                    'initiated_at' => $payload->transaction->created_at,
                    'description' => $payload->transaction->description,
                    'for' => PaymentType::SPONSORING->value,
                ],
            ]);

            $this->redirect($payload->authorization_url); // @phpstan-ignore-line
        } catch (ApiException $e) {
            Log::error($e->getMessage());

            Notification::make()
                ->title(__('notifications.sponsor_error_title'))
                ->body(__('notifications.sponsor_error_body'))
                ->danger()
                ->send();
        }
    }

    public function render(): View
    {
        return view('livewire.components.sponsor-subscription', [
            'sponsors' => Cache::remember(
                key: 'sponsors',
                ttl: now()->addWeek(),
                callback: fn () => Transaction::with(['user', 'user.media'])
                    ->scopes('complete')
                    ->distinct()
                    ->get(['id', 'user_id', 'metadata'])
            ),
        ]);
    }
}
