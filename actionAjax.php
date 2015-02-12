<?php
/******************************************
* @Created on JAN 27, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/actionHeader.php";

if(isset($_GET['logging']) && $_GET['logging']=='1'){
	
	$error     = 0;
	$message   = 'Internal Error';
	$url       = '';

	$username  = $_POST['username'];
	$vpassword = $_POST['password'];
	$password  = md5Hash($_POST['password']);
	$userData  = $userObj->login($username, $password);
	if(!empty($userData)){		
		$setting = $db->getUniversalRow($table_name='user_privacy_settings',$coloum_name_str='*',$updated_on_field='user_id',$updated_on_value=$userData['id'],$otherfields=null);
		if($userData['user_type']=='' || $userData['user_type']=='0'){
			$error   = '0';
			$message = $session_message[1];	
			$url     = '';
			$data    = '1';
		} else if(!is_numeric($userData['user_type'])){
			$project_id = getExploded($userData['user_type'],'-',1);
			$fullname   = $adminObj->getprojectName($project_id);
			$_SESSION['session_user_data'] = $userData;	
			$_SESSION['session_user_data']['dashbordType']='PAU';
			$error   = '1';	
			$data    = '2';
			$message = '';
			if(!empty($setting) && $setting['parent_category_setting']=='1'){
				$_SESSION['msgsuccess'] = "10";
				$url   = '/setting.php/'.$fullname;
			}else {
				$_SESSION['msgsuccess'] = "0";
				$url   = '/dashboard.php/'.$fullname;
			}
		} else if(is_numeric($userData['user_type']) && $projectObj->checkProjectUser($userData['id'])){
			$_SESSION['session_user_data'] = $userData;	
			$_SESSION['session_user_data']['dashbordType'] ='PU';
			$fullname = getUserName($userData,'join');
			$error    = '1';	
			$data     = '3';
			$message  = '';
			if(!empty($setting) && $setting['parent_category_setting']=='1'){
				$_SESSION['msgsuccess'] = "10";
				$url   = '/setting.php?'.$fullname;
			}else {
				$_SESSION['msgsuccess'] = "0";
				$url   = '/index.php?'.$fullname;
			}
		} else{
			$_SESSION['session_user_data'] = $userData;
			$_SESSION['session_user_data']['dashbordType'] ='NU';
			$fullname = getUserName($userData,'join');
			$message  = '';
			$error    = '1';
			$data     = '4';
			if(!empty($setting) && $setting['parent_category_setting']=='1'){
				$_SESSION['msgsuccess'] = "10";
				$url   = '/setting.php?'.$fullname;
			}else {
				$_SESSION['msgsuccess'] = "0";
				$url   = '/index.php?'.$fullname;
			}
		}	
	} else {
		$error   = 0;
		$message = $session_message[1];	
		$data    = '1';
	}

	if($error){
		$updatevisiblepassword = $userObj->updateVisiblePasswordLogin($vpassword, $userData['id']);
	}

	echo function_json_encode(array('data' => $data, 'url' => $url, 'error' => $error, 'message' => $message));
	return true;
}

if(isset($_GET['registering']) && $_GET['registering']=='1'){

	//echo '<pre>';print_r($_POST);echo '</pre>';die;
	//saving record to datebase is left

	$error   = 0;
	$message = $session_message[8];

	if($_SESSION['security_number'] == $_POST['captcha_code']) {

		if(!empty($_POST['email'])){
			$receivename	=   ucwords($_POST['pfirstname'].' '.$_POST['plastname']);
			$receivermail	=   trim($_POST['email']);
			$endode_email   =   base64_encode($receivermail);
			$fromname		=	FROM_NAME;
			$fromemail		=	FROM_EMAIL;

			$mailbody		=	'Welcome '.$receivename.', <br /><p>You have successfully created a Kisan Sanchar Account! Please click the link below to verify your email address. </p><p><a href="'.URL_SITE.'/index.php?verification='.$endode_email.'">'.URL_SITE.'/index.php?verification='.$endode_email.'</a> </p>
			<p>If you are having trouble clicking on the link, please copy and paste it into your browser. </p><br />
			<p>Thank You </p>
			'.SUPPORT_TEXT.'';

			$subject     ='Registration Verfication Mail';	
			$send_mail   = mail_function($receivename,$receivermail,$fromname,$fromemail,$mailbody,$subject, $attachments = array(),$addcc=array());	

			if($send_mail){
				$result      = $userObj->registration($_POST);	
				if($result){			
					$message = $session_message[4];
					$error   = 1;
					$data    = '<div class="pT10 pB10 pL10 pR10 txtcenter"><h1>'.$session_message[4].'</h1><h2><a href="'.URL_SITE.'">Click Here to Login</a></h2></div>';
				}else{
					$message = $session_message[8];	
				}
			}else{
				//IF MAIL NOT SEND
				$message = $session_message[14];
				$data    = '';
			}
		}else{
			$message = $session_message[14];
			$data    = '';
		}
	}else{
		$message = $session_message[3];
		$data    = '';
	}
	echo function_json_encode(array('data' => $data, 'error' => $error, 'message' => $message));
	return true;
}

if(isset($_GET['submitmessage']) && $_GET['submitmessage']!='') {
	$status = $adminObj->functionAddSmsAndriodMsg($_POST);
	if($status){
		echo $langVariables['msg_var']['common_succuss'];
	} else {
		echo $langVariables['msg_var']['intrenal_error'];
	}	
} 

if(isset($_POST['startLimit']) && isset($_POST['tablename']) && isset($_POST['endLimit'])) {

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

	if(isset($sectionType) && $sectionType=='admin'){
		$messageData   = $msgObj->selectActiveMessageAndriodPaginationArrayAdmin($tablenamemsg, $message_type, $language_type, $day, $month, $year, $status , $user_privacy, $startLimit, $endLimit , $othercondition ="", $orderby);
	} 
	if(isset($sectionType) && $sectionType=='front'){
		if(isset($edit_setter_var) && $edit_setter_var=='1'){
			$messageData = $msgObj->selectActiveMessageAndriodPaginationArrayFront($tablenamemsg, $message_type, $language_type, $day, $month, $year, $status, $user_privacy, $startLimit, $endLimit, $othercondition =" ".$categoryCondition." ".$messagetagsetCondition." ",$orderby);
		} else {			
			$messageData = $msgObj->selectActiveMessageAndriodPaginationArrayFront($tablenamemsg, $message_type, $language_type, $day, $month, $year, $status, $user_privacy, $startLimit, $endLimit, $othercondition =" ".$categoryCondition." ".$messagetagsetCondition." ",$orderby);
		}			
	}
	
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
							<ul>
								<?php if(isset($sectionType) && $sectionType=='front'){?>

									   <?php if(isset($_SESSION['session_user_data']['id']) && isset($edit_setter_var) && $edit_setter_var=='1'){?>		
											<li>
												<a href="javascript:;">Edit</a>
											</li>												
											<li>|</li>
											<li id="delete_click_div_<?php echo $unique_div_id;?>">
												<a onclick="javascript:functionDeleteMessages('<?php echo $message_id;?>','<?php echo $unique_div_id;?>','Do you really want to delete this message');" title="delete" href="javascript:;">Trash</a>						
											</li>
										<?php } ?>
											
										<li>
											<?php if(!isset($edit_setter_var) && isset($_SESSION['session_user_data']['id'])){
												  $likeDetail = $msgObj->liked_detail($_SESSION['session_user_data']['id'] , $content_id, $content_type);
												  $display_like = $display_unlike = 'style="display:none;"';
												  if(empty($likeDetail)){
													  $display_like = 'style="display:block;"';
												  } else if(!empty($likeDetail) && $likeDetail['status']=='0'){
													  $display_like = 'style="display:block;"';
												  } else if(!empty($likeDetail) && $likeDetail['status']=='1'){
													  $display_unlike = 'style="display:block;"';
												  }
												  ?>											 
												  <a <?php if(isset($display_like))echo $display_like;?> id="like_<?php echo $unique_div_id;?>" href="javascript:;" <?php if(isset($_SESSION['session_user_data']['id'])){?>onclick="javascript: functionLikeContentComment('<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','1','<?php if(isset($_SESSION['session_user_data']['id'])){ echo $_SESSION['session_user_data']['id'];} else { echo '0';}?>');"<?php }?>>Thanks</a>						  
												  <a <?php if(isset($display_unlike))echo $display_unlike;?> id="unlike_<?php echo $unique_div_id;?>" href="javascript:;" <?php if(isset($_SESSION['session_user_data']['id'])){?>onclick="javascript: functionLikeContentComment('<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','0','<?php if(isset($_SESSION['session_user_data']['id'])){ echo $_SESSION['session_user_data']['id'];} else { echo '0';}?>');"<?php }?>>Undo</a>				
											<?php } else {?>
												<a href="javascript:;">Thanks</a>
											<?php } ?>												
										</li>

										<li>|</li>

										<li>
											<!-- FACEBOOK SHARE-->
											<?php require($DOC_ROOT.'facebookshare.php');?>	
											<!-- /FACEBOOK SHARE-->										
										</li>
										<li>|</li>									
										<li>
											<a id="comment_open_<?php echo $unique_div_id;?>" href="javascript:;" onclick="">Answer</a>
										</li>
										<li>
											<a id="like_loader_<?php echo $unique_div_id;?>"  href="javascript:;"></a>
										</li>									

								<?php } ?>
								
								<?php if(isset($sectionType) && $sectionType=='admin'){?>
									<?php if(isset($message['status']) && $message['status']=='0') {?>								
										<li id="aprrove_dissaprove_div_<?php echo $unique_div_id;?>">
											<a onclick="javascript:functionApproveDisaprove('<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','1','Do you really want to approve this message');" id="aprove_div_<?php echo $unique_div_id;?>" href="javascript:;">Visible</a>
										</li>
										<li>|</li>
										<li id="edit_click_div_<?php echo $unique_div_id;?>">		
											<?php if(isset($message['content_type']) && $message['content_type']=='text'){?>
												<a target="_blank" title="edit" href="<?php echo URL_SITE;?>/admin/edit_text_msg.php?id=<?php echo $message['id'];?>">Modify-Send</a>
											<?php }else if(isset($message['content_type']) && $message['content_type']=='mp3'){?>
												<a target="_blank" title="edit" href="<?php echo URL_SITE;?>/admin/edit_voice_msg.php?id=<?php echo $message['id'];?>">Modify-Send</a>
											<?php }else if(isset($message['content_type']) && $message['content_type']=='wav'){?>
												<a target="_blank" title="edit" href="<?php echo URL_SITE;?>/admin/edit_voice_msg.php?id=<?php echo $message['id'];?>">Modify-Send</a>
											<?php } else{?>
												<a target="_blank" title="edit" href="<?php echo URL_SITE;?>/admin/edit_andriod_msg.php?id=<?php echo $message['id'];?>">Modify</a>
											<?php } ?>
										</li>
										<?php if(isset($message['content_type']) && ($message['content_type']=='text' || $message['content_type']=='mp3' || $message['content_type']=='wav')){?>
										<li>|</li>
										<li id="send_voice_click_div_<?php echo $unique_div_id;?>">
											<a onclick="javascript: functionSendVoiceSms('<?php echo $content_id;?>','<?php if(isset($message['content_type']) && $message['content_type']=='text'){?>textmsg<?php }else if(isset($message['content_type']) && $message['content_type']=='mp3'){?>voicemsg<?php }else if(isset($message['content_type']) && $message['content_type']=='wav'){?>voicemsg<?php } ?>','<?php echo $unique_div_id;?>','Do you really want to send this message to all associated users.It will cost you.');" id="send_voice_div_<?php echo $unique_div_id;?>" href="javascript:;">Send</a>	
										</li>
										<?php } ?>
										<li>|</li>
										<li id="delete_click_div_<?php echo $unique_div_id;?>">
											<a onclick="javascript:functionDeleteMessages('<?php echo $message_id;?>','<?php echo $unique_div_id;?>','Do you really want to delete this message');" title="delete" href="javascript:;">Trash</a>							
										</li>
									<?php } ?>
									<?php if(isset($message['status']) && $message['status']=='1') {?>							
										<li id="aprrove_dissaprove_div_<?php echo $unique_div_id;?>">
											<a onclick="javascript:functionApproveDisaprove('<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','0','Do you really want to disapprove this message');" id="dissaprove_div_<?php echo $unique_div_id;?>" href="javascript:;">Unvisible</a>
										</li>
										<li>|</li>
										<li id="delete_click_div_<?php echo $unique_div_id;?>">
											<a onclick="javascript:functionDeleteMessages('<?php echo $message_id;?>','<?php echo $unique_div_id;?>','Do you really want to delete this message');" title="delete" href="javascript:;">Trash</a>							
										</li>
									<?php } ?>
										<li>
											<a id="broadcast_unbroadcast_loader_<?php echo $unique_div_id;?>"  href="javascript:;"></a>
										</li>										
								<?php } ?>
							</ul>
						</div>
						<!-- LIKE DISLIKE DIV -->
						
						<?php if(isset($sectionType) && $sectionType=='front'){?>
						<!-- COUNT LIKE DISLIKE DIV -->
						<div id="content_like_div_<?php echo $unique_div_id;?>" class="msgresultbuttonright">
							<!-- SHOW TEXT COMMENT -->
							<?php require($DOC_ROOT.'showcontentlikedislike.php');?>	
							<!-- /SHOW TEXT COMMENT -->									
						</div>							
						<!-- COUNT LIKE DISLIKE DIV -->
						<?php } ?>
						
					</div>
					<!--/Photo Gallery-->
					<br class="clear">

					<!-- SHOW TEXT COMMENT -->
					<?php if(isset($sectionType) && $sectionType=='front'){?>
					<?php require($DOC_ROOT.'showtextComment.php');?>						
					<!-- /SHOW TEXT COMMENT -->	
					<?php } ?>
						
				</div>
				<br class="clear">		
			</div>

		<?php } ?>

	<?php } //content end****************?>		

<?php } ?>

<?php if(isset($_POST['msgid']) && isset($_POST['select_msg_body'])){
	  $msgid          = $_POST['msgid'];
	  $unique_div_id  = $_POST['unique_div_id'];
	  $tablename      = $_POST['tablename'];
	  $messageData    = $langObj->functionGetSetting($tablename, $dmlType='1', $msgid);
	  if(!empty($messageData['message'])) {?>	  		
		<div>
			<?php echo stripslashes($messageData['message']);?>
		</div>
		<div>
			<a class="font10" onclick="javascript:fun_message_unshow('<?php echo $messageData['id'];?>','<?php echo $unique_div_id;?>');" href="javascript:;">Hide</a>	
		</div>	  		
	  <?php } ?>
<?php } ?>

<?php
//This part is used on File ../showtextComment.php
if(isset($_GET['ajaxcontentcomment'])){

	$contentcommentOutput = array();

	if(isset($_GET['loadoldcomment'])){
		$content_id       = trim($_POST['content_id']);	
		$content_type     = trim($_POST['content_type']);	
		$unique_div_id    = trim($_POST['unique_div_id']);
		$message_user_id  = trim($_POST['message_user_id']);
		$startlimit       = trim($_POST['limit']);	
		$endlimit         = 10;
		$contentcommentOutput = $msgObj->selectContentComments($content_id, $content_type,$orderby='order by id', $startlimit, $endlimit);		
	}
	if(isset($_GET['recentcontentcomment'])){
		$content_id       = trim($_POST['content_id']);	
		$content_type     = trim($_POST['content_type']);	
		$unique_div_id    = trim($_POST['unique_div_id']);
		$user_id          = trim($_POST['user_id']);
		$commenting     = addslashes($_POST['comment']);
		if(!empty($commenting)){
			$comment_id = $msgObj->insertContentComent($user_id,$content_id, $content_type, $commenting);
		}
		$contentcommentOutput[] = $db->getUniversalRow($table_name='comments',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$comment_id,$otherfields=null);
	}
	if(!empty($contentcommentOutput)){
		foreach($contentcommentOutput as $contents){
			$content_comment_id = $contents['id'];	
			$user = $db->getUniversalRow($table_name='users',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$contents['user_id'],$otherfields=null);
			?>			   
								   
			<div class="answerslidetext" id="commentsslidetext_<?php echo $content_comment_id;?>_<?php echo $unique_div_id;?>">
											
				<div class="msgmain fullcontent">
					<div class="msgdisplay">
						<h5>
							<a href="#"><?php echo $user['pfirstname'];?></a>
						</h5>
						<span class="font12">
							<?php echo date_diff_hour_min($contents['date']);?>
						</span>
						<p><?php echo addslashes($contents['comment'])?></p>						
						<?php if((isset($_SESSION['session_user_data']['id']) && $_SESSION['session_user_data']['id']==$contents['user_id']) || (isset($message_user_id) && (isset($_SESSION['session_user_data']['id'])) && $message_user_id==$_SESSION['session_user_data']['id'])) {?>
							<ul>
								<li>
									<a id="comment_delete_<?php echo $content_comment_id;?>_<?php echo $unique_div_id;?>" href="javascript:;" onclick="javascript:functionDeleteContentComment('<?php echo $unique_div_id;?>','<?php echo $content_comment_id;?>')">Delete</a>
								</li>
							</ul>	
						<?php } ?>						
					</div>
				</div>

			</div>

		<?php } ?>

	<?php } ?>

<?php } ?>

<?php if(isset($_GET['ajaxcontentcommentdelete']) && $_GET['ajaxcontentcommentdelete']!='') {
	$content_comment_id = $_POST['content_comment_id'];
	$status = $msgObj->functionContentCommentDelete($content_comment_id);
	echo $langVariables['msg_var']['common_delete'];
	return true;	
} 
?>
<?php if(isset($_GET['ajaxcontentlikedBy']) && $_GET['ajaxcontentlikedBy']!='') {

	$content_id    = trim($_POST['content_id']);	
	$content_type  = trim($_POST['content_type']);	
	$unique_div_id = trim($_POST['unique_div_id']);
	$like_status   = trim($_POST['like_status']);
	if($like_status==1){
		$liker_detail_result = $msgObj->liked_byUsersAll($content_id, $content_type);
		$liker_detail        = $db->getAll($liker_detail_result);
		$notification        = 'Liked By';
	}else{}
	?>

	<!--PopupBox-->
	<div class="popupwindw">
		
		<div class="poptop">						
			<h4 class="poptitle left"><?php echo $notification;?></h4>

			<div id="close" class="popupclose right">
				<a onclick="javascript:loader_unshow();" href="javascript:;">&nbsp;</a>		
			</div>
		</div>					
		
		<div class="popupcntent">
			<div class="popupform">  
					<?php foreach($liker_detail as $likers){							
						$userDetail = $db->getUniversalRow($table_name='users',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$likers['user_id'],$otherfields=null);
						if(isset($_SESSION['session_user_data']['id']) && !empty($userDetail['id']) && $userDetail['id'] == $_SESSION['session_user_data']['id']) {
							$I_OR_YOU = 'You';							
						} else {
							$I_OR_YOU=ucwords($userDetail['pfirstname'].' '.$userDetail['plastname']);
						}
						?>								
						<div class="popupfrd">		
							<div class="wdthpercent100">
								<div class="wdthpercent10 popupimg left">
									<a href="" class="txtblue">
										<img class="pic" title="<?php echo $userDetail['firstname'];?>" alt="<?php echo $userDetail['image'];?>" <?php if(!empty($userDetail['image'])){ ?> src="/uploads/users/<?php echo $userDetail['id'];?>/<?php echo $userDetail['image']?>" <?php } else { ?> src="/images/no-image.jpeg" <?php } ?>>	
									</a>
								</div>						

								<div class="wdthpercent50 left">
									<a href="<?php echo URL_SITE;?>/front/user/profile.php" class="txtblue"><?php echo $I_OR_YOU;?></a>			
								</div>									
							</div>
						 <div class="clear"></div>								
						 </div>						
					<?php } ?>			
				</div>
			</div>

			<div id="" class="poptop">
				<div class="wdthpercent50 right">
					<input type="button" class="button right" onclick="javascript:loader_unshow();" value="Close">	
				</div>
		   </div>
				 
	</div>
	<!--/PopupBox-->
<?php } ?>

<?php if(isset($_GET['approvedissaprove']) && $_GET['approvedissaprove']!='') {
	$content_id    = trim($_POST['content_id']);	
	$content_type  = trim($_POST['content_type']);	
	$unique_div_id = trim($_POST['unique_div_id']);
	$status        = trim($_POST['status']);	
	if($status =='0'){
		$coloum_name_str = " `status`='".$status."', broadcast_date='', timeline_date='' ";
		$statuscheck = $db->updateUniversalRow($table_name='message',$coloum_name_str,$updated_on_field='id',$updated_on_value=$content_id,$otherfields=null);
		?>
		<a onclick="javascript:functionApproveDisaprove('<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','1','Do you really want to approve this message');" id="aprove_div_<?php echo $unique_div_id;?>" href="javascript:;">Approve</a>
	<?php } else {
		$coloum_name_str = " `status`='".$status."', broadcast_date=NOW(), timeline_date=NOW() ";
		$statuscheck = $db->updateUniversalRow($table_name='message',$coloum_name_str,$updated_on_field='id',$updated_on_value=$content_id,$otherfields=null);
		?>
		<a onclick="javascript:functionApproveDisaprove('<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','0','Do you really want to disapprove this message');" id="dissaprove_div_<?php echo $unique_div_id;?>" href="javascript:;">Disaprove</a>
	<?php }	?>
<?php }	?>

<?php
if(isset($_GET['settingcatsession']) && $_GET['settingcatsession']=='1') {
	$_SESSION['parent_subcategory'] = trim($_POST['parent_subcategory']);	
	return true;		
}
?>

<?php 
//Request from reports.php file
if(isset($_GET['user_group']) && $_GET['user_group']!='') {
	$usergroup      = $db->getUniversalRowAll($table_name="user_groups"," and `parent_id`= '".$_GET['user_group']."' ORDER BY id ");
	$usergroup_all  = array_chunk($usergroup,3);
	if(!empty($usergroup_all)){?>
		<td>Select Village</td>
		<td>
			<table class="data-table">
				<tr>
					<td colspan="3" class="blue fontbld"><input type="checkbox" id="village-type-check-all">&nbsp;&nbsp;All</td>
				</tr>
				<?php foreach($usergroup_all as $key => $groupsAll){ ?>
					<tr>					
						<?php foreach($groupsAll as $key => $groups){ ?>							
							<td>
								<input type="checkbox" name="user_sub_group[]" id="user_sub_group" value="<?php echo $groups['id'];?>" />&nbsp;&nbsp;<?php echo $groups['group_name'];?>
							</td>							
						<?php } ?>
					</tr>
				<?php } ?>				
			</table>
		</td>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#village-type-check-all').click(function () {
				if(jQuery("#village-type-check-all").is(":checked")){
					jQuery("input[type='checkbox'][name='user_sub_group[]']").prop('checked', true);
				} else {
					jQuery("input[type='checkbox'][name='user_sub_group[]']:checked").removeAttr("checked");
				}
			});
			jQuery("input[type='checkbox'][name='user_sub_group[]']").click(function () {
				jQuery('#village-type-check-all').removeAttr("checked");
			});
		});
		</script>
	<?php } ?>
<?php } ?>

<?php 
//voice_sms.php
if(isset($_POST['voice_type']) && $_POST['voice_type']!='') {

	$_SESSION['voice_type'] = $_POST['voice_type'];
	$usergroup       = $db->getUniversalRowAll($table_name='sms_groups',$otherfields=" and `owner_id`='".$front_user_id."' and  `is_active` ='1'");
	$countryArray = $db->getUniversalRowAll($table_name='india'," and `parent_id` ='0' ");

	if($_POST['voice_type'] == 'bulk') { ?>
		
		<div class="wdthpercent100 pT10 pB10">
			<div class="wdthpercent30 left">Upload CSV</div>
			<div class="wdthpercent70 left">
				<input accept="CSV" type="file" id="csv_file_upload" name="csv_file_upload" class="wdthpercent100 required"/>
			</div>
		</div>
		<div class="clear"></div>

		<div class="wdthpercent100">
			<input type="hidden" value="http-audio-contact" name="job_type">	
		</div>		
		
		<div class="wdthpercent100 pT10 pB10">
			<div class="wdthpercent30 left">Select Audio File</div>
			<div class="wdthpercent70 left">
				<input accept="WAV" type="file" id="wav_audio_upload" name="wav_audio_upload" class="wdthpercent100 required"/><small class="red left">Only WAV format</small>
			</div>
		</div>
		<div class="clear"></div>
	<?php } ?>

	<?php if($_POST['voice_type'] == 'group') { ?>
		
		<div class="wdthpercent100">
			<input type="hidden" value="http-audio" name="job_type">	
		</div>

		<div class="wdthpercent100 pT10 pB10">
			<div class="wdthpercent30 left">Select Audio File</div>
			<div class="wdthpercent70 left">
				<input accept="WAV" type="file" id="wav_audio_upload" name="wav_audio_upload" class="wdthpercent100 required"/><small class="red left">Only WAV format</small>
			</div>
		</div>
		<div class="clear"></div>

		<div class="wdthpercent100 pT15 pB10" id="created_group_type_text_content">
			<div class="wdthpercent30 left">Select User Group</div>
			<div class="wdthpercent70 left">
				<?php if(!empty($usergroup)){?>								
					<?php foreach($usergroup as $key => $groups){ ?>
						<span class="wdthpercent50 left pT5 pB5"><input type="checkbox" name="user_group[]" id="user_group_writemgs<?php echo $key;?>" class="required" value="<?php echo $groups['id'];?>" />&nbsp;&nbsp;<?php echo $groups['group_name'];?></span>
					<?php } ?>
						<span class="wdthpercent50 left pT5 pB5">
							<input type="checkbox" onclick="functionSelectAllUserGroupMobile('other','other');" name="user_group[]" id="user_group_writemgsother" value="0" />&nbsp;&nbsp;Others
						</span>

						<div class="wdthpercent100 left pT5 pB5">
							<a id="creategrouppopupdivclick" href="javascript:;">+Add More Group</a>
							<script type="text/javascript">
							jQuery(document).ready(function(){
								jQuery("#creategrouppopupdivclick").click(function(){
									jQuery("#content_seleted_other").remove();
									jQuery("#user_group_writemgsother").prop("checked",false);		
									jQuery("#creategrouppopupdivclick").addClass("sLoader");
									jQuery.ajax({
										type: "POST",
										data: "",
										url : URL_SITE+"/actionAjax.php?creategrouppopupWindow=1",	
										success: function(msg){										
											jQuery("#creategrouppopupdivclick").removeClass("sLoader");
											BLOCKUI_MSG_OBJECT(msg);
										}							
									});									
								});
							});
							</script>	
					   </div>

				<?php } else{ ?>
					No Group created.Please click here to <a id="creategrouppopupdivclick" href="javascript:;">Create Group</a>
					<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery("#creategrouppopupdivclick").click(function(){
							jQuery("#content_seleted_other").remove();
							jQuery("#user_group_writemgsother").prop("checked",false);			
							jQuery("#creategrouppopupdivclick").addClass("sLoader");
							jQuery.ajax({
								type: "POST",
								data: "",
								url : URL_SITE+"/actionAjax.php?creategrouppopupWindow=1",	
								success: function(msg){	
									jQuery("#creategrouppopupdivclick").removeClass("sLoader");
									BLOCKUI_MSG_OBJECT(msg);
								}							
							});									
						});
					});
					</script>

				<?php } ?>	
			</div>
		</div>
		<div class="clear pB10"></div>

		<div id="select_user_sub_group"></div>

	<?php }

	return true;
}
?>

<?php //text_sms.php
if(isset($_GET['getsmstype']) && $_GET['getsmstype']=='1') {
	$_SESSION['sms_type'] = $_POST['sms_type'];
	$usergroup       = $db->getUniversalRowAll($table_name='sms_groups',$otherfields=" and `owner_id`='".$front_user_id."' and  `is_active` ='1'");
	$countryArray = $db->getUniversalRowAll($table_name='india'," and `parent_id` ='0' ");

	if($_POST['sms_type'] == 'bulk') { ?>
		
		<div class="wdthpercent100 pT10 pB10">
			<div class="wdthpercent30 left">Upload CSV</div>
			<div class="wdthpercent70 left">
				<input accept="CSV" type="file" id="csv_file_upload" name="csv_file_upload" class="wdthpercent100 required"/>
			</div>
		</div>
		<div class="clear"></div>	
		
	<?php } ?>

	<?php if($_POST['sms_type'] == 'group') { ?>
		
		<div class="wdthpercent100">
			<input type="hidden" value="http-audio" name="job_type">	
		</div>
		<div class="clear"></div>

		<div class="wdthpercent100 pT15 pB10" id="created_group_type_text_content">
			<div class="wdthpercent30 left">Select User Group</div>
			<div class="wdthpercent70 left">
				<?php if(!empty($usergroup)){?>								
					<?php foreach($usergroup as $key => $groups){ ?>
						<span class="wdthpercent50 left pT5 pB5"><input type="checkbox" name="user_group[]" id="user_group_writemgs<?php echo $key;?>" class="required" value="<?php echo $groups['id'];?>" />&nbsp;&nbsp;<?php echo $groups['group_name'];?></span>
					<?php } ?>
						<span class="wdthpercent50 left pT5 pB5">
							<input type="checkbox" onclick="functionSelectAllUserGroupMobile('other','other');" name="user_group[]" id="user_group_writemgsother" value="0" />&nbsp;&nbsp;Others
						</span>

						<div class="wdthpercent100 left pT5 pB5">
							<a id="creategrouppopupdivclick" href="javascript:;">+Add More Group</a>
							<script type="text/javascript">
							jQuery(document).ready(function(){
								jQuery("#creategrouppopupdivclick").click(function(){
									jQuery("#content_seleted_other").remove();
									jQuery("#user_group_writemgsother").prop("checked",false);		
									jQuery("#creategrouppopupdivclick").addClass("sLoader");
									jQuery.ajax({
										type: "POST",
										data: "",
										url : URL_SITE+"/actionAjax.php?creategrouppopupWindow=1",	
										success: function(msg){										
											jQuery("#creategrouppopupdivclick").removeClass("sLoader");
											BLOCKUI_MSG_OBJECT(msg);
										}							
									});									
								});
							});
							</script>	
					   </div>

				<?php } else{ ?>
					No Group created.Please click here to <a id="creategrouppopupdivclick" href="javascript:;">Create Group</a>
					<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery("#creategrouppopupdivclick").click(function(){
							jQuery("#content_seleted_other").remove();
							jQuery("#user_group_writemgsother").prop("checked",false);			
							jQuery("#creategrouppopupdivclick").addClass("sLoader");
							jQuery.ajax({
								type: "POST",
								data: "",
								url : URL_SITE+"/actionAjax.php?creategrouppopupWindow=1",	
								success: function(msg){	
									jQuery("#creategrouppopupdivclick").removeClass("sLoader");
									BLOCKUI_MSG_OBJECT(msg);
								}							
							});									
						});
					});
					</script>

				<?php } ?>	
			</div>
		</div>
		<div class="clear pB10"></div>

		<div id="select_user_sub_group"></div>
	
	<?php }

	return true;
} 
?>

<?php
//voice_sms.php
if(isset($_POST['job_type']) && $_POST['job_type']!='') {	
	$_SESSION['job_type']   = $_POST['job_type'];
	return true;
} 
?>

<?php //Request from reports.php file
if(isset($_GET['user_group_id']) && $_GET['user_group_id']!='') {
	$usergroup      = $db->getUniversalRowAll($table_name="user_groups"," and `parent_id`= '".$_GET['user_group_id']."' ORDER BY id ");
	$usergroup_all  = array_chunk($usergroup,3);
	if(!empty($usergroup_all)){?>

		<div class="wdthpercent50 left">&nbsp;</div>
		<div class="wdthpercent50 left">
			<input type="checkbox" id="village-type-check-all">&nbsp;&nbsp;<span class="fontbld">All</span> <br />
			<?php foreach($usergroup_all as $key => $groupsAll){ ?>									
				<?php foreach($groupsAll as $key => $groups){ ?>							
					<span class="wdthpercent40 left"><input type="checkbox" name="user_sub_group[]" id="user_sub_group" value="<?php echo $groups['id'];?>" />&nbsp;<?php echo trim($groups['group_name']);?></span>										
				<?php } ?>			
			<?php } ?>
		</div>
		<div class="clear pB10"></div>	

		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#village-type-check-all').click(function () {
				if(jQuery("#village-type-check-all").is(":checked")){
					jQuery("input[type='checkbox'][name='user_sub_group[]']").prop('checked', true);
				} else {
					jQuery("input[type='checkbox'][name='user_sub_group[]']:checked").removeAttr("checked");
				}
			});
			jQuery("input[type='checkbox'][name='user_sub_group[]']").click(function () {
				jQuery('#village-type-check-all').removeAttr("checked");
			});
		});
		</script>

	<?php } ?>

<?php } ?>

<?php if(isset($_GET['deletemessage']) && $_GET['deletemessage']=='1') {
	$message_id = $_POST['message_id'];
	$messageData = $db->getUniversalRow($table_name='message',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$message_id,$otherfields=null);
	if(isset($messageData['message_file']) && $messageData['message_file']!=''){
		 if(file_exists("uploads/audios/".$messageData['message_file']."")){
			unlink("uploads/audios/".$messageData['message_file']."");
		 }
		 if(file_exists("uploads/photos/".$messageData['message_file']."")){
			unlink("uploads/photos/".$messageData['message_file']."");
		 }
    }
	if($db->deleteUniversalRow($table_name='message',$updated_on_field='id',$updated_on_value=$message_id,$otherfields=null)){
		echo $session_message[7];	
		return true;
	} else {
		echo $session_message[8];	
		return true;
	}
}
?>

<?php 
//Request from reports.php file
if(isset($_GET['user_group_wise12May14']) && $_GET['user_group_wise12May14']!='') {
	if($_POST['user_group']!='all'){?>
		<?php $usergroup      = $db->getUniversalRowAll($table_name="user_groups"," and `parent_id`= '".$_POST['user_group']."' ORDER BY id ");
		if(!empty($usergroup)){?>
			<td>Select Village</td>
			<td>									
				<select class="wdthpercent70 required" name="user_sub_group" id="user_sub_group_select">
					<option selected="selected" value="">Select Village</option>
					<?php foreach($usergroup as $key => $groups){ ?>
						<option value="<?php echo $groups['id']; ?>"><?php echo $groups['group_name']; ?></option>
					<?php } ?>
				</select>
				<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery("#display_farmer_list").hide();
					jQuery('#user_sub_group_select').change(function(){
						var user_sub_group = jQuery("#user_sub_group_select").val();
						if(user_sub_group != '0' && user_sub_group!=''){	
							loader_show();
							jQuery.ajax({
								type: "POST",
								data: "user_sub_group="+user_sub_group,
								url : URL_SITE+"/actionAjax.php?farmer_selection=1",			
								success: function(msg){
									loader_unshow();
									jQuery("#display_farmer_list").html(msg).show();	
									if(!jQuery('#notrenderidfr').hasClass("notrenserclassfr")){
										jQuery('#'+divid+'').after('<tr id="notrenderidfr" class="notrenserclassfr"><td>&nbsp;</td><td>&nbsp;</td></tr>');
									}									
								}							
							});	
						}else{
							return false;
						}
					});
				});
				</script>
		<?php } ?>
	<?php } ?>
<?php } ?>


<?php 
//Request from reports.php file
if(isset($_GET['farmer_selection']) && $_GET['farmer_selection']=='1') {
	$userData      = $db->getUniversalRowAll($table_name="users"," and `village`= '".$_POST['user_sub_group']."' ORDER BY id ");
	$userData_all  = array_chunk($userData,3);
	if(!empty($userData_all)){?>
		<td>Select Farmer</td>
		<td>
			<table class="data-table">
				<tr>
					<td colspan="3" class="blue fontbld"><input type="checkbox" id="user-type-check-all">&nbsp;&nbsp;All</td>
				</tr>
				<?php foreach($userData_all as $key => $farmersAll){ ?>
					<tr>					
						<?php foreach($farmersAll as $key => $farmer){ ?>							
							<td>
								<input type="checkbox" name="receiver_id[]" id="receiver_id" value="<?php echo $farmer['id'];?>" />&nbsp;&nbsp;<?php echo $farmer['phone'];?>
							</td>							
						<?php } ?>
					</tr>
				<?php } ?>	
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#user-type-check-all').click(function () {
				if(jQuery("#user-type-check-all").is(":checked")){
					jQuery("input[type='checkbox'][name='receiver_id[]']").prop('checked', true);
				} else {
					jQuery("input[type='checkbox'][name='receiver_id[]']:checked").removeAttr("checked");
				}
			});
			jQuery("input[type='checkbox'][name='receiver_id[]']").click(function () {
				jQuery('#user-type-check-all').removeAttr("checked");
			});
		});
		</script>
	<?php } ?>
<?php } ?>

<?php 
if(isset($_POST['section_type']) && $_POST['section_type']=='subcategory') {
	$parent_id = $_POST['parentid'];
	$fieldid   = $_POST['fieldid'];
	$categoryDetail = $adminObj->functiongetSubCategory($tablename='category', $parent_id);
	$categoryDetail_all  = array_chunk($categoryDetail,2);
	if(!empty($categoryDetail)){?>
		<div class="wdthpercent30 left">Select Sub Category</div>
		<div class="wdthpercent70 left">
			<table class="data-table">

				<tr>
					<td colspan="3" class="blue fontbld"><input type="checkbox" id="sub-cg-category-type-check-all-<?php echo $fieldid;?>">&nbsp;&nbsp;All</td>
				</tr>
				<?php foreach($categoryDetail_all as $key => $categoryAll){ ?>
					<tr>					
						<?php foreach($categoryAll as $key => $category){ ?>							
							<td>
								<input class="required" type="checkbox" id="<?php echo $fieldid;?>" name="<?php echo $fieldid;?>[]" value="<?php echo $category['id'];?>" />&nbsp;&nbsp;<?php echo $category['category_name'];?>
							</td>							
						<?php } ?>
					</tr>
				<?php } ?>

				<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery('#sub-cg-category-type-check-all-<?php echo $fieldid;?>').click(function () {
						if(jQuery("#sub-cg-category-type-check-all-<?php echo $fieldid;?>").is(":checked")){
							jQuery("input[type='checkbox'][name='<?php echo $fieldid;?>[]']").prop('checked', true);
						} else {
							jQuery("input[type='checkbox'][name='<?php echo $fieldid;?>[]']:checked").removeAttr("checked");
						}
					});
					jQuery("input[type='checkbox'][name='<?php echo $fieldid;?>[]']").click(function () {
						jQuery('#sub-cg-category-type-check-all-<?php echo $fieldid;?>').removeAttr("checked");
					});
				});
				</script>

			</table>
		</div>
	<?php } else { ?>
		<div class="wdthpercent30 left">Select Sub Category</div>
		<div class="wdthpercent70 left">
			<select class="wdthpercent100 required">
				<option value="">No Sub Category</option>
			</select>
		</div>
		<?php } ?>
		<div class="clear pB10"></div>
<?php } ?>

<?php if(isset($_POST['section_type']) && $_POST['section_type']=='subcategorygeneral') {
	$parent_id = $_POST['parentid'];
	$categoryDetail = $adminObj->functiongetSubCategory($tablename='category', $parent_id);
	if(!empty($categoryDetail)) { ?>
	<div class="wdthpercent30 left">Select Sub Category</div>
	<div class="wdthpercent70 left">
		<select class="wdthpercent100 required" id="sub_category" name="sub_category">
			<option value="">Select Sub Category</option>
			<?php foreach($categoryDetail as $key => $category){ ?>
				<option value="<?php echo $category['id']; ?>"><?php echo $category['category_name'];?></option>
			<?php } ?>
		</select>
	</div>
	<?php } else { ?>
	<div class="wdthpercent30 left">Select Sub Category</div>
	<div class="wdthpercent70 left">
		<select class="wdthpercent100 required">
			<option value="">No Sub Category</option>
		</select>
	</div>
	<?php } ?>
	<div class="clear pB10"></div>
<?php } ?>


<?php 
if(isset($_GET['forgotpasswordemail']) && $_GET['forgotpasswordemail']=='1') {
	$email      = $_POST['email'];
	$userData	= $userObj->checkEmailExistence($email,$status=1);
	if(empty($userData)) {
		echo '<p class="txtcenter red">Email ID doesnot exists.</p>';		       
		return true;
	} else {		
		//updating user account password and sending password
		$password        =   randomPassword();
		$coloum_name_str = " `password`='".md5($password)."' ";
		$statusUpdate    = $db->updateUniversalRow($table_name='users',$coloum_name_str,$updated_on_field='id',$updated_on_value=$userData['id'],$otherfields=null);
		if(!$statusUpdate){
			echo '<p class="txtcenter red">Internal Error Occurs.Please try again!</p>';		       
			return true;
			exit;
		}
		$receivename	=   ucwords($userData['firstname'].' '.$userData['lastname']);
		$receivermail	=   trim($userData['email']);
		$endode_email   =   base64_encode($receivermail);
		$fromname		=	FROM_NAME;
		$fromemail		=	FROM_EMAIL;		
		$mailbody		=	'<p>You have successfully recovered your password of Kisan Sanchar Account!</p><p>Email:'.$receivermail.'<br />Password:'.$password.'</p><p>Please click the link below to login.</p><p>Login Detail:</p><p><a href="'.URL_SITE.'/index.php?email='.$endode_email.'">'.URL_SITE.'/index.php?email='.$endode_email.'</a> </p><p>If you are having trouble clicking on the link, please copy and paste it into your browser. </p><br />
		<p>Thank You </p>
		'.SUPPORT_TEXT.'';
		$subject		= 'Password Recovery Mail';	
		$send_mail		= mail_function($receivename,$receivermail,$fromname,$fromemail,$mailbody,$subject, $attachments = array(),$addcc=array());
		echo '<p class="txtcenter green">Email has been sent succussfully in your Mail ID.</p>';
		return true;
	}
}
?>

<?php 
//Request from reports.php file
if(isset($_GET['selectusergroup']) && $_GET['selectusergroup']=='1') {
	if($_POST['user_group'] == 'other'){ ?>
		<div id="content_seleted_<?php echo $_POST['user_group'];?>" class="wdthpercent100 pT15 pB10">
			<div class="wdthpercent30 left">Enter Number for Others</div>
			<div class="wdthpercent70 left">	
				<textarea placeholder="enter number seperated by comma(,)" id="user_sub_group_<?php echo $_POST['user_group'];?>" name="user_sub_group_<?php echo $_POST['user_group'];?>[]" class="wdthpercent100 required" /></textarea>			
			</div>
		<div class="clear pB10"></div>
		</div>
	<?php } else { ?>
		<?php
		$groupDetail    = $db->getUniversalRow($table_name="user_groups",$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$_POST['user_group'],$otherfields=null);
		$usergroup      = $db->getUniversalRowAll($table_name="user_groups"," and `parent_id`= '".$_POST['user_group']."' ORDER BY id ");
		$usergroup_all  = array_chunk($usergroup,3);
		if(!empty($usergroup_all)){?>
			<div id="content_seleted_<?php echo $_POST['user_group'];?>" class="wdthpercent100 pT15 pB10">
				<div class="wdthpercent30 left">Select <?php echo $groupDetail['group_name'];?> Village</div>
				<div class="wdthpercent70 left">	
					<table class="data-table">
						<tr>
							<td colspan="3" class="blue fontbld"><input type="checkbox" id="village-type-check-all-<?php echo $_POST['user_group'];?>">&nbsp;&nbsp;All</td>
						</tr>
						<?php foreach($usergroup_all as $key => $groupsAll){ ?>
							<tr>					
								<?php foreach($groupsAll as $key => $groups){ ?>							
									<td>
										<input type="checkbox" name="user_sub_group[]" class="required user_sub_group_<?php echo $_POST['user_group'];?>" value="<?php echo $groups['id'];?>" />&nbsp;&nbsp;<?php echo $groups['group_name'];?>
									</td>							
								<?php } ?>
							</tr>
						<?php } ?>				
					</table>
				</div>
			<div class="clear pB10"></div>
			</div>
			<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#village-type-check-all-<?php echo $_POST['user_group'];?>").click(function () {
					if(jQuery("#village-type-check-all-<?php echo $_POST['user_group'];?>").is(":checked")){
						jQuery(".user_sub_group_<?php echo $_POST['user_group'];?>").prop('checked', true);
					} else {
						jQuery(".user_sub_group_<?php echo $_POST['user_group'];?>").removeAttr("checked");
					}
				});
				jQuery(".user_sub_group_<?php echo $_POST['user_group'];?>").click(function () {
					jQuery("#village-type-check-all-<?php echo $_POST['user_group'];?>").removeAttr("checked");
				});
			});
			</script>
		<?php } ?>

	<?php } ?>

<?php } ?>

<?php
if(isset($_GET['removeallfilter']) && $_GET['removeallfilter']=='1') {
	unset($_SESSION['filter_data']);
	unset($_SESSION['parent_subcategory']);
	return true;		
}
?>

<?php 
//Request from reports.php file
if(isset($_GET['user_group_wise']) && $_GET['user_group_wise']=='1') {
	$usergroup      = $db->getUniversalRowAll($table_name="user_groups"," and `parent_id`= '".$_POST['user_group']."' ORDER BY id ");
	$usergroup_all  = array_chunk($usergroup,3);
	if(!empty($usergroup_all)){?>
		<td>Select Village</td>
		<td>
			<table class="data-table">
				<tr>
					<!-- <td colspan="3" class="blue fontbld"><input type="checkbox" id="village-type-check-all">&nbsp;&nbsp;All</td> -->
				</tr>
				<?php foreach($usergroup_all as $key => $groupsAll){ ?>
					<tr>					
						<?php foreach($groupsAll as $key => $groups){ ?>							
							<td>
								<input type="checkbox" name="user_sub_group[]" onclick="javascript: functionUserGroupMobileFarmerWise('<?php echo $groups['id'];?>','<?php echo $groups['group_name'];?>','<?php echo $_POST['gender'];?>');" id="user_sub_group_select_<?php echo $groups['id'];?>" value="<?php echo $groups['id'];?>" />&nbsp;&nbsp;<?php echo $groups['group_name'];?>
							</td>							
						<?php } ?>
					</tr>
				<?php } ?>				
			</table>
		</td>
	<?php } ?>
<?php } ?>

<?php 
//Request from reports.php file
if(isset($_GET['farmer_selection_refine']) && $_GET['farmer_selection_refine']=='1') {
	$genderStr = '';
	if(isset($_POST['gender']) && $_POST['gender']!='all'){
		$genderStr = " and `gender` = '".$_POST['gender']."' ";
	}
	$userData      = $db->getUniversalRowAll($table_name="users"," and `village`= '".$_POST['user_sub_group']."' ".$genderStr." ORDER BY id ");
	$userData_all  = array_chunk($userData,4);
	if(!empty($userData_all)){?>
		<tr class="content_seleted_farmer_remove" id="content_seleted_farmer_<?php echo $_POST['user_sub_group'];?>">
			<td class="lft-td"><h4><?php echo $_POST['group_name'];?></h4></td>
			<td class="rht-td">
				<table class="data-table">
					<tr>
						<td colspan="3" class="blue fontbld"><input type="checkbox" id="village-type-check-all-<?php echo $_POST['user_sub_group'];?>">&nbsp;&nbsp;All</td>
					</tr>
					<?php foreach($userData_all as $key => $farmersAll){ ?>
						<tr>					
							<?php foreach($farmersAll as $key => $farmer){ ?>							
								<td>
									<input title="<?php echo ucwords($farmer['pfirstname'].' '.$farmer['plastname']);?>" type="checkbox" name="receiver_id[]" class="receiver_id_class_<?php echo $_POST['user_sub_group'];?>" value="<?php echo $farmer['id'];?>" />&nbsp;&nbsp;<?php echo $farmer['phone'];?>
								</td>							
							<?php } ?>
						</tr>
					<?php } ?>	
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
			<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#village-type-check-all-<?php echo $_POST['user_sub_group'];?>").click(function () {
					if(jQuery("#village-type-check-all-<?php echo $_POST['user_sub_group'];?>").is(":checked")){
						jQuery(".receiver_id_class_<?php echo $_POST['user_sub_group'];?>").prop('checked', true);
					} else {
						jQuery(".receiver_id_class_<?php echo $_POST['user_sub_group'];?>").removeAttr("checked");
					}
				});
				jQuery(".receiver_id_class_<?php echo $_POST['user_sub_group'];?>").click(function () {
					jQuery("#village-type-check-all-<?php echo $_POST['user_sub_group'];?>").removeAttr("checked");
				});
			});
			</script>
		<tr>
	<?php } else { ?>
		<tr class="content_seleted_farmer_remove" id="content_seleted_farmer_<?php echo $_POST['user_sub_group'];?>">
			<td class="lft-td"><h4><?php echo $_POST['group_name'];?></h4></td>
			<td class="rht-td">
				<table class="data-table">
					<tr>							
						<td>
							No user found.
						</td>
					</tr>
					
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
		<tr>
	<?php } ?>
<?php } ?>

<?php if(isset($_GET['deleteuniversal']) && $_GET['deleteuniversal']!='') {
	$content_id = $_POST['content_id'];
	$status = $db->deleteUniversalRow($table_name='contact_us','id',$content_id,$otherfields=null);
	echo $langVariables['msg_var']['common_delete'];
	return true;	
} 
?>

<?php 
//Request from add-project-user.php file
if(isset($_GET['district_state_wise']) && $_GET['district_state_wise']=='1') {
	if($_POST['datavalue']=='hr'){
		$district_code = 1;
	}else{
		$district_code = 2;
	}
	$districts     = $db->getUniversalRowAll($table_name="user_groups"," and `id`= '".$district_code."' ORDER BY id ");
	if(!empty($districts)){?>
		<td class="wdthpercent50">District</td>
		<td class="wdthpercent50">									
			<select onchange="javascript: FunctionSelectUniversal('show_village_list','district','district_village_wise','village');" class="inputbox required" id="district" name="district">
				<option selected="selected" value="">Select District</option>
				<?php foreach($districts as $key => $district){ ?>
					<option value="<?php echo $district['id']; ?>"><?php echo $district['group_name']; ?></option>
				<?php } ?>
			</select>
	<?php } ?>
<?php } ?>

<?php 
//Request from add-project-user.php file
if(isset($_GET['district_village_wise']) && $_GET['district_village_wise']=='1') {
	$villages     = $db->getUniversalRowAll($table_name="user_groups"," and `parent_id`= '".$_POST['datavalue']."' ORDER BY id ");
	if(!empty($villages)){?>
		<td class="wdthpercent50">Village</td>
		<td class="wdthpercent50">									
			<select class="inputbox required" id="village" name="village">
				<option selected="selected" value="">Select Village</option>
				<?php foreach($villages as $key => $village){ ?>
					<option value="<?php echo $village['id']; ?>"><?php echo $village['group_name']; ?></option>
				<?php } ?>
			</select>
	<?php } ?>
<?php } ?>

<?php 
//Request from add-project-user.php file
if(isset($_GET['remove_project_user']) && $_GET['remove_project_user']=='1') {
	$project_id  = $_POST['projectid'];
	$user_id     = $_POST['contentid'];
	if($db->delete("DELETE FROM `projects_users` WHERE `user_id` = '".$user_id."' and `project_id` = '".$project_id."' ")){
		echo $session_message[9];	
		return true;
	}else{
		return true;
	}
} 
?>

<?php 
//Request from add-project-user.php file
if(isset($_GET['active_inactive_project_user']) && $_GET['active_inactive_project_user']=='1') {
	$project_id      = $_POST['projectid'];
	$user_id         = $_POST['contentid'];
	$is_active       = $_POST['removedivid'];
	$coloum_name_str = " `is_active` ='".$is_active."' ";
	$result          = $projectObj->updateActiveInactiveProjectUser($tablename="projects_users", $project_id, $user_id, $is_active);
	if($is_active == '1'){?>
		<a id="loader_div<?php echo $user_id;?>" onclick="javascript: FunctionRemoveUniversal('<?php echo $project_id;?>', '<?php echo $user_id;?>','0','loader_div','active_inactive_project_user');" href="javascript:;">Deactivate</a>
	<?php }else{?>
		<a id="loader_div<?php echo $user_id;?>" onclick="javascript: FunctionRemoveUniversal('<?php echo $project_id;?>', '<?php echo $user_id;?>','1','loader_div','active_inactive_project_user');" href="javascript:;">Activate</a>
	<?php } ?>
<?php } ?>

<?php 
//Request from signup.php file
if(isset($_GET['country_wise']) && $_GET['country_wise']=='1') {
	$contentid  = $_POST['contentid'];
	$stateArray = $db->getUniversalRowAll($table_name='india'," and `parent_id` ='".$contentid."' ");
	if(isset($_POST['returntype']) && $_POST['returntype']=='checkbox'){
		$state_all  = array_chunk($stateArray,3);
		if(!empty($state_all)){?>
			<td class="lft-td">Village</td>
			<td class="rht-td">
				<table class="data-table">
					<?php foreach($state_all as $key => $groupsAll){ ?>
						<tr>					
							<?php foreach($groupsAll as $key => $groups){
								if($groups['name']!='Other'){?>							
									<td>
										<input title="<?php echo $groups['name'];?>" type="checkbox" name="village[]" onclick="javascript: functionUserGroupMobileFarmerWise('<?php echo $groups['id'];?>','<?php echo $groups['name'];?>','<?php echo $_POST['gender'];?>');" id="user_sub_group_select_<?php echo $groups['id'];?>" value="<?php echo $groups['id'];?>" />&nbsp;&nbsp;<?php if(strlen($groups['name']) > 25){echo substr($groups['name'],0,25).'...';} else { echo $groups['name'];}?>
									</td>	
								<?php } ?>
							<?php } ?>
						</tr>
					<?php } ?>				
				</table>
			</td>
		<?php } ?>
	<?php } else {?>
		<?php if(!empty($stateArray)){?>		
			<!-- <option selected="selected" value="">Select State</option> -->
			<?php foreach($stateArray as $key => $state){ ?>
				<option value="<?php echo $state['id']; ?>"><?php echo $state['name']; ?></option>
			<?php } ?>			
		<?php } ?>
	<?php } ?>
<?php } ?>

<?php if(isset($_GET['selection_type_check']) && $_GET['selection_type_check']=='1') {

	$error   = 0;
	$message = 'Internal Error';

	$selection_type     = (isset($_POST['selection_type']))?$_POST['selection_type']:'by_name';
	$group_id           = (isset($_POST['group_id']))?$_POST['group_id']:'';

	$userDetailNameJson  = $projectObj->getProjectAssociatedGloblaData($tablename='projects_locations',IS_PROJECT_ID,$contentType='f',$selection_type);

	if(isset($userDetailNameJson) && $userDetailNameJson!=''){

		$error = 1;

		$data  ='
		<div class="wdthpercent30 left">Enter '.ucwords(str_replace('_',' ',$selection_type)).' </div>
		<div class="wdthpercent60 left">
			<input type="text" name="assigned_users" id="assigned_users" class="wdthpercent80 required"/>
			 <script type="text/javascript">
			 $(document).ready(function() {	
				$("#assigned_users").tokenInput('.$userDetailNameJson.', {	
					preventDuplicates: true
				});		
			 });					
			 </script>					   
		</div>	
		<div class="wdthpercent10 left">
			<input type="submit" type="submitid"  class="button" value="'.$langVariables["form_var"]["submit"].'" name="submitreportgroupforms">			
		</div>
	   ';	   
	}
	echo function_json_encode(array('data' => $data, 'error' => $error, 'message' => $message));
}
?>

<?php if(isset($_GET['addingsmsgroupname']) && $_GET['addingsmsgroupname']=='1') {
	$data = '';
	$group_id  = $db->functionInsertUniversalData($tablename='sms_groups', $_POST);
	if($group_id){
		$error   = 1;
		$message = $session_message[7];	
		$data.='<div class="pT10 pB10">
			<form action="" method="post" id="addreportgroupformspopup" name="addreportgroupformspopup">
				
				<h1 class="title">Add Group Member</h1>
				
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent30 left">Select Group Addition Type </div>
					<div class="wdthpercent70 left">
						<select class="wdthpercent100 required" id="selection_type" name="selection_type">
							<option value="">Select Group Addition Type</option>
							<option value="by_name">By User Name</option>
							<option value="by_phone_number">By User Phone Number</option>				
						</select>
						<input type="hidden" name="group_id" id="group_id" value="'.$group_id.'"> 
					</div>
				</div>
				<div class="clear pB10"></div>

				<div id="selection_type_display" class="wdthpercent100 pT10 pB10" style="display:none;">
				</div>
				<div class="clear"></div>

			</form>	
		</div>
		<div class="clear"></div>';

		$data.='<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#addreportgroupformspopup #selection_type").change(function(e){
				e.preventDefault();	
				var selection_type = jQuery(this).val();
				var group_id       = jQuery("#group_id").val();
				if(selection_type!=""){
					jQuery("#selection_type_display").html("");
					jQuery("#selection_type_display").addClass("sLoader").show();
					jQuery.ajax({
						type: "POST",
						data: "selection_type="+selection_type+"&group_id="+group_id,
						url : URL_SITE+"/actionAjax.php?selection_type_check=1",	
						success: function(msg){
							jQuery("#selection_type_display").removeClass("sLoader");
							var obj = jQuery.parseJSON(msg);
							if(obj.error=="1"){
								jQuery("#selection_type_display").html(obj.data).show();
							}else{
								jQuery("#selection_type_display").html(obj.message).show();
							}
						}
					});
				}else{
					jQuery("#selection_type_display").html("");
					return false;
				}
				
			});
		});
		jQuery(document).ready(function(){
			jQuery("#addreportgroupformspopup").submit(function(e){				
				e.preventDefault();	
				var assigned_users = jQuery("#assigned_users").val();
				if(assigned_users!=""){
					jQuery("#submitid").val("Please Wait..");				
					jQuery.ajax({
						type: "POST",
						data: jQuery("#addreportgroupformspopup").serialize(),
						url : URL_SITE+"/actionAjax.php?addingassignedusers=1",	
						success: function(msg){
							var obj = jQuery.parseJSON(msg);
							jQuery("#errordisplaydiv").addClass("txtcenter fontbld");
							if(obj.error=="0"){
								jQuery("#errordisplaydiv").removeClass("green");
								jQuery("#errordisplaydiv").addClass("red");
								jQuery("#errordisplaydiv").html(obj.message).show();	
								jQuery("#submitid").val("Submit");
							}else{
								jQuery("#errordisplaydiv").addClass("green");
								jQuery("#errordisplaydiv").removeClass("red");
								jQuery("#errordisplaydiv").html(obj.message).show();		
								jQuery("#addreportgroupformspopup").addClass("fadeLoader");	
								jQuery.ajax({
									type: "POST",
									data: "",
									url : URL_SITE+"/actionAjax.php?getcreatedsmstype=1",	
									success: function(msg){
										loader_unshow();
										jQuery("#created_group_type_text_content").html(msg);
									}
								});								
							}
						}
					});
				}else{
					return false;
				}
				
			});
		});
		</script>';		
	}else{
		$error   = 0;
		$message = $session_message[14];	
	}
	echo function_json_encode(array('data' => $data, 'error' => $error, 'message' => $message));
}
?>

<?php if(isset($_GET['addingassignedusers']) && $_GET['addingassignedusers']=='1'){
	$result  = $adminObj->functionInsertGroupMembersData($tablename='sms_groups_members', $_POST);
	if($result){
		$error   = 1;
		$message = $session_message[7];
		$data    = '';
	}else{
		$error   = 0;
		$message = $session_message[8];	
	}
	echo function_json_encode(array('data' => $data, 'error' => $error, 'message' => $message));
}
?>

<?php //kisansan@192.186.222.198:/public_html/create-group-popup.php
if(isset($_GET['getcreatedsmstype']) && $_GET['getcreatedsmstype']=='1') {	
	$usergroup = $db->getUniversalRowAll($table_name='sms_groups',$otherfields=" and `owner_id`='".$front_user_id."' and  `is_active` ='1'");
	?>
	<div class="wdthpercent100 pT15 pB10" id="created_group_type_text_content">
		<div class="wdthpercent30 left">Select User Group</div>
		<div class="wdthpercent70 left">
			<?php if(!empty($usergroup)){?>								
				<?php foreach($usergroup as $key => $groups){ ?>
					<span class="wdthpercent50 left pT5 pB5"><input type="checkbox" name="user_group[]" id="user_group_writemgs<?php echo $key;?>" class="required" value="<?php echo $groups['id'];?>" />&nbsp;&nbsp;<?php echo $groups['group_name'];?></span>
				<?php } ?>
					<span class="wdthpercent50 left pT5 pB5"><input type="checkbox" onclick="functionSelectAllUserGroupMobile('other','other');" name="user_group[]" id="user_group_writemgsother" value="0" />&nbsp;&nbsp;Others</span>
			<?php } ?>
			<div class="wdthpercent100 left pT5 pB5">
				<a id="creategrouppopupdivclick" href="javascript:;">+Add More Group</a>
				<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery("#creategrouppopupdivclick").click(function(){						
						jQuery("#content_seleted_other").remove();
						jQuery("#user_group_writemgsother").prop("checked",false);
						jQuery("#creategrouppopupdivclick").addClass("sLoader");
						jQuery.ajax({
							type: "POST",
							data: "",
							url : URL_SITE+"/actionAjax.php?creategrouppopupWindow=1",	
							success: function(msg){		
								jQuery("#creategrouppopupdivclick").removeClass("sLoader");
								BLOCKUI_MSG_OBJECT(msg);
							}							
						});									
					});
				});
				</script>	
			</div>
		</div>
	</div>
	<div class="clear pB10"></div>

	<div id="select_user_sub_group"></div>

<?php } ?>

<?php //kisansan@192.186.222.198:/public_html/create-group-popup.php
if(isset($_GET['creategrouppopupWindow']) && $_GET['creategrouppopupWindow']=='1') {
	include_once($DOC_ROOT.'create-group-popup.php');
}
?>

<?php 
//Request from signup.php file
if(isset($_GET['country_wise_project1']) && $_GET['country_wise_project1']=='1') {
	$contentid  = $_POST['contentid'];
	$stateArray = $db->getUniversalRowAll($table_name='india'," and `parent_id` ='".$contentid."' ");
	if(!empty($stateArray)){?>
		<?php foreach($stateArray as $key => $state){ ?>
			<option data-id="<?php echo $state['id']; ?>" value="<?php echo $state['id']; ?>-<?php echo $state['parent_id'];?>"><?php echo $state['name']; ?></option>
		<?php } ?>			
	<?php } ?>
<?php } ?>

<?php 
//Request from signup.php file
if(isset($_GET['country_wise_project']) && $_GET['country_wise_project']=='1') {
	$contentid      = $_POST['contentid'];
	$contentidtext  = $_POST['contentidtext'];
	if(strtolower($contentidtext) == 'country'){
		$contentdataid = 'statedata';
	}else if(strtolower($contentidtext) == 'state'){
		$contentdataid = 'districtdata';
	}else if(strtolower($contentidtext) == 'district'){
		$contentdataid = 'tehsildata';
	}else if(strtolower($contentidtext) == 'tehsil'){
		$contentdataid = 'villagedata';
	}else{
		$contentdataid = 'nonedata';
	}
	$contentArray = $projectObj->getUniversalContentData($table_name='india'," and `parent_id` IN (".$contentid.") and `is_active`='1' ");
	if(!empty($contentArray)){?>
		<div class="leftcontentpro">
			<?php echo ucwords($contentidtext);?>
		</div>
		<div class="rightcontentpro" id="<?php echo strtolower($contentidtext);?>data">
			<?php foreach($contentArray as $parentidkey => $contentArrayAll){ ?>
				<h4 disabled="true" class="header"><?php echo $projectObj->getParentName($table_name='india',$parentidkey);?></h4>
				<?php foreach($contentArrayAll as $idkey => $content){ ?>				
					<p><input name="<?php echo strtolower($contentidtext);?>[]" onchange="javascript:if (typeof functionAddLocationUniversal == 'function') {functionAddLocationUniversal('<?php echo strtolower($contentidtext);?>','<?php echo strtolower($contentdataid);?>');}" id="<?php echo strtolower($contentidtext);?>_<?php echo $content['id']; ?>" type="checkbox" value="<?php echo $content['id']; ?>-<?php echo $parentidkey;?>"><span class="pL10"><?php echo ucwords($content['name']); ?></span></p>
				<?php } ?>		
			<?php } ?>			
		</div>
	<?php } ?>
<?php } ?>

<?php 
//Request from signup.php file
if(isset($_GET['selected_content_wise']) && $_GET['selected_content_wise']=='1' && isset($_POST['contentid'])){	
	//$arraycurrent       = explode(',',$_POST['contentid']);
	//$previousContentid  = explode(',',$_POST['previousContentid']);
	//$latestid           = end($arraycurrent);	

	$contentid       = $_POST['contentid'];
	$dataid          = $_POST['dataid'];
	$selectboxid   = $_POST['selectboxid'];

	if(strtolower($selectboxid) == 'country'){
		$contentidtext = 'state';
		$contentdataid = 'districtdata';
	}else if(strtolower($selectboxid) == 'state'){
		$contentidtext = 'district';
		$contentdataid = 'tehsildata';
	}else if(strtolower($selectboxid) == 'district'){
		$contentidtext = 'tehsil';
		$contentdataid = 'villagedata';
	}else if(strtolower($selectboxid) == 'village'){
		$contentidtext = 'village';
		$contentdataid = 'nonedata';
	}else{
		$contentidtext = 'village';
		$contentdataid = 'nonedata';
	}

	$contentArray       = $projectObj->getUniversalContentData($table_name='india'," and `parent_id` IN (".$_POST['contentid'].") and `is_active`='1' ");
	if(!empty($contentArray)){?>
		<?php foreach($contentArray as $parentidkey => $contentArrayAll){ ?>
			<h4 disabled="true" class="header"><?php echo $projectObj->getParentName($table_name='india',$parentidkey);?></h4>
			<?php foreach($contentArrayAll as $idkey => $content){ ?>				
				<p><input name="<?php echo strtolower($contentidtext);?>[]" onchange="javascript:if (typeof functionAddLocationUniversal == 'function') {functionAddLocationUniversal('<?php echo strtolower($contentidtext);?>','<?php echo strtolower($contentdataid);?>');}" id="<?php echo strtolower($contentidtext);?>_<?php echo $content['id']; ?>" type="checkbox" value="<?php echo $content['id']; ?>-<?php echo $parentidkey;?>"><span class="pL10"><?php echo ucwords($content['name']); ?></span></p>
			<?php } ?>		
		<?php } ?>			
	<?php } ?>
<?php } ?>

<?php 
//Request from signup.php file
if(isset($_GET['project_village_country_wise']) && $_GET['project_village_country_wise']=='1' && isset($_GET['type'])) {

	$contentid = $_POST['contentid'];
	
	if($_GET['type'] == 's'){
		$heading   = 'Select State';
		$firstvar  = 'state';
		$secondvar = 'district';
		$thirdvar  = 'd';
	}else if($_GET['type'] == 'd'){
		$heading   = 'Select District';
		$firstvar  = 'district';
		$secondvar = 'tahsil';
		$thirdvar  = 't';
	}else if($_GET['type'] == 't'){
		$heading = 'Select Tahsil';
		$firstvar  = 'tahsil';
		$secondvar = 'village';
		$thirdvar  = 'v';
	}else if($_GET['type'] == 'v'){
		$heading = 'Select Village';
		$firstvar  = 'village';
		$secondvar = 'none';
		$thirdvar  = 'none';
	}

	$contentArray = $projectObj->getProjectLocationReport(IS_PROJECT_ID, $_GET['type'], $contentid);
	$size         = (!empty($contentArray))?count($contentArray)+2:'3';
	
	if(!empty($contentArray)){?>	    
		
		<td class="lft-td">
			<?php if(isset($heading)){echo $heading;} ?>
		</td>
		<td class="rht-td">
		    <?php if($_GET['type'] == 'v'){?>
			<select multiple size="<?php echo $size;?>" onchange="javascript:if (typeof functionVillageProjectLocationUniversal == 'function') {functionVillageProjectLocationUniversal('<?php echo $firstvar;?>','<?php echo $secondvar;?>','<?php echo $thirdvar;?>');}" class="wdthpercent77 required villageall" id="<?php echo $firstvar;?>" name="<?php echo $firstvar;?>[]">
			<?php } else { ?>
			<select onchange="javascript:if (typeof functionVillageProjectLocationUniversal == 'function') {functionVillageProjectLocationUniversal('<?php echo $firstvar;?>','<?php echo $secondvar;?>','<?php echo $thirdvar;?>');}" class="wdthpercent77 required" id="<?php echo $firstvar;?>" name="<?php echo $firstvar;?>">
			<option value=""><?php if(isset($heading)){echo $heading;} ?></option>	
			<?php } ?>				
				<?php foreach($contentArray as $key => $content){ ?>
					<option value="<?php echo $content['ind_id']; ?>"><?php echo $content['name']; ?></option>
				<?php } ?>	
			</select>


			<?php if($_GET['type'] == 'd'){?>

			<input onclick="javascript: functionsetunsetrequried('alldistrictreport','district');" type="checkbox" id="alldistrictreport" name="alldistrictreport" value="1">&nbsp;All

			<?php } ?>

			<?php if($_GET['type'] == 't'){?>

			<input type="checkbox" onclick="javascript: functionsetunsetrequried('alltahsilreport','tahsil');" id="alltahsilreport" name="alltahsilreport" value="1">&nbsp;All

			<?php } ?>

			<?php if($_GET['type'] == 'v'){?>
			
			<input type="checkbox" onclick="javascript: functionsetunsetrequried('allvillagereport','village');" id="allvillagereport" name="allvillagereport" value="1">&nbsp;All
			<span id="hideselectallvillagediv">
				<br />
				<em class="red font12">press control to select multiple</em>
				<input type="checkbox" id="checkallVillage">&nbsp;All
				<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery("#checkallVillage").click(function(){
						var checkedd =  this.checked ? true : false;
						if(checkedd){
							jQuery(".villageall option").prop('selected', true);
						}else{
							jQuery(".villageall option").removeAttr("selected");
						}
					});
					jQuery(".villageall").click(function(){							
						jQuery("#checkallVillage").removeAttr("checked");
					});
				});
			    </script>				
		    </span>

			<?php } ?>	
		</td>		
				
	<?php } ?>
<?php } ?>

<?php 
//Request from signup.php file
if(isset($_GET['project_farmer_country_wise']) && $_GET['project_farmer_country_wise']=='1' && isset($_GET['type'])) {

	$contentid = $_POST['contentid'];
	
	if($_GET['type'] == 's'){
		$heading   = 'Select State';
		$firstvar  = 'state';
		$secondvar = 'district';
		$thirdvar  = 'd';
	}else if($_GET['type'] == 'd'){
		$heading   = 'Select District';
		$firstvar  = 'district';
		$secondvar = 'tahsil';
		$thirdvar  = 't';
	}else if($_GET['type'] == 't'){
		$heading = 'Select Tahsil';
		$firstvar  = 'tahsil';
		$secondvar = 'village';
		$thirdvar  = 'v';
	}else if($_GET['type'] == 'v'){
		$heading = 'Select Village';
		$firstvar  = 'village';
		$secondvar = 'none';
		$thirdvar  = 'none';
	}

	$contentArray = $projectObj->getProjectLocationReport(IS_PROJECT_ID, $_GET['type'], $contentid);
	$size         = (!empty($contentArray))?count($contentArray)+2:'3';
	
	if(!empty($contentArray)){?>
	
		<?php if(isset($_POST['returntype']) && $_POST['returntype']=='checkbox'){
			$contentArray_all  = array_chunk($contentArray,2);
		    ?>
			<td class="lft-td"><?php if(isset($heading)){echo $heading;} ?></td>
			<td class="rht-td">
				<table class="villlage-data">
					<?php foreach($contentArray_all as $key => $groupsAll){ ?>
						<tr>					
							<?php foreach($groupsAll as $key => $groups){
								if($groups['name']!='Other'){?>							
									<td>
										<input title="<?php echo $groups['name'];?>" type="checkbox" name="village[]" onclick="javascript: functionUserGroupMobileFarmerWise('<?php echo $groups['id'];?>','<?php echo $groups['name'];?>','<?php echo $_POST['gender'];?>');" id="user_sub_group_select_<?php echo $groups['id'];?>" value="<?php echo $groups['id'];?>" />&nbsp;&nbsp;<?php if(strlen($groups['name']) > 25){echo substr($groups['name'],0,25).'...';} else { echo $groups['name'];}?>
									</td>	
								<?php } ?>
							<?php } ?>
						</tr>
					<?php } ?>				
				</table>
			</td>
	     <?php } else { ?>
		
			<td class="lft-td">
				<?php if(isset($heading)){echo $heading;} ?>
			</td>
			<td class="rht-td">
				<?php if($_GET['type'] == 'v'){?>
				<select multiple size="<?php echo $size;?>" onchange="javascript:if (typeof functionFarmerProjectLocationUniversal == 'function') {functionFarmerProjectLocationUniversal('<?php echo $firstvar;?>','<?php echo $secondvar;?>','<?php echo $thirdvar;?>');}" class="wdthpercent77 required" id="<?php echo $firstvar;?>" name="<?php echo $firstvar;?>[]">
				<?php } else { ?>
				<select onchange="javascript:if (typeof functionFarmerProjectLocationUniversal == 'function') {functionFarmerProjectLocationUniversal('<?php echo $firstvar;?>','<?php echo $secondvar;?>','<?php echo $thirdvar;?>');}" class="wdthpercent77 required" id="<?php echo $firstvar;?>" name="<?php echo $firstvar;?>">
					<option value=""><?php if(isset($heading)){echo $heading;} ?></option>	
					<?php } ?>				
						<?php foreach($contentArray as $key => $content){ ?>
							<option value="<?php echo $content['ind_id']; ?>"><?php echo $content['name']; ?></option>
						<?php } ?>	
				</select>
			</td>	

		<?php } ?>
				
	<?php } ?>

<?php } ?>