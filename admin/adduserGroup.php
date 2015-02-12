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

$category_id = $description = '';

$groupArray     = $langObj->functionGetSetting($tablename='group_settings', $dmlType='');
$groupDetail    = $adminObj->functiongetCategory($tablename='user_groups',$id='',$parent_id='');

if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){
	$category_id    = $_GET['id'];
	$category_one   = $langObj->functionGetSetting($tablename='category', $dmlType='1', $category_id);
	$category_name  = stripslashes($category_one['category_name']);
	$description    = stripslashes($category_one['description']);
	$parent_id      = $category_one['parent_id'];
	$is_active      = trim($category_one['is_active']);
}
if(isset($_POST['submitgroupforms'])){	
	$result  = $adminObj->functionAddGroupSubGroup($_POST);
	$_SESSION['msgsuccess'] = "7";
	header("location: adduserGroup.php");
	exit;	
}
if(isset($_POST['updategroupforms'])){	
	$result  = $adminObj->functionUpdateCategorySubcategory($_POST);
	$_SESSION['msgsuccess'] = "7";
	header("location: adduserGroup.php?id=".$_POST['group_id']."&action=".$_POST['action']."");
	exit;	
}
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading left">
			<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?>
				Edit User Group
			<?php } else {?>
				Add User Group
			<?php }?>	
			<a class="right pR10" href="javascript:;" onclick="javascript:window.history.go(-1);"><?php echo $langVariables['general_var']['back']?></a>
		</h2>
		<div class="clear pB10"></div>

		<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?>
			<form action="" method="post" id="editgroupforms" name="editgroupforms">
		<?php } else {?>
			<form action="" method="post" id="addgroupforms" name="addgroupforms">
		<?php }?>

			<div class="wdthpercent100 register">
				
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['general_var']['group_name']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['general_var']['group_name'];?>" type="text" id="group_name" name="group_name" class="wdthpercent40 required" value="<?php if(isset($group_name)){ echo $group_name;} ?>" />
					</div>
			    </div>
			    <div class="clear"></div>

				<?php if(!empty($groupDetail)) { ?>					
					<div class="wdthpercent100 pT10 pB10">
						<div class="wdthpercent20 left">Select Parent Group</div>
						<div class="wdthpercent80 left">
							<select class="wdthpercent40 inputbox" id="parent_id" name="parent_id">
								<option value="0">Select Parent Group</option>
								<?php foreach($groupDetail as $key => $groups){ ?>
									<option value="<?php echo $groups['id']; ?>" <?php if(isset($parent_id) && $parent_id == $groups['id']){ echo "selected=selected"; } ?>><?php echo $groups['group_name']; ?></option>
								<?php } ?>
							</select>	
							<small>	For adding Parent group,please don't select any group.</small>
						</div>						
					</div>
					<div class="clear"></div>
				<?php } else { ?>
					<input type="hidden" name="parent_cat" value="0">
				<?php } ?>			

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['general_var']['description']?></div>
					<div class="wdthpercent80 left">
					   <textarea placeholder="<?php echo $langVariables['general_var']['description']?>" id="description" name="description" class="wdthpercent40" value="<?php if(isset($description)){ echo $description;} ?>"></textarea>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['category_var']['category_status']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['category_var']['category_status']?>" type="text" id="is_active" name="is_active" class="wdthpercent40 required" value="<?php if(isset($is_active)){ echo $is_active;} ?>" />
					   <small>1 for Active and 0 for deactive </small>
					</div>
			    </div>
			    <div class="clear"></div>	

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left">&nbsp;</div>
					<div class="wdthpercent80 left">
						<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?>
							<span class="">
								<input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="updategroupforms"></span>
							<span class="pL40">
								<input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
								<input type="hidden" value="<?php echo $group_id;?>" name="group_id">
								<input type="hidden" value="<?php echo $_GET['action'];?>" name="action">	
							</span>
						<?php } else {?>
							<span class="">
								<input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submitgroupforms"></span>
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