<?php

namespace App\Filament\Resources\ProjectsResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectLinksRelationManager extends RelationManager
{
    protected static string $relationship = 'projectLinks';

    protected static ?string $recordTitleAttribute = 'title';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('url')
                    ->required()
                    ->url()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options([
                        'documentation' => 'Documentation',
                        'repository' => 'Dépôt de code',
                        'website' => 'Site web',
                        'demo' => 'Démo',
                        'other' => 'Autre',
                    ])
                    ->default('website')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->url(fn(string $state): string => $state)
                    ->openUrlInNewTab()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'documentation' => 'Documentation',
                        'repository' => 'Dépôt de code',
                        'website' => 'Site web',
                        'demo' => 'Démo',
                        'other' => 'Autre',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'documentation' => 'info',
                        'repository' => 'success',
                        'website' => 'primary',
                        'demo' => 'warning',
                        'other' => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
