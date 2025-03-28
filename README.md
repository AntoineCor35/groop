# Groop - Plateforme de mise en relation pour projets étudiants

Groop est une plateforme web innovante qui simplifie la mise en relation entre étudiants autour de projets et valorise la diversité des talents. Notre solution permet aux étudiants de proposer leurs projets, de constituer des équipes pluridisciplinaires et de collaborer efficacement.

![Groop Screenshot](https://via.placeholder.com/800x400?text=Groop+Screenshot) <!-- Remplacez par une capture d'écran réelle -->

## 🚀 Fonctionnalités principales

-   **Proposer un projet** : Déposez vos idées de projets et définissez les compétences recherchées
-   **Rechercher un projet** : Explorez les projets disponibles selon vos intérêts et compétences
-   **Constituer votre équipe** : Sélectionnez les membres en fonction de leurs profils
-   **Collaborer efficacement** : Utilisez nos outils de communication et de gestion de projet
-   **Valoriser votre expérience** : Enrichissez votre portfolio avec vos projets réalisés

## 🔧 Technologies utilisées

-   **Backend** : Laravel 10.x (PHP 8.1+)
-   **Frontend** : Tailwind CSS, Alpine.js
-   **Base de données** : MySQL
-   **Authentification** : Laravel Breeze
-   **Admin Panel** : Laravel Filament

## 📋 Prérequis

-   PHP 8.1 ou supérieur
-   Composer
-   Node.js et NPM
-   MySQL
-   Git

## 💻 Installation

### Cloner le dépôt

```bash
git clone https://github.com/votre-utilisateur/groop.git
cd groop
```

### Installer les dépendances

```bash
# Installer les dépendances PHP
composer install

# Installer les dépendances Node.js
npm install
```

### Configuration de l'environnement

```bash
# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

Modifiez le fichier `.env` avec vos configurations :

```
APP_NAME=Groop
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=groop
DB_USERNAME=root
DB_PASSWORD=
```

### Configurer la base de données

```bash
# Exécuter les migrations et les seeders
php artisan migrate --seed
```

### Compiler les assets

```bash
npm run dev
```

### Démarrer le serveur de développement

```bash
php artisan serve
```

Accédez à [http://localhost:8000](http://localhost:8000) dans votre navigateur.

## 📂 Structure du projet

-   `app/` - Contient les modèles, contrôleurs, middlewares et autres classes PHP
-   `resources/` - Contient les vues, assets CSS/JS et fichiers de traduction
-   `database/` - Contient les migrations et seeders
-   `routes/` - Contient les définitions de routes
-   `config/` - Contient les fichiers de configuration
-   `public/` - Point d'entrée et assets compilés

## 🔄 Déploiement

Le projet est configuré pour un déploiement automatique vers Hostinger via GitHub Actions.

### Configuration du déploiement

Pour configurer le déploiement automatique :

1. Configurez les secrets GitHub dans votre dépôt (voir `.github/workflows/README.md`)
2. Poussez vos modifications sur la branche principale
3. GitHub Actions déploiera automatiquement vers Hostinger

Pour plus de détails sur la configuration du déploiement, consultez [le guide de déploiement](.github/workflows/README.md).

## 🧪 Tests

```bash
# Exécuter les tests unitaires et fonctionnels
php artisan test
```

## 🔒 Authentification

Le projet utilise Laravel Breeze pour l'authentification. Vous pouvez modifier les vues d'authentification dans `resources/views/auth/`.

## 👥 Équipe

-   **Antoine Cormier** - Développeur principal
<!-- Ajoutez les autres membres de l'équipe ici -->

## 📜 Licence

Ce projet est sous licence [MIT](LICENSE).

## 📧 Contact

Pour toute question ou suggestion, veuillez nous contacter à [contact@groop.fr](mailto:contact@groop.fr).
