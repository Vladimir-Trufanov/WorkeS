<?php
echo '
   <!DOCTYPE html>
   <html lang="ru">
   <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   <title>Сохранение больших файлов а базу данных и показ их в HTML</title>
   </head>
   <body>
';

// Инициируем рабочее пространство страницы
require_once $_SERVER['DOCUMENT_ROOT'].'/iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();
$SiteRoot   = $_WORKSPACE[wsSiteRoot];      // Корневой каталог сайта
$SiteAbove  = $_WORKSPACE[wsSiteAbove];     // Надсайтовый каталог
$SiteHost   = $_WORKSPACE[wsSiteHost];      // Каталог хостинга

// Указываем место размещения библиотеки прикладных функций TPhpPrown
define ("pathPhpPrown",$SiteHost.'/TPhpPrown/TPhpPrown');
// Указываем место размещения библиотеки прикладных классов TPhpTools
define ("pathPhpTools",$SiteHost.'/TPhpTools/TPhpTools');

require_once pathPhpPrown.'/'."CommonPrown.php";
require_once "SQLiteBLOBClass1.php";

echo '<div id="Privet">';
echo 'Привет!<br>';
proba();   
echo '</div>';   
   
echo '
   </body>
   </html>
';

function proba()
{
   // Получаем спецификацию файла базы данных материалов
   $filename='proba.db3';
   // Создается объект PDO и файл базы данных
   $pathBase='sqlite:'.$filename; 
   $username='tve'; $password='23ety17'; 
   // Подключаем PDO к базе
   $pdo = new \PDO(
      $pathBase, 
      $username,
      $password,
      array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
   );
   $sqlite=new ttools\SQLiteBLOB($pdo);
   
   // Включаем действие внешних ключей
   $sql='PRAGMA foreign_keys=on;';
   $st = $pdo->query($sql);
   // Создаем таблицу
   $sql='
      CREATE TABLE IF NOT EXISTS documents 
      (
         document_id INTEGER PRIMARY KEY,
         mime_type   TEXT    NOT NULL,
         doc         BLOB
      )';
   $st = $pdo->query($sql);
      
   // insert a PDF file into the documents table
   $pathToPDFFile = 'Proba.pdf';
   $pdfId = $sqlite->insertDoc('application/pdf', $pathToPDFFile);
   // insert a PNG file into the documents table
   $pathToPNGFile = 'Proba.png';
   $pngId = $sqlite->insertDoc('image/png', $pathToPNGFile);

   prown\Alert('Читаем PDF и PNG из базы данных');

   $documentId=1;
   $doc = $sqlite->readDoc($documentId);
   if ($doc != null) 
   echo '<embed src="data:'.$doc['mime_type'].';base64,'.base64_encode($doc['doc']).'"/>';
   else echo 'Error loading document ' . $documentId;
      
   $documentId=2;
   $doc = $sqlite->readDoc($documentId);
   if ($doc != null) 
   echo '<img src="data:'.$doc['mime_type'].';base64,'.base64_encode($doc['doc']).'"/>';
   else echo 'Error loading document ' . $documentId;

   prown\Alert("Заменяем 'Proba.pdf' на 'Proba.mp3' и показываем");

   $documentId=1;
   $pathToPNGFile = 'Proba.mp3';
   $sqlite->updateDoc($documentId,'audio/mpeg', $pathToPNGFile);

   $doc = $sqlite->readDoc($documentId);
   if ($doc != null) 
   echo '
      <audio controls>
      <source src="data:'.$doc['mime_type'].';base64,'.base64_encode($doc['doc']).'">
      </audio>
   ';
   else echo 'Error loading document ' . $documentId;

   // Показываем VIDEO   
   echo '
   <embed 
      type="video/webm"
      src="Proba.mp4"
      width="250"
      height="200"
   >';
   
   echo '
   <video width="400" height="300" controls="controls" poster="Poster.jpg">
      <source src="Proba.mp4" type="video/webm">
   </video>';
   
   // Показываем AUDIO   
   echo '
   <embed 
      type="audio/mpeg"
      src="Proba.mp3"
      width="500"
      height="200"
   >';

   // Показываем doc   
   echo '
   <embed 
      type="application/msword"
      src="Proba.doc"
      width="500"
      height="200"
   >';
}
