// JavaScript/PHP7/HTML5, EDGE/CHROME                     *** SignaPhoto.js ***

/**
 * Библиотека прикладных функций страницы "Подписать фотографию"                             
 * 
 * v4.0, 21.01.2021        Автор: Труфанов В.Е. 
 * Copyright © 2021 tve    Дата создания: 03.06.2021
 * 
**/ 

// ****************************************************************************
// *                   Блок функций по выгрузке изображений на сервер         *
// ****************************************************************************
// По клику на кнопке выполнить выбор файла и 
// активировать клик для загрузки файла
function alf1FindFile() 
{
   //console.log("alfFindFile");
   //document.getElementById('ipfLoadPic').click();
   // Настраиваем #InfoLead на загрузку изображения
   /*
   elem=document.getElementById('InfoLead');
   elem.innerHTML=
     '<div id="InfoLead">'+
     '<form method="POST" enctype="multipart/form-data">'+  
     '<input type="file"   id="my_hidden_file" accept="image/jpeg,image/png,image/gif" name="loadfile" onchange="alfLoadFile();">'+  
     '<input type="submit" id="my_hidden_load" value="">'+  
     '</form>'+
     '</div>';
   */
   document.getElementById('my_hidden_file').click(); // alf2LoadFile()
   //$('#my_hidden_file').click();
} 
// При изменении состояния input file активизировать кнопку "submit" для
// загрузки выбранного файла во временное хранилище на сервере 
function alf2LoadFile() 
{
   //console.log("alfLoadFile");
   // По нажатию кнопки "submit" отправляем запрос из формы на выполнение
   // модуля проверки параметров файла, загруженного во временное хранилище,
   // его переброски на постоянное хранение и переименование  
   document.getElementById('my_hidden_load').click(); // "SignaUpload.php"
   //console.log('submit: my_hidden_load.click');
   // ------Подключаем вызов загрузки нового изображения
   //readImage(document.getElementById('ipfLoadPic'));
   //readImage(document.getElementById('my_hidden_file'));
}  



// ****************************************************************************
// *           Вывести диагностическое сообщение при ошибке перемещения       *
// *                файла из временного хранилища и других событиях           *
// ****************************************************************************
function jsWinParentMessage(mess)
{
   alert(mess+'!'); 
} 

// ********************************************************** SignaPhoto.js ***
