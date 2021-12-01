<?php
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- https://habr.com/ru/post/245689/ -->
   <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   <title>Единственная кнопка для загрузки файла</title>
   <link rel="stylesheet" href="css/style.css" type="text/css" media="screen, projection" />
</head>
<body>
   <div class="navButtons" onclick="FindFile();" title="Загрузка файла"><img src="buttons/openfile.png"   width=100% height=100%/></a></div>
   <form action="view/upload.php" target="rFrame" method="POST" enctype="multipart/form-data">  
   <div class="hiddenInput">
      <input type="file"   id="my_hidden_file" accept="image/jpeg,image/png,image/gif" name="loadfile" onchange="LoadFile();">  
      <input type="submit" id="my_hidden_load" style="display: none" value='Загрузить'>  
   </div>
   </form>
   <iframe id="rFrame" name="rFrame" style="display: none"> </iframe>  
   <script src="js/upload.js"> </script>

