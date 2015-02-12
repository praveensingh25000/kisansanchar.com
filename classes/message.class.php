<?php
/******************************************
* @Modified on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

class message {
	
	function functionAddSmsAndriodMsg($postedArray){

		global $db;
		extract($postedArray);
		$andriodcontenttype_condition = $message_condition = $content_type = $message_file = $categoryCondition = '';

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
			$videoembedObj  = new videoEmbed();
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

		if(isset($select_upload_type) && $select_upload_type=='txt'){
			$message_condition = " `content_type` = '".trim($select_upload_type)."', ";
		}

		if(!isset($select_upload_type) && isset($message_type) && $message_type=='andriod'){
			$andriodcontenttype_condition = " `content_type` = '".trim($message_type)."', ";
		}

		if(!isset($language_checked)){ $language_type = 'en'; }
		mysql_set_charset('utf8');
		if(date('A',strtotime($date))=='AM'){
			$content_time = 'Morning';
		}else{
			$content_time = 'Evening';
		}

		mysql_query('SET character_set_results=utf8');       
		mysql_query('SET names=utf8');       
		mysql_query('SET character_set_client=utf8');       
		mysql_query('SET character_set_connection=utf8');
		mysql_query('SET collation_connection=utf8_general_ci'); 

		$sql	= "INSERT into `message_".$language_type."` SET `project_id`='".$project_id."', `user_id`='".$user_id."', `status_type`='".$status_type."', `user_type`='".$user_type."', `message_subject`='".mysql_real_escape_string($message_subject)."', `message`='".addslashes($message)."', `message_type`='".trim($message_type)."', ".$message_condition."  ".$categoryCondition." ".$andriodcontenttype_condition." `language_type`='".trim($language_type)."', `message_tag`='".mysql_real_escape_string($message_tag)."', `content_time` = '".$content_time."', `date`= '".$date."' ";
		$inserted_msg_id  = $db->insert($sql);
		if($inserted_msg_id){
			$sqlupdate	= "UPDATE  `message_".$language_type."`  SET  `array_key_element` = 'message_".$language_type.'_'.$inserted_msg_id."'  WHERE `id` = '".$inserted_msg_id."' ";
			$db->update($sqlupdate);
		}
		return $inserted_msg_id;
	}

	function functionAddVoiceFileCSVFile($msg_id, $wave_file, $csv_file, $user_group_str, $user_sub_group_str, $user_sub_group_other_str, $job_type, $country, $state, $district, $language_type, $date){
		global $db;
		$sql = "INSERT into `message_ordinates_".$language_type."` SET `msg_id`='".$msg_id."', `wave_file`='".$wave_file."', `csv_file`='".$csv_file."', `user_group`='".$user_group_str."', `user_sub_group`='".$user_sub_group_str."', `user_sub_group_other`='".$user_sub_group_other_str."', `job_type`='".$job_type."', `country`='".$country."', `state`='".$state."', `district`='".$district."', date='".$date."' ";
		if($db->insert($sql)){
			$db->updateUniversalRow($table_name="message_".$language_type."",$coloum_name_str=" `message_file` = '".$wave_file."', `content_type` = '".getQuickExtension($wave_file)."' ",$updated_on_field='id', $msg_id, $otherfields=null);
		}
		return true;
	}

	function functionAddVoiceFileSMSCSVFile($msg_id, $wave_file, $csv_file, $user_group_str, $user_sub_group_str, $user_sub_group_other_str, $job_type, $country, $state, $district, $language_type, $date){
		global $db;
		$sql = "INSERT into `message_ordinates_".$language_type."` SET `msg_id`='".$msg_id."', `wave_file`='".$wave_file."', `csv_file`='".$csv_file."', `user_group`='".$user_group_str."', `user_sub_group`='".$user_sub_group_str."', `user_sub_group_other`='".$user_sub_group_other_str."', `job_type`='".$job_type."', `country`='".$country."', `state`='".$state."', `district`='".$district."', date='".$date."' ";
		if($db->insert($sql)){
			$db->updateUniversalRow($table_name="message_".$language_type."",$coloum_name_str=" `message_file` = '".$wave_file."', `content_type` = 'txt' ",$updated_on_field='id', $msg_id, $otherfields=null);
		}
		return true;
	}

	function selectActiveMessageAndriodPaginationArrayAdmin($tablename='message', $message_type=null, $language_type=null, $day=null, $month=null, $year=null, $status='0',$user_privacy_settings_sql=null, $startLimit='0', $endLimit='10', $othercondition=null,$orderby='order by date DESC'){

		global $db;

		$messageData = $messageArray = array();

		$tablenamemain = "".$tablename.'_'.$language_type."";

		mysql_set_charset('utf8');		
		if(!is_numeric($message_type)){
			$sql = "select DISTINCT(array_key_element) from `".$tablenamemain."` where 1 ";
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
				if(isset($status) && $status=='1'){
					$sql.= " and DAY(broadcast_date) = '".$day."'  ";
				}else{
					$sql.= " and DAY(date) = '".$day."'  ";
				}
			}
			if(isset($month) && $month!=''){
				if(isset($status) && $status=='1'){
					$sql.= " and MONTH(broadcast_date) = '".$month."'  ";
				}else{
					$sql.= " and MONTH(date) = '".$month."'  ";
				}
			}
			if(isset($year) && $year!=''){
				if(isset($status) && $status=='1'){
					$sql.= " and YEAR(broadcast_date) = '".$year."'  ";
				}else{
					$sql.= " and YEAR(date) = '".$year."'  ";
				}
			}
			if(isset($othercondition) && $othercondition!=''){
				$sql.= " and ".$othercondition."  ";
			}
			if($startLimit!='' && $endLimit!=''){
				if(isset($status) && $status=='1'){
					$sql.= " order by broadcast_date  LIMIT ".$startLimit.",".$endLimit." ";
				}else{
					$sql.= " ".$orderby."  LIMIT ".$startLimit.",".$endLimit." ";
				}
			}

			//echo $sql;

			$messageArray = $db->getAll($db->run_query($sql));
			if(!empty($messageArray)){
				foreach($messageArray as $messageDataone){
					$msgData    =  $db->getUniversalRow($table_name=$tablenamemain,$coloum_name_str='*',$updated_on_field='id',funExplode($messageDataone),$otherfields=null);	
					if(!empty($msgData)){						
						$messageData[$messageDataone['array_key_element']] = $msgData;
					}					
				}
			}
			return $messageData;
		} else {
			$sql	= "select * from `".$tablename."` where `id` = '".$message_type."' ";
			return $db->getRow($sql);
		}
	}

	function selectActiveMessageAndriodPaginationArrayFront($tablename='message', $message_type=null, $language_type=null, $day=null, $month=null, $year=null, $status='1,5',$user_privacy_settings_sql=null, $startLimit='0', $endLimit='10', $othercondition=null,$orderby='order by date DESC'){

		global $db;
		$messageData = $messageArray = array();
		$tablenamemain = "".$tablename.'_'.$language_type."";

		mysql_set_charset('utf8');		
		if(!is_numeric($message_type)){
			$sql = "select DISTINCT(array_key_element) from `".$tablenamemain."` where 1 ";
			if(isset($message_type) && $message_type!='all'){
				$sql.= " and  `message_type` = '".$message_type."' ";
			}
			if(isset($language_type) && $language_type!='all'){
				$sql.= " and  `language_type` = '".$language_type."' ";
			}
			if(isset($status) && $status!='all'){				
				$sql.= " and  `status` IN (".$status.") ";								
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
			if(isset($othercondition) && trim($othercondition)!=''){
				$sql.= " and ".$othercondition."  ";
			}
			if($startLimit!='' && $endLimit!=''){
				$sql.= " ".$orderby."  LIMIT ".$startLimit.",".$endLimit." ";
			}

			//echo $sql;

			$messageArray = $db->getAll($db->run_query($sql));
			if(!empty($messageArray)){
				foreach($messageArray as $messageDataone){
					$msgData    =  $db->getUniversalRow($table_name=$tablenamemain,$coloum_name_str='*',$updated_on_field='id',funExplode($messageDataone),$otherfields=null);	
					if(!empty($msgData)){						
						$messageData[$messageDataone['array_key_element']] = $msgData;
					}					
				}
			}
			return $messageData;
		} else {
			$sql	= "select * from `".$tablename."` where `id` = '".$message_type."' ";
			return $db->getRow($sql);
		}
	}

	function selectActiveMessageAndriodPaginationArrayFrontMyDashboard($tablename='message', $message_type=null, $language_type=null, $day=null, $month=null, $year=null, $status='1,5',$user_privacy_settings_sql=null, $startLimit='0', $endLimit='10', $othercondition=null,$orderby='order by date DESC'){

		global $db;
		$messageData = $messageArray = array();
		$tablenamemain = "".$tablename.'_'.$language_type."";

		mysql_set_charset('utf8');		
		if(!is_numeric($message_type)){
			$sql = "select DISTINCT(array_key_element) from `".$tablenamemain."` where 1 ";
			if(isset($message_type) && $message_type!='all'){
				$sql.= " and  `message_type` = '".$message_type."' ";
			}
			if(isset($language_type) && $language_type!='all'){
				$sql.= " and  `language_type` = '".$language_type."' ";
			}
			if(isset($status) && $status!='all'){				
				$sql.= " and  `status` IN (".$status.") ";								
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
			if(isset($othercondition) && trim($othercondition)!=''){
				$sql.= " and ".$othercondition."  ";
			}
			if($startLimit!='' && $endLimit!=''){
				$sql.= " ".$orderby."  LIMIT ".$startLimit.",".$endLimit." ";
			}

			//echo $sql;

			$messageArray = $db->getAll($db->run_query($sql));
			if(!empty($messageArray)){
				foreach($messageArray as $messageDataone){
					$msgData    =  $db->getUniversalRow($table_name=$tablenamemain,$coloum_name_str='*',$updated_on_field='id',funExplode($messageDataone),$otherfields=null);	
					if(!empty($msgData)){						
						$messageData[$messageDataone['array_key_element']] = $msgData;
					}					
				}
			}
			return $messageData;
		} else {
			$sql	= "select * from `".$tablename."` where `id` = '".$message_type."' ";
			return $db->getRow($sql);
		}
	}

	function getAllUserSelectedGroup($user_group,$type='user_group'){
		global $db;
		$userDetailArray = array();
		if($type=='user_group'){
			$sql = "SELECT u.* from `sms_groups_members` sgm JOIN `users` u on sgm.user_id = u.id WHERE sgm.group_id IN (".$user_group.") order by u.id DESC ";
			$userData = $db->getAll($db->run_query($sql));
			if(!empty($userData)){
				foreach($userData as $users){
					$userArray[] = $users['phone'];
				}
				$userDetailArray = array_unique($userArray);
			}
		}
		if($type=='phone'){
			$sqlinnerone     = "select * from `users` where `phone` IN (".$user_group.") ";
			$userData = $db->getAll($db->run_query($sqlinnerone));
			if(!empty($userData)){
				foreach($userData as $users){
					$userArray[] = $users['phone'];
				}
				$userDetailArray = array_unique($userArray);
			}
		}
		return $userDetailArray;
	}

	function functionUpdateVoiceSmsMsg($postedArray){
		global $db;
		extract($postedArray);
		if($msg_id!='' && $msg_id!='0'){
			$sql	= "UPDATE `message_".$language_type."` SET `message`='".addslashes($message)."', `message_subject`='".$message_subject."', `language_type`='".trim($language_type)."', `message_tag`='".mysql_real_escape_string($message_tag)."', `update_on`= '".CURRENT_DATE."' WHERE `id` = '".$msg_id."' ";
			return $db->update($sql);
		}
		return false;
	}

	function functionUpdateSendVoiceSmsMsg($postedArray){
		global $db, $URL_SITE,$DOC_ROOT;

		$succuss = $userDetail = array();	
		
		$user_list = $user_sub_group = $sub_group_other = $csv_file = $csv_path = $audio_file = $audio_path = $useridStr = '';

		$responseCode ='0';

		$host   		= VOICE_HOST_NAME;
		$port			= VOICE_PORT;
		$username		= VOICE_USERNAME;
		$password		= VOICE_PASSWORD;	

		extract($postedArray);

		if($msg_id!='' && $msg_id!='0'){
			$sql	= "UPDATE `message_".$language_type."` SET `message`='".addslashes($message)."', `message_subject`='".$message_subject."', `language_type`='".trim($language_type)."', `message_tag`='".mysql_real_escape_string($message_tag)."', `update_on`= '".CURRENT_DATE."' WHERE `id` = '".$msg_id."' ";
			$db->update($sql, $db->conn);	

			$msgDetail        = $db->getUniversalRow($table_name="message_".$language_type."",$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$msg_id,$otherfields=null);

			if(isset($msgDetail['message_type']) && $msgDetail['message_type']=='sms' && isset($msgDetail['content_type']) && $msgDetail['content_type']=='wav'){

				//User of this Message
				$sqlinnerfirst = "select * from `message_ordinates_".$language_type."` where `msg_id` = '".$msg_id."' ";
				$messageOrdinates = $db->getRow($sqlinnerfirst);
				if(!empty($messageOrdinates)){

					if($messageOrdinates['csv_file']!=''){
						$audio_path     = $URL_SITE.'/uploads/temp/'.$messageOrdinates['wave_file'];
						$csv_path       = $URL_SITE.'/uploads/temp/'.$messageOrdinates['csv_file'];
						$job_type       = $messageOrdinates['job_type'];

						$audiouploadObj			 = new AudioUpload($host, $username, $password, $audio_path);
						$voice_clip_ref_no		 = $audiouploadObj->Submit();

						$csvuploadObj            = new CSVUpload($host, $username, $password, $csv_path);
						$dest_csv_path_ref_no    = $csvuploadObj->Submit();

						$audiosmsObj			 = new AudioSms ($host, $username, $password, $job_type, $dest_csv_path_ref_no, $voice_clip_ref_no);
						$responseCode			 = $audiosmsObj->Submit();
					}

					if($messageOrdinates['csv_file']==''){
						$audio_path     = $URL_SITE.'/uploads/temp/'.$messageOrdinates['wave_file'];
						$job_type       = $messageOrdinates['job_type'];

						$msgObj		    = new message();
						if(!empty($messageOrdinates['user_group'])){
							$userDetailArray[] = $msgObj->getAllUserSelectedGroup($messageOrdinates['user_group'],$type='user_group');
						}
						if(!empty($messageOrdinates['user_sub_group_other'])){
							$userDetailArray[] = $msgObj->getAllUserSelectedGroup($messageOrdinates['user_sub_group_other'],$type='phone');
						}
						if(!empty($userDetailArray)){
							foreach($userDetailArray as $key => $useroneAll){
								set_time_limit(0);	
								foreach($useroneAll as $key => $userone){
									$userDetail[$userone] = $userone;
								}
							}
							$user_list = implode(',', $userDetail);
							if(isset($user_list)){						
								$audiouploadObj		= new AudioUpload($host, $username, $password,	$audio_path);
								$voice_clip_ref_no	= $audiouploadObj->Submit();

								$audiosmsObj	    = new AudioSms ($host, $username, $password, $job_type,		$user_list, $voice_clip_ref_no);
								$responseCode	    = $audiosmsObj->Submit();
							}
						}
					}

					if($responseCode == '3001'){	
						//Coping file from temp to audios			
						$audio_path_tmp = $DOC_ROOT.'/uploads/temp/'.$messageOrdinates['wave_file'];
						$audio_path_original=$DOC_ROOT.'/uploads/audios/'.$messageOrdinates['wave_file'];
						if(copy($audio_path_tmp,$audio_path_original)){
							unlink($audio_path_tmp);
						}
						//UPDATING MSG STATUS
						$sql	= "UPDATE `message_".$language_type."` SET `status`='5', `broadcast_date`= '".CURRENT_DATE."' WHERE `id` = '".$msg_id."' ";
						$db->update($sql);
					}				
				}				
			}			
		}		
		return $responseCode;
	}

	function functionSendVoiceSmsMsg($tablename,$msg_id){
		global $db, $URL_SITE,$DOC_ROOT;
		$succuss        = $userDetail = array();		
		$user_list      = $user_sub_group = $sub_group_other = $csv_file = $csv_path = $audio_file = $audio_path     = '';

		$responseCode   = '0';
		$host   		= VOICE_HOST_NAME;
		$port			= VOICE_PORT;
		$username		= VOICE_USERNAME;
		$password		= VOICE_PASSWORD;	
		
		$msgDetail      = $db->getUniversalRow($tablename,$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$msg_id,$otherfields=null);

		if(!empty($msgDetail)){

			$language_type = $msgDetail['language_type'];

			//User of this Message
			$sqlinnerfirst = "select * from `message_ordinates_".$language_type."` where `msg_id` = '".$msg_id."' ";
			$messageOrdinates = $db->getRow($sqlinnerfirst);
			if(!empty($messageOrdinates)){

				if($messageOrdinates['csv_file']!=''){
					$audio_path			  = $URL_SITE.'/uploads/temp/'.$messageOrdinates['wave_file'];
					$csv_path			  = $URL_SITE.'/uploads/temp/'.$messageOrdinates['csv_file'];
					$job_type			  = $messageOrdinates['job_type'];

					set_time_limit(0);	

					$audiouploadObj		  = new AudioUpload($host, $username, $password, $audio_path);
					$voice_clip_ref_no	  = $audiouploadObj->Submit();

					set_time_limit(0);	

					$csvuploadObj         = new CSVUpload($host, $username, $password, $csv_path);
					$dest_csv_path_ref_no = $csvuploadObj->Submit();

					set_time_limit(0);	

					$audiosmsObj		  = new AudioSms ($host, $username, $password, $job_type, $dest_csv_path_ref_no, $voice_clip_ref_no);
					$responseCode		  = $audiosmsObj->Submit();

					set_time_limit(0);	
				}

				if($messageOrdinates['csv_file']==''){
					$audio_path     = $URL_SITE.'/uploads/temp/'.$messageOrdinates['wave_file'];
					$job_type       = $messageOrdinates['job_type'];

					$msgObj		    = new message();
					if(!empty($messageOrdinates['user_group'])){
						$userDetailArray[] = $msgObj->getAllUserSelectedGroup($messageOrdinates['user_group'],$type='user_group');
					}

					set_time_limit(0);	

					if(!empty($messageOrdinates['user_sub_group_other'])){
						$userDetailArray[] = $msgObj->getAllUserSelectedGroup($messageOrdinates['user_sub_group_other'],$type='phone');
					}

					set_time_limit(0);	

					if(!empty($userDetailArray)){
						foreach($userDetailArray as $key => $useroneAll){
							foreach($useroneAll as $key => $userone){
								$userDetail[$userone] = $userone;
							}
						}
						$audiouploadObj		= new AudioUpload($host, $username, $password, $audio_path);
						$voice_clip_ref_no	= $audiouploadObj->Submit();
						foreach($userDetail as $mobile){	
							set_time_limit(0);	
							$audiosmsObj	= new AudioSms ($host, $username, $password, $job_type, $mobile, $voice_clip_ref_no);
						    $responseCode	= $audiosmsObj->Submit();
						}
				    }
				}
			}

			if($responseCode == '3001'){		
				//UPDATING MSG STATUS
				$sql	= "UPDATE `message_".$language_type."` SET `status`='5', `broadcast_date`= '".CURRENT_DATE."' WHERE `id` = '".$msg_id."' ";
				$db->update($sql, $db->conn);
				//Coping file from temp to audios			
				$audio_path_tmp      = $DOC_ROOT.'/uploads/temp/'.$messageOrdinates['wave_file'];
				$audio_path_original = $DOC_ROOT.'/uploads/audios/'.$messageOrdinates['wave_file'];
				if(copy($audio_path_tmp,$audio_path_original)){
					unlink($audio_path_tmp);
				}
			}
		}

		return $responseCode;
	}

	function functionUpdateTextSmsMsg($postedArray){
		global $db;
		extract($postedArray);
		if($msg_id!='' && $msg_id!='0'){
			$sql	= "UPDATE `message_".$language_type."` SET `message`='".addslashes($message)."', `message_subject`='".$message_subject."', `language_type`='".trim($language_type)."', `message_tag`='".mysql_real_escape_string($message_tag)."', `update_on`= '".CURRENT_DATE."' WHERE `id` = '".$msg_id."' ";
			return $db->update($sql);
		}
		return false;
	}

	function functionUpdateSendTextSmsMsg($postedArray){
		global $db,$DOC_ROOT;
		$projectObj= new project();
		$responsecode = 0;
		extract($postedArray);

		$host_name	= TEXT_HOST_NAME;
		$port		= TEXT_PORT;
		$username	= TEXT_USERNAME;
		$password	= TEXT_PASSWORD;
		$sender		= $projectObj->getProjectSenderName($project_id);
		$message	= addslashes($message);
		$msgtype    = TEXT_MSGTYPE;
		$dlr		= TEXT_DLR;

		if($msg_id!='' && $msg_id!='0'){
			$sql	= "UPDATE `message_".$language_type."` SET `message`='".addslashes($message)."', `message_subject`='".$message_subject."', `language_type`='".trim($language_type)."', `message_tag`='".mysql_real_escape_string($message_tag)."', `update_on`= '".CURRENT_DATE."' WHERE `id` = '".$msg_id."' ";
			$db->update($sql, $db->conn);	

			$msgDetail        = $db->getUniversalRow($table_name="message_".$language_type."",$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$msg_id,$otherfields=null);

			if(isset($msgDetail['message_type']) && $msgDetail['message_type']=='sms' && isset($msgDetail['content_type']) && $msgDetail['content_type']=='txt'){

				//User of this Message
				$sqlinnerfirst = "select * from `message_ordinates_".$language_type."` where `msg_id` = '".$msg_id."' ";
				$messageOrdinates = $db->getRow($sqlinnerfirst);
				if(!empty($messageOrdinates)){

					if($messageOrdinates['csv_file']!=''){	
						$csv_path         = $DOC_ROOT.'/uploads/temp/'.$messageOrdinates['csv_file'];
						$userDetailArray = getCSVData($csv_path);
					}

					$msgObj = new message();
					if(!empty($messageOrdinates['user_group'])){
						$userDetailArray[] = $msgObj->getAllUserSelectedGroup($messageOrdinates['user_group'],$type='user_group');
					}
					if(!empty($messageOrdinates['user_sub_group_other'])){
						$userDetailArray[] = $msgObj->getAllUserSelectedGroup($messageOrdinates['user_sub_group_other'],$type='phone');
					}
					if(!empty($userDetailArray)){
						foreach($userDetailArray as $key => $useroneAll){
							foreach($useroneAll as $key => $userone){
								$userDetail[$userone] = $userone;
							}
						}
						$user_list = implode(',', $userDetail);
					}
				}

				//echo '<pre>';print_r($userDetail);echo '</pre>';die;

				//Calling TEXT API.
				if(isset($user_list) && $user_list!=''){
					set_time_limit(0);	
					$textsmsObj = new Textsms($host_name,$port,$username,$password,$sender,$message,$user_list,$msgtype,$dlr);
					$response   = $textsmsObj->Submit();	
					$responseArray = (isset($response))?explode('|', $response):'';
					$responsecode  = (isset($responseArray[0]))?trim($responseArray[0]):'0';
				}

				//UPDATING MSG STATUS
				$sql	= "UPDATE `message_".$language_type."` SET `status`='5', `broadcast_date`= '".CURRENT_DATE."' WHERE `id` = '".$msg_id."' ";
				$db->update($sql, $db->conn);
			}
		}
		return $responsecode;
	}

	function functionSendTextSmsMsg($tablename, $msg_id){
		global $db,$DOC_ROOT;
		$responsecode = 0;
		$projectObj   = new project();
		$msgObj       = new message();
				
		$msgDetail        = $db->getUniversalRow($tablename,$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$msg_id,$otherfields=null);

		if(isset($msgDetail['message_type']) && $msgDetail['message_type']=='sms' && isset($msgDetail['content_type']) && $msgDetail['content_type']=='txt'){
			
			$host_name	= TEXT_HOST_NAME;
			$port		= TEXT_PORT;
			$username	= TEXT_USERNAME;
			$password	= TEXT_PASSWORD;
			$sender		= $projectObj->getProjectSenderName($msgDetail['project_id']);
			$msgtype    = TEXT_MSGTYPE;
			$dlr		= TEXT_DLR;

			//User of this Message
			$sqlinnerfirst = "select * from `message_ordinates_".$msgDetail['language_type']."` where `msg_id` = '".$msg_id."' ";
			$messageOrdinates = $db->getRow($sqlinnerfirst);
			if(!empty($messageOrdinates)){

				if($messageOrdinates['csv_file']!=''){	
					$csv_path        = $DOC_ROOT.'/uploads/temp/'.$messageOrdinates['csv_file'];
					$userDetailArray = getCSVData($csv_path);
				}
				if(!empty($messageOrdinates['user_group'])){
					$userDetailArray[] = $msgObj->getAllUserSelectedGroup($messageOrdinates['user_group'],$type='user_group');
				}
				if(!empty($messageOrdinates['user_sub_group_other'])){
					$userDetailArray[] = $msgObj->getAllUserSelectedGroup($messageOrdinates['user_sub_group_other'],$type='phone');
				}
				if(!empty($userDetailArray)){
					foreach($userDetailArray as $key => $useroneAll){
						foreach($useroneAll as $key => $userone){
							$userDetail[$userone] = $userone;
						}
					}
					$user_list = implode(',', $userDetail);
				}
			}

			//echo '<pre>';print_r($userDetail);echo '</pre>';die;

			//Calling TEXT API.
			if(isset($user_list) && $user_list!=''){

				set_time_limit(0);	
				
				//UPDATING MSG STATUS
				$sql	= "UPDATE `message_".$msgDetail['language_type']."` SET `status`='5', `broadcast_date`= '".CURRENT_DATE."' WHERE `id` = '".$msg_id."' ";
				$db->update($sql, $db->conn);

				$textsmsObj = new Textsms($host_name,$port,$username,$password,$sender,addslashes($msgDetail['message']),$user_list,$msgtype,$dlr);
				$response   = $textsmsObj->Submit();	
				$responseArray = (isset($response))?explode('|', $response):'';
				$responsecode  = (isset($responseArray[0]))?trim($responseArray[0]):'0';
			}
		}		
		return $responsecode;
	}


	function functionUpdateAndriodMsg($postedArray){
		global $db;
		extract($postedArray);
		if($msg_id!='' && $msg_id!='0'){
		echo	$sql	= "UPDATE `message_".$language_type."` SET `message`='".addslashes($message)."', `message_subject`='".$message_subject."', `language_type`='".trim($language_type)."', `message_tag`='".mysql_real_escape_string($message_tag)."', `update_on`= '".CURRENT_DATE."' WHERE `id` = '".$msg_id."' ";
			return $db->update($sql);
		}
		return false;
	}

	function selectContentComments($content_id, $content_type, $orderby=null, $startlimit=null, $endlimit=null){
		global $db;
		$sql	= "select * from `comments` where `content_id` = '".$content_id."' and `content_type` = '".$content_type."' ".$orderby." ";
		if(isset($startlimit) && $startlimit!='all' && isset($endlimit) && $endlimit!='all'){
			$sql.= " LIMIT ".$startlimit.",".$endlimit." ";
		}
		return $db->getAll($db->run_query($sql));
	}

	function insertContentComent($user_id,$content_id, $content_type, $comment){
		global $db;
		mysql_set_charset('utf8');		
		$sql	= "insert into `comments` SET `user_id`='".$user_id."', `content_id`='".$content_id."', `content_type`='".mysql_real_escape_string($content_type)."', `comment`='".mysql_real_escape_string($comment)."', `date`= '".CURRENT_DATE."' ";
		return $insertResult = $db->insert($sql, $db->conn);
	}
	function functionContentCommentDelete($content_id){
		global $db;		
		$sql	= "delete from `comments` WHERE `id`='".$content_id."' ";
		return $db->delete($sql, $db->conn);
	}

	function insertContentLike($user_id,$content_id, $content_type, $status){
		global $db;	
		$sql	= "Select * from `likes` WHERE `content_id`='".$content_id."' and `content_type`='".mysql_real_escape_string($content_type)."' and `user_id`='".trim($user_id)."' ";
		$likeDetail = $db->getRow($sql);
		if(empty($likeDetail)){
			$sql	= "insert into `likes` SET `user_id`='".$user_id."', `content_id`='".$content_id."', `content_type`='".mysql_real_escape_string($content_type)."', `status`='".trim($status)."', `date`= '".CURRENT_DATE."' ";
			$db->insert($sql, $db->conn);
		} else {
			$sql	= "UPDATE `likes` SET `status`='".trim($status)."', `date`= '".CURRENT_DATE."' WHERE `user_id`='".$user_id."' and `content_id`='".$content_id."' and `content_type`='".mysql_real_escape_string($content_type)."' ";
			$db->update($sql, $db->conn);
		}
		return true;
	}

	function liked_byUsersAll($content_id, $content_type){
		global $db;
		$sql	= "Select * from `likes` WHERE `content_id`='".$content_id."' and `content_type`='".mysql_real_escape_string($content_type)."' and `status`='1' ";
		return $db->run_query($sql);
	}

	function liked_detail($user_id , $content_id, $content_type){
		global $db;
		$sql	= "Select * from `likes` WHERE `content_id`='".$content_id."' and `content_type`='".mysql_real_escape_string($content_type)."' and `user_id`='".trim($user_id)."' ";
		return $db->getRow($sql);
	}

}
?>