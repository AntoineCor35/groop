<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EntitiesResource\Pages;
use App\Filament\Resources\EntitiesResource\RelationManagers;
use App\Models\Entities;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EntitiesResource extends Resource
{
    protected static ?string $model = Entities::class;

    protected static ?string $navigationGroup = 'Structure organisationnelle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('image_id')
                    ->relationship('image', 'name')
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('promotions_count')
                    ->label('Promotions')
                    ->counts('promotions')
                    ->sortable(),
                Tables\Columns\TextColumn::make('groups_count')
                    ->label('Groupes')
                    ->counts('groups')
                    ->sortable(),
                Tables\Columns\TextColumn::make('image.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('with_promotions')
                    ->label('Avec promotions')
                    ->query(fn(Builder $query): Builder => $query->has('promotions')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PromotionsRelationManager::class,
            RelationManagers\GroupsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEntities::route('/'),
            'create' => Pages\CreateEntities::route('/create'),
            'edit' => Pages\EditEntities::route('/{record}/edit'),
        ];
    }
}
