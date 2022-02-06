<?php
// PHP7/HTML5, EDGE/CHROME                           *** SignaMakeStamp.php ***

// ****************************************************************************
// * SignaPhoto                          Наложить подпись на файл изображения *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  10.07.2021
// Copyright © 2021 tve                              Посл.изменение: 06.02.2022

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
   $imgDir=$_SERVER['DOCUMENT_ROOT'].'/Temp'; 
   $NameLoad=prown\MakeRID().'stamt';
   $ci_FileStamp=$imgDir.'/'.$NameLoad.'.'.'png';
   // Изменяем размеры штампа до заданной пропорции от основного изображения
   $mds=makeDestinationStamp($im,$wStamp,$hStamp,$wImg,$hImg,$c_FileImg,$c_FileStamp,$ci_FileStamp);
   if ($mds==ajTransparentSuccess)
   {
      // Строим изображение штампа (водяного знака)
      $stamp = @imagecreatefrompng($ci_FileStamp);
      if (!$stamp) ViewMess(ajStampNotBuilt);
      else
      {
         // Строим изображение для наложения подписи
         if (($FileExt=='gif')or($FileExt=='png'))
         {
            makeTransparentImg($im,$wImg,$hImg,$c_FileImg,$FileExt);
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
            // Копируем изображение штампа на фотографию с учетом смещения края    
            // и ширины фотографии и расчётом позиционирования штампа        
            ImageAndStamp($im,$stamp,$FileExt,$SiteProtocol);
         }
      }
   }
}
// ****************************************************************************
// *   Скопировать изображение штампа на фотографию с учетом смещения края    *
// *        и ширины фотографии и расчётом позиционирования штампа            *
// ****************************************************************************
// Расчитать величины смещения по горизонтали от точки привязки
function MakeOffsets(&$xOffset,&$yOffset)
{
   // Определяем проценты смещения от точки привязки
   $c_PerMargeWidth=prown\MakeCookie('PerMargeWidth');
   $c_PerMargeHight=prown\MakeCookie('PerMargeHight');
}
// Расчитать целевую точку (левый-верхний угол) в целевом изображении
// для переноса подписи
function MakePointDesc(&$xDesc,&$yDesc,$im,$stamp)
{
   // Определяем точку привязки подписи
   $c_PointCorner=prown\MakeCookie('PointCorner');
   // Определяем высоту/ширину штампа
   $sx = imagesx($stamp);
   $sy = imagesy($stamp);
   // Рассчитываем целевую точку, если привязка к правому-нижнему углу
   if ($c_PointCorner==ohRightBottom)
   {
      //prown\ConsoleLog('$c_PointCorner_getPointDesc='.$c_PointCorner);
      //   imagesx($im)-$sx-$marge_right,
      //   imagesy($im)-$sy-$marge_bottom
   }
}
// Скопировать изображение штампа на фотографию с учетом смещения края    
// и ширины фотографии и расчётом позиционирования штампа     
function ImageAndStamp($im,$stamp,$type,$SiteProtocol)
{
   // Определяем имя файла изображения со штампом и его url-адреса
   $imgDir=$_SERVER['DOCUMENT_ROOT'].'/Temp'; 
   $urlDir=$SiteProtocol.'://'.$_SERVER['HTTP_HOST'].'/Temp'; 
   $NameLoad=prown\MakeRID().'proba';
   $localimgp=$urlDir.'/'.$NameLoad.'.'.$type;
   $nameimgp=$imgDir.'/'.$NameLoad.'.'.$type;
   $c_FileProba=prown\MakeCookie('FileProba');
   // Если имя файла изображения со штампом не соответствует url-адресу,
   // то выдаем сообщение
   if ($localimgp<>$c_FileProba) ViewMess(ajNameFileNoMatchUrl);
   // Иначе наносим изображение штампа на фотографию 
   else
   {
      // Устанавливаем поля для штампа
      // от правого нижнего угла
      $marge_right = 10;
      $marge_bottom = 10;
      // Определяем высоту/ширину штампа
      $sx = imagesx($stamp);
      $sy = imagesy($stamp);
      // Расчитываем целевую точку (левый-верхний угол) в целевом изображении
      // для переноса подписи
      MakePointDesc($xDesc,$yDesc,$im,$stamp);
      // Копируем изображения штампа на фотографию с помощью смещения края
      // и ширины фотографии для расчёта позиционирования штампа.
      imagecopy($im,$stamp,
         imagesx($im)-$sx-$marge_right,
         imagesy($im)-$sy-$marge_bottom,0,0,
         imagesx($stamp),imagesy($stamp));
      // Выводим изображение в файл и освобождаем память
      imagepng($im,$nameimgp);
      imagedestroy($im);
      imagedestroy($stamp);
      //unlink($nameimgp);
      // Отмечаем, что на фотографию наложена свежая подпись
      ViewMess(ajIsFreshStamp);
   }
}
// ****************************************************************************
// *   Сделать требуемое gif или png изображение прозрачным png-изображением  *
// *     (так как на 20/08/2021 tve не знает способа проверки прозрачности)   *
// ****************************************************************************
function makeTransparentImg(&$im,$wImg,$hImg,$c_FileImg,$FileExt)
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
      $imgDir=$_SERVER['DOCUMENT_ROOT'].'/Temp'; 
      $NameLoad=prown\MakeRID().'probt';
      $destination_path=$imgDir.'/'.$NameLoad.'.'.'png';
      imagepng($destination_resource, $destination_path);
      // Извлекаем уже прозрачное изображение
      $im = @imagecreatefrompng($destination_path);
      //unlink($destination_path);
      return $Result;
   }
}
// ****************************************************************************
// *      Изменить размеры штампа (водяного знака) до заданной пропорции      *
// *                             от основного изображения                     *
// ****************************************************************************
function makeDestinationStamp(&$im,&$wStamp,&$hStamp,&$wImg,&$hImg,$c_FileImg,$c_StampImg,$destination_path)
{
   $im=null;
   // Изначально считаем, преобразование к прозрачному виду было успешным
   $Result=ajTransparentSuccess;
   // Определяем размеры штампа для подписания
   $c_PerSizeImg=prown\MakeCookie('PerSizeImg'); 
   $size=getimagesize($c_FileImg);
   $wImg=$size[0];                       // old --> 100%
   $wStamp=$wImg*$c_PerSizeImg/100;      // x   --> 20%
   $hImg=$size[1];                       //
   $hStamp=$hImg*$c_PerSizeImg/100;      // new = old*20/100
   // Определяем исходные размеры штампа
   $size = getimagesize($c_StampImg);
   $oldwidth=$size[0];                     
   $oldheight=$size[1];                   
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
      $Result='ajFailedResizedStamp'; ViewMess(ajFailedResizedStamp);
      // Извлекаем уже прозрачное изображение
      $im = @imagecreatefrompng($destination_path);
   }
   return $Result;
}
// ***************************************************** SignaMakeStamp.php ***
