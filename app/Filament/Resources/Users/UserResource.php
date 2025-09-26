<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users;

use App\Actions\User\BanUserAction;
use App\Actions\User\UnBanUserAction;
use App\Models\User;
use Awcodes\BadgeableColumn\Components\Badge;
use Awcodes\BadgeableColumn\Components\BadgeableColumn;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Columns;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'untitledui-users-02';

    public static function getNavigationGroup(): string
    {
        return __('Management');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): void {
                $query->whereHas('roles', function (Builder $query): void {
                    $query->whereNotIn('name', ['admin', 'moderator']);
                })
                    ->latest();
            })
            ->columns([
                Columns\ImageColumn::make('profile_photo_url')
                    ->label('Avatar')
                    ->circular(),
                BadgeableColumn::make('name')
                    ->suffixBadges([
                        Badge::make('username')
                            ->label(fn (User $record): string => "@{$record->username}")
                            ->color('gray'),
                    ])
                    ->description(fn (User $record): ?string => $record->location)
                    ->searchable()
                    ->sortable(),
                Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->icon('untitledui-inbox')
                    ->description(fn (User $record): ?string => $record->phone_number),
                Columns\TextColumn::make('email_verified_at')
                    ->label(__('user.validate_email'))
                    ->placeholder('N/A')
                    ->date(),
                Columns\TextColumn::make(name: 'created_at')
                    ->label(__('user.inscription'))
                    ->date(),
            ])
            ->filters([
                TernaryFilter::make('email_verified_at')
                    ->label(__('user.email_verified'))
                    ->nullable(),
            ])
            ->recordActions([
                Actions\Action::make('ban')
                    ->label(__('actions.ban'))
                    ->icon('untitledui-archive')
                    ->color('warning')
                    ->visible(fn (User $record): bool => $record->banned_at === null)
                    ->modalHeading(__('user.ban.heading'))
                    ->modalDescription(__('user.ban.description'))
                    ->authorize('ban', User::class)
                    ->schema([
                        TextInput::make('banned_reason')
                            ->label(__('user.ban.reason'))
                            ->required(),
                    ])
                    ->action(function (User $record, array $data): void {
                        app(BanUserAction::class)->execute($record, $data['banned_reason']);

                        Notification::make()
                            ->success()
                            ->duration(5000)
                            ->title(__('notifications.user.banned_title'))
                            ->body(__('notifications.user.banned_body'))
                            ->send();
                    })
                    ->requiresConfirmation(),
                Actions\Action::make('unban')
                    ->label(__('actions.unban'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (User $record): bool => $record->banned_at !== null)
                    ->authorize('unban', User::class)
                    ->action(function (User $record): void {
                        app(UnBanUserAction::class)->execute($record);

                        Notification::make()
                            ->success()
                            ->title(__('notifications.user.unbanned_title'))
                            ->duration(5000)
                            ->body(__('notifications.user.unbanned_body'))
                            ->send();
                    })
                    ->requiresConfirmation(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\DeleteBulkAction::make(),
                Actions\BulkAction::make('delete_banned')
                    ->label(__('Supprimer les utilisateurs bannis'))
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->action(function ($records): void {
                        $bannedUsers = $records->whereNotNull('banned_at');

                        if ($bannedUsers->isEmpty()) {
                            Notification::make()
                                ->warning()
                                ->title(__('actions.delete_none'))
                                ->duration(5000)
                                ->body(__('actions.delete_none_description'))
                                ->send();

                            return;
                        }

                        $bannedUsers->each(fn (User $user): ?bool => $user->delete());

                        Notification::make()
                            ->success()
                            ->title(__('actions.delete_success'))
                            ->duration(5000)
                            ->body(__('actions.delete_success_description'))
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}
