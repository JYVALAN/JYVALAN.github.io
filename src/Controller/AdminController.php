<?php
namespace Otopix\Controller;

use Otopix\Model\Picture;
use Otopix\Model\Category;
use Otopix\Model\User;
use Otopix\Repository\PictureRepository;
use Otopix\Repository\CategoryRepository;
use Otopix\Repository\UserRepository;

class AdminController extends AbstractController
{
    public function adminPictures()
    {
        // security
        if (!isset($_SESSION['user'])
            || !$_SESSION['user'] instanceof User
            || ($_SESSION['user']->getRole() !== User::ROLE_ADMIN)) {
            // redirection vers la page d'accueil
            $this->redirectAndDie('index.php?page=home');
        }

        // Récupération (+ nettoyage des données POST)
    //     $aCriterias = [];
    //     if (!empty($_POST)) {
    //         $aCriterias = [
    //             'magic-search' => strip_tags($_POST['magic-search']),
    //             'category' => strip_tags($_POST['category']),
    //             'from' => strip_tags($_POST['from']),
    //             'to' => strip_tags($_POST['to']),
    //         ];
    //         // Stockage en session des critères pour la pagination
    //         $_SESSION['files_criterias'] = $aCriterias;
    //     } else {
    //         // On récupère les critères de la dernière recherche
    //         $aCriterias = $_SESSION['files_criterias'] ?? [];
    //     }

    //     $iPage = ($_GET['listing-page'] ?? 1);
    //     $iNbEltsPerPage = PictureRepository::NB_ELTS_PER_PAGE;
    //     $iOffset = ($iPage - 1) * $iNbEltsPerPage;

    //     return $this->render('admin-pictures.php', [
    //         'seo_title' => 'Gestion des images - Espace admin',
    //         'categories' => CategoryRepository::findAll(),
    //         'pictures' => PictureRepository::findBy($aCriterias, $iOffset, $iNbEltsPerPage),
    //         'page' => $iPage,
    //         'nb_results' => PictureRepository::countBy($aCriterias),
    //         'nb_results_per_page' => $iNbEltsPerPage,
    //     ]);
    // }

    // public function adminUsers(): string
    // {
    //     return $this->render('admin-users.php', [
    //         'seo_title' => 'Gestion des utilisateurs - Espace admin',
            
    //     ]);
    // }

    // /**
    //  * Fonction appelée en AJAX
    //  * Objectif : retourner du code HTML partiel
    //  * @return string
    //  * @throws \Exception
    //  */
    // public function refreshUsers(): string
    // {


    //     // (3) Récupération (+ nettoyage des données POST)
    //     $aCriterias = [
    //         'magic-search' => strip_tags($_POST['magic-search']),
    //         'role' => strip_tags($_POST['role']),
    //         'from' => strip_tags($_POST['from']),
    //         'to' => strip_tags($_POST['to']),
    //     ];

    //     // Stockage en session des critères pour la pagination
    //     $_SESSION['users_criterias'] = $aCriterias;

    //     // 1. Calculer l'offset
    //     $iPage = ($_POST['page'] ?? 1);
    //     $iNbEltsPerPage = UserRepository::NB_ELTS_PER_PAGE;
    //     $iOffset = ($iPage - 1) * $iNbEltsPerPage;

    //     $aParams =  [
    //         'users' => UserRepository::findBy($aCriterias, $iOffset, $iNbEltsPerPage),
    //         'page' => $iPage,
    //         'site_page' => PAGE_ADMIN_USERS,
    //         'nb_results' => UserRepository::countBy($aCriterias),
    //         'nb_results_per_page' => $iNbEltsPerPage,
    //     ];

    //     // 2. Récupérer les utilisateurs et renvoyer la vue HTML
    //     return $this->render('_admin-users.php', $aParams, true);
    // }

    // /**
    //  * Fonction appelée en AJAX
    //  * Objectif : retourner du code HTML partiel
    //  * @return string
    //  * @throws \Exception
    //  */
    // public function refreshPictures(): string
    // {


    //     // (3) Récupération (+ nettoyage des données POST)
    //     $aCriterias = [
    //         'magic-search' => strip_tags($_POST['magic-search']),
    //         'category' => strip_tags($_POST['category']),
    //         'from' => strip_tags($_POST['from']),
    //         'to' => strip_tags($_POST['to']),
    //     ];

    //     // Stockage en session des critères pour la pagination
    //     $_SESSION['users_criterias'] = $aCriterias;

    //     // 1. Calculer l'offset
    //     $iPage = ($_POST['page'] ?? 1);
    //     $iNbEltsPerPage = PictureRepository::NB_ELTS_PER_PAGE;
    //     $iOffset = ($iPage - 1) * $iNbEltsPerPage;

    //     $aParams =  [
    //         'articles' => PictureRepository::findBy($aCriterias, $iOffset, $iNbEltsPerPage),
    //         'page' => $iPage,
    //         'site_page' => PAGE_ADMIN_PICTURES,
    //         'nb_results' => PictureRepository::countBy($aCriterias),
    //         'nb_results_per_page' => $iNbEltsPerPage,
    //     ];

    //     // 2. Récupérer les utilisateurs et renvoyer la vue HTML
    //     return $this->render('_admin-pictures.php', $aParams, true);
     }
}