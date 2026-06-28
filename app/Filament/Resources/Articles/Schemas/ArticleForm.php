<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contenu éditorial')->schema([
                    TextInput::make('title')->label('Titre')->required()->maxLength(255)->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                    TextInput::make('slug')->label('URL')->required()->unique(ignoreRecord: true)->maxLength(255),
                    Select::make('category_id')->label('Catégorie')->relationship('category', 'name')->searchable()->preload(),
                    Textarea::make('excerpt')->label('Résumé')->rows(3)->columnSpanFull(),
                    RichEditor::make('content')->label('Contenu')->required()->columnSpanFull(),
                    FileUpload::make('featured_image')->label('Image à la une')->image()->directory('articles')->disk('public')->columnSpanFull(),
                ])->columns(2)->columnSpanFull(),
                Section::make('Publication')->schema([
                    Select::make('status')->label('Statut')->options(['draft' => 'Brouillon', 'published' => 'Publié'])->required()->default('draft'),
                    DateTimePicker::make('published_at')->label('Date de publication')->seconds(false),
                    Select::make('created_by')->label('Auteur')->relationship('author', 'name')->default(fn () => auth()->id())->required(),
                ])->columns(3)->columnSpanFull(),
                Section::make('Référencement SEO')->description('Laissez vide pour utiliser le titre et le résumé de l’article.')->schema([
                    TextInput::make('meta_title')->label('Meta title')->maxLength(60),
                    Textarea::make('meta_description')->label('Meta description')->rows(3)->maxLength(160),
                    TextInput::make('keywords')->label('Mots-clés')->helperText('Séparez les mots-clés par des virgules.'),
                ])->columns(2)->columnSpanFull(),
            ]);
    }
}
