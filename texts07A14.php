<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

checkSession(false,2);

$page_title    = 'Text Messages';
$filter_data   = array();
$status        = 0;
$tablenamelang = 'language';
$tablenamemsg  = 'message';
$user_privacy_settings_sql = $user_content_condition = $categoryCondition = '';
$day = $month = '';
$year = '2014';
$commenting_status = 0;

$languageArray = $langObj->functionGetSetting($tablenamelang, $dmlType='');
if(isset($_SESSION['session_user_data']['id'])){
	$languageArray			= array();
	$commenting_status		= 1;
	$session_user_id		= $_SESSION['session_user_data']['id'];
	$user_content_condition = " and `user_id` = '".$session_user_id."' ";

	//-- MESSAGING DISPLAYING SECTION ---------------------------
	if(!is_numeric($_SESSION['session_user_data']['user_type'])){
		//ACCORDING TO CONTENT SETTING
		$user_type_var = explode('-', $_SESSION['session_user_data']['user_type']);
		if(!empty($user_type_var[1]))
		$projectData   = $langObj->functionGetSetting($tablename='projects', $dmlType='1', $id=$user_type_var[1]);
		if(!empty($projectData))
		$userStr = implode(',',explode(';', $projectData['assigned_users']));
		$user_privacy_settings_sql = " and `user_id` IN (".$userStr.") ";
	} else {	
		//ACCORDING TO CONTENT SETTING
		$user_privacy_settings_sql = $adminObj->getcontentSettingSqlArray($table_name='user_privacy_settings',$coloum_name_str='*',$updated_on_field='user_id',$updated_on_value=$session_user_id,$otherfields=null , $returnType='sql');
	}
	//-- MESSAGING DISPLAYING SECTION ---------------------------

	//-- FILTER DISPLAYING SECTION ------------------------------
	$user_privacy_settings_Language_Filter = $adminObj->getcontentSettingSqlArray($table_name='user_privacy_settings',$coloum_name_str='*',$updated_on_field='user_id',$updated_on_value=$session_user_id,$otherfields=null , $returnType='');
	$languageArray = $adminObj->functionContenPrivacySetting($tablenamelang, $user_privacy_settings_Language_Filter,$contentType='languages');
	//-- MESSAGING DISPLAYING SECTION ---------------------------
}
if(isset($_POST['message_type']) || isset($_POST['language_type']) || isset($_POST['status'])){
	$filter_data  = $_SESSION['filter_data'] = $_POST;
} else if(isset($_SESSION['filter_data'])){
	$filter_data  = $_SESSION['filter_data'];
} else {
	$filter_data  = array('message_type' => 'all','language_type' => 'all','status' => 'all');	
}
if(isset($_SESSION['parent_subcategory'])){
	$categoryArray     = explode('-',$_SESSION['parent_subcategory']);
	$categoryCondition = " and ( `parent_category`= '".$categoryArray[0]."' and `sub_category`= '".$categoryArray[1]."' ) ";
}
extract($filter_data);
$totalmessageDataArray = $adminObj->selectUserMessageAndriodPagination($tablenamemsg, $message_type, $language_type, $day,$month,$year,$status='all', $user_privacy_settings_sql, $startlimit='0', $endlimit='',$othercondition=" `status`= '0' ".$categoryCondition." ".$user_content_condition." ", $groupby='');
$totalMsg   = count($totalmessageDataArray);
$startLimit = '';
$endLimit   = '';
$messageData = $adminObj->selectUserMessageAndriodPagination($tablenamemsg, $message_type, $language_type,$day,$month,$year, $status='all', $user_privacy_settings_sql, $startLimit, $endLimit,$othercondition="`status`= '0' ".$categoryCondition." ".$user_content_condition." ", $groupby='');
$total_count = count($messageData);
//echo '<pre>';print_r($userDetail);echo '</pre>';
?>

<div class="container">

	<!-- TITLE HEADING -->
	<?php require_once($DOC_ROOT.'include/title_heading.php');?>	
	<!-- /TITLE HEADING -->

	<!-- FILTER TAB -->
	<?php require_once($DOC_ROOT.'include/filter_tab.php');?>	
	<!-- /FILTER TAB -->
	
	<div id="paginationcontent" class="entry">

		<div id="content_loder_empty" class="cLoader pT30 pB30 txtcenter"><h1>Loading....</h1></div>
		
		<!-- content -->
		<?php if(empty($messageData)){?>
			<div class="msgdiscriptiontxt">
				<div class="photomsgshow">No Message Posted.</div>					
			</div>
		<?php } else { 
			foreach($messageData as $uniquekey=> $message) { 

				$action_div_type = $file_type = $mediatext =  $mediacenter = $organicLogo = $logowidthL = $logowidthR = $file_url = $file = $edit_setter_var = "";
				$unique_div_id        = $uniquekey;
				$contentTypeIdArray   = explode('_',$uniquekey);
				$content_type         = $contentTypeIdArray[0];
				$content_id			  = $contentTypeIdArray[1];
				$message_user_id      = $message['user_id'];
				$message_status_type  = $message['status_type'];
				$message_content_type = $message['content_type'];
				$userDetail = $db->getUniversalRow($table_name='users',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$message['user_id'],$otherfields=null);
				if(!empty($userDetail['firstname']) && !empty($userDetail['lastname'])){ 
					$fullname = $userDetail['firstname'].' '.$userDetail['lastname']; 
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
				if(!empty($message['broadcast_date']) && $message['broadcast_date']!='0000-00-00'){
					//$message_data_static = 'has posted a message and broadcasted.';
					$broad_cast_date     = date('d M Y',strtotime($message['broadcast_date']));
				} else {
					//$message_data_static = 'has posted a message and waiting for broadcast.';
					$broad_cast_date     = date('d M Y',strtotime($message['date']));
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
				?>
				<div class="msgdiscriptiontxt">
					<div class="msgmain fullcontent">
						<div class="msgmain1">
							<div class="msgmain1L">
								<a href="<?php echo URL_SITE; ?>/profile.php?id=<?php echo $userDetail['id'];?>"><?php echo $fullname;?> </a> 
								<?php if(!empty($message_data_static)){ echo $message_data_static; } ?>
								<span class="right pR10"><?php if(!empty($broad_cast_date)) { echo $broad_cast_date; } ?></span>
							</div>
							<br class="clear">
						</div>

						<!--Photo Gallery-->
						<div class="photomsgshow<?php if(isset($mediacenter)){echo ' '.$mediacenter;}?>">
							
							<?php if(isset($file_type) && $file_type=='photo'){?>
								<?php if(isset($file_url) && $file_url!=''){?>
								<!-- MEDIA DIV -->
								<div class="timeline pB10">									
									<img class="media" title="<?php echo $file;?>" alt="<?php echo $file;?>" src="<?php echo $file_url;?>" />						
								</div>								
								<!-- /MEDIA DIV -->
								<?php } ?>
							<?php } ?>

							<?php if(isset($file_type) && $file_type=='audio') {?>
								<?php if(isset($file_url) && $file_url!=''){?>
								<!-- MEDIA DIV -->
								<audio controls="controls">
								  <source src="<?php echo URL_SITE;?><?php echo $file_url;?>" type="<?php echo $file_type;?>/<?php echo $action_div_type;?>">					  
								  Your browser doesn't support <?php echo $file_type;?>
								</audio>				
								<!-- /MEDIA DIV -->
								<?php } ?>
							<?php } ?>

							<?php if(isset($file_type) && $file_type=='video') {?>
								<?php if(isset($file_url) && $file_url!=''){?>
								<!-- MEDIA DIV -->
								<video width="320" height="240" controls="controls">
								  <source src="<?php echo URL_SITE;?><?php echo $file_url;?>" type="<?php echo $file_type;?>/<?php echo $action_div_type;?>">					  
								  Your browser doesn't support <?php echo $file_type;?>
								</video>				
								<!-- /MEDIA DIV -->
								<?php } ?>
							<?php } ?>

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
									<div id="full_message_discription<?php echo $unique_div_id;?>" style="display:none;" class=""></div>
									<div id="half_message_discription<?php echo $unique_div_id;?>"class="msgshowing">
										<?php if(!empty($message)){?>
											<?php if(strlen($message['message']) > 500){?>
												<?php  echo stripslashes(substr($message['message'],0,500)).'...';?> <br/>
												<a onclick="javascript: view_all('<?php echo $tablenamemsg;?>','<?php echo $message['id'];?>','<?php echo $unique_div_id;?>');" class="blue" href="javascript:;">View More..<span class="pL30" id="loader<?php echo $unique_div_id;?>"></span></a>
											<?php } else { ?>
											   <?php  echo stripslashes($message['message']);?>
											<?php } ?>
										<?php } ?>
									</div>
								</div>
								<!--/Left-->
								<br class="clear">
							</div>							

							<!-- LIKE DISLIKE DIV -->
							<div id="likes_div_<?php echo $unique_div_id;?>" class="msgresultbuttonleft">
								<ul>
									<?php if(isset($session_user_id) && isset($edit_setter_var) && $edit_setter_var=='1'){?>
										
										<li>
											<a href="javascript:;">Edit</a>
										</li>
										<li>|</li>
										<li>
											<a href="javascript:;">Trash</a>
										</li>

									<?php } else { ?>
										<li>
											<?php if(isset($session_user_id)){
												  $likeDetail = $msgObj->liked_detail($session_user_id , $content_id, $content_type);
												  $display_like = $display_unlike = 'style="display:none;"';
												  if(empty($likeDetail)){
													  $display_like = 'style="display:block;"';
												  } else if(!empty($likeDetail) && $likeDetail['status']=='0'){
													  $display_like = 'style="display:block;"';
												  } else if(!empty($likeDetail) && $likeDetail['status']=='1'){
													  $display_unlike = 'style="display:block;"';
												  }
												  ?>											 
												  <a <?php if(isset($display_like))echo $display_like;?> id="like_<?php echo $unique_div_id;?>" href="javascript:;" <?php if(isset($session_user_id)){?>onclick="javascript: functionLikeContentComment('<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','1','<?php if(isset($session_user_id)){ echo $session_user_id;} else { echo '0';}?>');"<?php }?>>Thanks</a>						  
												  <a <?php if(isset($display_unlike))echo $display_unlike;?> id="unlike_<?php echo $unique_div_id;?>" href="javascript:;" <?php if(isset($session_user_id)){?>onclick="javascript: functionLikeContentComment('<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','0','<?php if(isset($session_user_id)){ echo $session_user_id;} else { echo '0';}?>');"<?php }?>>Undo</a>				
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
											<a id="comment_open_<?php echo $unique_div_id;?>" href="javascript:;">Answer</a>
										</li>	
										<li>
											<a id="like_loader_<?php echo $unique_div_id;?>"  href="javascript:;"></a>
										</li>
									<?php } ?>
								</ul>
							</div>
							<!-- LIKE DISLIKE DIV -->

							<?php if(isset($edit_setter_var) && $edit_setter_var!='1'){?>				
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
						<?php require($DOC_ROOT.'showtextComment.php');?>	
						<!-- /SHOW TEXT COMMENT -->	
							
						</div>
						<br class="clear">		
				</div>
			<?php } ?>
		<?php } ?>
		<!-- /content -->

	</div>

	<?php if(isset($totalMsg) && $totalMsg > 10){?>
		<!------- BANNER-START ----------->
		<?php //require_once($DOC_ROOT.'ajax-pagination.php');?>
		<!------- BANNER-END ------------->	
	<?php } ?>

</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>