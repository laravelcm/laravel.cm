<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
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
                    ->label('Validation Email')
                    ->placeholder('N/A')
                    ->date(),
                Tables\Columns\TextColumn::make(name: 'created_at')
                    ->label('Inscription')
                    ->date(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Vérifiée')
                    ->nullable(),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('ban')
                        ->label(__('actions.ban'))
                        ->icon('untitledui-archive')
                        ->color('warning')
                        ->visible(fn ($record) => $record->banned_at == null)
                        ->modalHeading(__('Bannir l\'utilisateur'))
                        ->modalDescription(__('Veuillez entrer la raison du bannissement.'))
                        ->form([
                            TextInput::make('banned_reason')
                                ->label(__('Raison du bannissement'))
                                ->required(),
                        ])
                        ->action(function ($record, array $data) {
                            $record->ban($data['banned_reason']);
                        })
                        ->requiresConfirmation(),
                    
                    Action::make('unban')
                        ->label(__('actions.unban'))
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn ($record) => $record->banned_at !== null)
                        ->action(function ($record) {
                            $record->unban();
                        })
                        ->requiresConfirmation(),
                
                    Tables\Actions\DeleteAction::make(),
                ])->icon('heroicon-m-ellipsis-horizontal'),
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