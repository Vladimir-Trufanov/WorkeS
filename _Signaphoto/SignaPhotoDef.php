<?php
// PHP7/HTML5, EDGE/CHROME                            *** SignaPhotoDef.php ***

// ****************************************************************************
// * SignaPhoto       Совместные определения(переменные) для модулей PHP и JS *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  10.07.2021
// Copyright © 2021 tve                              Посл.изменение: 30.01.2022

// Определения сообщений для PHP
define ("ajCopyImageNotCreate", "Не создана копия оригинального изображения для подписи"); 
define ("ajErrBigFile",         "Файл превышает максимальный размер"); 
define ("ajErrFreshStamp",      "Ошибка при наложении подписи на изображение");
define ("ajErrMoveServer",      "Ошибка при перемещении файла на сервер");  
define ("ajErrorisLabel",       "Не найдена метка в переданном сообщении");  
define ("ajErrTempoFile",       "Ошибка при загрузке файла во временное хранилище");
define ("ajImageNotBuilt",      "Не строится изображение для подписи");
define ("ajInfoLoadImg",        "Загрузите изображение для нанесения подписи");     
define ("ajInvalidBuilt",       "Неверный тип файла для построения изображения");  
define ("ajInvalidTransparent", "Неверный тип файла для получения прозрачности");  
define ("ajInvalidType",        "Неверный тип файла изображения");  
define ("ajIsFreshStamp",       "На изображение наложена свежая подпись");
define ("ajLostScriptFile",     "Утерян файл скрипта");   
define ("ajMustTransparentPng", "Изображение подписи должно быть с прозрачным фоном и типа 'png'");
define ("ajNoSetFile",          "Не установлен массив файлов и не загружены данные");
define ("ajNoTempoFile",        "Не загружен файл во временное хранилище");
define ("ajOk",                 "Все получилось хорошо");
define ("ajProba",              "Это проверочное сообщение");
define ("ajStampNotBuilt",      "Не строится изображение штампа - водяного знака");
define ("ajSuccess",            "Функция/процедура выполнена успешно");     
define ("ajSuccessfully",       "Файл успешно загружен sss ОТЛАДКА"); 
define ("ajTransparentSuccess", "Преобразование к прозрачному виду успешно"); 
// Определения к сценариям
define ("ohInfo",               "Info");  // Id дива информационных сообщений
define ("ohRightBottom",        "правый нижний угол");  
define ("ohLeftTop",            "левый верхний угол");  
define ("ohRightTop",           "правый верхний угол");  
define ("ohLeftBottom",         "левый нижний угол");  

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
   'ajImageNotBuilt="'     .ajImageNotBuilt.     '";'.
   'ajInfoLoadImg="'       .ajInfoLoadImg.       '";'.
   'ajInvalidBuilt="'      .ajInvalidBuilt.      '";'.
   'ajInvalidTransparent="'.ajInvalidTransparent.'";'.
   'ajInvalidType="'       .ajInvalidType.       '";'.
   'ajIsFreshStamp="'      .ajIsFreshStamp.      '";'.
   'ajLostScriptFile="'    .ajLostScriptFile.    '";'.
   'ajMustTransparentPng="'.ajMustTransparentPng.'";'.
   'ajNoSetFile="'         .ajNoSetFile.         '";'.
   'ajNoTempoFile="'       .ajNoTempoFile.       '";'.
   'ajOk="'                .ajOk.                '";'.
   'ajProba="'             .ajProba.             '";'.
   'ajStampNotBuilt="'     .ajStampNotBuilt.     '";'.
   'ajSuccess="'           .ajSuccess.           '";'.
   'ajSuccessfully="'      .ajSuccessfully.      '";'.
   'ajTransparentSuccess="'.ajTransparentSuccess.'";'.
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
