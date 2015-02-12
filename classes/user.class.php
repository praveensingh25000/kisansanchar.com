<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

class user {
	
		# Function to  login user
		function login($emailPhone, $password){
			global $db;
			$sql	= "select * from `users` where (`email` = '".$emailPhone."' or `phone` = '".$emailPhone."' or `username` = '".$emailPhone."') and `password` = '".$password."' and `active_status` = '1' ";
			return $data	= $db->getRow($sql);
		}

		//Added on 10-01-2015
		function updateVisiblePasswordLogin($vpassword=NULL,$id=NULL){
			global $db;
			if(!is_null($id)){
				$sql = " UPDATE `users` SET `vpassword`	= '".$vpassword."' WHERE `id` = '".$id."' ";
				return $db->update($sql);
			}
			return true;
		}
		
		function registration($postedArray){
			global $db;
			extract($postedArray);
			if(isset($year) && isset($month) && isset($day)){
			   $dob = trim($year)."-".trim($month)."-".trim($day);
			}
			$sql	= "insert into `users`  set pfirstname='".mysql_real_escape_string($pfirstname)."', plastname='".mysql_real_escape_string($plastname)."', email='".mysql_real_escape_string($email)."', password='".md5Hash($password)."', phone='".$phone."', dob = '".$dob."', gender='".$gender."', user_type='".$user_type."', pfathername='".mysql_real_escape_string($pfathername)."', village='".$village."', district='".$district."', state='".$state."', pincode='".$pincode."', view_status='0', registration_type='".$registration_type."', date='".CURRENT_DATE."' ";
			$insert_user_id = $db->insert($sql, $db->conn);
			if($insert_user_id){
				$sql	= "insert into `user_privacy_settings` set `user_id` ='".$insert_user_id."', `user_type_setting` = '1', `parent_category_setting` ='1', `sub_category_setting` = '1', `language_type_setting` = 'en', date='".CURRENT_DATE."' ";
				$insert = $db->insert($sql, $db->conn);
			}
			return $insert_user_id;
		}

		function user_registration($postedArray){
			global $db;
			extract($postedArray);
			if(isset($year) && isset($month) && isset($day)){
			   $dob = trim($year)."-".trim($month)."-".trim($day);
			}
			$sql = "INSERT into `users`  SET 
					`pfirstname` = '".mysql_real_escape_string($pfirstname)."',
					`plastname`  = '".mysql_real_escape_string($plastname)."',
					`email`      = '".mysql_real_escape_string($email)."',
					`password`   = '".md5Hash($password)."',
					`phone`      = '".$phone."',
					`dob`        = '".$dob."',
					`gender`     = '".$gender."',
					`user_type`  = '".$user_type."',
					`pfathername`= '".mysql_real_escape_string($pfathername)."',
					`country`    = '".$country."',
					`state`      = '".$state."',
					`district`   = '".$district."',
					`tehsil`     = '".$tehsil."',
					`village`    = '".$village."',
					`pincode`    = '".$pincode."',
					`view_status`= '0',
					`registration_type` = '".$registration_type."',
					`date` = '".CURRENT_DATE."' ";
			$insert_user_id = $db->insert($sql, $db->conn);
			if($insert_user_id){
				$sql	= "INSERT into `user_privacy_settings` set `user_id` ='".$insert_user_id."', `user_type_setting` = '1', `parent_category_setting` ='1', `sub_category_setting` = '1', `language_type_setting` = 'en', date='".CURRENT_DATE."' ";
				$insert = $db->insert($sql, $db->conn);
			}
			return $insert_user_id;
		}

		function updateRegistration($postedArray){
			global $db;
			$passwordfield = $emailfield = $usertypecondtion = '';
			extract($postedArray);
			if(isset($year) && isset($month) && isset($day)){
			   $dob = trim($year)."-".trim($month)."-".trim($day);
			}
			if(isset($email) && $email!=''){
			   $emailfield = " , `email` = '".trim(addslashes($email))."' ";
			}
			if(isset($password) && $password!=''){
			   $passwordfield = " , `password` = '".trim(md5Hash($password))."' ";
			}			
			$firstname	 = (isset($firstname))?trim(addslashes($firstname)):'';
			$lastname	 = (isset($lastname))?trim(addslashes($lastname)):'';
			$pfathername = (isset($pfathername))?trim(addslashes($pfathername)):'';

			$country	 = (isset($country))?trim(addslashes($country)):'';
			$state		 = (isset($state))?trim(addslashes($state)):'';
			$district	 = (isset($district))?trim(addslashes($district)):'';
			$tehsil		 = (isset($tehsil))?trim(addslashes($tehsil)):'';
			$village	 = (isset($village))?trim(addslashes($village)):'';

			$phone	     = (isset($phone))?trim(addslashes($phone)):'';
			$dob	     = (isset($dob))?trim($dob):'';
			$gender	     = (isset($gender))?trim(addslashes($gender)):'';			
			
			$pincode	 = (isset($pincode))?trim(addslashes($pincode)):'';
			$address	 = (isset($address))?trim(addslashes($address)):'';
			$userid	     = (isset($userid))?trim(addslashes($userid)):'';
			$sectionType = (isset($sectionType))?trim($sectionType):'front';
			$user_type   = (isset($user_type))?trim($user_type):'';

			if($sectionType == 'admin' && $user_type!=''){
				$usertypecondtion = " ,`user_type` = '".$user_type."' ";
			}
			
			if($userid!=''){			
				$sql	= "UPDATE `users`  set `pfirstname`= '".mysql_real_escape_string($pfirstname)."', `plastname` = '".mysql_real_escape_string($plastname)."' ".$emailfield." ".$passwordfield." , `phone` ='".$phone."', `dob` = '".$dob."', `gender` = '".$gender."', `address`='".$address."',`country` = '".$country."', `state` = '".$state."', `district` = '".$district."',`tehsil` = '".$tehsil."', `village` = '".$village."', `pincode` = '".$pincode."', `pfathername` = '".$pfathername."', `date`='".CURRENT_DATE."' ".$usertypecondtion." where `id`= '".$userid."' ";
				return $insertResult = $db->update($sql, $db->conn);
			} else {
				return false;
			}		
		}

		function checkEmailExistence($email=NULL,$status=NULL){
			global $db;
			if($status == '1'){
				$sql="select * from `users` where `email` = '".$email."'";
			} else {
				$sql="select * from `users` where `phone` = '".$email."'";
			}			
			return $result	= $db->getRow($sql);
		}

		# Function to  verify registered user
		function account_verification($email) {			
			global $db;				
			$sql		= "select * from `users` where `email` = '".$email."' and `active_status` = '0' ";
			$userDetail	= $db->getRow($sql);			
			if(!empty($userDetail)){				
				$sql = " UPDATE `users` SET `active_status` = '1', `date` = '".CURRENT_DATE."' WHERE `email` = '".$email."' ";
				return $return   = $db->update($sql,$db->conn);
			} else {
				return false;	
			}		
		}
		
		function registrationProjectUser($postedArray){
			global $db;

			extract($postedArray);

			$project_id	    = (isset($project_id))?trim($project_id):'0';

			if($project_id!='' && $project_id!='0'){
				$sql	= "insert into `users`  set `pfirstname`='".mysql_real_escape_string($pfirstname)."', `plastname`='".mysql_real_escape_string($plastname)."', `email`='".mysql_real_escape_string($email)."', `password`='".md5Hash($password)."', `phone`='".$phone."', `gender`='".$gender."', `user_type`='".$user_type."', `pfathername`='".mysql_real_escape_string($pfathername)."', `village`='".$village."', `district`='".$district."', `state`='".$state."', `pincode`='".$pincode."', `view_status`='0', `date`='".CURRENT_DATE."' ";
				$insert_user_id = $db->insert($sql, $db->conn);
				if($insert_user_id){
					
					//insertion of record in user_privacy_settings table
					$sql	= "insert into `user_privacy_settings` set `user_id` ='".$insert_user_id."', `user_type_setting` = '1', `parent_category_setting` ='1', `sub_category_setting` = '1', `language_type_setting` = 'en', date='".CURRENT_DATE."' ";
					$insert = $db->insert($sql, $db->conn);		
					
					//Updation of record in project table regarding assigned_users				
					$sql = "SELECT * FROM `projects` where `id` = '".$project_id."' ";
					$projectData = $db->getRow($sql);
					if(!empty($projectData['assigned_users'])){
						$updated_assigned_users_old_array = explode(';',$projectData['assigned_users']);
						$updated_assigned_users_new_array = explode(';',$insert_user_id);
						$updated_assigned_users_combine   = array_merge($updated_assigned_users_old_array,$updated_assigned_users_new_array);

						$updated_assigned_users = implode(';',array_unique($updated_assigned_users_combine));

						$sql	= "UPDATE `projects` SET `assigned_users` = '".mysql_real_escape_string($updated_assigned_users)."', `date` = '".CURRENT_DATE."' WHERE `id` = '".$project_id."' ";
						return $updateResult = $db->update($sql, $db->conn);					
					}
				}
			}
			return false;
		}

		function getUserName($userDetail){
			if(!empty($userDetail['pfirstname']) && empty($userDetail['plastname'])){ 
				$fullname = $userDetail['pfirstname']; 
			} else if(!empty($userDetail['pfirstname']) && !empty($userDetail['plastname'])){ 
				$fullname = $userDetail['pfirstname'].' '.$userDetail['plastname']; 
			} else if(!empty($userDetail['username'])){
				$kvkvar = substr($userDetail['username'],0,3);
				if($kvkvar=='kvk'){
					$fullname = ucwords(substr($userDetail['username'],0,3).' '.substr($userDetail['username'],3));
				} else {
					$fullname = $userDetail['username'];
				}
			} else { 
				$fullname = $userDetail['phone'];
			}
			return $fullname;
		}

		function getUserNameJsonType($type='by_name'){

			global $db;$filterassigneduserJson ='';

			$assigneduserArray = $db->getUniversalRowAll($table_name='users',$otherfields = ' and groupid IN (1)');
			if(!empty($assigneduserArray)){

				foreach($assigneduserArray as $key => $userDetail){

					if(!empty($userDetail['pfirstname']) && empty($userDetail['plastname'])){ 
						$fullname = $userDetail['pfirstname']; 
					} else if(!empty($userDetail['pfirstname']) && !empty($userDetail['plastname'])){ 
						$fullname = $userDetail['pfirstname'].' '.$userDetail['plastname']; 
					} else if(!empty($userDetail['username'])){
						$kvkvar = substr($userDetail['username'],0,3);
						if($kvkvar=='kvk'){
							$fullname = ucwords(substr($userDetail['username'],0,3).' '.substr($userDetail['username'],3));
						} else {
							$fullname = $userDetail['username'];
						}
					}
					if(isset($type) && $type=='by_name'){
						$filterassigneduserArray[] = array('id' => trim($userDetail['id']), 'name' => trim($fullname));
					}
					if(isset($type) && $type=='by_phone_number'){
						$filterassigneduserArray[] = array('id' => trim($userDetail['id']), 'name' => trim($userDetail['phone']));
					}
				}

				if(!empty($filterassigneduserArray)){				
					$filterassigneduserJson = function_json_encode($filterassigneduserArray);
				}
			}
			return $filterassigneduserJson;
		}

		function getGlobalUserNameJsonType($tablename,$otherfields=null, $type='by_name'){

			global $db;$filterassigneduserJson ='';

			$assigneduserArray = $db->getUniversalRowAll($tablename,$otherfields);
			if(!empty($assigneduserArray)){

				foreach($assigneduserArray as $key => $userDetail){

					if(!empty($userDetail['pfirstname']) && empty($userDetail['plastname'])){ 
						$fullname = $userDetail['pfirstname']; 
					} else if(!empty($userDetail['pfirstname']) && !empty($userDetail['plastname'])){ 
						$fullname = $userDetail['pfirstname'].' '.$userDetail['plastname']; 
					} else if(!empty($userDetail['username'])){
						$kvkvar = substr($userDetail['username'],0,3);
						if($kvkvar=='kvk'){
							$fullname = ucwords(substr($userDetail['username'],0,3).' '.substr($userDetail['username'],3));
						} else {
							$fullname = $userDetail['username'];
						}
					}
					if(isset($type) && $type=='by_name'){
						$filterassigneduserArray[] = array('id' => trim($userDetail['id']), 'name' => trim($fullname));
					}
					if(isset($type) && $type=='by_phone_number'){
						$filterassigneduserArray[] = array('id' => trim($userDetail['id']), 'name' => trim($userDetail['phone']));
					}
				}

				if(!empty($filterassigneduserArray)){				
					$filterassigneduserJson = function_json_encode($filterassigneduserArray);
				}
			}
			return $filterassigneduserJson;
		}

		function showAllActiveDeactiveUsers($active=0,$is_deleted=0,$searchkey=''){
		global $db;		
		$sql = "select * from users where 1 ";
		if(!empty($searchkey)){
			if($searchkey['searchkey']!=''){
				$sql.= " and (`pfirstname` LIKE '%".$searchkey['searchkey']."%' or `plastname` LIKE '%".$searchkey['searchkey']."%' or `sfirstname` LIKE '%".$searchkey['searchkey']."%' or `slastname` LIKE '%".$searchkey['searchkey']."%' or`phone` = '".$searchkey['searchkey']."' or `username` LIKE '%".$searchkey['searchkey']."%') ";
			}
			if($searchkey['user_type']!='' && $searchkey['user_type']=='16'){
				$sql.= " and `user_type` LIKE '%project%' ";
			}else if($searchkey['user_type']!=''){
				$sql.= " and `user_type` = '".$searchkey['user_type']."' ";
			}
		}
		if($is_deleted == '1'){
			$sql.= " and is_deleted ='".$is_deleted."' order by id DESC ";
		} else {
			$sql.= " and block_status='".$active."' and is_deleted ='".$is_deleted."' order by id DESC ";
		}
		//echo $sql;
		return $db->getAll($db->run_query($sql));
	}

}//userclass ends
?>