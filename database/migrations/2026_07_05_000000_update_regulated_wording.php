<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('page_seos')) {
            DB::table('page_seos')->where('slug', 'accueil')->update([
                'meta_title' => 'MCCG | Cabinet de conseil comptable et fiscal au Maroc',
                'meta_description' => 'MCCG accompagne les entreprises au Maroc en tenue comptable, fiscalité, gestion sociale, conseil juridique et accompagnement administratif.',
            ]);

            DB::table('page_seos')->where('slug', 'services')->update([
                'meta_title' => 'Services comptables, fiscaux et sociaux | MCCG',
                'meta_description' => 'Découvrez les services MCCG : tenue comptable, conseil fiscal, gestion sociale, paie, accompagnement administratif et conseil aux entreprises.',
            ]);
        }

        if (Schema::hasTable('services')) {
            $services = [
                'tenue-comptable' => [
                    'title' => 'Tenue comptable',
                    'content' => 'De la tenue des comptes au suivi des états de synthèse, MCCG organise votre information financière et vous apporte une lecture claire de vos chiffres.',
                    'meta_title' => 'Tenue comptable — MCCG',
                ],
                'conseil-fiscal' => [
                    'title' => 'Conseil fiscal',
                    'meta_title' => 'Conseil fiscal — MCCG',
                ],
                'audit-controle' => [
                    'title' => 'Audit interne & revue comptable',
                    'short_description' => 'Renforcez la fiabilité de vos processus, de vos comptes et de votre gouvernance.',
                    'content' => 'Nos missions d’audit interne et de revue comptable identifient les risques, améliorent vos processus et éclairent le pilotage de votre entreprise.',
                    'meta_title' => 'Audit interne & revue comptable — MCCG',
                    'meta_description' => 'Renforcez la fiabilité de vos processus, de vos comptes et de votre gouvernance.',
                ],
                'creation-entreprise' => [
                    'title' => 'Conseil juridique et administratif',
                    'short_description' => 'Sécurisez vos décisions et donnez à vos projets le cadre juridique et administratif adapté.',
                    'content' => 'Création d’entreprise, formalités et accompagnement administratif : nous vous conseillons dans la limite des prestations autorisées et mobilisons, lorsque nécessaire, des professionnels habilités.',
                    'meta_title' => 'Conseil juridique et administratif — MCCG',
                    'meta_description' => 'Sécurisez vos décisions et donnez à vos projets le cadre juridique et administratif adapté.',
                ],
            ];

            foreach ($services as $slug => $values) {
                DB::table('services')->where('slug', $slug)->update($values);
            }
        }
    }

    public function down(): void
    {
        // Marketing copy is intentionally not restored to regulated wording.
    }
};
