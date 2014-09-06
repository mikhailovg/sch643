<link rel="stylesheet" href="/css/parts/html.css">
<?
       //Или форма для админа или блок для простого смертного
        $stmt = $db->prepare("SELECT  header, title FROM html WHERE id = ?");
        $stmt->bind_param('i', $idEditOrLoadBlock);
        $stmt->execute();
        $stmt->bind_result($header, $title);
        $stmt -> fetch();
        $stmt -> close();
?>
<div class="other">
<?php
    if (isLoggedIn()) {
?>

        <a href="/html/<?= $idEditOrLoadBlock?>/edit" class="other__editIcon <?= $idEditOrLoadBlock == 4 ? "other__editIconRight" : "other__editIconLeft" ?>"></a>
<?
    }
?>

    <h3 class="other__header"><?= $header ?></h3>
    <?= $title ?>
</div>

