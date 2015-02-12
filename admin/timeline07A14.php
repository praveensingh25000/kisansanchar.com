<?php
/******************************************
* @Modified on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);

$page_title    = '<span class="heading">Timeline</span>';
$filter_data   = array();
$status        = 0;
$tablenamelang = 'language';
$tablenamemsg  = 'message';
$user_privacy_settings_sql = '';
$day = $month = '';
$year = '2014';
$commenting_status = 0;

$languageArray = $langObj->functionGetSetting($tablenamelang, $dmlType='');
if(isset($_SESSION['admin_session']['id'])){
	$session_user_id   = $_SESSION['admin_session']['id'];
	$commenting_status = 1;
	if(!is_numeric($_SESSION['admin_session']['user_type'])){
		//ACCORDING TO CONTENT SETTING
		$user_type_var = explode('-', $_SESSION['admin_session']['user_type']);
		if(!empty($user_type_var[1]))
		$projectData   = $langObj->functionGetSetting($tablename='projects', $dmlType='1', $id=$user_type_var[1]);
		if(!empty($projectData))
		$userStr = implode(',',explode(';', $projectData['assigned_users']));
		$user_privacy_settings_sql = " and `user_id` IN (".$userStr.") ";
	}
}
if(isset($_POST['message_type']) || isset($_POST['language_type']) || isset($_POST['status'])){
	$filter_data  = $_SESSION['filter_data'] = $_POST;
} else if(isset($_SESSION['filter_data'])){
	$filter_data  = $_SESSION['filter_data'];
} else {
	$filter_data  = array('message_type' => 'all','language_type' => 'all','status' => 'all');	
}
extract($filter_data);
$totalmessageDataArray = $adminObj->selectActiveMessageAndriodPaginationAdmin($tablenamemsg, $message_type, $language_type, $day,$month,$year,$status='all', $user_privacy_settings_sql, $startlimit='0', $endlimit='12000',$othercondition="");
$totalMsg   = count($totalmessageDataArray);
$startLimit = '0';
$endLimit   = '10';
$messageData = $adminObj->selectActiveMessageAndriodPaginationAdmin($tablenamemsg, $message_type, $language_type,$day,$month,$year, $status='all', $user_privacy_settings_sql, $startLimit, $endLimit,$othercondition="");
$total_count = count($messageData);
//echo '<pre>';print_r($userDetail);echo '</pre>';
?>
<!-- containerCenter -->
<section class="containerCenter">

	<div class="containercentercnt">
	
		<!-- TITLE HEADING -->
		<?php require_once($DOC_ROOT.'include/title_heading.php');?>	
		<!-- /TITLE HEADING -->

		<!-- FILTER TAB -->
		<?php require_once($DOC_ROOT.'include/filter_tab.php');?>	
		<!-- /FILTER TAB -->
		
		<div id="paginationcontent" class="entry">
			
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
								
								<?php if(isset($file_type) && $file_type=='photos'){?>
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

								<!-- BROADCAST UNBROADCAST DIV -->
								<div id="likes_div_<?php echo $unique_div_id;?>" class="msgresultbuttonleft">
									<ul>								
										<?php										
										if(isset($message['status']) && $message['status']=='0') {?>
										<li id="aprrove_dissaprove_div_<?php echo $unique_div_id;?>">
											<a onclick="javascript:functionApproveDisaprove('<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','1','Do you really want to approve this message');" id="aprove_div_<?php echo $unique_div_id;?>" href="javascript:;">Visible</a>
										</li>
										<?php } ?>
										<?php if(isset($message['status']) && $message['status']=='1') {?>
										<li id="aprrove_dissaprove_div_<?php echo $unique_div_id;?>">
											<a onclick="javascript:functionApproveDisaprove('<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','0','Do you really want to disapprove this message');" id="dissaprove_div_<?php echo $unique_div_id;?>" href="javascript:;">Unvisible</a>
										</li>
										<?php } ?>
										<li>|</li>
										<li>
											<a id="msg_unbroadcast_delete_<?php echo $unique_div_id;?>" href="javascript:;" onclick="javascript:functionDeleteMsgContent('<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>')">Trash</a>
										</li>
										<li>
											<a id="broadcast_unbroadcast_loader_<?php echo $unique_div_id;?>"  href="javascript:;"></a>
										</li>
									</ul>
								</div>
								<!-- /BROADCAST UNBROADCAST DIV -->
							</div>

							<!--/Photo Gallery-->
							<br class="clear">
						</div>

						<br class="clear">		
					</div>
				<?php } ?>

			<?php } ?>
			<!-- /content -->

		</div>

		<?php if(isset($totalMsg) && $totalMsg > 10){?>
			<!------- BANNER-START ----------->
			<?php require_once($DOC_ROOT.'ajax-pagination.php');?>
			<!------- BANNER-END ------------->	
		<?php } ?>

	</div>

</section>

<?php include_once $basedir."/include/adminFooter.php"; ?>