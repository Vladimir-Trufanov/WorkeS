<?php
// Вытаскиваем из параметра путь к файлам класса 
$pathClass='';
if (IsSet($_REQUEST['pathi']))
{ 
   $pathClass=$_REQUEST['pathi'];
}

//require_once("aps-common.php");


echo '
   <!DOCTYPE html>
   <html lang="ru">
   <head>
   <title>KwinTiny-редактор материалов!</title>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   <meta name="description" content="Труфанов Владимир Евгеньевич, редактор материалов TinyMCE">
   <meta name="keywords" content="Труфанов Владимир Евгеньевич,KwinTiny,TinyMCE,редактор материалов">
';
//echo '<link rel="stylesheet" type="text/css" href="/_ImgAjaxSqlite/aps-style.css">';
echo '<link rel="stylesheet" type="text/css" href="'.$pathClass.'/aps-style.css">';
echo '</head>'; 
echo '<body>'; 

// Подключение к БД.
// $dbh = new PDO('mysql:dbname=db_name;host=localhost', 'логин', 'пароль');
// $dbh = new PDO('mysql:dbname=db_name;host=localhost', 'логин', 'пароль');

   $imbasename=$_SERVER['DOCUMENT_ROOT'].'/itimg'; $imusername='tve'; $impassword='23ety17'; 
   // Получаем спецификацию файла базы данных материалов
   $imfilename=$imbasename.'.db3';
   $impathBase='sqlite:'.$imfilename; 
   // Подключаем PDO к базе
   $dbh = new \PDO(
      $impathBase, 
      $imusername,
      $impassword,
      array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
   );

$sth = $dbh->prepare("SELECT * FROM `reviews` ORDER BY `date_add` DESC");
$sth->execute();
$items = $sth->fetchAll(PDO::FETCH_ASSOC);

if (!empty($items)) {

    echo '$pathClass='.$pathClass.'<br>';

    ?>
    <h2>Отзывы</h2>
    <div class="reviews">
        <?php
        foreach ($items as $row) {
            $sth = $dbh->prepare("SELECT * FROM `reviews_images` WHERE `reviews_id` = ?");
            $sth->execute(array($row['id']));
            $images = $sth->fetchAll(PDO::FETCH_ASSOC);
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
?>