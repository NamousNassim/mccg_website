<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nom')->searchable()->sortable(),
                TextColumn::make('email')->label('E-mail')->searchable()->copyable(),
                TextColumn::make('role')->label('Rôle')->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'admin' ? 'Administrateur' : 'Marketeur')
                    ->color(fn (string $state): string => $state === 'admin' ? 'danger' : 'info'),
                TextColumn::make('email_verified_at')->label('E-mail vérifié')->dateTime('d/m/Y H:i')->placeholder('Non vérifié')->sortable(),
                TextColumn::make('created_at')->label('Créé le')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')->label('Rôle')->options([
                    'admin' => 'Administrateur',
                    'marketer' => 'Marketeur',
                ]),
            ])
            ->defaultSort('name')
            ->paginated(extension_loaded('intl') ? [10, 25, 50] : false)
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
