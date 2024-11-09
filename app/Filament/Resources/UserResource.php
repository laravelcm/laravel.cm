<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
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
