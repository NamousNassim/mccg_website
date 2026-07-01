# Déploiement MCCG sur cPanel

## Prérequis

- PHP 8.3 ou supérieur avec `intl`, `mbstring`, `pdo_mysql`, `fileinfo`, `openssl`, `tokenizer`, `xml` et `zip`
- MySQL 8 / MariaDB récent
- Composer 2
- Le domaine doit pointer vers le dossier `public` de Laravel

## Mise en ligne

1. Créer la base et l’utilisateur MySQL depuis cPanel, puis leur attribuer tous les privilèges.
2. Copier `.env.example` vers `.env` et renseigner `APP_URL`, `DB_*`, les identifiants administrateur et la configuration mail.
   Pour le site MCCG, utiliser `APP_URL=https://www.mc-cg.com`.
   Renseigner également `CONTACT_NOTIFICATION_EMAIL`. Si cette valeur reste vide, MCCG utilise `MAIL_FROM_ADDRESS`.
3. Placer l’application hors de `public_html` si l’hébergement le permet, puis configurer la racine du domaine vers `mccg_website/public`.
4. Exécuter depuis le terminal cPanel :

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## E-mails et file d’attente

Les notifications du formulaire de contact utilisent la file Laravel `database`. Configurez un worker permanent si cPanel fournit un gestionnaire de processus :

```bash
php artisan queue:work database --tries=3 --timeout=90
```

Sur un hébergement sans worker permanent, ajoutez une tâche cron chaque minute en adaptant le chemin du projet :

```cron
* * * * * cd /home/CPANEL_USER/mccg_website && php artisan queue:work database --stop-when-empty --tries=3 --timeout=90 >> /dev/null 2>&1
```

Contrôlez régulièrement les échecs avec `php artisan queue:failed`. Après un déploiement avec un worker permanent, exécutez `php artisan queue:restart`.

Les assets sont déjà produits dans `public/build`. Pour les reconstruire : `npm ci && npm run build` sur une machine disposant de Node.js, puis téléverser le dossier `public/build`.

## Sécurité et exploitation

- Remplacer impérativement `ADMIN_PASSWORD` avant le premier `db:seed`.
- Conserver `APP_DEBUG=false` en production.
- Donner les droits d’écriture au serveur web sur `storage` et `bootstrap/cache`.
- Après chaque déploiement : `php artisan optimize:clear && php artisan optimize`.
- Sauvegarder régulièrement la base MySQL et `storage/app/public`.

Le sitemap est généré à chaque requête sur `/sitemap.xml` : tout nouvel article publié ou service activé y apparaît automatiquement, sans tâche cron.
