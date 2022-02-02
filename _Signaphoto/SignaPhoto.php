<?php
// PHP7/HTML5, EDGE/CHROME                               *** SignaPhoto.php ***

// ****************************************************************************
// * SignaPhoto                                              Главный модуль - *
// *                                сайтостраница для подписывания фотографий *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
// v5.1                                              Дата создания:  01.06.2021
// Copyright © 2021 tve                              Посл.изменение: 24.01.2022

// Инициируем рабочее пространство страницы
require_once $_SERVER['DOCUMENT_ROOT'].'/iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();
$SiteRoot   = $_WORKSPACE[wsSiteRoot];      // Корневой каталог сайта
$SiteAbove  = $_WORKSPACE[wsSiteAbove];     // Надсайтовый каталог
$SiteHost   = $_WORKSPACE[wsSiteHost];      // Каталог хостинга
$SiteDevice = $_WORKSPACE[wsSiteDevice];    // 'Computer' | 'Mobile' | 'Tablet'
$SiteProtocol=$_WORKSPACE[wsSiteProtocol];  //  => isProtocol() 
$RemoteAddr = $_WORKSPACE[wsRemoteAddr];    // IP-адрес запроса сайта

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
   require_once pathPhpPrown."/MakeRID.php";
   require_once pathPhpPrown."/MakeSession.php";
   require_once pathPhpPrown."/MakeUserError.php";
   require_once pathPhpPrown."/ViewGlobal.php";
   // Подключаем файлы библиотеки прикладных классов:
   require_once pathPhpTools."/iniToolsMessage.php";
   require_once pathPhpTools."/TDeviceOrientater/DeviceOrientaterClass.php";

   // Подключаем рабочие модули:
   require_once 'SignaPhotoDef.php';
   require_once "SignaPhotoImg.php";
   
   // Изменяем счетчики запросов сайта из браузера и, таким образом,       
   // регистрируем новую загрузку страницы
   $c_UserName=prown\MakeCookie('UserName',"Гость",tStr,true);              // логин авторизованного посетителя
   $c_PersName=prown\MakeCookie('PersName',"Гость",tStr,true);              // логин посетителя
   $c_BrowEntry=prown\MakeCookie('BrowEntry',0,tInt,true);                  // число запросов сайта из браузера
   $c_BrowEntry=prown\MakeCookie('BrowEntry',$c_BrowEntry+1,tInt);  
   $c_PersEntry=prown\MakeCookie('PersEntry',0,tInt,true);                  // счетчик посещений текущим посетителем
   $c_PersEntry=prown\MakeCookie('PersEntry',$c_PersEntry+1,tInt);
   // Обеспечиваем инициацию параметров подписи
   $c_PointCorner=prown\MakeCookie('PointCorner',ohRightBottom,tStr,true);  // точка привязки подписи
   $c_PerSizeImg=prown\MakeCookie('PerSizeImg',20,tInt,true);               // процент размера подписи к изображению
   $c_PerMargeWidth=prown\MakeCookie('PerMargeWidth',5,tInt,true);          // процент смещения подписи по ширине от точки привязки
   $c_PerMargeHight=prown\MakeCookie('PerMargeHight',5,tInt,true);          // процент смещения подписи по высоте от точки привязки
   $c_MaintainProp=prown\MakeCookie('MaintainProp',false,tBool,true);       // сохранять пропорции подписи
   
   // Инициируем или изменяем счетчик числа запросов страницы
   $c_SignaPhoto=prown\MakeCookie('SignaPhoto',0,tInt,true);  
   $c_SignaPhoto=prown\MakeCookie('SignaPhoto',$c_SignaPhoto+1,tInt);  

   // Изменяем сессионные переменные (сессионные переменные инициируются после
   // переменных-кукисов, так как некоторые переменные-кукисы переопределяются появившимися
   // сессионными переменными. Например: $s_ModeImg --> $c_ModeImg)
   $s_Counter=prown\MakeSession('Counter',0,tInt,true);                     // посещения за сессию
   $s_Counter=prown\MakeSession('Counter',$s_Counter+1,tInt);   

   // Подключаемся к файлам изображений
   ConnectImgFiles($c_FileImg,$c_FileStamp,$c_FileProba);
   // Обрабатываем загрузку изображения 
   if (IsSet($_POST["MAX_FILE_SIZE"])) require_once "SignaUpload.php";

   // Обрабатываем подписание фотографии 
   if (prown\isComRequest('Do','Stamp')) require_once "SignaMakeStamp.php";

   // Сбрасываем кэши состояний файлов
   ClearCacheImgFiles($c_FileImg,$c_FileStamp,$c_FileProba);
   // Готовим начало страницы для подписывания фотографий
   IniPage($c_SignaPhoto,$UrlHome,$SiteProtocol);

   prown\ConsoleLog('$c_PersEntry='.$c_PersEntry);
 
   // Создаем объект класса по контролю за положением устройства
   // и определяем ориентацию устройства
   $orient = new ttools\DeviceOrientater($SiteDevice);
   $_Orient=$orient->getOrient();
   
   // Подключаем скрипты по завершению загрузки страницы
   if (prown\isComRequest('In','Tune')) $NamePage='Tunein';
   else $NamePage='Other';
   ?> <script>
   NamePage="<?php echo $NamePage;?>";
   $(document).ready(function() {
      // Устанавливаем фон настроек
      if (NamePage=='Tunein') $("#Proba").css("background-image",'url(images/bg_page.png)')
      else $("#Proba").css("background",'khaki');
   });
   </script> <?php

   // Начинаем выводить тело страницы 
   echo '</head>';
   echo '<body>';

   // Выводим отладочную информацию
   // DebugView($s_Orient);

   // Запускаем построение разметки
   if ($_Orient==oriLandscape) MarkupLandscape($c_FileImg,$c_FileStamp,$c_FileProba,$RemoteAddr);
   else MarkupPortrait($c_FileImg,$c_FileStamp,$c_FileProba,$RemoteAddr);

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
   //ViewMess('Поверните устройство!');
   MarkupLandscape($c_FileImg,$c_FileStamp,$c_FileProba,$RemoteAddr);
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
      // Показываем загруженное изображение для подписи
      echo '<div id="Photo">';
        ViewPhoto($c_FileImg);
      echo '</div>';
      // Показываем образец подписи
      echo '<div  id="Stamp">';
        ViewStamp($c_FileStamp);
      echo '</div>';
    echo '</div>';
    // Размечаем область изображения с подписью
    echo '<div  id="Proba">';
      if (prown\isComRequest('In','Tune')) ViewTuneIn();
      else ViewProba($c_FileProba,$RemoteAddr);
    echo '</div>';
  echo '</div>';
   
  // Размечаем область управления загрузкой и подписанием
  echo '<div  id="Lead">';
    // Строим форму и кнопку загрузки изображения для подписи
    LoadImg();
    // Накладываем изображения штампа на фотографию с учетом ширины фотографии
    // и смещения штампа от точка привязки       
    MakeStamp();
    // Изменяем настройки подписания фотографии
    Tunein();
    // Загружаем образец для подписания фотографии
    LoadStamp();
    // Делаем кнопку для отладки js-функций
    // echo '<button id="bQuest" title="Вопрос?" onclick="PlaceImgOnDiv()">Вопросик?</button>';
    // Закладываем в разметку див для сообщений через диалоговое окно
    echo '<div id="'.ohInfo.'">';
    echo '***<br>';
    echo 'Привет info!<br>';
    echo '***<br>';
    echo '</div>';
    
    echo '<div id="hello">';
    echo 'Привет';
    echo '</div>';
    
  echo '</div>';
}
// ****************************************************************************
// *                            Начать HTML-страницу сайта                    *
// ****************************************************************************
function IniPage(&$c_SignaPhoto,&$UrlHome,$SiteProtocol)
{
   $Result=true;
   // Определяем Url домашней страницы
   if ($_SERVER["SERVER_NAME"]=='kwinflatht.nichost.ru') $UrlHome='http://kwinflatht.nichost.ru';
   else $UrlHome='http://localhost:82'; 
   // Подключаем межязыковые (PHP-JScript) определения внутри HTML
   DefinePHPtoJS();
   // Загружаем заголовочную часть страницы
   echo '<!DOCTYPE html>';
   echo '<html lang="ru">';
   echo '<head>';
   echo '<meta http-equiv="content-type" content="text/html; charset=utf-8"/>';
   //echo '<meta http-equiv="Cache-control" content="no-cache">';
   echo '<title>Подписать фотографию: _SignaPhoto</title>';
   echo '<meta name="description" content="_SignaPhoto">';
   echo '<meta name="keywords"    content="_SignaPhoto">';
   // Подключаем jquery/jquery-ui
   echo '
      <link rel="stylesheet" href="/Jsx/jqueryui-1.13.0.min.css"/> 
      <script src="/Jsx/jquery-1.11.1.min.js"></script>
      <script src="/Jsx/jqueryui-1.13.0.min.js"></script>
      <link rel="stylesheet" href="reset.min.css">
   ';
   // Подключаем font-awesome
   echo '<link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">';
   //
   echo '<link rel="stylesheet" type="text/css" href="SignaPhoto.css">';
   // Подключаем сайтовые(SignaPhoto) функции Js и
   // инициализируем обработчики
   echo '<script src="SignaPhoto.js"></script>';
   
   
  echo '
  <style>
  </style>
  <script src="prefixfree.min.js"></script> 
  '; 
   
   
   
   
   
   return $Result;
}


?> <?php // *** <!-- --> *********************************** SignaPhoto.php ***
