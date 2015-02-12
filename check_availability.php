<?php
/******************************************
* @Created on JAN 27, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/actionHeader.php";

if(isset($_GET['email'])){
	$email	= $_GET['email'];
	$result	= $userObj->checkEmailExistence($email,$status=1);
	if(!empty($result)) {
		echo 'false';		       
	} else {
		echo 'true';
	}
}

if(isset($_GET['phone'])){
	$phone    = $_GET['phone'];
	$result   = $userObj->checkEmailExistence($phone, $status='');
	if(!empty($result)) {
		echo 'false';		       
	} else {
		echo 'true';
	}
}
?>