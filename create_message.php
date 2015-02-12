<?php
/******************************************
* @Created on JAN 26, 2014
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
$categoryDetail = $adminObj->functiongetCategory($tablename='category',$id='',$parent_id='');

if(isset($_POST['channel_id'])){
	$channel_id  = $_SESSION['channel_id'] = $_POST['channel_id'];
} else if(isset($_SESSION['channel_id'])){
	$channel_id  = $_SESSION['channel_id'];
}

if(isset($_POST['submitmessage']) && $_POST['submitmessage']=='1') {
	$result = $adminObj->functionAddSmsAndriodMsg($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "9";
	} else {
		$_SESSION['msgerror']   = "8";
	}
	header("location:texts.php");
	exit;
} 
?>
<!-- CONTAINER -->
<div class="container">
	
	<h1 class="title"><?php echo $langVariables['msg_var']['msg_write'];?>
		<div class="right"><a href="<?php echo URL_SITE.$timeline_url;?>">Timeline</a></div>
	</h1>
	
	<p class="meta"></p>
	
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

		<!-- MESSAGE DIV START -->
		<?php if(isset($channel_id) && $channel_id!=''){?>
			
			<div class="wdthpercent100 pT10 pB10">
				<form method="post" action="" name="userSmsAndriodMessagePostingForm" id="userSmsAndriodMessagePostingForm" enctype="multipart/form-data">
				
					<div class="wdthpercent100 pT10 pB10">
						<div class="wdthpercent30 left"> Project Name</div>
						<div class="wdthpercent68 left user">
							<?php if(!empty($projectDetail)) { echo $projectDetail['user_type'].' User';} else {echo 'Project User';}?>	
							<input name="user_type" type="hidden" value="<?php if(!empty($projectDetail)) { echo $projectDetail['id'];}else {echo '17';}?>">
							<input name="message_type" type="hidden" value="<?php if(isset($channel_id)) { echo $channel_id;}?>">
							<input name="user_id" type="hidden" value="<?php if(isset($_SESSION['session_user_data']['id'])) { echo $_SESSION['session_user_data']['id'];}?>">
						</div>
					</div>
					<div class="clear"></div>

					<?php if(!empty($messagestatusDetail)) { ?>					
					<div class="wdthpercent100 pT10 pB10">
						<div class="wdthpercent30 left">Select Status Category</div>
						<div class="wdthpercent70 left">
							<select class="wdthpercent100 required" id="status_type" name="status_type">
								<option value="">Select Status Category</option>
								<?php foreach($messagestatusDetail as $key => $category){ ?>
									<option value="<?php echo $category['id']; ?>" <?php if(isset($parentcat) && $parentcat == $category['id']){ echo "selected=selected"; } ?>><?php echo $category['message_status_name']; ?></option>
								<?php } ?>
							</select>
							<div id="loader" style="display:none;"></div>
						</div>						
					</div>
					<div class="clear"></div>
				    <?php } ?>
					
					<?php if(!empty($categoryDetail)) { ?>					
					<div class="wdthpercent100 pT10 pB10">
						<div class="wdthpercent30 left"><?php echo $langVariables['category_var']['select_category'];?></div>
						<div class="wdthpercent70 left">
							<select onchange="javascript: functiongetSubCategory('parent_category');"  class="wdthpercent100 required" id="parent_category" name="parent_category">
								<option value=""><?php echo $langVariables['category_var']['select_category'];?></option>
								<?php foreach($categoryDetail as $key => $category){ ?>
									<option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
								<?php } ?>
							</select>							
						</div>						
					</div>
					<div class="clear"></div>
				    <?php } ?>

					<div id="show_sub_category" class="wdthpercent100 pT10" style="display:none;">	
					</div>
					<div class="clear"></div>

					<?php if(isset($channel_id) && $channel_id =='andriod'){?>

					<div class="wdthpercent100 pT10 pB10">
						<div class="wdthpercent30 left">Select Upload Type</div>
						<div class="wdthpercent70 left">
						   <span class="">
								<input type="radio" id="select_upload_File" name="select_upload_type" value="photos" />&nbsp;Photo
						   </span>
						   <span class="pL10">
								<input type="radio" id="select_upload_audio" name="select_upload_type" value="audios" />&nbsp;Audio
						   </span>
						   <span class="pL10">
								<input type="radio" id="select_upload_video" name="select_upload_type" value="videos" />&nbsp;Video
						   </span>
						   <span class="pL10">
								<input type="radio" id="select_upload_url" name="select_upload_type" class="" value="embeddedUrl" />&nbsp;Embedded Url
						   </span>
						   <span class="pL10" id="select_upload_none_div" style="display:none;">
								<input type="radio" id="select_upload_none" value="" />&nbsp;None
						   </span>
						</div>
					</div>
					<div class="clear"></div>

					<div id="select_upload_file_div" style="display:none;" class="wdthpercent100 pT15 pB10">
						<div class="wdthpercent30 left">Upload File</small>
						</div>
						<div class="wdthpercent70 left">
						   <input type="file" id="message_file_upload" name="message_file" class="wdthpercent100"/>
						   <small class="labelred" style="display:none" id="select_upload_File_limit"><?php echo $langVariables['msg_var']['msg_image'];?></small>
						   <small class="labelred" style="display:none" id="select_upload_audio_limit"><?php echo $langVariables['msg_var']['msg_audio'];?></small>
						   <small class="labelred" style="display:none" id="select_upload_video_limit"><?php echo $langVariables['msg_var']['msg_video'];?></small>
						</div>
					</div>
					<div class="clear"></div>

					<div id="select_upload_url_div" style="display:none;" class="wdthpercent100 pT15 pB10">
						<div class="wdthpercent30 left">Enter URL</div>
						<div class="wdthpercent70 left">
						   <textarea id="message_url_upload" name="message_file" class="wdthpercent100"/></textarea>
						</div>
					</div>
					<div class="clear pB10"></div>
					<?php } ?>
					
					<div class="wdthpercent100 pT10">
					    <!-- call transliterate service -->
						<?php require_once($DOC_ROOT.'api/googleTranslateMessage.php');?> 
						<!-- call transliterate service -->
					</div>
					<div class="clear"></div>

					<div class="wdthpercent100 pT10">
						<div class="wdthpercent100 pB10 googleLanguage">
							<div class="wdthpercent30 left">Select Message Tag</div>
							<div class="wdthpercent70 left">
								<input type="text" placeholder="Type or copy your message TAG here" id="message_tag" class="wdthpercent100 required" name="message_tag" value="<?php if(isset($message_tag) && $message_tag!=''){echo $message_tag; } ?>">	
							</div>
							<div class="clear"></div>
					</div>
					<div class="clear"></div>

					<!-- call transliterate service -->
					<?php //require_once($DOC_ROOT.'api/googleTranslateTagging.php');?> 
					<!-- call transliterate service -->

					</div>
					<div class="clear"></div>

					<div class="wdthpercent100 pT10 pB10">				
						<span class="right">
						<input class="button" type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submit">
						<input type="hidden" value="1" name="submitmessage">
						</span>
						<span class="right pR20"><input class="button" type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset"></span>
					</div>
					<div class="clear"></div>
				</form>
			</div>

		<?php } ?>
		<!-- /MESSAGE DIV START -->
		
	</div>

</div>
<!-- CONTAINER -->

<!-- FOOTER -->
<?php include_once $basedir."/include/frontFooter.php"; ?>
<!-- /FOOTER -->