<?php

namespace App\Filament\Resources\Articles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Titre')->searchable()->sortable()->limit(50),
                TextColumn::make('category.name')->label('Catégorie')->badge(),
                TextColumn::make('status')->label('Statut')->badge()->formatStateUsing(fn (string $state) => $state === 'published' ? 'Publié' : 'Brouillon')->color(fn (string $state) => $state === 'published' ? 'success' : 'gray'),
                TextColumn::make('published_at')->label('Publication')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('author.name')->label('Auteur'),
            ])
            ->filters([
                SelectFilter::make('status')->label('Statut')->options(['draft' => 'Brouillon', 'published' => 'Publié']),
                SelectFilter::make('category')->relationship('category', 'name')->label('Catégorie'),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(extension_loaded('intl') ? [10, 25, 50] : false)
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions(extension_loaded('intl') ? [
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ] : []);
    }
}
