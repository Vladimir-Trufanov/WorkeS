// JavaScript Document
function FindFile() { document.getElementById('my_hidden_file').click(); }  
function LoadFile() { document.getElementById('my_hidden_load').click(); }  


function onResponse(d) 
{  
 //  let htr;
 eval('var obj = ' + d + ';');  
 if(obj.success!=1)
   {
    alert('Ошибка!\nФайл ' + obj.filename + " не загружен - "+obj.myres); 
    return; 
   }; 
 alert('Файл загружен'); 
 
 htr = 'tabletib<br>';
$("div#Privet").html(htr);
}  
