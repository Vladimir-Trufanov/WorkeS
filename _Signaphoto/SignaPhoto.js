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
// ****************************************************************************
// *     Изменить цвет поля ввода процентов смещения штампа в малозаметный,   *
// * указав таким образом пользователю, что при сохранении пропорциональности *
// *                    штампа, данное поле не работает                       *
// ****************************************************************************
function alf1MaintainProp()
{
   if (document.getElementById('MaintainProp').checked) 
   {
      $('.PerSizeImg').css('color','DarkGoldenRod');
      $('#PerSizeInput').css('color','DarkGoldenRod');
      $('#PerSizeImg').html('Процент размера подписи по ширине изображения:');
      $('#MaintainProp').attr('value',ohMaintainTrue);
      $('#MaintainCtrl').attr('value',ohMaintainFalse);
      $('#MaintainCtrl').prop('checked',false);
   } 
   else 
   {
      $('.PerSizeImg').css('color','black'); 
      $('#PerSizeInput').css('color','black');
      $('#PerSizeImg').html('Процент размера подписи к изображению:');
      $('#MaintainCtrl').attr('value',ohMaintainTrue);
      $('#MaintainProp').attr('value',ohMaintainFalse);
      $('#MaintainCtrl').prop('checked',true);
   }   
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
// *          Перезагрузить главную страницу подписания фотографий            *
// ****************************************************************************
function alf1Home()
{
   console.log('urlPage2='+urlPage2);
   location=urlPage2+'?Com=WasHome';
   location.reload(true);
}   
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

// ********************************************************** SignaPhoto.js ***
