<?php
// PHP7/HTML5, EDGE/CHROME                            *** SignaPhotoDef.php ***

// ****************************************************************************
// * SignaPhoto       Совместные определения(переменные) для модулей PHP и JS *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  10.07.2021
// Copyright © 2021 tve                              Посл.изменение: 26.11.2021

// Определения сообщений для PHP
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
define ("ajNoSetFile",          "Не установлен массив файлов и не загружены данные");
define ("ajNoTempoFile",        "Не загружен файл во временное хранилище");
define ("ajProba",              "Это проверочное сообщение");
define ("ajStampNotBuilt",      "Не строится изображение штампа - водяного знака");
define ("ajSuccess",            "Функция/процедура выполнена успешно");     
define ("ajSuccessfully",       "Файл успешно загружен sss ОТЛАДКА");     
define ("ajTransparentSuccess", "Преобразование к прозрачному виду успешно"); 
// Определения объектов HTML
define ("ohInfo", "Info");  // Id дива информационных сообщений



// Переменные JavaScript, соответствующие определениям сообщений в PHP
$define=
'<script>'.
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
'ajNoSetFile="'         .ajNoSetFile.         '";'.
'ajNoTempoFile="'       .ajNoTempoFile.       '";'.
'ajProba="'             .ajProba.             '";'.
'ajStampNotBuilt="'     .ajStampNotBuilt.     '";'.
'ajSuccess="'           .ajSuccess.           '";'.
'ajSuccessfully="'      .ajSuccessfully.      '";'.
'ajTransparentSuccess="'.ajTransparentSuccess.'";'.
'</script>';

// Переменные JavaScript, соответствующие определениям объектов HTML
$odefine=
'<script>'.
'const ohInfo="'   .ohInfo. '";'. 
'</script>';

// ****************************************************** SignaPhotoDef.php ***
