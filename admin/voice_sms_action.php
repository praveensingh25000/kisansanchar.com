<?php
/******************************************
* @Created on June 08, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/actionHeader.php";

//VOICE TYPE IS BULK**********************************************
if(isset($_POST['voice_type']) && $_POST['voice_type']=='bulk'){

	$user_list = $user_sub_group = $sub_group_other = $csv_file = $csv_path = $audio_file = $audio_path = '';

	$host   		= VOICE_HOST_NAME;
	$port			= VOICE_PORT;
	$username		= VOICE_USERNAME;
	$password		= VOICE_PASSWORD;
	
	$msg_id = $adminObj->functionAddSmsAndriodMsg($_POST);
	if($msg_id){

		$job_type		    = trim($_POST['job_type']);
		$uploadFolder	    = '/uploads/temp';
		
		$wav_audio_upload[] = $_FILES['wav_audio_upload'];
		$wavuploadResult    = uploadAllTypeFiles($uploadFolder, $wav_audio_upload);
		if(isset($wavuploadResult['urls']['0'])){
			$audio_file     = $wavuploadResult['urls']['0'];
			$audio_path     = $URL_SITE.'/uploads/temp/'.$audio_file;
		}

		$csv_file_upload[]  = $_FILES['csv_file_upload'];
		$csvuploadResult    = uploadAllTypeFiles($uploadFolder, $csv_file_upload);
		if(isset($csvuploadResult['urls']['0'])){
			$csv_file       = $csvuploadResult['urls']['0'];
			$csv_path       = $URL_SITE.'/uploads/temp/'.$csv_file;
		}

		$result = $adminObj->functionAddVoiceFileCSVFile($msg_id, $audio_file, $csv_file, $user_list='', $job_type);

		if($result){

			$audiouploadObj			 = new AudioUpload($host, $username, $password, $audio_path);
			$voice_clip_ref_no		 = $audiouploadObj->Submit();

			$csvuploadObj            = new CSVUpload($host, $username, $password, $csv_path);
			$dest_csv_path_ref_no    = $csvuploadObj->Submit();

			$audiosmsObj			 = new AudioSms ($host, $username, $password, $job_type, $dest_csv_path_ref_no, $voice_clip_ref_no);
			$responseCode			 = $audiosmsObj->Submit();

			if($responseCode == '3001'){
				$_SESSION['successmsg'] = 'Voice Message Sent';
			}else {
				$_SESSION['errormsg']   = 'Voice Message sending failed';
			}
		}

	}else{
		$_SESSION['errormsg']   = 'Message insertion Error.Please try again!';
	}

	header("location: message.php");
	exit;
}




//VOICE TYPE IS GROUP************************************************************
if(isset($_POST['voice_type']) && $_POST['voice_type']=='group'){

	$userDetail = array();

	$user_list = $user_sub_group = $sub_group_other = $csv_file = $csv_path = $audio_file = $audio_path = '';

	$host   		= VOICE_HOST_NAME;
	$port			= VOICE_PORT;
	$username		= VOICE_USERNAME;
	$password		= VOICE_PASSWORD;
	
	$msg_id = $adminObj->functionAddSmsAndriodMsg($_POST);
	if($msg_id){

		$job_type		= trim($_POST['job_type']);
		$uploadFolder	= '/uploads/temp';
		
		$wav_audio_upload[] = $_FILES['wav_audio_upload'];
		$wavuploadResult  = uploadAllTypeFiles($uploadFolder, $wav_audio_upload);
		if(isset($wavuploadResult['urls']['0'])){
			$audio_file   = $wavuploadResult['urls']['0'];
			$audio_path   = $URL_SITE.'/uploads/temp/'.$audio_file;
		}
		
		if(!empty($_POST['user_sub_group'])){
			$user_sub_group    = implode(',', $_POST['user_sub_group']);
			$sqlinner          = "select DISTINCT phone from `users` where `village` IN (".$user_sub_group.") ";
			$resultinner       = $db->run_query($sqlinner);
			$userDetailArray[] = $db->getAll($resultinner);
		}

		if(!empty($_POST['user_sub_group_other'])){
			$sub_group_other   = implode(',', $_POST['user_sub_group_other']);
			$sqlinnerone       = "select DISTINCT phone from `users` where `phone` IN (".$sub_group_other.") ";
			$resultinnerone    = $db->run_query($sqlinnerone);
			$userDetailArray[] = $db->getAll($resultinnerone);
		}

		if(!empty($userDetailArray)){
			foreach($userDetailArray as $key => $useroneAll){
				foreach($useroneAll as $key => $userone){
					$userDetail[$userone['phone']] = $userone['phone'];
				}
			}
			$user_list = implode(',', $userDetail);
		}

		$result = $adminObj->functionAddVoiceFileCSVFile($msg_id, $audio_file, $user_file='', $user_list, $job_type);

		if($result){

			$audiouploadObj		= new AudioUpload($host, $username, $password, $audio_path);
			$voice_clip_ref_no	= $audiouploadObj->Submit();

			$audiosmsObj	    = new AudioSms ($host, $username, $password, $job_type, $user_list, $voice_clip_ref_no);
			$responseCode	    = $audiosmsObj->Submit();

			if($responseCode == '3001'){
				$_SESSION['successmsg'] = 'Voice Message Sent';
			}else{
				$_SESSION['errormsg']   = 'Voice Message sending failed';
			}
		}

	}else{
		$_SESSION['errormsg']   = 'Message insertion Error.Please try again!';
	}

	header("location: message.php");
	exit;
}

?>