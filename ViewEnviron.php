<?php
// PHP7/HTML5, EDGE/CHROME                               *** ViewEnviron.php ***

// ****************************************************************************
// *                     Вывести технологическую информацию                   *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  09.11.2021
// Copyright © 2021 tve                              Посл.изменение: 09.11.2021

function EnviView()
{
   echo $_SERVER['DOCUMENT_ROOT'].'/iniWorkSpace.php'.'<br>';
   global $SiteRoot;   if (isset($SiteRoot))   echo '$SiteRoot='.$SiteRoot.'<br>';
   global $SiteAbove;  if (isset($SiteAbove))  echo '$SiteAbove='.$SiteAbove.'<br>';
   global $SiteHost;   if (isset($SiteHost))   echo '$SiteHost='.$SiteHost.'<br>';
   global $SiteDevice; if (isset($SiteDevice)) echo '$SiteDevice='.$SiteDevice.'<br>';
   // Показываем, какие графические форматы поддерживаются
   echo '<pre>';
   print_r(gd_info());
   echo '</pre>';
}
// *** <!-- --> ******************************************* ViewEnviron.php ***
