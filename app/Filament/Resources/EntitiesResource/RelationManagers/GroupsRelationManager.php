<?php

namespace App\Filament\Resources\EntitiesResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupsRelationManager extends RelationManager
{
    protected static string $relationship = 'groups';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('promotion_id')
                    ->relationship('promotion', 'name')
                    ->searchable()
                    ->required()
                    ->preload(),
                Forms\Components\Select::make('image_id')
                    ->relationship('image', 'name')
                    ->default(null),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('promotion.name')
                    ->label('Promotion')
                    ->sortable(),
                Tables\Columns\TextColumn::make('projects_count')
                    ->label('Projets')
                    ->counts('projects')
                    ->sortable(),
                Tables\Columns\TextColumn::make('users_count')
                    ->label('Utilisateurs')
                    ->counts('users')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('promotion')
                    ->relationship('promotion', 'name'),
                Tables\Filters\Filter::make('with_projects')
                    ->label('Avec projets')
                    ->query(fn(Builder $query): Builder => $query->has('projects')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }
}
