<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Actions\User\BanUserAction;
use App\Actions\User\UnBanUserAction;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'untitledui-users-02';

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
                Tables\Columns\ImageColumn::make('profile_photo_url')
                    ->label('Avatar')
                    ->circular(),
                BadgeableColumn::make('name')
                    ->suffixBadges([
                        Badge::make('username')
                            ->label(fn ($record) => "@{$record->username}")
                            ->color('gray'),
                    ])
                    ->description(fn ($record): ?string => $record->location)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->icon('untitledui-inbox')
                    ->description(fn ($record): ?string => $record->phone_number),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label(__('user.validate_email'))
                    ->placeholder('N/A')
                    ->date(),
                Tables\Columns\TextColumn::make(name: 'created_at')
                    ->label(__('user.inscription'))
                    ->date(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label(__('user.email_verified'))
                    ->nullable(),
            ])
            ->actions([
                Tables\Actions\Action::make('ban')
                    ->label(__('actions.ban'))
                    ->icon('untitledui-archive')
                    ->color('warning')
                    ->visible(fn ($record) => $record->banned_at == null)
                    ->modalHeading(__('user.ban.heading'))
                    ->modalDescription(__('user.ban.description'))
                    ->authorize('ban', User::class)
                    ->form([
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

                Tables\Actions\Action::make('unban')
                    ->label(__('actions.unban'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->banned_at !== null)
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

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('delete_banned')
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

                        $bannedUsers->each(function (User $user): void {
                            $user->delete();
                        });

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
