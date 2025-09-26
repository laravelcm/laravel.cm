<?php

declare(strict_types=1);

namespace App\Filament\Resources\Tags;

use App\Models\Tag;
use Filament\Actions;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

final class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static string|\BackedEnum|null $navigationIcon = 'untitledui-tag-03';

    public static function getNavigationGroup(): string
    {
        return __('Contenu');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Components\TextInput::make('name')
                    ->live(onBlur: true)
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->afterStateUpdated(fn ($state, Set $set): mixed => $set('slug', Str::slug($state)))
                    ->columnSpanFull(),
                Components\TextInput::make('slug')
                    ->readOnly()
                    ->required()
                    ->columnSpanFull(),
                Components\Select::make('concerns')
                    ->multiple()
                    ->options([
                        'post' => 'Article',
                        'tutorial' => 'Tutoriel',
                        'discussion' => 'Discussion',
                    ])
                    ->required()
                    ->columnSpanFull(),
                Components\Textarea::make('description')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make(name: 'concerns'),
            ])
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTags::route('/'),
        ];
    }
}
