<?php
/******************************************
* @Created on APRIL 27, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

if(isset($_POST['submitmessage']) && $_POST['submitmessage']=='submit') {
	$basedir=dirname(__FILE__)."";
	include_once $basedir."/include/actionHeader.php";
	$result = $msgObj->functionAddSmsAndriodMsg($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
	} else {
		$_SESSION['msgerror']   = "8";
	}
	header("location: mydashboard.php");
	exit;
} 
?>
<div class="wdthpercent100 pT10 pB10">

	<!-- MESSAGE DIV START -->		
	<div class="wdthpercent100 pT10 pB10">
		<form method="post" action="andriod_messages.php" name="userSmsAndriodMessagePostingForm" id="userSmsAndriodMessagePostingForm" enctype="multipart/form-data">
		
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
			
			<?php if(!empty($categoryDetail) && !isset($is_project_user)) { ?>					
			<div class="wdthpercent100 pT10 pB10">
				<div class="wdthpercent30 left"><?php echo $langVariables['category_var']['select_category'];?></div>
				<div class="wdthpercent70 left">
					<select onchange="javascript: functiongetGenSubCategory('parent_category','sub_category');"  class="wdthpercent100 required" id="parent_category" name="parent_category">
						<option value=""><?php echo $langVariables['category_var']['select_category'];?></option>
						<?php foreach($categoryDetail as $key => $category){ ?>
							<option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
						<?php } ?>
					</select>							
				</div>						
			</div>
			<div class="clear"></div>

			<div id="parent_category_sub_show" class="wdthpercent100 pT10" style="display:none;">	
			</div>
			<div class="clear"></div>

			<?php } ?>

			<?php if(!empty($categoryDetail) && isset($is_project_user)) { ?>

			<div class="wdthpercent100 pT10 pB10">
				<div class="wdthpercent30 left">Select C Category</div>
				<div class="wdthpercent70 left">
					<select onchange="javascript: functiongetSubCategory('c_parent_category','c_sub_category');"  class="wdthpercent100 required" id="c_parent_category" name="c_parent_category">
						<option value="">Select C Category</option>
						<option value="261">C Category</option>								
					</select>							
				</div>						
			</div>
			<div class="clear"></div>

			<div id="c_parent_category_sub_show" class="wdthpercent100 pT10" style="display:none;">	
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<div class="wdthpercent30 left">Select G Category</div>
				<div class="wdthpercent70 left">
					<select onchange="javascript: functiongetSubCategory('g_parent_category','g_sub_category');"  class="wdthpercent100 required" id="g_parent_category" name="g_parent_category">
						<option value="">Select G Category</option>
						<option value="275">G Category</option>								
					</select>							
				</div>						
			</div>
			<div class="clear"></div>

			<div id="g_parent_category_sub_show" class="wdthpercent100 pT10" style="display:none;">	
			</div>
			<div class="clear"></div>

			<?php } ?>

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
						<input type="radio" name="select_upload_type" id="select_upload_none" value="" />&nbsp;None
				   </span>
				</div>
			</div>
			<div class="clear"></div>

			<div id="select_upload_file_div" style="display:none;" class="wdthpercent100 pT15 pB10">
				<div class="wdthpercent30 left">Upload File</small>
				</div>
				<div class="wdthpercent70 left">
				   <input type="file" id="message_file_upload" name="message_file" accept="image/gif, image/jpeg, image/jpeg, audio/mp3, audio/wav, video/mpeg, video/mp4" class="wdthpercent100"/>
				   <small class="labelred" style="display:none" id="select_upload_File_limit">Only gif|jpeg|pjpeg upto 3 MB.</small>
				   <small class="labelred" style="display:none" id="select_upload_audio_limit">Only mp3|wav upto 3 MB.</small>
				   <small class="labelred" style="display:none" id="select_upload_video_limit">Only mpeg|mp4 upto 3 MB.</small>
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
			
			<div class="wdthpercent100 pT10 pB10">				
				<span class="right">
				<input class="button" id="submitid" onclick="javascript:ShowSubmitTextGlobal('submitid','reset','userSmsAndriodMessagePostingForm');" type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submit">
				<input type="hidden" value="submit" name="submitmessage">
				<input type="hidden" id="project_id" name="project_id" value="<?php echo (defined('IS_PROJECT_ID'))?IS_PROJECT_ID:'0'?>" />
				</span>
				<span class="right pR20"><input class="button" type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset"></span>
			</div>
			<div class="clear"></div>
		</form>
	</div>
	<!-- /MESSAGE DIV START -->
	
	<!-- windowLoader -->
	<script type="text/javascript">windowLoader();</script>
	<!-- /windowLoader -->

</div>