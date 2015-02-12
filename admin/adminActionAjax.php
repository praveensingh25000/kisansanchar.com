<?php
/******************************************
* @Created on JAN 27, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once ("../include/actionHeader.php");

if(isset($_GET['settingsaved'])){
	$result  = $langObj->functionUpdateSetting($_POST);
	echo $langVariables['msg_var']['common_update'];
	return true;	
}

if(isset($_GET['modulesaved'])){
	$result  = $langObj->functionUpdateModule($_POST);
	echo $langVariables['msg_var']['common_update'];
	return true;	
}
?>