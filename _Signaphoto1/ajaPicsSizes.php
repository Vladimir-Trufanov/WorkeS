<?php
// PHP7/HTML5, EDGE/CHROME                             *** ajaPicsSizes.php ***

// ****************************************************************************
// * SignaPhoto                  Передать размеры трех изображений через аякс *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  25.11.2021
// Copyright © 2021 tve                              Посл.изменение: 26.11.2021

// Подключаем межязыковые определения
require_once 'SignaPhotoDef.php';

// Инициируем рабочее пространство страницы
require_once $_SERVER['DOCUMENT_ROOT'].'/iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();
$SiteRoot   = $_WORKSPACE[wsSiteRoot];    // Корневой каталог сайта
$SiteAbove  = $_WORKSPACE[wsSiteAbove];   // Надсайтовый каталог
$SiteHost   = $_WORKSPACE[wsSiteHost];    // Каталог хостинга
$SiteDevice = $_WORKSPACE[wsSiteDevice];  // 'Computer' | 'Mobile' | 'Tablet'
// Подключаем сайт сбора сообщений об ошибках/исключениях и формирования 
// страницы с выводом сообщений, а также комментариев для PHP5-PHP7
require_once $SiteHost."/TDoorTryer/DoorTryerPage.php";
try 
{
   // Подключаем файлы библиотеки прикладных модулей:
   $TPhpPrown=$SiteHost.'/TPhpPrown';
   require_once $TPhpPrown."/TPhpPrown/MakeCookie.php";
   // Извлекаем из кукисов спецификации изображений (путей с именами файлов)
   $c_FileImg=prown\MakeCookie('FileImg');
   $c_FileStamp=prown\MakeCookie('FileStamp');
   $c_FileProba=prown\MakeCookie('FileProba');
   // Создаем массив данных для передачи браузеру
   // (либо массив с одним сообщением, либо массив размеров изображений)
   $user_info = array(); 
   /*    
   // Принимаем и обрабатываем переданные параметры
   foreach($_GET as $key => $value)
   {
      $user_info[] = array (
      '$key'   => $key,
      '$value' => $value
      );
   }
   */
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
}
catch (E_EXCEPTION $e) 
{
   DoorTryPage($e);
}
// ****************************************************************************
// *                    Заполнить массив для возврата по Аяксу                *
// ****************************************************************************
function FillArray($DivId,$ImgName,&$user_info)
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
      return true;
   }
   // Если объект изображения НЕ получился, то готовим одно сообщение 
   else 
   {
      // Сбрасываем массиы для возврата, чтобы было одно сообщение 
      $user_info = array(); 
      $user_info[] = array (
         'DivId'     => 'info',
         'ImgName'   => $ImgName.': '.$messa,
         'ImgWidth'  => NULL,
         'ImgHeight' => NULL
      );
      return false;
   }
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
// ****************************************************************************
// *                       Выделить расширение в имени файла                  *
// ****************************************************************************
function get_file_extension($file_name)
{
   return substr(strrchr($file_name,'.'),1);
}
                                
// ******************************************************* ajaPicsSizes.php ***
