<?php
// *************************************************************************
// *                          Выбрать имя базы данных                      *
// *************************************************************************
function _BaseName() 
{
   $imbasename=$_SERVER['DOCUMENT_ROOT'].'/itimg';
   return $imbasename;
}
// *************************************************************************
// *                       Подключиться к базе данных                      *
// *************************************************************************
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
