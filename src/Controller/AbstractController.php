<?php
namespace Otopix\Controller;

abstract class AbstractController
{
    /**
     * @param string $sUrl
     * @return void
     */
    protected function redirectAndDie(string $sUrl): void
    {
        header('Location: '. $sUrl);
        die;
    }

    /**
     * Génére la vue demandée avec les paramètres donnés
     *
     * @param string $sView
     * @param array  $aParams
     * @param bool   $bAjax
     *
     * @return string
     */
    protected function render(string $sView, array $aParams = [], $bAjax = false): string
    {
        // On génère les variables correspondantes ($h1, $title, etc.)
        extract($aParams);

        // ob_start permet de démarrer un buffer/tampon dans la mémoire de PHP
        // Tous les affichages (echo/include) sont mis en mémoire
        ob_start();
        if ($bAjax) {
            // Mode d'affichage "AJAX" où on inclue/génère uniquement une vue partielle
            include __DIR__.'/../../views/'. $sView;
        } else {
            // Mode d'affichage "classique/web" où on inclue/génère une page HTML complète
            include __DIR__ . '/../../views/base.php';
        }

        /*$sTemplate = __DIR__ . '/../../views/base.php';
        if ($bAjax) {
            $sTemplate = __DIR__.'/../../views/'. $sView;
        }
        include $sTemplate;*/

        // ob_get_clean retourne tout le contenu du buffer et ferme le buffer
        return ob_get_clean();
    }
}
