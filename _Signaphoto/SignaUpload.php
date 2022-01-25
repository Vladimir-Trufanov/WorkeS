<?php
// PHP7/HTML5, EDGE/CHROME                              *** SignaUpload.php ***

// ****************************************************************************
// * SignaPhoto  Переместить загруженный файл из временного хранилища на сервер
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  25.11.2021
// Copyright © 2021 tve                              Посл.изменение: 22.01.2022

// Подключаем файлы библиотеки прикладных модулей:
require_once pathPhpPrown."/CreateRightsDir.php";
require_once pathPhpPrown."/MakeRID.php";
// Подключаем файлы библиотеки прикладных классов:
require_once pathPhpTools."/TUploadToServer/UploadToServerClass.php";

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
// Назначаем имя файла в соответствии с RID и для файла изображения,
// и для файла штампа-подписи
$name='x95'; 
$name=prown\MakeRID();
if ($NameInput=="loadimg") $NameLoad=$name.'img';
elseif ($NameInput=="loadstamp") $NameLoad=$name.'stamp';
else $NameLoad=$name;

// Определяем полный путь для создания каталога хранения изображений и
// его url-аналог для связывания с разметкой через кукис
$imgDir=$_SERVER['DOCUMENT_ROOT'].'/Temp'; 
$urlDir=$SiteProtocol.'://'.$_SERVER['HTTP_HOST'].'/Temp'; 
// Подготавливаем параметры размещения изображения в диве
$field=current($_FILES);
$type=substr($field['type'],strpos($field['type'],'/')+1);
$localimg=$urlDir.'/'.$NameLoad.'.'.$type;
$nameimg=$imgDir.'/'.$NameLoad.'.'.$type;
// Создаем каталог для хранения изображений, если его нет.
$modeDir=0777;
$is=prown\CreateRightsDir($imgDir,$modeDir,rvsReturn);

// Если с каталогом все в порядке, то будем перебрасывать файл на сервер
if ($is===true)
{
   // Перебрасываем файл на постоянное хранение
   $upload=new ttools\UploadToServer($imgDir,$NameLoad);
   $MessUpload=$upload->move();
   // Если перемещение завершилось неудачно, то выдаем сообщение
   if ($MessUpload<>imok) 
   {
      global $_Prefix;
      prown\MakeUserError($MessUpload,$_Prefix,rvsDialogWindow);
   }   
   // Перемещение файла на сервер выполнилось успешно
   else 
   {
      // Создаем массив данных для передачи браузеру
      // (либо массив с одним сообщением, либо массив размеров изображений)
      $user_info = array(); 
      if ($NameInput=="loadimg") 
      {
         $c_FileImg=prown\MakeCookie('FileImg',$localimg,tStr);
         prown\ConsoleLog('$localimg='.$localimg);
         prown\ConsoleLog('$nameimg='.$nameimg);
      }
      elseif ($NameInput=="loadstamp") 
      {
         $c_FileStamp=prown\MakeCookie('FileStamp',$localimg,tStr);
      }
   }  
}
// ******************************************************** SignaUpload.php ***
