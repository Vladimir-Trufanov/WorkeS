<?php
// PHP7/HTML5, EDGE/CHROME                              *** SignaUpload.php ***

// ****************************************************************************
// * SignaPhoto  Переместить загруженный файл из временного хранилища на сервер
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  25.11.2021
// Copyright © 2021 tve                              Посл.изменение: 10.01.2022


function alf_jsOnResponse($obj)  
{  
   echo '<script type="text/javascript"> window.parent.alfOnResponse("'.$obj.'"); </script> ';  
}  

// Подключаем межязыковые (PHP-JScript) определения внутри HTML
require_once 'SignaPhotoDef.php';
echo $define; echo $odefine;

// Инициируем рабочее пространство страницы
require_once $_SERVER['DOCUMENT_ROOT'].'/iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();
$SiteHost=$_WORKSPACE[wsSiteHost];    // Каталог хостинга
// Подключаем файлы библиотеки прикладных модулей:
define ("pathPhpPrown",$SiteHost.'/TPhpPrown/TPhpPrown'); 
require_once pathPhpPrown."/CommonPrown.php";
require_once pathPhpPrown."/CreateRightsDir.php";
require_once pathPhpPrown."/MakeCookie.php";
require_once pathPhpPrown."/MakeRID.php";
// Подключаем файлы библиотеки прикладных классов:
define ("pathPhpTools",$SiteHost.'/TPhpTools/TPhpTools'); 
require_once pathPhpTools."/iniToolsMessage.php";
require_once pathPhpTools."/TUploadToServer/UploadToServerClass.php";

// Подключаем сайт сбора сообщений об ошибках/исключениях и формирования 
// страницы с выводом сообщений, а также комментариев для PHP5-PHP7
require_once $SiteHost."/TDoorTryer/DoorTryerPage.php";
try 
{
   // Трассируем вызов SignaUpload.php
   // alf_jsOnResponse("Выполнен вызов SignaUpload.php");
   
   // Определяем имя подмассива по INPUT для $_FILES
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
   
   // Создаем каталог для хранения изображений, если его нет.
   $imgDir=$_SERVER['DOCUMENT_ROOT'].'/Temp'; $modeDir=0777;
   $is=prown\CreateRightsDir($imgDir,$modeDir,rvsReturn);
   // Если с каталогом все в порядке, то будем перебрасывать файл на сервер
   if ($is===true)
   {
      $upload=new ttools\UploadToServer($imgDir,$NameLoad);
      $MessUpload=$upload->move();
      // Если перемещение завершилось неудачно, то выдаем сообщение
      if ($MessUpload<>imok) alf_jsOnResponse($MessUpload);
      // Перемещение файла на сервер выполнилось успешно
      else 
      {
         $LoadImg=$_SERVER['DOCUMENT_ROOT'].'/Temp/'.$NameLoad.'.'.$upload->getExt();
         alf_jsOnResponse($LoadImg);
         if ($NameInput=="loadimg") $c_FileImg=prown\MakeCookie('FileImg',$LoadImg,tStr);
         elseif ($NameInput=="loadstamp") $c_FileStamp=prown\MakeCookie('FileStamp',$LoadImg,tStr);
      }
   }
   // Если не удалось каталог с правами сделать, сообщаем причину
   else alf_jsOnResponse($is);
   
}
catch (E_EXCEPTION $e) 
{
   DoorTryPage($e);
}

// ******************************************************** SignaUpload.php ***
