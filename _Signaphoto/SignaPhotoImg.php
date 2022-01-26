<?php
// PHP7/HTML5, EDGE/CHROME                            *** SignaPhotoImg.php ***

// ****************************************************************************
// * SignaPhoto               Блок функций подготовки и обработки изображений *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  25.11.2021
// Copyright © 2021 tve                              Посл.изменение: 22.01.2022

// Подключаем межязыковые (PHP-JScript) определения
require_once 'SignaPhotoDef.php';

// ****************************************************************************
// *     Разместить изображение по центру дива: cDiv - идентификатор дива,    *
// *                   cImg - идентификатор изображения,                      *
// *  wImg - реальная ширина изображения, hImg - реальная высота изображения  *
// *        mAligne - первичное выравнивание ('по ширине','по высоте'),       *
// *    perWidth - процент ширины изображения от ширины дива (или высоты),    *
// *
// ****************************************************************************
function MakeImgOnDiv($cDiv,$cImg,$c_FileImg,$perWidth)
{
   // Определяем реальную ширину и высоту изображения
   $a=getimagesize($c_FileImg);
   $wImg=$a[0]; $hImg=$a[1];
   
   ?> <script>
   cDiv="<?php echo $cDiv; ?>";
   cImg="<?php echo $cImg; ?>";
   wImg="<?php echo $wImg; ?>";
   hImg="<?php echo $hImg; ?>";
   perWidth="<?php echo $perWidth; ?>";
   // Определяем способ выравнивания изображения диву
   // ('по ширине','по высоте')
   alignPhoto=getAlignImg(cDiv,cImg,wImg,hImg);
   // Расчитываем выравнивание и устанавливаем CSS
   aCalcPicOnDiv=CalcPicOnDiv(cDiv,cImg,wImg,hImg,alignPhoto,perWidth)
   $("#"+cImg).css("width",String(aCalcPicOnDiv.widthImg)+'px');
   $("#"+cImg).css("height",String(aCalcPicOnDiv.heightImg)+'px');
   $("#"+cImg).css("margin-left",String(aCalcPicOnDiv.nLeft)+'px');
   $("#"+cImg).css("margin-top",String(aCalcPicOnDiv.nTop)+'px');
</script> <?php
}
/*
// ****************************************************************************
// *  Заполнить массив данными об изображении для размещения в заданном окне, *
// *     если определить данные не получается, то в этом массиве указать      *
// *   сообщение для вывода в специальном окне, указанном константой ohInfo   *
// ****************************************************************************
function FillArrayOne($DivId,$IdImg,$ImgName)
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
         'IdImg'     => $IdImg,
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
         'IdImg'     => NULL,
         'ImgWidth'  => NULL,
         'ImgHeight' => NULL
      );
   }
   return $user_info;
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
*/
// ****************************************************************************
// *                       Выделить расширение в имени файла                  *
// ****************************************************************************
function get_file_extension($file_name)
{
   return substr(strrchr($file_name,'.'),1);
}
// ****************************************************************************
// *        Вывести информационное сообщение или сообщение об ошибке          *
// ****************************************************************************
function ViewMess($Mess)
{
   $_Prefix='SignaPhoto';
   prown\Alert('$_Prefix'.': '.$Mess);
}
// ****************************************************** SignaPhotoImg.php ***
