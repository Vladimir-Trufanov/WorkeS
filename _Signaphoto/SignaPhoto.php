<?php
// PHP7/HTML5, EDGE/CHROME                               *** SignaPhoto.php ***

// ****************************************************************************
// * SignaPhoto                                              Главный модуль - *
// *                                сайтостраница для подписывания фотографий *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
// v4.1                                              Дата создания:  01.06.2021
// Copyright © 2021 tve                              Посл.изменение: 17.01.2022

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

   // Подключаем рабочие модули:
   require_once "SignaPhotoHtml.php";
   
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

   // Готовим начало страницы для подписывания фотографий
   IniPage($c_SignaPhoto,$UrlHome,$c_FileImg,$c_FileStamp,$c_FileProba);

   // Создаем объект класса по контролю за положением устройства
   // и определяем ориентацию устройства
   $orient = new ttools\DeviceOrientater($SiteDevice);
   $_Orient=$orient->getOrient();
   
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
   
   // Выводим отладочную информацию
   // DebugView($s_Orient);

   // Запускаем построение разметки
   
   //clearstatcache();
   
   if ($_Orient==oriLandscape) MarkupLandscape($c_FileImg,$c_FileStamp,$c_FileProba,$RemoteAddr);
   else MarkupPortrait($c_FileImg,$c_FileStamp,$c_FileProba,$RemoteAddr);

   // Размещаем плавающий фрэйм сообщений при загрузке изображения
   echo 
    '<iframe id="alfFrame" name="alfFrame" align="left">'.
    'Ваш браузер не поддерживает плавающие фреймы!'.
    '</iframe>';

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
      // echo '<button id="bQuest" title="Вопрос?" onclick="PlaceImgOnDiv()">Вопросик?</button>';

      // Закладываем в разметку див для сообщений через диалоговое окно
      echo '<div id="'.ohInfo.'">';
      echo '***<br>';
      echo 'Привет info!<br>';
      echo '***<br>';
      echo '</div>';
      
   echo '</div>';
}

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

?> <?php // *** <!-- --> *********************************** SignaPhoto.php ***
