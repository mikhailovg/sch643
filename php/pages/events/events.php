<?php
    include_once("../../support/connectBD.php");
    require_once("../../shared/auth.php");
    $page_title = "Календарь событий Сето";
    include_once("../../parts/header.php");
    include_once("../../support/dateFormat.php");
?>
<link href="/css/pages/events/events.css" rel="stylesheet" >
<link href="/css/parts/template.css" rel="stylesheet" >
<script src="/js/pages/events/events.js"></script>

<div class="template__columns">
    <div class="template__left-column">
        <div class="events">
<?php
                    if(isLoggedIn()){
?>
            <a class="events__add-event-icon" href="/event/new"></a>
<?
                    }
?>
            <h3 class="events__label">Последние события</h3>
            <table class="events__table">
                <thead>
                    <tr>
                        <th class="events__date-column">Дата</th>
                        <th class="events__name-column">Название</th>
                        <th class="events__description-column">Описание</th>
                    </tr>
                </thead>
<?php
                $queryForBlock = "SELECT date_start, date_finish, title, description, info, id  FROM event ORDER BY date_start DESC";
                $stmt = $db->prepare($queryForBlock);
                $stmt->execute();
                $stmt->bind_result($dateStartBlock, $dateFinishBlock, $titleBlock, $descriptionBlock, $infoBlock, $idEvent);

                while($stmt->fetch()){

                if($dateStartBlock == $dateFinishBlock) {
                    $dateFinishBlock = "";
                }
                else{
                    $dateFinishUnix = date_format(date_create($dateFinishBlock), 'U');
                    $dateFinishBlock = getFormatDate($dateFinishBlock);

                }
                    $dateStartUnix = date_format(date_create($dateStartBlock), 'U');
                    $dateStartBlock = getFormatDate($dateStartBlock);

                $colorTitle = '#E20103';

                 if($dateFinishBlock != ""){
                     $dateBlock = "C ".$dateStartBlock. "<br> По ".$dateFinishBlock;
                     if($dateFinishUnix < time()){
                        $colorTitle = 'grey';
                     }

                 }  else {
                     $dateBlock = $dateStartBlock;
                     if($dateStartUnix < time()){
                         $colorTitle = 'grey';
                     }
                 }
?>
                <tbody class="events__event events__event--past">
                    <tr>
                        <td class="events__date-column">
<?php
                    if(isLoggedIn()){
?>
                            <a class="events__edit-event-icon" href="/event/<?php echo $idEvent?>/edit"></a>
                            <span class="events__delete-event-icon"></span>
<?
                    }
?>
                            <input type="hidden" class="events__idEvent" value="<?echo $idEvent?>">
                            <?php echo $dateBlock ?>
                        </td>
                        <td class="events__name-column" style="color: <?php echo $colorTitle?>;">
                            <?php echo $titleBlock ?>
                        </td>
                        <td class="events__description-column">
                            <?php echo $descriptionBlock ?>
                        </td>
                    </tr>
                    <tr class="events__info-row  events__info-row--collapsed">
                        <td class="events__info-cell" colspan="3">
                            <?php echo $infoBlock ?>
                        </td>
                    </tr>
                </tbody>
<?php
                }
?>
            </table>
        </div>

        <div id="events__comments" class="events__comments"></div>

    </div>
    <div class="template__right-column">
            <?
            $idEditOrLoadBlock = 4;
            include ('../../parts/html.php');
            ?>
    </div>
</div>
<?php
                    if(isLoggedIn()){
?>
    <div id="events__deleteDialog" title="Удаление события" style="display: none">
        <form id = "events__deleteDialogForm" action = "/event/delete" enctype="application/x-www-form-urlencoded" method="POST">
            <input type="hidden" id="events__deleteDialogIdEvent" name = "id" value="">
        </form>
        <p id="events__deleteDialogMessage">Вы уверены, что хотите удалить событие?</p>
    </div>
<?
                    }
?>

<?php include_once("../../parts/footer.php"); ?>
