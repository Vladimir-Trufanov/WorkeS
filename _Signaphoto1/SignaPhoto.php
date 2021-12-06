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

   //echo $_WORKSPACE[wsUserAgent];
   // Подключаем модуль и выодим технологическую информацию
   require_once $_SERVER['DOCUMENT_ROOT'].'/ViewEnviron.php';;
   // Подключаем файлы библиотеки прикладных модулей:
   $TPhpPrown  = $SiteHost.'/TPhpPrown/TPhpPrown';
   require_once $TPhpPrown."/CommonPrown.php";
   require_once $TPhpPrown."/MakeCookie.php";
   require_once $TPhpPrown."/MakeSession.php";
   require_once $TPhpPrown."/ViewGlobal.php";
   // Подключаем файлы библиотеки прикладных классов:
   //$TPhpTools=$SiteHost.'/TPhpTools';
   //require_once $TPhpTools."/TPhpTools/iniErrMessage.php";
   // Подключаем файлы библиотеки прикладных классов:
   $TPhpTools=$SiteHost.'/TPhpTools/TPhpTools';
   //require_once $TPhpTools."/TUploadToServer/UploadToServerClass.php";
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

   echo '<script> PlaceImgOnDiv(); </script>';


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

   //DebugView($s_Orient);
   MarkupLandscape($c_FileImg,$c_FileStamp,$c_FileProba);

   // 
 
    echo '
     <iframe id="alfFrame" name="alfFrame" width="468" height="360" align="left" style="position:absolute; display:block; z-index:201;"></iframe>  
   ';

 
  
   
   // Завершаем вывод страницы
   echo '</body>';
   echo '</html>';
}
catch (E_EXCEPTION $e) 
{
   DoorTryPage($e);
}
// ****************************************************************************
// *                    Разметить страницу в варианте LandScape               *
// ****************************************************************************
function MarkupLandscape($c_FileImg,$c_FileStamp,$c_FileProba)
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
         ViewProba($c_FileProba);
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
         /*
         echo '***<br>';
         echo 'Привет info!<br>';
         echo '***<br>';
         echo '</div>';
         */
      echo '</div>';

      
      
   echo '</div>';
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
?> <?php // *** <!-- --> *********************************** SignaPhoto.php ***
