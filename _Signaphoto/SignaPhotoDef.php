<?php
// PHP7/HTML5, EDGE/CHROME                            *** SignaPhotoDef.php ***

// ****************************************************************************
// * SignaPhoto       Совместные определения(переменные) для модулей PHP и JS *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  10.07.2021
// Copyright © 2021 tve                              Посл.изменение: 31.01.2022

// Определения к сценариям
define ("ohInfo",               "Info");  // Id дива информационных сообщений
define ("ohLeftTop",            "Левый верхний угол");  
define ("ohRightTop",           "Правый верхний угол");  
define ("ohRightBottom",        "Правый нижний угол");  
define ("ohLeftBottom",         "Левый нижний угол");  
// Определения переключателя "сохранять пропорции подписи"
define ("ohMaintainTrue",       "Да, сохранять");  
define ("ohMaintainFalse",      "Не сохранять"); 

define ("oriLandscape", 'landscape');  // Ландшафтное расположение устройства
define ("oriPortrait",  'portrait');   // Портретное расположение устройства

// Определения сообщений для PHP
define ("ajCopyImageNotCreate", "Не создана копия оригинального изображения для подписи"); 
define ("ajErrBigFile",         "Файл превышает максимальный размер"); 
define ("ajErrFreshStamp",      "Ошибка при наложении подписи на изображение");
define ("ajErrMoveServer",      "Ошибка при перемещении файла на сервер");  
define ("ajErrorisLabel",       "Не найдена метка в переданном сообщении");  
define ("ajErrTempoFile",       "Ошибка при загрузке файла во временное хранилище");
define ("ajFailedResizedStamp", "Не удалось сохранить штамп в измененном размере");
define ("ajImageNotBuilt",      "Не строится изображение для подписи");
define ("ajInfoLoadImg",        "Загрузите изображение для нанесения подписи");     
define ("ajInvalidBuilt",       "Неверный тип файла для построения изображения");  
define ("ajInvalidTransparent", "Неверный тип файла для получения прозрачности");  
define ("ajInvalidType",        "Неверный тип файла изображения");  
define ("ajIsFreshStamp",       "На изображение наложена свежая подпись");
define ("ajLostScriptFile",     "Утерян файл скрипта");   
define ("ajMustTransparentPng", "Изображение подписи должно быть с прозрачным фоном и типа 'png'");
define ("ajNameFileNoMatchUrl", "Имя файла изображения со штампом не соответствует url-адресу");
define ("ajNoSetFile",          "Не установлен массив файлов и не загружены данные");
define ("ajNoTempoFile",        "Не загружен файл во временное хранилище");
define ("ajOk",                 "Все получилось хорошо");
define ("ajPlaceIsPossible",    "Размещение штампа на изображении возможно");
define ("ajProba",              "Это проверочное сообщение");
define ("ajStampBeyondBottom",  "Штамп зашел за нижний край изображения");
define ("ajStampBeyondLeft",    "Штамп зашел за левый край изображения");
define ("ajStampBeyondRight",   "Штамп зашел за правый край изображения");
define ("ajStampBeyondTop",     "Штамп зашел за верхний край изображения");
define ("ajStampNotBuilt",      "Не строится изображение штампа - водяного знака");
define ("ajStampPlaceDetermin", "Размещение штампа определено успешно");
define ("ajSuccess",            "Функция/процедура выполнена успешно");     
define ("ajSuccessfully",       "Файл успешно загружен"); 
define ("ajTransparentSuccess", "Преобразование к прозрачному виду успешно");

// ****************************************************************************
// *         Подключить межязыковые (PHP-JScript) определения внутри HTML     *
// ****************************************************************************
function DefinePHPtoJS()
{
   // Переменные JavaScript, соответствующие определениям сообщений в PHP
   $define=
   '<script>'.
   'ajCopyImageNotCreate="'.ajCopyImageNotCreate.'";'.
   'ajErrBigFile="'        .ajErrBigFile.        '";'.
   'ajErrFreshStamp="'     .ajErrFreshStamp.     '";'.
   'ajErrMoveServer="'     .ajErrMoveServer.     '";'.
   'ajErrorisLabel="'      .ajErrorisLabel.      '";'.
   'ajErrTempoFile="'      .ajErrTempoFile.      '";'.
   'ajFailedResizedStamp="'.ajFailedResizedStamp.'";'.
   'ajImageNotBuilt="'     .ajImageNotBuilt.     '";'.
   'ajInfoLoadImg="'       .ajInfoLoadImg.       '";'.
   'ajInvalidBuilt="'      .ajInvalidBuilt.      '";'.
   'ajInvalidTransparent="'.ajInvalidTransparent.'";'.
   'ajInvalidType="'       .ajInvalidType.       '";'.
   'ajIsFreshStamp="'      .ajIsFreshStamp.      '";'.
   'ajLostScriptFile="'    .ajLostScriptFile.    '";'.
   'ajMustTransparentPng="'.ajMustTransparentPng.'";'.
   'ajNameFileNoMatchUrl="'.ajNameFileNoMatchUrl.'";'.
   'ajNoSetFile="'         .ajNoSetFile.         '";'.
   'ajNoTempoFile="'       .ajNoTempoFile.       '";'.
   'ajOk="'                .ajOk.                '";'.
   'ajPlaceIsPossible="'   .ajPlaceIsPossible.   '";'.
   'ajProba="'             .ajProba.             '";'.
   'ajStampBeyondBottom="' .ajStampBeyondBottom. '";'.
   'ajStampBeyondLeft="'   .ajStampBeyondLeft.   '";'.
   'ajStampBeyondRight="'  .ajStampBeyondRight.  '";'.
   'ajStampBeyondTop="'    .ajStampBeyondTop.    '";'.
   'ajStampNotBuilt="'     .ajStampNotBuilt.     '";'.
   'ajStampPlaceDetermin="'.ajStampPlaceDetermin.'";'.
   'ajSuccess="'           .ajSuccess.           '";'.
   'ajSuccessfully="'      .ajSuccessfully.      '";'.
   'ajTransparentSuccess="'.ajTransparentSuccess.'";'.
   
   'ohMaintainTrue="'      .ohMaintainTrue.      '";'.  
   'ohMaintainFalse="'     .ohMaintainFalse.     '";'.  
   
   'oriLandscape="'        .oriLandscape. '";'.
   'oriPortrait="'         .oriPortrait.  '";'.

   '</script>';
   echo $define;

   // Переменные JavaScript, соответствующие определениям объектов HTML
   $odefine=
   '<script>'.
   'const ohInfo="'   .ohInfo. '";'. 
   '</script>';
   echo $odefine;
}   

// ****************************************************** SignaPhotoDef.php ***
