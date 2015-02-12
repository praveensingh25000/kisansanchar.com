<?php
/******************************************
* @Modified on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

class project {
	
	function addProjectLocation($postedArray){
		global $db;$succuss=array();
		extract($postedArray);
		if(!empty($country)){
			foreach($country as $countryone){
				$sql = "SELECT * FROM `projects_locations` where `project_id`='".$project_id."' and `primary_id`='".getElement($countryone,0,'-')."' and `parent_id`='".getElement($countryone,1,'-')."' and `type`='c' ";
				$locationData = $db->getRow($sql);
				if(empty($locationData)){
					$sql	= "INSERT into `projects_locations` SET `project_id`='".$project_id."', `primary_id`='".getElement($countryone,0,'-')."', `parent_id`='".getElement($countryone,1,'-')."', `type`='c', `added_on`= '".CURRENT_DATE."' ";
					$succuss[] = $db->insert($sql);
				}
			}
		}
		if(!empty($state)){
			foreach($state as $stateone){
				$sql = "SELECT * FROM `projects_locations` where `project_id`='".$project_id."' and `primary_id`='".getElement($stateone,0,'-')."' and `parent_id`='".getElement($stateone,1,'-')."' and `type`='s' ";
				$locationData = $db->getRow($sql);
				if(empty($locationData)){
					$sql	= "INSERT into `projects_locations` SET `project_id`='".$project_id."', `primary_id`='".getElement($stateone,0,'-')."', `parent_id`='".getElement($stateone,1,'-')."', `type`='s', `added_on`= '".CURRENT_DATE."' ";
					$succuss[] = $db->insert($sql);
				}
			}
		}
		if(!empty($district)){
			foreach($district as $districtone){
				$sql = "SELECT * FROM `projects_locations` where `project_id`='".$project_id."' and `primary_id`='".getElement($districtone,0,'-')."' and `parent_id`='".getElement($districtone,1,'-')."' and `type`='d' ";
				$locationData = $db->getRow($sql);
				if(empty($locationData)){
					$sql	= "INSERT into `projects_locations` SET `project_id`='".$project_id."', `primary_id`='".getElement($districtone,0,'-')."', `parent_id`='".getElement($districtone,1,'-')."', `type`='d', `added_on`= '".CURRENT_DATE."' ";
					$succuss[] = $db->insert($sql);
				}
			}
		}
		if(!empty($tehsil)){
			foreach($tehsil as $tehsilone){
				$sql = "SELECT * FROM `projects_locations` where `project_id`='".$project_id."' and `primary_id`='".getElement($tehsilone,0,'-')."' and `parent_id`='".getElement($tehsilone,1,'-')."' and `type`='t' ";
				$locationData = $db->getRow($sql);
				if(empty($locationData)){
					$sql	= "INSERT into `projects_locations` SET `project_id`='".$project_id."', `primary_id`='".getElement($tehsilone,0,'-')."', `parent_id`='".getElement($tehsilone,1,'-')."', `type`='t', `added_on`= '".CURRENT_DATE."' ";
					$succuss[] = $db->insert($sql);
				}
			}
		}
		if(!empty($village)){
			foreach($village as $villageone){
				$sql = "SELECT * FROM `projects_locations` where `project_id`='".$project_id."' and `primary_id`='".getElement($villageone,0,'-')."' and `parent_id`='".getElement($villageone,1,'-')."' and `type`='v' ";
				$locationData = $db->getRow($sql);
				if(empty($locationData)){
					$sql	= "INSERT into `projects_locations` SET `project_id`='".$project_id."', `primary_id`='".getElement($villageone,0,'-')."', `parent_id`='".getElement($villageone,1,'-')."', `type`='v', `added_on`= '".CURRENT_DATE."' ";
					$succuss[] = $db->insert($sql);
				}
			}
		}
		return $succuss;
	}

	function getUniversalContentData($table_name=null,$otherfields=null) {
		global $db;
		$contentDataArray = array();
		$sql = "SELECT * FROM `".$table_name."` where 1 ".$otherfields." ";
		$contentData = $db->getAll($db->run_query($sql));
	    if(!empty($contentData)){
			foreach($contentData as $content){
				$contentDataArray[$content['parent_id']][$content['id']] = $content;
			}
		}
		return $contentDataArray;
	}

	function getParentName($table_name='india',$id=null){
		global $db;
		$sql  = "SELECT * FROM `".$table_name."` where `id` = '".$id."' ";
		$data = $db->getRow($sql);
		return (!empty($data['name']))?trim(strtoupper($data['name'])):'Name';
	}

	function getProjectLocationOne($project_id){
		global $db;$villageStr ='';
		$sql= "SELECT * FROM `projects_locations` where `project_id` = '".$project_id."' and `type`='v' ";
		$data = $db->getAll($db->run_query($sql));
		return $villageStr = (!empty($data))?trim(getImploded(',',$db->getUniversalFormattedArray1D($data,'primary_id'))):'0';
	}

	function getProjectAssociatedGloblaData($tablename='projects_locations',$project_id='1',$contentType='s',$type='by_name',$returnType='JSON'){

		global $db;
		$villageStr = $filterassigneduserJson='';
		$filterassigneduserArray = $assigneduserArray = array();
		$villageStr = project::getProjectLocationOne($project_id);

		if(isset($villageStr)){
			if($contentType == 's'){
				$sql  = "SELECT * FROM `users` where `user_type` = '2' and `groupid` = '1' ";
			}
			if($contentType == 'f'){
				$sql  = "SELECT * FROM `users` where `user_type` = '1' and `village` IN (".$villageStr.") and `groupid` = '1' ";		
			}
			$assigneduserArray = $db->getAll($db->run_query($sql));
			if(!empty($assigneduserArray)){
				foreach($assigneduserArray as $key => $userDetail){
					$fullname = getUserName($userDetail,$associated='both');
					if(isset($type) && $type=='by_name'){
						$filterassigneduserArray[] = array('id' => trim($userDetail['id']), 'name' => trim($fullname));
					}
					if(isset($type) && $type=='by_phone_number'){
						$fullname = getUserName($userDetail);
						$filterassigneduserArray[] = array('id' => trim($userDetail['id']), 'name' => trim($userDetail['phone'].'('.$fullname.')'));
					}
				}
			}
			if(!empty($filterassigneduserArray)){				
				if($returnType='JSON'){
					return $filterassigneduserJson = function_json_encode($filterassigneduserArray);
				}else{
					return $filterassigneduserArray;
			    }				
			}
		}
		return false;
	}

	function functionaddProjectAssignedContent($tablename='projects_users',$postedArray){
		global $db;
		extract($postedArray);
		$assigned_users	   = (!empty($assigned_users))?(explode(';',$assigned_users)):array();		
		$project_id	       = (isset($project_id))?trim($project_id):'0';
		$project_user_type = (isset($project_user_type))?trim($project_user_type):'1';
		if(!empty($project_id) && !empty($assigned_users)){			
			foreach($assigned_users as $user_id){
			    $sql = "SELECT * FROM `projects_users` where `project_id` = '".$project_id."' and `project_user_type` = '".$project_user_type."' and `user_id` = '".$user_id."' ";
				$projectData = $db->getRow($sql);
				if(empty($projectData)){
					$sql = "INSERT INTO `projects_users` SET `project_id` = '".$project_id."', `project_user_type` = '".$project_user_type."', `user_id` = '".$user_id."', `added_on` = '".CURRENT_DATE."' ";
					$db->insert($sql);
					$db->updateUniversalRow($table_name='users',$coloum_name_str=" `is_project_user` = '".$project_id."' ",$updated_on_field='id',$user_id,$otherfields=null);
				}
			}
			return true;
		}
		return false;		
	}

	function functionUpdateProjectAssignedUserCSV($userMobileDataArray=array(),$postedArray=null){
		
		global $db;$succuss = array();

		extract($postedArray);
		
		if(!empty($userMobileDataArray) && !empty($project_id) && !empty($project_user_type)){			
			$villageStr = project::getProjectLocationOne($project_id);			
			//Checking user if exits or not
			foreach($userMobileDataArray as $data){				
				$sqluser = "select * from `users` where `username` = '".$data[2]."' or `phone`= '".$data[2]."' ";
				$userData = $db->getRow($sqluser);
				if(empty($userData)){
					$sql = "INSERT into `users`  SET `pfirstname`='".mysql_real_escape_string($data[0])."', `plastname`='".mysql_real_escape_string($data[1])."', `registration_type` = '1', `password` ='".md5Hash('kisansanchar')."', `username`='".$data[2]."', `phone`='".$data[2]."', `groupid` = '1', `user_type`='1', `active_status` = '1', `date` = '".CURRENT_DATE."' ";
					$insert_user_id = $db->insert($sql);
					if($insert_user_id){				
						$sql_setting	= "INSERT into `user_privacy_settings` SET `user_id` ='".$insert_user_id."', `user_type_setting` = '1', `parent_category_setting` ='1', `sub_category_setting` = '1', `date` = '".CURRENT_DATE."'  ";
						$db->insert($sql_setting);
					}
					$assigned_users[$insert_user_id] =  $insert_user_id;
					$succuss['registered'][]         =  $insert_user_id;
				}else{
					$assigned_users[$userData['id']] =  $userData['id'];
				}				
			}

			if(!empty($assigned_users)){
				foreach($assigned_users as $user_id){
					$existData = project::checkprojectLoctionUserExist($villageStr,$user_id);
					if(!empty($existData)){
						$sql = "SELECT * FROM `projects_users` where `project_id` = '".$project_id."' and `project_user_type` = '".$project_user_type."' and `user_id` = '".$user_id."' ";
						$projectData = $db->getRow($sql);
						if(empty($projectData)){
							$sql = "INSERT INTO `projects_users` SET `project_id` = '".$project_id."', `project_user_type` = '".$project_user_type."', `user_id` = '".$user_id."', `added_on` = '".CURRENT_DATE."' ";
							$db->insert($sql);
							$db->updateUniversalRow($table_name='users',$coloum_name_str=" `is_project_user` = '".$project_id."' ",$updated_on_field='id',$user_id,$otherfields=null);
							$succuss['in'][]   = $user_id;
						}else{
							$succuss['have'][] = $user_id;
						}
					}else{
						$succuss['out'][]      = $user_id;
					}
				}
			}
		}
		return $succuss;
	}

	function checkprojectLoctionUserExist($villageStr=null,$user_id=null){
		global $db;	
		$sql = "SELECT * FROM `users` WHERE `village` IN (".$villageStr.") AND `id` = '".$user_id."' ";
		return $db->getRow($sql);
	}

	function SelectFarmerAllUserProjectDetail($project_id,$user_type){
		global $db;		
		$sql = "SELECT * FROM `projects_users` where `project_id` = '".$project_id."' and `project_user_type` = '".$user_type."' and `is_active` = '1' ";
		$contentData = $db->getAll($db->run_query($sql));
		$userstring = (!empty($contentData))?trim(getImploded(',',$db->getUniversalFormattedArray1D($contentData,'user_id'))):'0';
		$sql = "SELECT u.id as user_id, u.phone as phone, u.gender, u.user_type, u.pfirstname,u.plastname,u.sfirstname,u.slastname,u.pfathername,u.sfathername,usc.name as country,uss.name as state,usd.name as district,ust.name as tehsil, usv.name as village 
		FROM `users` u
		JOIN `india` usc ON usc.id = u.country 
		JOIN `india` uss ON uss.id = u.state 
		JOIN `india` usd ON usd.id = u.district
		JOIN `india` ust ON ust.id = u.tehsil
		JOIN `india` usv ON usv.id = u.village
		WHERE 1
		and u.id IN (".$userstring.") ";
		return $db->getAll($db->run_query($sql));
	}

	//Added on 23-07-2014
	function getprojectUsers($project_id,$project_user_type='2'){
		global $db;
		$sql = "SELECT * FROM `projects_users` where `project_id` = '".$project_id."' and `project_user_type` = '".$project_user_type."' and `is_active` = '1' ";
		$contentData = $db->getAll($db->run_query($sql));
		$projectRelatedUser = (!empty($contentData))?trim(getImploded(',',$db->getUniversalFormattedArray1D($contentData,'user_id'))):'0';
		return (!empty($projectRelatedUser))?$projectRelatedUser.",".FRONT_USER_ID:FRONT_USER_ID;
	}

	function checkProjectUser($user_id){
		global $db;
		$sql = "SELECT * FROM `projects_users` where `user_id` = '".$user_id."' ";
		$data = $db->getRow($sql);
		return (!empty($data))?'1':'0';
	}

	function getProjectUserId($user_id){
		global $db;
		$sql = "SELECT * FROM `projects_users` where `user_id` = '".$user_id."' ";
		$data = $db->getRow($sql);
		return (!empty($data))?trim($data['project_id']):'0';
	}

	function getProjectSenderName($id){
		global $db;
		$sql = "SELECT * FROM `projects` where `id` = '".$id."' ";
		$data = $db->getRow($sql);
		return (!empty($data['sender_name']))?trim($data['sender_name']):'ECCAFS';
	}

	function getProjectLocation($tablename='projects_locations',$project_id){
		global $db;
		$sql = "SELECT * FROM `projects_locations` where `project_id`='".$project_id."' and `is_active`='1' and `type`='v' ";
		$locationDataArray = $db->getAll($db->run_query($sql));
		if(!empty($locationDataArray)){
			foreach($locationDataArray as $location){
				if(!empty($location['primary_id'])){
					$sqlvillage  = "SELECT * FROM `india` where `id` = '".$location['primary_id']."' ";
					$villageData = $db->getRow($sqlvillage);
					$location['village'] = $villageData['name'];
				}
				if(!empty($location['parent_id'])){
					$sqltehsil  = "SELECT * FROM `india` where `id` = '".$location['parent_id']."' ";
					$tehsilData = $db->getRow($sqltehsil);
					$location['tehsil'] = $tehsilData['name'];
					if(!empty($tehsilData['parent_id'])){
					   $sqldistrict  = "SELECT * FROM `india` where `id` = '".$tehsilData['parent_id']."' ";
					   $districtData = $db->getRow($sqldistrict);
					   $location['district'] = $districtData['name'];
					   if(!empty($districtData['parent_id'])){
						   $sqlstate = "SELECT * FROM `india` where `id` = '".$districtData['parent_id']."' ";
						   $stateData = $db->getRow($sqlstate);
					       $location['state'] = $stateData['name'];
						   if(!empty($stateData['parent_id'])){
							   $sqlcountry = "SELECT * FROM `india` where `id` = '".$stateData['parent_id']."' ";
							   $countryData = $db->getRow($sqlcountry);
							   $location['country'] = $countryData['name'];
						   }
					   }
					}
				}
				$locationData[$location['country']][$location['state']][$location['district']][$location['tehsil']][$location['id']] = $location['id'];
				$locationData[$location['country']][$location['state']][$location['district']][$location['tehsil']][$location['id']] = $location['village'];
			}		
		}
		return $locationData;	
	}

	function getStartingEndingDateofReport($project_id=null,$languageArray=null){
		global $db;$reportDate = $minmaxdate = $maxmin = array();
		foreach($languageArray as $lang){
			$sql = "select MIN(broadcast_date) as `starting` from `message_".$lang['name']."` where `project_id` = '".$project_id."' and `status` = '1' ";
			$data = $db->getRow($sql);
			if(!empty($data['starting'])){
				$reportDate[] = $data;
			}
			$sql = "select MAX(broadcast_date) as `ending` from `message_".$lang['name']."` where `project_id` = '".$project_id."' and `status` = '1' ";
			$data = $db->getRow($sql);
			if(!empty($data['ending'])){
				$reportDate[] = $data;
			}
		}
		foreach($reportDate as $data){
			if(!empty($data['starting'])){
				$minmaxdate['starting'][] = $data['starting'];
			}
			if(!empty($data['ending'])){
				$minmaxdate['ending'][]   = $data['ending'];
			}
		}
		if(!empty($minmaxdate)){
			$maxmin['starting'] = show_date(MIN($minmaxdate['starting']));
			$maxmin['ending']   = show_date(MAX($minmaxdate['ending']));
		}
		return $maxmin;
	}

	function updateActiveInactiveProjectUser($tablename="projects_users", $project_id, $user_id, $status){
		global $db;
		$sql  = "UPDATE `".$tablename."` SET `is_active`='".$status."' WHERE `user_id` = '".$user_id."' and `project_id` = '".$project_id."' ";
		return $return   = $db->update($sql);
	}

	function getProjectLocationReport($project_id=NULL, $type=NULL, $contentid=NULL){
		global $db;
		$sql= "SELECT pl.id as pl_id,pl.*,ind.id as ind_id,ind.* FROM `projects_locations` pl JOIN `india` ind ON pl.primary_id = ind.id WHERE pl.project_id = '".$project_id."' and pl.type = '".$type."' AND pl.parent_id = '".$contentid."' ";
		return $db->getAll($db->run_query($sql));

	}

}
?>