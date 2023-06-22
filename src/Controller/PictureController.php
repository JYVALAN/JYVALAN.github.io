<?php

namespace Otopix\Controller;

use Otopix\Model\Picture;
use Otopix\Repository\CategoryRepository;
use Otopix\Repository\PictureRepository;
use Otopix\Model\Category;
use Otopix\Model\User;
use Otopix\Manager\DbManager;





class PictureController extends AbstractController
{

    /**
     * @return string
     */
    public function import(): string
    {
        // security
        if (!isset($_SESSION['user'])
            || !$_SESSION['user'] instanceof User) {
            // redirection vers la page d'accueil
            $this->redirectAndDie('index.php?page=home');
        }

        // Est-ce que le formulaire de création d'image a été soumis ?
        // if (isset($_POST['form_new_picture'], $_POST['field_category'], $_POST['field_title'], $_POST['field_description'], $_POST['field_picture'])) {
            if(!empty($_POST)){
            // Récupérer (+ nettoyer) les données du formulaire
            $sCleanCategoryId = intval($_POST['field_category']) ;
            $sCleanTitle = strip_tags($_POST['field_title']);
            $sCleanDescription = strip_tags($_POST['field_description']);

            


            // Récupération rapide de notre catégorie via le repository
            $oCategory = CategoryRepository::find($sCleanCategoryId);
            if ($oCategory instanceof Category) {


                $sFilenameNew = "";
                // On regarde si un fichier a été uploadé
                if (isset($_FILES['field_picture'])) {
                    // Contrôle de l'upload
                    if ($_FILES['field_picture']['error'] === UPLOAD_ERR_OK) {
                        $sFilepathTmp = $_FILES['field_picture']['tmp_name']; // D:\Temp\php89F1.tmp

                        $sFilenameNew = uniqid() . '.' . pathinfo($_FILES['field_picture']['name'], PATHINFO_EXTENSION);
                        $sFilepathNew = DIR_UPLOADS . DIRECTORY_SEPARATOR . $sFilenameNew;
                        // uniqid() : permet "d'anonymiser" le nom du fichier
                        // pathinfo() : permet de récupérer des informations sur le fichier (ici l'extension du nom donné par l'utilisateur)
                        // Contrôle de l'image
                        $aPictureInfo = getimagesize($sFilepathTmp); // Array ([0] => 1920, [1] => 1280, ..)
                        if ($aPictureInfo) {
                            // Le fichier est bien une image : on accepte/déplace le fichier
                            if (move_uploaded_file($sFilepathTmp, $sFilepathNew)) {
                                // On associe l'image (nom du fichier) à l'article
                               
                            }
                        }
                    }
                }

                $oPicture = new Picture($sCleanTitle, $sCleanDescription, $oCategory, $sFilenameNew, $_SESSION['user']);
                if (isset($_FILES['field_picture'])) {
                    $oPicture->setPicture($sFilenameNew);
                }
                // On sauvegarde l'article sous forme d'objet
                PictureRepository::save($oPicture);
            }

            // redirection vers la page d'accueil
            $this->redirectAndDie('index.php?page='. PAGE_MY_ACCOUNT);
        }
    

        $oCategories = CategoryRepository::findAll();
        return $this->render('import.php',[
        'seo_title' => 'Importer',
        'categories' => $oCategories,
        ]);


    }


    /**
     * @return string
     */
    public function picture(): string
    {
        // Récupérer la bonne image
        $oPicture = PictureRepository::find($_GET['picture']);
        if (!$oPicture instanceof Picture) {
            $this->redirectAndDie('?page='. PAGE_HOME);
        }

        // Générer la vue
        return $this->render('picture.php', [
            'seo_title' => mb_substr($oPicture->getTitle(), 0 ,25),
            'picture' => $oPicture,
        ]);
    }


    /**
     * @return string
     */
    public function download(): string
    {
           $oPicture = PictureRepository::find($_GET['picture']);

           $sFile = __DIR__ . '/../../uploads/' . $oPicture -> getPicture();


            header('Content-disposition: attachment; filename="' . basename($sFile) . '"');

            $iNewValue = $oPicture->getNbDownloads()+1;
            $oPicture->setNbDownloads($iNewValue);
            PictureRepository::save($oPicture);
            
            return readfile($sFile);
    }


    public function deletepicture()
    {
        $id =  $_GET['pictureId'];
// Valider le paramètre picture

        // security
        if (!isset($_SESSION['user'])
        || !$_SESSION['user'] instanceof User) {
        // redirection vers la page d'accueil
        $this->redirectAndDie('index.php?page=home');
        }
        

        PictureRepository::deletePictureFromAccount($id);
        
        $this->redirectAndDie('?page=my-account');

    }



}


