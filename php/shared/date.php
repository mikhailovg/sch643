<?
/**
 * Парсит дату в виде строки и возвращает юниксовое количество милисекнд.
 * @param $date string Строковое значение даты, взятое, например из БД.
 * @return int Количество милисекунд прошедших с начала времен, бла, бла, бла.
 */
function milliseconds($date) {
    return strtotime($date)*1000;
}

/**
 * Форматирует дату в виде на подобии "1 января 2014", где месяц строкой.
 * @param $date string Значение даты, что надо отформатировать.
 * @return string отформатированная дата
 */
function format_date_with_month_name($date) {
    $timestamp = strtotime($date);
    $date = getdate($timestamp);
    $months_names = array("января", "февраля", "марта", "арпеля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
    return "".$date["mday"]." ".$months_names[$date["mon"] - 1]." ".$date["year"];
}