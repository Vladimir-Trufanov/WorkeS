<?php
// PHP7/HTML5, EDGE/CHROME                               *** SignaPhoto.php ***

// ****************************************************************************
// * SignaPhoto                                              Главный модуль - *
// *                                сайтостраница для подписывания фотографий *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
// v4.01                                             Дата создания:  01.06.2021
// Copyright © 2021 tve                              Посл.изменение: 15.01.2022

// Инициируем рабочее пространство страницы
require_once $_SERVER['DOCUMENT_ROOT'].'/iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();
$SiteRoot   = $_WORKSPACE[wsSiteRoot];    // Корневой каталог сайта
$SiteAbove  = $_WORKSPACE[wsSiteAbove];   // Надсайтовый каталог
$SiteHost   = $_WORKSPACE[wsSiteHost];    // Каталог хостинга
$SiteDevice = $_WORKSPACE[wsSiteDevice];  // 'Computer' | 'Mobile' | 'Tablet'
$RemoteAddr = $_WORKSPACE[wsRemoteAddr];  // IP-адрес запроса сайта

// Подключаем сайт сбора сообщений об ошибках/исключениях и формирования 
// страницы с выводом сообщений, а также комментариев для PHP5-PHP7
require_once $SiteHost."/TDoorTryer/DoorTryerPage.php";
try 
{
   session_start();
   
   // Подключаем модуль и выводим технологическую информацию
   require_once $_SERVER['DOCUMENT_ROOT'].'/ViewEnviron.php';
   
   // Указываем место размещения библиотеки прикладных функций TPhpPrown
   define ("pathPhpPrown",$SiteHost.'/TPhpPrown/TPhpPrown');
   // Указываем место размещения библиотеки прикладных классов TPhpTools
   define ("pathPhpTools",$SiteHost.'/TPhpTools/TPhpTools');
   // Подключаем файлы библиотеки прикладных модулей:
   require_once pathPhpPrown."/CommonPrown.php";
   require_once pathPhpPrown."/MakeCookie.php";
   require_once pathPhpPrown."/MakeSession.php";
   require_once pathPhpPrown."/ViewGlobal.php";
   // Подключаем файлы библиотеки прикладных классов:
   require_once pathPhpTools."/iniToolsMessage.php";
   require_once pathPhpTools."/TDeviceOrientater/DeviceOrientaterClass.php";

   // Подключаем модули страницы "Подписать фотографию"
   //require_once 'SignaPhotoHtml.php';

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
   //$s_Orient=prown\MakeSession('Orient','landscape',tStr,true); // текущая ориентация устройства

   // Готовим начало страницы для подписывания фотографий
   IniPage($c_SignaPhoto,$UrlHome,$c_FileImg,$c_FileStamp,$c_FileProba);

   // Создаем объект класса по контролю за положением устройства
   $orient = new ttools\DeviceOrientater();
   // Проверяем, что ориентационные константы появились в PHP/JS
   prown\ConsoleLog('oriLandscape в PHP='.oriLandscape);
   prown\ConsoleLog('oriPortrait в PHP='.oriPortrait);
   echo
      '<script>'.
      "console.log('oriLandscape='+oriLandscape);".
      "console.log('oriPortrait='+oriPortrait);".      
      "console.log('Orient='+Orient);".
      "alert('OrientDevice='+Orient)".
      '</script>';
   
   // Уточняем ориентацию страницы
   // $s_Orient=prown\MakeSession('Orient',MakeOrient($s_Orient),tStr);
   // Подгоняем размеры изображений (здесь устранить бликование)
   //echo '<script> PlaceImgOnDiv(); </script>';
   // Подключаем скрипты по завершению загрузки страницы
   echo 
   '<script>$(document).ready(function() {
      //console.log("window.orientation="+window.orientation);
      //alert("window.orientation="+window.orientation);
      // Размещаем изображения внутри Div-ов
   });</script>';
   // Начинаем выводить тело страницы 
   echo '</head>';
   echo '<body>';
   
   /*
   echo '<pre>';
   //echo prown\listBrowscap();
   echo '***'.prown\MakeRID().'***<br>';
   echo "</pre>";
   */
   // Выводим отладочную информацию
   // DebugView($s_Orient);
   // Запускаем построение разметки
   //if ($s_Orient=='landscape') MarkupLandscape($c_FileImg,$c_FileStamp,$c_FileProba,$RemoteAddr);
   //else MarkupPortrait($c_FileImg,$c_FileStamp,$c_FileProba,$RemoteAddr);
   
   MarkupLandscape($c_FileImg,$c_FileStamp,$c_FileProba,$RemoteAddr);
   /*
   // Размещаем плавающий фрэйм сообщений при загрузке изображения
   echo 
    '<iframe id="alfFrame" name="alfFrame" align="left">'.
    'Ваш браузер не поддерживает плавающие фреймы!'.
    '</iframe>';
   */


/* отладка 03,01,2022
   define ("pathPhpPrown",$SiteHost.'/TPhpPrown/TPhpPrown'); 
   define ("pathPhpTools",$SiteHost.'/TPhpTools/TPhpTools'); 
   require_once pathPhpTools."/iniToolsMessage.php";
   require_once pathPhpTools."/TUploadToServer/UploadToServerClass.php";
   $imgDir=$_SERVER['DOCUMENT_ROOT'].'/Temp'; 
   $upload=new ttools\UploadToServer($imgDir);
   prown\ConsoleLog('1 $MessUpload=$upload->move()');
   $MessUpload=$upload->move();
   prown\ConsoleLog('2 $MessUpload=$upload->move()');
   prown\ConsoleLog('$MessUpload='.$MessUpload);
*/

 
  
   
   // Завершаем вывод страницы
   echo '</body>';
   echo '</html>';
}
catch (E_EXCEPTION $e) 
{
   DoorTryPage($e);
}
// ****************************************************************************
// *                    Разметить страницу в варианте Portrait                *
// ****************************************************************************
function MarkupPortrait($c_FileImg,$c_FileStamp,$c_FileProba,$RemoteAddr)
{
   echo 'Привет Portrait!<br>';
}
// ****************************************************************************
// *                    Разметить страницу в варианте LandScape               *
// ****************************************************************************
function MarkupLandscape($c_FileImg,$c_FileStamp,$c_FileProba,$RemoteAddr)
{
   echo 'Привет!<br>';
   prown\ViewGlobal(avgCOOKIE);

/*
   // Размечаем область изображений
   echo '<div id="All">';
      // Размечаем область оригинального изображения и образца подписи
      echo '<div  id="View">';
         // Оригинал
         echo '<div  id="Photo">';
         ViewPhoto($c_FileImg);
         echo '</div>';
         // Подпись
         echo '<div  id="Stamp">';
         ViewStamp($c_FileStamp);
         echo '</div>';
      echo '</div>';
      // Размечаем область изображения с подписью
      echo '<div  id="Proba">';
         ViewProba($c_FileProba,$RemoteAddr);
      echo '</div>';
   echo '</div>';
   
   // Размечаем область управления загрузкой и подписанием
   echo '<div  id="Lead">';
      LoadImg();
      Subscribe();
      Tunein();
      LoadStamp();

      
      // Делаем кнопку для отладки js-функций
      echo '<button id="bQuest" title="Вопрос?" onclick="PlaceImgOnDiv()">Вопросик?</button>';
      // Закладываем в разметку див для сообщений через диалоговое окно
      echo '<div id="'.ohInfo.'">';
      echo '***<br>';
      echo 'Привет info!<br>';
      echo '***<br>';
      echo '</div>';
      
   echo '</div>';
   */
}

/*
// Выполнить разметку мобильных подстраниц "Подписать фотографию"
function markupPortraitMobile($c_SignaPhoto,$UrlHome,$SiteRoot,$c_FileImg,$c_FileStamp,$c_FileProba)
{
   // Начинаем 1 страницу
   echo '<div data-role = "page" id = "page1">';
   // Выводим заголовок 1 страницы с двумя кнопками навигации
   echo '
      <div data-role = "header">
         <div data-role="controlgroup" data-type="horizontal"> 
            <div id="bTasks" class="dibtn">
               <a href="'.$UrlHome.'"><i class="fa fa-tasks fa-lg" aria-hidden="true"> </i></a>
            </div>
            <div id="c1Title"> <h1>'.'Подготовка фото для подписания'.'</h1></div>
            <div id="bHandoright" class="dibtn">
               <a href="#page2"><i class="fa fa-hand-o-right fa-lg" aria-hidden="true"> </i></a>
            </div>
         </div>
      </div>
   ';
   // Выводим контент: фотографию и штамп   
   echo '<div role="main" class="ui-content" id="cCenter">';
   echo '<div id="Photo">';
      ViewPhoto($c_FileImg);
   echo '</div>';
   echo '<div id="Stamp">';
      ViewStamp($c_FileStamp);
   echo '</div>';
   echo '</div>  ';
   // Выводим подвал с кнопками обработкт фотографий
   // https://habr.com/ru/post/245689/
   echo '<div data-role = "footer">';
   LoadImg();
   LoadStamp();
   Register();
   Indoor();
   // Заготавливаем скрытый фрэйм для обработки загружаемого изображения 
   // (25.06.2021 убираем из кода для осмысления. Делаем по другому)
   // echo '<iframe id="rFrame" name="rFrame" style="display: none"> </iframe>';
   // Завершаем подвал
   echo '</div>';
   // Завершаем 1 страницу 
   echo '</div>'; 
   
   // Начинаем 2 страницу
   echo '
   <div data-role = "page" id = "page2">
   ';
   // Выводим кнопки управления и заголовок
   echo '
      <div data-role = "header">
         <div data-role="controlgroup" data-type="horizontal"> 
         <div id="bTasks" class="dibtn">
            <a href="#page1"><i class="fa fa-hand-o-left fa-lg" aria-hidden="true"> </i></a>
         </div>
         <div id="c2Title"> <h1>Подписанная фотография</h1></div>
         <div id="bHandoright" class="dibtn">
            <a href="'.$UrlHome.'"><i class="fa fa-sign-out fa-lg" aria-hidden="true"> </i></a>
         </div>
         </div>
      </div>
   ';
   // Размечаем область изображения с подписью
   echo '<div role="main" class="ui-content" id="exPhp">';
   echo '<div  id="Proba">';
   ViewProba($c_FileProba);
   //prown\ViewGlobal(avgCOOKIE);
   echo '</div>';
   echo '</div>';
   // Размечаем подвал с двумя кнопками действий
   echo '<div data-role = "footer">';
   Subscribe();
   Tunein();
   echo '</div>';
   // Завершаем 2 страницу 
   echo '</div>'; 
}
   
*/

// ****************************************************************************
// *                            Начать HTML-страницу сайта                    *
// ****************************************************************************
function IniPage(&$c_SignaPhoto,&$UrlHome,&$c_FileImg,&$c_FileStamp,&$c_FileProba)
{
   $Result=true;
   // Инициируем или изменяем счетчик числа запросов страницы
   $c_SignaPhoto=prown\MakeCookie('SignaPhoto',0,tInt,true);  
   $c_SignaPhoto=prown\MakeCookie('SignaPhoto',$c_SignaPhoto+1,tInt);  
   $c_FileImg=prown\MakeCookie('FileImg','images/iphoto.jpg',tStr,true);
   $c_FileStamp=prown\MakeCookie('FileStamp','images/istamp.png',tStr,true);
   $c_FileProba=prown\MakeCookie('FileProba','images/iproba.png',tStr,true);
   // Определяем Url домашней страницы
   if ($_SERVER["SERVER_NAME"]=='kwinflatht.nichost.ru') $UrlHome='http://kwinflatht.nichost.ru';
   else $UrlHome='http://localhost:82'; 
   // Формируем тексты запросов для вызова страниц (с помощью JS) с портретной 
   // ориентацией и ландшафтной. Так как страница "Подписать фотографию" 
   // использует две разметки: для страницы на компьютере и ландшафтной странице
   // на смартфоне - простая разметка на дивах; а для портретной страницы на 
   // смартфоне с помощью jquery mobile 
   //MakeTextPages();
   // Загружаем заголовочную часть страницы
   echo '<!DOCTYPE html>';
   echo '<html lang="ru">';
   echo '<head>';
   echo '<meta http-equiv="content-type" content="text/html; charset=utf-8"/>';
   echo '<title>Подписать фотографию: _SignaPhoto1</title>';
   echo '<meta name="description" content="_SignaPhoto1">';
   echo '<meta name="keywords"    content="_SignaPhoto1">';
   // Подключаем jquery/jquery-ui
   echo '
      <link rel="stylesheet" href="/Jsx/jqueryui-1.13.0.min.css"/> 
      <script src="/Jsx/jquery-1.11.1.min.js"></script>
      <script src="/Jsx/jqueryui-1.13.0.min.js"></script>
   ';
   // Подключаем font-awesome
   echo '<link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">';
   // Подключаем скрипт изменения заголовка "input file"
   // echo '<script src="/Jsx/jquery-input-file-text.js"></script>';
   //
   echo '<link rel="stylesheet" type="text/css" href="SignaPhoto.css">';
   // Подключаем межязыковые (PHP-JScript) определения внутри HTML
   require_once 'SignaPhotoDef.php';
   echo $define; echo $odefine;
   // Подключаем сайтовые(SignaPhoto) функции Js и
   // инициализируем обработчики
   echo '<script src="SignaPhoto.js"></script>';
   return $Result;
}

/*
// ****************************************************************************
// *      Настроить ориентацию страницы (страница "Подписать фотографию"      *
// *   использует две разметки: для страницы на компьютере и для ландшафтной  *
// *    странице на смартфоне - простая разметка на дивах; а для портретной   *
// *           страницы на смартфоне с помощью jquery mobile                  *
// ****************************************************************************
function MakeOrient($s_Orient)
{
   $Result=$s_Orient;
   // !!! Запрос страницы "Подписать фотографию" может осуществляться тремя 
   // вариантами:
   //    href="/_Signaphoto/SignaPhoto.php"
   //    href="/_Signaphoto/SignaPhoto.php?orient=portrait"     
   //    href="/_Signaphoto/SignaPhoto.php?orient=landscape"
   // 1. Когда отсутствует параметр orient, это значит, что положение текущего 
   // устройства не изменилось или это был начальный запуск
   if (prown\getComRequest('orient')===NULL)
   {
      ?> <script> 
      // Задаем текущее значение счетчика загрузок страницы в сессию
      OrientCounter=Number(sessionStorage.getItem('OrientCounter'))+1;
      sessionStorage.setItem('OrientCounter',OrientCounter);
      console.log('OrientCounter='+OrientCounter);
      // По умолчанию считаем, что текущая страница запускается в
      // ландшафтной ориентации, поэтому если обнаруживается, что
      // страница в портретной ориентация, то перезагружаем страницу,
      // явно указывая портретную ориентацию
      if (OrientCounter===1)  
      {
         if ((window.orientation==0)||(window.orientation==180))
         {
            alert('Начальный запуск, ориентация портретная, перезагружаем страницу');
            window.location = SignaPortraitUrl;
         }
         else
         {
            alert('Начальный запуск, ориентация ландшафтная');
         }
      }
       </script> <?php

      // Если начальный запуск на смартфоне, то мы должны переопределить
      // ориентацию, "вдруг портретная ориентация"
      //else prown\Alert('Не изменилась ориентация: '.$s_Orient);
   }
   // 2. Когда присутствует параметр orient, это значит, что текущее 
   // устройство - смартфон и оно сменило ориентацию однозначно
   else
   {
      $s_Orient=prown\getComRequest('orient');
      //prown\Alert('Ориентация ИЗМЕНИЛАСЬ: '.$s_Orient);
   }
   return $Result;
}
// ****************************************************************************
// *                  Сформировать через глобальные переменные JS             *
// *            запросы для вызова страниц с портретной ориентацией           *
// *   и ландшафтной. Так как страница "Подписать фотографию" использует две  *
// * разметки: для страницы на компьютере и ландшафтной странице на смартфоне -
// *   простая разметка на дивах; а для портретной страницы на смартфоне с    *
// *                              помощью jquery mobile                       *
// ****************************************************************************
function MakeTextPages()
{
   ?> 
   <script>
   https="http"
   console.log('https='+https);
   // Готовим URL для мобильно-портретной разметки, то есть разметки
   // для jQuery-мobile c двумя страницами 
   SignaPortraitUrl="/_Signaphoto/SignaPhoto.php?orient=portrait";
   console.log('SignaPortraitUrl='+SignaPortraitUrl);
   // Готовим URL для настольно-ландшафтной разметки (одностраничной)
   SignaUrl="/_Signaphoto/SignaPhoto.php?orient=landscape";
   console.log('SignaUrl='+SignaUrl);
   </script> 
   <?php
}
*/
?> <?php // *** <!-- --> *********************************** SignaPhoto.php ***
