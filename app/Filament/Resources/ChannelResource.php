<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\ChannelResource\Pages\ListChannels;
use App\Filament\Resources\ChannelResource\Pages;
use App\Models\Channel;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

final class ChannelResource extends Resource
{
    use Translatable;

    protected static ?string $model = Channel::class;

    protected static string | \BackedEnum | null $navigationIcon = 'untitledui-git-branch';

    public static function getNavigationGroup(): string
    {
        return __('Forum');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Set $set): mixed => $set('slug', Str::slug($state)))
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->readOnly()
                    ->required()
                    ->columnSpanFull(),
                Select::make('parent_id')
                    ->relationship(
                        name: 'parent',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->whereNull('parent_id')
                    )
                    ->live()
                    ->default(null)
                    ->columnSpanFull(),
                ColorPicker::make('color')
                    ->label('Couleur')
                    ->hex()
                    ->live()
                    ->columnSpanFull()
                    ->required(fn (Get $get): bool => $get('parent_id') === null),
                Textarea::make('description')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                TextColumn::make('parent.name')
                    ->label('Parent')
                    ->placeholder('N/A')
                    ->sortable(),
                TextColumn::make('thread_number')
                    ->label('Nombre de sujets')
                    ->getStateUsing(fn ($record) => $record->threads()->count()),
                ColorColumn::make('color')
                    ->label('Couleur')
                    ->placeholder('N/A'),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->iconButton(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChannels::route('/'),
        ];
    }
}
