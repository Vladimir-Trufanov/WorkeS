<?php
// PHP7/HTML5, EDGE/CHROME                               *** ViewEnviron.php ***

// ****************************************************************************
// *                     ������� ��������������� ����������                   *
// ****************************************************************************

//                                                   �����:       �������� �.�.
//                                                   ���� ��������:  09.11.2021
// Copyright � 2021 tve                              ����.���������: 09.11.2021

function EnviView()
{
   echo $_SERVER['DOCUMENT_ROOT'].'/iniWorkSpace.php'.'<br>';
   global $SiteRoot;   if (isset($SiteRoot))   echo '$SiteRoot='.$SiteRoot.'<br>';
   global $SiteAbove;  if (isset($SiteAbove))  echo '$SiteAbove='.$SiteAbove.'<br>';
   global $SiteHost;   if (isset($SiteHost))   echo '$SiteHost='.$SiteHost.'<br>';
   global $SiteDevice; if (isset($SiteDevice)) echo '$SiteDevice='.$SiteDevice.'<br>';
   // ����������, ����� ����������� ������� ��������������
   echo '<pre>';
   print_r(gd_info());
   echo '</pre>';
}
// *** <!-- --> ******************************************* ViewEnviron.php ***
