<?php

namespace Otopix\Controller;

use Otopix\Manager\UserManager;
use Otopix\Model\User;
use Otopix\Repository\UserRepository;
use Otopix\Service\EmailService;
use Otopix\Repository\PictureRepository;

class UserController extends AbstractController
{
    /**
     * @return string
     */
    public function login(): string
    {
        // Création du UserManager (nécessaire pour authUser)
        $oUserManager = new UserManager(new EmailService());

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

        return $this->render('login.php');
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
                $oUser = new User($sCleanLastname, $sCleanFirstname, $sCleanEmail, $sHashedPassword, $sCleanUserPicture, $sCleanBio);

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
             return $this->render('signup.php');
    }

    /**
     * @return string
     */
    public function account(): string
    {
        $allpictures = PictureRepository::findAll();
        $picturecol1 = ceil(count($allpictures)/3);
        $restpictures = count($allpictures) - $picturecol1;
        $picturecol2 = ceil($restpictures/2);
        $picturecol3 = $restpictures - $picturecol2;

        $pictureincol1 = array_slice($allpictures, 0, $picturecol1);
        $pictureincol2 = array_slice($allpictures, $picturecol1, $picturecol2);
        $pictureincol3 = array_slice($allpictures, $picturecol1+$picturecol2, $picturecol3);

        return $this->render('my-account.php', [
            'seo_title' => 'Mon compte',
            'pictures' => PictureRepository::findAll(),
            'pictureincol1' => $pictureincol1,
            'pictureincol2' => $pictureincol2,
            'pictureincol3' => $pictureincol3,
        ]);
    }

    /**
     * @return string
     */
    public function like(): string
    {
        $allpictures = PictureRepository::findAll();
        $picturecol1 = ceil(count($allpictures)/3);
        $restpictures = count($allpictures) - $picturecol1;
        $picturecol2 = ceil($restpictures/2);
        $picturecol3 = $restpictures - $picturecol2;

        $pictureincol1 = array_slice($allpictures, 0, $picturecol1);
        $pictureincol2 = array_slice($allpictures, $picturecol1, $picturecol2);
        $pictureincol3 = array_slice($allpictures, $picturecol1+$picturecol2, $picturecol3);

        return $this->render('like.php', [
            'seo_title' => 'Favoris',
            'pictures' => PictureRepository::findAll(),
            'pictureincol1' => $pictureincol1,
            'pictureincol2' => $pictureincol2,
            'pictureincol3' => $pictureincol3,
        ]);
    }
}
