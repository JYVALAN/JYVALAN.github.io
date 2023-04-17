<?php
// Fonction prévue par PHP pour récupérer/inclure une classe non trouvée par PHP
/*spl_autoload_register(function (string $sClass) {
    $sFilepath = str_replace(['\\', 'Otopix/'], ['/', 'src/'], $sClass) . '.php';
    if (file_exists($sFilepath)) {
        require_once $sFilepath;
    }
});*/

// Chargement de l'autoload de Composer
require 'vendor/autoload.php';

// On indique à PHP que l'on veut utiliser le concept des "sessions" ($_SESSION)
session_start();

require_once 'config.php';
require_once 'functions.php';

// Préparation de la session (création des données utiles)
if (!isset($_SESSION['id'])) {
    // Création des données basiques de session pour la première fois
    $_SESSION['id'] = uniqid();

    // Tableau permettant des messages pour l'utilisateur (solution persistante)
    $_SESSION['flashes'] = [];
}

/**
 * Composant "Router"
 */
// > Vérifications des erreurs
$sPage = $_GET['page'] ?? PAGE_HOME;
if (!array_key_exists($sPage, ROUTING)) {
    $sPage = PAGE_HOME;
}
// >> Appel dynamique du bon contrôleur (et de la fonction associée)
[$sClass, $sFunction] = explode('::', ROUTING[$sPage]);
echo (new $sClass())->$sFunction();

