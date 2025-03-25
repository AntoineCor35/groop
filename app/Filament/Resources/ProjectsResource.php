<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectsResource\Pages;
use App\Filament\Resources\ProjectsResource\RelationManagers;
use App\Models\Projects;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\ImageColumn;

class ProjectsResource extends Resource
{
    protected static ?string $model = Projects::class;

    protected static ?string $navigationGroup = 'Gestion des projets';

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations générales')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom du projet')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Entrez le nom du projet')
                            ->columnSpan(['default' => 2, 'sm' => 1]),

                        Forms\Components\Select::make('group_id')
                            ->relationship('group', 'name')
                            ->label('Groupe')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->maxLength(255),
                            ])
                            ->columnSpan(['default' => 2, 'sm' => 1]),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(4)
                            ->placeholder('Décrivez votre projet...')
                            ->columnSpanFull(),

                        Forms\Components\Select::make('tags')
                            ->relationship('tags', 'name')
                            ->multiple()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\ColorPicker::make('color')
                                    ->required(),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Médias et apparence')
                    ->schema([
                        Forms\Components\FileUpload::make('cover')
                            ->label('Image de couverture')
                            ->directory('projects/covers')
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->disk('public')
                            ->visibility('public')
                            ->dehydrated(false)
                            ->columnSpan(['default' => 2, 'sm' => 1]),

                        Forms\Components\FileUpload::make('gallery')
                            ->label('Galerie d\'images')
                            ->directory('projects/gallery')
                            ->multiple()
                            ->maxFiles(5)
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->disk('public')
                            ->visibility('public')
                            ->dehydrated(false)
                            ->columnSpan(['default' => 2, 'sm' => 1]),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Select::make('icon')
                                    ->label('Icône')
                                    ->options([
                                        'heroicon-o-academic-cap' => 'Académique',
                                        'heroicon-o-beaker' => 'Laboratoire',
                                        'heroicon-o-bolt' => 'Éclair',
                                        'heroicon-o-briefcase' => 'Mallette',
                                        'heroicon-o-calculator' => 'Calculatrice',
                                        'heroicon-o-calendar' => 'Calendrier',
                                        'heroicon-o-chart-bar' => 'Graphique',
                                        'heroicon-o-chat-bubble-left' => 'Discussion',
                                        'heroicon-o-cog' => 'Paramètres',
                                        'heroicon-o-code-bracket' => 'Code',
                                        'heroicon-o-document' => 'Document',
                                        'heroicon-o-globe-europe-africa' => 'Globe',
                                        'heroicon-o-puzzle-piece' => 'Puzzle',
                                        'heroicon-o-rocket-launch' => 'Fusée',
                                        'heroicon-o-server' => 'Serveur',
                                    ])
                                    ->searchable()
                                    ->native(false)
                                    ->default('heroicon-o-briefcase'),

                                Forms\Components\TextInput::make('custom_icon')
                                    ->label('Icône personnalisée (CSS)')
                                    ->placeholder('fa-solid fa-rocket')
                                    ->helperText('Classes CSS pour Font Awesome, Material Icons, etc.'),
                            ])
                            ->columnSpan(['default' => 2, 'sm' => 2]),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Liens')
                    ->schema([
                        Forms\Components\Repeater::make('projectLinks')
                            ->label('Liens du projet')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Titre')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('url')
                                    ->label('URL')
                                    ->required()
                                    ->url()
                                    ->maxLength(255),
                                Forms\Components\Select::make('type')
                                    ->label('Type')
                                    ->options([
                                        'documentation' => 'Documentation',
                                        'repository' => 'Dépôt de code',
                                        'website' => 'Site web',
                                        'demo' => 'Démo',
                                        'other' => 'Autre',
                                    ])
                                    ->default('website')
                                    ->required(),
                            ])
                            ->defaultItems(0)
                            ->reorderable()
                            ->columns(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover')
                    ->label('')
                    ->size(40)
                    ->circular()
                    ->getStateUsing(function (Projects $record): ?string {
                        try {
                            // Récupérer le premier média de la collection "cover"
                            $media = $record->getMedia('cover')->first();

                            // Si aucun média n'est trouvé, retourner null
                            if (!$media) {
                                return null;
                            }

                            // Retourner l'URL de la miniature ou de l'original si la miniature n'existe pas
                            return $media->getUrl('thumb') ?: $media->getUrl();
                        } catch (\Exception $e) {
                            // En cas d'erreur, retourner null
                            return null;
                        }
                    })
                    ->defaultImageUrl(fn() => asset('images/placeholder.png')),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\IconColumn::make('icon')
                    ->label('Icône')
                    ->boolean()
                    ->trueIcon(fn(string $state): string => $state)
                    ->falseIcon('heroicon-o-x-mark'),

                Tables\Columns\TextColumn::make('group.name')
                    ->label('Groupe')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('users_count')
                    ->label('Membres')
                    ->counts('users')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tags.name')
                    ->label('Tags')
                    ->badge()
                    ->color(fn(string $state): string => 'primary')
                    ->searchable(),

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
                Tables\Filters\SelectFilter::make('group')
                    ->relationship('group', 'name'),

                Tables\Filters\SelectFilter::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\Filter::make('with_members')
                    ->label('Avec membres')
                    ->query(fn(Builder $query): Builder => $query->has('users')),

                Tables\Filters\Filter::make('with_links')
                    ->label('Avec liens')
                    ->query(fn(Builder $query): Builder => $query->has('projectLinks')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\UsersRelationManager::class,
            RelationManagers\ProjectLinksRelationManager::class,
            RelationManagers\TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProjects::route('/create'),
            'edit' => Pages\EditProjects::route('/{record}/edit'),
            'view' => Pages\ViewProjects::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
