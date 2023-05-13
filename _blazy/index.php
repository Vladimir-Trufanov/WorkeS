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
  Images loaded: <b id="loaded-images">0</b>
</div>

<div class="wrapper">
  
  <img class="b-lazy" data-src="ph1.png"                         src="ph1.png" />
  <img class="b-lazy" data-src="p1.png"                          src="ph1.png" />
  <img class="b-lazy" data-src="p2.png"                          src="ph1.png" />
  <img class="b-lazy" data-src="p2.png"                          src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" />
  <img class="b-lazy" data-src="01.jpg"                          src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" />
  <img class="b-lazy" data-src="04.jpg"                          src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" />
  <img class="b-lazy" data-src="06.jpg"                          src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" />

  <img class="b-lazy" data-src="Бревно на медведя.jpg"           src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" />
  <img class="b-lazy" data-src="Карта прогулки.jpg"              src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" />
  <img class="b-lazy" data-src="Медведь-пошел-туда.jpg"          src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" />
  <img class="b-lazy" data-src="Медведь-шел-след-в-след.jpg"     src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" />
  <img class="b-lazy" data-src="Размыло дорогу.jpg"              src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" />
  <img class="b-lazy" data-src="Следы-не-свежие,-но-догоним.jpg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" />
  <img class="b-lazy" data-src="Шапша весной.jpg"                src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" />
  <img class="b-lazy" data-src="Шапша-в-половодье.jpg"           src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" />

</div>


';

echo '<script src="Proba.js"></script>';



echo '</body>'; 
echo '</html>';





function SeoTags(&$ttl,&$desc,&$keys)
{
   $ttl='Обо мне, путешествиях и ... Черногории';
   $desc='Труфанов Владимир Евгеньевич, его жизнь и увлечения, жизнь его близких';
   $keys='Труфанов Владимир Евгеньевич, жизнь, увлечения';
}


// <!-- --> **************************************************** UpSite.php ***


