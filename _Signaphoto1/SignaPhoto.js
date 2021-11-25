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
// *           Просчитать и установить размер изображения внутри дива         *
// ****************************************************************************
function PlaceImgOnDiv()
{
   let oPhoto=document.getElementById("Photo")
   let widthPhoto=oPhoto.offsetWidth;
   let oPic=document.getElementById("pic")
   let widthPic=oPic.offsetWidth;
  
   //alert('widthPhoto='+widthPhoto+'  '+'widthPic='+widthPic); 
   /*
   $.ajax({
   type:'POST',             // тип запроса
   url: 'ajaPicsSizes.php', // скрипт обработчика
   async: false,
   data: 'formData',        // данные которые мы передаем
   cache: false,            // по POST отключено, но явно уточняем
   contentType: false,      // отключаем, так как тип кодирования задан в форме
   processData: false,      // отключаем, так как передаем файл
   // Отмечаем результат выполнения скрипта по аякс-запросу (успешный или нет)
   success:function(data)
   {
      alert('ajaPicsSizes.success: '+data);
            // "Файл превышает максимальный размер"
            if (isLabel(data,ajErrBigFile)) 
            {
               let Label=makeLabel(ajErrBigFile);
               regex=new RegExp(Label,"u");
               let p = data; p=p.replace(regex,'')
               p=freeLabel(p);
               printMessage('#result',ajErrBigFile,p);
            }
            // "Ошибка при перемещении файла на сервер"
            else if (isLabel(data,ajErrMoveServer)) 
            {
               printMessage('#result',ajErrMoveServer);
            }
            // "Неверный тип файла изображения"
            else if (isLabel(data,ajInvalidType)) 
            {
               printMessage('#result',ajInvalidType);
            }
            // "Не установлен массив файлов и не загружены данные"
            else if (isLabel(data,ajNoSetFile)) 
            {
               printMessage('#result',ajNoSetFile);
            }
            // "Файл успешно загружен"
            else if (isLabel(data,ajSuccessfully)) 
            {
               printMessage('#result',ajSuccessfully);
            }
            else 
            {
               printMessage('#result',ajErrorisLabel,data);
            }
      // Перегружаем страницу с очисткой кэша для того, 
      // чтобы обновить изображения и перекинуть кукисы
      // window.location.reload(true);
   },
   // Отмечаем  неуспешное выполнение аякс-запроса по причине:
   // 1) утерян файл скрипта.
   error:function(data)
   {
      alert('ajaPicsSizes.error: '+data);
      //printMessage('#result',ajLostScriptFile);
   }
   });
   */
   
   // Делаем ajax-запрос для того, чтобы данные с сервера 
// записались в переменную data
$.getJSON('ajaPicsSizes.php', {first:1, second:"second"}, function(data) 
{
   console.log( "success" );
   let htmlstr = '<table>';
   // Выполняем цикл по сотрудникам              
   for (var i=0; i<data.length; i++) 
   {
      htmlstr += '<tr>';
      htmlstr += '<td>' + data[i].fio + '</td>';      // ФИО
      htmlstr += '<td>' + data[i].birthday + '</td>'; // Дата рождения
      htmlstr += '</tr>';
   }
   htmlstr += '</table>';
   // в div с классом info выводим получившуюся таблицу с данными
   $('div.info').html(htmlstr); 
});

   
   
   
}  
// ********************************************************** SignaPhoto.js ***
