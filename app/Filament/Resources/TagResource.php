<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\TagResource\Pages\ListTags;
use App\Filament\Resources\TagResource\Pages;
use App\Models\Tag;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

final class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static string | \BackedEnum | null $navigationIcon = 'untitledui-tag-03';

    public static function getNavigationGroup(): string
    {
        return __('Contenu');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->live(onBlur: true)
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->afterStateUpdated(fn ($state, Set $set): mixed => $set('slug', Str::slug($state)))
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->readOnly()
                    ->required()
                    ->columnSpanFull(),
                Select::make('concerns')
                    ->multiple()
                    ->options([
                        'post' => 'Article',
                        'tutorial' => 'Tutoriel',
                        'discussion' => 'Discussion',
                    ])
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make(name: 'concerns'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTags::route('/'),
        ];
    }
}
