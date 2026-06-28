<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Expéditeur')->schema([
                TextEntry::make('first_name')->label('Prénom'),
                TextEntry::make('last_name')->label('Nom'),
                TextEntry::make('email')->label('E-mail')->copyable(),
                TextEntry::make('phone')->label('Téléphone')->placeholder('Non renseigné'),
                TextEntry::make('company')->label('Société')->placeholder('Non renseignée'),
                TextEntry::make('service')->label('Service demandé')->placeholder('Non précisé'),
            ])->columns(2)->columnSpanFull(),
            Section::make('Demande')->schema([
                TextEntry::make('message')->label('Message')->prose()->columnSpanFull(),
                TextEntry::make('status')->label('Statut')->badge()
                    ->formatStateUsing(fn (string $state): string => ['new' => 'Nouveau', 'contacted' => 'Contacté', 'closed' => 'Clôturé'][$state])
                    ->color(fn (string $state): string => ['new' => 'warning', 'contacted' => 'info', 'closed' => 'success'][$state]),
                TextEntry::make('created_at')->label('Reçu le')->dateTime('d/m/Y H:i'),
            ])->columns(2)->columnSpanFull(),
        ]);
    }
}
