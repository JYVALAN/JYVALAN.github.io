<main class="containerpicture">

    <h1><?= $picture->getTitle(); ?></h1>
    
    <figure class="figpicture">
        <?php if ($picture->getPicture()) { ?>
            <br >
            <img src="<?= DIR_UPLOADS . DIRECTORY_SEPARATOR . $picture->getPicture(); ?>"
                alt="Illustration" class= "clickedpicture" />
            <br >
        <?php } ?>
        <button class="dow"><a href="?page=<?= PAGE_DOWNLOAD . '&picture=' . $picture->getId(); ?>" ><i class="fa-regular fa-circle-down fa-xl"></i></a></button>

        <button class="fav"><i class="fa-regular fa-heart fa-xl"></i></button>
        <div class="pictureinfo">
            <div class="profiluser">
                <a href=""><img class="imgprofil" src="./mockups/cameraprofil.png" alt=""></a>
                <a class="lienprofil" href=""><p class="authorpicture"> <?= $picture->getUser()->getLastname().' '.$picture->getUser()->getFirstname();?></p></a>
            </div>

            <em class="timepicture"><?= $picture->getCreatedAt()->format('d/m/Y'); ?></em><br />
            <em class="categorypicture">Catégorie: <?= $picture->getCategory()->getName(); ?></em><br />
            <em class="categorypicture">Téléchargements: <?= $picture->getNbDownloads(); ?></em><br />
            
        </div>
        <p class="descriptionpicture">Description: <br> <br><?= $picture->getDescription(); ?></p>
    </figure> 
</main>

