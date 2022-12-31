<?php
// PHP7/HTML5, EDGE/CHROME                                     *** Main.php ***

// ****************************************************************************
// *                               Загрузка изображений с превью AJAX+SQLite! *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.11.2018
// Copyright © 2018 tve                              Посл.изменение: 18.12.2022

// Указываем место размещения библиотеки прикладных функций TPhpPrown
define ("pathPhpPrown",$SiteHost.'/TPhpPrown/TPhpPrown');
// Указываем место размещения библиотеки прикладных классов TPhpTools
define ("pathPhpTools",$SiteHost.'/TPhpTools/TPhpTools');

// Подключаем файлы библиотеки прикладных модулей:
//require_once pathPhpPrown."/ViewGlobal.php";
//require_once pathPhpPrown."/CommonPrown.php";
//require_once pathPhpPrown."/getTranslit.php";

// Подгружаем нужные модули библиотеки прикладных классов
//require_once pathPhpTools."/TArticlesMaker/ArticlesMakerClass.php";
//require_once pathPhpTools."/TKwinGallery/KwinGalleryClass.php";

// Готовим объект для работы с изображениями
require_once $SiteRoot."/_ImgAjaxSqlite/TImgAjaxSqlite/ImgAjaxSqliteClass.php";

$Imgaj=new ImgAjaxSqlite();
$Imgaj->BaseFirstCreate();
$impdo=$Imgaj->BaseConnect();

// Начинаем разметку документа
echo '
   <!DOCTYPE html>
   <html lang="ru">
   <head>
   <title>Загрузка изображений с превью AJAX+SQLite</title>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   <meta name="description" content="Труфанов Владимир Евгеньевич, Загрузка изображений с превью AJAX+SQLite">
   <meta name="keywords" content="Труфанов Владимир Евгеньевич,Загрузка, изображения, превью, AJAX+SQLite">
';
// Подключаем шрифты и стили документа
//echo '
//   <link rel="stylesheet" type="text/css" href="Styles/Styles.css">
//';
echo '<link rel="stylesheet" type="text/css" href="/_ImgAjaxSqlite/aps-style.css">';
// Подключаем js скрипты 
?> 
   <script src="/Jsx/jquery-1.11.1.min.js"></script>
<?php
// Подгружаем css для выбора материала 
echo '</head>'; 

echo '<body>'; 

   /*
   echo '<pre>';
   print_r( $_FILES );
   echo '</pre>'; 
   */

   $ImgAfterPost=$urlHome."/_ImgAjaxSqlite/TImgAjaxSqlite/aps-save_reviews.php";
   echo '<form method="post" action="'.$ImgAfterPost.'">';
   ?> 
   <h3>Отправить отзыв:</h3>
   <div class="form-row">
      <label>Ваше имя:</label>
	  <input type="text" name="name" required>
   </div>
   <div class="form-row">
      <label>Комментарий:</label>
	  <input type="text" name="text" required>
   </div>
   <div class="form-row">
      <label>Изображения:</label>
	  <div class="img-list" id="js-file-list"></div>
	  <input id="js-file" type="file" name="file[]" multiple accept=".jpg,.jpeg,.png,.gif">
   </div>
   <div class="form-submit">
      <input type="submit" name="send" value="Отправить">
   </div>
   </form>
 
   <script>
   $("#js-file").change(function()
   {
	  if (window.FormData === undefined) 
      {
	     alert('В вашем браузере загрузка файлов не поддерживается');
	  } 
      else 
      {
	     var formData = new FormData();
	     $.each($("#js-file")[0].files, function(key, input)
         {
		    formData.append('file[]', input);
		 });
 
		$.ajax(
        {
		   type: 'POST',
		   url: '/_ImgAjaxSqlite/aps-upload_image.php',
		   cache: false,
		   contentType: false,
	       processData: false,
		   data: formData,
		   dataType : 'json',
		   success: function(msg)
           {
		      msg.forEach(function(row) 
              {
                 if (row.error == '') 
                 {
                    $('#js-file-list').append(row.data);
				 } 
                 else 
                 {
                    alert(row.error);
                 }
			  });
			  $("#js-file").val(''); 
		   }
		});
	  }
   });
 
   /* Удаление загруженной картинки */
   function remove_img(target)
   {
      $(target).parent().remove();
   }
   </script>
   <?php
echo '
   </body>
   </html>
';
 
// *** <!-- --> ************************************************** Main.php ***
