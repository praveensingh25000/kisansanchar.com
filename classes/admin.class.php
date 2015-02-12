<?php
/******************************************
* @Modified on JAN 26, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

class admin {

	# Function to  login user
	function login($emailPhone, $password, $groupid){
		global $db;		
		$returnData = array();
		$sql	= "select * from `users` where (`email` = '".$emailPhone."' or `phone` = '".$emailPhone."') and `password` = '".$password."' ";
		$data = $db->getRow($sql);
		if(!empty($data) && is_numeric($data['user_type'])){
			if($data['groupid'] == $groupid){
				$returnData = $data;	
			}
		} else if(!empty($data) && !is_numeric($data['user_type'])){			
			$is_in_group_array = self::selectUserGroupWithGroupID($groupid,$data['user_type']);
			if(!empty($is_in_group_array)){
				$returnData = $data;
			}
			
		}
		return $returnData;
	}

	// function to select user group with group id
	function selectUserGroupWithGroupID($groupid=NULL, $user_type_str=NULL){
		$returnData    = $groupArray = array();
		$langObj       = new language();	
		$user_type_arr = explode('-', $user_type_str);
		if(!empty($user_type_arr[1])){
			$projectid     = $user_type_arr[1];
			$projectData   = $langObj->functionGetSetting($tablename='projects', $dmlType='1', $id=$projectid);
			$super_admin_arr = explode(';', $projectData['super_admin']);		
			if(!empty($super_admin_arr)){
				foreach($super_admin_arr as $groupidstr){
					$groupArrayOne = explode('-', $groupidstr);
					$groupArray[]  = $groupArrayOne[1];
				}
			}
			if(!empty($groupArray) && in_array($groupid, $groupArray)){
				$returnData = $groupArray;
			}
		}
		return $returnData;
	}

	// function to select user group with user type
	function selectUserGroupWithUserTypeArray($user_type_str=NULL){
		$returnData    = array();
		$super_admin_arr = explode(';', $user_type_str);		
		if(!empty($super_admin_arr)){
			foreach($super_admin_arr as $groupidstr){
				$groupArrayOne = explode('-', $groupidstr);
				$returnData[]  = $groupArrayOne[1];
			}
		}		
		return $returnData;
	}

	// this function is used for registration 
	function registration($postedArray){
		global $db;
		extract($postedArray);
		$sql	= "insert into `users`  SET `pfirstname`='".mysql_real_escape_string($pfirstname)."', `plastname`='".mysql_real_escape_string($plastname)."',  `email`='".mysql_real_escape_string($email)."', `password`='".md5($password)."', `phone`='".$phone."', `gender`='".$gender."', user_type='".$user_type."', `groupid`='".$groupid."', `active_status` = '1', `registration_type` = '".$registration_type."', `date`='".CURRENT_DATE."';";
		return $insertResult = $db->insert($sql, $db->conn);
	}

	// function for displaying the user registered with site
	function showAllActiveDeactiveUsers($active=0,$is_deleted=0,$searchkey=''){
		global $db;		
		$sql = "select * from users where `groupid` = '1' ";
		if(!empty($searchkey)){
			if($searchkey['searchkey']!=''){
				$sql.= " and (`pfirstname` LIKE '%".$searchkey['searchkey']."%' or `plastname` LIKE '%".$searchkey['searchkey']."%' or `sfirstname` LIKE '%".$searchkey['searchkey']."%' or `slastname` LIKE '%".$searchkey['searchkey']."%' or`phone` = '".$searchkey['searchkey']."' or `username` LIKE '%".$searchkey['searchkey']."%') ";
			}
			if($searchkey['user_type']!=''){
				$sql.= " and `user_type` = '".$searchkey['user_type']."' ";
			}
			/*if($searchkey['district']!=''){
				$sql.= " and `district` = '".$searchkey['district']."' ";
			}
			if($searchkey['village']!=''){
				$sql.= " and `village` = '".$searchkey['village']."' ";
			}*/
		}
		if($is_deleted == '1'){
			$sql.= " and is_deleted ='".$is_deleted."' order by id DESC ";
		} else {
			$sql.= " and block_status='".$active."' and is_deleted ='".$is_deleted."' order by id DESC ";
		}
		//echo $sql;
		return $usersResult = $db->run_query($sql);
	}

	// function to display the all staff members of the website
	function showAllActiveDeactiveStaff($active=0,$is_deleted=0){
		global $db;		
		$sql = "select * from users where `groupid` != '1' ";
		if($is_deleted == '1'){
			$sql.= " and is_deleted ='".$is_deleted."' order by id ASC ";
		} else {
			$sql.= " and block_status='".$active."' and is_deleted ='".$is_deleted."' order by id ASC ";
		}
		$usersResult = $db->run_query($sql);
		return $usersResult;
	}

	// function to activate or deactivate the status of the table, id 
	function activedeactiveStatus($tablename, $ids, $action,$status){
		global $db;
		switch($action){
			case 'active':
				$sql="update ".$tablename." set block_status='".$status."', is_deleted='0' where id IN (".$ids.")";
				$result	= $db->run_query($sql);
				break;
			case 'in-active':
				$sql="update ".$tablename." set block_status='".$status."', is_deleted='0' where id IN (".$ids.")";
				$result	= $db->run_query($sql);
				break;
			case 'delete':
				$sql="update ".$tablename." set is_deleted='".$status."' where id IN (".$ids.")";
				$result	= $db->run_query($sql);
				break;
		}
		return $result;
	}

	//function to add category and sub category with active/inactive status
	function functionAddCategorySubcategory($postedArray){
		global $db;
		extract($postedArray);
		$category_name	= (isset($category_name))?trim(addslashes($category_name)):'';
	    $parent_id	    = (isset($parent_id))?trim($parent_id):'0';
	    $description    = (isset($description))?trim(addslashes($description)):'';
		$is_active	    = (isset($is_active))?trim($is_active):'0';
		$sql	= "insert into `category` SET `category_name`='".mysql_real_escape_string($category_name)."', `description`='".mysql_real_escape_string($description)."', `parent_id`='".$parent_id."', `is_active`='".$is_active."', `date`='".CURRENT_DATE."' ";
		return $insertResult = $db->insert($sql, $db->conn);
	}

	// function to update the category and sub category
	function functionUpdateCategorySubcategory($postedArray){
		global $db;
		extract($postedArray);
		$category_name	= (isset($category_name))?trim(addslashes($category_name)):'';
	    $parent_id	    = (isset($parent_id))?trim($parent_id):'0';
	    $description    = (isset($description))?trim(addslashes($description)):'';
		$category_id    = (isset($category_id))?trim($category_id):'0';
		$is_active	    = (isset($is_active))?trim($is_active):'0';

		if($category_id!='0'){
			$sql	= "UPDATE `category` SET `category_name`='".mysql_real_escape_string($category_name)."', `description`='".mysql_real_escape_string($description)."', `parent_id`='".$parent_id."', `is_active`='".$is_active."', `date`='".CURRENT_DATE."' WHERE `id`='".$category_id."' ";
			return $insertResult = $db->update($sql, $db->conn);
		}
	}

	// function to fetch the category
	function functiongetCategory($tablename='category',$id=null,$parent_id=null){
		global $db;
		if($id =='' && $parent_id==''){
			$sql	= "select * from `".$tablename."` where parent_id ='0' order by id ";
			return $db->getAll($db->run_query($sql));
		} else if($id !='0'){
			$sql	= "select * from `".$tablename."` where id = '".$id."' ";
			return $db->getrow($sql);
		} else if($parent_id !='0'){
			$sql	= "select * from `".$tablename."` where `parent_id` = '".$parent_id."' ";
			return $db->getAll($db->run_query($sql));
		}
	}

	// function to fetch the sub category
	function functiongetSubCategory($tablename='category', $parent_id=null){
		global $db;		
		$sql	= "select * from `".$tablename."` where `parent_id` = '".$parent_id."' ";
		return $db->getAll($db->run_query($sql));		
	}

	//this function display all the category and sub category which is displayed on left side
	function listallsubCategoryActCategory($tablename='category',$status=null,$notInCategory){
		global $db;
		$adminObj       = new admin();
		$arrayCategory  = array();
		$notinvariable  = '';
		if(isset($notInCategory) && $notInCategory!=''){
		$notinvariable  = "and `id` NOT IN (".$notInCategory.")";
		}
		$sql	        = "select * from `".$tablename."` where parent_id ='0' ".$notinvariable." order by id ";
		$parentCategory = $db->getAll($db->run_query($sql));
		if(!empty($parentCategory)){
			foreach($parentCategory as $key => $category){
				$sql	     = "select * from `".$tablename."` where `parent_id`='".$category['id']."' ";
			    $subCategory = $db->getAll($db->run_query($sql));
				if(!empty($subCategory)){
					if($status=='0'){
						$arrayCategory[$category['category_name']]['subCategory'] = $subCategory;
						$arrayCategory[$category['category_name']]['subCategory']['count'] = count($subCategory);	
					} else {
						foreach($subCategory as $keyone => $subCategoryone){
						$subCategory[$keyone]['parent_cat_id']       = $category['id'];
						}
						$arrayCategory[$category['category_name']] = $subCategory;
					}
				}
			}
		}
		return $arrayCategory;		
	}

	//this function allow to select the active category and sub category
	function selectActiveParentSubparentCategory($tablename='category', $select_type=null){
		global $db;
		if($select_type=='0'){
			$sql	= "select * from `".$tablename."` where `parent_id` = '".$select_type."' ";
		} else {
			$sql	= "select * from `".$tablename."` where `parent_id` != '0' ";
		}
		return $db->getAll($db->run_query($sql));
	}

	// function to select the active android message from database table
	function selectActiveMessageAndriodCategory($tablename='message', $message_type=null, $language_type=null,$status='0',$user_privacy_settings_sql=null){
		global $db;
		mysql_set_charset('utf8');	
		if(!is_numeric($message_type)){
			$sql = "select * from `".$tablename."` where 1 ";
			if(isset($message_type) && $message_type!='all'){
				$sql.= " and  `message_type` = '".$message_type."' ";
			}
			if(isset($language_type) && $language_type!='all'){
				$sql.= " and  `language_type` = '".$language_type."' ";
			}
			if(isset($status) && $status!='all'){
				if($status == 'Pending'){
					$sql.= " and  `status` = '0' ";
				} else {
					$sql.= " and  `status` = '1' ";
				}				
			}
			if(isset($user_privacy_settings_sql) && $user_privacy_settings_sql!=''){
				$sql.= $user_privacy_settings_sql;
			}
			$sql.= " order by id DESC LIMIT 100";
			return $db->getAll($db->run_query($sql));
		} else {
			$sql	= "select * from `".$tablename."` where `id` = '".$message_type."' ";
			return $db->getRow($sql);
		}
	}

	// function for android pagination(next/back) for front end
	function selectActiveMessageAndriodPagination($tablename='message', $message_type=null, $language_type=null, $day=null, $month=null, $year=null, $status='0',$user_privacy_settings_sql=null,$startlimit='',$endlimit='',$othercondition=null,$groupby=''){
		global $db;
		$message = array();
		mysql_set_charset('utf8');	
		if(!is_numeric($message_type)){
			$sql = "select DISTINCT * from `".$tablename."` where 1 ";
			if(isset($message_type) && $message_type!='all'){
				$sql.= " and  `message_type` = '".$message_type."' ";
			}
			if(isset($language_type) && $language_type!='all'){
				$sql.= " and  `language_type` = '".$language_type."' ";
			}
			if(isset($status) && $status!='all'){
				if($status == 'Pending'){
					$sql.= " and  `status` = '0' ";
				} else {
					$sql.= " and  `status` = '1' ";
				}				
			}
			if(isset($user_privacy_settings_sql) && $user_privacy_settings_sql!=''){
				$sql.= $user_privacy_settings_sql;
			}
			if(isset($day) && $day!=''){
				$sql.= " and DAY(broadcast_date) = '".$day."'  ";
			}
			if(isset($month) && $month!=''){
				$sql.= " and MONTH(broadcast_date) = '".$month."'  ";
			}
			if(isset($year) && $year!=''){
				$sql.= " and YEAR(broadcast_date) = '".$year."'  ";
			}
			if(isset($othercondition) && $othercondition!=''){
				$sql.= " and ".$othercondition."  ";
			}
			if(isset($groupby) && $groupby!=''){
				//$sql.= " ".$groupby."  ";
			}
			if($startlimit!='' && $endlimit!=''){
				$sql.= " order by broadcast_date DESC ";
			}
			$messageDataArray = $db->getAll($db->run_query($sql));
			if(!empty($messageDataArray)){
				foreach($messageDataArray as $key => $messageData){
					$message_file_key = $messageData['message_file'];
					if(empty($messageData['message_file'])){
						$message_file_key = 'No_file'.$key;
					}					
					$messageDataArrayRaw[date('Y-m-d',strtotime($messageData['broadcast_date']))][$messageData['user_id']][$message_file_key] = $messageData;
				}
				foreach($messageDataArrayRaw as $messageDataArrayRawAll){
					foreach($messageDataArrayRawAll as $messageDataArrayRawAllinnerone){
						foreach($messageDataArrayRawAllinnerone as $messageDataArrayRawAllinnertwo){
							$message['text_'.$messageDataArrayRawAllinnertwo['id']] = $messageDataArrayRawAllinnertwo;
						}
					}
				}

				//echo '<pre>';print_r($message);echo '</pre>';

			}
			return $message;
		} else {
			$sql	= "select * from `".$tablename."` where `id` = '".$message_type."' ";
			return $db->getRow($sql);
		}
	}

	// function for android pagination(next/back) for Back end
	function selectActiveMessageAndriodPaginationAdmin($tablename='message', $message_type=null, $language_type=null, $day=null, $month=null, $year=null, $status='0',$user_privacy_settings_sql=null,$startlimit='0',$endlimit='10',$othercondition=null){
		global $db;
		$message = array();
		mysql_set_charset('utf8');	
		if(!is_numeric($message_type)){
			$sql = "select * from `".$tablename."` where 1 ";
			if(isset($message_type) && $message_type!='all'){
				$sql.= " and  `message_type` = '".$message_type."' ";
			}
			if(isset($language_type) && $language_type!='all'){
				$sql.= " and  `language_type` = '".$language_type."' ";
			}
			if(isset($status) && $status!='all'){
				if($status == 'Pending'){
					$sql.= " and  `status` = '0' ";
				} else {
					$sql.= " and  `status` = '1' ";
				}				
			}
			if(isset($user_privacy_settings_sql) && $user_privacy_settings_sql!=''){
				$sql.= $user_privacy_settings_sql;
			}
			if(isset($day) && $day!=''){
				$sql.= " and DAY(date) = '".$day."'  ";
			}
			if(isset($month) && $month!=''){
				$sql.= " and MONTH(date) = '".$month."'  ";
			}
			if(isset($year) && $year!=''){
				$sql.= " and YEAR(date) = '".$year."'  ";
			}
			if(isset($othercondition) && $othercondition!=''){
				$sql.= " and ".$othercondition."  ";
			}
			if($startlimit!='' && $endlimit!=''){
				$sql.= " order by id DESC LIMIT ".$startlimit.",".$endlimit." ";
			}
			//echo $sql;
			$messageDataArray = $db->getAll($db->run_query($sql));
			if(!empty($messageDataArray)){
				foreach($messageDataArray as $messageData){
					$message['text_'.$messageData['id']] = $messageData;
				}
			}
			return $message;
		} else {
			$sql	= "select * from `".$tablename."` where `id` = '".$message_type."' ";
			return $db->getRow($sql);
		}
	}

	// function to 
	function selectUserMessageAndriodPagination($tablename='message', $message_type=null, $language_type=null, $day=null, $month=null, $year=null, $status='0',$user_privacy_settings_sql=null,$startlimit='0',$endlimit='10',$othercondition=null){
		global $db;
		$message = array();
		mysql_set_charset('utf8');	
		if(!is_numeric($message_type)){
			$sql = "select * from `".$tablename."` where 1 ";
			if(isset($message_type) && $message_type!='all'){
				$sql.= " and  `message_type` = '".$message_type."' ";
			}
			if(isset($language_type) && $language_type!='all'){
				$sql.= " and  `language_type` = '".$language_type."' ";
			}
			if(isset($status) && $status!='all'){
				if($status == 'Pending'){
					$sql.= " and  `status` = '0' ";
				} else {
					$sql.= " and  `status` = '1' ";
				}				
			}
			if(isset($user_privacy_settings_sql) && $user_privacy_settings_sql!=''){
				$sql.= $user_privacy_settings_sql;
			}
			if(isset($day) && $day!=''){
				$sql.= " and DAY(date) = '".$day."'  ";
			}
			if(isset($month) && $month!=''){
				$sql.= " and MONTH(date) = '".$month."'  ";
			}
			if(isset($year) && $year!=''){
				$sql.= " and YEAR(date) = '".$year."'  ";
			}
			if(isset($othercondition) && $othercondition!=''){
				$sql.= " and ".$othercondition."  ";
			}
			if($startlimit!='' && $endlimit!=''){
				$sql.= " order by date DESC LIMIT ".$startlimit.",".$endlimit." ";
			}
			//echo $sql;
			$messageDataArray = $db->getAll($db->run_query($sql));
			if(!empty($messageDataArray)){
				foreach($messageDataArray as $messageData){
					$message['text_'.$messageData['id']] = $messageData;
				}
			}
			return $message;
		} else {
			$sql	= "select * from `".$tablename."` where `id` = '".$message_type."' ";
			return $db->getRow($sql);
		}
	}

	function selectActiveMessageAndriodCategoryUser($tablename='message', $message_type=null, $language_type=null,$status='0', $user_id=null, $user_privacy_settings_sql=null){
		global $db;
		mysql_set_charset('utf8');
		if(!is_numeric($message_type)){
			$sql = "select * from `".$tablename."` where `user_id` = '".$user_id."' and 1 ";
			if(isset($message_type) && $message_type!='all'){
				$sql.= " and  `message_type` = '".$message_type."' ";
			}
			if(isset($language_type) && $language_type!='all'){
				$sql.= " and  `language_type` = '".$language_type."' ";
			}
			if(isset($status) && $status!='all'){
				if($status == 'Pending'){
					$sql.= " and  `status` = '0' ";
				} else {
					$sql.= " and  `status` = '1' ";
				}				
			}
			if(isset($user_privacy_settings_sql) && $user_privacy_settings_sql!=''){
				$sql.= $user_privacy_settings_sql;
			}
			$sql.= " order by id DESC ";
			return $db->getAll($db->run_query($sql));
		} else {
			$sql	= "select * from `".$tablename."` where `id` = '".$message_type."' ";
			return $db->getRow($sql);
		}
	}

	// function to select the active message of android
	function selectActiveMessageAndriodPaginationProject($tablename='message', $message_type=null, $language_type=null, $day=null, $month=null, $year=null, $status='0',$user_privacy_settings_sql=null,$startlimit='0',$endlimit='10',$othercondition=null){
		global $db;
		$messageRaw = $message = array();
		mysql_set_charset('utf8');	
		if(!is_numeric($message_type)){
			$sql = "select * from `".$tablename."` where 1 ";
			if(isset($message_type) && $message_type!='all'){
				$sql.= " and  `message_type` = '".$message_type."' ";
			}
			if(isset($language_type) && $language_type!='all'){
				$sql.= " and  `language_type` = '".$language_type."' ";
			}
			if(isset($status) && $status!='all'){
				if($status == 'Pending'){
					$sql.= " and  `status` = '0' ";
				} else {
					$sql.= " and  `status` = '1' ";
				}				
			}
			if(isset($user_privacy_settings_sql) && $user_privacy_settings_sql!=''){
				$sql.= $user_privacy_settings_sql;
			}
			if(isset($day) && $day!=''){
				$sql.= " and DAY(broadcast_date) = '".$day."'  ";
			}
			if(isset($month) && $month!=''){
				$sql.= " and MONTH(broadcast_date) = '".$month."'  ";
			}
			if(isset($year) && $year!=''){
				$sql.= " and YEAR(broadcast_date) = '".$year."'  ";
			}
			if(isset($othercondition) && $othercondition!=''){
				$sql.= " and ".$othercondition."  ";
			}
			if($startlimit!='' && $endlimit!=''){
				$sql.= " GROUP BY message_file order by broadcast_date DESC LIMIT ".$startlimit.",".$endlimit." ";
			}
			//echo $sql.'<br>';
			$messageDataArray = $db->getAll($db->run_query($sql));
			if(!empty($messageDataArray)){
				foreach($messageDataArray as $key => $messageData){
					$message['text_'.$messageData['id']] = $messageData;
				}
			}
			return $message;
		} else {
			$sql	= "select * from `".$tablename."` where `id` = '".$message_type."' ";
			return $db->getRow($sql);
		}
	}

	//function to add user content setting it stores the data in user_privacy_settings table
	function addUserContentSetting($postedArray){
		global $db;
		extract($postedArray);
		$user_type_setting_str	    = (!empty($user_type_setting))?implode(',',$user_type_setting):'1';
		$parent_category_setting_str	= (!empty($parent_category_setting))?implode(',',$parent_category_setting):'1';
		$sub_category_setting_str	= (!empty($sub_category_setting))?implode(',',$sub_category_setting):'1';
		$language_type_setting_str	= (!empty($language_type_setting))?implode(',',$language_type_setting):'1';
		$c_parent_category_setting_str	= (!empty($language_type_setting))?implode(',',$c_parent_category_setting):'261';
		$c_sub_category_setting_str	= (!empty($language_type_setting))?implode(',',$c_sub_category_setting):'255';
		$g_parent_category_setting_str	= (!empty($language_type_setting))?implode(',',$g_parent_category_setting):'275';
		$g_sub_category_setting_str	= (!empty($language_type_setting))?implode(',',$g_sub_category_setting):'277';
		$user_id	                = (isset($user_id))?trim($user_id):'0';		

		if($user_id){
			$sql = "UPDATE `user_privacy_settings` SET `user_type_setting` = '".mysql_real_escape_string($user_type_setting_str)."', `parent_category_setting`='".mysql_real_escape_string($parent_category_setting_str)."', `sub_category_setting`='".mysql_real_escape_string($sub_category_setting_str)."', `language_type_setting`='".mysql_real_escape_string($language_type_setting_str)."', `c_parent_category_setting`='".mysql_real_escape_string($c_parent_category_setting_str)."', `c_sub_category_setting`='".mysql_real_escape_string($c_sub_category_setting_str)."', `g_parent_category_setting`='".mysql_real_escape_string($g_parent_category_setting_str)."', `g_sub_category_setting`='".mysql_real_escape_string($g_sub_category_setting_str)."', `date`='".CURRENT_DATE."' WHERE `user_id` = '".trim($user_id)."' ";
			return $insertResult = $db->insert($sql, $db->conn);
		}
	}
	
	//function to add the user category it stores the data in user_privacy_settings table
	function addUserCategoryTypeSetting($postedArray){
		global $db;
		extract($postedArray);	

		$parent_category_setting_str	= (!empty($parent_category_setting))?implode(',',$parent_category_setting):'1';
		$sub_category_setting_str	= (!empty($sub_category_setting))?implode(',',$sub_category_setting):'1';
		$c_parent_category_setting_str	= (!empty($c_parent_category_setting))?implode(',',$c_parent_category_setting):'261';
		$c_sub_category_setting_str	= (!empty($c_sub_category_setting))?implode(',',$c_sub_category_setting):'255';
		$g_parent_category_setting_str	= (!empty($g_parent_category_setting))?implode(',',$g_parent_category_setting):'275';
		$g_sub_category_setting_str	= (!empty($g_sub_category_setting))?implode(',',$g_sub_category_setting):'277';
		$user_id	                = (isset($user_id))?trim($user_id):'0';		

		if($user_id){
			$sql = "UPDATE `user_privacy_settings` SET  `parent_category_setting`='".mysql_real_escape_string($parent_category_setting_str)."', `sub_category_setting`='".mysql_real_escape_string($sub_category_setting_str)."', `c_parent_category_setting`='".mysql_real_escape_string($c_parent_category_setting_str)."', `c_sub_category_setting`='".mysql_real_escape_string($c_sub_category_setting_str)."', `g_parent_category_setting`='".mysql_real_escape_string($g_parent_category_setting_str)."', `g_sub_category_setting`='".mysql_real_escape_string($g_sub_category_setting_str)."', `date`='".CURRENT_DATE."' WHERE `user_id` = '".trim($user_id)."' ";
			return $insertResult = $db->insert($sql, $db->conn);
		}
	}
	
	//function to add/update the user type setting and stores the data in user_privacy_settings table
	function addUserUserTypeSetting($postedArray){
		global $db;
		extract($postedArray);		
		$user_type_setting_str	    = (!empty($user_type_setting))?implode(',',$user_type_setting):'1';	
		$user_id	                = (isset($user_id))?trim($user_id):'0';		

		if($user_id){
			$sql = "UPDATE `user_privacy_settings` SET `user_type_setting` = '".mysql_real_escape_string($user_type_setting_str)."', `update_on`='".CURRENT_DATE."' WHERE `user_id` = '".trim($user_id)."' ";
			return $insertResult = $db->insert($sql, $db->conn);
		}
	}

	// this function to add the user language type like english, hindi
	function addUserLanguageTypeSetting($postedArray){
		global $db;
		extract($postedArray);		
		$language_type_setting_str	= (!empty($language_type_setting))?implode(',',$language_type_setting):'1';		
		$user_id	                = (isset($user_id))?trim($user_id):'0';		

		if($user_id){
			$sql = "UPDATE `user_privacy_settings` SET `language_type_setting`='".mysql_real_escape_string($language_type_setting_str)."', `update_on`='".CURRENT_DATE."' WHERE `user_id` = '".trim($user_id)."' ";
			return $insertResult = $db->insert($sql, $db->conn);
		}
	}
	
	// function
	function getcontentSettingSqlArray($table_name='user_privacy_settings', $coloum_name_str='*', $updated_on_field=null, $updated_on_value=null, $otherfields=null, $returnType='sql'){
		global $db;
		$sql = '';
		$settingArray = array();

	    //ACCORDING TO CONTENT SETTING
		$user_privacy_settings_data_array = $db->getUniversalRow($table_name='user_privacy_settings',$coloum_name_str, $updated_on_field, $updated_on_value,$otherfields);

		//ACCORDING TO CONTENT SETTING
		$userDetail = $db->getUniversalRow($table_name='users',$coloum_name_str, $updated_on_field='id', $updated_on_value,$otherfields);

		if(!empty($user_privacy_settings_data_array)){	
			$user_type_setting_str       = $user_privacy_settings_data_array['user_type_setting'];
			$parent_category_setting_str = $user_privacy_settings_data_array['parent_category_setting'];	
			$sub_category_setting_str    = $user_privacy_settings_data_array['sub_category_setting'];
			$language_type_setting_array = $user_privacy_settings_data_array['language_type_setting'];
			$c_parent_category_setting_str = $user_privacy_settings_data_array['c_parent_category_setting'];
			$c_sub_category_setting_str    = $user_privacy_settings_data_array['c_sub_category_setting'];
			$g_parent_category_setting_str = $user_privacy_settings_data_array['g_parent_category_setting'];
			$g_sub_category_setting_str    = $user_privacy_settings_data_array['g_sub_category_setting'];

			if(!empty($language_type_setting_array)){	
				$language_type_setting_str_array_all ='';
				$language_type_setting_str_array = explode(',',$language_type_setting_array);
				foreach($language_type_setting_str_array as $language_type_setting_str_array_one){
				  $language_type_setting_str_array_all.='"'.$language_type_setting_str_array_one.'"'.' ,';
				}
				$language_type_setting_str = substr($language_type_setting_str_array_all, 0, -1);
			}			
			$settingArray['user_type_setting']	     =	$user_privacy_settings_data_array['user_type_setting'];
			$settingArray['parent_category_setting'] =	$user_privacy_settings_data_array['parent_category_setting'];
			$settingArray['sub_category_setting']    =	$user_privacy_settings_data_array['sub_category_setting'];
			$settingArray['language_type_setting']    =	$user_privacy_settings_data_array['language_type_setting'];
		}
		if(isset($user_type_setting_str) && $user_type_setting_str!='' && $user_type_setting_str!='all'){
			$sql.= " and `user_type` IN (".$user_type_setting_str.") ";
		}
		if($userDetail['is_project_user']=='0' && isset($parent_category_setting_str) && $parent_category_setting_str!='' && $parent_category_setting_str!='all'){
			$sql.= " and `parent_category` IN (".$parent_category_setting_str.") ";
		}
		if($userDetail['is_project_user']=='0' && isset($sub_category_setting_str) && $sub_category_setting_str!='' && $sub_category_setting_str!='all'){
			$sql.= " and `sub_category` IN (".$sub_category_setting_str.") ";
		}
		if(isset($language_type_setting_str) && $language_type_setting_str!='' && $language_type_setting_str!='all'){
			$sql.= " and `language_type` IN (".$language_type_setting_str.") ";
		}
		if($userDetail['is_project_user']=='1' && isset($c_parent_category_setting_str) && $c_parent_category_setting_str!='' && $c_parent_category_setting_str!='all'){
			$sql.= " and  `c_parent_category` IN (".$c_parent_category_setting_str.") ";
		}
		if($userDetail['is_project_user']=='1' && isset($c_sub_category_setting_str) && $c_sub_category_setting_str!='' && $c_sub_category_setting_str!='all'){
			$sql.= " and `c_sub_category` IN (".$c_sub_category_setting_str.") ";
		}
		if($userDetail['is_project_user']=='1' && isset($g_parent_category_setting_str) && $g_parent_category_setting_str!='' && $g_parent_category_setting_str!='all'){
			$sql.= " and `g_parent_category` IN (".$g_parent_category_setting_str.") ";
		}
		if($userDetail['is_project_user']=='1' && isset($g_sub_category_setting_str) && $g_sub_category_setting_str!='' && $g_sub_category_setting_str!='all'){
			$sql.= " and `g_sub_category` IN (".$g_sub_category_setting_str.") ";
		}
		if(isset($returnType) && $returnType=='sql'){
			return $sql;
		} else {			
			return $settingArray;
		}

	}

	// this function is used to add the project 
	function functionAddProject($postedArray){
		global $db;
		extract($postedArray);
		$sql	= "INSERT into `projects` SET `project_name` = '".mysql_real_escape_string($project_name)."', `sender_name` = '".mysql_real_escape_string($sender_name)."', date='".CURRENT_DATE."' ";
		$project_id = $db->insert($sql);
		if($project_id){
			if($sender_name_check){
			   sendMailToServiceProvider($sender_name,$receivename,$receivermail);
			}
			$sql_user	= "INSERT into `users` SET `pfirstname`='".getExploded($project_name,' ','0')."' , `plastname`='".getExploded($project_name,' ','1')."', `is_project_user` = '".$project_id."', `email`='".mysql_real_escape_string($email)."', `password`='".md5Hash($password)."', `phone`='".$phone."',groupid = '1', user_type='Project-".$project_id."', active_status='1', date='".CURRENT_DATE."' ";
			$insert_user_id = $db->insert($sql_user);
			if($insert_user_id){
				$sql_privacy	= "INSERT into `user_privacy_settings` SET `user_id` ='".$insert_user_id."', `user_type_setting` = '1', `parent_category_setting` ='1', `sub_category_setting` = '1', date='".CURRENT_DATE."' ";
				$insert = $db->insert($sql_privacy);
			}
		}
		return $project_id;
	}

	// project update query starts here-->
	// fuction to update the project name, users, and staff
	function functionUpdateproject($postedArray){
		global $db;
		extract($postedArray);
		$project_name	= (isset($project_name))?trim(addslashes($project_name)):'';
	    $super_admin	= (isset($super_admin))?trim($super_admin):'';
	    $assigned_users = (isset($assigned_users))?trim($assigned_users):'';
		$assigned_staff = (isset($assigned_staff))?trim($assigned_staff):'';
		$is_active	    = (isset($is_active))?trim($is_active):'0';

		if($id!='0'){
			$sql	= "UPDATE `projects` SET 
			`project_name` = '".mysql_real_escape_string($project_name)."',
			`super_admin` = '".mysql_real_escape_string($super_admin)."',
			`assigned_users` = '".mysql_real_escape_string($assigned_users)."',
			`assigned_staff` = '".mysql_real_escape_string($assigned_staff)."',
			`is_active` = '".$is_active."', 
			`date` = '".CURRENT_DATE."' 
			WHERE `id` = '".$id."' ";
			return $updateResult = $db->update($sql, $db->conn);
		}
	}
	
	// this function helps to update the assigned project user
	function functionUpdateProjectAssignedUser($postedArray){
		global $db;
		extract($postedArray);
		$assigned_users	= (!empty($assigned_users))?($assigned_users):'1';		
		$project_id	    = (isset($project_id))?trim($project_id):'0';		
		if($project_id!='' && $project_id!='0'){
			$sql = "SELECT * FROM `projects` where `id` = '".$project_id."' ";
			$projectData = $db->getRow($sql);
			if(!empty($projectData['assigned_users'])){
				$updated_assigned_users_old_array = explode(';',$projectData['assigned_users']);
				$updated_assigned_users_new_array = explode(';',$assigned_users);
				$updated_assigned_users_combine   = array_merge($updated_assigned_users_old_array,$updated_assigned_users_new_array);

				$updated_assigned_users = implode(';',array_unique($updated_assigned_users_combine));
				
				$sql	= "UPDATE `projects` SET `assigned_users` = '".mysql_real_escape_string($updated_assigned_users)."', `date` = '".CURRENT_DATE."' WHERE `id` = '".$project_id."' ";
				foreach($updated_assigned_users_new_array as $userid){
					$db->updateUniversalRow($table_name='users',$coloum_name_str=" `is_project_user` = '".$project_id."' ",$updated_on_field='id',$userid,$otherfields=null);
				}
				return $updateResult = $db->update($sql, $db->conn);
			}
		}
		return false;
	}
	//projects update query ends here -->

	//Function on 08/03/2014
	function functionContenPrivacySetting($tablename, $contentArrayType,$contentType='languages'){
		global $db;
		$returnData = array();
		$contentArrayType_str ='';
		if($contentType == 'languages'){
			if(!empty($contentArrayType['language_type_setting'])){	
				$language_type_setting_str_array_all ='';
				$language_type_setting_str_array = explode(',',$contentArrayType['language_type_setting']);
				foreach($language_type_setting_str_array as $language_type_setting_str_array_one){
				  $language_type_setting_str_array_all.="'".$language_type_setting_str_array_one."'".',';
				}
				$contentArrayType_str = substr($language_type_setting_str_array_all, 0, -1);
			}
		}
		if($contentType == 'categorysubcategory'){
			$parent_category_setting_str = $sub_category_setting_str ='';
			if(!empty($contentArrayType['parent_category_setting'])){	
				$parent_category_setting_str = $contentArrayType['parent_category_setting'];
			}
			if(!empty($contentArrayType['sub_category_setting'])){	
				$sub_category_setting_str    = $contentArrayType['sub_category_setting'];
			}
			if($parent_category_setting_str!='' && $sub_category_setting_str!=''){
				$sql_cs	        = "select * from `category` where `id` IN (".$sub_category_setting_str.") ";
				$parentCategory = $db->getAll($db->run_query($sql_cs));
			}
			if(!empty($parentCategory)){
				foreach($parentCategory as $key => $category){
					$numberofsubcategory = array();									
					$sql	= "select * from `category` where `id` = '".$category['parent_id']."' ";
					$parentCategory = $db->getRow($sql);
					if(!empty($parentCategory)){
						$returnData[$parentCategory['category_name']]['subCategory'][$category['id']] = $category;			
					}					
				}
			}
		}
		if(isset($contentArrayType_str) && $contentArrayType_str!=''){
			$sql = "select * from `".$tablename."` where `name` IN (".$contentArrayType_str.") ";
			$returnData = $db->getAll($db->run_query($sql));
		}		
		return $returnData;
	}

	// function to add voice file and csv file
	function functionAddVoiceFileCSVFile($msg_id, $wave_file, $csv_file, $user_group_str, $user_sub_group_str, $user_sub_group_other_str, $job_type, $state, $district){
		global $db;
		$sql = "INSERT into `message_ordinates` SET `msg_id`='".$msg_id."', `wave_file`='".$wave_file."', `csv_file`='".$csv_file."', `user_group`='".$user_group_str."', `user_sub_group`='".$user_sub_group_str."', `user_sub_group_other`='".$user_sub_group_other_str."', `job_type`='".$job_type."', `state`='".$state."', `district`='".$district."', date='".CURRENT_DATE."' ";
		$db->insert($sql, $db->conn);
		$db->updateUniversalRow($table_name='message',$coloum_name_str=" `message_file` = '".$wave_file."', `content_type` = '".trim(end(explode('.', $wave_file)))."' ",$updated_on_field='id',$msg_id,$otherfields=null);
		return true;
	}

	//function to add android message with audio/ video/ images
	function functionAddSmsAndriodMsg($postedArray){

		global $db;
		$videoembedObj  = new videoEmbed();
		extract($postedArray);
		$message_condition = $content_type = $message_file = $categoryCondition = '';
		if(isset($select_upload_type) && ($select_upload_type=='photos' || $select_upload_type=='audios'|| $select_upload_type=='videos')){
			if(!empty($_FILES) && $_FILES['message_file']['size']!='0'){
				if($select_upload_type=='photos'){
					$folder	  = '/uploads/photos';
				} else if($select_upload_type=='audios'){
					$folder	  = '/uploads/audios';
				} else if($select_upload_type=='videos'){
					$folder	  = '/uploads/videos';
				}				
				$formdata     = $_FILES;
				$uploadStatus = uploadAllTypeFiles($folder, $formdata, $contentid = null);

				if(!empty($uploadStatus) && !array_key_exists('urls',$uploadStatus)){
					return false;
				}
				if(isset($uploadStatus['urls'][0])){
					$message_file      = $uploadStatus['urls'][0];	
					$content_type      = end(explode('.', $message_file));
					$message_condition = " `message_file` = '".$message_file."',`content_type` = '".$content_type."', ";
				}
			}			
		}
		if(isset($select_upload_type) && $select_upload_type=='embeddedUrl'){
			$inputembbedcode = $postedArray['message_file'];
			list($imagelink, $vediolink, $embedcode) = $videoembedObj->embededcodewithurl($inputembbedcode);
			$message_condition = " `message_file` = '".$imagelink."', `message_url` = '".$embedcode."', `content_type` = 'embeddedUrl', ";
		}
		if(isset($c_parent_category) && isset($g_parent_category)){
			$c_sub_category_str = implode(',',$c_sub_category);
			$g_sub_category_str = implode(',',$g_sub_category);
			$categoryCondition = " `c_parent_category`='".$c_parent_category."', `c_sub_category`='".$c_sub_category_str."', `g_parent_category`='".$g_parent_category."',`g_sub_category`='".$g_sub_category_str."', `parent_category`='0', `sub_category`='0',  ";		
		} else {
			$categoryCondition = " `parent_category`='".$parent_category."', `sub_category`='".$sub_category."',`c_parent_category`='0', `c_sub_category`='0', `g_parent_category`='0',`g_sub_category`='0',  ";
		}
		if(!isset($language_checked)){ $language_type = 'en'; }
		mysql_set_charset('utf8');
		$datenow = CURRENT_DATE;
		if(date('A',strtotime($datenow))=='AM'){
			$content_time = 'Morning';
		}else{
			$content_time = 'Evening';
		}

		mysql_query('SET character_set_results=utf8');       
		mysql_query('SET names=utf8');       
		mysql_query('SET character_set_client=utf8');       
		mysql_query('SET character_set_connection=utf8');
		mysql_query('SET collation_connection=utf8_general_ci'); 

		$sql	= "INSERT into `message` SET `user_id`='".$user_id."', `status_type`='".$status_type."', `user_type`='".$user_type."', `message_subject`='".mysql_real_escape_string($message_subject)."', `message`='".addslashes($message)."', `message_type`='".trim($message_type)."', ".$message_condition." ".$categoryCondition." `language_type`='".trim($language_type)."', `message_tag`='".mysql_real_escape_string($message_tag)."', `content_time` = '".$content_time."', `date`= '".$datenow."' ";
		$inserted_msg_id  = $db->insert($sql, $db->conn);
		if($inserted_msg_id!='' && !isset($voice_type) && (isset($user_group) || isset($user_sub_group) || isset($user_sub_group_other))){
			$user_group_str           = (isset($user_group))?implode(',',$user_group):'';
			$user_sub_group_str		  = (isset($user_sub_group))?implode(',',$user_sub_group):'';
			$user_sub_group_other_str = (isset($user_sub_group_other))?implode(',',$user_sub_group_other):'';
			$sql_inner	= "INSERT into `message_ordinates` SET `msg_id`='".$inserted_msg_id."', `user_group`='".$user_group_str."', `user_sub_group`='".$user_sub_group_str."', `user_sub_group_other`='".$user_sub_group_other_str."' ";
			$db->insert($sql_inner, $db->conn);					
		}
		return $inserted_msg_id;
	}
	
	//function to add user group and sub group of user
	function functionAddGroupSubGroup($postedArray){
		global $db;
		extract($postedArray);
		$group_name   = (isset($group_name))?trim(addslashes($group_name)):'';
	    $parent_id	  = (isset($parent_id))?trim($parent_id):'0';
	    $description  = (isset($description))?trim(addslashes($description)):'';
		$is_active	  = (isset($is_active))?trim($is_active):'0';
		$sql	= "insert into `user_groups` SET `group_name`='".mysql_real_escape_string($group_name)."', `description`='".mysql_real_escape_string($description)."', `parent_id`='".$parent_id."', `is_active`='".$is_active."', `date`='".CURRENT_DATE."' ";
		return $insertResult = $db->insert($sql, $db->conn);
	}

	// functio to update the group and sub group of user
	function functionUpdateGroupSubGroup($postedArray){
		global $db;
		extract($postedArray);
		$group_name 	= (isset($group_name))?trim(addslashes($group_name)):'';
	    $parent_id	    = (isset($parent_id))?trim($parent_id):'0';
	    $description    = (isset($description))?trim(addslashes($description)):'';
		$group_id       = (isset($group_id))?trim($group_id):'0';
		$is_active	    = (isset($is_active))?trim($is_active):'0';

		if($group_id!='0'){
			$sql	= "UPDATE `category` SET `group_name`='".mysql_real_escape_string($category_name)."', `description`='".mysql_real_escape_string($description)."', `parent_id`='".$parent_id."', `is_active`='".$is_active."', `date`='".CURRENT_DATE."' WHERE `id`='".$group_id."' ";
			return $insertResult = $db->update($sql, $db->conn);
		}
	}

	function selectActiveMessageAndriodPaginationArray($tablename='message', $message_type=null, $language_type=null, $day=null, $month=null, $year=null, $status='0',$user_privacy_settings_sql=null, $startLimit='1', $endLimit='10', $othercondition=null,$orderby=''){
		global $db;
		$message_sorted_out = $message = $messageArray = array();
		mysql_set_charset('utf8');
		if(!is_numeric($message_type)){
			$sql = "select DISTINCT * from `".$tablename."` where 1 ";
			if(isset($message_type) && $message_type!='all'){
				$sql.= " and  `message_type` = '".$message_type."' ";
			}
			if(isset($language_type) && $language_type!='all'){
				$sql.= " and  `language_type` = '".$language_type."' ";
			}
			if(isset($status) && $status!='all'){				
				$sql.= " and  `status` = '".$status."' ";							
			}
			if(isset($user_privacy_settings_sql) && $user_privacy_settings_sql!=''){
				$sql.= $user_privacy_settings_sql;
			}
			if(isset($day) && $day!=''){
				$sql.= " and DAY(broadcast_date) = '".$day."'  ";
			}
			if(isset($month) && $month!=''){
				$sql.= " and MONTH(broadcast_date) = '".$month."'  ";
			}
			if(isset($year) && $year!=''){
				$sql.= " and YEAR(broadcast_date) = '".$year."'  ";
			}
			if(isset($othercondition) && $othercondition!=''){
				$sql.= " and ".$othercondition."  ";
			}
			
			if(isset($orderby) && $orderby!=''){
				$sql.= " ".$orderby." ";
			}
			//echo $sql; 
			$messageDataArray = $db->getAll($db->run_query($sql));
			if(!empty($messageDataArray)){
				foreach($messageDataArray as $key => $messageData){
					$message_file_key = $messageData['message_file'];
					if(empty($messageData['message_file'])){
						$message_file_key = 'No_file'.$key;
					}					
					$messageDataArrayRaw[date('Y-m-d',strtotime($messageData['broadcast_date']))][$messageData['user_id']][$message_file_key] = $messageData;
				}
				//echo '<pre>';print_r($messageDataArrayRaw);echo '</pre>';die;
				foreach($messageDataArrayRaw as $datekey => $messageDataArrayRawAll){
					foreach($messageDataArrayRawAll as $messageDataArrayRawAllinnerone){
						foreach($messageDataArrayRawAllinnerone as $messageDataArrayRawAllinnertwo){
							$messageArray['text_'.$messageDataArrayRawAllinnertwo['id']] = $messageDataArrayRawAllinnertwo;							
						}
					}
				}
			}
			if($startLimit!='' && $endLimit!=''){
				$nextpage  = ($startLimit-1) * $endLimit;
				return $message =  array_slice($messageArray, $nextpage,$endLimit,true);
			}
			return $messageArray;
		} else {
			$sql	= "select * from `".$tablename."` where `id` = '".$message_type."' ";
			return $db->getRow($sql);
		}
	}

	function selectActiveMessageAndriodPaginationArrayAdmin($tablename='message', $message_type=null, $language_type=null, $day=null, $month=null, $year=null, $status='0',$user_privacy_settings_sql=null, $startLimit='1', $endLimit='10', $othercondition=null,$orderby=''){
		global $db;
		$message_sorted_out = $message = $messageArray = array();
		mysql_set_charset('utf8');		
		if(!is_numeric($message_type)){
			$sql = "select DISTINCT * from `".$tablename."` where 1 ";
			if(isset($message_type) && $message_type!='all'){
				$sql.= " and  `message_type` = '".$message_type."' ";
			}
			if(isset($language_type) && $language_type!='all'){
				$sql.= " and  `language_type` = '".$language_type."' ";
			}
			if(isset($status) && $status!='all'){				
				$sql.= " and  `status` = '".$status."' ";								
			}
			if(isset($user_privacy_settings_sql) && $user_privacy_settings_sql!=''){
				$sql.= $user_privacy_settings_sql;
			}
			if(isset($day) && $day!=''){
				$sql.= " and DAY(date) = '".$day."'  ";
			}
			if(isset($month) && $month!=''){
				$sql.= " and MONTH(date) = '".$month."'  ";
			}
			if(isset($year) && $year!=''){
				$sql.= " and YEAR(date) = '".$year."'  ";
			}
			if(isset($othercondition) && $othercondition!=''){
				$sql.= " and ".$othercondition."  ";
			}
			if(isset($orderby) && $orderby!=''){
				$sql.= " ".$orderby."  ";
			}
			//echo $sql; 
			$messageDataArray = $db->getAll($db->run_query($sql));
			if(!empty($messageDataArray)){
				foreach($messageDataArray as $key=>$messageData){
					$message_file_key = $messageData['message_file'];
					if(empty($messageData['message_file'])){
						$message_file_key = 'No_file'.$key;
					}					
					$messageDataArrayRaw[date('Y-m-d',strtotime($messageData['broadcast_date']))][$messageData['user_id']][$message_file_key] = $messageData;
				}
				foreach($messageDataArrayRaw as $datekey => $messageDataArrayRawAll){
					foreach($messageDataArrayRawAll as $messageDataArrayRawAllinnerone){
						foreach($messageDataArrayRawAllinnerone as $messageDataArrayRawAllinnertwo){
							$messageArray['text_'.$messageDataArrayRawAllinnertwo['id']] = $messageDataArrayRawAllinnertwo;							
						}
					}
				}
			}
			if($startLimit!='' && $endLimit!=''){
				$nextpage  = ($startLimit-1) * $endLimit;
				return $message =  array_slice($messageArray, $nextpage,$endLimit,true);
			}
			return $messageArray;
		} else {
			$sql	= "select * from `".$tablename."` where `id` = '".$message_type."' ";
			return $db->getRow($sql);
		}
	}

	function selectActiveMessageAndriodPaginationUserArray($tablename='message', $message_type=null, $language_type=null, $day=null, $month=null, $year=null, $status='',$user_privacy_settings_sql=null, $startLimit='1', $endLimit='10', $othercondition=null,$orderby=''){
		global $db;
		$message_sorted_out = $message = $messageArray = array();
		mysql_set_charset('utf8');
		if(!is_numeric($message_type)){
			$sql = "select DISTINCT * from `".$tablename."` where 1 ";
			if(isset($message_type) && $message_type!='all'){
				$sql.= " and  `message_type` = '".$message_type."' ";
			}
			if(isset($language_type) && $language_type!='all'){
				$sql.= " and  `language_type` = '".$language_type."' ";
			}
			if(isset($status) && $status!='all' && $status!=''){				
				$sql.= " and  `status` = '".$status."' ";							
			}
			if(isset($user_privacy_settings_sql) && $user_privacy_settings_sql!=''){
				$sql.= $user_privacy_settings_sql;
			}
			if(isset($day) && $day!=''){
				$sql.= " and DAY(date) = '".$day."'  ";
			}
			if(isset($month) && $month!=''){
				$sql.= " and MONTH(date) = '".$month."'  ";
			}
			if(isset($year) && $year!=''){
				$sql.= " and YEAR(date) = '".$year."'  ";
			}
			if(isset($othercondition) && $othercondition!=''){
				$sql.= " ".$othercondition."  ";
			}			
			if(isset($orderby) && $orderby!=''){
				$sql.= " ".$orderby."  ";
			}
			//echo $sql; 
			$messageDataArray = $db->getAll($db->run_query($sql));
			if(!empty($messageDataArray)){
				foreach($messageDataArray as $key=>$messageData){
					$message_file_key = $messageData['message_file'];
					if(empty($messageData['message_file'])){
						$message_file_key = 'No_file'.$key;
					}					
					$messageDataArrayRaw[date('Y-m-d',strtotime($messageData['date']))][$messageData['user_id']][$message_file_key] = $messageData;
				}
				foreach($messageDataArrayRaw as $datekey => $messageDataArrayRawAll){
					foreach($messageDataArrayRawAll as $messageDataArrayRawAllinnerone){
						foreach($messageDataArrayRawAllinnerone as $messageDataArrayRawAllinnertwo){
							$messageArray['text_'.$messageDataArrayRawAllinnertwo['id']] = $messageDataArrayRawAllinnertwo;							
						}
					}
				}
			}
			if($startLimit!='' && $endLimit!=''){
				$nextpage  = ($startLimit-1) * $endLimit;
				return $message  =  array_slice($messageArray, $nextpage,$endLimit,true);
			}
			return $messageArray;
		} else {
			$sql	= "select * from `".$tablename."` where `id` = '".$message_type."' ";
			return $db->getRow($sql);
		}
	}
	
	//function to search the details of farmers
	function SelectFarmerDetail($mobile){
		global $db;
		$sql = "SELECT u.id as user_id, u.phone as phone, u.gender, u.pfirstname,u.plastname,u.sfirstname,u.slastname,u.pfathername,u.sfathername,usc.name as country,uss.name as state,usd.name as district,ust.name as tehsil, usv.name as village 
		FROM `users` u 
		JOIN `india` usc ON usc.id = u.country 
		JOIN `india` uss ON uss.id = u.state 
		JOIN `india` usd ON usd.id = u.district
		JOIN `india` ust ON ust.id = u.tehsil
		JOIN `india` usv ON usv.id = u.village
		WHERE u.phone='".$mobile."' ";
		return $db->getRow($sql);
	}

	//Carrer details starts
	// fuction to add the details of interns
	function functionAddCarrerDetail($postedArray){
		global $db;
		extract($postedArray);
		$uploaded_condition = '';
		if(isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['size']!='0'){
			$folder	      = '/uploads/contacts';
			$formdata     = $_FILES;
			$uploadStatus = uploadAllTypeFiles($folder, $formdata, $contentid = null);
			if(isset($uploadStatus['urls']['0'])){
				$uploaded_condition = " `uploaded_file` = '".$uploadStatus['urls']['0']."', ";
			}
		}
		$sql	= "INSERT INTO `contact_us` SET `content_type` = '".$content_type."', `name`='".mysql_real_escape_string($name)."',`email`='".mysql_real_escape_string($email)."',`phone`='".$phone."',`subject`='".mysql_real_escape_string($subject)."',`message`='".mysql_real_escape_string($message)."', ".$uploaded_condition." `date`= '".CURRENT_DATE."'";
		return $insertResult = $db->insert($sql, $db->conn);
	}
	//Carrer details ends

	//contact details starts
	//function to add the details of contacted person
	function functionAddContactDetail($postedArray){
		global $db;
		extract($postedArray);
		$uploaded_condition = '';
		if(isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['size']!='0'){
			$folder	      = '/uploads/contacts';
			$formdata     = $_FILES;
			$uploadStatus = uploadAllTypeFiles($folder, $formdata, $contentid = null);
			if(isset($uploadStatus['urls']['0'])){
				$uploaded_condition = " `uploaded_file` = '".$uploadStatus['urls']['0']."', ";
			}
		}
		$sql	= "INSERT INTO `contact_us` SET `content_type` = '".$content_type."', `name`='".mysql_real_escape_string($name)."',`email`='".mysql_real_escape_string($email)."',`phone`='".$phone."',`subject`='".mysql_real_escape_string($subject)."',`message`='".mysql_real_escape_string($message)."', ".$uploaded_condition." `date`= '".CURRENT_DATE."'";
		return $db->insert($sql);
	}
	//contact details ends


	//***********SMS GROUP ADDING FUNCTION START ******************	
	//function to add the group members data
	function functionInsertGroupMembersData($tablename, $postedArray){
		global $db;
		$insertStr = $insertData = '';
		extract($postedArray);
		$assigned_users_array = (isset($assigned_users))?explode(';',$assigned_users):'';
		if(!empty($assigned_users_array)){
			foreach($assigned_users_array as $key => $user_id){
				$memberDetail = $db->getUniversalTableData($tablename,$coloum_name_str='*',$otherfields=" and `user_id` = '".$user_id."' and `group_id`= '".$group_id."' ");
				if(empty($memberDetail)){
					$sql	= "insert into `".$tablename."` SET `user_id` = '".$user_id."', `group_id`= '".$group_id."', `date` = '".CURRENT_DATE."' ";
					$insertResult = $db->insert($sql);
				}
			}
			return true;
		}
		return false;		
	}
	
	// function to delete the group data
	function functionDeleteGroupRelatedData($id){
		global $db;
		
		$smsgroupTable    ='sms_groups';
		$smsgroupMemTable ='sms_groups_members';
		
		//deleting all member of thar group
		$sqlMem = "DELETE from `".$smsgroupTable."` WHERE `id` ='".$id."' ";
		$result	= $db->delete($sqlMem);

		//deleting all member of thar group
		$sqlMem = "DELETE from `".$smsgroupMemTable."` WHERE `group_id` ='".$id."' ";
		$result	= $db->delete($sqlMem);

		return $result;		
	}

	//***********/SMS GROUP ADDING FUNCTION ENDS******************

	//Added on 23-07-2014
	function getprojectName($is_project_user){
		global $db;
		$langObj       = new language();
		$projectData   = $langObj->functionGetSetting($tablename='projects', $dmlType='1', $is_project_user);
		if(!empty($projectData)){
			$projectName = str_replace(' ','-',strtoupper(strtolower($projectData['project_name'])));	
		}
		return $projectName;
	}
	
	//Added on 23-07-2014
	function getprojectUsers($projectid){
		global $db;
		$langObj      = new language();
		$projectData  = $langObj->functionGetSetting($tablename='projects', $dmlType='1', $projectid);
		if(!empty($projectData)){
			$projectRelatedUser = implode(',',explode(';', $projectData['assigned_users']));
		}
		return (!empty($projectRelatedUser))?$projectRelatedUser:'0';
	}

}
?>