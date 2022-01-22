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
// ****************************************************************************
// *    Преодолеть кэширование файла в браузере через именование файла        *
// ****************************************************************************
function RemCash($url_name,$file_name,$file_ext)
// Так как имена загружаемым файлам для текущего пользователя выполняются
// с помощью prown\MakeRID(), то в случае загрузки файла с одним и тем же 
// расширением для показа может вызываться файл из кэша, а не тот, который
// был загружен. Для того, чтобы обойти кэширование, в конце имени файла 
// функция добавляет поочередно символы 'F','A','X'.
{
   prown\ConsoleLog('***'.$url_name.'.'.$file_ext.'***');
   prown\ConsoleLog('***'.$file_name.'.'.$file_ext.'***');
   // Если есть файл с постфиксом 'F', удаляем его и возвращаем имя с 'A'
   if (is_file($file_name.'F.'.$file_ext))
   {
      //unlink($file_name.'F.'.$file_ext);
      $Result=$file_name.'A.'.$file_ext;
   }
   // Если есть файл с постфиксом 'A', удаляем его и возвращаем имя с 'X'
   else if (is_file($file_name.'A.'.$file_ext))
   {
      //unlink($file_name.'A.'.$file_ext);
      $Result=$file_name.'X.'.$file_ext;
   }
   // Если есть файл с постфиксом 'X', удаляем его и возвращаем имя с 'F'
   else if (is_file($file_name.'X.'.$file_ext))
   {
      //unlink($file_name.'X.'.$file_ext);
      $Result=$file_name.'F.'.$file_ext;
   }
   // Иначе удаляем заданный файл и возвращаем его имя
   else 
   {
      //unlink('C:/Webservers/Exploration/Temp/Win10Ch97De--1img.jpeg');
      //             'http://localhost:82/Temp/Win10Ch97De--1img.jpeg'
      unlink($file_name.'.'.$file_ext);
      $Result=$url_name.'F.'.$file_ext;
      
   }
   return $Result;
   
}
                               
// ****************************************************** SignaPhotoImg.php ***
