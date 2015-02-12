<?php
/******************************************
* @Created on June 08, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/actionHeader.php";

//echo '<pre>';print_r($_POST);echo '</pre>';
//echo '<pre>';print_r($_FILES);echo '</pre>';die;

//VOICE TYPE IN BULK**********************************************
if(isset($_POST['voice_type']) && $_POST['voice_type']=='bulk'){

	//echo '<pre>';print_r($_FILES);echo '</pre>';
	//echo '<pre>';print_r($_POST);echo '</pre>';die;

	$user_list = $user_group_str = $user_sub_group_str = $user_sub_group_other_str = $csv_file = $csv_path = $wave_file = $audio_path = $state = $district = $job_type = $country = '';
	
	$msg_id = $msgObj->functionAddSmsAndriodMsg($_POST);
	if($msg_id){	

		$date				= trim($_POST['date']);
		$job_type		    = trim($_POST['job_type']);
		$country		    = (isset($_POST['country']))?trim($_POST['country']):'';
		$state		        = (isset($_POST['state']))?trim($_POST['state']):'';
		$district	        = (isset($_POST['district']))?trim($_POST['district']):'';
		$language_type      = (isset($_POST['language_type']))?trim($_POST['language_type']):'en';
		$uploadFolder	    = '/uploads/temp';		
		
		$wav_audio_upload[] = $_FILES['wav_audio_upload'];
		$wavuploadResult    = uploadAllTypeFiles($uploadFolder, $wav_audio_upload);
		if(isset($wavuploadResult['urls']['0'])){
			$wave_file      = $wavuploadResult['urls']['0'];
			$audio_path     = $URL_SITE.'/uploads/temp/'.$wave_file;
		}

		$csv_file_upload[]  = $_FILES['csv_file_upload'];
		$csvuploadResult    = uploadAllTypeFiles($uploadFolder, $csv_file_upload);
		if(isset($csvuploadResult['urls']['0'])){
			$csv_file       = $csvuploadResult['urls']['0'];
			$csv_path       = $URL_SITE.'/uploads/temp/'.$csv_file;
		}

		if(empty($wave_file) && empty($csv_file)){
			$db->deleteUniversalRow(" message_".$language_type." ",$updated_on_field='id',$msg_id,$otherfields=null);
			$_SESSION['errormsg']   = 'Error in uploading file.Please try again!';
			return;
		}
		$result = $msgObj->functionAddVoiceFileCSVFile($msg_id, $wave_file, $csv_file, $user_group_str, $user_sub_group_str, $user_sub_group_other_str, $job_type, $country , $state, $district, $language_type, $date);
		if(!$result){
			if(file_exists(DOC_ROOT."uploads/temp/".$wave_file)){
				unlink(DOC_ROOT."uploads/temp/".$wave_file);
			}
			if(file_exists(DOC_ROOT."uploads/temp/".$csv_file)){
				unlink(DOC_ROOT."uploads/temp/".$csv_file);
			}
			$db->deleteUniversalRow(" message_".$language_type." ",$updated_on_field='id',$msg_id,$otherfields=null);
			$_SESSION['errormsg']   = 'Message insertion Error.Please try again!';
			return;
		}

		//echo '<pre>';print_r($wavuploadResult);echo '</pre>';
	    //echo '<pre>';print_r($csvuploadResult);echo '</pre>';
		//echo '<pre>';print_r($_FILES);echo '</pre>';
	    //echo '<pre>';print_r($_POST);echo '</pre>';die;

		$_SESSION['successmsg'] = 'Message saved succussfully.';		
	}else{
		$_SESSION['errormsg']   = 'Message insertion Error.Please try again!';
	}

	header("location: mydashboard.php");
	exit;
}

//VOICE TYPE IN GROUP************************************************************
if(isset($_POST['voice_type']) && $_POST['voice_type']=='group'){

	//echo '<pre>';print_r($_FILES);echo '</pre>';
	//echo '<pre>';print_r($_POST);echo '</pre>';die;

	$userDetail = array();

	$user_list = $user_group_str = $user_sub_group_str = $user_sub_group_other_str = $csv_file = $csv_path = $wave_file = $audio_path = $state = $district = $job_type = $country = '';
	
	$msg_id = $msgObj->functionAddSmsAndriodMsg($_POST);
	if($msg_id){

		$date				= trim($_POST['date']);
		$job_type			= trim($_POST['job_type']);
		$country		    = (isset($_POST['country']))?trim($_POST['country']):'';
		$state		        = (isset($_POST['state']))?trim($_POST['state']):'';
		$district	        = (isset($_POST['district']))?trim($_POST['district']):'';
		$language_type		= (isset($_POST['language_type']))?trim($_POST['language_type']):'en';
		$uploadFolder		= '/uploads/temp';
		
		$wav_audio_upload[] = $_FILES['wav_audio_upload'];
		$wavuploadResult    = uploadAllTypeFiles($uploadFolder, $wav_audio_upload);
		if(isset($wavuploadResult['urls']['0'])){
			$wave_file      = $wavuploadResult['urls']['0'];
			$audio_path     = $URL_SITE.'/uploads/temp/'.$wave_file;
		}

		if(!empty($_POST['user_group'])){
			$user_group_str       = implode(',', $_POST['user_group']);
		}
		
		if(!empty($_POST['user_sub_group'])){
			$user_sub_group_str   = implode(',', $_POST['user_sub_group']);
		}

		if(!empty($_POST['user_sub_group_other'])){
			$user_sub_group_other_str = implode(',', $_POST['user_sub_group_other']);
		}	

		if(empty($wave_file)){
			$db->deleteUniversalRow(" message_".$language_type." ",$updated_on_field='id',$msg_id,$otherfields=null);
			$_SESSION['errormsg']   = 'Error in uploading file.Please try again!';
			return;
		}

		$result = $msgObj->functionAddVoiceFileCSVFile($msg_id, $wave_file, $csv_file='',  $user_group_str, $user_sub_group_str, $user_sub_group_other_str, $job_type, $country , $state, $district, $language_type, $date);
		if(!$result){
			if(file_exists(DOC_ROOT."uploads/temp/".$wave_file)){
				unlink(DOC_ROOT."uploads/temp/".$wave_file);
			}
			$db->deleteUniversalRow(" message_".$language_type." ",$updated_on_field='id',$msg_id,$otherfields=null);
			$_SESSION['errormsg']   = 'Message insertion Error.Please try again!';
			return;
		}

		$_SESSION['successmsg'] = 'Message has been saved succussfully.';
	}else{
		$_SESSION['errormsg']   = 'Message insertion Error.Please try again!';
	}

	header("location: mydashboard.php");
	exit;
}

//TEXT TYPE IN BULK**********************************************
if(isset($_POST['sms_type']) && $_POST['sms_type']=='bulk'){

	//echo '<pre>';print_r($_FILES);echo '</pre>';
	//echo '<pre>';print_r($_POST);echo '</pre>';die;

	$user_list = $user_group_str = $user_sub_group_str = $user_sub_group_other_str = $csv_file = $csv_path = $wave_file = $audio_path = $state = $district = $job_type = $country = '';
	
	$msg_id = $msgObj->functionAddSmsAndriodMsg($_POST);
	if($msg_id){

		$date				= trim($_POST['date']);
		$country		    = (isset($_POST['country']))?trim($_POST['country']):'';
		$state		        = (isset($_POST['state']))?trim($_POST['state']):'';
		$district	        = (isset($_POST['district']))?trim($_POST['district']):'';
		$language_type      = (isset($_POST['language_type']))?trim($_POST['language_type']):'en';
		$uploadFolder	    = '/uploads/temp';

		$csv_file_upload[]  = $_FILES['csv_file_upload'];
		$csvuploadResult    = uploadAllTypeFiles($uploadFolder, $csv_file_upload);
		if(isset($csvuploadResult['urls']['0'])){
			$csv_file       = $csvuploadResult['urls']['0'];
			$csv_path       = $URL_SITE.'/uploads/temp/'.$csv_file;
		}

		if(empty($csv_file)){
			$db->deleteUniversalRow(" message_".$language_type." ",$updated_on_field='id',$msg_id,$otherfields=null);
			$_SESSION['errormsg']   = 'Error in uploading CSV file.Please try again!';
			return;
		}

		$result = $msgObj->functionAddVoiceFileSMSCSVFile($msg_id, $wave_file, $csv_file,  $user_group_str, $user_sub_group_str, $user_sub_group_other_str, $job_type, $country , $state, $district, $language_type, $date);
		if(!$result){
			if(file_exists(DOC_ROOT."uploads/temp/".$csv_file)){
				unlink(DOC_ROOT."uploads/temp/".$csv_file);
			}
			$db->deleteUniversalRow(" message_".$language_type." ",$updated_on_field='id',$msg_id,$otherfields=null);
			$_SESSION['errormsg']   = 'Message insertion Error.Please try again!';
			return;
		}
		$_SESSION['successmsg'] = 'Message saved succussfully.';		
	}else{
		$_SESSION['errormsg']   = 'Message insertion Error.Please try again!';
	}

	header("location: mydashboard.php");
	exit;
}

//TEXT TYPE IN GROUP**********************************************
if(isset($_POST['sms_type']) && $_POST['sms_type']=='group'){

	//echo '<pre>';print_r($_POST);echo '</pre>';die;

	$userDetail = array();

	$user_list = $user_group_str = $user_sub_group_str = $user_sub_group_other_str = $csv_file = $csv_path = $wave_file = $audio_path = $state = $district = $job_type = $country = '';
	
	$msg_id = $msgObj->functionAddSmsAndriodMsg($_POST);
	if($msg_id){

		$date				= trim($_POST['date']);
		$country		    = (isset($_POST['country']))?trim($_POST['country']):'';
		$state		        = (isset($_POST['state']))?trim($_POST['state']):'';
		$district	        = (isset($_POST['district']))?trim($_POST['district']):'';
		$language_type		= (isset($_POST['language_type']))?trim($_POST['language_type']):'en';
		$uploadFolder		= '/uploads/temp';

		if(!empty($_POST['user_group'])){
			$user_group_str    = implode(',', $_POST['user_group']);
		}
		
		if(!empty($_POST['user_sub_group'])){
			$user_sub_group_str = implode(',', $_POST['user_sub_group']);
		}

		if(!empty($_POST['user_sub_group_other'])){
			$user_sub_group_other_str = implode(',', $_POST['user_sub_group_other']);
		}	

		$result = $msgObj->functionAddVoiceFileSMSCSVFile($msg_id, $wave_file, $csv_file, $user_group_str, $user_sub_group_str, $user_sub_group_other_str, $job_type, $country , $state, $district, $language_type, $date);
		if(!$result){
			$db->deleteUniversalRow(" message_".$language_type." ",$updated_on_field='id',$msg_id,$otherfields=null);
			$_SESSION['errormsg']   = 'Message insertion Error.Please try again!';
			return;
		}
		$_SESSION['successmsg'] = 'Message has been saved succussfully.';
	}else{
		$_SESSION['errormsg']   = 'Message insertion Error.Please try again!';
	}

	header("location: mydashboard.php");
	exit;
}
?>