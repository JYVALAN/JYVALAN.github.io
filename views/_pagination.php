<?php $iMaxPage = ceil($nb_results / $nb_results_per_page); ?>

<nav class="pagination">
    <?php if ($page > 1) { ?>
        <a href="?page=<? $_GET['page'] ?>&listing-page=<?= ($page - 1) ?>">
            Précédent
        </a>
    <?php } ?>

    <?php for ($i = 1; $i <= $iMaxPage ; $i++) {
        $bIsActive = ($page == $i);
        ?>
        <a class="<?= ($bIsActive ? 'active' : ''); ?>"
           href="?page=<? $_GET['page'] ?>&listing-page=<?= $i ?>">
            <?= $i ?>
        </a>
    <?php } ?>

    <?php  if ($page < $iMaxPage) { ?>
        <a class="nextItems" href="?page=<? $_GET['page'] ?>&listing-page=<?= ($page + 1) ?>">
            Suivant
        </a>
    <?php } ?>
</nav>
