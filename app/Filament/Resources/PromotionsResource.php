<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromotionsResource\Pages;
use App\Filament\Resources\PromotionsResource\RelationManagers;
use App\Models\Promotions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromotionsResource extends Resource
{
    protected static ?string $model = Promotions::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('parent_promotion_id')
                    ->relationship('parentPromotion', 'name')
                    ->default(null),
                Forms\Components\Select::make('image_id')
                    ->relationship('image', 'name')
                    ->default(null),
                Forms\Components\Select::make('entity_id')
                    ->relationship('entity', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parentPromotion.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('image.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('entity.name')
                    ->numeric()
                    ->sortable(),
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
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPromotions::route('/'),
            'create' => Pages\CreatePromotions::route('/create'),
            'edit' => Pages\EditPromotions::route('/{record}/edit'),
        ];
    }
}
