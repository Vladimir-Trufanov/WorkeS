<?php
// PHP7/HTML5, EDGE/CHROME                           *** SignaPhotoHtml.php ***

// ****************************************************************************
// * _SignaPhoto1                       Вспомогательные функции сайтостраницы *
// *                                              для подписывания фотографий *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  10.06.2021
// Copyright © 2021 tve                              Посл.изменение: 12.11.2021

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
   MakeTextPages();
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
      <link rel="stylesheet" href="/Jsx/jquery-ui.min.css"/> 
      <script src="/Jsx/jquery-1.11.1.min.js"></script>
      <script src="/Jsx/jquery-ui.min.js"></script>
   ';
   echo '<link rel="stylesheet" type="text/css" href="SignaPhoto.css">';
   // Подключаем сайтовые(SignaPhoto) функции Js и
   // инициализировать обработчики
   echo '<script src="SignaPhoto.js"></script>';
   return $Result;
}

/*
// Выполнить разметку мобильных подстраниц "Подписать фотографию"
function markupMobileSite($c_SignaPhoto,$UrlHome,$SiteRoot,$c_FileImg,$c_FileStamp,$c_FileProba)
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


function MakeStamp()
{
   // Загрузка штампа и фото, для которого применяется водяной знак (называется штамп или печать)
   $stamp = imagecreatefrompng('images/stamp.png');
   $im = imagecreatefromjpeg('images/photo.jpg');
   // Установка полей для штампа и получение высоты/ширины штампа
   $marge_right = 10;
   $marge_bottom = 10;
   $sx = imagesx($stamp);
   $sy = imagesy($stamp);
   // Копирование изображения штампа на фотографию с помощью смещения края
   // и ширины фотографии для расчёта позиционирования штампа.
   imagecopy($im,$stamp,imagesx($im)-$sx-$marge_right,imagesy($im)-$sy-$marge_bottom,0,0,imagesx($stamp),imagesy($stamp));
   // Вывод и освобождение памяти
   //header('Content-type: image/png');
   imagepng($im, 'images/proba.png');
   imagedestroy($im);
   echo '<br>Сделано!<br>';
}

function ImgMakeStamp($FileImg)
{
   // Загрузка штампа и фото, для которого применяется водяной знак (называется штамп или печать)
   $stamp = imagecreatefrompng('images/stamp.png');
   $im = imagecreatefromjpeg('images/photo.jpg');
   // Установка полей для штампа и получение высоты/ширины штампа
   $marge_right = 10;
   $marge_bottom = 10;
   $sx = imagesx($stamp);
   $sy = imagesy($stamp);
   // Копирование изображения штампа на фотографию с помощью смещения края
   // и ширины фотографии для расчёта позиционирования штампа.
   imagecopy($im,$stamp,imagesx($im)-$sx-$marge_right,imagesy($im)-$sy-$marge_bottom,0,0,imagesx($stamp),imagesy($stamp));
   // Вывод и освобождение памяти
   //header('Content-type: image/png');
   imagepng($im, 'images/proba.png');
   imagedestroy($im);
   echo '<br>'.$FileImg.'- сделано <br>';
}
*/

// ****************************************************************************
// *                         Завершить HTML-страницу сайта                    *
// ****************************************************************************
function FinaPage()
{
   $Result=true;
   return $Result;
}
// ****************************************************************************
// *      Настроить ориентацию страницы (страница "Подписать фотографию"      *
// *   использует две разметки: для страницы на компьютере и для ландшафтной  *
// *    странице на смартфоне - простая разметка на дивах; а для портретной   *
// *           страницы на смартфоне с помощью jquery mobile                  *
// ****************************************************************************
function MakeOrient(&$s_Orient,$s_Counter)
{
   $s_Orient=$s_Orient;
   // Запрос страницы "Подписать фотографию" может осуществляться тремя 
   // вариантами:
   //    href="/_Signaphoto1/SignaPhoto.php"
   //    href="/_Signaphoto1/SignaPhoto.php?orient=portrait"     
   //    href="/_Signaphoto1/SignaPhoto.php?orient=landscape"
   // 1. Когда отсутствует параметр orient, это значит, что положение текущего 
   // устройства не изменилось или это был начальный запуск
   if (prown\getComRequest('orient')===NULL)
   {
      // Если начальный запуск на смартфоне, то мы должны переопределить
      // ориентацию, "вдруг портретная ориентация"
      if ($s_Counter===1) 
      {
         ?> <script> 
            iniOnOrientationChange(); 
         </script> <?php
         prown\Alert('Начальный запуск, ориентация: '.$s_Orient);
      }
      else prown\Alert('Не изменилась ориентация: '.$s_Orient);
   }
   // 2. Когда присутствует параметр orient, это значит, что текущее 
   // устройство - смартфон и оно сменило ориентацию однозначно
   else
   {
      $s_Orient=prown\getComRequest('orient');
      prown\Alert('Ориентация ИЗМЕНИЛАСЬ: '.$s_Orient);
   }
   return $s_Orient;
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
   //  <li><a href="_Signaphoto1/SignaPhoto.php?orient=portrait">SignaPhotoPortrait</a></li>     
   //  <li><a href="_Signaphoto1/SignaPhoto.php?orient=landscape">SignaPhotoLandscape</a></li>     
   ?> <script>
   // Определяем защишенность сайта, для того чтобы правильно сформулировать 
   // в запросе http или https
   let $https='<?php echo $_SERVER["HTTPS"];?>';
   if ($https=="off") $https="http"
   else $https="https"; 
   console.log('$https='+$https);
   // Готовим URL для мобильно-портретной разметки, то есть разметки
   // для jQuery-мobile c двумя страницами 
   var $SignaPortraitUrl="/_Signaphoto1/SignaPhoto.php?orient=portrait";
   console.log('$SignaPortraitUrl='+$SignaPortraitUrl);
   // Готовим URL для настольно-ландшафтной разметки (одностраничной)
   var $SignaUrl="/_Signaphoto1/SignaPhoto.php?orient=landscape";
   console.log('$SignaUrl='+$SignaUrl);
   </script> <?php
}
// Вывести изображение последнего загруженного фото
function ViewPhoto($c_FileImg)
{
   // Debug1: Выводим просто заполнитель
   /*
   echo 
      'Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo'.
      'Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo'.
      'Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo'.
      'Photo Photo Photo';
   */
   // Debug2: Выводим просто изображение
   echo '<img src="'.$c_FileImg.'" alt="" id="pic">';
   //echo '<img src="images/stamp.png" alt="" id="picStamp">';
   /* 
   $im = imagecreatefrompng('dave.png');
   if($im && imagefilter($im, IMG_FILTER_GRAYSCALE))
   {
      echo 'Изображение преобразовано к градациям серого.';
      imagepng($im, 'dave1.png');
   }
   else
   {
      echo 'Преобразование не удалось.';
   }
   imagedestroy($im);
   */   
}
// Вывести изображение подписи последних размеров
function ViewStamp($c_FileStamp)
{
   /*
   echo 'Stamp Stamp Stamp Stamp Stamp Stamp Stamp Stamp Stamp Stamp Stamp '.
      'Stamp Stamp Stamp Stamp Stamp Stamp Stamp Stamp Stamp Stamp Stamp Stamp'.
      'Stamp Stamp Stamp Stamp Stamp Stamp';
   */
   echo '<img src="'.$c_FileStamp.'" alt="" id="picStamp">';
}
// Вывести изображение c подписью
function ViewProba($c_FileProba)
{  
   /*                                                          
   echo 'Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba '.
   'Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba '.
   'Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba '.
   'Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba';
   */
   echo '<img src="'.$c_FileProba.'" alt="" id="picProba">';
}

function LoadImg()
{ 
   $RequestFile='photo';
   // Рисуем нашу кнопку, определяем ей реакцию на нажатие кнопки мыши
   echo '
      <div id="btnLoadImg" class="navButtons" onclick="FindFileImg();" title="Загрузка изображения">
         <img src="buttons/image128.png"   width=100% height=100%/></img>
      </div>
   ';
   // Начинаем форму запроса изображения по типу: photo, stamp, proba
   echo '
      <form action="SignaPhotoUpload.php?img='.$RequestFile.'" '.
      'target="rFrame" method="POST" enctype="multipart/form-data">';  
   // Формируем три inputа для обеспечения ввода в диве с нулевыми размерами,
   // для того чтобы их скрыть. Разрешенный размер загружаемого файла чуть 
   // больше, чем указанный в php.ini (где он равем 3Mb)
   $MaxLoadSize = 4100000;
   echo'
   <div class="hiddenInput">
      <input type="hidden" name="MAX_FILE_SIZE" value="'.$MaxLoadSize.'">
      <input type="file"    id="my_hidden_fileImg" '.
         'accept="image/jpeg,image/png,image/gif" name="loadfile" onchange="LoadFileImg();">'.
      '<input type="submit" id="my_hidden_loadImg" '.
         'style="display:none" value="Загрузить">'.
   '</div>';
   // Завершаем форму запроса
   echo '</form>';
}

function LoadStamp()
{ 
   // Рисуем нашу кнопку, определяем ей реакцию на нажатие кнопки мыши
   echo '
      <div id="btnLoadStamp" class="navButtons" onclick="AlertMessage();" title="Загрузка изображения подписи">
         <img src="buttons/stamp128.png"   width=100% height=100%/></img>
      </div>
   ';

   /*
   $RequestFile='stamp';
   // Рисуем нашу кнопку, определяем ей реакцию на нажатие кнопки мыши
   echo '
      <div id="btnLoadStamp" class="navButtons" onclick="FindFileStamp();" title="Загрузка файла">
         <img src="buttons/stamp128.png"   width=100% height=100%/></img>
      </div>
   ';
   // Начинаем форму запроса изображения по типу: photo, stamp, proba
   echo '
      <form action="SignaPhotoUpload.php?img='.$RequestFile.'" '.
      'target="rFrame" method="POST" enctype="multipart/form-data">';  
   // Формируем два inputа для обеспечения ввода в диве с нулевыми размерами,
   // для того чтобы их скрыть
   echo'
   <div class="hiddenInput">
      <input type="file"    id="my_hidden_fileStamp" '.
         'accept="image/jpeg,image/png,image/gif" name="loadfile" onchange="LoadFileStamp();">'.
      '<input type="submit" id="my_hidden_loadStamp" '.
         'style="display:none" value="Загрузить">'.
   '</div>';
   // Завершаем форму запроса
   echo '</form>';
   */
}

function Register()
{
  /*
   // Рисуем нашу кнопку, определяем ей реакцию на нажатие кнопки мыши
   /*
   echo '
      <div id="btnRegister" class="navButtons" title="Регистрация пользователя">
         <a  href="Register.html">
         <img src="buttons/register128.png" width=100% height=100%/></img>
         </a>
     </div>
    ';
    */
   echo '
      <div id="btnRegister" class="navButtons"
         onclick="AlertMessage(\'Регистрация пользователя отключена!\')"
         title="Регистрация пользователя">
         <img src="buttons/register128.png" width=100% height=100%/></img>
     </div>
   ';
}
function Indoor()
{ 
   /*
   echo '
      <div id="btnIndoor" class="navButtons" title="Авторизация пользователя">
         <a  href="Indoor.html">
         <img src="buttons/input128.png" width=100% height=100%/></img>
         </a>
     </div>
   ';
   */
   echo '
      <div id="btnIndoor" class="navButtons"
         onclick="AlertMessage(\'Авторизация пользователя отключена!\')"
         title="Авторизация пользователя">
         <img src="buttons/input128.png" width=100% height=100%/></img>
     </div>
   ';
}
function Subscribe()
{
   /*
   echo '
      <div id="btnSubscribe" class="navButtons"
         onclick="Substi()"
         title="Авторизация пользователя">
         <img src="buttons/subscribe128.png" width=100% height=100%/></img>
     </div>
   ';
   */
   
   echo '
      <div id="btnSubscribe" class="navButtons" title="Загрузка файла">
         <a  href="Subscribe.php">
         <img src="buttons/subscribe128.png"   width=100% height=100%/>
         </img>
         </a>
     </div>
   ';
   
 }
function Tunein()
{ 
   echo '
      <div id="btnTunein" class="navButtons" title="Загрузка файла">
         <a  href="Tunein.html">
         <img src="buttons/tunein128.png"   width=100% height=100%/></img>
         </a>
     </div>
    ';
}

// *** <!-- --> **************************************** SignaPhotoHtml.php ***
