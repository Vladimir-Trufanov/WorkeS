<?php
// PHP7/HTML5, EDGE/CHROME                              *** SignaTunein.php ***

// ****************************************************************************
// * SignaPhoto           Обеспечить обработку настроек подписания фотографий *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  04.02.2022
// Copyright © 2022 tve                              Посл.изменение: 06.02.2022

// ****************************************************************************
// *  Обработать параметры HTTP-запроса по настройкам подписания изображений  *
// *                           и записать данные в кукисы                     *
// ****************************************************************************
function TuneinRequest(&$c_PointCorner,&$c_PerSizeImg,&$c_PerMargeWidth,&$c_PerMargeHight,&$c_MaintainProp)
{
   // Инициируем (сбрасываем) признак перезагрузки страницы
   $PageReload=false;
   // Обеспечиваем инициацию параметров подписи при первом запуске
   $c_PointCorner=prown\MakeCookie('PointCorner',ohRightBottom,tStr,true);  // точка привязки подписи
   $c_PerSizeImg=prown\MakeCookie('PerSizeImg',20,tInt,true);               // процент размера подписи к изображению
   $c_PerMargeWidth=prown\MakeCookie('PerMargeWidth',5,tInt,true);          // процент смещения подписи по ширине от точки привязки
   $c_PerMargeHight=prown\MakeCookie('PerMargeHight',5,tInt,true);          // процент смещения подписи по высоте от точки привязки
   $c_MaintainProp=prown\MakeCookie('MaintainProp',false,tBool,true);       // сохранять пропорции подписи

   // Настраиваем процент размера подписи к изображению 
   if (IsSet($_REQUEST['PerSizeImg']))
   {
      $c_PerSizeImg=prown\MakeCookie('PerSizeImg',prown\getComRequest('PerSizeImg'),tInt);    
   }
   // Настраиваем точку привязки подписи 
   if (IsSet($_REQUEST['PointCorner']))
   {
      $c_PointCorner=prown\MakeCookie('PointCorner',prown\getComRequest('PointCorner'),tInt);    
      prown\ConsoleLog('$c_PointCorner='.$c_PointCorner);
   }
   // Настраиваем смещения подписи по ширине от точки привязки 
   if (IsSet($_REQUEST['PerMargeWidth']))
   {
      $c_PerMargeWidth=prown\MakeCookie('PerMargeWidth',prown\getComRequest('PerMargeWidth'),tInt);    
   }
   // Настраиваем смещения подписи по высоте от точки привязки 
   if (IsSet($_REQUEST['PerMargeHight']))
   {
      $c_PerMargeHight=prown\MakeCookie('PerMargeHight',prown\getComRequest('PerMargeHight'),tInt);    
   }
}
// ******************************************************** SignaTunein.php ***
