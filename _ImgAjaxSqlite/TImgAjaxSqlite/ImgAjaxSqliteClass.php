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
 * Первое что понадобится: HTML форма и JS скрипт, который после выбора одного 
 * или несколькольких файлов отправит их на aps-upload_image.php через AJAX.
 * 
**/

class ImgAjaxSqlite
{
   // ----------------------------------------------------- СВОЙСТВА КЛАССА ---
   protected $imbasename;  // База данных изображений

   // ------------------------------------------------------- МЕТОДЫ КЛАССА ---
   public function __construct() 
   {
      // Получаем спецификацию файла базы данных
      $this->imbasename=$_SERVER['DOCUMENT_ROOT'].'/itimg';
      // Трассируем установленные свойства
      //\prown\ConsoleLog('$this->gallidir='.$this->gallidir); 
   }
   
   public function __destruct() 
   {
   }
   // *************************************************************************
   // *      Выбрать изображения, доп.информацию и отправить на обработку     *
   // *************************************************************************
   public function SelImagesSendProcess()
   {
   /*
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
 
   // Удаление загруженной картинки
   function remove_img(target)
   {
      $(target).parent().remove();
   }
   </script>
   <?php
   */
   } 
   // *************************************************************************
   // *                       Подключиться к базе данных                      *
   // *************************************************************************
   public function im_UnlinkFile($filename) 
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
   // *                       Подключиться к базе данных                      *
   // *************************************************************************
   public function BaseConnect() 
   {
      $imusername='tve'; 
      $impassword='23ety17'; 
      $impathBase='sqlite:'.$this->imbasename.'.db3'; 
      // Подключаем PDO к базе
      $impdo = new \PDO(
         $impathBase, 
         $imusername,
         $impassword,
         array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
      );
      return $impdo;
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
   public function imCreateTables($pdo)
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



   protected function MakeaCharters($apdo)
   {
      //$t1=SelRecord($apdo,$this->pid);
      //$t2=SelRecord($apdo,$this->uid);
      /*
      echo '<pre>';
      print_r($t1);
      echo '</pre>';
      */
      /*
      $aCharters=[                                                          
         [            1,             0,              -1,        'ittve.me',                '/', acsAll,             '20',''],
         [$t1[0]['uid'], $t1[0]['pid'], $t1[0]['IdCue'], $t1[0]['NameArt'], $t1[0]['Translit'], acsAll,$t1[0]['DateArt'],''],
         [$t2[0]['uid'], $t2[0]['pid'], $t2[0]['IdCue'], $t2[0]['NameArt'], $t2[0]['Translit'], acsAll,$t2[0]['DateArt'],''],
         [           21,             0,              -1,       'ittve.end',                '/', acsAll,             '20','']
      ];  
      */     
      //return $aCharters;
   }
   // --------------------------------------------------- ВНУТРЕННИЕ МЕТОДЫ ---
} 

// ************************************************* ImgAjaxSqliteClass.php ***
