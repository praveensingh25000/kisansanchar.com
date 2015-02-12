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

$userTypes = $db->getUniversalRowAll($table_name='user_types');
$groupArray  = $langObj->functionGetSetting($tablename='group_settings', $dmlType='');

if(isset($_POST['addaddadminstaff'])){	
	$result     = $adminObj->registration($_POST);		
	$_SESSION['msgsuccess'] = "7";
	header("location:viewsetting.php");
	exit;	
}
//gurtej------->
if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){
	$user_id    = $_GET['id'];
	$userDetail = $langObj->functionGetSetting($tablename='user_types', $dmlType='1', $user_id);
	$user_name  = stripslashes($userDetail['user_type']);
	$is_active    = trim($userDetail['is_active']);
}
if(isset($_POST['addaddadminstaff'])){	
	$result  = $langObj->functionUpdateStaff($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
	}
	header("location:addstaff.php?id=".$_POST['user_id']."&action=edit");
	exit;	
}


?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading"><?php echo $langVariables['heading_var']['addstaff']?></h2>
		<div class="clear pB10"></div>

		<form action="" method="post" id="addadminstaffform" name="addadminstaffform">
			<div class="register">				
				<div class="wdthpercent100 pT10 pB10">
					<input placeholder="<?php echo $langVariables['form_var']['firstname']?>" type="text" id="pfirstname" name="pfirstname" value="<?php if(isset($_SESSION['register_data']['firstname'])){ echo $_SESSION['register_data']['firstname']; }?>" class="wdthpercent50 inputbox required"/><br />
					<label style="display:none;" for="pfirstname" generated="true" class="error">* required.</label>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<input placeholder="<?php echo $langVariables['form_var']['lastname']?>" type="text" id="plastname" name="plastname" value="<?php if(isset($_SESSION['register_data']['lastname'])){ echo $_SESSION['register_data']['lastname']; }?>" class="wdthpercent50 inputbox required"/><br />
					<label style="display:none;" for="plastname" generated="true" class="error">* required.</label>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">				
					 <input placeholder="<?php echo $langVariables['form_var']['email']?>" type="text" id="email" name="email" value="<?php if(isset($_SESSION['register_data']['email'])){ echo $_SESSION['register_data']['email']; }?>" class="wdthpercent50 email inputbox"/><br />
					<label style="display:none;" for="email" generated="true" class="error">* required.</label>				
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">					
					<input placeholder="<?php echo $langVariables['form_var']['phone']?>" type="text" id="phone" name="phone" value="<?php if(isset($_SESSION['register_data']['phone'])){ echo $_SESSION['register_data']['phone']; }?>" class="wdthpercent50 digits inputbox required"/><br />
					<label style="display:none;" for="phone" generated="true" class="error">* required.</label>					
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<input placeholder="<?php echo $langVariables['form_var']['password']?>" type="password" name="password" class="wdthpercent50 inputbox required"/><br />
					<label style="display:none;" for="password" generated="true" class="error">* required.</label>					
			    </div>
			    <div class="clear"></div>				

				<div class="wdthpercent100 pT10 pB10">
				   <?php if(!empty($userTypes)) { ?>
						<select class="wdthpercent50 inputbox required" id="user_type" name="user_type">
							<option value=""><?php echo $langVariables['form_var']['select_user_type']?> </option>
							<?php foreach($userTypes as $userTypes) { ?>
								<option value="<?php echo $userTypes['id'];?>" <?php if(isset($_SESSION['register_data']['user_type']) && $_SESSION['register_data']['user_type'] == $userTypes['id']){ echo "selected='selected'"; } ?> ><?php echo ucwords($userTypes['user_type']);?></option>
							<?php } ?>							
						</select><br />
					    <label style="display:none;" for="user_type" generated="true" class="error">* required.</label>						
					<?php } ?>					
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">				  
					<select class="wdthpercent50 inputbox required" id="gender" name="gender">
						  <option value=""><?php echo $langVariables['form_var']['gender']?></option>	<option <?php if(isset($_SESSION['register_data']['gender']) && $_SESSION['register_data']['gender'] == 'M'){ echo "selected='selected'"; }?> value="M"><?php echo $langVariables['form_var']['male']?></option>
						  <option <?php if(isset($_SESSION['register_data']['gender']) && $_SESSION['register_data']['gender'] == 'F'){ echo "selected='selected'"; }?> value="F"><?php echo $langVariables['form_var']['female']?></option>
						  <option <?php if(isset($_SESSION['register_data']['gender']) && $_SESSION['register_data']['gender'] == 'O'){ echo "selected='selected'"; }?> value="O"><?php echo $langVariables['form_var']['other']?></option>
					</select><br />
					<label style="display:none;" for="gender" generated="true" class="error">* required.</label>										
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
				   <?php if(!empty($groupArray)) { ?>
						<select class="wdthpercent50 inputbox required" id="groupid" name="groupid">
							<option value=""><?php echo $langVariables['module']['select_staff_type']?> </option>
							<?php foreach($groupArray as $groups) { ?>
								<option value="<?php echo $groups['id'];?>"><?php echo $groups['group_name'];?></option>
							<?php } ?>							
						</select><br />
					    <label style="display:none;" for="groupid" generated="true" class="error">* required.</label>					
					<?php } ?>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent25 left">&nbsp;</div>
					<div class="wdthpercent80 left">
							<span class=""><input type="hidden" value="1" name="registration_type"><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="addaddadminstaff"></span>
							<span class="pL40">
								<input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
							</span>				  
					</div>
				</div>
		</form>	
	</div>
</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>