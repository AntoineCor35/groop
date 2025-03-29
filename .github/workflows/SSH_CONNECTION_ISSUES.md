# Résolution des problèmes de connexion SSH avec Hostinger

## Problème identifié

Lors du déploiement via GitHub Actions, l'erreur suivante s'est produite :

```
ssh: connect to host *** port 22: Connection timed out
rsync: connection unexpectedly closed (0 bytes received so far) [sender]
rsync error: unexplained error (code 255) at io.c(232) [sender=3.2.7]
```

Cette erreur indique que l'action GitHub n'a pas pu établir une connexion SSH avec le serveur Hostinger.

## Causes possibles et solutions

### 1. Blocage du port SSH par Hostinger

Hostinger peut bloquer les connexions SSH standard (port 22) pour certains forfaits d'hébergement ou par mesure de sécurité.

**Solution :**

-   Vérifiez que votre forfait Hostinger autorise les connexions SSH
-   Contactez le support Hostinger pour activer l'accès SSH si nécessaire
-   Demandez le port SSH correct à utiliser (parfois ce n'est pas le port 22 standard)

### 2. Mauvaises informations de connexion

Les secrets GitHub configurés peuvent contenir des informations incorrectes.

**Solution :**

-   Vérifiez les secrets GitHub suivants :
    -   `REMOTE_HOST` : Assurez-vous qu'il s'agit du bon hostname ou IP du serveur Hostinger
    -   `REMOTE_USER` : Vérifiez que le nom d'utilisateur est correct
    -   `SSH_PRIVATE_KEY` : Confirmez que la clé privée correspond à la clé publique ajoutée à Hostinger

### 3. Clé SSH mal configurée sur Hostinger

La clé SSH peut ne pas être correctement configurée sur le serveur Hostinger.

**Solution :**

1. Connectez-vous à votre panneau de contrôle Hostinger (hPanel)
2. Accédez à la section "Avancé" > "Gestionnaire SSH" ou équivalent
3. Vérifiez que la clé publique (correspondant à la clé privée dans GitHub) est bien ajoutée
4. Assurez-vous que la clé est activée et n'a pas expiré

### 4. Test manuel de la connexion SSH

Pour vérifier si la connexion SSH fonctionne correctement, faites un test manuel :

1. Sur votre machine locale, créez un fichier temporaire contenant votre clé privée :

    ```bash
    echo "VOTRE_CLE_PRIVEE" > temp_key.pem
    chmod 600 temp_key.pem
    ```

2. Essayez de vous connecter :

    ```bash
    ssh -i temp_key.pem REMOTE_USER@REMOTE_HOST -p 22
    ```

3. Si cela échoue, essayez d'autres ports couramment utilisés pour SSH :
    ```bash
    ssh -i temp_key.pem REMOTE_USER@REMOTE_HOST -p 2222
    ```

### 5. Vérification du pare-feu Hostinger

Hostinger peut avoir des règles de pare-feu qui bloquent les connexions depuis GitHub Actions.

**Solution :**

-   Contactez le support Hostinger pour vérifier si les adresses IP de GitHub Actions sont autorisées
-   Demandez s'il est possible d'ajouter les plages d'IP de GitHub Actions à une liste blanche

### 6. Mise à jour du workflow pour utiliser un port SSH personnalisé

Si Hostinger utilise un port SSH non standard, mettez à jour le workflow GitHub Actions :

```yaml
- name: Deploy to Hostinger
  uses: easingthemes/ssh-deploy@main
  with:
      SSH_PRIVATE_KEY: ${{ secrets.SSH_PRIVATE_KEY }}
      ARGS: "-rltgoDzvO --delete -e 'ssh -p CUSTOM_PORT'"
      SOURCE: "."
      REMOTE_HOST: ${{ secrets.REMOTE_HOST }}
      REMOTE_USER: ${{ secrets.REMOTE_USER }}
      TARGET: ${{ secrets.REMOTE_PATH }}
      EXCLUDE: ".git, .github, .gitignore, .env.example, node_modules, tests, storage/framework/cache/*, storage/logs/*, vendor/bin"
```

Remplacez `CUSTOM_PORT` par le port SSH fourni par Hostinger.

### 7. Utilisation du protocole SFTP au lieu de SSH

Si SSH n'est pas disponible, mais que SFTP l'est, envisagez d'utiliser une action GitHub qui prend en charge SFTP :

```yaml
- name: Deploy via SFTP
  uses: SamKirkland/FTP-Deploy-Action@v4.3.4
  with:
      server: ${{ secrets.REMOTE_HOST }}
      username: ${{ secrets.REMOTE_USER }}
      password: ${{ secrets.SFTP_PASSWORD }}
      protocol: sftp
      port: 22 # ou un port personnalisé
      local-dir: ./
      server-dir: ${{ secrets.REMOTE_PATH }}
      exclude: .git*/** node_modules/** tests/**
```

Cette approche nécessite de configurer un nouveau secret `SFTP_PASSWORD` avec le mot de passe de votre compte Hostinger.

## Contact avec le support Hostinger

Si vous ne parvenez toujours pas à résoudre le problème, contactez le support Hostinger avec les informations suivantes :

1. Mentionnez que vous essayez de configurer un déploiement automatisé via GitHub Actions
2. Demandez la confirmation que l'accès SSH est activé pour votre compte
3. Demandez le port SSH correct à utiliser
4. Vérifiez si des restrictions IP sont en place pour les connexions SSH
5. Demandez des instructions spécifiques pour configurer des clés SSH pour l'automatisation

## Déploiement alternatif

Si le déploiement automatisé via SSH n'est pas possible sur votre forfait Hostinger, envisagez ces alternatives :

1. **Déploiement manuel** : Utilisez un client SFTP comme FileZilla pour télécharger les fichiers
2. **Déploiement FTP** : Configurez un déploiement FTP au lieu de SSH/SFTP
3. **Déploiement via le panneau de contrôle** : Utilisez les outils de déploiement intégrés au panneau de contrôle Hostinger

## Ressources supplémentaires

-   [Documentation Hostinger sur SSH](https://support.hostinger.com/en/articles/4755709-how-to-use-ssh-to-connect-to-your-hosting-account)
-   [Documentation GitHub Actions sur les déploiements](https://docs.github.com/fr/actions/deployment/deploying-to-your-cloud-provider)
-   [Documentation sur ssh-deploy Action](https://github.com/easingthemes/ssh-deploy)
