<?

$filename = __DIR__."/../../../uploads/files/".$_GET["type"]."/".$_GET["file"];

if (file_exists($filename)) {
header($_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
header('Content-Type: ' . $mimetype);
header('Last-Modified: ' . gmdate('r', filemtime($filename)));
header('ETag: ' . sprintf('%x-%x-%x', fileinode($filename), filesize($filename), filemtime($filename)));
header('Content-Length: ' . (filesize($filename)));
header('Connection: close');
header('Content-Disposition: attachment; filename="' . basename($filename) . '";');
// Открываем искомый файл
$f=fopen($filename, 'r');
while(!feof($f)) {
// Читаем килобайтный блок, отдаем его в вывод и сбрасываем в буфер
echo fread($f, 1024);
flush();
}
// Закрываем файл
fclose($f);
} else {
header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
header('Status: 404 Not Found');

}
?>