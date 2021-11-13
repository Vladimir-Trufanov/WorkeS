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
   session_start(); 

   // Подключаем модуль и выодим технологическую информацию
   require_once $_SERVER['DOCUMENT_ROOT'].'/ViewEnviron.php';;
   // Подключаем файлы библиотеки прикладных модулей:
   $TPhpPrown=$SiteHost.'/TPhpPrown';
   require_once $TPhpPrown."/TPhpPrown/CommonPrown.php";
   require_once $TPhpPrown."/TPhpPrown/MakeCookie.php";
   require_once $TPhpPrown."/TPhpPrown/MakeSession.php";
   require_once $TPhpPrown."/TPhpPrown/ViewGlobal.php";
   // Подключаем файлы библиотеки прикладных классов:
   $TPhpTools=$SiteHost.'/TPhpTools';
   //require_once $TPhpTools."/TPhpTools/iniErrMessage.php";
   // Подключаем модули страницы "Подписать фотографию"
   require_once 'SignaPhotoHtml.php';

   // Изменяем счетчики запросов сайта из браузера и, таким образом,       
   // регистрируем новую загрузку страницы
   $c_UserName=prown\MakeCookie('UserName',"Гость",tStr,true);  // логин авторизованного посетителя
   $c_PersName=prown\MakeCookie('PersName',"Гость",tStr,true);  // логин посетителя
   $c_BrowEntry=prown\MakeCookie('BrowEntry',0,tInt,true);      // число запросов сайта из браузера
   $c_BrowEntry=prown\MakeCookie('BrowEntry',$c_BrowEntry+1,tInt);  
   $c_PersEntry=prown\MakeCookie('PersEntry',0,tInt,true);      // счетчик посещений текущим посетителем
   $c_PersEntry=prown\MakeCookie('PersEntry',$c_PersEntry+1,tInt);
   // Изменяем сессионные переменные (сессионные переменные инициируются после
   // переменных-кукисов, так как некоторые переменные-кукисы переопределяются появившимися
   // сессионными переменными. Например: $s_ModeImg --> $c_ModeImg)
   $s_Counter=prown\MakeSession('Counter',0,tInt,true);         // посещения за сессию
   $s_Counter=prown\MakeSession('Counter',$s_Counter+1,tInt);   
   $s_Orient=prown\MakeSession('Orient','landscape',tStr,true); // текущая ориентация устройства
   // Готовим начало страницы для подписывания фотографий
   IniPage($c_SignaPhoto,$UrlHome,$c_FileImg,$c_FileStamp,$c_FileProba);
   // Уточняем ориентацию страницы
   $s_Orient=prown\MakeSession('Orient',MakeOrient($s_Orient,$s_Counter),tStr);
   // Подключаем скрипты по завершению загрузки страницы
   echo '<script>$(document).ready(function() {';
   echo "console.log('window.orientation='+window.orientation);";
   //echo "alert('window.orientation='+window.orientation);";
   echo '});</script>';
   // Начинаем выводить тело страницы 
   echo '</head>';
   echo '<body>';

   //echo '***<br>';
   //echo 'Всем привет!<br>';
   EnviView();
   echo 'Ориентация: '.$s_Orient.'<br>';
   echo "Вы обновили эту страницу ".$_SESSION['Counter']." раз. ";

   //echo '***<br>';

   // Завершаем вывод страницы
   //prown\ViewGlobal(avgSERVER);
   //prown\ViewGlobal(avgCOOKIE);
   prown\ViewGlobal(avgREQUEST);
   echo '</body>';
   echo '</html>';
}
catch (E_EXCEPTION $e) 
{
   DoorTryPage($e);
}
/*   
   
   echo "if (window.orientation===undefined) console.log('window.orientation=UndefineD');";    // 'undefined'
   
   
   ?> <script> 
      let orienti=window.orientation;
      if (orienti===undefined) {<?php $c_Orient=prown\MakeCookie('Orient','landscape1',tStr)?>}
      else if (orienti===180) {<?php $c_Orient=prown\MakeCookie('Orient','portrait180',tStr)?>} 
   </script> <?php

   
   
   

 
      //if ((window.orientation===0)||(window.orientation===180)) {<?php $c_Orient=prown\MakeCookie('Orient','portrait',tStr)?>} 
   
   
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
   
*/
?> <?php // *** <!-- --> *********************************** SignaPhoto.php ***
