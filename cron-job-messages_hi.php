<?php
/******************************************
* @Created on JUNE 15, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/actionHeader.php";

ERROR_REPORTING(0);

$cdrMessageData = $messageidArray = $maxArray = $userphoneData = $ordinatesData = array();

$user_list = '0';

header("Content-type: text/html; charset=utf-8");

$sendDate = (isset($_GET['date']))?$_GET['date']:date('Y-m-d');

//Voice CDR of this Message
$cdrvoiceapiObj	 = new CDRVoiceApi(VOICE_HOST_NAME, VOICE_USERNAME, VOICE_PASSWORD, $sendDate);
$cdrvoicexml     = $cdrvoiceapiObj->Submit();
$cdrvoicearray   = xml2array($cdrvoicexml);
$cdrvoiceData    = format_array_cdr($cdrvoicearray);

//echo '<pre>';print_r($cdrvoiceData);echo '</pre>';die;

if(!empty($cdrvoiceData)){

	//echo '<pre>';print_r($cdrvoicexml);echo '</pre>';die;

	//User of this Message
	$sqlordinates  = "SELECT mo.*,m.*,m.date as mdate FROM `message_ordinates_hi` mo JOIN `message_hi` m ON mo.msg_id = m.id WHERE DATE_FORMAT(mo.date,'%Y-%m-%d') = '".$sendDate."' and m.status='5' and `message_file` != '' ";
	$ordinatesData = $db->getAll($db->run_query($sqlordinates));

	//echo '<pre>';print_r($ordinatesData);echo '</pre>';die;

	if(!empty($ordinatesData)){
		foreach($ordinatesData as $ordinates){
			$messageidArray[$ordinates['msg_id']] = $ordinates['msg_id'];
		}
	}

	//echo '<pre>';print_r($messageidArray);echo '</pre>';die;

	if(!empty($ordinatesData) && !empty($cdrvoiceData)){
		foreach($ordinatesData as $ordinates){
			if(!empty($ordinates)){
				if($ordinates['csv_file']!=''){	
					$csv_path        = $DOC_ROOT.'/uploads/temp/'.$ordinates['csv_file'];
					$userDetailArray = getCSVData($csv_path);
				}
				if(!empty($ordinates['user_group'])){
					$userDetailArray[] = $msgObj->getAllUserSelectedGroup($ordinates['user_group'],$type='user_group');
				}
				if(!empty($ordinates['user_sub_group_other'])){
					$userDetailArray[] = $msgObj->getAllUserSelectedGroup($ordinates['user_sub_group_other'],$type='phone');
				}
				if(!empty($userDetailArray)){
					$userDetail = array(); $user_list = '0';
					foreach($userDetailArray as $key => $useroneAll){
						foreach($useroneAll as $key => $userone){
							$userDetail[$userone] = $userone;
						}
					}
					$user_list = implode(',', $userDetail);
				}
			}
			$sqluser = "select phone as destination,users.* from `users` WHERE `phone` IN (".$user_list.") order by id DESC ";
			$userphoneData = $db->getAll($db->run_query($sqluser));
			foreach($userphoneData as $userphone){
				foreach($cdrvoiceData as $cdrvoice){
					if(!empty($userphone['destination']) && $userphone['destination'] == $cdrvoice['destination']){
						$cdrMessageData[$ordinates['id']][$cdrvoice['destination']]['max'] = $cdrvoice['duration'];
						$cdrMessageData[$ordinates['id']][$cdrvoice['destination']]['cdr']  = $cdrvoice;
						$cdrMessageData[$ordinates['id']][$cdrvoice['destination']]['user'] = $userphone;
						$cdrMessageData[$ordinates['id']][$cdrvoice['destination']]['msg']  = $ordinates;
					}
				}
			}
		}

		//echo '<pre>';print_r($cdrvoiceData);echo '</pre>';
		//echo '<pre>';print_r($cdrMessageData);echo '</pre>';die;

		if(!empty($cdrMessageData)){
			foreach($cdrMessageData as $districtkey => $messageAll){
				foreach($messageAll as $phonekey => $message){
					$maxArray[$districtkey][] = $message['max'];
				}
			}
		}

		//echo '<pre>';print_r($maxArray);echo '</pre>';
		//echo '<pre>';print_r($cdrMessageData);echo '</pre>';die;

		if(!empty($cdrMessageData)){
			foreach($cdrMessageData as $districtkey => $messageAll){
				foreach($messageAll as $phonekey => $message){

					set_time_limit(0);

					mysql_set_charset('utf8');
					mysql_query('SET character_set_results=utf8');       
					mysql_query('SET names=utf8');       
					mysql_query('SET character_set_client=utf8');       
					mysql_query('SET character_set_connection=utf8');
					mysql_query('SET collation_connection=utf8_general_ci'); 				

					$content_status_data = $db->getUniversalRow($table_name='content_status',$coloum_name_str='id',$updated_on_field="name",$updated_on_value="".ucwords(strtolower($message['cdr']['status']))."",$otherfields=null);

					$operator_data = $db->getUniversalRow($table_name='operators',$coloum_name_str='id',$updated_on_field='name',$updated_on_value="".strtoupper(strtolower($message['cdr']['operator']))."",$otherfields=null);

					$message['msg']['content_maxduration'] = max($maxArray[$districtkey]);

					$sql = "INSERT into `message_hi` SET
					`array_key_element`   = '".$message['msg']['array_key_element']."',
					`user_id`             = '".$message['msg']['user_id']."', 
					`receiver_id`         = '".$message['user']['id']."', 
					`status`			  = '1',
					`project_id`		  = '".$message['msg']['project_id']."',
					`status_type`		  = '".$message['msg']['status_type']."',
					`user_type`			  = '".$message['msg']['user_type']."',
					`parent_category`	  = '".$message['msg']['parent_category']."',
					`sub_category`		  = '".$message['msg']['sub_category']."',
					`c_parent_category`	  = '".$message['msg']['c_parent_category']."',
					`c_sub_category`	  = '".$message['msg']['c_sub_category']."',
					`g_parent_category`	  = '".$message['msg']['g_parent_category']."',
					`g_sub_category`	  = '".$message['msg']['g_sub_category']."',
					`user_group`		  = '".$message['user']['district']."',
					`user_sub_group`      = '".$message['user']['village']."',
					`message_subject`	  = '".$message['msg']['message_subject']."',
					`message`			  = '".$message['msg']['message']."',
					`message_tag`		  = '".$message['msg']['message_tag']."',
					`content_type`		  = '".$message['msg']['content_type']."',
					`content_status`      = '".$content_status_data['id']."',
					`operator`			  = '".$operator_data['id']."',
					`content_duration`    = '".$message['cdr']['duration']."',
					`content_maxduration` = '".$message['msg']['content_maxduration']."',
					`content_time`        = '".$message['msg']['content_time']."',
					`message_file`        = '".$message['msg']['message_file']."',
					`message_url`         = '".$message['msg']['message_url']."',
					`message_type`        = '".$message['msg']['message_type']."',
					`language_type`       = '".$message['msg']['language_type']."',
					`broadcast_date`      = '".$message['msg']['broadcast_date']."',
					`date`                = '".$message['msg']['mdate']."' ";
					$insertResult = $db->insert($sql);
				}
			}

			if(!empty($messageidArray)){
				foreach($messageidArray as $msg_id){
					//UPDATING MSG STATUS
					$sql	= "UPDATE `message_hi` SET `status`='6' WHERE `id` = '".$msg_id."' ";
					$update = $db->update($sql);
				}
			}
			if(isset($insertResult) && $insertResult){
				echo 'Message inserted of date(Hindi) :'.$sendDate;exit;
			}
		}
	}else{
		echo 'No Message posted date(Hindi) :'.$sendDate;exit;
	}
}else{
	echo 'No Message posted date(Hindi) :'.$sendDate;exit;
}
?>