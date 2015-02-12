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

$category_id = $description = '';

$groupArray     = $langObj->functionGetSetting($tablename='group_settings', $dmlType='');
$categoryDetail = $adminObj->functiongetCategory($tablename='category',$id='',$parent_id='');

if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){
	$category_id    = $_GET['id'];
	$category_one   = $langObj->functionGetSetting($tablename='category', $dmlType='1', $category_id);
	$category_name  = stripslashes($category_one['category_name']);
	$description    = stripslashes($category_one['description']);
	$parent_id      = $category_one['parent_id'];
	$is_active      = trim($category_one['is_active']);
}
if(isset($_POST['submitcategoryforms'])){	
	$result  = $adminObj->functionAddCategorySubcategory($_POST);
	$_SESSION['msgsuccess'] = "7";
	header("location: addCategory.php");
	exit;	
}
if(isset($_POST['updatecategoryforms'])){	
	$result  = $adminObj->functionUpdateCategorySubcategory($_POST);
	$_SESSION['msgsuccess'] = "7";
	header("location: addCategory.php?id=".$_POST['category_id']."&action=".$_POST['action']."");
	exit;	
}
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading left">
			<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?><?php echo $langVariables['general_var']['edit_category']?>
			<?php } else {?>
				<?php echo $langVariables['category_var']['category_heading']?>
			<?php }?>	
			<a class="right pR10" href="javascript:;" onclick="javascript:window.history.go(-1);"><?php echo $langVariables['general_var']['back']?></a>
		</h2>
		<div class="clear pB10"></div>

		<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?>
			<form action="" method="post" id="editcategoryformsforms" name="editcategoryformsforms">
		<?php } else {?>
			<form action="" method="post" id="addcategoryformsforms" name="addcategoryformsforms">
		<?php }?>

			<div class="wdthpercent100 register">
				
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['category_var']['category_name'];?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['category_var']['category_name'];?>" type="text" id="category_name" name="category_name" class="wdthpercent40 required" value="<?php if(isset($category_name)){ echo $category_name;} ?>" />
					</div>
			    </div>
			    <div class="clear"></div>

				<?php if(!empty($categoryDetail)) { ?>					
					<div class="wdthpercent100 pT10 pB10">
						<div class="wdthpercent20 left"><?php echo $langVariables['category_var']['select_category'];?></div>
						<div class="wdthpercent80 left">
							<select class="wdthpercent40 inputbox" id="parent_id" name="parent_id">
								<option value="0"><?php echo $langVariables['category_var']['select_category'];?></option>
								<?php foreach($categoryDetail as $key => $category){ ?>
									<option value="<?php echo $category['id']; ?>" <?php if(isset($parent_id) && $parent_id == $category['id']){ echo "selected=selected"; } ?>><?php echo $category['category_name']; ?></option>
								<?php } ?>
							</select>	
							<small><?php echo $langVariables['category_var']['category_message'];?></small>
						</div>						
					</div>
					<div class="clear"></div>
				<?php } else { ?>
					<input type="hidden" name="parent_cat" value="0">
				<?php } ?>			

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['category_var']['category_description'];?></div>
					<div class="wdthpercent80 left">
					   <textarea placeholder="<?php echo $langVariables['category_var']['category_description'];?>" id="description" name="description" class="wdthpercent40"><?php if(isset($description)){ echo $description;} ?></textarea>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['category_var']['category_status']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['category_var']['category_status']?>" type="text" id="is_active" name="is_active" class="wdthpercent40 required" value="<?php if(isset($is_active)){ echo $is_active;} ?>" />
					   <small><?php echo $langVariables['general_var']['status_msg']?></small>
					</div>
			    </div>
			    <div class="clear"></div>	

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left">&nbsp;</div>
					<div class="wdthpercent80 left">
						<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?>
							<span class="">
								<input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="updatecategoryforms"></span>
							<span class="pL40">
								<input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
								<input type="hidden" value="<?php echo $category_id;?>" name="category_id">
								<input type="hidden" value="<?php echo $_GET['action'];?>" name="action">	
							</span>
						<?php } else {?>
							<span class="">
								<input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submitcategoryforms"></span>
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