# Workflow de déploiement pour Groop

Ce répertoire contient les workflows GitHub Actions pour le déploiement automatique de l'application Groop sur Hostinger.

## Méthode de déploiement mise à jour : FTP/SFTP

Le déploiement utilise désormais FTP/SFTP au lieu de SSH car certains hébergeurs comme Hostinger peuvent avoir des restrictions sur l'accès SSH.

### Configuration requise

Pour configurer le déploiement automatique, vous devez définir les secrets suivants dans votre référentiel GitHub :

1. `REMOTE_HOST` : Le nom d'hôte ou l'adresse IP de votre serveur Hostinger
2. `REMOTE_USER` : Le nom d'utilisateur FTP pour votre compte Hostinger
3. `FTP_PASSWORD` : Le mot de passe FTP pour votre compte Hostinger
4. `REMOTE_PATH` : Le chemin absolu vers le répertoire où le site doit être déployé (par exemple `/public_html`)
5. `ENV_PRODUCTION` : Le contenu complet de votre fichier `.env` de production

### Configuration du FTP sur Hostinger

1. Connectez-vous à votre panneau de contrôle Hostinger (hPanel)
2. Accédez à la section "Avancé" > "Gestionnaire FTP" ou équivalent
3. Notez ou créez un compte FTP avec les accès appropriés
4. Assurez-vous que le compte FTP a les permissions suffisantes pour écrire dans le répertoire cible

## Exécution du script post-déploiement

Comme le déploiement FTP ne permet pas d'exécuter des commandes directes sur le serveur, nous avons créé un script post-déploiement qui doit être exécuté manuellement après chaque déploiement.

### Étapes post-déploiement

1. Une fois le déploiement FTP terminé, modifiez le fichier `public/deploy-setup.php` sur le serveur
2. Remplacez la valeur de `$auth_token` par un token sécurisé de votre choix
3. Accédez au script via votre navigateur : `https://votre-site.com/deploy-setup.php?token=VOTRE_TOKEN_SECURISE`
4. Le script exécutera toutes les commandes post-déploiement nécessaires :
    - Migrations de base de données
    - Nettoyage du cache
    - Configuration des permissions
    - Création des liens symboliques
5. Cliquez sur le lien à la fin du script pour supprimer automatiquement ce fichier (par sécurité)

⚠️ **IMPORTANT** : Assurez-vous de supprimer le script `deploy-setup.php` après chaque utilisation pour des raisons de sécurité !

## Résolution des problèmes

Si vous rencontrez des problèmes lors du déploiement, consultez les guides suivants :

-   [Problèmes de version PHP](PHP_VERSION_ISSUE.md) - Pour les incompatibilités de version PHP
-   [Problèmes de build npm](NPM_BUILD_ISSUES.md) - Pour les erreurs lors de la compilation des assets
-   [Problèmes de connexion SSH](SSH_CONNECTION_ISSUES.md) - Pour les erreurs de connexion SSH (si vous utilisez cette méthode)

## Personnalisation du workflow

Vous pouvez personnaliser le workflow dans le fichier `deploy-hostinger.yml` :

-   Modifier le déclencheur (par exemple, déployer uniquement sur certaines branches)
-   Changer les versions de PHP ou Node.js
-   Modifier les fichiers à exclure du déploiement
-   Changer le protocole (FTP, FTPS, SFTP)

## Test manuel du FTP

Pour tester manuellement la connexion FTP :

```bash
# Utiliser un client FTP en ligne de commande
ftp -n $REMOTE_HOST << EOF
user $REMOTE_USER $FTP_PASSWORD
pwd
quit
EOF

# Ou utiliser un client FTP graphique comme FileZilla
```
