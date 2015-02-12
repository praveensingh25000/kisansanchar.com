<?php
/******************************************
* @Created on JAN 27, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
include_once $basedir."/include/actionHeader.php";

if(isset($_REQUEST['email'])){
	$email	= $_REQUEST['email'];
	$result	= $userObj->checkEmailExistence($email,$status=1);
	if(!empty($result)) {
		echo 'false';		       
	} else {
		echo 'true';
	}
}

if(isset($_REQUEST['phone'])){
	$phone    = $_REQUEST['phone'];
	$result   = $userObj->checkEmailExistence($phone, $status='');
	if(!empty($result)) {
		echo 'false';		       
	} else {
		echo 'true';
	}
}

if(isset($_REQUEST['adminend']) && isset($_REQUEST['email'])){
	$email  = $_REQUEST['email'];
	$result	= $userObj->checkEmailExistence($email,$status=1);	
	if(isset($_REQUEST['oldemail']) && $_REQUEST['oldemail']!='' && trim($_REQUEST['oldemail']) == trim($email)){
		echo 'true';
		exit;
	}	
	if($result > 0) {
	   	echo 'false';		       
	} else {
		echo 'true';
	}
}

if(isset($_REQUEST['adminend']) && isset($_REQUEST['phone'])){
	$phone   = $_REQUEST['phone'];
	$result  = $userObj->checkEmailExistence($phone, $status='');
	if(isset($_REQUEST['phone']) && $_REQUEST['phone']!='' && trim($_REQUEST['phone']) == trim($phone)){
		echo 'true';
		exit;
	}	
	if($result > 0) {
		echo 'false';		       
	} else {
		echo 'true';
	}
}

?>