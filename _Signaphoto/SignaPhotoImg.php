<?php
// PHP7/HTML5, EDGE/CHROME                            *** SignaPhotoImg.php ***

// ****************************************************************************
// * SignaPhoto               Блок функций подготовки и обработки изображений *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  25.11.2021
// Copyright © 2021 tve                              Посл.изменение: 01.02.2022

// ****************************************************************************
// *                  Сбросить кэши состояний файлов изображений              *
// ****************************************************************************
function ClearCacheImgFiles($c_FileImg,$c_FileStamp,$c_FileProba)
{
   clearstatcache(true,$c_FileImg); 
   clearstatcache(true,$c_FileStamp); 
   clearstatcache(true,$c_FileProba); 
}
// ****************************************************************************
// *                      Подключиться к файлам изображений                   *
// ****************************************************************************
function ConnectImgFiles(&$c_FileImg,&$c_FileStamp,&$c_FileProba)
{
   // Обеспечиваем инициацию изображений при первом запуске в браузере
   $c_FileImg=prown\MakeCookie('FileImg','images/iphoto.jpg',tStr,true);
   $c_FileStamp=prown\MakeCookie('FileStamp','images/istamp.png',tStr,true);
   $c_FileProba=prown\MakeCookie('FileProba','images/iproba.png',tStr,true);
   // Проверяем существование изображений, инициируем при отсутствии
   if (@!fopen($c_FileImg,"r"))   $c_FileImg=prown\MakeCookie('FileImg','images/iphoto.jpg',tStr); 
   if (@!fopen($c_FileStamp,"r")) $c_FileStamp=prown\MakeCookie('FileStamp','images/istamp.png',tStr); 
   if (@!fopen($c_FileProba,"r")) $c_FileProba=prown\MakeCookie('FileProba','images/iproba.png',tStr); 
}
// ****************************************************************************
// *     Разместить изображение по центру дива: cDiv - идентификатор дива,    *
// *                   cImg - идентификатор изображения,                      *
// *  wImg - реальная ширина изображения, hImg - реальная высота изображения  *
// *        mAligne - первичное выравнивание ('по ширине','по высоте'),       *
// *    perWidth - процент ширины изображения от ширины дива (или высоты),    *
// *
// ****************************************************************************
function MakeImgOnDiv($cDiv,$cImg,$c_FileImg,$perWidth)
{
   // Определяем реальную ширину и высоту изображения
   $a=getimagesize($c_FileImg);
   $wImg=$a[0]; $hImg=$a[1];
   ?> <script>
   cDiv="<?php echo $cDiv; ?>";
   cImg="<?php echo $cImg; ?>";
   wImg="<?php echo $wImg; ?>";
   hImg="<?php echo $hImg; ?>";
   perWidth="<?php echo $perWidth; ?>";
   // Определяем способ выравнивания изображения диву
   // ('по ширине','по высоте')
   alignPhoto=getAlignImg(cDiv,cImg,wImg,hImg);
   // Расчитываем выравнивание и устанавливаем CSS
   aCalcPicOnDiv=CalcPicOnDiv(cDiv,cImg,wImg,hImg,alignPhoto,perWidth)
   $("#"+cImg).css("width",String(aCalcPicOnDiv.widthImg)+'px');
   $("#"+cImg).css("height",String(aCalcPicOnDiv.heightImg)+'px');
   $("#"+cImg).css("margin-left",String(aCalcPicOnDiv.nLeft)+'px');
   $("#"+cImg).css("margin-top",String(aCalcPicOnDiv.nTop)+'px');
</script> <?php
}
// ****************************************************************************
// *                       Выделить расширение в имени файла                  *
// ****************************************************************************
function get_file_extension($file_name)
{
   return substr(strrchr($file_name,'.'),1);
}
// ****************************************************************************
// *        Вывести информационное сообщение или сообщение об ошибке          *
// ****************************************************************************
function ViewMess($Mess)
{
   $_Prefix='SignaPhoto';
   prown\Alert($_Prefix.': '.$Mess);
}
// ****************************************************************************
// *                  Вывести загруженное изображение для подписи             *
// ****************************************************************************
function ViewPhoto($c_FileImg)
{
   echo '<img id="pic" src="'.$c_FileImg.'"'.' alt="'.$c_FileImg.'"'.
     ' title="Загруженное изображение">';
   MakeImgOnDiv('Photo','pic',$c_FileImg,94);
}
// ****************************************************************************
// *            Вывести изображение для подписи или уже с подписью            *
// ****************************************************************************
function ViewProba($c_FileProba,$RemoteAddr)
{  
   /*
   echo 'Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba '.
   'Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba '.
   'Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba '.
   'Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba Proba';
   */

   echo '<img id="picProba" src="'.$c_FileProba.'"'.' alt="'.$c_FileProba.'"'.
     ' title="Подписанное изображение">';
   MakeImgOnDiv('Proba','picProba',$c_FileProba,94);

   /*        
   prown\ViewGlobal(avgREQUEST);
   prown\ViewGlobal(avgCOOKIE);
   echo '<pre>';
   echo '*** $RemoteAddr='.$RemoteAddr.' ***<br>';
   echo '*** browscap='.ini_get('browscap').' ***<br>';
   $browser = get_browser(null,true);
   print_r($browser);
   echo "</pre>";
   */
}

// ****************************************************************************
// *                     Вывести загруженный образец подписи                  *
// ****************************************************************************
function ViewStamp($c_FileStamp)
{
   echo '<img id="picStamp" src="'.$c_FileStamp.'"'.' alt="'.$c_FileStamp.'"'.
     ' title="Образец подписи">';
   MakeImgOnDiv('Stamp','picStamp',$c_FileStamp,50);
}

// ****************************************************** SignaPhotoImg.php ***
