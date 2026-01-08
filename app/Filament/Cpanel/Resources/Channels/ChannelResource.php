<?php

declare(strict_types=1);

namespace App\Filament\Cpanel\Resources\Channels;

use App\Models\Channel;
use BackedEnum;
use Filament\Actions;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities;
use Filament\Schemas\Schema;
use Filament\Tables\Columns;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;

final class ChannelResource extends Resource
{
    use Translatable;

    protected static ?string $model = Channel::class;

    protected static string|BackedEnum|null $navigationIcon = 'untitledui-git-branch';

    public static function getNavigationGroup(): string
    {
        return __('Forum');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Components\TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Utilities\Set $set): mixed => $set('slug', Str::slug($state)))
                    ->columnSpanFull(),
                Components\TextInput::make('slug')
                    ->readOnly()
                    ->required()
                    ->columnSpanFull(),
                Components\Select::make('parent_id')
                    ->relationship(
                        name: 'parent',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->whereNull('parent_id')
                    )
                    ->live()
                    ->default(null)
                    ->columnSpanFull(),
                Components\ColorPicker::make('color')
                    ->label('Couleur')
                    ->hex()
                    ->live()
                    ->columnSpanFull()
                    ->required(fn (Utilities\Get $get): bool => $get('parent_id') === null),
                Components\Textarea::make('description')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                Columns\TextColumn::make('parent.name')
                    ->label('Parent')
                    ->placeholder('N/A')
                    ->sortable(),
                Columns\TextColumn::make('thread_number')
                    ->label('Nombre de sujets')
                    ->getStateUsing(fn ($record) => $record->threads()->count()),
                Columns\ColorColumn::make('color')
                    ->label('Couleur')
                    ->placeholder('N/A'),
                Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([
                Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChannels::route('/'),
        ];
    }
}
