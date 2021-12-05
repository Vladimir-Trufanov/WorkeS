<?php
// PHP7/HTML5, EDGE/CHROME                             *** ajaMoveFile.php ***

// ****************************************************************************
// * SignaPhoto                  Передать размеры трех изображений через аякс *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  25.11.2021
// Copyright © 2021 tve                              Посл.изменение: 26.11.2021


$name = $_FILES['loadfile']['name'];  


// Подключаем межязыковые (PHP-JScript) определения
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
  // $dir = '../temp/';  
   //$name = basename($_FILES['loadfile']['name']);  
   /*
   $file = $dir . $name;  
   $success = move_uploaded_file($_FILES['loadfile']['tmp_name'], $file);  
   */



   // Передаем данные в формате JSON
   // (если нет передачи данных, то по аякс-запросу вернется ошибка)
   $user_info = array(); 
   $user_info[] = array (
         'DivId'     => 15,
         'ImgName'   => '$ImgName'
   );
   echo json_encode($user_info);
}
catch (E_EXCEPTION $e) 
{
   DoorTryPage($e);
}
                                
// ******************************************************* ajaMoveFile.php ***
