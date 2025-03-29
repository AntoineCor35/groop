<?php

/**
 * Script de post-déploiement pour Groop
 * À exécuter manuellement après le déploiement via FTP
 * 
 * IMPORTANT: 
 * - Ce script nécessite une authentification pour éviter les accès non autorisés
 * - Supprimez ce script après l'avoir exécuté
 */

// Configuration
$auth_token = 'CHANGEZ_CETTE_VALEUR_PAR_UN_TOKEN_SÉCURISÉ'; // ⚠️ Remplacez par un token sécurisé avant utilisation
$token_from_request = $_GET['token'] ?? '';

// Fonction pour afficher les messages de statut
function output($message, $success = true)
{
    echo '<div style="padding: 10px; margin: 5px; border-radius: 5px; background-color: ' . ($success ? '#d4edda' : '#f8d7da') . '; color: ' . ($success ? '#155724' : '#721c24') . ';">';
    echo $message;
    echo '</div>';
}

// Vérification du token
if ($token_from_request !== $auth_token) {
    http_response_code(401);
    output('Accès non autorisé. Token invalide.', false);
    exit;
}

// Afficher l'en-tête
echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post-déploiement Groop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.5;
        }
        h1 {
            color: #3490dc;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 10px;
        }
        pre {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <h1>Configuration post-déploiement Groop</h1>
    <p>Exécution des tâches de post-déploiement...</p>
';

// Fonction pour exécuter une commande artisan et afficher le résultat
function run_artisan_command($command)
{
    $full_command = 'cd ' . dirname(__DIR__) . ' && php artisan ' . $command . ' 2>&1';
    $output = [];
    $return_var = 0;
    exec($full_command, $output, $return_var);

    echo '<h3>php artisan ' . htmlspecialchars($command) . '</h3>';
    echo '<pre>';
    echo implode("\n", array_map('htmlspecialchars', $output));
    echo '</pre>';

    if ($return_var !== 0) {
        output('⚠️ La commande a échoué avec le code ' . $return_var, false);
    } else {
        output('✅ Commande exécutée avec succès');
    }

    return $return_var === 0;
}

// Vérifier la version PHP
echo '<h3>Version PHP</h3>';
echo '<pre>';
echo 'PHP ' . phpversion();
echo '</pre>';

// Exécuter les commandes artisan
$commands = [
    'migrate --force',
    'cache:clear',
    'config:clear',
    'route:clear',
    'view:clear',
    'storage:link --force',
];

$success_count = 0;
foreach ($commands as $command) {
    if (run_artisan_command($command)) {
        $success_count++;
    }
}

// Définir les permissions (plus difficile en PHP, mais on peut essayer)
echo '<h3>Configuration des permissions</h3>';
try {
    // Permissions pour les répertoires de storage
    $storage_paths = [
        dirname(__DIR__) . '/storage',
        dirname(__DIR__) . '/storage/app',
        dirname(__DIR__) . '/storage/framework',
        dirname(__DIR__) . '/storage/logs',
        dirname(__DIR__) . '/bootstrap/cache',
    ];

    foreach ($storage_paths as $path) {
        if (file_exists($path)) {
            chmod($path, 0775);
            output('Permissions appliquées pour ' . $path);
        } else {
            output('Répertoire non trouvé: ' . $path, false);
        }
    }
} catch (Exception $e) {
    output('Erreur lors de la configuration des permissions: ' . $e->getMessage(), false);
}

// Résumé
echo '<h2>Résumé</h2>';
if ($success_count === count($commands)) {
    output('✅ Toutes les commandes ont été exécutées avec succès');
} else {
    output('⚠️ ' . $success_count . ' commandes sur ' . count($commands) . ' ont été exécutées avec succès', false);
}

echo '<p><strong>IMPORTANT</strong>: Pour des raisons de sécurité, <a href="?token=' . htmlspecialchars($token_from_request) . '&delete=1">cliquez ici pour supprimer ce script</a> après utilisation.</p>';

// Auto-suppression du script si demandé
if (isset($_GET['delete']) && $_GET['delete'] == '1') {
    if (unlink(__FILE__)) {
        echo '<script>alert("Le script a été supprimé avec succès.");</script>';
        echo '<meta http-equiv="refresh" content="0;url=/">';
    } else {
        output('⚠️ Impossible de supprimer le script automatiquement. Veuillez le supprimer manuellement.', false);
    }
}

echo '</body></html>';
