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
   // Определяем имя промежуточного файл штампа
   $imgDir=$_SERVER['DOCUMENT_ROOT'].'/Temp'; 
   $NameLoad=prown\MakeRID().'stamt';
   $ci_FileStamp=$imgDir.'/'.$NameLoad.'.'.'png';
   // Изменяем размеры штампа до заданной пропорции от основного изображения
   if (makeDestinationStamp($im,$c_FileImg,$c_FileStamp,$ci_FileStamp)==ajTransparentSuccess)
   {
      // Строим изображение штампа (водяного знака)
      $stamp = @imagecreatefrompng($ci_FileStamp);
      if (!$stamp) ViewMess(ajStampNotBuilt);
      else
      {
         // Строим изображение для наложения подписи
         if (($FileExt=='gif')or($FileExt=='png'))
         {
            makeTransparentImg($im,$c_FileImg,$FileExt);
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
            /*
            // Устанавливаем поля для штампа
            // от правого нижнего угла
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
            $c_FileProba=prown\MakeCookie('FileProba');
            imagepng($im,$c_FileProba);
            imagedestroy($im);
            imagedestroy($stamp);
            //unlink($ci_FileStamp);
            // Отмечаем, что на фотографию наложена свежая подпись
            ViewMess(ajIsFreshStamp);
            */
         }
      }
   }
}
// ****************************************************************************
// *   Скопировать изображение штампа на фотографию с учетом смещения края    *
// *        и ширины фотографии и расчётом позиционирования штампа            *
// ****************************************************************************
function ImageAndStamp($im,$stamp,$type,$SiteProtocol)
{
   // Определяем имя файла изображения со штампом и его url-адреса
   $imgDir=$_SERVER['DOCUMENT_ROOT'].'/Temp'; 
   $urlDir=$SiteProtocol.'://'.$_SERVER['HTTP_HOST'].'/Temp'; 
   $NameLoad=prown\MakeRID().'proba';
   $localimgp=$urlDir.'/'.$NameLoad.'.'.$type;
   $nameimgp=$imgDir.'/'.$NameLoad.'.'.$type;
   $c_FileProba=prown\MakeCookie('FileProba');
   //prown\ConsoleLog('$nameimgp='.$nameimgp);
   //prown\ConsoleLog('$localimgp='.$localimgp);
   //prown\ConsoleLog('$c_FileProba='.$c_FileProba);
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
function makeTransparentImg(&$im,$c_FileImg,$FileExt)
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
function makeDestinationStamp(&$im,$c_FileImg,$c_StampImg,$destination_path)
{
   $im=null;
   // Изначально считаем, преобразование к прозрачному виду было успешным
   $Result=ajTransparentSuccess;
   // Определяем размеры штампа для подписания
   $c_PerSizeImg=prown\MakeCookie('PerSizeImg'); 
   $size = getimagesize($c_FileImg);
   $oldwidth=$size[0];                       // old --> 100%
   $newwidth=$oldwidth*$c_PerSizeImg/100;    // x   --> 20%
   $oldheight=$size[1];                      //
   $newheight=$oldheight*$c_PerSizeImg/100;  // new = old*20/100
   // Определяем исходные размеры штампа
   $size = getimagesize($c_StampImg);
   $oldwidth=$size[0];                     
   $oldheight=$size[1];                   
   // Выбираем изображение
   $source_resource=@imagecreatefrompng($c_StampImg);
   // Создаем пустое изображение в заданных размерах
   $destination_resource=@imagecreatetruecolor($newwidth,$newheight);
   // Отключаем режим сопряжения цветов
   imagealphablending($destination_resource, false);
   // Включаем сохранение альфа канала
   imagesavealpha($destination_resource, true);
   // Копируем изображение
   imagecopyresampled($destination_resource, $source_resource, 0, 0, 0, 0, 
      $newwidth, $newheight, $oldwidth, $oldheight);
   // Сохраняем изображение в промежуточный файл png
   if (!imagepng($destination_resource, $destination_path)) 
   {
      $Result='ajFailedResizedStamp'; ViewMess(ajFailedResizedStamp);
      // Извлекаем уже прозрачное изображение
      $im = @imagecreatefrompng($destination_path);
   }
   return $Result;
}

/*
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
