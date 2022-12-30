function gali(varName)
{
   //alert(varName);
   var $mew=varName;
            
   $.ajax
   ({
      url: 'save.php',
      type: 'POST',
      data: {mess:$mew},
      async: false,
      error: function()
      {
         $('#res').text("Ошибка!");
      },
      success: function(message)
      {
         //alert(message);
         console.log(message);
         $('#res').show().text("Сохранено!").fadeOut(1000);
      }
   });
}
