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
// *                       Выделить расширение в имени файла                  *
// ****************************************************************************
function get_file_extension($file_name)
{
   return substr(strrchr($file_name,'.'),1);
}
// ****************************************************************************
// *            Загрузить фотографию для подписи и сделать её копию,          *
// *                    на которой будет размещена подпись                    *
// ****************************************************************************
function LoadImg()
{ 
   echo '
      <div id="InfoLead">
      <form action="SignaPhoto.php" method="POST" enctype="multipart/form-data"> 
      <input type="hidden" name="MAX_FILE_SIZE" value="3000024"/> 
      <input type="file"   id="my_hidden_file" 
         accept="image/jpeg,image/png,image/gif" 
         name="loadimg" onchange="alf2LoadFile();"/>  
      <input type="submit" id="my_hidden_load" value="">  
      </form>
      </div>
   ';
   echo '
      <button class="navButtons" onclick="alf1FindFile()"  
      title="Загрузить изображение">
      <i id="iLoadImg" class="fa fa-file-image-o fa-3x" aria-hidden="true"></i>
      </button>
   ';
}
// ****************************************************************************
// *            Загрузить образец для подписания фотографии                   *
// ****************************************************************************
function LoadStamp()
{ 
   echo '
      <div id="StampLead">
      <form action="SignaPhoto.php" method="POST" enctype="multipart/form-data"> 
      <input type="hidden" name="MAX_FILE_SIZE" value="3000024"/> 
      <input type="file"   id="my_shidden_file" accept="image/png" 
      name="loadstamp" onchange="alf2sLoadFile();"/>  
      <input type="submit" id="my_shidden_load" value="">  
      </form>
      </div>
   ';
   echo '
      <button class="navButtons" onclick="alf1sFindFile()"  
      title="Загрузить образец подписи">
      <i id="iLoadStamp" class="fa fa-pencil-square-o fa-3x" aria-hidden="true"></i>
      </button>
  ';
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
// *   Наложить изображения штампа на фотографию с учетом ширины фотографии   *
// *                 и смещения штампа от точка привязки                      *
// ****************************************************************************
function MakeStamp()
{
   echo '
     <div id="StampDo">
     <form action="SignaPhoto.php" method="POST">
     <input type="submit" id="my_Stamp_Do" name="Stamp" value="Do">
     </form>
     </div>
   ';
   echo '
     <button id="bSubscribe" class="navButtons" onclick="alf1MakeStamp()"   
     title="Подписать">
     <i id="iSubscribe" class="fa fa-user-plus fa-3x" aria-hidden="true"></i>
     </button>
    ';
}
// ****************************************************************************
// *                  Изменить настройки подписания фотографии                *
// ****************************************************************************
function Tunein()
{ 
   echo '
     <div id="TuneIn">
     <form action="SignaPhoto.php" method="POST">
     <input type="submit" id="my_Tune_In" name="Tune" value="In">
     </form>
     </div>
   ';
   echo '
     <button id="bTunein" class="navButtons" onclick="alf1Tunein()"   
     title="Подписать">
     <i id="iTunein" class="fa fa-cog fa-3x" aria-hidden="true"></i>
     </button>
    ';
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
// ****************************************************************************
// *                     Изменить настройки для подписи                       *
// ****************************************************************************
function ViewTuneIn()
{
   echo '<div  id="ViewTuneIn">';
   echo '
      <form name="test" method="GET" action="SignaPhoto.php">
      
      <!-- 
      <b>Процент размера подписи к изображению:</b><br>
      <input name="PerSizeImg" value="20"
      type="number" min="1" max="99" step="1"><br><br>

      <b>Точка привязки подписи:</b><br>
      <input name="PointCorner" value="ohLeftTop" 
         type="radio">Левый верхний угол<br>
      <input name="PointCorner" value="ohRightTop" 
         type="radio">Правый верхний угол<br>
      <input name="PointCorner" value="ohRightBottom" 
         type="radio">Правый нижний угол<br>
      <input name="PointCorner" value="ohLeftBottom" 
         type="radio">Левый нижний угол<br><br>
      
      <b>Процент смещения подписи по ширине от точки привязки:</b><br>
      <input name="PerMargeWidth" value="5" 
         type="number" min="1" max="99" step="1"><br>      

      <b>Процент смещения подписи по высоте от точки привязки:</b><br>
      <input name="PerMargeHight" value="5" 
         type="number" min="1" max="99" step="1"><br><br>      

      <b>Сохранять пропорции подписи:</b><br>
      <input name="MaintainProp" value="true" 
         type="checkbox"><br><br>
      -->

      <input type="submit" value="Изменить настройки"><br>
      </form>
   ';
   echo '</div>';
   
   echo '<div  id="ViewSwitch">';
   echo '
      <input class="checkbox" id="checkbox1" type="checkbox"/>
      <label for="checkbox1" class="checkbox-label">
      <span class="on">I am on!</span>
      <span class="off">I am off</span>
      </label>

      <input class="rcheckbox" id="checkbox3" type="radio"/>
      <label for="checkbox3" class="rcheckbox-label">
      <span class="on">I am on!</span>
      <span class="off">I am off</span>
      </label>

      <input class="rcheckbox" id="checkbox4" type="radio"/>
      <label for="checkbox4" class="rcheckbox-label">
      <span class="on">I am on!</span>
      <span class="off">I am off</span>
      </label>

      <input class="checkbox blue" id="checkbox2" type="checkbox"/>
      <label for="checkbox2" class="checkbox-label">
      <span class="on">We are both longer than that guy up there</span>
      <span class="off">It works with much longer labels too</span>
      </label>
   ';
   echo '</div>';
}
// ****************************************************** SignaPhotoImg.php ***
