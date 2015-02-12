<?php
/******************************************
* @Modified on JAN 26, 2014
* @Package: Kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);

$groupArray  = $langObj->functionGetSetting($tablename='group_settings', $dmlType='');

if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){
	$status_id			 = $_GET['id'];
	$messagestatusDetail = $langObj->functionGetSetting($tablename='message_status_settings', $dmlType='1', $status_id);
	$message_status_name = stripslashes($messagestatusDetail['message_status_name']);
	$logo                = stripslashes($messagestatusDetail['logo']);
	$is_active           = trim($messagestatusDetail['is_active']);
	$visibilty           = trim($messagestatusDetail['visibilty']);
}

if(isset($_POST['submitStatusMsgforms'])){	
	$result  = $langObj->functionAddMessageStatus($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
	} else {
		$_SESSION['msgerror']   = "8";
	}
	header("location:addStatusMsg.php");
	exit;	
}

if(isset($_POST['updateStatusMsgforms'])){	
	$result  = $langObj->functionEditMessageStatus($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
	} else {
		$_SESSION['msgerror']   = "8";
	}
	header("location:addStatusMsg.php?id=".$_POST['id']."&action=edit");
	exit;	
}
?>
<!-- containerCenter -->
<section class="containerCenter">

	<div class="containercentercnt">

		<h2 class="heading"><?php echo $langVariables['form_var']['message_status_heading']?></h2>
		<div class="clear pB10"></div>

		<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?>
			<form action="" method="post" id="editStatusMsgformsforms" name="editStatusMsgformsforms" enctype="multipart/form-data">
		<?php } else {?>
			<form action="" method="post" id="addStatusMsgformsforms" name="addStatusMsgformsforms" enctype="multipart/form-data">
		<?php }?>

			<div class="wdthpercent100 register">
				
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['form_var']['message_status_name'];?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['form_var']['message_status_name'];?>" type="text" id="message_status_name" name="message_status_name" class="wdthpercent40 required" value="<?php if(isset($message_status_name)){ echo $message_status_name;} ?>" />
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['category_var']['msg_status_logo']?></div>
					<div class="wdthpercent80 left">
					   <input type="file" id="logo" name="logo" class="wdthpercent40 required"/>
					   <?php if(!empty($logo)){ ?>
					      <div class="clear"></div>
						  <span class="statusimg left">
							  <img class="logo" title="<?php echo $logo;?>" alt="<?php echo $logo;?>" <?php if(!empty($logo)){ ?> src="/uploads/general/<?php echo $logo;?>" <?php } ?> />
						  </span>
						<?php } ?>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['general_var']['logo_visible']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="visibilty" type="text" id="visibilty" name="visibilty" class="wdthpercent40 required" value="<?php if(isset($visibilty)){ echo $visibilty;} ?>" />
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['form_var']['message_status']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['form_var']['message_status']?>" type="text" id="is_active" name="is_active" class="wdthpercent40 required" value="<?php if(isset($is_active)){ echo $is_active;} ?>" />
					</div>
			    </div>
			    <div class="clear"></div>	

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left">&nbsp;</div>
					<div class="wdthpercent80 left">
						<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?>
							<span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="updateStatusMsgforms"></span>
							<span class="pL40">
								<input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
								<input type="hidden" name="id" value="<?php if(isset($status_id)){ echo $status_id;} ?>">
								<input type="hidden" name="logo" value="<?php if(isset($logo)){ echo $logo;} ?>"/>
							</span>
						<?php } else {?>
							<span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submitStatusMsgforms"></span>
							<span class="pL40">
								<input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
							</span>
						<?php }?>
					    					  
					</div>
			    </div>
			    <div class="clear"></div>
			
			</div> 

		</form>	

	</div>

</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>