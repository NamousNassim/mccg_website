<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Reçu le')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('first_name')->label('Prénom')->searchable(),
                TextColumn::make('last_name')->label('Nom')->searchable(),
                TextColumn::make('company')->label('Entreprise')->searchable(),
                TextColumn::make('email')->label('E-mail')->copyable(),
                TextColumn::make('service')->label('Service'),
                TextColumn::make('status')->label('Statut')->badge()->formatStateUsing(fn (string $state) => ['new' => 'Nouveau', 'contacted' => 'Contacté', 'closed' => 'Clôturé'][$state])->color(fn (string $state) => ['new' => 'warning', 'contacted' => 'info', 'closed' => 'success'][$state]),
            ])
            ->filters([
                SelectFilter::make('status')->label('Statut')->options(['new' => 'Nouveau', 'contacted' => 'Contacté', 'closed' => 'Clôturé']),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(extension_loaded('intl') ? [10, 25, 50] : false)
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions(extension_loaded('intl') ? [
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ] : []);
    }
}
