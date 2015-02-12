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

$notInCategory = '';
$project_id    = (defined('IS_PROJECT_ID'))?IS_PROJECT_ID:'';
if(!$project_id) {
	$notInCategory = implode(',',array('261','275'));
}
$userTypes      = $db->getUniversalRowAll($table_name='user_types');
$categoryDetail = $adminObj->listallsubCategoryActCategory($tablename='category', $status=1, $notInCategory);
$languageArray  = $langObj->functionGetSetting($table_name='language', $dmlType='');
$user_id = $_SESSION['session_user_data']['id'];
$user_privacy_settings_data_array = $db->getUniversalRow($table_name='user_privacy_settings',$coloum_name_str='*',$updated_on_field='user_id',$updated_on_value=$user_id,$otherfields=null);
if(!empty($user_privacy_settings_data_array)){	
	$user_type_setting_checkbox = explode(',',$user_privacy_settings_data_array['user_type_setting']);
	$parent_category_setting_checkbox = explode(',',$user_privacy_settings_data_array['parent_category_setting']);	
	$sub_category_setting_checkbox = explode(',',$user_privacy_settings_data_array['sub_category_setting']);	
	$language_type_setting_checkbox = explode(',',$user_privacy_settings_data_array['language_type_setting']);
	
	$c_parent_category_setting_checkbox = explode(',',$user_privacy_settings_data_array['c_parent_category_setting']);	
	$c_sub_category_setting_checkbox = explode(',',$user_privacy_settings_data_array['c_sub_category_setting']);	

	$g_parent_category_setting_checkbox = explode(',',$user_privacy_settings_data_array['g_parent_category_setting']);	
	$g_sub_category_setting_checkbox = explode(',',$user_privacy_settings_data_array['g_sub_category_setting']);	
}
if(isset($_POST['submitusersetting'])){
	//echo '<pre>';print_r($_POST);echo '</pre>';die;
	$result     = $adminObj->addUserCategoryTypeSetting($_POST);		
	$_SESSION['msgsuccess'] = "7";
	header("location: categorytype-setting.php");
	exit;	
}
//echo '<pre>';print_r($categoryDetail);echo '</pre>';die;
?>

<div class="container">
	<h1 class="title">
		Content Settings
		<div class="right"><a href="<?php echo URL_SITE; ?>/index.php">Timeline</a></div>
	</h1>

	<div class="entry">
		<form action="" method="post" id="userprivicysettingform" name="userprivicysettingform">

			<?php if(!empty($categoryDetail)){ ?>
			    <h3 class="title">Select Category Type Conent</h3>
				<?php foreach($categoryDetail as $categorynamekey => $subcategorys){?>
					<div class="tabnav pT5 pB5 pL20">
						<?php if(isset($subcategorys[0]['parent_cat_id']) && $subcategorys[0]['parent_cat_id']=='261'){?>
							
							<input onclick="javascript: category_subcategory_show('<?php echo $subcategorys[0]['parent_cat_id'];?>');" <?php if(!empty($c_parent_category_setting_checkbox) && in_array($subcategorys[0]['parent_cat_id'],$c_parent_category_setting_checkbox)){ echo 'checked="checked"';}?> value="<?php echo $subcategorys[0]['parent_cat_id'];?>" type="checkbox" id="parent_category_setting<?php echo $subcategorys[0]['parent_cat_id'];?>" name="c_parent_category_setting[]" class="required"/>

							<span class="pL5 fontbld">
								<?php echo ucwords($categorynamekey);?>&nbsp;&nbsp;&nbsp;&nbsp;
								<input onclick="javascript: categorysubcategorycheckAll('<?php echo $subcategorys[0]['parent_cat_id'];?>');" type="checkbox" id="category_subcategory_check_all<?php echo $subcategorys[0]['parent_cat_id'];?>">&nbsp;&nbsp;All
							</span>		

						<?php } else if(isset($subcategorys[0]['parent_cat_id']) && $subcategorys[0]['parent_cat_id']=='275'){?>
							
							<input onclick="javascript: category_subcategory_show('<?php echo $subcategorys[0]['parent_cat_id'];?>');" <?php if(!empty($g_parent_category_setting_checkbox) && in_array($subcategorys[0]['parent_cat_id'],$g_parent_category_setting_checkbox)){ echo 'checked="checked"';}?> value="<?php echo $subcategorys[0]['parent_cat_id'];?>" type="checkbox" id="parent_category_setting<?php echo $subcategorys[0]['parent_cat_id'];?>" name="g_parent_category_setting[]" class="required"/>

							<span class="pL5 fontbld">
								<?php echo ucwords($categorynamekey);?>&nbsp;&nbsp;&nbsp;&nbsp;
								<input onclick="javascript: categorysubcategorycheckAll('<?php echo $subcategorys[0]['parent_cat_id'];?>');" type="checkbox" id="category_subcategory_check_all<?php echo $subcategorys[0]['parent_cat_id'];?>">&nbsp;&nbsp;All
							</span>		

						<?php } else {?>
							
							<input onclick="javascript: category_subcategory_show('<?php echo $subcategorys[0]['parent_cat_id'];?>');" <?php if(!empty($parent_category_setting_checkbox) && in_array($subcategorys[0]['parent_cat_id'],$parent_category_setting_checkbox)){ echo 'checked="checked"';}?> value="<?php echo $subcategorys[0]['parent_cat_id'];?>" type="checkbox" id="parent_category_setting<?php echo $subcategorys[0]['parent_cat_id'];?>" name="parent_category_setting[]" class="required"/>

							<span class="pL5 fontbld">
								<?php echo ucwords($categorynamekey);?>&nbsp;&nbsp;&nbsp;&nbsp;
								<input onclick="javascript: categorysubcategorycheckAll('<?php echo $subcategorys[0]['parent_cat_id'];?>');" type="checkbox" id="category_subcategory_check_all<?php echo $subcategorys[0]['parent_cat_id'];?>">&nbsp;&nbsp;All
							</span>		

						<?php } ?>
						
										
					</div>
					<?php if(!empty($subcategorys)){ ?>
						<?php foreach($subcategorys as $key => $subcategory){?>
						<div style="<?php if(!empty($parent_category_setting_checkbox) && in_array($subcategorys[0]['parent_cat_id'],$parent_category_setting_checkbox)){ echo '';} else if(!empty($c_parent_category_setting_checkbox) && in_array($subcategorys[0]['parent_cat_id'],$c_parent_category_setting_checkbox)){echo '';} else if(!empty($g_parent_category_setting_checkbox) && in_array($subcategorys[0]['parent_cat_id'],$g_parent_category_setting_checkbox)){echo '';} else { echo "display:none;";}?>" class="wdthpercent40 pT5 pB5 pL40 left sub_category_div_show<?php echo $subcategorys[0]['parent_cat_id'];?> hideall">

							<?php if(isset($subcategorys[0]['parent_cat_id']) && $subcategorys[0]['parent_cat_id']=='261'){?>
								
								<input <?php if(!empty($c_sub_category_setting_checkbox) && in_array($subcategory['id'],$c_sub_category_setting_checkbox)){ echo 'checked="checked"';}?> value="<?php echo $subcategory['id'];?>" type="checkbox" id="sub_category_setting" name="c_sub_category_setting[]" class="checked_sub_category<?php echo $subcategorys[0]['parent_cat_id'];?> required"/>
								<span class="pL10"><?php echo ucwords($subcategory['category_name']);?></span>

							<?php } else if(isset($subcategorys[0]['parent_cat_id']) && $subcategorys[0]['parent_cat_id']=='275'){?>
								
								<input <?php if(!empty($g_sub_category_setting_checkbox) && in_array($subcategory['id'],$g_sub_category_setting_checkbox)){ echo 'checked="checked"';}?> value="<?php echo $subcategory['id'];?>" type="checkbox" id="sub_category_setting" name="g_sub_category_setting[]" class="checked_sub_category<?php echo $subcategorys[0]['parent_cat_id'];?> required"/>
								<span class="pL10"><?php echo ucwords($subcategory['category_name']);?></span>

							<?php } else {?>
								
								<input <?php if(!empty($sub_category_setting_checkbox) && in_array($subcategory['id'],$sub_category_setting_checkbox)){ echo 'checked="checked"';}?> value="<?php echo $subcategory['id'];?>" type="checkbox" id="sub_category_setting" name="sub_category_setting[]" class="checked_sub_category<?php echo $subcategorys[0]['parent_cat_id'];?> required"/>
								<span class="pL10"><?php echo ucwords($subcategory['category_name']);?></span>

							<?php } ?>							
							
						</div>						
						<?php } ?>
						<div class="clear pB10"></div>
					<?php } ?>
					
				<?php } ?>
			<?php } ?>			

			<div class="wdthpercent100 pT10 pB10">				
				<span class="right">
					<input class="button" type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submitusersetting">
					<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
				</span>
				<span class="right pR20">
					<input class="button" type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="resetsetting">
				</span>
			</div>
			<div class="clear"></div>

		</form>	
	</div>
</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>