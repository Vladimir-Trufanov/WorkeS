<?php
// PHP7/HTML5, EDGE/CHROME                               *** SignaPhoto.php ***

// ****************************************************************************
// * SignaPhoto                                              Главный модуль - *
// *                                сайтостраница для подписывания фотографий *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
// v5.1                                              Дата создания:  01.06.2021
// Copyright © 2021 tve                              Посл.изменение: 11.02.2022

// Инициируем рабочее пространство страницы
require_once $_SERVER['DOCUMENT_ROOT'].'/iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();
$SiteRoot   = $_WORKSPACE[wsSiteRoot];      // Корневой каталог сайта
$SiteAbove  = $_WORKSPACE[wsSiteAbove];     // Надсайтовый каталог
$SiteHost   = $_WORKSPACE[wsSiteHost];      // Каталог хостинга
$SiteDevice = $_WORKSPACE[wsSiteDevice];    // 'Computer' | 'Mobile' | 'Tablet'
$SiteProtocol=$_WORKSPACE[wsSiteProtocol];  //  => isProtocol() 
$RemoteAddr = $_WORKSPACE[wsRemoteAddr];    // IP-адрес запроса сайта
// Определяем URL сайта и URL страницы приложения "Подписать фотографию"
$urlHome=$SiteProtocol.'://'.$_SERVER['HTTP_HOST']; 
$urlPage=$SiteProtocol.'://'.$_SERVER['HTTP_HOST'].'/_Signaphoto/SignaPhoto.php'; 
// Определяем полный путь каталога хранения изображений и
// его url-аналог для связывания с разметкой через кукис
$imgDir=$_SERVER['DOCUMENT_ROOT'].'/Temp'; 
$urlDir=$SiteProtocol.'://'.$_SERVER['HTTP_HOST'].'/Temp'; 
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
   require_once pathPhpPrown."/CreateRightsDir.php";
   require_once pathPhpPrown."/MakeCookie.php";
   require_once pathPhpPrown."/MakeRID.php";
   require_once pathPhpPrown."/MakeSession.php";
   require_once pathPhpPrown."/MakeUserError.php";
   require_once pathPhpPrown."/ViewGlobal.php";
   // Подключаем файлы библиотеки прикладных классов:
   require_once pathPhpTools."/iniToolsMessage.php";
   require_once pathPhpTools."/TUploadToServer/UploadToServerClass.php";
   // Подключаем рабочие модули:
   require_once 'SignaPhotoDef.php';
   require_once "SignaPhotoImg.php";
   require_once "SignaTunein.php";
   require_once "SignaUpload.php";
   require_once "SignaMakeStamp.php";
   // Инициируем сообщения
   $InfoMess=ajSuccess;
   // Изменяем счетчики запросов сайта из браузера и, таким образом,       
   // регистрируем новую загрузку страницы
   $c_UserName=prown\MakeCookie('UserName',"Гость",tStr,true);              // логин авторизованного посетителя
   $c_PersName=prown\MakeCookie('PersName',"Гость",tStr,true);              // логин посетителя
   $c_BrowEntry=prown\MakeCookie('BrowEntry',0,tInt,true);                  // число запросов сайта из браузера
   $c_BrowEntry=prown\MakeCookie('BrowEntry',$c_BrowEntry+1,tInt);  
   $c_PersEntry=prown\MakeCookie('PersEntry',0,tInt,true);                  // счетчик посещений текущим посетителем
   $c_PersEntry=prown\MakeCookie('PersEntry',$c_PersEntry+1,tInt);
   // Инициируем или изменяем счетчик числа запросов страницы
   $c_SignaPhoto=prown\MakeCookie('SignaPhoto',0,tInt,true);  
   $c_SignaPhoto=prown\MakeCookie('SignaPhoto',$c_SignaPhoto+1,tInt);  
   // Меняем кукис ориентации устройства 
   $c_Orient=prown\MakeCookie('Orient',oriLandscape,tStr,true);             // ориентация устройства
   if (IsSet($_GET["orient"]))
   {
      if ($_GET["orient"]==oriLandscape) $c_Orient=prown\MakeCookie('Orient',oriLandscape,tStr); 
      if ($_GET["orient"]==oriPortrait)  $c_Orient=prown\MakeCookie('Orient',oriPortrait,tStr); 
   }
   // Изменяем сессионные переменные (сессионные переменные инициируются после
   // переменных-кукисов, так как некоторые переменные-кукисы переопределяются появившимися
   // сессионными переменными. Например: $s_ModeImg --> $c_ModeImg)
   $s_Counter=prown\MakeSession('Counter',0,tInt,true);      // посещения за сессию
   $s_Counter=prown\MakeSession('Counter',$s_Counter+1,tInt);   
   // Обрабатываем параметры HTTP-запроса по настройкам подписания изображений
   // и записываем данные в кукисы
   TuneinRequest($urlPage,$c_PointCorner,$c_PerSizeImg,$c_PerMargeWidth,$c_PerMargeHight,$c_MaintainProp);
   // Подключаемся к файлам изображений
   ConnectImgFiles($c_FileImg,$c_FileStamp,$c_FileProba);
   // Обрабатываем загрузку изображения 
   ifSignaUpload($InfoMess,$imgDir,$urlDir,$c_FileStamp,$c_FileImg,$c_FileProba);
   // Обрабатываем подписание фотографии
   ifSignaMakeStamp($InfoMess,$c_FileImg,$c_FileStamp,$imgDir,
      $c_PerSizeImg,$c_MaintainProp,$c_PointCorner,$c_PerMargeWidth,
      $c_PerMargeHight,$SiteProtocol,$c_FileProba,$urlDir);
   // Готовим начало страницы для подписывания фотографий
   IniPage($c_SignaPhoto,$SiteProtocol,$SiteDevice,$c_Orient);
   // Подключаем скрипты по завершению загрузки страницы
   if (prown\isComRequest('In','Tune')) $NamePage='Tunein';
   else $NamePage='Other';
   ?> <script>
   NamePage="<?php echo $NamePage;?>";
   urlPage="<?php echo $urlPage;?>";
   urlHome="<?php echo $urlHome;?>";
   xOrient="<?php echo $c_Orient;?>";
   $(document).ready(function() {
      window.addEventListener('orientationchange',doOnOrientationChange);
      OnOrientationChange(xOrient);
   });
   </script> <?php

   // Начинаем выводить тело страницы 
   echo '</head>';
   echo '<body>';

   // Выводим отладочную информацию
   // DebugView($c_Orient);
   // Запускаем построение базовой разметки
   MarkupBase($c_FileImg,$c_FileStamp,$c_FileProba,$RemoteAddr,$c_PerSizeImg,$c_PointCorner,
      $c_PerMargeWidth,$c_PerMargeHight,$c_MaintainProp,$c_Orient,$SiteDevice);

   // Завершаем вывод страницы 
   ViewMess($InfoMess);
   echo '</body>';
   echo '</html>';
}
catch (E_EXCEPTION $e) 
{
   DoorTryPage($e);
}
// ****************************************************************************
// *        Вывести информационное сообщение или сообщение об ошибке          *
// ****************************************************************************
function ViewMess($InfoMess)
{
   if ($InfoMess<>ajSuccess)
   {
      ?> <script>
      InfoMess="<?php echo $InfoMess;?>";
      $('#'+ohInfo).html(InfoMess);
      SignaInnerWidth = document.documentElement.clientWidth*0.7;
      $('#'+ohInfo).dialog({
         modal: true,
        width: SignaInnerWidth,
        position: {my: 'center center', at: 'center center'},
        show: {effect:'slideDown'},
        hide: {effect:'explode', delay:250, duration:1000, easing:'easeInQuad'}
      });
      </script> <?php
   }
}
// ****************************************************************************
// *                           Выполняем базовую разметку                     *
// ****************************************************************************
function MarkupBase($c_FileImg,$c_FileStamp,$c_FileProba,$RemoteAddr,
   $c_PerSizeImg,$c_PointCorner,$c_PerMargeWidth,$c_PerMargeHight,$c_MaintainProp,$c_Orient,$SiteDevice)
{
  // Размечаем область изображений
  echo '<div id="All">';
    
    if (prown\isComRequest('In','Tune')) 
       ViewTuneIn($c_PerSizeImg,$c_PointCorner,$c_PerMargeWidth,$c_PerMargeHight,$c_MaintainProp,$c_Orient,$SiteDevice);
    else 
    {
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
      ViewProba($c_FileProba,$RemoteAddr,
         $c_PointCorner,$c_PerSizeImg,$c_PerMargeWidth,$c_PerMargeHight,$c_MaintainProp,
         $c_FileImg,$c_FileStamp,$c_Orient);
    echo '</div>';
    }
    
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
    // Выходим на главную страницу сайта
    Home();
    // Закладываем в разметку див для сообщений через диалоговое окно
    echo '<div id="'.ohInfo.'"'.' title="SignaPhoto">';
    echo '</div>';
  echo '</div>';
}
// ****************************************************************************
// *                            Начать HTML-страницу сайта                    *
// ****************************************************************************
function IniPage(&$c_SignaPhoto,$SiteProtocol,$SiteDevice,$_Orient)
{
   $Result=true;
   // Подключаем межязыковые (PHP-JScript) определения внутри HTML
   DefinePHPtoJS();
   // Загружаем заголовочную часть страницы
   echo '<!DOCTYPE html>';
   echo '<html lang="ru">';
   echo '<head>';
   echo '<meta charset="UTF-8">';
   cssViewport($SiteDevice);
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
   cssDivPosition($SiteDevice,$_Orient);
   // Определяем uri вызова страниц с различной ориентацией
   $SignaUrl=$_SERVER['SCRIPT_NAME'].'?orient='.oriLandscape;
   $SignaPortraitUrl=$_SERVER['SCRIPT_NAME'].'?orient='.oriPortrait;
   // Подключаем сайтовые(SignaPhoto) функции Js и
   // инициализируем обработчики
   ?> <script>
      // Назначаем uri вызова страниц с различной ориентацией
      SignaUrl="<?php echo $SignaUrl;?>";
      SignaPortraitUrl="<?php echo $SignaPortraitUrl;?>";
   </script> <?php
   echo '<script src="SignaPhoto.js"></script>';
   return $Result;
}
?> <?php // *** <!-- --> *********************************** SignaPhoto.php ***
