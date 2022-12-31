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
//$Imgaj-> BaseFirstCreate();

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
/// Подключаем js скрипты 
?> 
   <script src="/Jsx/jquery-1.11.1.min.js"></script>
<?php
// Подгружаем css для выбора материала 
echo '</head>'; 

echo '<body>'; 
// Включаем в разметку див галереи изображений и всплывающее окно 
// ----------------------------------------------------------------------------
// Cоздаем объект для управления изображениями в галерее, связанной с 
// материалами сайта из базы данных
//$Galli=new ttools\KwinGallery(gallidir,nym,$pid,$uid);
//$Galli->ViewGallery(gallidir,$apdo);
         
// Подключаем загрузку  
require_once $SiteRoot."/_ImgAjaxSqlite/aps-workbase.php";

   // Создаем базу таблиц для изображений
   $imbasename=$_SERVER['DOCUMENT_ROOT'].'/itimg'; $imusername='tve'; $impassword='23ety17'; 
   // Получаем спецификацию файла базы данных материалов
   $imfilename=$imbasename.'.db3';
   // Проверяем существование и удаляем файл копии базы данных 
   $filenameOld=$imbasename.'-copy.db3';
   im_UnlinkFile($filenameOld);
   \prown\ConsoleLog('Проверено существование и удалена копия базы данных: '.$filenameOld);  
   // Создаем копию базы данных
   if (file_exists($imfilename)) 
   {
      if (rename($imfilename,$filenameOld))
      {
         \prown\ConsoleLog('Получена копия базы данных: '.$filenameOld);  
      }
      else
      {
         \prown\ConsoleLog('Не удалось переименовать базу данных: '.$imfilename);
      }
   } 
   else 
   {
      \prown\ConsoleLog('Прежней версии базы данных '.$imfilename.' не существует');
   }
   // Проверяем существование и удаляем файл базы данных 
   im_UnlinkFile($imfilename);
   \prown\ConsoleLog('Проверено существование и удалён старый файл базы данных: '.$imfilename);  
   // Создается объект PDO и файл базы данных
   $impathBase='sqlite:'.$imfilename; 
   // Подключаем PDO к базе
   $impdo = new \PDO(
      $impathBase, 
      $imusername,
      $impassword,
      array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
   );
   \prown\ConsoleLog('Создан объект PDO и файл базы данных');
   // Создаём таблицы базы данных
   imCreateTables($impdo);
   \prown\ConsoleLog('Созданы таблицы'); 
   
   /*
   echo '<pre>';
   print_r( $_FILES );
   echo '</pre>'; 
   */
   
   ?> 
   <form method="post" action="/_ImgAjaxSqlite/aps-save_reviews.php">
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

function im_UnlinkFile($filename)
{
   if (file_exists($filename)) 
   {
      if (!unlink($filename))
      {
         // Для файла базы данных выводится сообщение о неудачном удалении 
         // в случаях:
         //    а) база данных подключена к стороннему приложению;
         //    б) база данных еще привязана к другому объекту класса;
         //    в) прочее
         throw new Exception("Не удалось удалить файл $filename!");
      } 
   } 
}

 
// *** <!-- --> ************************************************** Main.php ***
