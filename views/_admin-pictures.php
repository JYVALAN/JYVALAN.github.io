<?php use \Otopix\Model\Article; ?>
<table>
    <thead>
    <tr>
        <th>Date de publication</th>
        <th>Catégorie</th>
        <th>Titre</th>
        <th>Contenu</th>
    </tr>
    </thead>
    <tbody>
    <?php
    /** @var Article $oArticle */
    foreach ($articles as $oArticle) {
        echo '<tr>';
        echo '<td>' . $oArticle->getCreatedAt()->format('d/m/Y H:i') . '</td>';
        echo '<td>' . $oArticle->getCategory()->getName() . '</td>';
        echo '<td>' . $oArticle->getTitle() . '</td>';
        echo '<td>' . mb_substr($oArticle->getContent(), 0, 100) . '</td>';
        echo '</tr>';
    }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="10" class="text-center pagination">
            <?php include '_pagination.php'; ?>
        </td>
    </tr>
    </tfoot>
</table>
