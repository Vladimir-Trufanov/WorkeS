<?php
// PHP7/HTML5, EDGE/CHROME                               *** SignaPhoto.php ***

// ****************************************************************************
// * SignaPhoto                                              Главный модуль - *
// *                                сайтостраница для подписывания фотографий *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
// v1.10                                             Дата создания:  01.06.2021
// Copyright © 2021 tve                              Посл.изменение: 15.06.2021

// Инициируем рабочее пространство страницы
require_once $_SERVER['DOCUMENT_ROOT'].'/iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();
$SiteRoot   = $_WORKSPACE[wsSiteRoot];    // Корневой каталог сайта
$SiteAbove  = $_WORKSPACE[wsSiteAbove];   // Надсайтовый каталог
$SiteHost   = $_WORKSPACE[wsSiteHost];    // Каталог хостинга
$SiteDevice = $_WORKSPACE[wsSiteDevice];  // 'Computer' | 'Mobile' | 'Tablet'
// Подключаем сайт сбора сообщений об ошибках/исключениях и формирования 
// страницы с выводом сообщений, а также комментариев для PHP5-PHP7
require_once $SiteHost."/TDoorTryer/DoorTryerPage.php";
try 
{
   // Подключаем модуль и выодим технологическую информацию
   require_once $_SERVER['DOCUMENT_ROOT'].'/ViewEnviron.php';;
   // Подключаем файлы библиотеки прикладных модулей:
   $TPhpPrown=$SiteHost.'/TPhpPrown';
   require_once $TPhpPrown."/TPhpPrown/MakeCookie.php";
   require_once $TPhpPrown."/TPhpPrown/ViewGlobal.php";
   // Подключаем файлы библиотеки прикладных классов:
   $TPhpTools=$SiteHost.'/TPhpTools';
   //require_once $TPhpTools."/TPhpTools/iniErrMessage.php";
   // Подключаем модули страницы "Подписать фотографию"
   require_once 'SignaPhotoHtml.php';
   // Готовим начало страницы для подписывания фотографий
   $c_Orient=prown\MakeCookie('Orient','landscape',tStr);
   IniPage($c_SignaPhoto,$UrlHome,$c_FileImg,$c_FileStamp,$c_FileProba);

   //echo '***<br>';
   //echo 'Всем привет!<br>';
   EnviView();
   //echo '***<br>';
   
}
catch (E_EXCEPTION $e) 
{
   DoorTryPage($e);
}
/*
    

   echo '<link rel="stylesheet" type="text/css" href="SignaPhoto.css">';
   // Формируем тексты запросов для вызова страниц (с помощью JS) с портретной 
   // ориентацией и ландшафтной. Так как страница "Подписать фотографию" 
   // использует две разметки: для страницы на компьютере и ландшафтной странице
   // на смартфоне - простая разметка на дивах; а для портретной страницы на 
   // смартфоне с помощью jquery mobile 
   MakeTextPages();
   // При запуске страницы на смартфоне, всегда уточняем ориентацию и 
   // перезагружаем смартфон в случае портретной ориентации
   
*/
   ?> <script>
      if ((window.orientation==0)||(window.orientation==180)) window.location = $SignaPortraitUrl;
   </script> <?php
/*   
   echo '</head>';
   echo '<body>';
   
   // Подключаем скрипты по завершению загрузки страницы
   echo '<script>$(document).ready(function() {';
   //echo 'alert("SignaPhoto");';
   echo '});</script>';
   
   
   
   // Размечаем область изображений
   echo '<div id="All">';
      // Размечаем область оригинального изображения и образца подписи
      echo '<div  id="View">';
      echo '<div  id="Photo">';
      ViewPhoto($c_FileImg);
      echo '</div>';
      echo '<div  id="Stamp">';
      ViewStamp($c_FileStamp);
      echo '</div>';
      echo '</div>';
      // Размечаем область изображения с подписью
      echo '<div  id="Proba">';
      ViewProba($c_FileProba);
      //prown\ViewGlobal(avgCOOKIE);
      echo '</div>';
   echo '</div>';
   
   // Размечаем область управления загрузкой и подписанием
   echo '<div  id="Lead">';
   LoadImg();
   LoadStamp();
   Subscribe();
   Tunein();
   echo '</div>';
*/
/*
   echo '</body>';
   echo '</html>';
   //prown\ViewGlobal(avgSERVER);
   //prown\ViewGlobal(avgCOOKIE);
   
*/
// *** <!-- --> ******************************************** SignaPhoto.php ***
