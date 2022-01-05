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
      <link rel="stylesheet" href="/Jsx/jqueryui-1.13.0.min.css"/> 
      <script src="/Jsx/jquery-1.11.1.min.js"></script>
      <script src="/Jsx/jqueryui-1.13.0.min.js"></script>
   ';
   // Подключаем font-awesome
   echo '<link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">';
   // Подключаем скрипт изменения заголовка "input file"
   echo '<script src="/Jsx/jquery-input-file-text.js"></script>';
   //
   echo '<link rel="stylesheet" type="text/css" href="SignaReset.css">';
   //echo '<link rel="stylesheet" type="text/css" href="SignaPhoto.css">';
   // Подключаем межязыковые (PHP-JScript) определения внутри HTML
   require_once 'SignaPhotoDef.php';
   echo $define; echo $odefine;
   // Подключаем сайтовые(SignaPhoto) функции Js и
   // инициализировать обработчики
   echo '<script src="SignaPhoto.js"></script>';
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
         //prown\Alert('Начальный запуск, ориентация: '.$s_Orient);
      }
      //else prown\Alert('Не изменилась ориентация: '.$s_Orient);
   }
   // 2. Когда присутствует параметр orient, это значит, что текущее 
   // устройство - смартфон и оно сменило ориентацию однозначно
   else
   {
      $s_Orient=prown\getComRequest('orient');
      //prown\Alert('Ориентация ИЗМЕНИЛАСЬ: '.$s_Orient);
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
/*
function MakeTextPages()
{
   //  <li><a href="_Signaphoto1/SignaPhoto.php?orient=portrait">SignaPhotoPortrait</a></li>     
   //  <li><a href="_Signaphoto1/SignaPhoto.php?orient=landscape">SignaPhotoLandscape</a></li>     
   ?> 
   <script>
   // Определяем защишенность сайта, для того чтобы правильно сформулировать 
   // в запросе http или https
   https='<?php echo $_SERVER["HTTPS"];?>';
   if (https=="off") https="http"
   else https="https"; 
   console.log('https='+https);
   // Готовим URL для мобильно-портретной разметки, то есть разметки
   // для jQuery-мobile c двумя страницами 
   var $SignaPortraitUrl="/_Signaphoto1/SignaPhoto.php?orient=portrait";
   console.log('$SignaPortraitUrl='+$SignaPortraitUrl);
   // Готовим URL для настольно-ландшафтной разметки (одностраничной)
   var $SignaUrl="/_Signaphoto1/SignaPhoto.php?orient=landscape";
   console.log('$SignaUrl='+$SignaUrl);
   </script> 
   <?php
}
*/
function MakeTextPages()
{
   ?> 
   <script>
   https="http"
   console.log('https='+https);
   // Готовим URL для мобильно-портретной разметки, то есть разметки
   // для jQuery-мobile c двумя страницами 
   var $SignaPortraitUrl="/_Signaphoto1/SignaPhoto.php?orient=portrait";
   console.log('$SignaPortraitUrl='+$SignaPortraitUrl);
   // Готовим URL для настольно-ландшафтной разметки (одностраничной)
   var $SignaUrl="/_Signaphoto1/SignaPhoto.php?orient=landscape";
   console.log('$SignaUrl='+$SignaUrl);
   </script> 
   <?php
}
// ****************************************************************************
// *           Вывести 3 изображения (оригинал, штамп, с подписью)            *
// ****************************************************************************
// Вывести изображение последнего загруженного фото
function ViewPhoto($c_FileImg)
{
   /* 
   // Выводим заполнитель дива вместо изображения
   echo 
      'Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo'.
      'Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo'.
      'Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo Photo'.
      'Photo Photo Photo';
   */
   // Выводим изображение
   echo '<img src="'.$c_FileImg.'" alt="tttrr" id="pic" title="ghhjjjkk">';
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
   
     
   // Начинаем форму запроса изображения по типу: photo, stamp, proba
   //echo '
   //   <form action="SignaPhotoUpload.php?img='.$RequestFile.'" '.
   /*
   echo '
      <form action="SignaPhotoUpload.php?img=file.png" '.
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
   */
   //echo '<img src="'.$c_FileProba.'" alt="" id="picProba">';
   
           
   echo '<pre>';
   print_r($_FILES);
   print "</pre>";
   

   
   //echo '<div id="InfoLead"></div>';
   //\prown\ViewGlobal(avgFILES);
}
// ****************************************************************************
// *     Подготовить кнопки для действий: загрузить изображение, подписать,   *
// *                    загрузить подпись, выполнить настройки                *
// ****************************************************************************
// "Загрузить изображение"
function LoadImg()
{ 
   // $RequestFile='photo';
   // Рисуем нашу кнопку, определяем ей реакцию на нажатие кнопки мыши
   /*
   echo '
      <div id="btnLoadImg" class="navButtons" onclick="FindFileImg();" title="Загрузка изображения">
         <img src="buttons/image128.png"   width=100% height=100%/></img>
      </div>
   ';
   */
   //echo '<button id="bLoadImg" class="btnLead" title="Загрузить изображение">'.
   //'<i id="iLoadImg" class="fa fa-file-image-o fa-3x" aria-hidden="true"></i></button>';
   //   <iframe id="alfFrame" name="alfFrame" style="display: none"> </iframe>  

   /*
   echo '
   <div class="navButtons" onclick="alfFindFile();" title="Загрузка файла"><i id="iLoadImg" class="fa fa-file-image-o fa-3x" aria-hidden="true"></i></div>
   <form action="SignaUpload.php" target="alfFrame" method="POST" enctype="multipart/form-data">  
   <div class="hiddenInput">
      <input type="file"   id="select_img" accept="image/jpeg,image/png,image/gif" name="loadfile" onchange="alfLoadFile();">  
      <input type="submit" id="loadin_img" style="display:none" value="Загрузить">  
   </div>
   </form>
   <iframe id="alfFrame" name="alfFrame" style="display:none"></iframe>  
   ';
   */
   
   /*
   echo '
   <div class="navButtons" onclick="alfFindFile();" title="Загрузка файла"><i id="iLoadImg" class="fa fa-file-image-o fa-3x" aria-hidden="true"></i></div>
   <form target="alfFrame" method="POST" enctype="multipart/form-data">  
   <div class="hiddenInput">
      <input type="file"   id="select_img" accept="image/jpeg,image/png,image/gif" name="loadfile" onchange="alfLoadFile();">  
      <input type="submit" id="loadin_img" style="display:none" value="Загрузить" onclick="alfMoveFile();">  
   </div>
   </form>
   <iframe id="alfFrame" name="alfFrame" style="display:none"></iframe>  
   ';
   */
   /*
   echo '
   <div class="navButtons" onclick="alfFindFile();" title="Загрузка файла"><i id="iLoadImg" class="fa fa-file-image-o fa-3x" aria-hidden="true"></i></div>
   <div class="hiddenInput">
      <input type="file" id="select_img" accept="image/jpeg,image/png,image/gif" name="loadfile" onchange="alfLoadFile();">  
   </div>
   ';
   echo '
      <input type="file" id="select_img" accept="image/jpeg,image/png,image/gif" onclick="alfLoadFile();">  
   ';
   */
   
   /*
   echo '
      <div id="ipfDivPic">
      <input id="ipfLoadPic" type="file" name="image" 
      onchange="alfLoadFile();" onclick="fliClick();" onload="fliLoad();" onreset="fliReset();">
      </div>
   ';
   */


   // Stamp
   // alfFrame
   echo '
     <div id="InfoLead">
     <form target="alfFrame" action="SignaUpload.php" method="POST" enctype="multipart/form-data"> 
     <input type="hidden" name="MAX_FILE_SIZE" value="3000024"/> 
     <input type="file"   id="my_hidden_file" accept="image/jpeg,image/png,image/gif" name="loadfile" onchange="alfLoadFile();"/>  
     <input type="submit" id="my_hidden_load" value="">  
     </form>
     </div>
   ';
   
   echo '
   <button id="bLoadImg" class="navButtons" onclick="alfFindFile()"  
   title="Загрузить изображение">
   <i id="iLoadImg" class="fa fa-file-image-o fa-3x" aria-hidden="true"></i>
   </button>
   ';
}
// "Подписать"
function Subscribe()
{ 
   echo '
   <button id="bSubscribe" class="navButtons"   
   title="Подписать">
   <i id="iSubscribe" class="fa fa-user-plus fa-3x" aria-hidden="true"></i>
   </button>
   ';
}
// "Выполнить настройки"
function Tunein()
{ 
   echo '
   <button id="bTunein" class="navButtons"   
   title="Выполнить настройки">
   <i id="iTunein" class="fa fa-cog fa-3x" aria-hidden="true"></i>
   </button>
   ';
}
// "Загрузить подпись"
function LoadStamp()
{ 
   echo '
   <button id="bLoadStamp" class="navButtons"   
   title="Загрузить подпись">
   <i id="iLoadStamp" class="fa fa-pencil-square-o fa-3x" aria-hidden="true"></i>
   </button>
   ';
}
/*
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

function LoadStamp1()
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
function Subscribe1()
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
 
/*
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
*/

// *** <!-- --> **************************************** SignaPhotoHtml.php ***
