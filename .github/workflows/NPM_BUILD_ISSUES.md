# Résolution des problèmes de build npm dans GitHub Actions

## Problème identifié

L'erreur rencontrée lors de l'exécution de `npm run build` dans GitHub Actions était :

```
TypeError: crypto$2.getRandomValues is not a function
```

Cette erreur est liée à Vite qui utilise l'API Web Crypto, mais celle-ci n'est pas disponible par défaut dans certains environnements Node.js, notamment dans GitHub Actions.

## Solutions appliquées

### 1. Mise à jour de Node.js

Le workflow a été mis à jour pour utiliser Node.js 18 au lieu de Node.js 16 :

```yaml
- name: Setup Node.js
  uses: actions/setup-node@v3
  with:
      node-version: "18" # Version plus récente
      cache: "npm"
```

Node.js 18 a un meilleur support pour les API Web modernes, ce qui peut résoudre certains problèmes de compatibilité.

### 2. Désactivation de l'experimental fetch

L'ajout de la variable d'environnement `NODE_OPTIONS` avec `--no-experimental-fetch` peut résoudre les problèmes liés à l'API Fetch et crypto :

```yaml
- name: Build assets
  run: |
      export NODE_OPTIONS=--no-experimental-fetch
      npm run build
  env:
      CI: false
```

### 3. Désactivation du mode CI

L'ajout de `CI: false` indique à la compilation de ne pas traiter les avertissements comme des erreurs, ce qui peut aider dans certains cas :

```yaml
env:
    CI: false
```

## Autres solutions possibles

Si les solutions ci-dessus ne fonctionnent pas, voici d'autres approches à essayer :

### 1. Polyfill pour crypto

Ajouter un polyfill pour crypto dans votre configuration Vite ou webpack. Cela peut être fait en modifiant votre fichier `vite.config.js` :

```js
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            // Ajouter un alias pour crypto si nécessaire
            crypto: require.resolve("crypto-browserify"),
        },
    },
});
```

### 2. Utiliser une version spécifique de Vite

Si le problème persiste, essayez de rétrograder ou de mettre à jour Vite dans votre `package.json` :

```bash
npm install vite@4.3.9 --save-dev
```

### 3. Construction locale et déploiement des assets

Une autre approche consiste à construire les assets localement, puis à les inclure dans le dépôt Git :

1. Exécutez `npm run build` localement
2. Ajoutez le dossier `public/build` à Git
3. Configurez le workflow pour ignorer l'étape de build

## Comment tester les changements

Pour tester si les changements ont résolu le problème, effectuez un push vers votre branche principale et surveillez les logs de GitHub Actions pour voir si l'étape de build se termine avec succès.

## Références

-   [Documentation Vite sur SSR et Node.js](https://vitejs.dev/guide/ssr.html)
-   [GitHub Actions et Node.js](https://docs.github.com/fr/actions/automating-builds-and-tests/building-and-testing-nodejs)
