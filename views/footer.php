<?php
    use Otopix\Model\User;
?>
<!-- <i class="fa-solid fa-circle-info fa-2xl" style="color: #00000a;"></i> -->
<footer class="Footer">
<button class="showfooter">Footer</button>  
    <div class="Footer-topfooter">
        <div class="Footer-topfooter-name">
            <h2 class="Footer-topfooter-name-logo">Otopix</h2>
            <strong class="Footer-topfooter-name-slogan">Vos photos libre de droit</strong> 
        </div>
        <nav class="Footer-topfooter-legal">
            <h4 class="Footer-topfooter-legal-title">Légalité</h4>
            <a class="Footer-topfooter-legal-link">Conditions d'utilisation</a>
            <a class="Footer-topfooter-legal-link">Politiques de confidentialité</a>
            <a class="Footer-topfooter-legal-link">Licence</a>
            <a class="Footer-topfooter-legal-link">Mentions légales</a>
        </nav>
        <nav class="Footer-topfooter-us">
            <h4 class="Footer-topfooter-us-title">Nous</h4>
            <a class="Footer-topfooter-us-link">A propos de nous</a>
            <a class="Footer-topfooter-us-link" href="index.php?page=<?php echo PAGE_CONTACT; ?>">Nous contacter</a>
            <a class="Footer-topfooter-us-link">Conditions</a>
        </nav>

        <nav class="Footer-topfooter-nav">

            <?php if (isset($_SESSION['user']) && $_SESSION['user'] instanceof User) { ?>

                <button class="disconnect"> <a href="?page=<?php echo PAGE_LOGOUT; ?>"> Déconnexion</a></button> 

            <?php } else { ?>
                <button class="signin"> <a href="?page=<?php echo PAGE_SIGNUP; ?>"> S'inscrire</a></button>
                <button class="login"><a href="?page=<?php echo PAGE_LOGIN; ?>"> Connexion</a></button>
            <?php } ?>

  
        </nav>
    </div>

    <div class="Footer-bottomfooter">
        <p>© Otopix 2023</p>
        <div class="social">
            <p>Suivez nous:                 
                <a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-pinterest"></i></a>
            </p>

        </div>

    </div>

</footer>