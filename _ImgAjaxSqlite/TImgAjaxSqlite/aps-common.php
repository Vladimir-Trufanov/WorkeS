<?php
// ****************************************************************************
// *                           Выбрать имя базы данных                        *
// ****************************************************************************
function _BaseName() 
{
   $imbasename=$_SERVER['DOCUMENT_ROOT'].'/itimg';
   return $imbasename;
}
// ****************************************************************************
// *                         Подключиться к базе данных                       *
// ****************************************************************************
function _BaseConnect() 
{
   $imbasename=_BaseName();
   $imusername='tve'; 
   $impassword='23ety17'; 
   $impathBase='sqlite:'.$imbasename.'.db3'; 
   // Подключаем PDO к базе
   $impdo = new \PDO(
      $impathBase, 
      $imusername,
      $impassword,
      array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
   );
   return $impdo;
}
// ****************************************************************************
// *                         Подключить стили форм класса                     *
// ****************************************************************************
function _iniStyles($pathClass) 
{
   $FormsStyles=$pathClass."/aps-style.css";
   echo '<link rel="stylesheet" type="text/css" href="'.$FormsStyles.'">';
   echo '
   <style>
   .img-item a 
   {
	  background: url('.$pathClass.'/remove.png) 0 0 no-repeat;
   }
   </style>
   ';
}
