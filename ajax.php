<?php

use Otopix\Controller\AdminController;

// Chargement de l'autoload de Composer
require 'vendor/autoload.php';

// On indique à PHP que l'on veut utiliser le concept des "sessions" ($_SESSION)
session_start();

require_once 'config.php';
require_once 'functions.php';

// On utilise un paramètre spécifique pour préciser le contexte d'appel
if (isset($_POST['context'])) {
    switch ($_POST['context']) {
        case PAGE_ADMIN_USERS:
            echo (new AdminController())->refreshUsers();
            break;

        case PAGE_ADMIN_PICTURES:
            echo (new AdminController())->refreshPictures();
            break;
    }
}/* else {
    // 0. Appeler le contrôleur / Renvoyer la vue HTML
    echo (new AdminController())->refreshUsers();
}*/
