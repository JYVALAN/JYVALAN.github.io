<?php
use DebugBar\StandardDebugBar;

// Utilisation de la bibliothèque maximebf/debugbar (via doc)
// https://packagist.org/packages/maximebf/debugbar
$oDebugbar = new StandardDebugBar();
$oDebugbarRenderer = $oDebugbar->getJavascriptRenderer('vendor/maximebf/debugbar/src/DebugBar/Resources');

// Exemple
$oDebugbar['messages']->addMessage('hello world!');
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?= $seo_title ?? ''; ?> - Otopix</title>

        <link rel="stylesheet" href="css/style.css">
        <script src="https://kit.fontawesome.com/f2547ac71d.js" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/contact.css">
        <link rel="stylesheet" href="css/import.css">
        <link rel="stylesheet" href="css/login.css">
        <link rel="stylesheet" href="css/signup.css">
        <link rel="stylesheet" href="css/picture.css">


        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        
        <script type="module" defer src="./js/main.js"></script>
        

        <?php echo $oDebugbarRenderer->renderHead(); ?>
	</head>

    <?php if( !isset($_GET['page']) || $_GET['page'] == 'like' || $_GET['page'] == 'mon-compte'){ ?>

        <body class="hiddenfooter">

    <?php } else { ?>
        <body class="toto">

    <?php }?>
	
        <!-- <a href="#" id="showDebug">Afficher les données de "debug"</a>
        <pre id="debug">
            <?php
            print_r($_GET);     // Données contenus dans l'url
            print_r($_POST);    // Données de formulaire
            print_r($_SESSION); // Données de session (PHP)
            print_r($_COOKIE);  // Données de cookies (navigateur)
            ?>
        </pre> -->

    

        <?php include 'header.php';?>
        <div class="layout">
                <?php // Affichage des messages utilisateurs (flash messages)
                foreach ($_SESSION['flashes'] as $iIdx => $aMessages) {
                    foreach ($aMessages as $sType => $sMessage) {
                        echo '<div class="alert alert-' . $sType . '">' . $sMessage . '</div>';
                    }
                    //unset($_SESSION['flashes'][$iIdx]);
                }
                $_SESSION['flashes'] = [];

                if (file_exists('views/'.$sView)) {
                    include $sView;
                }

                echo $oDebugbarRenderer->render();
                ?>
        </div>
        <?php include 'footer.php';?>
	</body>
</html>
