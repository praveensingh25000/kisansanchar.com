<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$adminObj         = new admin();
$userObj          = new user();
$langObj          = new language();
$msgObj		      = new message();
$analysisObj      = new analysis();
$videoembedObj    = new videoEmbed();
$searchObj        = new search();
$projectObj       = new project();

$pageArray        = explode('/',$_SERVER['PHP_SELF']);
$sectionType      = (isset($pageArray[1]) && $pageArray[1]=='admin')?trim($pageArray[1]):'front';

$langVariables    = $langObj->get_language_variables($language='en');

$generalSettings  = $langObj->fetch_genral_settings($tablename='site_settings',$groupid = "");

if(!empty($generalSettings)){	
	foreach($generalSettings as $key => $groups){
		foreach($groups as $key => $setting){
			define(strtoupper($setting['name']),$setting['value']);
			define(strtoupper($setting['name'].'_'.$setting['name']),$setting['text']);
		}
	}
}

if(isset($_SESSION['admin_session']['groupid'])){
	$getModuleNames  = $langObj->get_all_user_assign_modules($_SESSION['admin_session']['groupid']);
}

$session_set = '0';
if(!empty($_SESSION['session_user_data']['id'])){
	$session_set = $_SESSION['session_user_data']['id'];
}

$month_option = array(''=>'Month','01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');

$month_analysis_option = array(''=>'Month','all'=>'All','01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');

$day_option[] = array('id' => '', 'name' => 'Day');
for($i=1;$i<=31;$i++){
   if(strlen($i)==1){
	   $day_option[] = array('id' => trim('0'.$i), 'name' => trim('0'.$i));
   } else {
	   $day_option[] = array('id' => trim($i), 'name' => trim($i));
   }
}
//LIRABARY OF YEAR OPTION
$year_condition = date('Y');
$year_option[] = array('id' => '', 'name' => 'Year');
for($i=2010;$i<=$year_condition;$i++){
   if(strlen($i)==1){
	   $year_option[] = array('id' => trim('0'.$i), 'name' => trim('0'.$i));
   } else {
	   $year_option[] = array('id' => trim($i), 'name' => trim($i));
   }
}

//LIRABARY OF YEAR OPTION IN REGISTER PAGE
$year_condition = date('Y');
$year_r_option[] = array('id' => '', 'name' => 'Year');
for($i=1960;$i<=$year_condition;$i++){
   if(strlen($i)==1){
	   $year_r_option[] = array('id' => trim('0'.$i), 'name' => trim('0'.$i));
   } else {
	   $year_r_option[] = array('id' => trim($i), 'name' => trim($i));
   }
}

//LIRABARY OF YEAR OPTION IN REPORT PAGE
$year_condition = date('Y');
$year_rp_option[] = array('id' => '', 'name' => 'Year');
for($i=2013;$i<=$year_condition;$i++){
   if(strlen($i)==1){
	   $year_rp_option[] = array('id' => trim('0'.$i), 'name' => trim('0'.$i));
   } else {
	   $year_rp_option[] = array('id' => trim($i), 'name' => trim($i));
   }
}

//LIRABARY OF YEAR OPTION
$year_condition = date('Y');
$year_condition_register[] = array('id' => '', 'name' => 'Year');
for($i=1910;$i<=$year_condition;$i++){
   if(strlen($i)==1){
	   $year_condition_register[] = array('id' => trim('0'.$i), 'name' => trim('0'.$i));
   } else {
	   $year_condition_register[] = array('id' => trim($i), 'name' => trim($i));
   }
}

//LIRABARY OF YEAR OPTION FOR ANALYSIS
$year_condition = date('Y');
$year_condition_analysis[] = array('id' => '', 'name' => 'Year','id' => 'all', 'name' => 'All');
for($i=2013;$i<=$year_condition;$i++){
   if(strlen($i)==1){
	   $year_condition_analysis[] = array('id' => trim('0'.$i), 'name' => trim('0'.$i));
   } else {
	   $year_condition_analysis[] = array('id' => trim($i), 'name' => trim($i));
   }
}

// all messages to be shown
$session_message = array(

	'0' => $langVariables['msg_var']['admin_succuss_msg'],
	'1' => $langVariables['msg_var']['admin_error_msg'],
	'2' => $langVariables['session_var']['session_msg'],
	'3' => $langVariables['session_var']['register_capcha_var'],
	'4' => $langVariables['session_var']['register_succuss'],
	'5' => $langVariables['msg_var']['verification_succuss'],
	'6' => $langVariables['msg_var']['verification_error'],
	'7' => $langVariables['msg_var']['common_succuss'],
	'8' => $langVariables['msg_var']['intrenal_error'],
	'9' => $langVariables['msg_var']['common_saved'],
	'10'=> $langVariables['msg_var']['setting_saved'],
	'11'=> $langVariables['msg_var']['password_success'],
	'12'=> $langVariables['msg_var']['password_failure'],
	'13'=> $langVariables['msg_var']['common_delete'],
	'14'=> $langVariables['msg_var']['group_exist'],
	'15'=> 'Permission Denied.Please Contact Administrator'
);

$languageArray = $langObj->functionGetSetting($tablename='language', $dmlType='');
?>