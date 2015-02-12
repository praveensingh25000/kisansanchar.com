<?php
/******************************************
* @Created on JAN 27, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
include_once $basedir."/include/actionHeader.php";

//Request from admin/users.php
if(isset($_GET['user_group_wise']) && $_GET['user_group_wise']=='1') {
	$villagegroup      = $db->getUniversalRowAll($table_name="user_groups"," and `parent_id`= '".$_POST['user_group']."' ORDER BY id ");
	if(!empty($villagegroup)){?>												
		<select class="wdthpercent100" id="village_admin" name="village">
			<option selected="selected" value="">Select Village</option>
			<?php foreach($villagegroup as $key => $village){ ?>
				<option value="<?php echo $village['id']; ?>"><?php echo $village['group_name']; ?></option>
			<?php } ?>
		</select>
	<?php } ?>
<?php } ?>

<?php if(isset($_GET['update_contact_count']) && $_GET['update_contact_count']=='1') {
	$content_id = $_POST['content_id'];
	$status = $db->updateUniversalRow($table_name='contact_us',$coloum_name_str=" `status`= '1' ",$updated_on_field='id',$content_id,$otherfields=null);
	return true;	
} 
?>

<?php if(isset($_GET['sendvoicesmsajax']) && $_GET['sendvoicesmsajax']=='1') {

	$content_id = $_POST['content_id'];
	$tablename  = $_POST['tablename'];

	if(isset($_POST['content_type']) && $_POST['content_type']=='textmsg'){		
		$response = $msgObj->functionSendTextSmsMsg($tablename,$content_id);
		if($response == '1701'){
			echo 'Message has been sent succussfully';
		}else{
			echo 'Error! occur in sending please try again!';
		}
	}
	if(isset($_POST['content_type']) && $_POST['content_type']=='voicemsg'){
		$responseCode = $msgObj->functionSendVoiceSmsMsg($tablename,$content_id);
		if($responseCode == '3001'){	
			echo 'Message has been sent succussfully';
		}else{
			echo 'Error! occur in sending please try again!';
		}
	}	
	return true;	
} 
?>

<?php if(isset($_GET['selection_type_check']) && $_GET['selection_type_check']=='1') {

	$error   = 0;
	$message = 'Internal Error';

	$selection_type     = (isset($_POST['selection_type']))?$_POST['selection_type']:'byname';
	$group_id           = (isset($_POST['group_id']))?$_POST['group_id']:'';
	$userDetailNameJson = $userObj->getUserNameJsonType($selection_type);

	if(isset($userDetailNameJson) && $userDetailNameJson!=''){

		$error = 1;

		$data  ='
		<div class="wdthpercent20 left">Enter '.ucwords(str_replace('_',' ',$selection_type)).' </div>
		<div class="wdthpercent40 left">
			<input type="text" name="assigned_users" id="assigned_users" class="wdthpercent40 required"/>
			 <script type="text/javascript">
			 $(document).ready(function() {	
				$("#assigned_users").tokenInput('.$userDetailNameJson.', {	
					preventDuplicates: true
				});		
			 });					
			 </script>					   
		</div>	
		<div class="wdthpercent20 left">
			<input type="submit" value="'.$langVariables["form_var"]["submit"].'" name="submitreportgroupforms">			
		</div>
	   ';	   
	}
	echo function_json_encode(array('data' => $data, 'error' => $error, 'message' => $message));
}
?>

<?php if(isset($_GET['checkgroupmember']) && $_GET['checkgroupmember']=='1') {

	$user_id   = (isset($_POST['user_id']))?$_POST['user_id']:'';
	$group_id  = (isset($_POST['group_id']))?$_POST['group_id']:'';

	$memberDetail = $db->getUniversalTableData($table_name='sms_groups_members',$coloum_name_str='*',$otherfields=" and `user_id` = '".$user_id."' and `group_id`= '".$group_id."' ");
	if(empty($memberDetail)){
		echo '0';
	}else{
		echo '1';
	}
	return true;
}
?>

<?php if(isset($_GET['approvedissaprove']) && $_GET['approvedissaprove']!='' && !empty($_POST['tablename'])) {

	$tablename     = trim($_POST['tablename']);
	$content_id    = trim($_POST['content_id']);	
	$content_type  = trim($_POST['content_type']);	
	$unique_div_id = trim($_POST['unique_div_id']);
	$status        = trim($_POST['status']);	
	
	if($status =='0'){
		$coloum_name_str = " `status`='".$status."', broadcast_date='0000-00-00 00:00:00', timeline_date='0000-00-00 00:00:00' ";
		$statuscheck = $db->updateUniversalRow($tablename,$coloum_name_str,$updated_on_field='id',$updated_on_value=$content_id,$otherfields=null);
		?>
		<a onclick="javascript: functionApproveDisaprove('<?php echo $tablename;?>','<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','1','Do you really want to approve this message');" id="aprove_div_<?php echo $unique_div_id;?>" href="javascript:;">Approve for Timeline</a>
	<?php } else {
		$coloum_name_str = " `status`='".$status."', broadcast_date='".CURRENT_DATE."', timeline_date='".CURRENT_DATE."' ";
		$statuscheck = $db->updateUniversalRow($tablename,$coloum_name_str,$updated_on_field='id',$updated_on_value=$content_id,$otherfields=null);
		?>
		<a onclick="javascript: functionApproveDisaprove('<?php echo $tablename;?>','<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','0','Do you really want to disapprove this message');" id="dissaprove_div_<?php echo $unique_div_id;?>" href="javascript:;">Disapprove for Timeline</a>
	<?php }	?>
<?php }	?>

<?php if(isset($_GET['schuduledapprovedissaprove']) && $_GET['schuduledapprovedissaprove']!='' && !empty($_POST['tablename'])) {

	$tablename     = trim($_POST['tablename']);
	$content_id    = trim($_POST['content_id']);	
	$content_type  = trim($_POST['content_type']);	
	$unique_div_id = trim($_POST['unique_div_id']);
	$status        = trim($_POST['status']);	
	
	if($status =='0'){
		$coloum_name_str = " `status`='".$status."', broadcast_date='0000-00-00 00:00:00', timeline_date='0000-00-00 00:00:00' ";
		$statuscheck = $db->updateUniversalRow($tablename,$coloum_name_str,$updated_on_field='id',$updated_on_value=$content_id,$otherfields=null);
		?>
		<a onclick="javascript: functionSchuduledApproveDisaprove('<?php echo $tablename;?>','<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','7','Do you really want to approve this message');" id="aprove_div_<?php echo $unique_div_id;?>" href="javascript:;">Approve Schuduled Message</a>
	<?php } else {
		$coloum_name_str = " `status`='".$status."', broadcast_date='".CURRENT_DATE."', timeline_date='".CURRENT_DATE."' ";
		$statuscheck = $db->updateUniversalRow($tablename,$coloum_name_str,$updated_on_field='id',$updated_on_value=$content_id,$otherfields=null);
		?>
		<a onclick="javascript: functionSchuduledApproveDisaprove('<?php echo $tablename;?>','<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','0','Do you really want to disapprove this message');" id="dissaprove_div_<?php echo $unique_div_id;?>" href="javascript:;">Disapprove Schuduled Message</a>
	<?php }	?>
<?php }	?>

<?php if(isset($_POST['startLimit']) && isset($_POST['tablename']) && isset($_POST['endLimit'])) {

	$startLimit					= (isset($_POST['startLimit']))?trim($_POST['startLimit']):'';
	$endLimit					= (isset($_POST['endLimit']))?trim($_POST['endLimit']):'';

	$language_type				= (isset($_POST['language_type']))?trim($_POST['language_type']):'';
	$message_type				= (isset($_POST['message_type']))?trim($_POST['message_type']):'';

	$tablenamemsg				= (isset($_POST['tablename']))?trim($_POST['tablename']):'';		
	$user_privacy				= (isset($_POST['user_privacy_settings']))?trim(base64_decode($_POST['user_privacy_settings'])):'';

	$day						= (isset($_POST['day']))?trim($_POST['day']):'';
	$month						= (isset($_POST['month']))?trim($_POST['month']):'';

	$year						= (isset($_POST['year']))?trim($_POST['year']):'';
	$status						= (isset($_POST['status']))?trim($_POST['status']):'';
	$orderby					= (isset($_POST['orderby']))?trim($_POST['orderby']):'';

	$sectionType				= (isset($_POST['sectionType']))?trim($_POST['sectionType']):'';
	$commenting_status			= (isset($_POST['commenting_status']))?trim($_POST['commenting_status']):'';

	$parent_subcategory			= (isset($_POST['parent_subcategory']))?trim($_POST['parent_subcategory']):'';
	$edit_setter_var			= (isset($_POST['edit_setter_var']))?trim($_POST['edit_setter_var']):'';

	$categoryCondition			= (isset($_POST['categoryCondition']))?trim($_POST['categoryCondition']):'';
	$messagetagsetCondition     = (isset($_POST['messagetagsetCondition']))?trim($_POST['messagetagsetCondition']):'';

	$messageData   = $msgObj->selectActiveMessageAndriodPaginationArrayAdmin($tablenamemsg, $message_type, $language_type, $day, $month, $year, $status , $user_privacy, $startLimit, $endLimit , $othercondition ="", $orderby);
	 	
	//echo '<pre>';print_r($messageData);echo '</pre>';die;
	
	//content start****************
	if(empty($messageData)){			
		echo '0';
	} else { 
		foreach($messageData as $uniquekey=> $message) { 

			$action_div_type = $file_type = $mediatext =  $mediacenter = $organicLogo = $logowidthL = $logowidthR = $file_url = $file = $edit_setter_var = $message_url = "";

			$message_id           = $message['id'];
			$unique_div_id        = $uniquekey;
			list($contenttype,$language_type,$content_id)   = explode('_',$uniquekey);
			$content_type         = $contenttype.'_'.$language_type;
			$message_user_id      = $message['user_id'];
			$message_status_type  = $message['status_type'];
			$message_content_type = $message['content_type'];
			$userDetail = $db->getUniversalRow($table_name='users',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$message['user_id'],$otherfields=null);
			if(!empty($userDetail['pfirstname']) && empty($userDetail['plastname'])){  
				$fullname = $userDetail['pfirstname']; 
			} else if(!empty($userDetail['pfirstname']) && !empty($userDetail['plastname'])){ 
				$fullname = $userDetail['pfirstname'].' '.$userDetail['plastname']; 
			} else if(!empty($userDetail['username'])){
				$kvkvar = substr($userDetail['username'],0,3);
				if($kvkvar=='kvk'){
					$fullname = ucwords(substr($userDetail['username'],0,3).' '.substr($userDetail['username'],3));
				} else {
					$fullname = $userDetail['username'];
				}
			} else { 
				$fullname = $userDetail['phone'];
			}

			if(isset($sectionType) && $sectionType=='admin'){
				$broad_cast_date     = date('d M Y',strtotime($message['date']));
			}

			if(isset($sectionType) && $sectionType=='front'){
				$broad_cast_date     = date('d M Y',strtotime($message['broadcast_date']));
			}

			if(isset($message['status']) && $message['status']=='0'){
				$edit_setter_var     = 1;
			}
			if(!empty($message_status_type) && $message_status_type=='1'){
				$messagestatusCategory = $langObj->functionGetSetting($tablename='message_status_settings', $dmlType='1', $message_status_type);
				if(isset($messagestatusCategory['visibilty']) && $messagestatusCategory['visibilty']=='1'){
					$organicLogo = stripslashes($messagestatusCategory['logo']);
					$logowidthL = "logowidthL";
					$logowidthR = "logowidthR";
				}
			}
			if(!empty($message_content_type) && $message_content_type!='' && !empty($message['message_file'])){

				$mediacenter     = "txtcenter";					
				$mediatext       = "mediatext";	
				$action_div_type = $message_content_type;
				$message_file    = $message['message_file'];

				if($action_div_type == 'jpeg' || $action_div_type == 'JPEG' || $action_div_type == 'jpg' || $action_div_type == 'JPG' || $action_div_type == 'pjpeg' || $action_div_type == 'PJPEG' || $action_div_type == 'gif' || $action_div_type == 'GIF'){
					$file      = stripslashes($message_file);
					$file_url  = "/uploads/photos/".$file;
					$file_type = "photo";
				} else if($action_div_type == 'mp3' || $action_div_type == 'MP3' || $action_div_type == 'wav' || $action_div_type == 'WAV'){
					$file     = stripslashes($message_file);
					$file_url = "/uploads/audios/".$file;
					$main_file_url = DOC_ROOT."uploads/audios/".$file;
					if(!file_exists($main_file_url)){
						$file_url = "/uploads/temp/".$file;
					}
					$file_type = "audio";
				} else if($action_div_type == 'flv' || $action_div_type == 'FLV' || $action_div_type == 'mp4' || $action_div_type == 'MP4'){
					$file     = stripslashes($message_file);
					$file_url = "/uploads/videos/".$file;
					$file_type = "video";
				}
			}
			if(!empty($message_content_type) && $message_content_type!='' && !empty($message['message_url'])){

				$mediacenter     = "txtcenter";					
				$mediatext       = "mediatext";	
				$action_div_type = $message_content_type;
				$message_url     = $message['message_url'];
				if($action_div_type == 'embeddedUrl'){
					$file      = '';
					$file_url  = $message_url;
					$file_type = "embeddedUrl";
				}
			}
			?>
			<div class="msgdiscriptiontxt" id="msgdiscriptiontxt_<?php echo $unique_div_id;?>">

				<div class="msgmain fullcontent">
					<div class="msgmain1">
						<div class="msgmain1L">
							<a href="<?php echo URL_SITE; ?>/profile.php?id=<?php echo $userDetail['id'];?>"><?php echo $fullname;?> </a> 
							<?php if(isset($message_data_static)){ echo $message_data_static; } ?>
							<span class="right pR10"><?php if(isset($broad_cast_date)) { echo $broad_cast_date; } ?></span>
						</div>
						<br class="clear">
					</div>

					<!--Photo Gallery-->
					<div class="photomsgshow<?php if(isset($mediacenter)){echo ' '.$mediacenter;}?>">
						
						<!-- MESSAGE DISPLAY -->
						<?php require($DOC_ROOT.'media_display.php');?>	
						<!-- /MESSAGE DISPLAY -->

						<br class="clear">

						<div class="<?php if(isset($mediatext)){echo $mediatext;}?>">
							<?php if(!empty($organicLogo)){ ?>
							<!--Right-->
							<div class="photomsgshowL <?php if(isset($logowidthL)){echo $logowidthL;}?>">	
								<span class="statusimg left">
									<img class="logo" title="<?php echo $organicLogo;?>" alt="<?php echo $organicLogo;?>" src="/uploads/general/<?php echo $organicLogo;?>" />
								</span>														    
							</div>
							<!--/Right-->							
							<?php } ?>
							
							<!--Left-->
							<div class="photomsgshowR <?php if(isset($logowidthR)){echo $logowidthR;}?>">
								<div id="full_message_discription<?php echo $unique_div_id;?>" style="display:none;" class="justify"></div>
								<div id="half_message_discription<?php echo $unique_div_id;?>" class="msgshowing justify">
									<!-- MESSAGE DISPLAY -->
									<?php require($DOC_ROOT.'message_display.php');?>	
									<!-- /MESSAGE DISPLAY -->
								</div>
							</div>
							<!--/Left-->
							<br class="clear">
						</div>
						
						<!-- LIKE DISLIKE DIV -->
						<div id="likes_div_<?php echo $unique_div_id;?>" class="msgresultbuttonleft">
							<!-- MESSAGE ACTION -->
							<?php require($DOC_ROOT.'admin/message_action.php');?>	
							<!-- /MESSAGE ACTION -->
						</div>
						<!-- LIKE DISLIKE DIV -->
						
					</div>
					<!--/Photo Gallery-->
					<br class="clear">
						
				</div>
				<br class="clear">		
			</div>

		<?php } ?>

	<?php } //content end****************?>		

<?php } ?>

<?php if(isset($_GET['deletemessage']) && $_GET['deletemessage']=='1' && !empty($_POST['tablename'])) {
		
	$message_id     = $_POST['message_id'];
	$tablenameMain  = $_POST['tablename'];
	
	//Deleting Message Table Record
	$messageData = $db->getUniversalRow($tablenameMain,$coloum_name_str='*',$updated_on_field='id',$message_id,$otherfields=null);
	if(!empty($messageData)){
		if(file_exists(DOC_ROOT."uploads/audios/".$messageData['message_file']."")){
			@unlink(DOC_ROOT."uploads/audios/".$messageData['message_file']."");
		}
		if(file_exists(DOC_ROOT."uploads/photos/".$messageData['message_file']."")){
			@unlink(DOC_ROOT."uploads/photos/".$messageData['message_file']."");
		}
		$deleteMainTableRecord = $db->deleteUniversalRow($tablenameMain,$updated_on_field='id',$message_id,$otherfields=null);
    
		//Deleting Message Ordinates Table Record
		$tablenameOrdinates = trim('message_ordinates_'.$messageData['language_type']);
		$messageOrdinates   = $db->getUniversalRow($tablenameOrdinates,$coloum_name_str='*',$updated_on_field='msg_id',$message_id,$otherfields=null);
		if(!empty($messageOrdinates)){
			 if(file_exists(DOC_ROOT."uploads/temp/".$messageOrdinates['wave_file']."")){
				@unlink(DOC_ROOT."uploads/temp/".$messageOrdinates['wave_file']."");
			 }
			 if(file_exists(DOC_ROOT."uploads/temp/".$messageOrdinates['csv_file']."")){
				@unlink(DOC_ROOT."uploads/temp/".$messageOrdinates['csv_file']."");
			 }	
			 $deletemessageOrdinates = $db->deleteUniversalRow($tablenameOrdinates,$updated_on_field='msg_id',$message_id,$otherfields=null);
		}
		if($deleteMainTableRecord){
			echo $session_message[7];	
			return true;
		} else {
			echo $session_message[8];	
			return true;
		}
	}else{
		echo $session_message[8];	
		return true;
	}
}
?>
