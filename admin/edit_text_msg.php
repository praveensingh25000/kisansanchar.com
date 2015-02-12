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
$messageData   = $db->getUniversalRow($table_name='message_'.$language_type.'',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$msg_id,$otherfields=null);

if(empty($messageData)){
	header("location: timeline.php");
	exit;	
}

$user_id			= trim($messageData['user_id']);
$project_id			= trim($messageData['project_id']);
$status				= trim($messageData['status']);
$status_type		= trim($messageData['status_type']);
$user_type			= trim($messageData['user_type']);	
$parent_category	= trim($messageData['parent_category']);
$sub_category		= trim($messageData['sub_category']);
$user_group			= trim($messageData['user_group']);
$user_sub_group		= trim($messageData['user_sub_group']);
$message_subject	= stripslashes($messageData['message_subject']);
$message			= stripslashes($messageData['message']);
$message_tag		= stripslashes($messageData['message_tag']);
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

if(isset($_POST['updateSendmessage']) && $_POST['updateSendmessage']=='Send') {
	$response    = $msgObj->functionUpdateSendTextSmsMsg($_POST);
	if($response == '1701'){
		$_SESSION['successmsg'] = 'Text Message updated and Sent Succussfully';
		header("location: timeline.php");
		exit;
	} else {
		$_SESSION['errormsg']   = 'Text Message updation failed';
		header("location: timeline.php");
		exit;
	}
}

if(isset($_POST['updatemessage']) && $_POST['updatemessage']=='Update') {
	$status = $msgObj->functionUpdateTextSmsMsg($_POST);
	if($status){
		$_SESSION['successmsg'] = 'Text Message updated Succussfully';
	}else {
		$_SESSION['errormsg']   = 'Text Message updation failed';
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
		
		<div class="wdthpercent100 pT10">
			<div class="wdthpercent30 left">Select Channel</div>
			<div class="wdthpercent70 left">
			   <form id="select_channel_type" method="post" action="">
					<select disabled="true" class="wdthpercent100" id="channel_id" name="channel_id">
						<option value="">Select Channel Type</option>
						<option <?php if(isset($channel_id) && $channel_id=='andriod'){ echo 'selected="selected"';}?> value="andriod"><?php echo $langVariables['msg_var']['andriod_channel'];?>&nbsp;<small class="labelred">Free</small></option>
						<option <?php if(isset($channel_id) && $channel_id=='sms'){ echo 'selected="selected"';}?> value="sms"><?php echo $langVariables['msg_var']['sms_channel'];?>&nbsp;<small class="labelred">Paid</small></option>						
					</select>
				</form>
			</div>
			<div class="clear pB10"></div>			
		</div>

		<!-- MESSAGE DIV START -->
		<?php if(isset($channel_id) && $channel_id!=''){?>
			
			<div class="wdthpercent100 pT10 pB10">
				<form method="post" action="" name="userSmsAndriodMessagePostingForm" id="userSmsAndriodMessagePostingForm" enctype="multipart/form-data">

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
							<input type="hidden" value="<?php echo $project_id;?>" name="project_id">
							<input type="hidden" id="language_type_id" value="<?php echo $language_type;?>" name="language_type">
						</span>
						<span class="right pR20">
							<input class="button" type="button" value="Back" onclick="window.location=URL_SITE+'/admin/timeline.php'">
						</span>
					</div>
					<div class="clear"></div>
				</form>
			</div>

		<?php } ?>
		<!-- /MESSAGE DIV START -->

	</div>

</section>
<!-- CONTAINER -->