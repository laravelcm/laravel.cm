<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use Carbon\Carbon;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use App\Events\UserBannedEvent;
use Filament\Resources\Resource;
use App\Events\UserUnbannedEvent;
use App\Actions\User\BanUserAction;
use App\Actions\User\UnBanUserAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;

final class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'untitledui-users-02';

    public static function getNavigationGroup(): ?string
    {
        return __('Management');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): void {
                $query->whereHas('roles', function (Builder $query): void {
                    $query->whereNotIn('name', ['moderator']);
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
                    ->label(__('use.inscription'))
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
                        ->form([
                            
                    TextInput::make('banned_reason')
                                ->label(__('user.ban.reason'))
                                ->required(),
                        ])
                        ->action(function (User $record, array $data) {
                            
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
                        ->action(function (User $record) {
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}