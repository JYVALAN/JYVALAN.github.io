<?php
    use Otopix\Model\User;
?>

<main class="Container">
    <h2 class="Container-h2">Les images du monde entier</h2>
    <div class="Container-box everyImage">
        <div class="Container-box-imgbox ">

            <?php
            // Puis on les parcoure pour les afficher
            /** @var \Otopix\Model\Picture $oPicture */
            
            foreach ($pictureincol1 as $oPicture) {
                echo '<a href="?page='. PAGE_PICTURE .'&picture='. $oPicture->getId() .'">';
                echo '<figure class="Container-box-imgbox-fig oneItem">';
                echo '<h3 class="Container-box-imgbox-fig-name">'. $oPicture->getTitle() . '</h3>';
                echo '<img src="'. DIR_UPLOADS . DIRECTORY_SEPARATOR . $oPicture->getPicture() .'" alt="" class="Container-box-imgbox-fig-img">';
                echo '<button class="dow"><a href="?page='.PAGE_DOWNLOAD. '&picture='. $oPicture->getId() . '" ><i class="fa-regular fa-circle-down fa-l"></i></a></button>';
                if (isset($_SESSION['user']) && $_SESSION['user'] instanceof User) {
                    if(in_array($oPicture->getId(), $userFavoriteId)){
                        echo '<button class="fav"><i class="fa-solid fa-heart" style="color: #f00505;"></i></button>';

                    }
                    else{
                        echo '<button class="fav"><a href="?page='.PAGE_LIKE. '&pictureId='. $oPicture->getId() . '" ><i class="fa-regular fa-heart fa-l"></i></a></button>';

                    }

                }
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
                echo '<figure class="Container-box-imgbox-fig oneItem">';
                echo '<h3 class="Container-box-imgbox-fig-name">'. $oPicture->getTitle() . '</h3>';
                echo '<img src="'. DIR_UPLOADS . DIRECTORY_SEPARATOR . $oPicture->getPicture() .'" alt="" class="Container-box-imgbox-fig-img">';
                echo '<button class="dow"><a href="?page='.PAGE_DOWNLOAD. '&picture='. $oPicture->getId() . '" ><i class="fa-regular fa-circle-down fa-l"></i></a></button>';
                if (isset($_SESSION['user']) && $_SESSION['user'] instanceof User) {
                    if(in_array($oPicture->getId(), $userFavoriteId)){
                        echo '<button class="fav"><i class="fa-solid fa-heart" style="color: #f00505;"></i></button>';

                    }
                    else{
                        echo '<button class="fav"><a href="?page='.PAGE_LIKE. '&pictureId='. $oPicture->getId() . '" ><i class="fa-regular fa-heart fa-l"></i></a></button>';

                    }

                }                
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
                echo '<figure class="Container-box-imgbox-fig oneItem">';
                echo '<h3 class="Container-box-imgbox-fig-name">'. $oPicture->getTitle() . '</h3>';
                echo '<img src="'. DIR_UPLOADS . DIRECTORY_SEPARATOR . $oPicture->getPicture() .'" alt="" class="Container-box-imgbox-fig-img">';
                echo '<button class="dow"><a href="?page='.PAGE_DOWNLOAD. '&picture='. $oPicture->getId() . '" ><i class="fa-regular fa-circle-down fa-l"></i></a></button>';
                if (isset($_SESSION['user']) && $_SESSION['user'] instanceof User) {
                    if(in_array($oPicture->getId(), $userFavoriteId)){
                        echo '<button class="fav"><i class="fa-solid fa-heart" style="color: #f00505;"></i></button>';

                    }
                    else{
                        echo '<button class="fav"><a href="?page='.PAGE_LIKE. '&pictureId='. $oPicture->getId() . '" ><i class="fa-regular fa-heart fa-l"></i></a></button>';

                    }

                }                
                echo '<p class="Container-box-imgbox-fig-author">'. $oPicture->getUser()->getLastname().' '. $oPicture->getUser()->getFirstname() . '</p>';
                echo '</figure>';
                echo '</a>'; 
              
            }

            ?>  
        </div>
    </div> 
    <?php include '_pagination.php'; ?>
</main>
<script src="https://unpkg.com/@webcreate/infinite-ajax-scroll/dist/infinite-ajax-scroll.min.js"></script>
<script src="./js/infinitscroll.js"></script>

