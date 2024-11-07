<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): void {
                $query->withoutRole(['admin', 'moderator']);
            })
            ->columns([
                TextColumn::make('name')
                    ->label('Nom'),
                TextColumn::make('email')
                    ->label('Email'),
                TextColumn::make('username')
                    ->label('Username'),
                TextColumn::make(name: 'Points')
                    ->getStateUsing(fn (User $user) => $user->getPoints().' XP')
                    ->sortable(),
                TextColumn::make(name: 'created_at')
                    ->label('Date de création'),
                TextColumn::make(name: 'created_at')
                    ->label('Date de création'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}
