<?
//Можно было папариться с локалями, но я забил, т.к. русская локаль для UTF8 трабланута
function getFormatDate($date){

    $day = date_format(date_create($date), 'd');
    $month = date_format(date_create($date), 'm');
    $year = date_format(date_create($date), 'Y');

    $monthArray = array(
        1 => array('Январь', 'Января'),
        2 => array('Февраль', 'Февраля'),
        3 => array('Март', 'Марта'),
        4 => array('Апрель', 'Апреля'),
        5 => array('Май', 'Мая'),
        6 => array('Июнь', 'Июня'),
        7 => array('Июль', 'Июля'),
        8 => array('Август', 'Августа'),
        9 => array('Сентябрь', 'Сентября'),
        10=> array('Октябрь', 'Октября'),
        11=> array('Ноябрь', 'Ноября'),
        12=> array('Декабрь', 'Декабря')
    );

    $month = $monthArray[(int)$month][1];
    return $day." ".$month." ".$year;
}

function getUnFormatDate($date){
    $mas = explode(" ", $date);
    $day = $mas[0];
    $month = $mas[1];
    $year = $mas[2];

    switch ($month) {
        case 'Января':
            $month = 1;
            break;
        case 'Февраля':
            $month = 2;
            break;
        case 'Марта':
            $month = 3;
            break;
        case 'Апреля':
            $month = 4;
            break;
        case 'Мая':
            $month = 5;
            break;
        case 'Июня':
            $month = 6;
            break;
        case 'Июля':
            $month = 7;
            break;
        case 'Августа':
            $month = 8;
            break;
        case 'Сентября':
            $month = 9;
            break;
        case 'Октября':
            $month = 10;
            break;
        case 'Ноября':
            $month = 11;
            break;
        case 'Декабря':
            $month = 12;
            break;
    }
    return $year.".".$month.".".$day;
}

function unicode_conv($originalString) {
    // The four \\\\ in the pattern here are necessary to match \u in the original string
    $replacedString = preg_replace("/\\\\u(\w{4})/", "&#$1;", $originalString);
    $unicodeString = mb_convert_encoding($replacedString, 'UTF-8', 'HTML-ENTITIES');
    return $unicodeString;
}
?>