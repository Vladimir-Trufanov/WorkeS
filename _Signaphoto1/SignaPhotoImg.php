<?php
// PHP7/HTML5, EDGE/CHROME                            *** SignaPhotoImg.php ***

// ****************************************************************************
// * SignaPhoto               Блок функций подготовки и обработки изображений *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  25.11.2021
// Copyright © 2021 tve                              Посл.изменение: 13.01.2022

// Подключаем межязыковые (PHP-JScript) определения
require_once 'SignaPhotoDef.php';

// ****************************************************************************
// *  Заполнить массив данными об изображении для размещения в заданном окне, *
// *     если определить данные не получается, то в этом массиве указать      *
// *   сообщение для вывода в специальном окне, указанном константой ohInfo   *
// ****************************************************************************
function FillArrayOne($DivId,$ImgName)
{
   // Строим объект изображения и получаем сообщение
   $messa=ImgCreate($ImgName,$Img);
   // Для отладки:
   // if ($DivId=='Proba') $messa=ajProba;
   // Если объект изображения получился, то готовим массив параметров 
   if ($messa==ajSuccess) 
   {
      // Определяем размеры изображения
      $ImgWidth  = imagesx($Img);
      $ImgHeight = imagesy($Img);
      // Продолжаем заполнять список изображений
      $user_info[] = array (
         'DivId'     => $DivId,
         'ImgName'   => $ImgName,
         'ImgWidth'  => $ImgWidth,
         'ImgHeight' => $ImgHeight
      );
   }
   // Если объект изображения НЕ получился, то готовим одно сообщение 
   else 
   {
      $user_info[] = array (
         'DivId'     => ohInfo, 
         'ImgName'   => $ImgName.': '.$messa,
         'ImgWidth'  => NULL,
         'ImgHeight' => NULL
      );
   }
   return $user_info;
}
// ****************************************************************************
// *                       Выделить расширение в имени файла                  *
// ****************************************************************************
function get_file_extension($file_name)
{
   return substr(strrchr($file_name,'.'),1);
}
// ****************************************************************************
// *                 Создать объект изображения для его обработки             *
// ****************************************************************************
function ImgCreate($c_FileImg,&$Img)
{
   $Img = NULL;
   $Result=ajSuccess;
   // Определяем расширение имени файла изображения
   $FileExt=get_file_extension($c_FileImg);
   if (($FileExt<>'gif')and($FileExt<>'jpeg')and($FileExt<>'jpg')and($FileExt<>'png')) 
   { 
     // Если недопустимое расширение файла, то возвращаем сообщение
     $Result=ajInvalidBuilt;
   } 
   else
   {
      // Строим изображение
      if ($FileExt=='gif') 
      { 
         $Img = @imagecreatefromgif($c_FileImg);
      }           
      elseif (($FileExt=='jpeg')or($FileExt=='jpg'))
      {
         $Img = @imagecreatefromjpeg($c_FileImg);
      }
      elseif ($FileExt=='png')
      {
         $Img = @imagecreatefrompng($c_FileImg);
      }
      else
      {
         $Result=ajImageNotBuilt;
      }
   }
   return $Result;
}

/*
// Инициируем рабочее пространство страницы
require_once $_SERVER['DOCUMENT_ROOT'].'/iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();
$SiteRoot   = $_WORKSPACE[wsSiteRoot];    // Корневой каталог сайта
$SiteAbove  = $_WORKSPACE[wsSiteAbove];   // Надсайтовый каталог
$SiteHost   = $_WORKSPACE[wsSiteHost];    // Каталог хостинга
$SiteDevice = $_WORKSPACE[wsSiteDevice];  // 'Computer' | 'Mobile' | 'Tablet'
// Подключаем сайт сбора сообщений об ошибках/исключениях и формирования 
// страницы с выводом сообщений, а также комментариев для PHP5-PHP7
//require_once $SiteHost."/TDoorTryer/DoorTryerPage.php";
//try 
//{
   set_error_handler("CreateRightsPermsHandler");
   //$i=0; $j=4/$i;
   //restore_error_handler();

   // Подключаем файлы библиотеки прикладных модулей:
   $TPhpPrown=$SiteHost.'/TPhpPrown';
   require_once $TPhpPrown."/TPhpPrown/MakeCookie.php";
   // Извлекаем из кукисов спецификации изображений (путей с именами файлов)
   $c_FileImg=prown\MakeCookie('FileImg');
   //$c_FileImg='images/iphoto1.jpg';
   //prown\ConsoleLog('111-$c_FileImg='.$c_FileImg); 

   //$c_FileImg='http://localhost:82/Temp/proba.jpg';
   $c_FileStamp=prown\MakeCookie('FileStamp');
   $c_FileProba=prown\MakeCookie('FileProba');
   // Создаем массив данных для передачи браузеру
   // (либо массив с одним сообщением, либо массив размеров изображений)
   $user_info = array(); 
    
      
   // Принимаем и обрабатываем переданные параметры
   foreach($_GET as $key => $value)
   {
      $user_info[] = array (
      '$key'   => $key,
      '$value' => $value
      );
   }
   
   // Последовательно определяем ширину и высоту изображений из трех дивов,
   // готовим данные для передачи: или ширины и высоты всех трех, или одно
   // сообщение об ошибке
   
   $is=FillArray('Photo',$c_FileImg,$user_info);
   if ($is) 
   {
      $is=FillArray('Stamp',$c_FileStamp,$user_info);
      if ($is) 
      {
         FillArray('Proba',$c_FileProba,$user_info);
      }
   }
   
   // Передаем данные в формате JSON
   // (если нет передачи данных, то по аякс-запросу вернется ошибка)
   echo json_encode($user_info);
   restore_error_handler();
//}
//catch (E_EXCEPTION $e) 
//{
//   $user_info = array(); 
//   echo json_encode($user_info);
   //DoorTryPage($e);
//}


   function CreateRightsPermsHandler($errno,$errstr,$errfile,$errline)
   {
     //$user_info = array(); 
     //echo json_encode($user_info);
   } 









*/
                                
// ****************************************************** SignaPhotoImg.php ***
