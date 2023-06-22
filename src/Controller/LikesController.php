<?php
namespace Otopix\Controller;

use Otopix\Manager\DbManager;
use Otopix\Repository\PictureRepository;
use Otopix\Repository\LikesRepository;
use Otopix\Model\Likes;
use Otopix\Model\Picture;
use Otopix\Model\User;
use Otopix\Repository\CategoryRepository;
use Symfony\Component\DependencyInjection\Dumper\Dumper;

class LikesController extends AbstractController
{

    /**
     * @return string
     */
    public function like(): string
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

        if(isset($_SESSION['user']) && $_SESSION['user'] instanceof User){ 

            // $oPdo = DbManager::getInstance();

        //1°) Récupérer les données de la requête : l'id de l'image que tu veux mettre en favoris
            if(isset($_GET['pictureId'])){
                $pictureId = intval($_GET['pictureId']) ;

                $oPicture = PictureRepository::find($pictureId);
                // $userId = $oPicture->getUser()->getId();
                $user = $_SESSION['user'];
                $userId = $user->getId();
                $oLikes = new Likes();
                // dump($userId);
                $oLikes -> setUserId($userId);
                $oLikes -> setPictureId($pictureId);
                LikesRepository::save($oLikes);
                
                $this->redirectAndDie('?page=like');
            }

        //2°) Enregistrer le favori en appelant la méthode save() du repository
            $user = $_SESSION['user'];
            $userId = $user->getId();
           
            
            // dump($user);

            $iPage = ($_GET['listing-page'] ?? 1);
            $iNbEltsPerPage = PictureRepository::NB_ELTS_PER_PAGE;
            $iOffset = ($iPage - 1) * $iNbEltsPerPage;

            $favpictures = $favpictures = PictureRepository::findByUserLikes($userId, $aCriterias, $iOffset, $iNbEltsPerPage);
            $picturecol1 = ceil(count($favpictures)/3);
            $restpictures = count($favpictures) - $picturecol1;
            $picturecol2 = ceil($restpictures/2);
            $picturecol3 = $restpictures - $picturecol2;

            $pictureincol1 = array_slice($favpictures, 0, $picturecol1);
            $pictureincol2 = array_slice($favpictures, $picturecol1, $picturecol2);
            $pictureincol3 = array_slice($favpictures, $picturecol1+$picturecol2, $picturecol3);

        }

        return $this->render('like.php', [
            'seo_title' => 'Favoris',
            'pictureincol1' => $pictureincol1,
            'pictureincol2' => $pictureincol2,
            'pictureincol3' => $pictureincol3,
            'page' => $iPage,
            'nb_results' => PictureRepository::countBy($aCriterias),
            'nb_results_per_page' => $iNbEltsPerPage,
            'categories' => CategoryRepository::findAll(),
        ]);
    }


    public function deletelike()
    {
        $user = $_SESSION['user'];
        $userId = $user->getId();

        $pictureId = intval($_GET['pictureId']) ;

        LikesRepository::deleteLike($userId, $pictureId);
        
        $this->redirectAndDie('?page=like');
    }
}