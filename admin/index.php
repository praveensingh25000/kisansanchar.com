<?php
/******************************************
* @Modified on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
include_once $basedir."/include/adminHeader.php";
$groupArray  = $langObj->functionGetSetting($tablename='group_settings', $dmlType='');

if(isset($_SESSION['admin_session'])){
	header('location: '.URL_SITE.'/admin/timeline.php');
	exit;
}
if(isset($_POST['clicklogin'])){	
	$username  = $_POST['username'];
	$password  = md5($_POST['password']);
	$groupid   = $_POST['groupid'];
	$adminData = $adminObj->login($username, $password, $groupid);	
	if(!empty($adminData)){
		$_SESSION['admin_session']  = $adminData;
		$_SESSION['msgsuccess']		= "0";
		header('location: '.URL_SITE.'/admin/users.php');
		exit;
	} else {
		$_SESSION['msgerror'] = "1";
		header('location: '.URL_SITE.'/admin/index.php');
		exit;
	}
}
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<div id="" class="adminlogin">
			
			<form action="" method="post" id="adminformlogin" name="adminformlogin">			
		    
				<h2><?php echo $langVariables['form_var']['admin_login']?></h2>
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['form_var']['username']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="enter username or email" type="text" id="username" name="username" class="wdthpercent60 required"/><br>
					</div>
				</div>
				<div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['form_var']['password']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="enter password" type="password" id="password" name="password" class="wdthpercent60 required"/><br>
					</div>
				</div>
				<div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
				   <div class="wdthpercent20 left"><?php echo $langVariables['group']['select_module_type']?></div>
				   <div class="wdthpercent80 left">
				   <?php if(!empty($groupArray)) { ?>
						<select class="wdthpercent60 required" id="groupid" name="groupid">
							<option value=""><?php echo $langVariables['module']['select_module_type']?> </option>
							<?php foreach($groupArray as $groups) { ?>
								<?php if($groups['id']!='1') {?>
									<option <?php if($groups['id']=='2'){echo 'selected="selected"';}?> value="<?php echo $groups['id'];?>"><?php echo $groups['group_name'];?></option>
								<?php } ?>
							<?php } ?>							
						</select><br />					
					<?php } ?>
					</div>
				</div>
				<div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left">&nbsp;</div>
					<div class="wdthpercent80 left">
						<span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="clicklogin"></span>
						<span class="pL40"><input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset"></span>					  
					</div>
				</div>
				<div class="clear"></div>			
			</form>	
		</div>
	</div>
</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>