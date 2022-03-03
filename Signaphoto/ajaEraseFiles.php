<?php
// PHP7/HTML5, EDGE/CHROME                            *** ajaEraseFiles.php ***

// ****************************************************************************
// * SignaPhoto             Отработать ajax-запрос для удаления старых файлов *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  25.11.2021
// Copyright © 2021 tve                              Посл.изменение: 03.03.2022

// Инициируем рабочее пространство страницы

require_once $_SERVER['DOCUMENT_ROOT'].'/iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();
$SiteRoot   = $_WORKSPACE[wsSiteRoot];      // Корневой каталог сайта
$SiteAbove  = $_WORKSPACE[wsSiteAbove];     // Надсайтовый каталог
$SiteHost   = $_WORKSPACE[wsSiteHost];      // Каталог хостинга
$SiteDevice = $_WORKSPACE[wsSiteDevice];    // 'Computer' | 'Mobile' | 'Tablet'
$SiteProtocol=$_WORKSPACE[wsSiteProtocol];  //  => isProtocol() 

// Подключаем совместные определения(переменные) для модулей PHP и JS
require_once 'SignaPhotoDef.php';
// Подключаем файлы библиотеки прикладных модулей:
require_once $SiteHost.'/TPhpPrown/TPhpPrown'."/CommonPrown.php";
// Подключаем стартер сессии страницы и регистратор пользовательских данных
require_once $SiteHost.'/TPhpTools/TPhpTools'."/TPageStarter/PageStarterClass.php";

set_error_handler("EraseFilesHandler");

// Генерируем отладочную ошибку
// $i=0;
// $j=5/$i;

$date=date('Y-m-d'); // date('r'); date("Y-m-d H:i:s");
$text='Удалены старые файлы!';
// ДЛЯ ОТЛАДЫ: Запускаем стартер сессии страницы и регистратор пользовательских данных
// $oEraseFilesStarter = new PageStarter('EraseFiles','SignaPhoto');
// $oEraseFilesStarter->Message($date.' '.$text.'='.imgDir.'='.sceDir.chr(10));

// Вытаскиваем упорядоченный список файлов каталога
$files1=scandir(imgDir);
   
// Передаем данные в формате JSON
// (если нет передачи данных, то по аякс-запросу вернется ошибка)
$user_info = array(); 
$user_info[] = array (
   'date' => $date,
   'text' => $text
);
restore_error_handler();
echo json_encode($user_info);
// ****************************************************************************
// *                 Обыграть ошибки удаления старых файлов                   *
// ****************************************************************************
function EraseFilesHandler($errno,$errstr,$errfile,$errline)
{
   $modul='EraseFilesHandler';
   \prown\putErrorInfo($modul,$errno,$errstr,$errfile,
      $errline,sceDir."/SignaPhoto.txt");
}
// ****************************************************** ajaEraseFiles.php ***
