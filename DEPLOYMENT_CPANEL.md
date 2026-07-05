# Déploiement MCCG sur cPanel

## Prérequis

- PHP 8.3 ou supérieur avec `intl`, `mbstring`, `pdo_mysql`, `fileinfo`, `openssl`, `tokenizer`, `xml` et `zip`.
- MySQL 8 ou une version récente de MariaDB.
- Composer 2.
- Le domaine doit pointer vers le dossier Laravel `public`.
- Une tâche cron ou un gestionnaire de processus doit être disponible pour la file d’attente.

## Arborescence recommandée

Pour conserver le code Laravel hors de la racine web, utiliser cette structure :

```text
/home/USERNAME/
├── mccg_backend/              # Dépôt Git Laravel complet
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── public/                # Source des fichiers publics
│   ├── storage/
│   └── vendor/
└── public_html/
    └── mccg/                  # Racine web configurée dans cPanel
        ├── build/             # Assets Vite suivis dans Git
        ├── images/
        ├── index.php
        └── .htaccess
```

Le `git pull` s’exécute dans `/home/USERNAME/mccg_backend`. Le dossier `public/build` est volontairement suivi dans Git afin que les assets compilés soient disponibles même lorsque Node.js n’est pas installé sur cPanel.

Configurer le document root du domaine `www.mc-cg.com` sur `/home/USERNAME/public_html/mccg`. Dans ce cas, `APP_URL` reste `https://www.mc-cg.com` sans suffixe `/mccg`.

## Première mise en ligne

1. Créer la base et l’utilisateur MySQL depuis cPanel, puis leur attribuer les privilèges requis.
2. Copier `.env.example` vers `.env` et configurer `APP_URL`, `DB_*`, SMTP, `CONTACT_NOTIFICATION_EMAIL` et les identifiants administrateur.
3. Utiliser `APP_URL=https://www.mc-cg.com`, `APP_ENV=production` et `APP_DEBUG=false`.
4. Cloner le dépôt dans `/home/USERNAME/mccg_backend`.
5. Exécuter depuis le terminal cPanel :

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan optimize
```

6. Copier le contenu du dossier public vers la racine web :

```bash
cp -a /home/USERNAME/mccg_backend/public/. /home/USERNAME/public_html/mccg/
```

7. Dans `/home/USERNAME/public_html/mccg/index.php`, remplacer les trois chemins relatifs par les chemins absolus du backend :

```php
if (file_exists($maintenance = '/home/USERNAME/mccg_backend/storage/framework/maintenance.php')) {
    require $maintenance;
}

require '/home/USERNAME/mccg_backend/vendor/autoload.php';

$app = require_once '/home/USERNAME/mccg_backend/bootstrap/app.php';
```

Ne jamais copier `.env`, `vendor`, `app`, `config`, `database` ou `storage` dans `public_html/mccg`.

8. Créer le lien public des fichiers téléversés vers le backend :

```bash
ln -s /home/USERNAME/mccg_backend/storage/app/public /home/USERNAME/public_html/mccg/storage
```

Générer `APP_KEY` et exécuter `db:seed` uniquement lors de la première installation. Sur les déploiements suivants, conserver la clé existante et appliquer seulement les nouvelles migrations.

Si Node.js n’est pas disponible sur cPanel, utiliser directement le dossier `public/build` suivi dans Git. Avant chaque commit de mise en production qui modifie CSS ou JavaScript, exécuter localement `npm ci && npm run build` et inclure les nouveaux fichiers compilés dans le commit.

## Déploiements suivants

```bash
cd /home/USERNAME/mccg_backend
git pull
composer install --no-dev --optimize-autoloader
php artisan optimize:clear
php artisan migrate --force
php artisan queue:restart
php artisan optimize
rsync -a --delete --exclude=index.php --exclude=storage public/ /home/USERNAME/public_html/mccg/
```

La synchronisation exclut volontairement le `index.php` public personnalisé et le lien `storage`. Vérifier après le déploiement que `public_html/mccg/storage` pointe toujours vers `mccg_backend/storage/app/public`.

Vérifier que `public_html/mccg/build/manifest.json` correspond au code déployé.

## E-mails et file d’attente

Les deux e-mails du formulaire de contact sont placés dans la file Laravel. La configuration de production doit contenir :

```env
QUEUE_CONNECTION=database
CONTACT_NOTIFICATION_EMAIL=adresse-de-reception@mccg.example
```

La migration Laravel `0001_01_01_000002_create_jobs_table.php` crée déjà les tables `jobs`, `job_batches` et `failed_jobs`. Exécuter `php artisan migrate --force` avant de démarrer le traitement de la file.

### Option recommandée : tâche cron cPanel

Dans cPanel > Cron Jobs, créer une tâche exécutée chaque minute. Adapter `USERNAME`, le chemin PHP et le chemin du projet :

```cron
* * * * * php /home/USERNAME/path-to-project/artisan queue:work --stop-when-empty --tries=3 --timeout=90 >> /dev/null 2>&1
```

La commande minimale demandée par certains hébergeurs est :

```bash
php /home/USERNAME/path-to-project/artisan queue:work --stop-when-empty
```

Chaque exécution traite les travaux disponibles puis s’arrête, ce qui convient aux hébergements sans processus permanent.

### Option alternative : worker permanent

Si cPanel propose Supervisor ou un gestionnaire de processus :

```bash
php artisan queue:work database --tries=3 --timeout=90
```

Après chaque déploiement, demander aux workers permanents de recharger le nouveau code :

```bash
php artisan queue:restart
```

### Travaux échoués

Lister les échecs :

```bash
php artisan queue:failed
```

Relancer tous les travaux échoués après avoir corrigé la cause :

```bash
php artisan queue:retry all
```

Supprimer uniquement les anciens échecs déjà traités :

```bash
php artisan queue:flush
```

Surveiller régulièrement les logs dans `storage/logs` et tester les deux e-mails du formulaire après la mise en ligne.

## Sauvegardes de production

Une sauvegarde exploitable doit contenir les éléments suivants :

1. **Base de données** : exporter la base MySQL depuis cPanel/phpMyAdmin ou avec `mysqldump`.
2. **Fichiers téléversés** : sauvegarder intégralement `storage/app/public`.
3. **Lien public** : `public/storage` est un lien symbolique créé par `php artisan storage:link`; sauvegarder sa cible `storage/app/public`, pas seulement le lien.
4. **Configuration** : conserver une copie chiffrée du fichier `.env` dans un emplacement sécurisé hors du dépôt Git et hors de la racine web.
5. **Code/version** : identifier le commit ou l’archive correspondant à chaque sauvegarde.

Fréquence recommandée :

- Base de données : quotidienne.
- Fichiers téléversés : quotidienne, ou immédiatement après une publication importante.
- Sauvegarde complète : hebdomadaire et avant chaque déploiement.
- Rétention : plusieurs versions quotidiennes et hebdomadaires selon l’espace disponible.

Tester périodiquement une restauration sur un environnement séparé. Une sauvegarde non testée ne garantit pas une reprise fiable.

## Sécurité et exploitation

- Ne jamais versionner `.env` ni une sauvegarde contenant des secrets.
- Conserver `APP_DEBUG=false` en production.
- Utiliser un mot de passe administrateur unique et robuste.
- Donner les droits d’écriture au serveur web uniquement sur `storage` et `bootstrap/cache`.
- Exécuter `php artisan optimize:clear && php artisan optimize` après une modification de configuration.
- Vérifier `/sitemap.xml`, `/robots.txt`, `/admin` et le formulaire de contact après chaque mise en ligne.
- Laisser les URL Casablanca vides tant que l’adresse et les coordonnées ne sont pas confirmées.

Le sitemap est généré dynamiquement : tout article publié ou service actif apparaît automatiquement, sans tâche cron dédiée.
