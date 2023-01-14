<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Models\Tag;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nom')
                        ->required(),
                    Forms\Components\CheckboxList::make('concerns')
                        ->options([
                            'post' => __('Article'),
                            'tutorial' => __('Tutoriel'),
                            'discussion' => __('Discussion'),
                            'jobs' => __('Jobs'),
                        ])
                        ->required()
                        ->bulkToggleable()
                        ->columns(),
                ]),
                Forms\Components\Textarea::make('description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nom'),
                Tables\Columns\TagsColumn::make('concerns'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('concerns')
                    ->multiple()
                    ->options([
                        'post' => __('Article'),
                        'tutorial' => __('Tutoriel'),
                        'discussion' => __('Discussion'),
                        'jobs' => __('Jobs'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->whereJsonContains('concerns', $data['values']);
                    })
                ->attribute('concerns')
                ->default(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
