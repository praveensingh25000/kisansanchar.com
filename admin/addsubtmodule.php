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

$sub_module_name = $sub_module_link = $is_active = '';

$dataArray  = $langObj->functionGetSetting($tablename='module_settings', $dmlType='');

if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){
	$sub_module_id    = $_GET['id'];
	$submoduleDetail = $langObj->functionGetSetting($tablename='module_sub_settings', $dmlType='1', $sub_module_id);
	$sub_module_name  = stripslashes($submoduleDetail['sub_module_name']);
	$sub_module_link  = stripslashes($submoduleDetail['sub_module_link']);
	$is_active        = trim($submoduleDetail['is_active']);
	$module_id        = trim($submoduleDetail['module_id']);
}

if(isset($_POST['updatesubmoduleheadforms'])){	
	$result  = $langObj->functionupdateSubModules($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
	}
	header("location:addsubtmodule.php?id=".$_POST['id']."&action=edit");
	exit;	
}

if(isset($_POST['submitsubmoduleforms'])){	
	$result  = $langObj->functionAddSubModules($_POST);	
	$_SESSION['msgsuccess'] = "7";
	header("location:addsubtmodule.php");
	exit;	
}

//echo '<pre>';print_r($dataArray);echo '</pre>';die;
?>
<!-- containerCenter -->
<section class="containerCenter">

	<div class="containercentercnt">

		<h2 class="heading"><?php echo $langVariables['module']['module_heading']?></h2>
		<div class="clear pB10"></div>

		<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?>
			<form action="" method="post" id="editsubmoduleform" name="editsubmoduleform">
		<?php } else {?>
			<form action="" method="post" id="addsubmoduleform" name="addsubmoduleform">	
		<?php }?>

			<div class="wdthpercent100 register">
			
				<div class="wdthpercent100 pT10 pB10">
				   <div class="wdthpercent20 left"><?php echo $langVariables['module']['select_parent_module_type']?></div>
				   <div class="wdthpercent80 left">
				   <?php if(!empty($dataArray)) { ?>
						<select class="wdthpercent40 inputbox required" id="module_id" name="module_id">
							<option value=""><?php echo $langVariables['module']['select_parent_module_type']?> </option>
							<?php foreach($dataArray as $data) { ?>
								<option <?php if(isset($module_id) && $module_id == $data['id']){ echo 'selected="selected"';}?> value="<?php echo $data['id'];?>"><?php echo $data['module_name'];?></option>
							<?php } ?>							
						</select><br />					
					<?php } ?>
					</div>
			    </div>
			    <div class="clear"></div>
				
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_name']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['module']['module_name']?>" type="text" id="sub_module_name" name="sub_module_name" class="wdthpercent40 required" value="<?php if(isset($sub_module_name)){echo $sub_module_name;}?>"/><br>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_link']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['module']['module_link']?>" type="text" id="sub_module_link" name="sub_module_link" class="wdthpercent40 required" value="<?php if(isset($sub_module_link)){echo $sub_module_link;} ?>"/><br>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_status']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['module']['module_status']?>" type="text" id="is_active" name="is_active" class="wdthpercent40 required" value="<?php if(isset($is_active)){echo $is_active;} ?>"/><br>
					</div>
			    </div>
			    <div class="clear"></div>	

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left">&nbsp;</div>
					<div class="wdthpercent80 left">
						<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?>
							<span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="updatesubmoduleheadforms"></span>
							<span class="pL40">
								<input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
								<input type="hidden" name="id" value="<?php echo $sub_module_id;?>">
							</span>
						<?php } else {?>
							<span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submitsubmoduleforms"></span>
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