<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

if(isset($_GET['verification']) && $_GET['verification']!='') {
	$email_verification	= base64_decode($_GET['verification']);
	$not_a_used_link	= $userObj->account_verification($email_verification);	
	if($not_a_used_link) {
		$_SESSION['msgsuccess'] = "5";
		header('location: index.php');
		exit;
	} else {
		$_SESSION['msgsuccess'] = "6";
		header('location: index.php');
		exit;
	}
}
?>

<div class="container">
	<!------- BANNER-START ----------->
	<?php include_once($DOC_ROOT.'sms_content.php');?>
	<!------- BANNER-END ------------->	
</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>