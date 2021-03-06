<?php
// PHP7/HTML5, EDGE/CHROME                                    *** index.php ***

// ****************************************************************************
// * doortry.ru                                          AJAKS-меню на JQuery *
// * https://webformyself.com/dinamicheskaya-sortirovka-menyu-s-ispolzovaniem-metoda-ajax/
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  29.10.2019
// Copyright © 2019 tve                              Посл.изменение: 29.10.2019

// Выбрать массив пунктов меню
function getPmenu($db)
{
    // Делаем выборку данных 
    $sql="SELECT * FROM 'sortable' ORDER BY 'position'";
    /*
    $sql="
    select k.id, k.name, k.position
    from sortable k
    ";
    */
    $st = $db->query($sql);
    $results = $st->fetchAll();
    return $results;
}




//require_once 'db.php'; 
$SiteRoot = $_SERVER['DOCUMENT_ROOT'];       // Корневой каталог сайта


// Подключаем базу данных обеспечения расчетов  
$pathBase='sqlite:'.$SiteRoot.'/sort.db3';                                          
$db = new PDO($pathBase);
// Выбираем массив льготных категорий
$row = getPmenu($db);


?>

<!DOCTYPE html>
<html lang="ru">

<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   <meta name="Description" content="" />
   <meta name="KeyWords" content="" />
   <title> Сортировка ADMIN</title>

<!-- 

<link type="text/css" href="css/jquery-ui-1.8.14.custom.css" rel="stylesheet" />  
<script src="scripts/jquery-1.6.2.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui-1.8.14.custom.min.js" type="text/javascript"></script>
-->
   <link rel="stylesheet" type="text/css" 
      href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css">
   <script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous">
   </script>
   <script
      src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
      integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
      crossorigin="anonymous">
   </script>






<style>
	#sortable { list-style-type: none; margin: 0; padding: 15px 40px 15px 0; width: 200px; }
	#sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 15px; cursor:move}
	#sortable li span { position: absolute; margin-left: -1.3em; }
	.block{/*border:1px solid #ccc;*/ width:200px;}
</style>

<script type="text/javascript">

$(document).ready(function()
{
	$('#sortable').sortable(
   {
      axis: 'y',
		opacity: 0.5,
		placeholder: 'ui-state-default',
		containment: '.block',
      /*
      */
		stop: function()
      {
			var arr = $('#sortable').sortable("toArray");
			alert(arr);
			$.ajax(
         {
				url: 'save.php',
				type: 'POST',
				data: {masiv:arr},
				error: function()
            {
					$('#res').text("Ошибка!");
				},
				success: function()
            {
					$('#res').show().text("Сохранено!").fadeOut(1000);
				}
			});
		}
	});
});
 
</script>

</head>

<body>
   <?php
   echo 'Возьмите пункт меню и перетащите!<br>';

   echo "<div class='block'><ul id='sortable'>\r\n";
   for($m=0; $m <count($row); $m++)
   {
       echo "<li id=".$row[$m][0]." class='ui-state-default'>".$row[$m][1]."</li>\r\n";
   }
   echo "</ul></div>";


?>

<div id="res"></div>
</body> 
</html>

<?php
// ************************************************************** index.php ***
