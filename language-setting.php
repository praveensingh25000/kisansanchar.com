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
if(isset($_SESSION['session_user_data']['user_type']) && is_numeric($_SESSION['session_user_data']['user_type'])) {
	$notInCategory = implode(',',array('261','275'));
}
$userTypes      = $db->getUniversalRowAll($table_name='user_types');
$categoryDetail = $adminObj->listallsubCategoryActCategory($tablename='category', $status=1, $notInCategory);
$languageArray  = $langObj->functionGetSetting($table_name='language', $dmlType='');
$user_id = $_SESSION['session_user_data']['id'];
$user_privacy_settings_data_array = $db->getUniversalRow($table_name='user_privacy_settings',$coloum_name_str='*',$updated_on_field='user_id',$updated_on_value=$user_id,$otherfields=null);
if(!empty($user_privacy_settings_data_array)){	
	$language_type_setting_checkbox = explode(',',$user_privacy_settings_data_array['language_type_setting']);
}
if(isset($_POST['submitusersetting'])){
	//echo '<pre>';print_r($_POST);echo '</pre>';die;
	$result     = $adminObj->addUserLanguageTypeSetting($_POST);		
	$_SESSION['msgsuccess'] = "7";
	header("location: language-setting.php");
	exit;	
}
//echo '<pre>';print_r($categoryDetail);echo '</pre>';die;
?>

<div class="container">
	<h1 class="title">
		Language Settings
		<div class="right"><a href="<?php echo URL_SITE; ?>/index.php">Timeline</a></div>
	</h1>

	<div class="entry">
		<form action="" method="post" id="userprivicysettingform" name="userprivicysettingform">
		
			<?php if(!empty($languageArray)) { ?>
			<div class="wdthpercent100 pT10 pB10">
				<h3 class="title">Select Language Type Conent</h3>	
				<div class="tabnav pT5 pB5 pL20">
					<input type="checkbox" id="language-type-check-all">&nbsp;&nbsp;All
				</div>
				<?php foreach($languageArray as $language) { ?>
					<div class="wdthpercent100 pT5 pB5 pL20">								   
						<input <?php if(!empty($language_type_setting_checkbox) && in_array($language['name'],$language_type_setting_checkbox)){ echo 'checked="checked"';}?> value="<?php echo $language['name'];?>" type="checkbox" id="language_type_setting" name="language_type_setting[]" class="required"/>
						<span class="pL10"><?php echo ucwords($language['value']);?></span><br />
						<label style="display:none;" for="language_type_setting" generated="true" class="error">* required.</label>
					</div>
					<div class="clear pB10"></div>
				<?php } ?>
			</div>
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