<?php
// PHP7/HTML5, EDGE/CHROME                              *** SignaUpload.php ***

// ****************************************************************************
// * SignaPhoto  Переместить загруженный файл из временного хранилища на сервер
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  25.11.2021
// Copyright © 2021 tve                              Посл.изменение: 03.12.2021




   function alf_jsOnResponse($obj)  
   {  
      echo '<script type="text/javascript"> window.parent.alfOnResponse("'.$obj.'"); </script> ';  
   exit;
   }  

// Подключаем межязыковые (PHP-JScript) определения
require_once 'SignaPhotoDef.php';

// Инициируем рабочее пространство страницы
require_once $_SERVER['DOCUMENT_ROOT'].'/iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();
$SiteHost=$_WORKSPACE[wsSiteHost];    // Каталог хостинга

   $TPhpPrown  = $SiteHost.'/TPhpPrown/TPhpPrown';
   require_once $TPhpPrown."/CommonPrown.php";
   //prown\ConsoleLog('SignaUpload12'); 
   
   // Подключаем файлы библиотеки прикладных классов:
   $TPhpTools=$SiteHost.'/TPhpTools/TPhpTools';
   require_once $TPhpTools."/TUploadToServer/UploadToServerClass.php";
   prown\ConsoleLog($TPhpTools."/TUploadToServer/UploadToServerClass.php"); 
   //include $TPhpTools."/TUploadToServer/UploadToServerClass.php";




// Подключаем сайт сбора сообщений об ошибках/исключениях и формирования 
// страницы с выводом сообщений, а также комментариев для PHP5-PHP7
require_once $SiteHost."/TDoorTryer/DoorTryerPage.php";
try 
{

      // Обрабатываем ошибку при переброске файла на сервер с несуществующим каталогом
      //$upload = new ttools\UploadToServer($_SERVER['DOCUMENT_ROOT'].'/'.'i'.$imgDir.'/');
      $upload = new ttools\UploadToServer('fili.png');

    $i=0; $j=5/$i; echo $j;
     
   $dir = '../temp/';  
   $name = basename($_FILES['loadfile']['name']);  
   $file = $dir . $name;  
   prown\ConsoleLog('SignaUpload: '.$file); 
   $success = move_uploaded_file($_FILES['loadfile']['tmp_name'], $file);  
   alf_jsOnResponse("{'filename':'" . $name . "', 'success':'" . $success . "'}");
   
   
}
catch (E_EXCEPTION $e) 
{
   DoorTryPage($e);
}
// ******************************************************** SignaUpload.php ***
