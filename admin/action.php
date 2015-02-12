<?php
/******************************************
* @Created on JAN 27, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
include_once $basedir."/include/actionHeader.php";

//echo '<pre>';print_r($_POST);echo '</pre>';die;

//kisansan@192.186.222.198:/public_html/admin/addProject.php
if(isset($_POST['submitprojectforms']) && $_POST['submitprojectforms']=='Submit'){	
	$result  = $adminObj->functionAddProject($_POST);
	$_SESSION['msgsuccess'] = "7";
	header("location: addProject.php");
	exit;	
}
//kisansan@192.186.222.198:/public_html/admin/addProject.php
if(isset($_POST['updateprojectforms'])){	
	$result  = $adminObj->functionUpdateproject($_POST);
	$_SESSION['msgsuccess'] = "7";
	header("location: addProject.php?id=".$_POST['id']."&action=".$_POST['action']."");
	exit;	
}
//kisansan@192.186.222.198:/public_html/admin/user.php
if(isset($_GET['action']) && $_GET['action'] == "delete"){
	$parent_id		=	 $_GET['id'];
	$id				=	 trim($_GET['deleteid']);
	$user->deleteUserPermanent($id, $parent_id);
	header('location:user.php?action=view&id='.$parentid.'');
	exit;
}
//kisansan@192.186.222.198:/public_html/admin/user.php
if(isset($_POST['updateuserprofileadmin']) && $_POST['updateuserprofileadmin']=='Submit'){	
	$result				=	$userObj->updateRegistration($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
	}
	header('location: user.php?action=edit&id='.$_POST['userid'].'');
	exit;
}
//kisansan@192.186.222.198:/public_html/admin/users.php
if(isset($_POST['actionperform']) && $_POST['actionperform']!=''){
	$action		= strtolower($_POST['actionperform']);
	$ids		= implode(',', $_POST['ids']);
	$showurl	= trim($_POST['show']);	
	$tablename='users';	
	if($action =='active'){
		$_SESSION['msgsuccess'] = "9";
		$status=0;  
	} else if($action =='in-active'){	
		$_SESSION['msgsuccess'] = "9";
		$status=1;  
	} else if($action =='delete'){
		$_SESSION['msgsuccess'] = "9";
		$status=1; 
	}
	$return = $adminObj->activedeactiveStatus($tablename, $ids, $action,$status);
	header('location: users.php?show='.$showurl.' ');
	exit;
}
?>
