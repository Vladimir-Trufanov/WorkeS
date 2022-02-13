<?php
// PHP7/HTML5, EDGE/CHROME                           *** SignaMakeStamp.php ***

// ****************************************************************************
// * SignaPhoto                          Наложить подпись на файл изображения *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  10.07.2021
// Copyright © 2021 tve                              Посл.изменение: 13.02.2022

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
   // Определяем имя промежуточного файл штампа
   $PostFix='stamt';
   $PrefName=prown\MakeNumRID($imgDir,$PostFix,'png',true);
   $NameLoad=$PrefName.$PostFix;
   $ci_FileStamp=$imgDir.'/'.$NameLoad.'.'.'png';
   prown\ConsoleLog('$ci_FileStamp='.$ci_FileStamp);
   // Изменяем размеры штампа до заданной пропорции от основного изображения
   $mds=makeDestinationStamp($im,$wStamp,$hStamp,$wImg,$hImg,$c_FileImg,$c_FileStamp,$ci_FileStamp,$c_PerSizeImg,$c_MaintainProp);
   if ($mds==ajTransparentSuccess)
   {
      // $im - строковое представление измененного штампа, прозрачного
      // $wStamp - ширина штампа
      // $hStamp - высота штампа
      // $wImg - ширина изображения
      // $hImg - высота изображения
      prown\ConsoleLog('ajTransparentSuccess='.ajTransparentSuccess);
      // Строим изображение штампа (водяного знака)
      $stamp = @imagecreatefrompng($ci_FileStamp);
      if (!$stamp) ViewMess(ajStampNotBuilt);
      else
      {
         // Строим изображение для наложения подписи
         if (($FileExt=='gif')or($FileExt=='png'))
         {
            makeTransparentImg($im,$wImg,$hImg,$c_FileImg,$FileExt,$imgDir);
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
            // Расчитываем целевую точку (левый-верхний угол) в целевом изображении
            // для переноса подписи
            $mds=MakePointDesc($xDesc,$yDesc,$im,$stamp,$c_PointCorner,$c_PerMargeWidth,$c_PerMargeHight);
            if ($mds==ajStampPlaceDetermin)
            {
               // Копируем изображение штампа на фотографию с учетом смещения края    
               // и ширины фотографии и расчётом позиционирования штампа        
               ImageAndStamp($im,$stamp,$FileExt,$SiteProtocol,$xDesc,$yDesc,$c_FileProba,$imgDir,$urlDir);
            }
         }
      }
   }
}
// ****************************************************************************
// *    Расчитать целевую точку (левый-верхний угол) в целевом изображении    *
// *                             для переноса подписи                         *
// ****************************************************************************
function MakePointDesc(&$xDesc,&$yDesc,$im,$stamp,$c_PointCorner,$c_PerMargeWidth,$c_PerMargeHight)
{
   $Result=ajStampPlaceDetermin;
   // Определяем высоту и ширину изображения и штампа
   $imgx=imagesx($im);
   $imgy=imagesy($im);
   $sx=imagesx($stamp);
   $sy=imagesy($stamp);
   // Пересчитываем проценты смещения к точке привязки в пикселы
   $xOffset=$imgx*$c_PerMargeWidth/100;  // imagesx($im) -> 100%
   $yOffset=$imgy*$c_PerMargeHight/100;  // $xOffset     -> $c_PerMargeWidth
   // Рассчитываем целевую точку, если привязка к правому-нижнему углу
   if ($c_PointCorner==ohRightBottom)
   {
      $xDesc=$imgx-$sx-$xOffset;
      $yDesc=$imgy-$sy-$yOffset; 
   }
   // Рассчитываем целевую точку, если привязка к левому-верхнему углу
   if ($c_PointCorner==ohLeftTop)
   {
      $xDesc=$xOffset;
      $yDesc=$yOffset;  
   }
   // Рассчитываем целевую точку, если привязка к правому-верхнему углу
   if ($c_PointCorner==ohRightTop)
   {
      $xDesc=$imgx-$sx-$xOffset;  
      $yDesc=$yOffset;                  
   }
   // Рассчитываем целевую точку, если привязка к левому-нижнему углу
   if ($c_PointCorner==ohLeftBottom)
   {
      $xDesc=$xOffset;                  
      $yDesc=imagesy($im)-$sy-$yOffset;
   }
   // Контроллируем возможность размещения штамп на изображении 
   $mds=CtrlStampPlaceDetermin($imgx,$imgy,$sx,$sy,$xDesc,$yDesc);
   if ($mds<>ajPlaceIsPossible) $Result=$mds;
   return $Result;
}
// ****************************************************************************
// *         Определить возможность размещения штамп на изображении           *
// ****************************************************************************
function CtrlStampPlaceDetermin($imgx,$imgy,$sx,$sy,$xDesc,$yDesc)
{
   $Result=ajPlaceIsPossible;
   // "Штамп зашел за правый край изображения"
   if (($xDesc+$sx)>$imgx) ViewMess(ajStampBeyondRight);                                   
   // "Штамп зашел за верхний край изображения"
   else if ($yDesc<0) ViewMess(ajStampBeyondTop);                                   
   // "Штамп зашел за левый край изображения"
   else if ($xDesc<0) ViewMess(ajStampBeyondLeft);                                   
   // "Штамп зашел за нижний край изображения"
   else if (($yDesc+$sy)>$imgy) ViewMess(ajStampBeyondBottom);                                   
   return $Result;
}
// ****************************************************************************
// *   Скопировать изображение штампа на фотографию с учетом смещения края    *
// *        и ширины фотографии и расчётом позиционирования штампа            *
// ****************************************************************************
function ImageAndStamp($im,$stamp,$type,$SiteProtocol,$xDesc,$yDesc,$c_FileProba,$imgDir,$urlDir)
{
   // Заменяем URL-адрес на путь в файловой системе
   $Point=strpos($c_FileProba,$urlDir);
   if ($Point===false) ViewMess(ajNameFileNoMatchUrl);
   else
   {
      $Point=strlen($urlDir);
      $NameLoad=substr($c_FileProba,$Point);
      $nameimgp=$imgDir.$NameLoad;
      // Копируем изображения штампа на фотографию с помощью смещения края
      // и ширины фотографии для расчёта позиционирования штампа.
      imagecopy($im,$stamp,$xDesc,$yDesc,0,0,imagesx($stamp),imagesy($stamp));
      // Выводим изображение в файл и освобождаем память
      imagepng($im,$nameimgp);
      imagedestroy($im);
      imagedestroy($stamp);
      // Отмечаем, что на фотографию наложена свежая подпись
      //ViewMess(ajIsFreshStamp);
   }
}
// ****************************************************************************
// *   Сделать требуемое gif или png изображение прозрачным png-изображением  *
// *     (так как на 20/08/2021 tve не знает способа проверки прозрачности)   *
// ****************************************************************************
function makeTransparentImg(&$im,$wImg,$hImg,$c_FileImg,$FileExt,$imgDir)
{
   $im=null;
   // Изначально считаем, преобразование к прозрачному виду было успешным
   $Result=ajTransparentSuccess;
   // Выдаем сообщение, если файл не в заданном формате
   if (($FileExt<>'gif')and($FileExt<>'png')) 
   { 
     // Если недопустимое расширение файла, то возвращаем сообщение
     $Result=ajInvalidTransparent; ViewMess(ajInvalidTransparent);
   } 
   else
   {
      // Выбираем изображение
      if ($FileExt=='gif') $source_resource=@imagecreatefromgif($c_FileImg);
      else $source_resource=@imagecreatefrompng($c_FileImg);
      // Создаем новое изображение
      $destination_resource=@imagecreatetruecolor($wImg,$hImg);
      // Отключаем режим сопряжения цветов
      imagealphablending($destination_resource, false);
      // Включаем сохранение альфа канала
      imagesavealpha($destination_resource, true);
      // Копируем изображение
      imagecopyresampled($destination_resource,$source_resource,0,0,0,0,$wImg,$hImg,$wImg,$hImg);
      // Сохраняем изображение в промежуточный файл png
      $PostFix='probt';
      $PrefName=prown\MakeNumRID($imgDir,$PostFix,'png',true);
      $NameLoad=$PrefName.$PostFix;
      $destination_path=$imgDir.'/'.$NameLoad.'.'.'png';
      prown\ConsoleLog('$destination_path='.$destination_path);
      imagepng($destination_resource, $destination_path);
      // Извлекаем уже прозрачное изображение
      $im = @imagecreatefrompng($destination_path);
      return $Result;
   }
}
// ****************************************************************************
// *      Изменить размеры штампа (водяного знака) до заданной пропорции      *
// *                             от основного изображения                     *
// ****************************************************************************
// $im - строковое представление измененного штампа, прозрачного
// $wStamp - ширина штампа
// $hStamp - высота штампа
// $wImg - ширина изображения
// $hImg - высота изображения
function makeDestinationStamp(&$im,&$wStamp,&$hStamp,&$wImg,&$hImg,$c_FileImg,$c_StampImg,$destination_path,$c_PerSizeImg,$c_MaintainProp)
{
   $im=null;
   // Изначально считаем, преобразование к прозрачному виду было успешным
   $Result=ajTransparentSuccess;
   // Определяем исходные размеры штампа
   $size = getimagesize($c_StampImg);
   $oldwidth=$size[0];                     
   $oldheight=$size[1];  
   // Определяем размеры исходного изображения
   $size=getimagesize($c_FileImg);
   $wImg=$size[0];                      
   $hImg=$size[1];                     
   // Определяем размеры штампа для подписания
   if ($c_MaintainProp==ohMaintainFalse) 
   {
      $wStamp=$wImg*$c_PerSizeImg/100;        // old --> 100%
      $hStamp=$hImg*$c_PerSizeImg/100;        // x   --> 20%
   }
   else
   {
      // Определяем ширину штампа
      $wStamp=$wImg*$c_PerSizeImg/100;  
      // Определяем высоту штампа             // $oldheight --> $oldwidth
      $hStamp=$oldheight*$wStamp/$oldwidth;   // x          --> $wStamp
   }
   // Выбираем изображение
   $source_resource=@imagecreatefrompng($c_StampImg);
   // Создаем пустое изображение в заданных размерах
   $destination_resource=@imagecreatetruecolor($wStamp,$hStamp);
   // Отключаем режим сопряжения цветов
   imagealphablending($destination_resource,false);
   // Включаем сохранение альфа канала
   imagesavealpha($destination_resource,true);
   // Копируем изображение
   imagecopyresampled($destination_resource,$source_resource,0,0,0,0, 
      $wStamp,$hStamp,$oldwidth,$oldheight);
   // Сохраняем изображение в промежуточный файл png
   if (!imagepng($destination_resource, $destination_path)) 
   {
      $Result=ajFailedResizedStamp; ViewMess(ajFailedResizedStamp);
      // Извлекаем уже прозрачное изображение
      $im = @imagecreatefrompng($destination_path);
   }
   return $Result;
}
// ***************************************************** SignaMakeStamp.php ***
