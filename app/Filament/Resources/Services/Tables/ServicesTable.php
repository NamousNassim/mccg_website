<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Service')->searchable()->sortable(),
                TextColumn::make('slug')->label('URL'),
                IconColumn::make('is_active')->label('Actif')->boolean(),
                TextColumn::make('updated_at')->label('Mise à jour')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->defaultSort('title')
            ->paginated(extension_loaded('intl') ? [10, 25, 50] : false)
            ->filters([
                //
            ])
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
