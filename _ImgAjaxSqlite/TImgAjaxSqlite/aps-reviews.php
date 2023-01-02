<?php
                                           
// PHP7/HTML5, EDGE/CHROME                              *** aps-reviews.php ***

// ****************************************************************************
// *                             Вывести отзывы с фотографиями из базы данных *
// *                                                                          *
// * v2.0, 02.01.2023                              Автор:       Труфанов В.Е. *
// * Copyright © 2022 tve                          Дата создания:  18.12.2022 *
// ****************************************************************************

require_once("aps-common.php");
// Вытаскиваем из параметра путь к файлам класса 
$pathClass='';
if (IsSet($_REQUEST['pathi']))
{ 
   $pathClass=$_REQUEST['pathi'];
}
// Подключаем стили форм класса  
echo '<head>';
_iniStyles($pathClass);
echo '</head>'; 
// Формируем тело скрипта
echo '<body>'; 
   // Подключаем БД
   $dbh=_BaseConnect();
   // Выбираем все отзывы из таблицы авторов и комментариев 
   // по устареванию даты создания записей
   $sth=$dbh->prepare('SELECT * FROM reviews ORDER BY date_add DESC');
   $sth->execute();
   $items=$sth->fetchAll(PDO::FETCH_ASSOC);
   // Если отзывы есть, то формируем страницу с отзывами
   if (!empty($items)) 
   {
      ?>
      <h2>Отзывы</h2>
      <div class="reviews">
      <?php
      foreach ($items as $row) 
      {
         // Выбираем список всех изображений по очередному отзыву
         $sth=$dbh->prepare('SELECT * FROM reviews_images WHERE reviews_id = ?');
         $sth->execute(array($row['id']));
         $images = $sth->fetchAll(PDO::FETCH_ASSOC);
         // Формируем фрагмент страницы со всеми изображениями очередного отзыва
         ?>
         <div class="reviews_item">
         <div class="reviews_item-name"><?php echo $row['name']; ?></div>
         <div class="reviews_item-text"><?php echo $row['text']; ?></div>
         <?php if (!empty($images)): ?>
         <div class="reviews_item-images">
         <?php foreach($images as $img): ?>
            <div class="reviews_item-img">
            <?php 
            $name = pathinfo($img['filename'], PATHINFO_FILENAME);
            $ext = pathinfo($img['filename'], PATHINFO_EXTENSION);
            ?>
            <a href="/uploads/<?php echo $img['filename']; ?>" target="_blank">
               <img src="/uploads/<?php echo $name . '-thumb.' . $ext; ?>">
            </a>
            </div>
         <?php endforeach; ?>
         </div>
         <?php endif; ?>
         </div>
         <?php
      }
      ?>
      </div>
      <?php
   }
echo '</body>'; 

// ******************************************************** aps-reviews.php ***
