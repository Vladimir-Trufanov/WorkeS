<?php
// PHP7/HTML5, EDGE/CHROME                             *** ajaPicsSizes.php ***

// ****************************************************************************
// * SignaPhoto                  Передать размеры трех изображений через аякс *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  25.11.2021
// Copyright © 2021 tve                              Посл.изменение: 25.11.2021

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
   /*
   // Подключаем файлы библиотеки прикладных модулей:
   $TPhpPrown=$SiteHost.'/TPhpPrown';
   //require_once $TPhpPrown."/TPhpPrown/CommonPrown.php";
   require_once $TPhpPrown."/TPhpPrown/MakeCookie.php";
   // Подключаем межязыковые определения
   require_once 'SignaPhotoDef.php';
   */
   
   //echo('prown\makeLabel(ajSuccessfully)');
   
   $user_info = array();      // создаем массив с данными 
   
   
   foreach($_GET as $key => $value)
   {

    $user_info[] = array (
      'fio' => $key,
      'birthday' => $value
   );
   }
  
   
   

   $user_info[] = array (
      'fio' => 'Иванов Сергей',
      'birthday' => '09.03.1975'
   );
   $user_info[] = array (
      'fio' => 'Петров Алексей',
      'birthday' => '18.09.1983'
   );
   echo json_encode($user_info);
   
}
catch (E_EXCEPTION $e) 
{
   DoorTryPage($e);
}

// ******************************************************* ajaPicsSizes.php ***
