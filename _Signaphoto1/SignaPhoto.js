// JavaScript/PHP7/HTML5, EDGE/CHROME                     *** SignaPhoto.js ***

/**
 * Библиотека прикладных функций страницы "Подписать фотографию"                             
 * 
 * v1.0, 13.06.2021        Автор: Труфанов В.Е. 
 * Copyright © 2019 tve    Дата создания: 03.06.2021
 * 
**/ 

// ****************************************************************************
// *        Преобразовать логическое значение в соответствующий текст         *
// ****************************************************************************
function sayLogic($logic)
{
   $Result='false';
   if ($logic) $Result='true';
   return $Result;
}
// ****************************************************************************
// *        Выполнить действия в связи с изменением ориентации смартфона      *
// ****************************************************************************

// http://greymag.ru/?p=175, 07.09.2011. При повороте устройства браузер 
// отсылает событие orientationchange. Это актуально для обеих операционных 
// систем. Но подписка на это событие может осуществляться по разному. 
// При проверке на разных устройствах iPhone, iPad и Samsung GT (Android),
// выяснилось что в iOS срабатывает следующий вариант установки обработчика: 
// window.onorientationchange = handler; А для Android подписка осуществляется 
// иначе: window.addEventListener( 'orientationchange', handler, false ); 
//
// Примечание: В обоих примерах handler - функция-обработчик. Текущую ориентацию
// экрана можно узнать проверкой свойства window.orientation, принимающего одно
// из следующих значений: 0 — нормальная портретная ориентация, -90 —
// альбомная при повороте по часовой стрелке, 90 — альбомная при повороте 
// против часовой стрелки, 180 — перевёрнутая портретная ориентация (пока 
// только для iPad).
//         
// Отследить переворот экрана:
// https://www.cyberforum.ru/javascript/thread2242547.html, 08.05.2018

// Подключить обработчик изменения положения смартфона
// ****************************************************************************
// *     Настроить положение навигационных кнопок в мобильной версии сайта    *
// ****************************************************************************
window.addEventListener('orientationchange',doOnOrientationChange);

function doOnOrientationChange() 
{
   if ((window.orientation==0)||(window.orientation==180))
   {
      window.location = $SignaPortraitUrl;
   } 
   if ((window.orientation==90)||(window.orientation==-90)) 
      window.location = $SignaUrl;
}
// ****************************************************************************
// *     Настроить положение навигационных кнопок в мобильной версии сайта    *
// ****************************************************************************
function iniOnOrientationChange() 
{
   //alert('$SignaPortraitUrl='+$SignaPortraitUrl);
   //console.log('$SignaPortraitUrl='+$SignaPortraitUrl);
   if ((window.orientation==0)||(window.orientation==180))
   window.location = $SignaPortraitUrl;
}
// ****************************************************************************
// *     Настроить положение навигационных кнопок в мобильной версии сайта    *
// ****************************************************************************
function ApartButtons()
/**
 * В верхней части каждой мобильной страницы слева находится одна кнопка (от
 * края 5рх), потом на расстоянии 5px размещается заголовок и опять через 5px 
 * вторая кнопка. Кнопки шириной по 35px. Исходя из этого функция устанавливает
 * ширину заголовка (чтобы все три объекта умещались в ширину страницы)
**/ 
{
   var nWidth;
   nWidth=document.body.clientWidth-90;
   console.log('ApartButtons: '+String(nWidth));
   $('#c1Title').css('width',String(nWidth)+'px');
   $('#c2Title').css('width',String(nWidth)+'px');
}

function FindFileImg() { document.getElementById('my_hidden_fileImg').click(); }  
function LoadFileImg() { document.getElementById('my_hidden_loadImg').click(); }  
function FindFileStamp() { document.getElementById('my_hidden_fileStamp').click(); }  
function LoadFileStamp() { document.getElementById('my_hidden_loadStamp').click(); }  

function AlertMessage(messa='Загрузка новой подписи отключена!')
{
   alert(messa);
}
function Substi()
{
   window.location.replace('/Pages/SignaPhoto/SignaPhotoPortrait.php#page2');
}

function onResponse(d) // Функция обработки ответа от сервера 
{  
 eval('var obj = ' + d + ';');  
 if(obj.success!=1)
   {
    alert('Ошибка!\nФайл ' + obj.filename + " не загружен - "+obj.myres); 
    return; 
   }; 
 alert('Файл загружен'); 
}
// ****************************************************************************
// *          Просчитать и установить размеры изображений внутри дивов        *
// ****************************************************************************
function PlaceImgOnDiv()
{
   // Выбираем размеры окон для первоначального изображения, подписи и окончательного
   let oPhoto=document.getElementById("Photo")
   let widthPhoto=oPhoto.offsetWidth;
   let heightPhoto=oPhoto.offsetHeight;
   let oStamp=document.getElementById("Stamp")
   let widthStamp=oStamp.offsetWidth;
   let heightStamp=oStamp.offsetHeight;
   let oProba=document.getElementById("Proba")
   let widthProba=oProba.offsetWidth;
   let heightProba=oProba.offsetHeight;

   // Делаем ajax-запрос для того, чтобы данные с сервера записались в 
   // переменную data. The jqXHR.success(), jqXHR.error(), and jqXHR.complete() 
   // callback methods are removed as of jQuery 3.0. You can use jqXHR.done(), 
   // jqXHR.fail(), and jqXHR.always() instead.
   $.getJSON('ajaPicsSizes.php', {first:1, second:"second"}, function(data) 
   {
      console.log( "success" );
      if (isJSON(data)=='true')
      {
         // Трассируем переданный массив
         // trassData(data);
         
         // Определяем первичное выравнивание ('по ширине','по высоте')
         // первоначального изображения и выравниваем его по диву
         let alignPhoto='по ширине';
         PlaceUsPic("Photo","pic",data[0].ImgWidth,data[0].ImgHeight,alignPhoto);
      }
   })
   .done(function() 
   {
      console.log( "second success" );
   })
   .fail(function() 
   {
      console.log( "error" );
   })
   .always(function() 
   {
      console.log( "complete" );
   });
}
// ****************************************************************************
// *    Перебрать массив JSON и выдать диалоговое окно, если есть сообщение   *
// ****************************************************************************
function isJSON(data)
{
   $Result='true';
   // Просматриваем массив и ищем первое сообщение              
   for (let i=0; i<data.length; i++) 
   {
      if (data[i].DivId==ohInfo)
      {
         let htmlmessa = '<p>'+data[i].ImgName+'</p>';
         $('div#'+ohInfo).html(htmlmessa); 
         $('#'+ohInfo).dialog({modal:true});
         $Result='false';
      } 
   }
   return $Result;
}
// ****************************************************************************
// *         Трассировать переданные параметры через диалоговое окно          *
// ****************************************************************************
function trassData(data)
{
   let htmlstr = '<table>';
   // Делаем шапку таблицы
   htmlstr += '<tr>';
   htmlstr += '<th>' + 'DivId'     + '</th>';    
   htmlstr += '<th>' + 'ImgName'   + '</th>'; 
   htmlstr += '<th>' + 'ImgWidth'  + '</th>';    
   htmlstr += '<th>' + 'ImgHeight' + '</th>'; 
   htmlstr += '</tr>';
   // Делаем тело таблицы              
   for (i=0; i<data.length; i++) 
   {
      htmlstr += '<tr>';
      htmlstr += '<td>' + data[i].DivId     + '</td>';    
      htmlstr += '<td>' + data[i].ImgName   + '</td>'; 
      htmlstr += '<td>' + data[i].ImgWidth  + '</td>';    
      htmlstr += '<td>' + data[i].ImgHeight + '</td>'; 
      htmlstr += '</tr>';
   }
   htmlstr += '</table>';
   $('div#'+ohInfo).html(htmlstr); 
   $('#'+ohInfo).dialog({modal:true});
}
// ****************************************************************************
// *     Разместить изображение по центру дива: cDiv - идентификатор дива,    *
// *                    cImg - идентификатор изображения,                     *
// *  wImg - реальная ширина изображения, hImg - реальная высота изображения  *
// *        mAligne - первичное выравнивание ('по ширине','по высоте')        *
// ****************************************************************************
function PlaceUsPic(cDiv,cImg,wImg,hImg,mAligne)
{
   // Определяем размеры дива на экране
   let oDiv=document.getElementById(cDiv)
   let widthDiv=oDiv.offsetWidth;
   let heightDiv=oDiv.offsetHeight;
   // Выравниваем по ширине
   if (mAligne=='по ширине')
   {
      // Вначале определяем размещение по ширине через проценты
      let nWidth=94;  let nLeft=4;
      $('#'+cImg).css('width',String(nWidth)+'%');
      $('#'+cImg).css('margin-left',String(nLeft)+'%');
      // Определяем размещение по высоте в пикселах ???
      let nTop=5;
      $('#'+cImg).css('margin-top',String(nTop)+'px');
   }
   // Выравниваем по высоте
   else
   {
   }
}
// ****************************************************************************
// *     Разместить изображение по центру дива: cDiv - идентификатор дива,    *
// *                    cImg - идентификатор изображения,                     *
// *  wImg - реальная ширина изображения, hImg - реальная высота изображения  * 
// ****************************************************************************
function PlaceUsStamp(cDiv,cImg,wImg,hImg)
{
   // Определяем размеры дива на экране
   let oDiv=document.getElementById(cDiv)
   let widthDiv=oDiv.offsetWidth;
   let heightDiv=oDiv.offsetHeight;
   // Определяем первичное выравнивание ('по ширине','по высоте')
   let mAligne='по ширине';
   // Выравниваем по ширине
   if (mAligne=='по ширине')
   {
      let nWidth=84;  let nLeft=4;
      $('#'+cImg).css('width',String(nWidth)+'%');
   }
   // Выравниваем по высоте
   else
   {
   }
}
 
// ********************************************************** SignaPhoto.js ***
