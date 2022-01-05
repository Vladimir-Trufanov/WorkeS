<?php
// PHP7/HTML5, EDGE/CHROME                              *** SignaUpload.php ***

// ****************************************************************************
// * SignaPhoto  Переместить загруженный файл из временного хранилища на сервер
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  25.11.2021
// Copyright © 2021 tve                              Посл.изменение: 29.12.2021


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
   
   // Создаем каталог для хранения изображений, если его нет.
   $imgDir=$_SERVER['DOCUMENT_ROOT'].'/Temp'; $modeDir=0777;
   $is=prown\CreateRightsDir($imgDir,$modeDir,rvsReturn);
   // Если с каталогом все в порядке, то будем перебрасывать файл на сервер
   if ($is===true)
   {
      //alf_jsOnResponse(ajOk);
      $upload=new ttools\UploadToServer($imgDir);
      $MessUpload=$upload->move();
      // Если перемещение завершилось неудачно, то выдаем сообщение
      if ($MessUpload<>imok) alf_jsOnResponse($MessUpload);
      // Перемещение файла на сервер выполнилось успешно
      else 
      {
         alf_jsOnResponse($MessUpload);
         //  alf_jsOnResponse("{'filename':'" . $is . "', 'success':'" . $success . "'}");
      }
   }
   // Если не удалось каталог с правами сделать, сообщаем причину
   else alf_jsOnResponse($is);
}
catch (E_EXCEPTION $e) 
{
   DoorTryPage($e);
}

      /*
      $MessUpload=$upload->move(); 
      if ($MessUpload<>Ok) echo $MessUpload; 
      if ($thiss!==NULL) $thiss->assertNotEqual($MessUpload,Ok);
      // '[TUploadToServer] Каталог для загрузки файла отсутствует');
      if ($thiss!==NULL) $thiss->assertTrue(strpos($MessUpload,DirDownloadMissing)); 
      OkMessage();
      
      // Выполняем "успешную" переброску файла на сервер с верным каталогом
      $upload = new ttools\UploadToServer($_SERVER['DOCUMENT_ROOT'].'/'.$imgDir.'/');
      $MessUpload=$upload->move(); echo $MessUpload;
      //if ($thiss!==NULL) $thiss->assertEqual($MessUpload,Ok);
      OkMessage();
      */
     
      /*
      $dir = '../temp/';  
      $name = basename($_FILES['loadfile']['name']);  
      $file = $dir . $name;  
      prown\ConsoleLog('SignaUpload: '.$file); 
      $success = move_uploaded_file($_FILES['loadfile']['tmp_name'], $file);  
      alf_jsOnResponse("{'filename':'" . $name . "', 'success':'" . $success . "'}");
      */

// ******************************************************** SignaUpload.php ***