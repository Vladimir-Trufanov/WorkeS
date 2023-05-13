<?php
echo '<!DOCTYPE html>';
echo '<html lang="ru">';

echo '<head>';
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
SeoTags($ttl,$desc,$keys);
echo '<title>'.$ttl.'</title>';
echo '<meta name="description" content="'.$desc.'">';
echo '<meta name="keywords" content="'.$keys.'">';
// Выполняем сброс стилей и устанавливаем начальные настройки стилей
echo '<link rel="stylesheet" type="text/css" href="Styles.css">';
// Подключаем скрипты внутренних классов 
echo '<script src="blazy.min.js"></script>';
echo '</head>'; 
echo '<body>'; 


echo 'Привет!';
echo '
<div class="info">
  <!--
  Images loaded: <b id="loaded-images">0</b>
  -->
</div>

<div class="wrapper">
  <img class="b-nolazy" src="ph1.png">
  <img class="b-nolazy" src="p1.png">
  <img class="b-nolazy" src="p2.png">
  <img class="b-nolazy" src="p2.png">
  <img class="b-nolazy" src="01.jpg">
  <img class="b-nolazy" src="04.jpg">
  <img class="b-nolazy" src="06.jpg">
  <img class="b-nolazy" src="Бревно на медведя.jpg">
  <img class="b-nolazy" src="Карта прогулки.jpg">
  <img class="b-nolazy" src="Медведь-пошел-туда.jpg">
  <!--
  <img class="b-nolazy" src="Медведь-шел-след-в-след.jpg">
  <img class="b-nolazy" src="Размыло дорогу.jpg">
  <img class="b-nolazy" src="Следы-не-свежие-но-догоним.jpg">
  <img class="b-nolazy" src="Шапша весной.jpg">
  <img class="b-nolazy" src="Шапша-в-половодье.jpg">
   -->
</div>


';

//echo '<script src="Proba.js"></script>';



echo '</body>'; 
echo '</html>';





function SeoTags(&$ttl,&$desc,&$keys)
{
   $ttl='Обо мне, путешествиях и ... Черногории';
   $desc='Труфанов Владимир Евгеньевич, его жизнь и увлечения, жизнь его близких';
   $keys='Труфанов Владимир Евгеньевич, жизнь, увлечения';
}


// <!-- --> **************************************************** UpSite.php ***


