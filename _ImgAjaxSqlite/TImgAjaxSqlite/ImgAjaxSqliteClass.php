<?php
                                         
// PHP7/HTML5, EDGE/CHROME                        *** ImgAjaxSqliteClass.php ***

// ****************************************************************************
// *                  Фрэйм галереи изображений, связанных с текущим *
// *                   материалом (uid) из выбранной (указанной) группы (pid) *
// *                                                                          *
// * v2.0, 31.12.2022                              Автор:       Труфанов В.Е. *
// * Copyright © 2022 tve                          Дата создания:  18.12.2022 *
// ****************************************************************************

/**
 *
 * 
**/

// Свойства:
//
// --- $FltLead - команда управления передачей данных. По умолчанию fltNotTransmit,
//            то есть данные о загрузке не передаются для контроля ни в кукисы, 
// ни в консоль, а только записываются в LocalStorage. Если LocalStorage,
// браузером не поддерживается, то данные будут записываться в кукисы при 
// установке свойства $FltLead в значение fltSendCookies или fltAll 
// $Page - название страницы сайта;
// $Uagent - браузер пользователя;

// Подгружаем нужные модули библиотеки прикладных функций
//require_once pathPhpPrown."/CommonPrown.php";
// Подгружаем нужные модули библиотеки прикладных классов
//require_once pathPhpTools."/TArticlesMaker/ArticlesMakerClass.php";

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
