<?php
// PHP7/HTML5, EDGE/CHROME                              *** SignaUpload.php ***

// ****************************************************************************
// * SignaPhoto  Переместить загруженный файл из временного хранилища на сервер
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  25.11.2021
// Copyright © 2021 tve                              Посл.изменение: 12.02.2022

// Подключаем файлы библиотеки прикладных модулей:
require_once pathPhpPrown."/CreateRightsDir.php";
// Подключаем файлы библиотеки прикладных классов:
require_once pathPhpTools."/TUploadToServer/UploadToServerClass.php";

// Создаем каталог для хранения изображений, если его нет.
$modeDir=0777;
$isDir=prown\CreateRightsDir($imgDir,$modeDir,rvsReturn);
// Если с каталогом все в порядке, то будем перебрасывать файл на сервер
if ($isDir===true)
{
   // Определяем, загрузка какого файла выполнена: оригинального изображения
   // или образца подписи, через имя массива ("loadimg","loadstamp") из $_FILES         
   $NameInput=getLoadKind();

   $field=current($_FILES);
   $type=substr($field['type'],strpos($field['type'],'/')+1);

   if ($NameInput=="loadstamp") 
   {
      // Назначаем префикс имени файла в соответствии с RID и для файла штампа
      $PostFix='stamp';
      $PrefName=prown\MakeNumRID($imgDir,$PostFix,$type,true);
      $NameLoad=$PrefName.$PostFix;
      $localimg=$urlDir.'/'.$NameLoad.'.'.$type;
      $nameimg=$imgDir.'/'.$NameLoad.'.'.$type;
      // Перемещаем загруженный файл из временного хранилища на сервер,
      // записываем кукис                            
      MoveFromUpload($imgDir,$NameLoad,$c_FileStamp,'FileStamp',$localimg);
   }
   else if ($NameInput=="loadimg") 
   {
      // Перемещаем оригинальное изображение
      $PostFix='img';
      $PrefName=prown\MakeNumRID($imgDir,$PostFix,$type,true);
      $NameLoad=$PrefName.$PostFix;
      $localimg=$urlDir.'/'.$NameLoad.'.'.$type;
      $nameimg=$imgDir.'/'.$NameLoad.'.'.$type;
      MoveFromUpload($imgDir,$NameLoad,$c_FileImg,'FileImg',$localimg);
      // Создаем копию оригинального изображение для подписи
      // Важно: здесь имена создаем через MakeNumRID, как и для оригинального
      // изображения для того чтобы автоматически удалялся старый файл
      $PostFix='proba';
      $PrefName=prown\MakeNumRID($imgDir,$PostFix,$type,true);
      $NameLoad=$PrefName.$PostFix;
      $localimgp=$urlDir.'/'.$NameLoad.'.'.$type;
      $nameimgp=$imgDir.'/'.$NameLoad.'.'.$type;
      if (copy($nameimg,$nameimgp)) $c_FileProba=prown\MakeCookie('FileProba',$localimgp,tStr);
      else ViewMess(ajCopyImageNotCreate);
   }
   /* 12/02/2022
   // Перезагружаем начальную страницу
   Header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
   Header('Pragma: no-cache');                                   // HTTP 1.0.
   Header('Expires: 0');                                         // Proxies.
   Header('Location: '.$urlPage);
   */
}
// ****************************************************************************
// *       Определить, загрузка какого файла выполнена: оригинального         *
// *     изображение или образца подписи, через имя массива ("loadimg",       *
// *                     "loadstamp") из $_FILES                              *
// ****************************************************************************
// Файлы могут быть загружены из двух форм.
// "loadimg":
//   <form action="SignaPhoto.php" method="POST" enctype="multipart/form-data"> 
//   <input type="hidden" name="MAX_FILE_SIZE" value="3000024"/> 
//   <input type="file"   id="my_hidden_file" accept="image/jpeg,image/png,image/gif" 
//   name="loadimg" onchange="alf2LoadFile();"/>  
//   <input type="submit" id="my_hidden_load" value="">  
//   </form>
// "loadstamp":
//   <form action="SignaPhoto.php" method="POST" enctype="multipart/form-data"> 
//   <input type="hidden" name="MAX_FILE_SIZE" value="3000024"/> 
//   <input type="file"   id="my_shidden_file" accept="image/jpeg,image/png,image/gif" 
//   name="loadstamp" onchange="alf2sLoadFile();"/>  
//   <input type="submit" id="my_shidden_load" value="">  
//   </form>
function getLoadKind()
{
   // Определяем имя подмассива ("loadimg","loadstamp") по $_FILES
   // рассматриваем через сериализацию, когда загружен 1 файл:
   // или оригинальное изображение, или подпись !!! 
   $NameInputFile=serialize($_FILES);
   // Отрезаем часть строки до имени подмассива
   $PatternBefore="/\/\/\sМодуль([0-9a-zA-Zа-яёА-ЯЁ\s\.\$\n\r\(\)-:,=&;]+)\/\/\s---/u";
   $PatternBefore="/^a:1:\{s:[0-9]:\"/u";    // "/\/\/\sМодуль([0-9a-zA-Zа-яёА-ЯЁ\s\.\$\n\r\(\)-:,=&;]+)\/\/\s---/u");
   $Replacement="";
   $NameInputAfter=preg_replace($PatternBefore,$Replacement,$NameInputFile);
   // Отрезаем часть строки после имени подмассива
   $PatternAfter="/\";a:5:\{([\\a-zA-Zа-яёА-ЯЁ\:0-9\";\.\/_\}]*)/u";   
   $NameInput=preg_replace($PatternAfter,$Replacement,$NameInputAfter);
   return $NameInput;
}
// ****************************************************************************
// *       Переместить загруженный файл из временного хранилища на сервер     *
// *                           и записать в кукис                             *
// ****************************************************************************
function MoveFromUpload($imgDir,$NameLoadp,&$c_FileImgx,$NameCookie,$localimg)
{
   // Перебрасываем файл  
   $upload=new ttools\UploadToServer($imgDir,$NameLoadp);
   $MessUpload=$upload->move();
   // Если перемещение завершилось неудачно, то выдаем сообщение
   if ($MessUpload<>imok) ViewMess($MessUpload);
   // Перемещение файла на сервер выполнилось успешно, меняем кукис
   else $c_FileImgx=prown\MakeCookie($NameCookie,$localimg,tStr);
}
// ******************************************************** SignaUpload.php ***
