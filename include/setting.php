<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

//Checking the live and test status of the site
if(defined('SITE_STATUS') && SITE_STATUS=='test' && $sectionType=='front'){
	header('location: site.php');
	exit;
}

//setting for sidebarleft,rightbar
$pagename = basename($_SERVER['PHP_SELF']);
$divtonotShowArray = array('reports-percentage-village-wise-data.php','reports-percentage-farmer-wise-data.php','reports-farmer-joining-data.php','search.php');

$divtonotShowsidebarleft = array('reports-percentage-village-wise-data.php','reports-percentage-farmer-wise-data.php','reports-farmer-joining-data.php','search.php');

$divtonotShowsidebarright = array('reports-percentage-village-wise-data.php','reports-percentage-farmer-wise-data.php','reports-farmer-joining-data.php','search.php','reports.php','view-project-detail.php','contact.php');

$divtoshowArray = array('');

$loaderSetterDivArray = array('message.php','report.php','create-group.php','addViewGroupMember.php');

$NoloaderPageShowArray = array('reports-percentage-farmer-wise-data.php','reports-percentage-village-wise-data.php','add-project-detail.php');

if(isset($_SESSION['admin_session']['id'])){
	$admin_user_id = $_SESSION['admin_session']['id'];
}

if(isset($_SESSION['session_user_data']['id'])){
	$front_user_id = $_SESSION['session_user_data']['id'];
}

if(!empty($_SESSION['session_user_data']['dashbordType'])){
	if($_SESSION['session_user_data']['dashbordType']=='PAU'){
		$dashbordType = $_SESSION['session_user_data']['user_type'];
		$project_id   = getExploded($_SESSION['session_user_data']['user_type'],'-',1);
		define('FRONT_USER_ID', $front_user_id);
		define('IS_PROJECT_ID', $project_id);
		define('PROJECTDASHBORD', $dashbordType);
		define('TEXT_SENDER', $projectObj->getProjectSenderName($project_id));
	}else if($_SESSION['session_user_data']['dashbordType']=='PU'){
		define('FRONT_USER_ID', $front_user_id);
		$dashbordType = $_SESSION['session_user_data']['user_type'];
		$project_id   = $projectObj->getProjectUserId($_SESSION['session_user_data']['id']);
		define('IS_PROJECT_ID', $project_id);
	}else{
		define('FRONT_USER_ID', $front_user_id);
	}
}

$timeline_url = '';
if(!empty($_SESSION['session_user_data']['id'])){
    $userDetail	= $db->getUniversalRow($table_name='users', $coloum_name_str='*', $updated_on_field='id', $_SESSION['session_user_data']['id'], $otherfields	= null);
	$setting = $db->getUniversalRow($table_name='user_privacy_settings',$coloum_name_str='*',$updated_on_field='user_id',$updated_on_value=$userDetail['id'],$otherfields=null);
	if($_SESSION['session_user_data']['dashbordType']=='PAU'){
		$project_id = getExploded($_SESSION['session_user_data']['user_type'],'-',1);	
		$fullname   = $adminObj->getprojectName($project_id);
		if(!empty($setting) && $setting['parent_category_setting']=='1'){			
			$_SESSION['msgsuccess'] = "10";
			$timeline_url = '/setting.php?'.$fullname;
		}else {
			$_SESSION['msgsuccess'] = "0";
			$timeline_url = '/dashboard.php?'.$fullname;
		}
	}
	if($_SESSION['session_user_data']['dashbordType']=='PU' || $_SESSION['session_user_data']['dashbordType']=='NU'){
		$fullname   = getUserName($userDetail,'join');
		if(!empty($setting) && $setting['parent_category_setting']=='1'){
			$_SESSION['msgsuccess'] = "10";
			$timeline_url = '/setting.php?'.$fullname;
		}else {
			$_SESSION['msgsuccess'] = "0";
			$timeline_url = '/index.php?'.$fullname;
		}
	}
}
?>