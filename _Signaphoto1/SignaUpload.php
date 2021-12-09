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
require_once $TPhpPrown."/CreateRightsDir.php";
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
   $imgDir="Gallery"; $modeDir=05577;
   prown\CreateRightsDir($imgDir,$modeDir);
   //$imgDir="Gallery2"; $modeDir=0755;
   
   
   
   
   
   
   
   
   //prown\ConsoleLog('$permissions='.$permissions);  
   //prown\ConsoleLog('$modeDir=    '.$modeDir);  

   $permissions=fileperms($imgDir);
   // Сравниваем установленные права с желаемыми
   $fPermissions=substr(sprintf('%o',$permissions),-4);
   prown\ConsoleLog($fPermissions);
   $xPermissions='0'.sprintf('%o',$modeDir);
   prown\ConsoleLog($xPermissions);
   if ($fPermissions===$xPermissions) prown\ConsoleLog('Установленные и желаемые права совпадают');
   else prown\ConsoleLog('Установленные и желаемые права НЕ совпадают');
   
   //$modeDir=0123;
   //$modeDir=123;
   
   //alf_jsOnResponse(sprintf("%04o",$modeDir)); 
   //alf_jsOnResponse(octdec(sprintf("%04o",$modeDir))); 
   //alf_jsOnResponse(decoct(octdec(sprintf("%04o",$modeDir)))); 
   //alf_jsOnResponse("0".decoct(octdec(sprintf("%04o",$modeDir)))); 

   /*
   prown\ConsoleLog(sprintf("%04o",0123)); 
   prown\ConsoleLog(sprintf("%04o",123)); 
   prown\ConsoleLog(octdec(sprintf("%04o",0123))); 
   prown\ConsoleLog(octdec(sprintf("%04o",123))); 
   */


   //----
   /*
   $expectedPermissions='0123';
   $permissions=0123;
   if (intval($expectedPermissions,8) == $permissions) 
   { // 8 specifies octal base for conversion
     prown\ConsoleLog('0123 - восьмеричное'); 
   }
   $expectedPermissions='123';
   if (intval($expectedPermissions, 8) == $permissions) { // 8 specifies octal base for conversion
   prown\ConsoleLog('123 - восьмеричное'); 
   }
   */
   //----

   //prown\ConsoleLog(0123); 
   //prown\ConsoleLog(intval(0123,8)); 
   //prown\ConsoleLog(123); 
   //prown\ConsoleLog(intval(123,8)); 
   
   //$x=0123;
   //prown\ConsoleLog((string)$x); 
   //prown\ConsoleLog('"'.$x.'"'); 
   
   
   
   //return decoct(octdec($x)) == $x;
   /*
   $x=0123;
   prown\ConsoleLog(decoct(octdec($x)));     // =   3
   prown\ConsoleLog($x);                     // =  83
   if (is_octal($x)) prown\ConsoleLog('0123 - это восьмеричное'); 
   else prown\ConsoleLog('0123 - это НЕ восьмеричное'); 

   $x=123;
   prown\ConsoleLog(decoct(octdec($x)));     // = 123
   prown\ConsoleLog($x);                     // = 123
   if (is_octal($x)) prown\ConsoleLog('123 - это восьмеричное'); 
   else prown\ConsoleLog('123 - это НЕ восьмеричное'); 

   $x=0177;
   prown\ConsoleLog(decoct(octdec($x)));     
   prown\ConsoleLog($x);                    
   if (is_octal($x)) prown\ConsoleLog('0177 - это восьмеричное'); 
   else prown\ConsoleLog('0177 - это НЕ восьмеричное'); 

   $x=177;
   prown\ConsoleLog(decoct(octdec($x)));     
   prown\ConsoleLog($x);                     
   if (is_octal($x)) prown\ConsoleLog('177 - это восьмеричное'); 
   else prown\ConsoleLog('177 - это НЕ восьмеричное'); 
   */

 
   
   /*
   if (is_int($modeDir)) 
   {
      if (is_octal($modeDir)) alf_jsOnResponse('восьмеричное число'); 
      else alf_jsOnResponse('НЕ восьмеричное число'); 
   }
   else alf_jsOnResponse('НЕ число'); 
   */
   
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

// ******************************************************** SignaUpload.php ***
