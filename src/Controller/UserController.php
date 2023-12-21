<?php

namespace Otopix\Controller;

use Otopix\Manager\UserManager;
use Otopix\Model\User;
use Otopix\Repository\UserRepository;
use Otopix\Service\EmailService;
use Otopix\Repository\PictureRepository;
use Otopix\Repository\CategoryRepository;

class UserController extends AbstractController
{
    /**
     * @return string
     */
    public function login(): string
    {
        // Création du UserManager (nécessaire pour authUser)
        $oUserManager = new UserManager(new EmailService());

        // $aErrors = [];

        // Est-ce que le formulaire de connexion a été soumis ?
        if (isset($_POST['form_login'], $_POST['field_email'], $_POST['field_password'])) {
            $sCleanEmail = strip_tags($_POST['field_email']);
            $sCleanPassword = strip_tags($_POST['field_password']);

            $oUser = $oUserManager->authUser($sCleanEmail, $sCleanPassword);
            if ($oUser instanceof User) {
                // On stocke l'utilisateur connecté en session
                $_SESSION['user'] = $oUser;
                // $_SESSION['flashes'][] = ['success' => 'Bienvenue ' . $oUser->getFirstname()];

                // redirection vers la page 'Mon compte'
                header('Location: index.php?page='. PAGE_MY_ACCOUNT);
                exit;
            } else {
                $_SESSION['flashes'][] = ['danger' => 'Identifiants invalides'];
            }
        }

        // if(strlen($sCleanPassword)<8){
        //     $aErrors[]='Le mot de passe doit contenir au moins 8 caractères';
        // }

        return $this->render('login.php', [
            'categories' => CategoryRepository::findAll(),
         ]);
    }

    /**
     * Gérer la déconnexion
     */
    public function logout(): void
    {
       session_destroy();      // Destruction de la session en cours

        // redirection vers la page 'Accueil'
        $this->redirectAndDie('index.php?page='. PAGE_HOME);
    }

    /**
     * @return string
     */
    public function register(): string
    {
        // Création du UserManager (nécessaire pour hashUserPassword)
        $oUserManager = new UserManager(new EmailService());

        // Est-ce que le formulaire de création de compte a été soumis ?
        if (isset($_POST['form_signup'], $_POST['field_lastname'], $_POST['field_firstname'], $_POST['field_email'], $_POST['field_password'])) { //$_POST['field_user_picture'], $_POST['field_bio']
            // Récupérer (+ nettoyer) les données du formulaire
            $sCleanLastname = strip_tags($_POST['field_lastname']);
            $sCleanFirstname = strip_tags($_POST['field_firstname']);
            $sCleanEmail = strip_tags($_POST['field_email']);
            $sCleanPassword = strip_tags($_POST['field_password']);
            $sCleanUserPicture = strip_tags($_POST['field_user_picture']);
            $sCleanBio = strip_tags($_POST['field_bio']);

            // Check that user doesn't exist yet
            if (!UserRepository::isExist($sCleanEmail)) {
                // Hash the password
                $sHashedPassword = $oUserManager->hashUserPassword($sCleanPassword);
                $oUser = new User($sCleanLastname, $sCleanFirstname, $sCleanEmail, $sHashedPassword);

                // On sauvegarde l'article sous forme d'objet
                UserRepository::save($oUser);
               
                // On stocke l'utilisateur connecté en session
                $_SESSION['user'] = $oUser;
                $_SESSION['flashes'][] = ['success' => 'Bienvenue ' . $oUser->getFirstname()];

                // redirection vers la page 'Mon compte'
                $this->redirectAndDie('index.php?page='. PAGE_MY_ACCOUNT);
                

            } else {
                $_SESSION['flashes'][] = ['danger' => 'Compte déjà existant'];
                //array_push($_SESSION['flashes'], ['danger' => 'Compte déjà existant']);
            }
        }
             return $this->render('signup.php', [
                'categories' => CategoryRepository::findAll(),
             ]);
    }

    /**
     * @return string
     */
    public function account(): string
    {
        // Récupération (+ nettoyage des données POST)
        $aCriterias = [];
        if (!empty($_POST)) {
            $aCriterias = [
                'magic-search' => strip_tags($_POST['magic-search']),
                'category' => strip_tags($_POST['category']),
            ];
            // Stockage en session des critères pour la pagination
            $_SESSION['pictures_criterias'] = $aCriterias;
        } else {
            // On récupère les critères de la dernière recherche
            $aCriterias = $_SESSION['pictures_criterias'] ?? [];
        }

        $iPage = ($_GET['listing-page'] ?? 1);
        $iNbEltsPerPage = PictureRepository::NB_ELTS_PER_PAGE;
        $iOffset = ($iPage - 1) * $iNbEltsPerPage;

        $user = $_SESSION['user'];
        $userId = $user->getId();

        $userpictures = PictureRepository::findByUserPicture($userId);
        $picturecol1 = ceil(count($userpictures)/3);
        $restpictures = count($userpictures) - $picturecol1;
        $picturecol2 = ceil($restpictures/2);
        $picturecol3 = $restpictures - $picturecol2;

        $pictureincol1 = array_slice($userpictures, 0, $picturecol1);
        $pictureincol2 = array_slice($userpictures, $picturecol1, $picturecol2);
        $pictureincol3 = array_slice($userpictures, $picturecol1+$picturecol2, $picturecol3);


        return $this->render('my-account.php', [
            'seo_title' => 'Mon compte',
            'pictureincol1' => $pictureincol1,
            'pictureincol2' => $pictureincol2,
            'pictureincol3' => $pictureincol3,
            'page' => $iPage,
            'nb_results' => PictureRepository::countBy($aCriterias),
            'nb_results_per_page' => $iNbEltsPerPage,
            'categories' => CategoryRepository::findAll(),
        ]);
    }

    // public function showUserPicture()
    // {
    //     $aUserPicture = [];

    //     $user = $_SESSION['user'];
    //     $userId = $user->getId();

    //     $aUserPicture = PictureRepository::findByUserPicture($userId);
        
    //     return $aUserPicture;

    // }

}
