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
function TuneinRequest($urlPage,&$c_PointCorner,&$c_PerSizeImg,&$c_PerMargeWidth,&$c_PerMargeHight,&$c_MaintainProp)
{
   // Обеспечиваем инициацию параметров подписи при первом запуске
   $c_PointCorner=prown\MakeCookie('PointCorner',ohRightBottom,tStr,true);      // точка привязки подписи
   $c_PerSizeImg=prown\MakeCookie('PerSizeImg',20,tInt,true);                   // процент размера подписи к изображению
   $c_PerMargeWidth=prown\MakeCookie('PerMargeWidth',5,tInt,true);              // процент смещения подписи по ширине от точки привязки
   $c_PerMargeHight=prown\MakeCookie('PerMargeHight',5,tInt,true);              // процент смещения подписи по высоте от точки привязки
   $c_MaintainProp=prown\MakeCookie('MaintainProp',ohMaintainFalse,tStr,true);  // не сохранять пропорции подписи
  
   // Настраиваем процент размера подписи к изображению 
   if (IsSet($_POST['PerSizeImg']))
   {
      $c_PerSizeImg=prown\MakeCookie('PerSizeImg',$_POST['PerSizeImg'],tInt); 
   }
   // Настраиваем точку привязки подписи 
   if (IsSet($_POST['PointCorner']))
   {
      $c_PointCorner=prown\MakeCookie('PointCorner',$_POST['PointCorner'],tStr);    
   }
   // Настраиваем смещения подписи по ширине от точки привязки 
   if (IsSet($_POST['PerMargeWidth']))
   {
      $c_PerMargeWidth=prown\MakeCookie('PerMargeWidth',$_POST['PerMargeWidth'],tInt);    
   }
   // Настраиваем смещения подписи по высоте от точки привязки 
   if (IsSet($_POST['PerMargeHight']))
   {
      $c_PerMargeHight=prown\MakeCookie('PerMargeHight',$_POST['PerMargeHight'],tInt);    
   }
   // Определяем способ масштабирования подписи 
   if (IsSet($_POST['MaintainCtrl']))
   {
      $c_MaintainProp=prown\MakeCookie('MaintainProp',ohMaintainFalse,tStr);    
   }
   else if (IsSet($_POST['MaintainProp']))
   {
      $c_MaintainProp=prown\MakeCookie('MaintainProp',ohMaintainTrue,tStr);    
   }
}
// ******************************************************** SignaTunein.php ***
