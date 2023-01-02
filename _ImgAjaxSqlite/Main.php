<?php
// PHP7/HTML5, EDGE/CHROME                                     *** Main.php ***

// ****************************************************************************
// *                               Загрузка изображений с превью AJAX+SQLite! *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.11.2018
// Copyright © 2018 tve                              Посл.изменение: 18.12.2022

// Указываем место размещения библиотеки прикладных функций TPhpPrown
define ("pathPhpPrown",$SiteHost.'/TPhpPrown/TPhpPrown');
// Указываем место размещения библиотеки прикладных классов TPhpTools
define ("pathPhpTools",$SiteHost.'/TPhpTools/TPhpTools');

// Подключаем файлы библиотеки прикладных модулей:
//require_once pathPhpPrown."/ViewGlobal.php";
//require_once pathPhpPrown."/CommonPrown.php";
//require_once pathPhpPrown."/getTranslit.php";

// Подгружаем нужные модули библиотеки прикладных классов
//require_once pathPhpTools."/TArticlesMaker/ArticlesMakerClass.php";
//require_once pathPhpTools."/TKwinGallery/KwinGalleryClass.php";

// Готовим объект для работы с изображениями, где $SiteRoot - корневой каталог 
// сайта, $urlHome - начальная страница сайта
require_once $SiteRoot."/_ImgAjaxSqlite/TImgAjaxSqlite/ImgAjaxSqliteClass.php";
$Imgaj=new ImgAjaxSqlite($urlHome."/_ImgAjaxSqlite/TImgAjaxSqlite");
// При необходимости создаем базу данных для изображений
$imfilename=$Imgaj->imbasename.'.db3';
if (!file_exists($imfilename)) $Imgaj->BaseFirstCreate();
// Подключаемся к базе данных
$impdo=$Imgaj->BaseConnect();

// Начинаем разметку документа
echo '
   <!DOCTYPE html>
   <html lang="ru">
   <head>
   <title>Загрузка изображений с превью AJAX+SQLite</title>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   <meta name="description" content="Труфанов Владимир Евгеньевич, Загрузка изображений с превью AJAX+SQLite">
   <meta name="keywords" content="Труфанов Владимир Евгеньевич,Загрузка, изображения, превью, AJAX+SQLite">
';
// Подключаем шрифты и стили документа
$Imgaj->iniStyles(); 
// Подключаем js скрипты 
?> 
   <script src="/Jsx/jquery-1.11.1.min.js"></script>
<?php
// Подгружаем css для выбора материала 
echo '</head>'; 

echo '<body>'; 

   /*
   echo '<pre>';
   print_r( $_FILES );
   echo '</pre>'; 
   */
   
   // Готовим и отрабатываем форму по загрузке изображений
   $Imgaj->SelImagesSendProcess();

echo '
   </body>
   </html>
';
 
// *** <!-- --> ************************************************** Main.php ***
