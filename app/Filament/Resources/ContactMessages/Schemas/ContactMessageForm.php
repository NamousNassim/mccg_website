<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Expéditeur')->schema([
                    TextInput::make('first_name')->label('Prénom')->disabled(),
                    TextInput::make('last_name')->label('Nom')->disabled(),
                    TextInput::make('email')->label('E-mail')->disabled(),
                    TextInput::make('phone')->label('Téléphone')->disabled(),
                    TextInput::make('company')->label('Entreprise')->disabled(),
                    TextInput::make('service')->label('Service demandé')->disabled(),
                ])->columns(2)->columnSpanFull(),
                Section::make('Demande')->schema([
                    Textarea::make('message')->label('Message')->rows(8)->disabled()->columnSpanFull(),
                    Select::make('status')->label('Statut')->options(['new' => 'Nouveau', 'contacted' => 'Contacté', 'closed' => 'Clôturé'])->required(),
                ])->columnSpanFull(),
            ]);
    }
}
