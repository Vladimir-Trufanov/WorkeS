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
// *      ������� ������� ���� ������ � ��������� ��������� ����������        *
// ****************************************************************************
function imCreateTables($pdo)
{
   try 
   {
      $pdo->beginTransaction();
      // �������� �������� ������� ������
      $sql='PRAGMA foreign_keys=on;';
      $st = $pdo->query($sql);
      // ������ 1 ������� 
      $sql=
      'CREATE TABLE reviews ('.
      'id       INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'.
      'name     VARCHAR NOT NULL,'.
      'text     TEXT    NOT NULL,'.
      'date_add INTEGER NOT NULL  DEFAULT 0)';
      $st = $pdo->query($sql);
      // ������ 2 ������� 
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
      // ���� � ����������, �� ������ ����� ���������
      if ($pdo->inTransaction()) 
      {
         $pdo->rollback();
      }
      // ���������� ����������
     throw $e;
   }
}
