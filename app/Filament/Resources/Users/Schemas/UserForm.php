<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Compte utilisateur')->schema([
                    TextInput::make('name')->label('Nom complet')->required()->maxLength(255),
                    TextInput::make('email')->label('Adresse e-mail')->email()->required()->unique(ignoreRecord: true)->maxLength(255),
                    Select::make('role')->label('Rôle')->options([
                        'admin' => 'Administrateur',
                        'marketer' => 'Marketeur',
                    ])->required()->default('marketer')
                        ->disabled(fn (?User $record): bool => $record?->is(auth()->user()) ?? false)
                        ->dehydrated(fn (?User $record): bool => ! ($record?->is(auth()->user()) ?? false)),
                    DateTimePicker::make('email_verified_at')->label('E-mail vérifié le')->seconds(false)->nullable(),
                ])->columns(2)->columnSpanFull(),
                Section::make('Sécurité')->description('Laissez les champs vides pour conserver le mot de passe actuel lors d’une modification.')->schema([
                    TextInput::make('password')->label('Mot de passe')->password()->revealable()->minLength(12)
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->same('password_confirmation')
                        ->dehydrated(fn (?string $state): bool => filled($state)),
                    TextInput::make('password_confirmation')->label('Confirmation du mot de passe')->password()->revealable()->minLength(12)
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(false),
                ])->columns(2)->columnSpanFull(),
            ]);
    }
}
