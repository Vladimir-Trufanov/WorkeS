<?php
// PHP7/HTML5, EDGE/CHROME                              *** SignaUpload.php ***

// ****************************************************************************
// * SignaPhoto  ����������� ����������� ���� �� ���������� ��������� �� ������
// ****************************************************************************

//                                                   �����:       �������� �.�.
//                                                   ���� ��������:  25.11.2021
// Copyright � 2021 tve                              ����.���������: 03.12.2021




   function alf_jsOnResponse($obj)  
   {  
      echo '<script type="text/javascript"> window.parent.alfOnResponse("'.$obj.'"); </script> ';  
   exit;
   }  

// ���������� ����������� (PHP-JScript) �����������
require_once 'SignaPhotoDef.php';

// ���������� ������� ������������ ��������
require_once $_SERVER['DOCUMENT_ROOT'].'/iniWorkSpace.php';
$_WORKSPACE=iniWorkSpace();
$SiteHost=$_WORKSPACE[wsSiteHost];    // ������� ��������

   $TPhpPrown  = $SiteHost.'/TPhpPrown/TPhpPrown';
   require_once $TPhpPrown."/CommonPrown.php";
   //prown\ConsoleLog('SignaUpload12'); 
   
   // ���������� ����� ���������� ���������� �������:
   $TPhpTools=$SiteHost.'/TPhpTools/TPhpTools';
   require_once $TPhpTools."/TUploadToServer/UploadToServerClass.php";
   prown\ConsoleLog($TPhpTools."/TUploadToServer/UploadToServerClass.php"); 
   //include $TPhpTools."/TUploadToServer/UploadToServerClass.php";




// ���������� ���� ����� ��������� �� �������/����������� � ������������ 
// �������� � ������� ���������, � ����� ������������ ��� PHP5-PHP7
require_once $SiteHost."/TDoorTryer/DoorTryerPage.php";
try 
{

      // ������������ ������ ��� ���������� ����� �� ������ � �������������� ���������
      //$upload = new ttools\UploadToServer($_SERVER['DOCUMENT_ROOT'].'/'.'i'.$imgDir.'/');
      $upload = new ttools\UploadToServer('fili.png');

    $i=0; $j=5/$i; echo $j;
     
   $dir = '../temp/';  
   $name = basename($_FILES['loadfile']['name']);  
   $file = $dir . $name;  
   prown\ConsoleLog('SignaUpload: '.$file); 
   $success = move_uploaded_file($_FILES['loadfile']['tmp_name'], $file);  
   alf_jsOnResponse("{'filename':'" . $name . "', 'success':'" . $success . "'}");
   
   
}
catch (E_EXCEPTION $e) 
{
   DoorTryPage($e);
}
// ******************************************************** SignaUpload.php ***
