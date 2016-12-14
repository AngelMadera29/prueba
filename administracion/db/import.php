<?php
$dir = 'bbdd.sqlite'; 
$dir2 = 'registros.sqlite';
$dir3 = 'imagenes';
$dir4 = 'empresas';

$now = gmdate('d-m-y', time() - 3600 * 5);

$archive = $now.'download.zip';

$zip = new ZipArchive;
$zip->open($archive, ZipArchive::CREATE);

$files = scandir($dir3);
unset($files[0], $files[1]);
foreach ($files as $file) {
$zip->addFile($dir3.'/'.$file);
}
$files_1 = scandir($dir4);
unset($files_1[0], $files_1[1]);
foreach ($files_1 as $file_1) {
$zip->addFile($dir4.'/'.$file_1);
}


$zip->addFile($dir);
$zip->addFile($dir2);


$zip->close();

header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$archive);
header('Content-Length: '.filesize($archive));
readfile($archive);
unlink($archive);
?>
