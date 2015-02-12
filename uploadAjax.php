<?php
/******************************************
* @Created on JAN 27, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/actionHeader.php";

if(!empty($_FILES['file'])){
	$folder	      = '/uploads/users';
	$formdata[]   = $_FILES['file'];
	$contentid    = $_POST['contentid'];
	$uploadResult = uploadFiles($folder, $formdata, $contentid);
	if(isset($uploadResult['urls']['0'])){
		$coloum_name_str = " `image` = '".$uploadResult['urls']['0']."' ";
		$status = $db->updateUniversalRow($table_name='users', $coloum_name_str, $updated_on_field='id',$updated_on_value=$contentid,$otherfields=null);
		echo '<p>Image Uploaded Successfully</p>';
		echo '<p><a class="button" onclick="javascript:location.reload();" href="javascript:;">OK</a></p>';
		return true;
	} else if(isset($uploadResult['error']['0'])){
		echo 'Error in uploading photo.Please Try Again';
		return true;
	} else {
		echo 'No file Selected';
		return true;
	}	
} else {
	echo 'No file Selected';
}
?>