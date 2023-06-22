<?php
    use Otopix\Model\User;
?>

<header class="Header">
    <div class="Header-layout">
        <nav class="Header-nav">
            <a class="Header-nav-logo" href="?">
                <h1>Otopix</h1>
            </a>
            <ul class="Header-nav-link active">
                <a class="Header-nav-link-menu" href="?">Accueil</a>
                <a class="Header-nav-link-menu" href="?page=<?php echo PAGE_CONTACT; ?>">Nous contacter</a>
                <select class="Header-nav-link-menu" name="field_category">
                    <option value="">Catégories</option>
                    <?php
                    
                        foreach ($categories as $oCategory) {
                            $bSelected = ($_SESSION['pictures_criterias']['category'] ?? '') == $oCategory->getId();
                            echo '<option value="'.$oCategory->getId().'" '. ($bSelected ? 'selected="selected"' : ''  ) .' >'.
                                $oCategory->getName() .
                                '</option>';
                        }

                    ?>
                </select>

                <a class="Header-nav-link-menu mobile" href="">Importer</a>
                <a class="Header-nav-link-menu mobile" href="">Favoris</a>

                <select class="Header-nav-link-menu mobile" name="field_legal" id="legal">
                    <option value="propos">A propos de nous</option>
                    <option value="condition">Conditions d'utilisation</option>
                    <option value="politic">Politiques de confidentialité</option>
                    <option value="licence">Licence</option>
                    <option value="mention">Mentions légales</option>  
                </select>
                
            </ul>
            <form action="?page=<? $_GET['page'] ; ?>" method="POST" class="Header-nav-form" >
                <div class="Header-nav-form-wen">
                    <button class="searchbtn"><i class="fa-solid fa-magnifying-glass fa-xs"></i></button>
                    <input class="Header-nav-form-search" type="search" name="magic-search" id="search" value="<?= $_SESSION['pictures_criterias']['magic-search'] ?? '' ; ?>" placeholder=" Rechercher...">
                </div> 
            </form>
                <nav class="Header-nav-menu">
                    <?php if (isset($_SESSION['user']) && $_SESSION['user'] instanceof User) { ?>

                        <a class="Header-nav-menu-link" href="?page=<?php echo PAGE_MY_ACCOUNT; ?>"><i class="fa-solid fa-user"></i> Profil</a>
                        
                        <a class="Header-nav-menu-link" href="?page=<?php echo PAGE_LOGOUT; ?>"><i class="fa-solid fa-arrow-right-from-bracket" style="color: #000000;"></i>Déconnexion</a>
                    <?php } else { ?>

                        <a class="Header-nav-menu-link" href="?page=<?php echo PAGE_LOGIN; ?>"><i class="fa-solid fa-user"></i>Connexion/ <br>Inscription</a>
                    <?php } ?>

                    <?php if(isset($_SESSION['user']) && $_SESSION['user'] instanceof User){ ?>

                        <a class="Header-nav-menu-link desktop" href="?page=<?php echo PAGE_IMPORT; ?>"><i class="fa-solid fa-file-import"></i>Importer</a>
                        <a class="Header-nav-menu-link desktop" href="?page=<?php echo PAGE_LIKE; ?>"><i class="fa-regular fa-heart"></i>Favoris</a>

                    <?php } else { ?>

                        <a class="Header-nav-menu-link desktop" href="?page=<?php echo PAGE_LOGIN; ?>"><i class="fa-solid fa-file-import"></i>Importer</a>
                        <a class="Header-nav-menu-link desktop" href="?page=<?php echo PAGE_LOGIN; ?>"><i class="fa-regular fa-heart"></i>Favoris</a>

                    <?php }?>


                <a href="#" id="burger" class=
                "Header-nav-burger"><i class="fas fa-bars"></i></a>   
            </nav>
        </nav>
        </div>
        
        <?php if(isset($_SESSION['user']) && $_SESSION['user'] instanceof User && array_key_exists('page', $_GET) && $_GET['page'] == 'mon-compte'){ ?>

            <figure class="Header-profil">
                <form action="POST" class="change-user-form">
                    <input type="file" class="change-user-picture" name="form_user_picture" value="user_picture"><img class="Header-profil-img" src="./mockups/cameraprofil.png" name="field_user_picture" alt=""></input>
                </form>
                <div class="Header-profil-info">
                    <h3 class="Header-profil-info-name" ><?= $_SESSION['user']->getLastname(); ?> <?= $_SESSION['user']->getFirstname(); ?></h3>
                    <em class="Header-profil-info-role"><?= $_SESSION['user']->getEmail(); ?></em>
                    <p class="Header-profil-info-bio" name="field_bio"><?= $_SESSION['user']->getBio(); ?>
                    <button name="form_bio" value="bio"><i class="fa-solid fa-pen-to-square" style="color: #000000;"></i></button></p>
                </div>

        <?php } else { ?>

                <figure class="Header-figure">
                    <form action="?page=<? $_GET['page'] ; ?>" class="Header-figure-form" method="POST">
                        <button class="searchbtn"><i class="fa-solid fa-magnifying-glass fa-xs"></i></button>
                        <input class="Header-nav-form-search" value="<?= $_SESSION['pictures_criterias']['magic-search'] ?? '' ; ?>" type="search" name="magic-search" id="search" placeholder="Rechercher une photo...">
                    </form>
                    <p class="Header-figure-author">by Takashi Miyazaki</p>
                </figure>

        <?php }?>
        </figure>

        <?php if(isset($_SESSION['user']) && $_SESSION['user'] instanceof User && array_key_exists('page', $_GET) && $_GET['page'] == 'like'){ ?>

            <div class="Header-none">
            </div>

        <?php } else { ?>

            <!-- <div class="Header-bottom">
                    <form action="popular" class="Header-bottom-form">
                        <select name="field_popular" id="" class="Header-bottom-form-sort">
                            <option value="most_download">Les plus récentes</option>
                            <option value="most_recent">Les plus téléchargées</option>
                        </select>
                    </form>
                </div> -->

        <?php }?>
    
</header>