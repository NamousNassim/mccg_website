<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\PageSeo;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@mccg.ma')],
            ['name' => 'Administrateur MCCG', 'password' => Hash::make(env('ADMIN_PASSWORD', 'ChangeMe123!')), 'role' => 'admin']
        );

        foreach ([
            ['Accueil', 'accueil', 'MCCG | Cabinet d’expertise comptable et conseil au Maroc', 'MCCG accompagne les entreprises au Maroc en expertise comptable, fiscalité, audit, gestion sociale, conseil juridique et accompagnement stratégique.'],
            ['À propos', 'a-propos', 'À propos de MCCG — Votre partenaire de confiance', 'Découvrez MCCG, cabinet de conseil marocain engagé aux côtés des dirigeants et entreprises.'],
            ['Services', 'services', 'Nos services — Comptabilité, fiscalité, audit & conseil', 'Une expertise complète en comptabilité, fiscalité, audit, paie et accompagnement des entreprises au Maroc.'],
            ['Articles', 'articles', 'Éclairages & actualités — MCCG', 'Analyses pratiques sur la fiscalité, la gestion, la comptabilité et la vie des entreprises au Maroc.'],
            ['Contact', 'contact', 'Contacter MCCG — Parlons de vos enjeux', 'Échangez avec nos consultants et obtenez un accompagnement adapté aux enjeux de votre entreprise.'],
            ['Confidentialité', 'confidentialite', 'Politique de confidentialité — MCCG', 'Politique de confidentialité et traitement des données personnelles par MCCG.'],
            ['Conditions', 'conditions', 'Conditions d’utilisation — MCCG', 'Conditions d’utilisation du site internet MCCG.'],
        ] as [$name, $slug, $title, $description]) {
            PageSeo::updateOrCreate(['slug' => $slug], ['page_name' => $name, 'meta_title' => $title, 'meta_description' => $description]);
        }

        $services = [
            ['Expertise comptable', 'tenue-comptable', 'Une information comptable fiable pour sécuriser vos obligations et piloter votre activité.', 'De la tenue des comptes à la production des états de synthèse, MCCG fiabilise votre information financière et vous apporte une lecture claire de vos chiffres.', 'calculator'],
            ['Fiscalité', 'conseil-fiscal', 'Anticipez vos obligations et maîtrisez durablement vos risques fiscaux.', 'Nous vous accompagnons dans vos déclarations, vos choix structurants, vos opérations exceptionnelles et vos relations avec l’administration fiscale marocaine.', 'scale'],
            ['Audit & Commissariat aux comptes', 'audit-controle', 'Renforcez la confiance dans vos comptes, vos procédures et votre gouvernance.', 'Nos missions d’audit et de commissariat aux comptes identifient les risques, fiabilisent vos processus et renforcent la confiance de vos partenaires.', 'check'],
            ['Gestion sociale & RH', 'paie-social', 'Une gestion sociale précise, confidentielle et conforme à vos obligations.', 'Bulletins de paie, déclarations sociales, contrats et conseil RH : nous simplifions votre quotidien tout en sécurisant vos obligations.', 'users'],
            ['Conseil juridique', 'creation-entreprise', 'Sécurisez vos décisions et donnez à vos projets le cadre juridique adapté.', 'Choix de la forme, constitution, secrétariat juridique et opérations sur le capital : nous structurons chaque étape de la vie de votre entreprise.', 'building'],
            ['Accompagnement des entreprises', 'conseil-gestion', 'Des indicateurs clairs et un conseil stratégique pour décider avec confiance.', 'Budgets, tableaux de bord, analyse de rentabilité et optimisation de trésorerie : nos consultants éclairent vos décisions stratégiques.', 'chart'],
        ];
        foreach ($services as [$title, $slug, $short, $content, $icon]) {
            Service::updateOrCreate(['slug' => $slug], compact('title', 'content', 'icon') + [
                'short_description' => $short, 'meta_title' => $title.' — MCCG', 'meta_description' => $short, 'is_active' => true,
            ]);
        }

        $category = Category::updateOrCreate(['slug' => 'conseils'], ['name' => 'Conseils', 'description' => 'Conseils pratiques pour les dirigeants.']);
        Article::updateOrCreate(['slug' => 'bien-preparer-cloture-comptable'], [
            'title' => 'Bien préparer sa clôture comptable : les points essentiels',
            'excerpt' => 'Une méthode claire pour aborder votre clôture avec sérénité et obtenir des comptes réellement utiles.',
            'content' => '<h2>Anticiper pour mieux décider</h2><p>Une clôture réussie commence bien avant la fin de l’exercice. Rapprochements, inventaires et justificatifs doivent être organisés progressivement.</p><h2>Les contrôles indispensables</h2><p>Vérifiez les comptes clients et fournisseurs, la trésorerie, les immobilisations et les charges rattachées au bon exercice. Votre conseiller MCCG peut établir avec vous un calendrier adapté.</p>',
            'category_id' => $category->id, 'meta_title' => 'Préparer sa clôture comptable — MCCG',
            'meta_description' => 'Les contrôles essentiels pour préparer une clôture comptable fiable et utile au pilotage de votre entreprise.',
            'keywords' => 'clôture comptable, entreprise Maroc, conseil', 'status' => 'published', 'published_at' => now()->subDays(5), 'created_by' => $admin->id,
        ]);
    }
}
