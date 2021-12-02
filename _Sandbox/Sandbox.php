<?php
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- https://habr.com/ru/post/245689/ -->
   <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   <title>Единственная кнопка для загрузки файла</title>
   <link rel="stylesheet" href="css/style.css" type="text/css" media="screen, projection" />
   
   <!-- Подключаем jquery/jquery-ui -->
   <link rel="stylesheet" href="/Jsx/jqueryui-1.13.0.min.css"/> 
   <!-- <script src="/Jsx/jquery-1.11.1.min.js"></script>  -->
   <script src="/Jsx/jquery-3.6.0.min.js"></script>
   <script src="/Jsx/jqueryui-1.13.0.min.js"></script>
   <!-- Подключаем font-awesome -->
   <link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
   <div id="Privet">
   <p>Привет!</p>
   </div>
   <!-- <div class="navButtons" onclick="FindFile();" title="Загрузка файла"><img src="buttons/openfile.png" width=100% height=100%/></div> -->
   <!-- <div class="naviButtons" onclick="FindFile();" title="Загрузка файла">Это текст</div> -->
   <div class="navButtons" onclick="FindFile();" title="Загрузка файла"><i id="iLoadImg" class="fa fa-file-image-o fa-3x" aria-hidden="true"></i></div>
   <form action="view/upload.php" target="rFrame" method="POST" enctype="multipart/form-data">  
   <div class="hiddenInput">
      <input type="file"   id="my_hidden_file" accept="image/jpeg,image/png,image/gif" name="loadfile" onchange="LoadFile();">  
      <input type="submit" id="my_hidden_load" style="display: none" value='Загрузить'>  
   </div>
   </form>
   <iframe id="rFrame" name="rFrame" style="display: none"> </iframe>  
   <script src="js/upload.js"> </script>
</body>
</html>
