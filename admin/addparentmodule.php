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
	$module_id    = $_GET['id'];
	$moduleDetail = $langObj->functionGetSetting($tablename='module_settings', $dmlType='1', $module_id);
	$module_name  = stripslashes($moduleDetail['module_name']);
	$is_active    = trim($moduleDetail['is_active']);
}
if(isset($_POST['updatemoduleheadforms'])){	
	$result  = $langObj->functionUpdateModuleHead($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
	}
	header("location:addparentmodule.php?id=".$_POST['module_id']."&action=edit");
	exit;	
}

if(isset($_POST['submitmoduleheadforms'])){	
	$result  = $langObj->functionAddModuleHead($_POST);
	$_SESSION['msgsuccess'] = "7";
	header("location:addparentmodule.php");
	exit;	
}
?>
<!-- containerCenter -->
<section class="containerCenter">

	<div class="containercentercnt">

		<h2 class="heading"><?php echo $langVariables['module']['module_heading']?></h2>
		<div class="clear pB10"></div>

		<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?>
			<form action="" method="post" id="editparentmoduleforms" name="editparentmoduleforms">
		<?php } else {?>
			<form action="" method="post" id="addparentmoduleforms" name="addparentmoduleforms">
		<?php }?>

			<div class="wdthpercent100 register">
				
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_name'];?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['module']['module_name'];?>" type="text" id="module_name" name="module_name" class="wdthpercent40 required" value="<?php if(isset($module_name)){ echo $module_name;} ?>" /><br>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_status']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['module']['module_status']?>" type="text" id="is_active" name="is_active" class="wdthpercent40 required" value="<?php if(isset($is_active)){ echo $is_active;} ?>" /><br>
					</div>
			    </div>
			    <div class="clear"></div>	

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left">&nbsp;</div>
					<div class="wdthpercent80 left">
						<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?>
							<span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="updatemoduleheadforms"></span>
							<span class="pL40">
								<input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
								<input type="hidden" name="module_id" value="<?php echo $module_id;?>">
							</span>
						<?php } else {?>
							<span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submitmoduleheadforms"></span>
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