<?php
/******************************************
* @Created on June 08, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/actionHeader.php";

//echo '<pre>';print_r($_POST);echo '</pre>';die;

//kisansan@kisansanchar.com:/public_html/admin/user.php
if(isset($_POST['updatebackuserprofile']) && $_POST['updatebackuserprofile']=='Submit'){	
	$result				=	$userObj->updateRegistration($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
	}	
	header('location: profile.php?action=edit&id='.$_POST['userid'].'');
	exit;
}

//kisansan@192.186.222.198:/public_html/profile.php
if(isset($_POST['updatefrontuserprofile']) && $_POST['updatefrontuserprofile']=='Submit'){	
	$result				=	$userObj->updateRegistration($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
	}	
	header('location: profile.php?action=edit&id='.$_POST['userid'].'');
	exit;
}

//kisansan@192.186.222.198:/public_html/add-project-user.php
if(isset($_POST['submitregisterformbutton']) && $_POST['submitregisterformbutton']!=''){
	$result     = $userObj->registrationProjectUser($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
	}
	header("location: project-profile.php?tab=view");
	exit;	
}

//kisansan@192.186.222.198:/public_html/add-project-user.php
if(isset($_POST['updateprojectassigneduser'])){	
	$result  = $adminObj->functionUpdateProjectAssignedUser($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
	}
	header("location: project-profile.php?tab=view");
	exit;	
}

//kisansan@192.186.222.198:/public_html/add-project-user.php
if(isset($_POST['uploadprojectassignedscientist']) && $_POST['uploadprojectassignedscientist']=='Scientist'){
	$result  = $projectObj->functionaddProjectAssignedContent($tablename='projects_users',$_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
		header("location: view-project-detail.php?tab=".$_POST['project_user_type']."");
		exit;
	}
	$_SESSION['msgerror'] = "8";
	header("location: add-project-detail.php");
	exit;	
}

//kisansan@192.186.222.198:/public_html/add-project-user.php
if(isset($_POST['uploadprojectassignedfarmer']) && $_POST['uploadprojectassignedfarmer']=='Farmer'){
	$result  = $projectObj->functionaddProjectAssignedContent($tablename='projects_users',$_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
		header("location: view-project-detail.php?tab=".$_POST['project_user_type']."");
		exit;
	}
	$_SESSION['msgerror'] = "8";
	header("location: add-project-detail.php");
	exit;	
}

//kisansan@192.186.222.198:/public_html/add-project-user.php
if(isset($_POST['uploadprojectassignedscientistcsv']) && $_POST['uploadprojectassignedscientistcsv']=='Submit'){

	$userDataArray = array();
	if(is_uploaded($_FILES['importcsv']['tmp_name']) && getQuickExtension($_FILES['importcsv']['name'])=='csv'){
		$userDataArray = getCSVData($_FILES['importcsv']['tmp_name']);		
	}
	if(!empty($userDataArray)){
		$userDataArray = array_slice($userDataArray,1);
		$succuss = $projectObj->functionUpdateProjectAssignedUserCSV($userDataArray,$_POST);
		if(!empty($succuss)){
			$registeredCount = (!empty($succuss['registered']))?trim(count($succuss['registered'])):'0';
			$addInUserCount  = (!empty($succuss['in']))?trim(count($succuss['in'])):'0';
			$addOutUserCount = (!empty($succuss['out']))?trim(count($succuss['out'])):'0';
			$haveUserCount   = (!empty($succuss['have']))?trim(count($succuss['have'])):'0';
			$_SESSION['msgheader'] = " Total Registered : ".$registeredCount." | Total Added User : ".$addInUserCount." | Total Out Location User : ".$addOutUserCount." | Total Existing Location User : ".$haveUserCount."";
		}else{
			$_SESSION['msgheader'] = " Total Registered : 0 | Total Added User : 0 | Total Out Location User : 0 | Total Existing Location User : 0 ";
		}
		header("location: view-project-detail.php?tab=".$_POST['project_user_type']."");
		exit;	
	}
	$_SESSION['msgerror'] = "8";
	header("location: add-project-detail.php");
	exit;	
}

//public_html/add-project-location.php
if(isset($_POST['submitaddprojectlocation']) && $_POST['submitaddprojectlocation']=='addlocation'){
	$result = $projectObj->addProjectLocation($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
		header("location: project-profile.php?tab=pls");
		exit;
	}
	$_SESSION['msgerror'] = "8";
	header("location: add-project-location.php");
	exit;
}

//kisansan@192.186.222.198:/public_html/contact.php
if(isset($_POST['submitcontactdetails']) && $_POST['submitcontactdetails']=='Submit'){
	if($_SESSION['security_number'] == $_POST['captcha_code']) {
		$result  = $adminObj->functionAddContactDetail($_POST);
		if($result){
			$_SESSION['msgsuccess'] = "7";
		}else{
			$_SESSION['msgerror']   = '8';
		}
	}else{
		$_SESSION['msgerror']   = '3';
	}
	header("location: contact.php");
	exit;	
}

//kisansan@192.186.222.198:/public_html/carrers.php
if(isset($_POST['submitcarrerdetails']) && $_POST['submitcarrerdetails']=='Submit'){
	$result  = $adminObj->functionAddCarrerDetail($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
	}else{
		$_SESSION['msgerror']   = '8';
	}	
	header("location: carrers.php");
	exit;	
}

?>