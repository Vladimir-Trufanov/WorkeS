<?php
// PHP7/HTML5, EDGE/CHROME                                    *** index.php ***

// ****************************************************************************
// * doortry.ru                                          AJAKS-меню на JQuery *
// * https://webformyself.com/dinamicheskaya-sortirovka-menyu-s-ispolzovaniem-metoda-ajax/*
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
   <title>Сортировка</title>
   <link type="text/css" href="css/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
   <style>
      #sortable { list-style-type: none; margin: 0; padding: 0; width: 200px; }
	   #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em;
         font-size: 1.4em; height: 15px; cursor: pointer;}
	   #sortable li span { position: absolute; margin-left: -1.3em; }
   </style>
</head>

<body>
   <?php
   //$res = mysql_query("SELECT * FROM 'sortable' ORDER BY 'position'") or die(mysql_error());

   echo 'Приветs!<br>';
   /*   
   for($m=0; $m <count($row); $m++)
   {
      echo $row[$m][0].','.$row[$m][1].','.$row[$m][2].','."<br />";
   }
   */

   echo "<ul id='sortable'>\r\n";
   for($m=0; $m <count($row); $m++)
   {
       echo "<li id=".$row[$m][0]." class='ui-state-default'>".$row[$m][1]."</li>\r\n";
   }
   //while($row = mysql_fetch_assoc($res))
   //{
	//  echo "<li id='{$row['id']}' class='ui-state-default'>{$row['name']}</li>\r\n";
   //}
   echo "</ul>";
?>
</body> 
</html>

<?php
// ************************************************************** index.php ***
