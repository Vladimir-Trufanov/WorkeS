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
// ****************************************************************************
// *                              Настроить мобильный экран                   *
// ****************************************************************************
function cssViewport($SiteDevice)
{
   if ($SiteDevice<>Computer)
   {
      echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
   }
}
// ****************************************************************************
// *                       Спозиционировать основные дивы                     *
// ****************************************************************************
function cssDivPosition($SiteDevice,$_Orient)
{
   if ($_Orient==oriLandscape)
   {
      // Мобильный телефон
      if ($SiteDevice==Mobile)
      {
         ?> <style>
         #All,#Lead {position:fixed; height:100%;}
         #All {left:0;  width:80%; }
         #Lead {right:0; width:20%;}  
         #View  {width:48%; float:left;  height:100%;}
         #Proba {width:52%; float:right; height:100%;}         
         #Photo {height:82%;}
         #Stamp {height:18%;} 
         
         .navButtons {position:fixed;}
         #bLoadimg {top:7px; right:108px;}
         #bSubscribe {top:7px; right:54px;}
         #bTunein {top:64px; right:108px;}
         #bHome {bottom:7px; right:7px}
         #bLoadStamp {bottom:7px; right:64px}
                                           
         /*
         #bLoadimg,#bSubscribe,bTunein {float:left; margin-left:8px;}
         #bLoadimg,#bSubscribe {margin-top:8px;}
         bTunein {margin-top:.58rem;}
         #bHome,#bLoadStamp {float:right; margin-bottom:.8rem;}
         */
         
         /*
         #bLoadimg,#bSubscribe,bTunein {float:left; margin:.8rem 0 0 .8rem;}
         #bLoadStamp,#bHome {float:right; margin:.8rem 0 0 .8rem;}
         */
         </style> <?php
      }
      // Компьютер
      else
      {
         ?> <style>
         #All,#Lead {position:fixed; height:100%;}
         #All {left:0;  width:92%; }
         #Lead {right:0; width:8%;}  
         #View  {width:48%; float:left;  height:100%;}
         #Proba {width:52%; float:right; height:100%;}         
         #Photo {height:82%;}
         #Stamp {height:18%;} 
         .navButtons {margin-top:1rem;}
         .navButtons {position:relative;}
         </style> <?php
      };
   }
   else
   {
      ?> 
      <style>
      #All,#Lead {position:fixed; width:100%;}
      #All {top:0; height:85%;}
      #Lead {bottom:0; height:15%;}  
      
      #View  {width:48%; float:left;  height:100%;}
      #Proba {width:52%; float:right; height:100%;}         
      #Photo {height:82%;}
      #Stamp {height:18%;} 
      
      #bLoadImg,#bSubscribe,#bTunein,#bLoadStamp {float:left;}
      #bHome{float:right; margin-right:1rem;}
      .navButtons {margin-left:1rem; margin-top:.4rem;}
      .navButtons {position:relative;}
         
      </style>
      <?php
   }
}
// ******************************************************** SignaTunein.php ***
