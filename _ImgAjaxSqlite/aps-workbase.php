<?php

/*
CREATE TABLE `reviews` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date_add` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 
ALTER TABLE `reviews` ADD PRIMARY KEY (`id`);
ALTER TABLE `reviews` MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

CREATE TABLE `reviews_images` (
  `id` int(11) UNSIGNED NOT NULL,
  `reviews_id` int(11) NOT NULL DEFAULT '0',
  `filename` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 
ALTER TABLE `reviews_images` ADD PRIMARY KEY (`id`);
ALTER TABLE `reviews_images` MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
*/

// ****************************************************************************
// *      Создать таблицы базы данных и выполнить начальное заполнение        *
// ****************************************************************************
function imCreateTables($pdo)
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
