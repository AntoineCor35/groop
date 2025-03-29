# Résolution des problèmes de version PHP avec Hostinger

## Problème identifié

Votre projet Laravel requiert PHP 8.2 ou supérieur comme indiqué dans votre `composer.json` :

```json
"require": {
    "php": "^8.2",
    ...
}
```

Cependant, votre serveur Hostinger utilise PHP 8.1.32, ce qui provoque des erreurs lors du déploiement, notamment avec l'installation des dépendances via Composer.

## Solutions possibles

### Option 1: Mettre à jour PHP sur Hostinger (Recommandé)

Hostinger permet généralement de changer la version de PHP utilisée par votre site via leur panneau de contrôle hPanel.

1. Connectez-vous à votre panneau de contrôle Hostinger (hPanel)
2. Accédez à la section "Site web" > "PHP Configuration" ou "Advanced"
3. Dans le sélecteur de version PHP, choisissez PHP 8.2 ou supérieur
4. Sauvegardez les changements
5. Relancez votre déploiement GitHub Actions

Cette solution est recommandée car elle maintient la compatibilité avec les dépendances modernes de votre projet Laravel.

### Option 2: Adapter votre projet pour PHP 8.1

Si vous ne pouvez pas mettre à jour PHP sur Hostinger, vous devrez adapter votre projet pour qu'il soit compatible avec PHP 8.1 :

1. Modifiez votre fichier `composer.json` pour accepter PHP 8.1 :

    ```json
    "require": {
        "php": "^8.1",
        ...
    }
    ```

2. Mettez à jour vos dépendances vers des versions compatibles avec PHP 8.1 :

    ```bash
    composer update --with-dependencies
    ```

3. Il est possible que vous deviez également rétrograder Laravel à une version antérieure à 12, car Laravel 12 requiert PHP 8.2. La version Laravel 11 est compatible avec PHP 8.1 :

    ```json
    "require": {
        "php": "^8.1",
        "laravel/framework": "^11.0",
        ...
    }
    ```

4. Ensuite, exécutez :

    ```bash
    composer update
    ```

5. Réajustez votre code si nécessaire pour être compatible avec les versions antérieures de Laravel et PHP

6. Commitez ces changements et déployez à nouveau

### Option 3: Utiliser un environnement de build personnalisé

Cette approche plus avancée consiste à :

1. Construire votre application avec PHP 8.2 en local ou dans GitHub Actions
2. Transférer uniquement les fichiers compilés vers Hostinger
3. Configurer l'application pour fonctionner en mode production sans nécessiter d'exécuter Composer sur le serveur

Cette approche nécessite de modifier votre workflow GitHub Actions pour créer un package déployable qui est compatible avec PHP 8.1 à l'exécution.

## Recommandation

La mise à jour de PHP sur Hostinger est généralement la solution la plus simple et la plus propre. La rétrogradation de votre projet peut introduire d'autres problèmes de compatibilité et limiter votre capacité à utiliser les fonctionnalités modernes de Laravel.

## Vérification de la version PHP sur Hostinger

Vous pouvez créer un fichier `info.php` avec le contenu suivant et le télécharger sur votre serveur :

```php
<?php phpinfo(); ?>
```

Accédez ensuite à ce fichier dans votre navigateur (par exemple, `https://votresite.com/info.php`) pour voir quelle version de PHP est actuellement installée et toutes les extensions disponibles.

**Important :** N'oubliez pas de supprimer ce fichier après utilisation pour des raisons de sécurité.
