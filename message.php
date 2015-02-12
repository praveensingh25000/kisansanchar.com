<?php
/******************************************
* @Created on April 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

checkSession(false,2);

$userTypes            = $db->getUniversalRowAll($table_name='user_types');
$projectDetail        = $langObj->functionGetSetting($tablename='user_types', $dmlType='1', $_SESSION['session_user_data']['user_type']);
$messagestatusDetail  = $langObj->functionGetSetting($tablename='message_status_settings', $dmlType='');
$categoryDetail       = $adminObj->functiongetCategory($tablename='category',$id='',$parent_id='');
$usergroup            = $db->getUniversalRowAll($table_name="user_groups"," and `parent_id`= '0' ORDER BY id ");

if(isset($_POST['channel_id'])){
	$channel_id  = $_SESSION['channel_id'] = $_POST['channel_id'];
} else if(isset($_SESSION['channel_id'])){
	$channel_id  = $_SESSION['channel_id'];
}

if(isset($_POST['content_type'])){
	$content_type  = $_SESSION['content_type'] = $_POST['content_type'];
} else if(isset($_SESSION['content_type'])){
	$content_type  = $_SESSION['content_type'];
}

if(isset($_POST['voice_type'])){
	$voice_type  = $_SESSION['voice_type'] = $_POST['voice_type'];
} else if(isset($_SESSION['voice_type'])){
	$voice_type  = $_SESSION['voice_type'];
}

if(isset($_SESSION['session_user_data']['user_type']) && is_numeric($_SESSION['session_user_data']['user_type']) && isset($is_project_user)) {
	$voice_sending_content_type  = '1';
}

if(isset($_POST['job_type'])){
	$job_type  = $_SESSION['job_type'] = $_POST['job_type'];
} else if(isset($_SESSION['job_type'])){
	$job_type  = $_SESSION['job_type'];
}

if(isset($_POST['submitmessage']) && $_POST['submitmessage']=='1') {
	$result = $adminObj->functionAddSmsAndriodMsg($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
	} else {
		$_SESSION['msgerror']   = "8";
	}
	header("location: mydashboard.php");
	exit;
} 
?>
<!-- CONTAINER -->
<div class="container">
	
	<h1 class="title">
		Write Message 
		<div class="right"><a href="<?php echo URL_SITE.$timeline_url;?>">Timeline</a></div>
	</h1>
	
	<div class="entry pL10 pR10">
		
		<div class="wdthpercent100 pT10">
			<div class="wdthpercent30 left">Select Channel</div>
			<div class="wdthpercent70 left">
			   <form id="select_channel_type" method="post" action="">
					<select class="wdthpercent100" id="channel_id" name="channel_id">
					    <option value="">Select Channel Type</option>
						<option <?php if(isset($_SESSION['channel_id']) && $_SESSION['channel_id']=='andriod'){ echo 'selected="selected"';}?> value="andriod"><?php echo $langVariables['msg_var']['andriod_channel'];?>&nbsp;<small class="labelred">Free</small></option>
						<option <?php if(isset($_SESSION['channel_id']) && $_SESSION['channel_id']=='sms'){ echo 'selected="selected"';}?> value="sms"><?php echo $langVariables['msg_var']['sms_channel'];?>&nbsp;<small class="labelred">Paid</small></option>						
					</select>
				</form>
			</div>
			<div class="clear pB10"></div>			
		</div>

		<!-- SMS MESSAGE DIV START -->
		<?php if(isset($channel_id) && $channel_id =='sms'){?>

			<?php
			$contentArray = $db->getUniversalRowAll($table_name='sms_types',$otherfields=" and `is_active` = '1' ");
			if(!empty($contentArray)){ ?>
			<div class="wdthpercent100 pT10">
				<div class="wdthpercent30 left">Select SMS Type</div>
				<div class="wdthpercent70 left">
				   <form id="select_content_type" method="post" action="">
						<select class="wdthpercent100" id="content_type" name="content_type">
							<option value="">Select SMS Type</option>
							<?php foreach($contentArray as $key=> $content){?>
								<option <?php if(isset($_SESSION['content_type']) && $_SESSION['content_type']==$content['menu_type']){ echo 'selected="selected"';}?> value="<?php echo $content['menu_type'];?>"><?php echo strtoupper($content['menu_type']);?></option>
							<?php } ?>										
						</select>
					</form>
				</div>
				<div class="clear pB10"></div>			
			</div>
			<?php } ?>

			<?php if(isset($content_type) && $content_type =='textsms'){?>
				<?php include_once($DOC_ROOT.'text_sms.php');?>
			<?php } ?>
			<?php if(isset($content_type) && $content_type =='voicesms'){?>				
				<?php include_once($DOC_ROOT.'voice_sms.php');?>
			<?php } ?>

		<?php } ?>
		<!-- /SMS MESSAGE DIV START -->

		<!-- ANDRIOD MESSAGE DIV START -->
		<?php if(isset($channel_id) && $channel_id =='andriod'){?>
			<?php include_once($DOC_ROOT.'andriod_messages.php');?>
		<?php } ?>
		<!-- ANDRIOD MESSAGE DIV START -->

		<div id="creategrouppopupdivshow" style="display:none;"></div>
		
	</div>

</div>
<!-- CONTAINER -->

<!-- FOOTER -->
<?php include_once $basedir."/include/frontFooter.php"; ?>
<!-- /FOOTER -->