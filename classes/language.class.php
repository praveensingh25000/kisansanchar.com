<?php
/******************************************
* @Modified on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

class language {

	//Function to for getting all language variable
	function get_language_variables($lang='en'){
		global $db;
		$lang_sql   = "select * from `language_variables` where language='".$lang."' order by id";
		$lang_res   = $db->run_query($lang_sql);
		$langrowAll = $db->getAll($lang_res);
		if(!empty($langrowAll)){
			foreach($langrowAll as $lang){
				$langArray[$lang['name']][$lang['sub_name']] = html_entity_decode($lang['value']);
			}
		}
		return $langArray;
	}
	
	function functionAddSetting($postedArray){
		global $db;
		extract($postedArray);
		$sql	= "insert into  `site_settings`  set `groupid` = '".$groupid."', `group`='".mysql_real_escape_string($group)."', `name`='".mysql_real_escape_string($name)."',  `text`='".mysql_real_escape_string($text)."', `value`='".$value."', `date`='".CURRENT_DATE."' ";
		return $insertResult = $db->insert($sql, $db->conn);
	}

	function fetch_genral_settings($tablename='site_settings',$groupid = ""){
		global $db;
		$generalSettings = array();
		if($groupid != ""){
			$sql="select * from `".$tablename."` where groupid = '".$groupid."'";
		} else {
			$sql="select * from `".$tablename."` order by groupid";
		}
		$source=$db->run_query($sql);
		$rowsAll = $db->getAll($source);		
		if(count($rowsAll)>0){
			foreach($rowsAll as $key => $row){
				$generalSettings[$row['groupid']][] = $row;
			}
		}
		return $generalSettings;
	}

	function functionGetSetting($tablename=null, $dmlType=null, $id=null){
		global $db;
		mysql_set_charset('utf8');
		if($dmlType ==''){
			$sql	= "select * from `".$tablename."` order by id ";
			return $db->getAll($db->run_query($sql));
		} else if($dmlType =='1'){
			$sql	= "select * from `".$tablename."` where id = '".$id."' ";
			return $db->getRow($sql);
		} else if($dmlType =='2'){
			$sql	= "select * from `".$tablename."` where groupid = '".$id."' ";
			return $db->getAll($db->run_query($sql));
		} else if($dmlType =='3'){
			$sql	= "select * from `".$tablename."` where module_id = '".$id."' ";
			return $db->getAll($db->run_query($sql));
		} else if($dmlType =='4'){
			$sql	= "select * from `".$tablename."` where user_type_id = '".$id."' ";
			return $db->getRow($sql);
		}
	}

	function functionUpdateSetting($postedArray){
		global $db;
		extract($postedArray);
		//$sql	= "UPDATE `site_settings` SET `name`='".mysql_real_escape_string($name)."',  `text`='".mysql_real_escape_string($text)."', `value`='".$value."', `date`='".CURRENT_DATE."' where id= '".$id."' ";
		$sql	= "UPDATE `site_settings` SET `text`='".mysql_real_escape_string($text)."', `value`='".$value."', `date`= '".CURRENT_DATE."' where id= '".$id."' ";
		return $insertResult = $db->update($sql, $db->conn);
	}

	function functionAddModule($postedArray){
		global $db;
		extract($postedArray);
		$sql	= "insert into `module_settings` SET `groupid`='".$groupid."',
		`module_id`='".mysql_real_escape_string($module_id)."', `module_head`='".mysql_real_escape_string($module_head)."', `module_name`='".mysql_real_escape_string($module_name)."',  `module_link`='".mysql_real_escape_string($module_link)."', `is_active`='".$is_active."', `date`= '".CURRENT_DATE."' ";
		return $insertResult = $db->insert($sql, $db->conn);
	}

	function functionAddModuleHead($postedArray){
		global $db;
		extract($postedArray);
		$sql	= "insert into `module_settings` SET `module_name`='".mysql_real_escape_string($module_name)."', `is_active`='".$is_active."', `date`= '".CURRENT_DATE."' ";
		return $insertResult = $db->insert($sql, $db->conn);
	}

	function functionUpdateModuleHead($postedArray){
		global $db;
		extract($postedArray);
		if(isset($module_id) && $module_id!=''){
			$sql	= "update `module_settings` SET `module_name`='".mysql_real_escape_string($module_name)."', `is_active`='".$is_active."', `date`= '".CURRENT_DATE."' where id = '".$module_id."'";
			return $insertResult = $db->update($sql, $db->conn);
		}
		return false;
	}
	
	function functionUpdateModule($postedArray){
		global $db;
		extract($postedArray);
		$sql	= "UPDATE `module_settings` SET `module_name`='".mysql_real_escape_string($module_name)."',  `module_link`='".mysql_real_escape_string($module_link)."', `is_active`='".$is_active."', `date`= '".CURRENT_DATE."' where `id` = '".$id."' ";
		return $insertResult = $db->update($sql, $db->conn);
	}

	//Sub Module
	function functionAddSubModules($postedArray){
		global $db;
		extract($postedArray);
		$sql	= "insert into `module_sub_settings` SET `module_id`='".mysql_real_escape_string($module_id)."', `sub_module_name`='".mysql_real_escape_string($sub_module_name)."', `sub_module_link`='".mysql_real_escape_string($sub_module_link)."', `is_active`='".$is_active."', `date`= '".CURRENT_DATE."' ";
		return $insertResult = $db->insert($sql, $db->conn);
	}

	//Sub Module
	function functionupdateSubModules($postedArray){
		global $db;
		extract($postedArray);
	    $module_id	        = (isset($module_id))?trim($module_id):'0';
	    $sub_module_name    = (isset($sub_module_name))?trim(addslashes($sub_module_name)):'';
		$sub_module_link    = (isset($sub_module_link))?trim(addslashes($sub_module_link)):'';
		$is_active	        = (isset($is_active))?trim($is_active):'0';
		$id	        = (isset($id))?trim($id):'0';
		if($id!='0' && $id!=''){
			$sql	= "update `module_sub_settings` SET `module_id`='".mysql_real_escape_string($module_id)."', `sub_module_name`='".mysql_real_escape_string($sub_module_name)."', `sub_module_link`='".mysql_real_escape_string($sub_module_link)."', `is_active`='".$is_active."', `date`= '".CURRENT_DATE."' where `id` = '".$id."'";
			return $updateResult = $db->update($sql, $db->conn);
		}
		return false;
	}
	
	function functionAddGroups($postedArray){
		global $db;
		extract($postedArray);
		$sql	= "INSERT into `group_settings` SET `group_name`='".mysql_real_escape_string($group_name)."',  `is_active`='".$is_active."', `date`='".CURRENT_DATE."' ";
		return $insertResult = $db->insert($sql, $db->conn);
	}

	// group update query
	function functionupdateGroups($postedArray){
		global $db;
		extract($postedArray);
		$sql	= "update `group_settings` SET `group_name`='".mysql_real_escape_string($group_name)."',  `is_active`='".$is_active."', `date`='".CURRENT_DATE."' where `id` = '".$id."'";
		return $updateResult = $db->update($sql, $db->conn);
	}

	function functionAddUserType($postedArray){
		global $db;
		extract($postedArray);
		$sql	= "INSERT into `user_types` SET `user_type`='".mysql_real_escape_string($user_type)."',  `is_active`='".$is_active."', `date`='".CURRENT_DATE."' ";
		return $insertResult = $db->insert($sql, $db->conn);
	}

	function functionAssignModules($postedArray){
		global $db;
		$moduleStr ='';
		if(isset($postedArray['groupid'])) {
			$delete_sql    = " DELETE from `module_assign_settings` where `groupid` = '".trim($postedArray['groupid'])."' ";
			$delete_status = $db->run_query($delete_sql);
		}
		if(!empty($postedArray['module_id'])) {
			$moduleStr = implode(',', $postedArray['module_id']);
			$sql	= "insert into `module_assign_settings` SET `groupid`='".trim($postedArray['groupid'])."', `module_id` = '".mysql_real_escape_string($moduleStr)."', `date`='".CURRENT_DATE."' ";
			return $insertResult = $db->insert($sql, $db->conn);
		}		
	}

	function get_all_user_assign_modules($groupid){
		global $db;
		$langArray = array();
		$adminObj  = new admin();		
		$mod_assigned_str = $mod_assigned_all_sql = '';
		if(isset($groupid) && is_numeric($groupid)){
			$mod_assigned_all_sql = "select * from `module_assign_settings` where `groupid`='".$groupid."' ";
		} else {
			$groupidArray = $adminObj->selectUserGroupWithUserTypeArray($groupid);
			if(!empty($groupidArray)){
				$groupidStr = implode(',', $groupidArray);
				$mod_assigned_all_sql = "select * from `module_assign_settings` where `groupid` IN (".$groupidStr.") ";
			}			
		}		
		$mod_assigned_all  = $db->getRow($mod_assigned_all_sql);		
		if(!empty($mod_assigned_all)){
			$mod_assigned_str = $mod_assigned_all['module_id'];
			$moduleArray  = $db->getUniversalJoinData($table_name1='module_settings', $table_name2='module_sub_settings', $join_type='JOIN', $onjoinid1='id' , $onjoinid2='module_id', $wherejoinid_str = ' module_settings.is_active=1 and module_sub_settings.is_active=1 and module_sub_settings.id IN ('.$mod_assigned_str.') ', $coloum_name_str='*', $andcondition='set', $otherfields=null);
			if(!empty($moduleArray)){
				foreach($moduleArray as $module){
				   $langArray[$module['module_name']][$module['sub_module_link']] = $module['sub_module_name'];
				}
			}
		}
		return $langArray;
	}

	function functionAddSMSTypes($postedArray){
		global $db;
		extract($postedArray);
		$sql = "INSERT into `sms_types` SET `menu_type`='".mysql_real_escape_string($menu_type)."', `menu_link`='".mysql_real_escape_string($menu_link)."', `is_active`= '".$is_active."', `date`= '".CURRENT_DATE."' ";
		return $insertResult = $db->insert($sql, $db->conn);
	}

	function functionAssignSMSTypes($postedArray){
		global $db;
		$moduleStr ='';
		if(isset($postedArray['user_type_id'])) {
			$delete_sql    = " DELETE from `sms_types_assign_settings`  where `user_type_id` = '".trim($postedArray['user_type_id'])."' ";
			$delete_status = $db->run_query($delete_sql);
		}
		if(!empty($postedArray['menu_id'])) {
			$menuidStr = implode(',', $postedArray['menu_id']);
			$sql	= "insert into `sms_types_assign_settings`  SET `user_type_id`='".trim($postedArray['user_type_id'])."', `menu_id` = '".mysql_real_escape_string($menuidStr)."', `date`='".CURRENT_DATE."' ";
			return $insertResult = $db->insert($sql, $db->conn);
		}		
	}

	function functionAddMessageStatus($postedArray){
		global $db;		
		extract($postedArray);
		if(!empty($_FILES['logo'])){
			$folder	      = '/uploads/general';
			$formdata     = $_FILES;
			$uploadStatus = uploadFiles($folder, $formdata, $contentid = null);
			if(isset($uploadStatus['urls'][0])){
				$logo = $uploadStatus['urls'][0];		
			}			
		}
		if(!isset($logo)){ return false; }
		$sql      = "insert into `message_status_settings` SET `message_status_name`='".mysql_real_escape_string($message_status_name)."', `is_active`='".$is_active."', `logo`='".mysql_real_escape_string($logo)."', `visibilty`='".$visibilty."', `date`='".CURRENT_DATE."' ";
		return $insertResult = $db->insert($sql, $db->conn);
	}

	function functionEditMessageStatus($postedArray){
		global $db;		
		extract($postedArray);
		if(!empty($_FILES['logo'])){
			$folder	      = '/uploads/general';
			$formdata     = $_FILES;
			$uploadStatus = uploadFiles($folder, $formdata, $contentid = null);
			if(isset($uploadStatus['urls'][0])){
				$logo = $uploadStatus['urls'][0];		
			}			
		}
		if(!isset($logo) && !isset($id)){ return false; }
		$sql  = "UPDATE `message_status_settings` SET `message_status_name`='".mysql_real_escape_string($message_status_name)."', `is_active`='".$is_active."', `logo`='".mysql_real_escape_string($logo)."', `visibilty`='".$visibilty."', `date`='".CURRENT_DATE."' WHERE `id` = '".$id."' ";
		$insertResult = $db->insert($sql, $db->conn);
		return true;
	}

}
?>