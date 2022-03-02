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

//
//$i=0;
//$j=5/$i;
//

$date=date('Y-m-d');  // date('r'); date("Y-m-d H:i:s");
$text='Удалены старые файлы!';
// Запускаем стартер сессии страницы и регистратор пользовательских данных
$oEraseFilesStarter = new PageStarter('EraseFiles','SignaPhoto');
// Вытаскиваем упорядоченный список файлов каталога
//$files1=scandir(imgDir.'x');
   
$oEraseFilesStarter->Message($date.' '.$text.'='.imgDir.'='.sceDir.chr(10));
// Передаем данные в формате JSON
// (если нет передачи данных, то по аякс-запросу вернется ошибка)
$user_info = array(); 
$user_info[] = array (
   'date' => $date,
   'text' => $text
);
echo json_encode($user_info);
restore_error_handler();

// ****************************************************************************
// *               Обыграть возможные ошибки задания прав каталога            *
// ****************************************************************************
function EraseFilesHandler($errno,$errstr,$errfile,$errline)
{
   $modul='EraseFilesHandler';
   \prown\putErrorInfo($modul,$errno,'[DirRightsNoAssign]'.$errstr,$errfile,
      $errline,sceDir."/SignaPhoto.txt");

   /*
   // Отлавливаем ошибку "Некорректное числовое значение в правах каталога"
   // "A non well formed numeric value encountered"
   $Find='A non well formed numeric value encountered';
   $Resu=Findes('/'.$Find.'/u',$errstr); 
   if ($Resu==$Find) 
   {
      putErrorInfo($modul,$errno,
         '['.NonWellNumeric.'] '.$errstr,$errfile,$errline);
   }
   // Обобщаем остальные ошибки
   else 
   {
      putErrorInfo($modul,$errno,
         '['.DirRightsNoAssign.'] '.$errstr,$errfile,$errline);
   }
   */
}

// ****************************************************** ajaEraseFiles.php ***
