<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ChannelResource\Pages;
use App\Models\Channel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

final class ChannelResource extends Resource
{
    use Translatable;

    protected static ?string $model = Channel::class;

    protected static ?string $navigationIcon = 'untitledui-git-branch';

    public static function getNavigationGroup(): string
    {
        return __('Forum');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state)))
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('slug')
                    ->readOnly()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('parent_id')
                    ->relationship(
                        name: 'parent',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->whereNull('parent_id')
                    )
                    ->live()
                    ->default(null)
                    ->columnSpanFull(),
                Forms\Components\ColorPicker::make('color')
                    ->label('Couleur')
                    ->hex()
                    ->live()
                    ->columnSpanFull()
                    ->required(fn (Forms\Get $get): bool => $get('parent_id') === null),
                Forms\Components\Textarea::make('description')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Parent')
                    ->placeholder('N/A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('thread_number')
                    ->label('Nombre de sujets')
                    ->getStateUsing(fn ($record) => $record->threads()->count()),
                Tables\Columns\ColorColumn::make('color')
                    ->label('Couleur')
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListChannels::route('/'),
        ];
    }
}
