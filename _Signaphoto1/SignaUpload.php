<?php
// PHP7/HTML5, EDGE/CHROME                              *** SignaUpload.php ***

// ****************************************************************************
// * SignaPhoto  Переместить загруженный файл из временного хранилища на сервер
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  25.11.2021
// Copyright © 2021 tve                              Посл.изменение: 07.12.2021

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

$TPhpPrown  = $SiteHost.'/TPhpPrown/TPhpPrown';
require_once $TPhpPrown."/CommonPrown.php";
// Подключаем файлы библиотеки прикладных классов:
$TPhpTools=$SiteHost.'/TPhpTools/TPhpTools';
require_once $TPhpTools."/TUploadToServer/UploadToServerClass.php";
prown\ConsoleLog($TPhpTools."/TUploadToServer/UploadToServerClass.php"); 

// Подключаем сайт сбора сообщений об ошибках/исключениях и формирования 
// страницы с выводом сообщений, а также комментариев для PHP5-PHP7
//require_once $SiteHost."/TDoorTryer/DoorTryerPage.php";
//try 
//{
   //alf_jsOnResponse("Это сообщение из SignaLoad!!");
   //$i=0; $j=5/$i; /*echo $j;*/
   // Создаем каталог для хранения изображений, если его нет.
   // И отдельно (чтобы сработало на старых Windows) задаем права
   $imgDir="Gallery";
   $is=CreateRightsDir($imgDir,0777);
   //alf_jsOnResponse($is);
   
   /*
   try
   {
       $fileperms=substr(sprintf('%o', fileperms('/tmp')), -4);
       alf_jsOnResponse($fileperms);
   }
   catch (E_WARNING $e) 
   {
       alf_jsOnResponse('Не удалось получить права доступа каталога');
   }
   */

   //try 
   //{
       // Регистрируем новую функцию-обработчик для всех типов ошибок
       //set_error_handler("ProbaHandler",E_WARNING);
       //$i=0; $j=5/$i; 
       //$fileperms=substr(sprintf('%o', fileperms('/tmp')), -4);
       //$fileperms=substr(sprintf('%o', fileperms($imgDir)), -4);
       //alf_jsOnResponse($fileperms);
   //} catch (E_EXCEPTION $e) {
   //    alf_jsOnResponse('Не удалось получить права доступа каталога');
   //}



   //$fileperms=substr(sprintf('%o',fileperms($imgDir)),-4);
   
   
   /*
   if ($is<>Ok)
   {
      alf_jsOnResponse(ajOk);
     // return $is;
      //  alf_jsOnResponse("{'filename':'" . $is . "', 'success':'" . $success . "'}");
   }
   else 
   {
      alf_jsOnResponse(ajOk);
      // Обрабатываем ошибку при переброске файла на сервер с несуществующим каталогом
      //$upload = new ttools\UploadToServer($_SERVER['DOCUMENT_ROOT'].'/'.'i'.$imgDir.'/');
      //alf_jsOnResponse("{'filename':'" . '$upload' . "', 'success':'" . $success . "'}");
   }
   */
//}
//catch (E_EXCEPTION $e) 
//{
//   DoorTryPage($e);
//}

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

function ProbaHandler($errno,$errstr,$errfile,$errline)
{
   //global $TypeErrors;
   // Если error_reporting нулевой, значит, использован оператор @,
   // все ошибки должны игнорироваться
   //if (!error_reporting())
   //{
   //   return true;
   //}
          alf_jsOnResponse('Не удалось получить права доступа каталога');

   return true;
}  
               

// ****************************************************************************
// *       Создать каталог (проверить существование) и задать его права       *
// ****************************************************************************
function CreateRightsDir($Dir,$modeDir)
// https://habr.com/ru/sandbox/124577/ - хорошая статья про удаление каталога 
{
   // Если каталога нет, то будем создавать его
   if (!is_dir($Dir))
   {
      prown\ConsoleLog('Каталога нет, будем создавать его!'); 
   }
   // Если каталог существует, то будем проверять его права
   else
   {
      prown\ConsoleLog('Каталог существует, будем проверять его права!'); 
   }
/*
   // Если каталог существует, то удаляем его
   if (!is_dir($imgDir))
   {
      // Создаем каталог
      if (!mkdir($imgDir,$modeDir))
      {
         return 'Ошибка создания каталога: '.$imgDir;
      }
      // И отдельно (чтобы сработало на старых Windows) задаем права
      else
      {
         if (!chmod($imgDir,$modeDir))
         {
            return 'Ошибка изменения прав каталога: '.$imgDir.
               ' ['.$modeDir.'] --> ['.substr(sprintf('%o', fileperms($imgDir)),-4).']';
         }
         // Параметр режима состоит из четырех цифр:
         //
         // Первое число всегда равно нулю
         // Второе число указывает разрешения для владельца
         // Третье число указывает разрешения для группы пользователей владельца.
         // Четвертое число указывает разрешения для всех остальных.
         // Возможные значения (чтобы установить несколько разрешений, сложите следующие числа):
         //
         // 1 = выполнение
         // 2 = права на запись
         // 4 = разрешения на чтение
      }
   }
   return ajOk;
*/
}

// ******************************************************** SignaUpload.php ***
