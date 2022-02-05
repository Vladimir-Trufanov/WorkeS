// JavaScript/PHP7/HTML5, EDGE/CHROME                     *** SignaPhoto.js ***

/**
 * Библиотека прикладных функций страницы "Подписать фотографию"                             
 * 
 * v4.0, 21.01.2021        Автор: Труфанов В.Е. 
 * Copyright © 2021 tve    Дата создания: 03.06.2021
 * 
**/ 

// По клику на кнопке выполнить выбор файла и 
// активировать клик для загрузки файла
function alf1FindFile() 
{
   document.getElementById('my_hidden_file').click(); // alf2LoadFile()
} 
// По клику на кнопке  
// активировать клик на форме для подписания файла
function alf1MakeStamp()
{
   document.getElementById('my_Stamp_Do').click(); 
} 
// По клику на кнопке  
// активировать клик на форме для изменения настроек
function alf1Tunein()
{
   document.getElementById('my_Tune_In').click(); 
} 
function alfSubmitTunein()
{
   document.getElementById('my_Tune_Submit').click(); 
} 
// При изменении состояния input file активизировать кнопку "submit" для
// загрузки выбранного файла во временное хранилище на сервере 
function alf2LoadFile() 
{
   // По нажатию кнопки "submit" отправляем запрос из формы на выполнение
   // модуля проверки параметров файла, загруженного во временное хранилище,
   // его переброски на постоянное хранение и переименование  
   document.getElementById('my_hidden_load').click(); // "SignaUpload.php"
}
function alf1sFindFile() 
   {document.getElementById('my_shidden_file').click();} 
function alf2sLoadFile()
   {document.getElementById('my_shidden_load').click();}
// ****************************************************************************
// *   Определить спосов выравнивания ('по ширине','по высоте') изображения   *
// *                                 по диву                                  *
// ****************************************************************************
function getAlignImg(cDiv,cImg,wImg,hImg)
{
   // Определяем размеры дива на экране
   oDiv=document.getElementById(cDiv)
   widthDiv=oDiv.offsetWidth;
   heightDiv=oDiv.offsetHeight;
   // Считаем, что нужно выровнять по ширине
   alignImg='по ширине';
   // Через пропорцию вычисляем высоту     *** widthDiv --> wImg ***
   // растянутого изображения по ширине:   ***        x --> hImg ***
   p_heightDiv=(widthDiv*hImg/wImg);
   // Сравниваем расчетную высоту изображения с высотой дива и,
   // если высота изображения превышает высоту дива,
   // то считаем, что изображение нужно растянуть по высоте
   if (p_heightDiv>heightDiv) alignImg='по высоте';
   return alignImg;
}
// ****************************************************************************
// *     Расчитать изображение по центру дива: cDiv - идентификатор дива,     *
// *                    cImg - идентификатор изображения,                     *
// *  wImg - реальная ширина изображения, hImg - реальная высота изображения  *
// *        mAligne - первичное выравнивание ('по ширине','по высоте'),       *
// *    perWidth - процент ширины изображения от ширины дива (или высоты),    *
// ****************************************************************************
function CalcPicOnDiv(cDiv,cImg,wImg,hImg,mAligne,perWidth)
{
   // Определяем возвращаемый массив
   aCalcPicOnDiv=
   { 
      "widthImg":  32,
      "heightImg": 32,
      "nLeft":     10,
      "nTop":      10
   }
   // Определяем размеры дива на экране
   oDiv=document.getElementById(cDiv)
   widthDiv=oDiv.offsetWidth;
   heightDiv=oDiv.offsetHeight;
   // Выравниваем по ширине
   if (mAligne=='по ширине')
   {
      // Определяем ширину изображения            ***   nWidth --> x        ***
      // в диве из пропорции:                     ***     100% --> widthDiv ***
      nWidth=perWidth; 
      widthImg=nWidth*widthDiv/100;
      aCalcPicOnDiv.widthImg=widthImg;
      // Определяем высоту изображения            ***     wImg --> hImg     ***  
      // в диве из пропорции:                     *** widthImg --> x        ***
      heightImg=widthImg*hImg/wImg;
      aCalcPicOnDiv.heightImg=heightImg;
   }
   // Выравниваем по высоте
   else
   {
      // Вначале задаем высоту изображения в диве через проценты
      nHeight=perWidth; 
      // Определяем высоту изображения в диве через пикселы
      heightImg=nHeight*heightDiv/100;
      aCalcPicOnDiv.heightImg=heightImg;
      // Определяем ширину изображения               *** wImg --> hImg      ***
      // в диве через пикселы:                       ***    x --> heightImg ***
      widthImg=wImg*heightImg/hImg;
      aCalcPicOnDiv.widthImg=widthImg;
   } 
   // Центрируем изображение по диву
   aCalcPicOnDiv.nLeft=(widthDiv-widthImg)/2;
   aCalcPicOnDiv.nTop=(heightDiv-heightImg)/2;
   return aCalcPicOnDiv;
}






// ----------

function PlaceImgOnDiv()
{
   alert( "PlaceImgOnDiv()" );
}
  
// ****************************************************************************
// *           Вывести диагностическое сообщение при ошибке перемещения       *
// *                файла из временного хранилища и других событиях           *
// ****************************************************************************
function jsWinParentMessage(mess)
{
   alert(mess+'!'); 
}
// ****************************************************************************
// *              Заменить изображение в заданной области страницы            *
// ****************************************************************************
function Proba12()
{
   htmlstr='Привет!';
   $('div#Photo').html(htmlstr); 
}
function jsWinParentReplaceImg(mess,IdDiv) 
{
   if (IdDiv==null)
   {
      data=JSON.parse(mess);
   }
   else
   {
      if (data[0].DivId=="Photo")
      {
      }
      else if (data[0].DivId=="Stamp")
      {
      }
      else if (data[0].DivId=="Proba")
      {
      }
      else
      {
      }
   }
   //alert(data[0].ImgName); 
   // Определяем способы выравнивания ('по ширине','по высоте')
   // изображений и выравниваем их по дивам
   alignPhoto=getAlignImg(data[0].DivId,data[0].IdImg,data[0].ImgWidth,data[0].ImgHeight);
   PlacePicOnDiv(data[0].DivId,data[0].IdImg,data[0].ImgWidth,data[0].ImgHeight,alignPhoto,94,4,data[0].ImgName);
}

// ****************************************************************************
// *     Разместить изображение по центру дива: cDiv - идентификатор дива,    *
// *                    cImg - идентификатор изображения,                     *
// *  wImg - реальная ширина изображения, hImg - реальная высота изображения  *
// *        mAligne - первичное выравнивание ('по ширине','по высоте'),       *
// *    perWidth - процент ширины изображения от ширины дива (или высоты),    *
// *
// ****************************************************************************
/*
function PlacePicOnDiv(cDiv,cImg,wImg,hImg,mAligne,perWidth,perLeft,cPlacePicOnDivFile)
{
   //
   //htmlstr='<div  id="Photo">'+
   //        '<img src="'+cPlacePicOnDivFile+'" alt="tttrr" id="pic" title="ghhjjjkk">'+
   //        '</div>';
   //$('div#Photo').html(htmlstr); 

   // Определяем размеры дива на экране
   oDiv=document.getElementById(cDiv)
   widthDiv=oDiv.offsetWidth;
   heightDiv=oDiv.offsetHeight;
   // Выравниваем по ширине
   if (mAligne=='по ширине')
   {
      // Вначале определяем размещение по ширине через проценты
      nWidth=perWidth; nLeft=perLeft;
      $('#'+cImg).css('margin-left',String(nLeft)+'%');
      // Определяем ширину изображения  ***   nWidth --> x        ***
      // в диве из пропорции:           ***     100% --> widthDiv ***
      widthImg=nWidth*widthDiv/100;
      // Определяем высоту изображения  ***     wImg --> hImg     ***  
      // в диве из пропорции:           *** widthImg --> x        ***
      heightImg=widthImg*hImg/wImg;
      // Определяем центрирование размещения по высоте через пикселы
      nTop=(heightDiv-heightImg)/2;
      console.log('widthImg='+widthImg);
      console.log('heightImg='+heightImg);
      $('#'+cImg).css('width',String(widthImg)+'px');
      $('#'+cImg).css('height',String(heightImg)+'px');
      $('#'+cImg).css('margin-top',String(nTop)+'px');
   }
   // Выравниваем по высоте
   else
   {
      // Вначале задаем высоту изображения в диве через проценты
      nHeight=94; 
      // Определяем высоту изображения в диве через пикселы
      heightImg=nHeight*heightDiv/100;
      // Определяем ширину изображения  *** wImg --> hImg      ***
      // в диве через пикселы:          ***    x --> heightImg ***
      widthImg=wImg*heightImg/hImg;
      $('#'+cImg).css('width',String(widthImg)+'px');
      $('#'+cImg).css('height',String(heightImg)+'px');
      // Центрируем изображение по диву
      $('#'+cImg).css('margin-left',String((widthDiv-widthImg)/2)+'px');
      $('#'+cImg).css('margin-top',String((heightDiv-heightImg)/2)+'px');
   } 

   console.log('cPlacePicOnDivFile='+cPlacePicOnDivFile);
   $('#pic').attr('src',cPlacePicOnDivFile);
   
}
*/
// ********************************************************** SignaPhoto.js ***
