<?php
/******************************************
* @Created on JAN 27, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);

$msg_id		   = (isset($_GET['id']))?trim($_GET['id']):'';
$language_type = (isset($_GET['lang']))?trim($_GET['lang']):'';
$userTypes     = $db->getUniversalRowAll($table_name='user_types');

//$projectDetail        = $langObj->functionGetSetting($tablename='user_types', $dmlType='1', $_SESSION['session_user_data']['user_type']);
$messagestatusDetail  = $langObj->functionGetSetting($tablename='message_status_settings', $dmlType='');
$categoryDetail       = $adminObj->functiongetCategory($tablename='category',$id='',$parent_id='');

$messageData   = $db->getUniversalRow($table_name='message_'.$language_type.'',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$msg_id,$otherfields=null);

if(empty($messageData)){
	header("location: timeline.php");
	exit;	
}

//echo '<pre>';print_r($messageData);echo '</pre>';

if(!empty($messageData)){
	$action_div_type = $file_type = $mediatext =  $mediacenter = $organicLogo = $logowidthL = $logowidthR = $file_url = $file = $edit_setter_var = $message_url = "";

	$user_id			= trim($messageData['user_id']);
	$status				= trim($messageData['status']);
	$status_type		= trim($messageData['status_type']);
	$user_type			= trim($messageData['user_type']);	
	$parent_category	= trim($messageData['parent_category']);
	$sub_category		= trim($messageData['sub_category']);
	$user_group			= trim($messageData['user_group']);
	$user_sub_group		= trim($messageData['user_sub_group']);
	$message			= stripslashes($messageData['message']);
	$message_tag		= stripslashes($messageData['message_tag']);
	$message_subject	= stripslashes($messageData['message_subject']);
	$content_type		= trim($messageData['content_type']);
	$content_status		= trim($messageData['content_status']);
	$content_duration	= trim($messageData['content_duration']);
	$content_maxduration= trim($messageData['content_maxduration']);
	$content_time		= trim($messageData['content_time']);
	$message_file   	= trim($messageData['message_file']);
	$channel_id  		= trim($messageData['message_type']);
	$language_type	    = trim($messageData['language_type']);
	$broadcast_date		= trim($messageData['broadcast_date']);
	$timeline_date		= stripslashes($messageData['timeline_date']);
	$date       		= stripslashes($messageData['date']);
	$content_type       = $messageData['content_type'];

	if(!empty($content_type) && $content_type!='' && !empty($messageData['message_file'])){
		$action_div_type = $content_type;
		$message_file    = $messageData['message_file'];

		if($action_div_type == 'jpeg' || $action_div_type == 'JPEG' || $action_div_type == 'jpg' || $action_div_type == 'JPG' || $action_div_type == 'pjpeg' || $action_div_type == 'PJPEG' || $action_div_type == 'gif' || $action_div_type == 'GIF'){
			$file      = stripslashes($message_file);
			$file_url  = "/uploads/photos/".$file;
			$file_type = "photo";
		} else if($action_div_type == 'mp3' || $action_div_type == 'MP3' || $action_div_type == 'wav' || $action_div_type == 'Wav' || $action_div_type == 'WAV'){
			$file     = stripslashes($message_file);
			$file_url = "/uploads/temp/".$file;
			$file_type = "audio";
		} else if($action_div_type == 'flv' || $action_div_type == 'FLV' || $action_div_type == 'mp4' || $action_div_type == 'MP4'){
			$file     = stripslashes($message_file);
			$file_url = "/uploads/videos/".$file;
			$file_type = "video";
		}
	}
}

if(isset($_POST['updateSendmessage']) && $_POST['updateSendmessage']=='Send') {
	//echo '<pre>';print_r($_POST);echo '<pre>';die;
	$responseCode = $msgObj->functionUpdateSendVoiceSmsMsg($_POST);
	if($responseCode == '3001'){
		$_SESSION['successmsg'] = 'Voice Message updated and Sent Succussfully';
	}else {
		$_SESSION['errormsg']   = 'Voice Message updated but sending failed';
	}
	header("location: timeline.php");
	exit;
} 

if(isset($_POST['updatemessage']) && $_POST['updatemessage']=='Update') {
	//echo '<pre>';print_r($_POST);echo '<pre>';die;
	$responseCode = $msgObj->functionUpdateVoiceSmsMsg($_POST);
	if($responseCode == '3001'){
		$_SESSION['successmsg'] = 'Voice Message updated Succussfully';
	}else {
		$_SESSION['errormsg']   = 'Voice Message updation failed';
	}
	header("location: ".$_SERVER['REQUEST_URI']."");
	exit;
} 
?>
<!-- containerCenter -->
<section class="containerCenter">

	<div class="containercentercnt">

		<h2 class="heading">Edit Message<div class="right pR10"><a href="timeline.php">Back</a></div></h2>
		<div class="clear pB10"></div>	

		<!-- MESSAGE DIV START -->				
		<div class="wdthpercent100 pT10 pB10">
			<form method="post" action="" name="userSmsAndriodMessagePostingForm" id="userSmsAndriodMessagePostingForm" enctype="multipart/form-data">

				<div class="wdthpercent100 pT10">
					<div class="wdthpercent30 left">Audio File</div>
					<div class="wdthpercent70 left">
						<!-- MEDIA DIV -->
						<audio controls="controls">
						  <source src="<?php echo URL_SITE;?><?php echo $file_url;?>" type="<?php echo $file_type;?>/<?php echo $action_div_type;?>">	  
						  Your browser doesn't support <?php echo $file_type;?>
						</audio>				
						<!-- /MEDIA DIV -->
					</div>
				</div>	
				<div class="clear pB10"></div>
				
				<div class="wdthpercent100 pT10">
					<!-- call transliterate service -->
					<?php require($DOC_ROOT.'api/googleTranslateMessage.php');?> 
					<!-- call transliterate service -->
				</div>
				<div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">				
					<span class="right">
						<input class="button" type="submit" value="Send" name="updateSendmessage">
						<input class="button" type="submit" value="Update" name="updatemessage">
						<input type="hidden" value="<?php echo $msg_id;?>" name="msg_id">
						<input type="hidden" id="language_type_id" value="<?php echo $language_type;?>" name="language_type">
					</span>
					<span class="right pR20">
						<input class="button" type="button" value="Back" onclick="window.location=URL_SITE+'/admin/timeline.php'">
					</span>
				</div>
				<div class="clear"></div>
			</form>
		</div>
		<!-- /MESSAGE DIV START -->

	</div>

	<!-- windowLoader -->
	<script type="text/javascript">windowLoader();</script>
	<!-- /windowLoader -->

</section>
<!-- CONTAINER -->

<?php include_once $basedir."/include/adminFooter.php"; ?>