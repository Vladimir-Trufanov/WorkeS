<?php
// PHP7/HTML5, EDGE/CHROME                           *** SignaMakeStamp.php ***

// ****************************************************************************
// * SignaPhoto                          Наложить подпись на файл изображения *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  10.07.2021
// Copyright © 2021 tve                              Посл.изменение: 26.01.2022

// Определяем расширение имени файла изображения
$FileExt=get_file_extension($c_FileImg);
// Если недопустимое расширение файла, то возвращаем сообщение
if (($FileExt<>'gif')and($FileExt<>'jpeg')and($FileExt<>'jpg')and($FileExt<>'png')) 
{ 
   ViewMess(ajInvalidBuilt);
}
// Проверяем расширение файла подписи, он всегда быть должен "*.png"
// (c прозрачным фоном)
else if (get_file_extension($c_FileStamp)<>'png')
{
   ViewMess(ajMustTransparentPng);
}
else
{
   //prown\ConsoleLog('$FileExt='.$FileExt);
   
   

   // Строим изображение штампа (водяного знака)
   $stamp = @imagecreatefrompng($c_FileStamp);
   if (!$stamp) ViewMess(ajStampNotBuilt);
   else
   {
      // Строим изображение для наложения подписи
      if (($FileExt=='gif')or($FileExt=='png'))
      {
         ViewMess(makeTransparentImg($im,$c_FileImg,$FileExt));
      }
      elseif (($FileExt=='jpeg')or($FileExt=='jpg'))
      {
         $im = @imagecreatefromjpeg($c_FileImg);
      }
      // 
      if (!$im) 
      {
         imagedestroy($stamp);
         ViewMess(ajImageNotBuilt);
      }
      else
      {
         // Устанавливаем поля для штампа
         $marge_right = 10;
         $marge_bottom = 10;
         // Определяем высоту/ширину штампа
         $sx = imagesx($stamp);
         $sy = imagesy($stamp);
         // Копируем изображения штампа на фотографию с помощью смещения края
         // и ширины фотографии для расчёта позиционирования штампа.
         imagecopy($im,$stamp,
            imagesx($im)-$sx-$marge_right,
            imagesy($im)-$sy-$marge_bottom,0,0,
            imagesx($stamp),imagesy($stamp));
         // Выводим изображение в файл и освобождаем память
         $fileproba='images/proba.png';
         imagepng($im,$fileproba);
         imagedestroy($im);
         imagedestroy($stamp);
         // Запоминаем в кукисе имя файла фотографии с подписью
          $c_FileProba=prown\MakeCookie('FileProba',$fileproba,tStr);
          // Отмечаем, что на фотографию наложена свежая подпись
          ViewMess(ajIsFreshStamp);
      }
   }
}
// ****************************************************************************
// *   Сделать требуемое gif или png изображение прозрачным png-изображением  *
// *     (так как на 20/08/2021 tve не знает способа проверки прозрачности)   *
// ****************************************************************************
function makeTransparentImg(&$im,$c_FileImg,$FileExt)
{
   $im=null;
   // Изначально считаем, преобразование к прозрачному виду было успешным
   $Result=ajTransparentSuccess;
   // Выдаем сообщение, если файл не в заданном формате
   if (($FileExt<>'gif')and($FileExt<>'png')) 
   { 
     // Если недопустимое расширение файла, то возвращаем сообщение
     $Result=ajInvalidTransparent;
   } 
   else
   {
      // Определяем размеры изображения
      $size = getimagesize($c_FileImg); 
      $newwidth=$size[0];  $oldwidth=$newwidth;
      $newheight=$size[1]; $oldheight=$newheight;
      // Выбираем изображение
      if ($FileExt=='gif') $source_resource=@imagecreatefromgif($c_FileImg);
      else $source_resource=@imagecreatefrompng($c_FileImg);
      // Создаем новое изображение
      $destination_resource=@imagecreatetruecolor($newwidth,$newheight);
      // Отключаем режим сопряжения цветов
      imagealphablending($destination_resource, false);
      // Включаем сохранение альфа канала
      imagesavealpha($destination_resource, true);
      // Копируем изображение
      imagecopyresampled($destination_resource, $source_resource, 0, 0, 0, 0, 
         $newwidth, $newheight, $oldwidth, $oldheight);
      // Сохраняем изображение в промежуточный файл png
      $destination_path='images/tempimg.png';
      imagepng($destination_resource, $destination_path);
      // Извлекаем уже прозрачное изображение
      $im = @imagecreatefrompng($destination_path);
      return $Result;
   }
}
// ****************************************************************************
// *   Сделать требуемое gif или png изображение прозрачным png-изображением  *
// *     (так как на 20/08/2021 tve не знает способа проверки прозрачности)   *
// ****************************************************************************
function makeDestinationStamp(&$im,$c_FileImg,$FileExt,$c_StampImg)
{
   $im=null;
   // Изначально считаем, преобразование к прозрачному виду было успешным
   $Result=ajTransparentSuccess;
   // Выдаем сообщение, если файл не в заданном формате
   if (($FileExt<>'gif')and($FileExt<>'png')) 
   { 
     // Если недопустимое расширение файла, то возвращаем сообщение
     $Result=ajInvalidTransparent;
   } 
   else
   {
      // Определяем размеры штампа для подписания
      $size = getimagesize($c_FileImg);
      $oldwidth=$size[0];                      // old --> 100%
      $newwidth=$oldwidth*20/100;              // x   --> 20%
      $oldheight=$size[1];                     //
      $newheight=$oldheight*20/100;            // new = old*20/100
      //$newwidth=$size[0];  $oldwidth=$newwidth;
      //$newheight=$size[1]; $oldheight=$newheight;
      // Определяем старые размеры штампа для подписания
      $size = getimagesize($c_StampImg);
      $oldwidth=$size[0];                     
      $oldheight=$size[1];                   
      // Выбираем изображение
      //if ($FileExt=='gif') $source_resource=@imagecreatefromgif($c_FileImg);
      //else $source_resource=@imagecreatefrompng($c_FileImg);
      $source_resource=@imagecreatefrompng($c_StampImg);
      // Создаем новое изображение
      $destination_resource=@imagecreatetruecolor($newwidth,$newheight);
      // Отключаем режим сопряжения цветов
      imagealphablending($destination_resource, false);
      // Включаем сохранение альфа канала
      imagesavealpha($destination_resource, true);
      // Копируем изображение
      imagecopyresampled($destination_resource, $source_resource, 0, 0, 0, 0, 
         $newwidth, $newheight, $oldwidth, $oldheight);
      // Сохраняем изображение в промежуточный файл png
      $destination_path='images/tempstamp.png';
      imagepng($destination_resource, $destination_path);
      // Извлекаем уже прозрачное изображение
      $im = @imagecreatefrompng($destination_path);
      return $Result;
   }
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
require_once $SiteHost."/TDoorTryer/DoorTryerPage.php";
try 
{
   // Подключаем файлы библиотеки прикладных модулей:
   $TPhpPrown=$SiteHost.'/TPhpPrown';
   //require_once $TPhpPrown."/TPhpPrown/CommonPrown.php";
   require_once $TPhpPrown."/TPhpPrown/MakeCookie.php";
   // Подключаем межязыковые определения
   require_once 'SignaPhotoDef.php';
   // Определяем имена файлов для выполнения подписания
   $c_FileImg=prown\MakeCookie('FileImg');
   $c_FileStamp=prown\MakeCookie('FileStamp');
   $c_FileProba=prown\MakeCookie('FileProba');
   //
   //prown\ConsoleLog('MakeStamp: '.$c_FileImg); 
   //
   // Накладываем подпись на изображение, получаем сообщение результата работы
   $MakeStamp=ImgMakeStamp($c_FileImg,$c_FileStamp,$c_FileProba);
   // Помечаем и передаем сообщение на страницу в браузере
   echo(prown\makeLabel($MakeStamp));  
}
catch (E_EXCEPTION $e) 
{
   DoorTryPage($e);
}
// ****************************************************************************
// *                     Наложить подпись на файл изображения                 *
// ****************************************************************************
function ImgMakeStamp($c_FileImg,$c_FileStamp,&$c_FileProba)
{
   // Определяем расширение имени файла изображения
   $FileExt=get_file_extension($c_FileImg);
   if (($FileExt<>'gif')and($FileExt<>'jpeg')and($FileExt<>'jpg')and($FileExt<>'png')) 
   { 
     // Если недопустимое расширение файла, то возвращаем сообщение
     $Result=ajInvalidBuilt;
   } 
   else
   {
      // Строим изображение штампа (водяного знака)
      //$stamp = @imagecreatefrompng('images/istamp.png');
      $stamp = @imagecreatefrompng($c_FileStamp);
      if (!$stamp) $Result=ajStampNotBuilt;
      else
      {
         // Строим изображение для наложения подписи
         if (($FileExt=='gif')or($FileExt=='png'))
         {
            $Result=makeTransparentImg($im,$c_FileImg,$FileExt);
         }
         elseif (($FileExt=='jpeg')or($FileExt=='jpg'))
         {
            $im = @imagecreatefromjpeg($c_FileImg);
         }
         // 
         if (!$im) 
         {
            imagedestroy($stamp);
            $Result=ajImageNotBuilt;
         }
         else
         {
            // Устанавливаем поля для штампа
            $marge_right = 10;
            $marge_bottom = 10;
            // Определяем высоту/ширину штампа
            $sx = imagesx($stamp);
            $sy = imagesy($stamp);
            // Копируем изображения штампа на фотографию с помощью смещения края
            // и ширины фотографии для расчёта позиционирования штампа.
            imagecopy($im,$stamp,
               imagesx($im)-$sx-$marge_right,
               imagesy($im)-$sy-$marge_bottom,0,0,
               imagesx($stamp),imagesy($stamp));
            // Выводим изображение в файл и освобождаем память
            $fileproba='images/proba.png';
            imagepng($im,$fileproba);
            imagedestroy($im);
            imagedestroy($stamp);
            // Запоминаем в кукисе имя файла фотографии с подписью
            $c_FileProba=prown\MakeCookie('FileProba',$fileproba,tStr);
            // Отмечаем, что на фотографию наложена свежая подпись
            $Result=ajIsFreshStamp;
         }
      }
   }
   return $Result;
}
*/
// ***************************************************** SignaMakeStamp.php ***
