<?php
// PHP7/HTML5, EDGE/CHROME                           *** SignaPhotoHtml.php ***

// ****************************************************************************
// * _SignaPhoto                        Вспомогательные функции сайтостраницы *
// *                                              для подписывания фотографий *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  10.06.2021
// Copyright © 2021 tve                              Посл.изменение: 21.01.2022

// ****************************************************************************
// *           Вывести 3 изображения (оригинал, штамп, с подписью)            *
// ****************************************************************************
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
function ViewProba($c_FileProba,$RemoteAddr,$c_FileImg)
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
   
   $a=getimagesize($c_FileImg);
   echo '<pre>';
   print_r($a);
   echo '</pre>';

   $a=serialize($_FILES);
   echo '$a='.$a.'<br>';
   prown\ViewGlobal(avgCOOKIE);
   /*        

   echo '<pre>';
   echo '*** $RemoteAddr='.$RemoteAddr.' ***<br>';
   echo '*** browscap='.ini_get('browscap').' ***<br>';
   $browser = get_browser(null,true);
   print_r($browser);
   echo "</pre>";
   */
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
     <form action="SignaUpload.php" method="POST" enctype="multipart/form-data"> 
     <input type="hidden" name="MAX_FILE_SIZE" value="3000024"/> 
     <input type="file"   id="my_hidden_file" accept="image/jpeg,image/png,image/gif" name="loadimg" onchange="alf2LoadFile();"/>  
     <input type="submit" id="my_hidden_load" value="">  
     </form>
     </div>
   ';
   
   echo '
   <button id="bLoadImg" class="navButtons" onclick="alf1FindFile()"  
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
