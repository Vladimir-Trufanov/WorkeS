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
// ********************************************************** SignaPhoto.js ***
