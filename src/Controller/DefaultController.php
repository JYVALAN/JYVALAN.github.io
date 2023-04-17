<?php
namespace Otopix\Controller;

use Otopix\Repository\PictureRepository;
use Otopix\Manager\DbManager;


//nb total de photo/3 = nb photo colonne 1 arrondi au superieur
//nb total - nb photo colonne 1 arrondi au superieur = nb photo restante
//nb photo restante / 2 = nb photo colonne 2 arrondi au superieur
//nb photo restante - nb photo colonne 2 arrondi au superieur = nb de photo derniere colonne


class DefaultController extends AbstractController
{

    

    /**
     * @return string
     */
    public function home(): string
    {
        $allpictures = PictureRepository::findAll();
        $picturecol1 = ceil(count($allpictures)/3);
        $restpictures = count($allpictures) - $picturecol1;
        $picturecol2 = ceil($restpictures/2);
        $picturecol3 = $restpictures - $picturecol2;

        $pictureincol1 = array_slice($allpictures, 0, $picturecol1);
        $pictureincol2 = array_slice($allpictures, $picturecol1, $picturecol2);
        $pictureincol3 = array_slice($allpictures, $picturecol1+$picturecol2, $picturecol3);

        return $this->render('home.php', [
            'seo_title' => 'Accueil',
            'pictures' => PictureRepository::findAll(),
            'pictureincol1' => $pictureincol1,
            'pictureincol2' => $pictureincol2,
            'pictureincol3' => $pictureincol3,
        ]);
    }

    /**
     * @return string
     */
    public function contact(): string
    {
        // Est-ce que le formulaire de contact a été soumis ?
        if (isset($_POST['form_contact']) 
            && isset($_POST['field_author']) 
            && isset($_POST['field_email'])
            && isset($_POST['field_subject'])
            && isset($_POST['field_content'])) {
            // Récupérer (+ nettoyer) les données du formulaire
            $sCleanAuthor = strip_tags($_POST['field_author']);
            $sCleanEmail = strip_tags($_POST['field_email']);
            $sCleanSubject = strip_tags($_POST['field_subject']);
            $sCleanContent = strip_tags($_POST['field_content']);
            sendMail(EMAIL_ADMIN, $sCleanAuthor, $sCleanEmail, $sCleanSubject, $sCleanContent);
        }

        return $this->render('contact.php', [
            'seo_title' => 'Me contacter',
        ]);
    }


}
