<?php
// PHP7/HTML5, EDGE/CHROME                                    *** index.php ***

// ****************************************************************************
// * doortry.ru                                       AJAKS-меню на Prototype *
// *                                  https://ruseller.com/lessons.php?id=279 *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  28.10.2019
// Copyright © 2019 tve                              Посл.изменение: 28.10.2019

?>

<!DOCTYPE html>
<html lang="ru">

<head>
   <title>AJAKS-меню на Prototype</title>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"/>

	<style type="text/css" media="screen">
		html
      {
			background: url(img/bg.jpg);
			border: 0px;
			margin: 0;
			padding: 0;
		}
      body
      {
			border: 0px;
			margin: 0;
			padding: 0;
		}		
		#page {
			margin: 0px auto;
			width: 800px;
		}
		#mentveu 
      {
			position: relative;
			height: 500px;
			margin-left: 5px;
		}
		.gallery
      {
			margin: 30px auto;
			width: 80%;	
			padding-top: 10px;
		}
		.menuitem
      {
	   	background: #afec77;
		}
      .menutarget
      {
			background-color:#afec77;
			display: none;
			border-bottom: 5px solid white;
			border-left: 5px solid white;
			border-right: 5px solid white;
		}
      img
      {
			border:0px;
		}
	</style>
   
   <?php
   // Подключаем Prototype — JavaScript фреймворк, упрощающий работу с Ajax и 
   // некоторыми другими низкоуровневыми функциями. Prototype доступен в виде 
   // отдельной библиотеки, также он поставляется в составе Ruby on Rails, 
   // Tapestry, script.aculo.us и Rico:
   // https://ru.wikipedia.org/wiki/Prototype_(%D1%84%D1%80%D0%B5%D0%B9%D0%BC%D0%B2%D0%BE%D1%80%D0%BA)
	echo '<script type="text/javascript" src="js/prototype.js"></script>';
   // Подключаем script.aculo.us — JavaScript-библиотеку для разработки 
   // пользовательского интерфейса веб-приложений, построенная на фреймворке 
   // Prototype:               https://ru.wikipedia.org/wiki/Script.aculo.us
	echo '<script type="text/javascript" src="js/scriptaculous.js?load=effects"></script>';
   ?>
	<script type='text/javascript' src='js/e24tabmenu.js'></script>	
	<script type="text/javascript">
		function initApp() 
      {
			oe24TabMenu = new 
         e24TabMenu('mentveu',{mode:'uppertabs',duration:1.0,transition:Effect.Transitions.sinoidal}); 
		}
		Event.observe(window,'load',initApp,false);
	</script>	
</head>

<body>
   AJAkS-меню на Prototype
   <div id="page">

	<div id="mentveu" ><!---menu  container-->	
		<div id="item_3d" class="menutarget">
			<div class="gallery" >
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.			
			</div>
		</div>
		<div id="item_gall" class="menutarget">
			<div class="gallery">
			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.			
			</div>
		</div>
		<div id="item_menu" class="menutarget">
			<div class="gallery">
			Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? 
			</div>
		</div>
		<div id="item_efec" class="menutarget">
			<div class="gallery">
			Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?			
			</div>
		</div>
	
		<a id="3d" href="#3d" rel="e24menuitem[item_3d]"><img src="img/3d.gif" alt="Efectos 3D" /></a>				
		<a id="gall" href="#galerias" rel="e24menuitem[item_gall]"><img src="img/galerias.gif" alt="Galería de fotos AJAX" /></a>
		<a id="menus" href="#menus" rel="e24menuitem[item_menu]" ><img src="img/menus.gif" alt="Efectos de Menús" /></a>	
		<a id="efec" href="#efectos" rel="e24menuitem[item_efec]"><img src="img/efectos.gif" alt="Otros efectos ajax" /></a>
		
			
	</div><!--menu container-->
	
	<!--End of Menu -->
</div>

   
</body> 
</html>

<?php
// ************************************************************** index.php ***
