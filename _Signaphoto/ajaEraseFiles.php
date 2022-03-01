<?php
// PHP7/HTML5, EDGE/CHROME                            *** ajaEraseFiles.php ***

// ****************************************************************************
// * SignaPhoto                  Передать размеры трех изображений через аякс *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  25.11.2021
// Copyright © 2021 tve                              Посл.изменение: 26.11.2021

// Инициируем рабочее пространство страницы
require_once $_SERVER['DOCUMENT_ROOT'].'/iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();
$SiteRoot   = $_WORKSPACE[wsSiteRoot];    // Корневой каталог сайта
$SiteAbove  = $_WORKSPACE[wsSiteAbove];   // Надсайтовый каталог
$SiteHost   = $_WORKSPACE[wsSiteHost];    // Каталог хостинга
$SiteDevice = $_WORKSPACE[wsSiteDevice];  // 'Computer' | 'Mobile' | 'Tablet'
// Подключаем стартер сессии страницы и регистратор пользовательских данных
require_once $SiteHost.'/TPhpTools/TPhpTools'."/TPageStarter/PageStarterClass.php";
// Подключаем сайт сбора сообщений об ошибках/исключениях и формирования 
// страницы с выводом сообщений, а также комментариев для PHP5-PHP7
require_once $SiteHost."/TDoorTryer/DoorTryerPage.php";
try 
{
   // Запускаем стартер сессии страницы и регистратор пользовательских данных
   $oEraseFilesStarter = new PageStarter('EraseFiles','SignaPhoto');
   $oEraseFilesStarter->Message('Текст сообщения \r\n');

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
// ****************************************************** ajaEraseFiles.php ***
