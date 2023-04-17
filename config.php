<?php
// On indique à PHP quelle timezone on utilise
date_default_timezone_set('Europe/Paris');

define('ENV', strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ? 'development' : 'production');

// On masque les erreurs (en production)
if (ENV !== 'development') {
    ini_set('display_errors', false);
}

const DIR_DATABASE = 'database';
const DIR_UPLOADS = 'uploads';

const EMAIL_ADMIN = 'admin@gmail.com';

const DB_HOST = 'localhost';
const DB_NAME = 'otopix';
const DB_USER = 'root';
const DB_PWD = '';

const PAGE_HOME = 'home';
const PAGE_CONTACT = 'contact';
const PAGE_PICTURE = 'picture';
const PAGE_LIKE = 'like';
const PAGE_SIGNUP = 'signup';
const PAGE_LOGIN = 'login';
const PAGE_LOGOUT = 'logout';
const PAGE_MY_ACCOUNT = 'mon-compte';       // page=my-account
const PAGE_IMPORT = 'import';

// Création d'un dictionnaire/tableau associant une fonction de classe à une page
const ROUTING = [
    PAGE_HOME => '\Otopix\Controller\DefaultController::home',
    PAGE_CONTACT => '\Otopix\Controller\DefaultController::contact',
    PAGE_LIKE => '\Otopix\Controller\UserController::like',
    PAGE_PICTURE => '\Otopix\Controller\PictureController::picture',
    PAGE_SIGNUP => '\Otopix\Controller\UserController::register',
    PAGE_LOGIN => '\Otopix\Controller\UserController::login',
    PAGE_LOGOUT => '\Otopix\Controller\UserController::logout',
    PAGE_MY_ACCOUNT => '\Otopix\Controller\UserController::account',
    PAGE_IMPORT => '\Otopix\Controller\PictureController::import',
];
