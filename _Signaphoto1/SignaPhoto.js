// JavaScript/PHP7/HTML5, EDGE/CHROME                     *** SignaPhoto.js ***

/**
 * Библиотека прикладных функций страницы "Подписать фотографию"                             
 * 
 * v3.0, 05.12.2021        Автор: Труфанов В.Е. 
 * Copyright © 2021 tve    Дата создания: 03.06.2021
 * 
**/ 

// ****************************************************************************
// *                   Блок функций по выгрузке изображений на сервер         *
// ****************************************************************************
// По клику на кнопке активировать клик выбора файла для загрузки
function alfFindFile() 
{
   document.getElementById('ipfLoadPic').click();
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
} 
// При изменении состояния input file перебрасываем файл на сервер 
function alfLoadFile() 
{
   console.log('alfLoadFile');
   // ------Подключаем вызов загрузки нового изображения
   readImage(document.getElementById('ipfLoadPic'));
}  


function fliClick() 
{
   console.log("fliClick");
}
function fliLoad() 
{
   console.log("fliLoad");
}
function fliReset() 
{
   console.log("fliReset");
}
// ****************************************************************************
// *       Выбрать и скопировать изображение во временное хранилище           *
// ****************************************************************************
function readImage(input) 
{
   // Если выбран и загружен во временное хранилище хотя бы один файл
   if (input.files && input.files[0]) 
   {
      
      // Трассируем параметры загружаемого файла
      console.log(input.files[0]);
      console.log(input.files[0].name);
      console.log(input.files[0].type);
      console.log(input.files[0].lastModified);
      console.log(input.files[0].size+' байт');
      
      console.log('readImage=11');
      // Определяем расширение файла
      imageType=input.files[0].type;
      // Если неверное расширение файла, то выдаем сообщение
      if (!(imageType=='image/jpeg'||imageType=='image/png'||imageType=='image/gif')) 
      {
         //printMessage('#result',ajInvalidType);
         console.log('ajInvalidType');
      }
      // Выполняем считывание файла во временное хранилище
      else 
      {
         // Создаем объект чтения содержимого файла, 
         // хранящиеся на компьютере пользователя
         // (асинхронно, чтобы не тормозить браузер)
         reader = new FileReader();
         // Прицепляем замену существующего изображения на загруженное
         // при успешном завершении загрузки страницы
         reader.onload = function (event) 
         {
            $('#pic').attr('src',event.target.result);
            // Напоминаем о дальнейшем шаге "Загрузите изображение для нанесения подписи"
            //printMessage('#result',ajInfoLoadImg);
            console.log('ajInfoLoadImg');
         }
         // Прицепляем сообщение об ошибке загрузки во временное хранилище
         reader.onerror = function(event) 
         {
            //printMessage('#result',ajErrTempoFile);
            console.log('ajErrTempoFile');
            reader.abort(); 
         };
         // Запускаем процесс чтения изображения 
         reader.readAsDataURL(input.files[0]);
      }
   }
   // Отмечаем, что не загружен файл во временное хранилище
   else
   {
      console.log('ajNoTempoFile');
      // printMessage('#result',ajNoTempoFile);
   }
}







// Вывести сообщение при ошибке перемещения файла из временного хранилища
function alfOnResponse(d) 
{
 alert('var obj = ' + d + ';');  
 eval('var obj = ' + d + ';');  
 if(obj.success!=1)
   {
    alert('Ошибка!\nФайл ' + obj.filename + " не загружен - "+obj.myres); 
    return; 
   }; 
 alert('Файл загружен'); 
}
 
function alfMoveFile() 
{
   alert('ajaMoveFile');
   
   
   
   /*
   $.ajax({
         type:'POST',            // тип запроса
         //type: "GET",
         url: 'ajaMoveFile.php',  // скрипт обработчика
         dataType: "json",
         //async: false,          // гуглом не рекомендуется 'из-за пагубного воздействия'
         data:  {first:1, second:"second"},         // данные которые мы передаем
         cache: false,           // по POST отключено, но явно уточняем
         contentType: false,     // отключаем, так как тип кодирования задан в форме
         processData: false,     // отключаем, так как передаем файл
         // Отмечаем результат выполнения скрипта по аякс-запросу (успешный или нет)
         success:function(data)
         {
            alert('ajaMoveFile.success: ');
            trassData(data);

         },
         // Отмечаем  неуспешное выполнение аякс-запроса по причине:
         error:function(data)
         {
            //alert('ajaMoveFile.error: '+data);
            alert('ajaMoveFile.error: ');
         }
      });
 */     
} 
 


// -------------------------------------------------------------------
// ****************************************************************************
// *        Преобразовать логическое значение в соответствующий текст         *
// ****************************************************************************
function sayLogic($logic)
{
   $Result='false';
   if ($logic) $Result='true';
   return $Result;
}



function Proba111()
{
   alert('Proba111');
   $.ajax({
         type:'POST',            // тип запроса
         //type: "GET",
         url: 'ajaProba111.php',  // скрипт обработчика
         dataType: "json",
         //async: false,          // гуглом не рекомендуется 'из-за пагубного воздействия'
         data:  {first:1, second:"second"},         // данные которые мы передаем
         cache: false,           // по POST отключено, но явно уточняем
         contentType: false,     // отключаем, так как тип кодирования задан в форме
         processData: false,     // отключаем, так как передаем файл
         // Отмечаем результат выполнения скрипта по аякс-запросу (успешный или нет)
         success:function(data)
         {
            alert('Proba111.success: ');
            trassData(data);

         },
         // Отмечаем  неуспешное выполнение аякс-запроса по причине:
         error:function(data)
         {
            //alert('Proba111.error: '+data);
            alert('Proba111.error: ');
         }
      });

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

function AlertMessage(messa)
{
   if (messa==undefined) messa='Загрузка новой подписи отключена!';
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
   /*
   let oPhoto=document.getElementById("Photo")
   let widthPhoto=oPhoto.offsetWidth;
   let heightPhoto=oPhoto.offsetHeight;
   let oStamp=document.getElementById("Stamp")
   let widthStamp=oStamp.offsetWidth;
   let heightStamp=oStamp.offsetHeight;
   let oProba=document.getElementById("Proba")
   let widthProba=oProba.offsetWidth;
   let heightProba=oProba.offsetHeight;
   */
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
         
         // Определяем способы выравнивания ('по ширине','по высоте')
         // изображений и выравниваем их по дивам
         alignPhoto=getAlignImg("Photo","pic",data[0].ImgWidth,data[0].ImgHeight);
         PlacePicOnDiv("Photo","pic",data[0].ImgWidth,data[0].ImgHeight,alignPhoto,94,4);
         alignStamp=getAlignImg("Stamp","picStamp",data[1].ImgWidth,data[1].ImgHeight);
         PlacePicOnDiv("Stamp","picStamp",data[1].ImgWidth,data[1].ImgHeight,alignStamp,20,50);
         alignProba=getAlignImg("Proba","picProba",data[2].ImgWidth,data[2].ImgHeight);
         PlacePicOnDiv("Proba","picProba",data[2].ImgWidth,data[2].ImgHeight,alignProba,94,2);
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
      //alert("complete");
   });
}
// ****************************************************************************
// *    Перебрать массив JSON и выдать диалоговое окно, если есть сообщение   *
// ****************************************************************************
function isJSON(data)
{
   $Result='true';
   // Просматриваем массив и ищем первое сообщение              
   for (i=0; i<data.length; i++) 
   {
      if (data[i].DivId==ohInfo)
      {
         htmlmessa = '<p>'+data[i].ImgName+'</p>';
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
   htmlstr = '<table>';
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
// *        mAligne - первичное выравнивание ('по ширине','по высоте'),       *
// *    perWidth - процент ширины изображения от ширины дива (или высоты),    *
// *
// ****************************************************************************
function PlacePicOnDiv(cDiv,cImg,wImg,hImg,mAligne,perWidth,perLeft)
{
   // Определяем размеры дива на экране
   oDiv=document.getElementById(cDiv)
   widthDiv=oDiv.offsetWidth;
   heightDiv=oDiv.offsetHeight;
   // Выравниваем по ширине
   if (mAligne=='по ширине')
   {
      // Вначале определяем размещение по ширине через проценты
      nWidth=perWidth; nLeft=perLeft;
      $('#'+cImg).css('width',String(nWidth)+'%');
      $('#'+cImg).css('margin-left',String(nLeft)+'%');
      // Определяем ширину изображения  ***   nWidth --> x        ***
      // в диве из пропорции:           ***     100% --> widthDiv ***
      widthImg=nWidth*widthDiv/100;
      // Определяем высоту изображения  ***     wImg --> hImg     ***  
      // в диве из пропорции:           *** widthImg --> x        ***
      heightImg=widthImg*hImg/wImg;
      // Определяем центрирование размещения по высоте через пикселы
      nTop=(heightDiv-heightImg)/2;
      $('#'+cImg).css('margin-top',String(nTop)+'px');
   }
   // Выравниваем по высоте
   else
   {
      // Вначале определяем высоту изображения в диве через проценты
      nHeight=94; 
      $('#'+cImg).css('height',String(nHeight)+'%');
      // Определяем высоту изображения в диве через пикселы
      heightImg=nHeight*heightDiv/100;
      // Определяем ширину изображения  *** wImg --> hImg      ***
      // в диве через пикселы:          ***    x --> heightImg ***
      widthImg=wImg*heightImg/hImg;
      $('#'+cImg).css('width',String(widthImg)+'px');
      // Центрируем изображение по диву
      $('#'+cImg).css('margin-left',String((widthDiv-widthImg)/2)+'px');
      $('#'+cImg).css('margin-top',String((heightDiv-heightImg)/2)+'px');
   }
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
   console.log('alignImg='+alignImg);
   return alignImg;
}
// ****************************************************************************
// *     Разместить изображение по центру дива: cDiv - идентификатор дива,    *
// *                    cImg - идентификатор изображения,                     *
// *  wImg - реальная ширина изображения, hImg - реальная высота изображения  * 
// ****************************************************************************
function PlaceUsStamp(cDiv,cImg,wImg,hImg)
{
   // Определяем размеры дива на экране
   oDiv=document.getElementById(cDiv)
   widthDiv=oDiv.offsetWidth;
   heightDiv=oDiv.offsetHeight;
   // Определяем первичное выравнивание ('по ширине','по высоте')
   mAligne='по ширине';
   // Выравниваем по ширине
   if (mAligne=='по ширине')
   {
      nWidth=84;  nLeft=4;
      $('#'+cImg).css('width',String(nWidth)+'%');
   }
   // Выравниваем по высоте
   else
   {
   }
}
 
// ********************************************************** SignaPhoto.js ***
