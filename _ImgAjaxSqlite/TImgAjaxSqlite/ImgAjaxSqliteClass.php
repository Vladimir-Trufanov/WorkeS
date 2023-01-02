<?php 
                                         
// PHP7/HTML5, EDGE/CHROME                        *** ImgAjaxSqliteClass.php ***

// ****************************************************************************
// *              Реализация загрузки изображений с превью через AJAX         *
// *                     с сохранением в базу данных SQLite                   *
// *                                                                          *
// * v2.0, 31.12.2022                              Автор:       Труфанов В.Е. *
// * Copyright © 2022 tve                          Дата создания:  18.12.2022 *
// ****************************************************************************

/**
 * В примере представлена упрощенная реализация загрузки изображений с превью 
 * через AJAX с сохранением в базу данных SQLite, а также дальнейший их вывод 
 * на примере модуля отзывов.
 *  
 * https://snipp.ru/php/upload-images
 *  
 * Порядок работы с классом:
 * 
 * // Готовим объект для работы с изображениями, где $SiteRoot - корневой каталог
 * // сайта, $urlHome - начальная страница сайта
 * require_once $SiteRoot."/_ImgAjaxSqlite/TImgAjaxSqlite/ImgAjaxSqliteClass.php";
 * $Imgaj=new ImgAjaxSqlite($urlHome."/_ImgAjaxSqlite/TImgAjaxSqlite");
 * // При необходимости создаем базу данных для изображений
 * $imfilename=$Imgaj->imbasename.'.db3';
 * if (!file_exists($imfilename)) $Imgaj->BaseFirstCreate();
 * // Подключаемся к базе данных
 * $impdo=$Imgaj->BaseConnect();
 * // Подключаем шрифты и стили документа
 * echo '<head>';
 * $Imgaj->iniStyles(); 
 * echo '</head>';
 * // Готовим и отрабатываем форму по загрузке изображений
 * echo '<body>'; 
 * $Imgaj->SelImagesSendProcess();
 * echo '</body>'; 
 * 
**/

require_once("aps-common.php");
class ImgAjaxSqlite
{
   // ----------------------------------------------------- СВОЙСТВА КЛАССА ---
   public $imbasename;       // Наименование базы данных изображений 
   protected $pathClass;     // Путь к каталогу файлов класса  
   // ------------------------------------------------------- МЕТОДЫ КЛАССА ---
   public function __construct($pathClass) 
   {
      // Генерируем имя файла базы данных
      $this->imbasename=_BaseName();
      // Принимаем путь к каталогу файлов класса
      $this->pathClass=$pathClass;
      // Трассируем установленные свойства
      \prown\ConsoleLog('$this->pathClass='.$this->pathClass); 
   }
   public function __destruct() 
   {
   }
   // *************************************************************************
   // *                        Подключить стили форм класса                   *
   // *************************************************************************
   public function iniStyles() 
   {
      $FormsStyles=$this->pathClass."/aps-style.css";
      echo '<link rel="stylesheet" type="text/css" href="'.$FormsStyles.'">';
   }
   // *************************************************************************
   // *      Выбрать изображения, доп.информацию и отправить на обработку     *
   // *************************************************************************
   public function SelImagesSendProcess()
   {
      $ImgAfterPost  =$this->pathClass.'/aps-save_reviews.php?pathi='.$this->pathClass;
      $apsUploadImage=$this->pathClass."/aps-upload_image.php";

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
      <?php
      echo '</form>';
      ?> 
 
      <script>
      apsUploadImage="<?php echo $apsUploadImage;?>";
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
		       url: apsUploadImage,
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
   }
   // *************************************************************************
   // *                       Подключиться к базе данных                      *
   // *************************************************************************
   public function BaseConnect() 
   {
      $impdo=_BaseConnect(); 
      return $impdo;
   }
   // *************************************************************************
   // *                       Подключиться к базе данных                      *
   // *************************************************************************
   protected function im_UnlinkFile($filename) 
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
   // *************************************************************************
   // *                  Создать базу таблиц для изображений                  *
   // *************************************************************************
   public function BaseFirstCreate()
   {
      // Получаем спецификацию файла базы данных материалов
      $imfilename=$this->imbasename.'.db3';
      // Проверяем существование и удаляем файл копии базы данных 
      $filenameOld=$this->imbasename.'-copy.db3';
      $this->im_UnlinkFile($filenameOld);
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
      $this->im_UnlinkFile($imfilename);
      \prown\ConsoleLog('Проверено существование и удалён старый файл базы данных: '.$imfilename); 
      $impdo=$this->BaseConnect(); 
      \prown\ConsoleLog('Создан объект PDO и файл базы данных');
      // Создаём таблицы базы данных
      $this->imCreateTables($impdo);
      \prown\ConsoleLog('Созданы таблицы'); 
   }
   // *************************************************************************
   // *      Создать таблицы базы данных и выполнить начальное заполнение     *
   // *************************************************************************
   protected function imCreateTables($pdo)
   {
      try 
      {
         $pdo->beginTransaction();
         // Включаем действие внешних ключей
         $sql='PRAGMA foreign_keys=on;';
         $st = $pdo->query($sql);
         // Создаём 1 таблицу 
         $sql=
         'CREATE TABLE reviews ('.
         'id       INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'.
         'name     VARCHAR NOT NULL,'.
         'text     TEXT    NOT NULL,'.
         'date_add INTEGER NOT NULL  DEFAULT 0)';
         $st = $pdo->query($sql);
         // Создаём 2 таблицу 
         $sql=
         'CREATE TABLE reviews_images ('.
         'id         INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'.
         'reviews_id integer NOT NULL DEFAULT 0,'.
         'filename   varchar NOT NULL)';
         $st = $pdo->query($sql);
         $pdo->commit();
      } 
      catch (Exception $e) 
      {
         // Если в транзакции, то делаем откат изменений
         if ($pdo->inTransaction()) 
         {
            $pdo->rollback();
         }
         // Продолжаем исключение
         throw $e;
      }
   }
}
// ************************************************* ImgAjaxSqliteClass.php ***
