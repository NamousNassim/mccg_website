<?php

namespace App\Filament\Resources\PageSeos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PageSeosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('page_name')->label('Page')->searchable()->sortable(),
                TextColumn::make('slug')->label('URL'),
                TextColumn::make('meta_title')->label('Meta title')->limit(55),
                ImageColumn::make('og_image')->label('OG'),
                TextColumn::make('updated_at')->label('Mise à jour')->date('d/m/Y')->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->paginated(extension_loaded('intl') ? [10, 25, 50] : false)
            ->toolbarActions(extension_loaded('intl') ? [
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ] : []);
    }
}
