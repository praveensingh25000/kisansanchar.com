<?php
/******************************************
* @Created on JUNE 20, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/actionHeader.php";

if(isset($_GET['LANG'])){
	$_SESSION['LANG'] = $_GET['LANG'];
	return true;
}

if(isset($_GET['search']) && isset($_POST['searchkeyword']) && isset($_POST['searchtype']) && $_POST['searchtype']=='message'){
	if(isset($_SESSION['searchData'])){unset($_SESSION['searchData']);}
	$searchkeyword = trim($_POST['searchkeyword']);
	$searchtype    = trim($_POST['searchtype']);
	$language_type = trim($_POST['language_type']);
	$startLimit    = 0;
	$endLimit      = 10;
	$searchData    = $searchObj->searchResult($searchtype,$searchkeyword, $startLimit, $endLimit, $language_type);
	$totalcount    = count($searchData);
	if(!empty($searchData)){?>
		<div id="search_result_display_append">		
			<?php foreach($searchData as $key1 => $search){
				$unique_div_id        = $key1;
				$msgArray = explode(' ',$search['message']);
				if(isset($msgArray)&& count($msgArray)>150){
					$msgArrayShort = array_slice($msgArray,0,150);
					$msgStr        = implode(' ',$msgArrayShort);
					$stackLimiter  = 1;
				}else{
					$msgStr = implode(' ',$msgArray);
				}
				$added_on_date     = date('d M Y',strtotime($search['date']));
				$broad_cast_date   = date('d M Y',strtotime($search['broadcast_date']));

				$message_tag = (isset($search['message_tag']))?$search['message_tag']:'--';

				if(!empty($search['content_type']) && $search['content_type']!='' && !empty($search['message_file'])){

					$mediacenter     = "txtcenter";					
					$mediatext       = "mediatext";	
					$action_div_type = $search['content_type'];
					$message_file    = $search['message_file'];

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
				if(!empty($search['content_type']) && $search['content_type']!='' && !empty($message['message_url'])){

					$mediacenter     = "txtcenter";					
					$mediatext       = "mediatext";	
					$action_div_type = $search['content_type'];
					$message_url     = $message['message_url'];

					if($action_div_type == 'embeddedUrl'){
						$file      = '';
						$file_url  = $message_url;
						$file_type = "embeddedUrl";
					}
				}
				?>
				<div class="fullcontent">				
					<div class="wdthpercent100 left">
						<a href="<?php echo $search['msg_id'];?>"><?php echo $userObj->getUserName($search);?></a>					
					</div>
					<div class="wdthpercent100 left">
						<div class="photomsgshow txtcenter">
							<!-- MESSAGE DISPLAY -->
							<?php require($DOC_ROOT.'media_display.php');?>	
							<!-- /MESSAGE DISPLAY -->
							<br class="clear" /><br class="clear" />
							<?php echo highlight_word($msgStr, $searchkeyword, $class='highlight');?>
						</div>
						<br class="clear" />
						<?php if(isset($message_tag) && $message_tag!='') {?>
							<span class="fontbld">Message Tag -</span><span class="pL5">
							<?php echo highlight_word($message_tag, $searchkeyword, $class='highlight');?></span>&nbsp;|&nbsp;
						<?php } ?>
						<?php if(isset($added_on_date) && $added_on_date!='') {?>
							<span class="fontbld">Added On -</span><span class="pL5"><?php echo $added_on_date;?></span>&nbsp;|&nbsp;
						<?php } ?>
						<?php if(isset($broad_cast_date) && $broad_cast_date!='') {?>
							<span class="fontbld">Broadcast On -</span><span class="pL5"><?php echo $broad_cast_date;?></span>&nbsp;|&nbsp;
						<?php } ?>
					</div>		
				</div>
				<br class="clear" /><br class="clear" />
			<?php } ?>

		</div>

		<?php if(isset($_SESSION['searchData']) && count($_SESSION['searchData'])>10){?>

		<div id="search_pagination_div" class="contentdiv fullcontent">
			<a id="load_more_message" href="javascript:;" onclick="javascript: return SearchPagination('<?php echo $searchtype ?>');">
				Load More Results&nbsp;<span class="id-load-total-display"></span>
				<input type="hidden" name="startLimit" id="startLimit" value="<?php echo $endLimit+1;?>">
				<input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo $searchkeyword;?>">
				<input type="hidden" name="endLimit" id="endLimit" value="<?php echo $endLimit;?>">
				<input type="hidden" name="totalMsg" id="totalMsg" value="<?php if(isset($_SESSION['searchData'])){echo count($_SESSION['searchData']);}?>">	
			</a>
		</div>

		<?php } ?>

	<?php } else { echo 'false'; } ?>
	
<?php } ?>

<?php if(isset($_POST['startLimit']) && isset($_POST['endLimit']) && isset($_POST['searchtype']) && $_POST['searchtype']=='message'){

	header("Content-type: text/html; charset=utf-8");

	$startLimit		= $_POST['startLimit'];
	$endLimit		= $_POST['startLimit'];
	$searchkeyword  = $_POST['searchkeyword'];

	if(!empty($_SESSION['searchData'])){
		$searchData = array_slice($_SESSION['searchData'], $startLimit,$endLimit,true);
		if(!empty($searchData)){
			foreach($searchData as $key1 => $search){
				$msgArray = explode(' ',$search['message']);
				if(isset($msgArray)&& count($msgArray)>150){
					$msgArrayShort = array_slice($msgArray,0,150);
					$msgStr        = implode(' ',$msgArrayShort);
					$stackLimiter  = 1;
				}else{
					$msgStr = implode(' ',$msgArray);
				}
				$added_on_date     = date('d M Y',strtotime($search['date']));
				$broad_cast_date   = date('d M Y',strtotime($search['broadcast_date']));

				$message_tag = (isset($search['message_tag']))?$search['message_tag']:'--';
				
				if(!empty($search['content_type']) && $search['content_type']!='' && !empty($search['message_file'])){

					$mediacenter     = "txtcenter";					
					$mediatext       = "mediatext";	
					$action_div_type = $search['content_type'];
					$message_file    = $search['message_file'];

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
				if(!empty($search['content_type']) && $search['content_type']!='' && !empty($message['message_url'])){
					$action_div_type = $search['content_type'];
					$message_url     = $message['message_url'];
					if($action_div_type == 'embeddedUrl'){
						$file      = '';
						$file_url  = $message_url;
						$file_type = "embeddedUrl";
					}
				}
				?>
				<div class="fullcontent">				
					<div class="wdthpercent100 left">
						<a href=""><?php echo $userObj->getUserName($search);?></a>					
					</div>
					<div class="wdthpercent100 left">
						<div class="photomsgshow txtcenter">
							<!-- MESSAGE DISPLAY -->
							<?php require($DOC_ROOT.'media_display.php');?>	
							<!-- /MESSAGE DISPLAY -->
							<br class="clear" /><br class="clear" />
							<?php echo highlight_word($msgStr, $searchkeyword, $class='highlight');?>
						</div>
						<br class="clear" />
						<?php if(isset($message_tag) && $message_tag!='') {?>
							<span class="fontbld">Message Tag -</span><span class="pL5">
							<?php echo highlight_word($message_tag, $searchkeyword, $class='highlight');?></span>&nbsp;|&nbsp;
						<?php } ?>
						<?php if(isset($added_on_date) && $added_on_date!='') {?>
							<span class="fontbld">Added On -</span><span class="pL5"><?php echo $added_on_date;?></span>&nbsp;|&nbsp;
						<?php } ?>
						<?php if(isset($broad_cast_date) && $broad_cast_date!='') {?>
							<span class="fontbld">Broadcast On -</span><span class="pL5"><?php echo $broad_cast_date;?></span>&nbsp;|&nbsp;
						<?php } ?>
					</div>		
				</div>
				<br class="clear" /><br class="clear" />

			<?php } ?>

		<?php } ?>

	<?php } ?>

<?php } ?>

<?php if(isset($_GET['search']) && isset($_POST['searchkeyword']) && isset($_POST['searchtype']) && $_POST['searchtype']=='users'){
	if(isset($_SESSION['searchData'])){unset($_SESSION['searchData']);}
	$searchkeyword = trim($_POST['searchkeyword']);
	$searchtype    = trim($_POST['searchtype']);
	$language_type = trim($_POST['language_type']);
	$startLimit    = 0;
	$endLimit      = 10;
	$searchData    = $searchObj->searchResult($searchtype,$searchkeyword, $startLimit, $endLimit, $language_type);
	$totalcount    = count($searchData);
	if(!empty($searchData)){?>
		<div id="search_result_display_append">		
			<?php foreach($searchData as $key1 => $search){
				
				$sname = $pfathername = $sfathername= '';

				$added_on_date = date('d M Y',strtotime($search['date']));	
				$sname.= (isset($search['sfirstname']))?ucwords($search['sfirstname']):'';
				$sname.= (isset($search['slastname']))?ucwords($search['slastname']):'';
				
				$pfathername = (isset($search['pfathername']))?ucwords($search['pfathername']):'';
				$sfathername = (isset($search['sfathername']))?ucwords($search['sfathername']):'';

				$phone = (isset($search['phone']))?$search['phone']:'';
				$user_type = (isset($search['user_type']))?$search['user_type']:'';

				$gender = (isset($search['gender']))?$search['gender']:'';
				if($gender=='M'){ $gendertype='Male'; }else{ $gendertype='Female';}
				?>
				<div class="fullcontent">				
					<div class="wdthpercent100 left">
						<div class="popupimg left">
							<?php if(!empty($search['image'])){?>
								<a href="javascript:;"><img src="<?php echo URL_SITE;?>/uploads/users/<?php echo $search['user_id'];?>/<?php echo $search['image'];?>" alt="<?php echo $userObj->getUserName($search);?>"></a>
							<?php } else { ?>
								<a href="javascript:;"><img src="<?php echo URL_SITE;?>/images/no-image.jpeg" alt="<?php echo $userObj->getUserName($search);?>"></a>
							<?php } ?>
						</div>
						<div class="left pL10">
							<a href="javascript:;"><?php echo $userObj->getUserName($search);?></a>
						</div>					
					</div>
					<div class="wdthpercent100 left pT10">
						<?php if(isset($user_type) && $user_type!='') {?>
							<span class="fontbld">User Type -</span><span class="pL5"><?php echo $user_type;?></span>&nbsp;|&nbsp;
						<?php } ?>
						<?php if(isset($sname) && $sname!='') {?>
							<span class="fontbld">Second Name -</span><span class="pL5"><?php echo $sname;?></span>&nbsp;|&nbsp;
						<?php } ?>
						<?php if(isset($gendertype) && $gendertype!='') {?>
							<span class="fontbld">Gender -</span><span class="pL5"><?php echo $gendertype;?></span>&nbsp;|&nbsp;
						<?php } ?>
						<?php if(isset($pfathername) && $pfathername!='') {?>
							<span class="fontbld">Father Name -</span><span class="pL5"><?php if(isset($pfathername) && $pfathername!='') {echo $pfathername;}else{echo $sfathername;}?></span>&nbsp;|&nbsp;
						<?php } ?>
						<?php if(isset($phone) && $phone!='') {?>
							<span class="fontbld">Phone Number -</span><span class="pL5"><?php echo $phone;?></span>&nbsp;|&nbsp;
						<?php } ?>
						<span class="fontbld">Added On -</span><span class=""><?php echo $added_on_date;?></span>				
					</div>				
				</div>
				<br class="clear" /><br class="clear" />
			<?php } ?>

		</div>

		<?php if(isset($_SESSION['searchData']) && count($_SESSION['searchData'])>10){?>

		<div id="search_pagination_div" class="contentdiv fullcontent">
			<a id="load_more_message" href="javascript:;" onclick="javascript: return SearchPagination('<?php echo $searchtype ?>');">
				Load More Results&nbsp;<span class="id-load-total-display"></span>
				<input type="hidden" name="startLimit" id="startLimit" value="<?php echo $endLimit+1;?>">
				<input type="hidden" name="endLimit" id="endLimit" value="<?php echo $endLimit;?>">
				<input type="hidden" name="totalMsg" id="totalMsg" value="<?php if(isset($_SESSION['searchData'])){echo count($_SESSION['searchData']);}?>">	
				<input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo $searchkeyword;?>">
			</a>
		</div>

		<?php } ?>

	<?php } else { echo 'false'; } ?>
	
<?php } ?>


<?php if(isset($_POST['startLimit']) && isset($_POST['endLimit']) && isset($_POST['searchtype']) && $_POST['searchtype']=='users'){

	header("Content-type: text/html; charset=utf-8");
	$startLimit		= $_POST['startLimit'];
	$endLimit		= $_POST['startLimit'];
	$searchkeyword  = $_POST['searchkeyword'];

	if(!empty($_SESSION['searchData'])){
		$searchData = array_slice($_SESSION['searchData'], $startLimit,$endLimit,true);
		if(!empty($searchData)){?>
			<?php foreach($searchData as $key1 => $search){

				$sname = $pfathername = $sfathername= '';

				$added_on_date = date('d M Y',strtotime($search['date']));	
				$sname.= (isset($search['sfirstname']))?ucwords($search['sfirstname']):'';
				$sname.= (isset($search['slastname']))?ucwords($search['slastname']):'';
				
				$pfathername = (isset($search['pfathername']))?ucwords($search['pfathername']):'';
				$sfathername = (isset($search['sfathername']))?ucwords($search['sfathername']):'';

				$phone = (isset($search['phone']))?$search['phone']:'';
				$user_type = (isset($search['user_type']))?$search['user_type']:'';

				$gender = (isset($search['gender']))?$search['gender']:'';
				if($gender=='M'){ $gendertype='Male'; }else{ $gendertype='Female';}
				?>
				<div class="fullcontent">				
					<div class="wdthpercent100 left">
						<div class="popupimg left">
							<?php if(!empty($search['image'])){?>
								<a href="javascript:;"><img src="<?php echo URL_SITE;?>/uploads/users/<?php echo $search['user_id'];?>/<?php echo $search['image'];?>" alt="<?php echo $userObj->getUserName($search);?>"></a>
							<?php } else { ?>
								<a href="javascript:;"><img src="<?php echo URL_SITE;?>/images/no-image.jpeg" alt="<?php echo $userObj->getUserName($search);?>"></a>
							<?php } ?>
						</div>
						<div class="left pL10">
							<a href="javascript:;"><?php echo $userObj->getUserName($search);?></a>
						</div>					
					</div>
					<div class="wdthpercent100 left pT10">
						<?php if(isset($user_type) && $user_type!='') {?>
							<span class="fontbld">User Type -</span><span class="pL5"><?php echo $user_type;?></span>&nbsp;|&nbsp;
						<?php } ?>
						<?php if(isset($sname) && $sname!='') {?>
							<span class="fontbld">Second Name -</span><span class="pL5"><?php echo $sname;?></span>&nbsp;|&nbsp;
						<?php } ?>
						<?php if(isset($gendertype) && $gendertype!='') {?>
							<span class="fontbld">Gender -</span><span class="pL5"><?php echo $gendertype;?></span>&nbsp;|&nbsp;
						<?php } ?>
						<?php if(isset($pfathername) && $pfathername!='') {?>
							<span class="fontbld">Father Name -</span><span class="pL5"><?php if(isset($pfathername) && $pfathername!='') {echo $pfathername;}else{echo $sfathername;}?></span>&nbsp;|&nbsp;
						<?php } ?>
						<?php if(isset($phone) && $phone!='') {?>
							<span class="fontbld">Phone Number -</span><span class="pL5"><?php echo $phone;?></span>&nbsp;|&nbsp;
						<?php } ?>
						<span class="fontbld">Added On -</span><span class=""><?php echo $added_on_date;?></span>				
					</div>				
				</div>
				<br class="clear" /><br class="clear" />
			<?php } ?>

		<?php } ?>

	<?php } ?>

<?php } ?>