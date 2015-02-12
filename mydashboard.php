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

$user_content_condition = $user_privacy_settings_sql = $categoryCondition = $messagetagsetCondition = '';

$page_title         = 'Timeline';
$page_link_title	= 'Write Message';
$page_link			= 'message.php'; 
$page_image			= 'message.png';

$filter_data		= array();
$tablenamelang		= 'language';
$tablenamemsg		= 'message';

$day				= '';
$month				= date('m');
$year				= date('Y');
$status             = 'all';

$orderBy            = "order by date DESC ";
$commenting_status  = 0;

$languageArray = $langObj->functionGetSetting($tablenamelang, $dmlType='');
if(isset($_SESSION['session_user_data']['id'])){
	$languageArray			   = array();
	$commenting_status		   = 1;
	$user_privacy_settings_sql.= " and `user_id` = '".$session_user_id."' ";
	
	//MESSAGING TO CONTENT SETTING
	$user_privacy_settings_sql.= $adminObj->getcontentSettingSqlArray($table_name='user_privacy_settings',$coloum_name_str='*',$updated_on_field='user_id',$updated_on_value=$front_user_id,$otherfields=null , $returnType='sql');
	//-- MESSAGING DISPLAYING SECTION ---------------------------

	//-- FILTER DISPLAYING SECTION ------------------------------
	$user_privacy_settings_Language_Filter = $adminObj->getcontentSettingSqlArray($table_name='user_privacy_settings',$coloum_name_str='*',$updated_on_field='user_id',$updated_on_value=$front_user_id,$otherfields=null , $returnType='');
	$languageArray = $adminObj->functionContenPrivacySetting($tablenamelang, $user_privacy_settings_Language_Filter,$contentType='languages');
	//-- FILTER DISPLAYING SECTION ---------------------------
}
if(isset($_POST['message_type']) || isset($_POST['language_type']) || isset($_POST['status'])){
	$filter_data  = $_SESSION['filter_data'] = $_POST;
	$LIMIT = '';
} else if(isset($_SESSION['filter_data'])){
	$filter_data  = $_SESSION['filter_data'];
	$LIMIT = '';
} else {
	$filter_data  = array('message_type' => 'all','language_type' => 'hi','status' => 'all');	
}
if(isset($_SESSION['parent_subcategory'])){
	$categoryArray     = explode('-',$_SESSION['parent_subcategory']);
	$categoryCondition = " and ( `parent_category`= '".$categoryArray[0]."' and `sub_category`= '".$categoryArray[1]."' ) ";
	$LIMIT = '';
}
extract($filter_data);
$startLimit    = '0';
$endLimit      = '10';
$messageData   = $msgObj->selectActiveMessageAndriodPaginationArrayFrontMyDashboard($tablenamemsg, $message_type, $language_type, $day, $month, $year, $status, $user_privacy_settings_sql, $startLimit, $endLimit , $othercondition="".$user_content_condition."".$categoryCondition."", $orderBy);
$totalMsg = count($messageData);
//echo '<pre>';print_r($messageData);echo '</pre>';
?>

<div class="container">

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

				$action_div_type = $file_type = $mediatext =  $mediacenter = $organicLogo = $logowidthL = $logowidthR = $file_url = $file = $edit_setter_var = $message_url = "";

				$message_id           = $message['id'];
				$unique_div_id        = $uniquekey;
				$contentTypeIdArray   = explode('_',$uniquekey);
				$content_type         = $contentTypeIdArray[0];
				$content_id			  = $contentTypeIdArray[1];
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
				if(isset($message['status']) && $message['status']=='1'){
					$broad_cast_date     = date('d M Y',strtotime($message['broadcast_date']));
				}
				if(isset($message['status']) && $message['status']=='0'){
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
						$main_file_url = DOC_ROOT."uploads/audios/".$file;
						if(!file_exists($main_file_url)){
							$file_url = "/uploads/temp/".$file;
						}
						$file_type = "audio";
					} else if($action_div_type == 'flv' || $action_div_type == 'FLV' || $action_div_type == 'mp4' || $action_div_type == 'MP4'){
						$file     = stripslashes($message_file);
						$file_url = "/uploads/videos/".$file;
						$file_type = "video";
					} else if($action_div_type == 'embeddedUrl'){
						$file      = stripslashes($message_file);
						$file_url  = $message_url;
						$file_type = "embeddedUrl";
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
								<?php if(!empty($message_data_static)){ echo $message_data_static; } ?>
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

	<?php if(isset($totalMsg) && $totalMsg > 9){?>
		<!------- PAGINATION-START ----------->
		<?php require_once($DOC_ROOT.'ajax-pagination.php');?>
		<!------- PAGINATION-END ------------->	
	<?php } ?>

</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>