<?php
use Otopix\Model\User;

// security
if (!isset($_SESSION['user']) || !$_SESSION['user'] instanceof User) {
    // redirection vers la page d'accueil
    header('Location: index.php?page=home');
    exit;
}

?>

<main class="Container">
    <h2 class="Container-h2">Les plus récentes</h2>
    <div class="Container-box">
        <div class="Container-box-imgbox">

            <?php
            // Puis on les parcoure pour les afficher
            /** @var \Otopix\Model\Picture $oPicture */
            
            foreach ($pictureincol1 as $oPicture) {
                echo '<a href="?page='. PAGE_PICTURE .'&picture='. $oPicture->getId() .'">';
                echo '<figure class="Container-box-imgbox-fig">';
                echo '<h3 class="Container-box-imgbox-fig-name">'. $oPicture->getTitle() . '</h3>';
                echo '<img src="'. DIR_UPLOADS . DIRECTORY_SEPARATOR . $oPicture->getPicture() .'" alt="" class="Container-box-imgbox-fig-img">';
                echo '<button class="dow"><i class="fa-regular fa-circle-down fa-xl"></i></button>';
                echo '<button class="fav"><i class="fa-regular fa-heart fa-xl"></i></button>';
                echo '<p class="Container-box-imgbox-fig-author">'. $oPicture->getUser()->getLastname().' '. $oPicture->getUser()->getFirstname() . '</p>';
                echo '</figure>';
                echo '</a>'; 
              
            }

            ?>  

        </div>
        <div class="Container-box-imgbox">
        <?php
            // Puis on les parcoure pour les afficher
            /** @var \Otopix\Model\Picture $oPicture */
            foreach ($pictureincol2 as $oPicture) {
                echo '<a href="?page='. PAGE_PICTURE .'&picture='. $oPicture->getId() .'">';
                echo '<figure class="Container-box-imgbox-fig">';
                echo '<h3 class="Container-box-imgbox-fig-name">'. $oPicture->getTitle() . '</h3>';
                echo '<img src="'. DIR_UPLOADS . DIRECTORY_SEPARATOR . $oPicture->getPicture() .'" alt="" class="Container-box-imgbox-fig-img">';
                echo '<button class="dow"><i class="fa-regular fa-circle-down fa-xl"></i></button>';
                echo '<button class="fav"><i class="fa-regular fa-heart fa-xl"></i></button>';
                echo '<p class="Container-box-imgbox-fig-author">'. $oPicture->getUser()->getLastname().' '. $oPicture->getUser()->getFirstname() . '</p>';
                echo '</figure>';
                echo '</a>'; 
              
            }

            ?>  

        </div>

        <div class="Container-box-imgbox">
        <?php
            // Puis on les parcoure pour les afficher
            /** @var \Otopix\Model\Picture $oPicture */
            foreach ($pictureincol3 as $oPicture) {
                echo '<a href="?page='. PAGE_PICTURE .'&picture='. $oPicture->getId() .'">';
                echo '<figure class="Container-box-imgbox-fig">';
                echo '<h3 class="Container-box-imgbox-fig-name">'. $oPicture->getTitle() . '</h3>';
                echo '<img src="'. DIR_UPLOADS . DIRECTORY_SEPARATOR . $oPicture->getPicture() .'" alt="" class="Container-box-imgbox-fig-img">';
                echo '<button class="dow"><i class="fa-regular fa-circle-down fa-xl"></i></button>';
                echo '<button class="fav"><i class="fa-regular fa-heart fa-xl"></i></button>';
                echo '<p class="Container-box-imgbox-fig-author">'. $oPicture->getUser()->getLastname().' '. $oPicture->getUser()->getFirstname() . '</p>';
                echo '</figure>';
                echo '</a>'; 
              
            }

            ?>  
        </div>
    </div> 
</main>


