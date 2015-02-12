<?php
/******************************************
* @Created on APL 20, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
*******************************************/

class analysis{

	function analysisVillageWiseResult($user_privacy){

		//echo '<pre>';print_r($_SESSION['postedArray']);echo '</pre>';

		global $db;

		$returnDataMain = $return = $whereCombination = $whereCombinationloop = $innerwhereCombination = $displayCombination = $returnArray = $returnDataArray = $returnDataMainArray = $returnDataArrayMain = $percentage_calulate_array = $returnData = array();		

		$village_str  = '';

		$language_type = $_SESSION['postedArray']['language_type'];

		$displayCombination[]       = trim("msg.id as msg_id,us.pfirstname,us.plastname,us.username");
		
		$displayCombination[]       = trim("usc.name as country,uss.name as state,usd.name as district,ust.name as tehsil, usv.name as village");

		$displayCombination[]       = trim("cs.name,msg.c_parent_category, msg.c_sub_category, msg.g_parent_category, msg.g_sub_category , msg.message_subject, msg.content_duration,msg.content_maxduration,msg.content_type,msg.content_time,msg.broadcast_date");
	
		$tablecombinationleftjoin[] = trim("`message_".$language_type."` msg");

		$tableJoinCondition[]       = trim("JOIN `users` us  ON us.id = msg.receiver_id");
		$tableJoinCondition[]       = trim("JOIN `india` usc ON usc.id = us.country");
		$tableJoinCondition[]       = trim("JOIN `india` uss ON uss.id = us.state");
		$tableJoinCondition[]       = trim("JOIN `india` usd ON usd.id = us.district");
		$tableJoinCondition[]       = trim("JOIN `india` ust ON ust.id = us.tehsil");
		$tableJoinCondition[]       = trim("JOIN `india` usv ON usv.id = us.village");

		$tableJoinCondition[]       = trim("JOIN `content_status` cs ON cs.id = msg.content_status");

		if(isset($_SESSION['postedArray']['percentageto'][0]) && $_SESSION['postedArray']['percentagefrom'][0]!='' && isset($_SESSION['postedArray']['content_status'])){

			if(isset($_SESSION['postedArray']['country']) && $_SESSION['postedArray']['country']!=''){
				$innerwhereCombination[]  = trim("us.country = '".$_SESSION['postedArray']['country']."' ");
			}

			if(isset($_SESSION['postedArray']['state']) && $_SESSION['postedArray']['state']!=''){
				$innerwhereCombination[]  = trim("us.state = '".$_SESSION['postedArray']['state']."' ");
			}

			if(!isset($_SESSION['postedArray']['alldistrictreport']) && isset($_SESSION['postedArray']['district']) && $_SESSION['postedArray']['district']!=''){
				$innerwhereCombination[]  = trim("us.district = '".$_SESSION['postedArray']['district']."' ");
			}

			if(!isset($_SESSION['postedArray']['alltahsilreport']) && isset($_SESSION['postedArray']['tehsil']) && $_SESSION['postedArray']['tehsil']!=''){
				$innerwhereCombination[]  = trim("us.tehsil = '".$_SESSION['postedArray']['tehsil']."' ");
			}

			if(!isset($_SESSION['postedArray']['allvillagereport']) && isset($_SESSION['postedArray']['village']) && $_SESSION['postedArray']['village']!='' && $_SESSION['postedArray']['village']!='all'){	
				$village_str              = implode(',',$_SESSION['postedArray']['village']);
				$innerwhereCombination[]  = trim("us.village IN (".$village_str.") ");
			}

			if(isset($_SESSION['postedArray']['content_status']) && $_SESSION['postedArray']['content_status']!='0' && $_SESSION['postedArray']['content_status']!='all'){			
				$innerwhereCombination[]  = trim("msg.content_status = '".$_SESSION['postedArray']['content_status']."' ");
			}

			if(isset($_SESSION['postedArray']['month']) && $_SESSION['postedArray']['month']!='0' && $_SESSION['postedArray']['month']!='all'){			
				$innerwhereCombination[]  = trim("MONTH(msg.broadcast_date) = '".$_SESSION['postedArray']['month']."' ");
			}

			if(isset($_SESSION['postedArray']['year']) && $_SESSION['postedArray']['year']!='0' && $_SESSION['postedArray']['year']!='all'){			
				$innerwhereCombination[]  = trim("YEAR(msg.broadcast_date) = '".$_SESSION['postedArray']['year']."' ");
			}

			if(isset($user_privacy) && $user_privacy!=''){			
				$innerwhereCombination[]  = trim(" msg.user_id IN (".$user_privacy.") ");
			}

			if(defined('IS_PROJECT_ID')){			
				$innerwhereCombination[]  = trim(" msg.project_id = ".IS_PROJECT_ID." ");
			}

			if(!empty($displayCombination)){
				$displayCombinationStr = implode(' , ',array_unique($displayCombination));
			}
			if(!empty($tablecombinationleftjoin)){
				$tableCombinationStr = implode(' ',array_unique($tablecombinationleftjoin));
			}

			if(!empty($tableJoinCondition)){
				$tableJoinConditionStr = implode(' ',array_unique($tableJoinCondition));
			}

			if(!empty($innerwhereCombination)){
				$innerwhereCombinationStr = implode(' and ',array_unique($innerwhereCombination));
			}		

			if(!empty($tableJoinCondition) && count($tableJoinCondition) >= '1'){
				$whereClause = " WHERE 1 and ";
			} else {
				$whereClause = " WHERE 1 ";
			}

			$sql = "SELECT ".$displayCombinationStr." FROM ".$tableCombinationStr." ".$tableJoinConditionStr." ".$whereClause." ".$innerwhereCombinationStr."";
			$result	= $db->run_query($sql);
			if(isset($result) && mysql_num_rows($result)>0){				
				while($row  = mysql_fetch_assoc($result)){
					$returnDataArray[date('Y-m-d',strtotime($row['broadcast_date']))][$row['village']][$row['content_time']][] = $row;	
				}
			}

			//echo '<pre>';print_r($returnDataArray);echo '</pre>';die;

			foreach($returnDataArray as $keycontenttime => $returnDataoneAll){
				foreach($returnDataoneAll as $keyonevillage => $returndataonealloneall){
					foreach($returndataonealloneall as $mornevenkey => $returnDataoneAll){

						foreach($returnDataoneAll as $keyone => $returnDataone){

							$content_duration    = $content_maxduration = '';
							$percentageReceived  = 0;
							$content_duration    = $returnDataone['content_duration'];
							$content_maxduration = $returnDataone['content_maxduration'];

							$percentageReceived  = @number_format((($content_duration/$content_maxduration)*100),3);
							$returnDataone['percentageReceived'] = $percentageReceived;
							$returnDataMainArray[$keycontenttime][$keyonevillage][$mornevenkey][$keyone] = $returnDataone;
						}
					}
				}
			}

			foreach($returnDataMainArray as $keycontenttimemain => $returnDataoneAll1oneall){
				
				foreach($returnDataoneAll1oneall as $keyonevillage => $returnDataonemainAll){
					
					foreach($returnDataonemainAll as $morningevening => $returnDataonemainoneAll){

						foreach($returnDataonemainoneAll as $keyone2 => $returnDataonemain){

							$percentage_Received  = number_format($returnDataonemain['percentageReceived']);
							
							foreach($_SESSION['postedArray']['percentageto'] as $key1 => $percentageto){
								if($_SESSION['postedArray']['percentageto'][$key1]!='' && $_SESSION['postedArray']['percentagefrom'][$key1]!=''){
									if($percentage_Received >= $_SESSION['postedArray']['percentageto'][$key1] && $percentage_Received <= $_SESSION['postedArray']['percentagefrom'][$key1]){
										$returnDataonemain['count_farmer'] = '1';
										$returnDataArrayMain[$keycontenttimemain][$keyonevillage][$morningevening]['No.of Farmers in ('.$_SESSION['postedArray']['percentageto'][$key1].'%-'.$_SESSION['postedArray']['percentagefrom'][$key1].'%)'][] = $returnDataonemain;
										
										$returnDataArrayMain[$keycontenttimemain][$keyonevillage][$morningevening]['Percentage of Farmers in ('.$_SESSION['postedArray']['percentageto'][$key1].'%-'.$_SESSION['postedArray']['percentagefrom'][$key1].'%)'][] = $returnDataonemain['percentageReceived'];

									} else {
										$returnDataonemain['count_farmer'] = '0';
										$returnDataArrayMain[$keycontenttimemain][$keyonevillage][$morningevening]['No.of Farmers in ('.$_SESSION['postedArray']['percentageto'][$key1].'%-'.$_SESSION['postedArray']['percentagefrom'][$key1].'%)'][0] = $returnDataonemain;

										$returnDataArrayMain[$keycontenttimemain][$keyonevillage][$morningevening]['Percentage of Farmers in ('.$_SESSION['postedArray']['percentageto'][$key1].'%-'.$_SESSION['postedArray']['percentagefrom'][$key1].'%)'][$keyone2] = 0.00;
									}
								}
							}
						}
					
					}
				}
			}

			foreach($returnDataArrayMain as $keyreturnDataMaintime => $keyreturnDataMaintimeAll){

				foreach($keyreturnDataMaintimeAll as $keyreturnDataMainvillage => $keyreturnDataMainvillageAll){

					foreach($keyreturnDataMainvillageAll as $keymorningevening => $keyreturnDataMainnumpertcolAlloneAll){	
						
						foreach($keyreturnDataMainnumpertcolAlloneAll as $keyreturnDataMainnumpertcol => $keyreturnDataMainnumpertcolAll){
						
							$total_row = count($keyreturnDataMainnumpertcolAll);

							foreach($keyreturnDataMainnumpertcolAll as $keyreturnDataMainnumpertcolkey => $keyreturnDataMainnumpertcolkeyAll){

								if(substr($keyreturnDataMainnumpertcol,0,10) == 'Percentage'){								
									$percentage_calulate_array[$keyreturnDataMaintime][$keyreturnDataMainvillage][$keymorningevening][$keyreturnDataMainnumpertcol] = '';
									
								} else {

									if($total_row == '1'){
										$percentage_calulate_array[$keyreturnDataMaintime][$keyreturnDataMainvillage][$keymorningevening][$keyreturnDataMainnumpertcol][]=$keyreturnDataMainnumpertcolkeyAll;
									}
									if($keyreturnDataMainnumpertcolkeyAll['count_farmer']!='0'){
										$percentage_calulate_array[$keyreturnDataMaintime][$keyreturnDataMainvillage][$keymorningevening][$keyreturnDataMainnumpertcol][]=$keyreturnDataMainnumpertcolkeyAll;
									}
								}
							}
						}
					}
				}
			}

			//echo '<pre>';print_r($percentage_calulate_array);echo '</pre>';die;

			foreach($percentage_calulate_array as $time_key => $percentage_calulate_time_all){

				foreach($percentage_calulate_time_all as $vill_key => $percentage_calulate_vill_All){

					foreach($percentage_calulate_vill_All as $morning_evening => $percentage_calulate_vill_All_one_all){
					
						$count_farmer = array();

						foreach($percentage_calulate_vill_All_one_all as $percentage_key => $percentage_calulate_numpert_All){	
							
							if(is_array($percentage_calulate_numpert_All) && array_key_exists('0',$percentage_calulate_numpert_All)){

								foreach($percentage_calulate_numpert_All as $key => $data){

									$c_parent_category = $g_parent_category = $c_sub_category = $g_sub_category = '';

									$langObj  = new language();
									$c_parent_category_detail = $langObj->functionGetSetting($tablename='category', $dmlType='1', $data['c_parent_category']);
									$g_parent_category_detail = $langObj->functionGetSetting($tablename='category', $dmlType='1', $data['g_parent_category']);
									$c_sub_category_detail = $langObj->functionGetSetting($tablename='category', $dmlType='1', $data['c_sub_category']);
									$g_sub_category_detail = $langObj->functionGetSetting($tablename='category', $dmlType='1', $data['g_sub_category']);

									$c_parent_category	= (isset($c_parent_category_detail['category_name']))?trim($c_parent_category_detail['category_name']):'Not entered';
									$g_parent_category	= (isset($g_parent_category_detail['category_name']))?trim($g_parent_category_detail['category_name']):'Not entered';

									$c_sub_category	= (isset($c_sub_category_detail['category_name']))?trim($c_sub_category_detail['category_name']):'Not entered';
									$g_sub_category	= (isset($g_sub_category_detail['category_name']))?trim($g_sub_category_detail['category_name']):'Not entered';

									$returnData[$time_key][$vill_key][$morning_evening]['S.N.']         = '';	
									$returnData[$time_key][$vill_key][$morning_evening]['State']        = $data['state'];
									$returnData[$time_key][$vill_key][$morning_evening]['District']     = $data['district'];	
									$returnData[$time_key][$vill_key][$morning_evening]['Village Name'] = $data['village'];
									$returnData[$time_key][$vill_key][$morning_evening]['Message Date'] = date('d/m/Y',strtotime($data['broadcast_date']));				
									$returnData[$time_key][$vill_key][$morning_evening]['Message Time'] = $data['content_time'];
									$returnData[$time_key][$vill_key][$morning_evening]['Call Duration'] = $data['content_maxduration'];	
									$returnData[$time_key][$vill_key][$morning_evening]['Broadcasting Time'] = date('h:i A',strtotime($data['broadcast_date']));
									$returnData[$time_key][$vill_key][$morning_evening]['message_subject']         = $data['message_subject'];

									$returnData[$time_key][$vill_key][$morning_evening]['c_category']         = $c_sub_category;
									$returnData[$time_key][$vill_key][$morning_evening]['g__category']         = $g_sub_category;
									if(is_array($percentage_calulate_numpert_All) && count($percentage_calulate_numpert_All)=='1'){
										if($percentage_calulate_numpert_All[0]['count_farmer']=='0'){
											$returnData[$time_key][$vill_key][$morning_evening][$percentage_key] = 0;
										} else {
											$returnData[$time_key][$vill_key][$morning_evening][$percentage_key] = count($percentage_calulate_numpert_All);
										}
									}
									if(is_array($percentage_calulate_numpert_All) && count($percentage_calulate_numpert_All) > 1){
										$returnData[$time_key][$vill_key][$morning_evening][$percentage_key] = count($percentage_calulate_numpert_All);
									}
								}	
							} else {						
								$returnData[$time_key][$vill_key][$morning_evening][$percentage_key] = $percentage_calulate_numpert_All;
							}
						}
					}
				}
			}
			
			foreach($returnData as $keyreturnData => $returnDataoneAll){

				foreach($returnDataoneAll as $keyreturnvillageData => $returnDataoneAlloneVilAll){

					foreach($returnDataoneAlloneVilAll as $keymorevening => $dataone){

						$total_farmer = $total_percentage = array();
						foreach($dataone as $keyN => $valuefarmer){
							if(substr($keyN,0,5)=='No.of'){
								$total_farmer[]       = $valuefarmer;
							}
						}		
						$number_total_farmer  = $total_farmer_np  = '';
						foreach($dataone as $keyPN => $valuefarmerPN){						
							$percentage_of_farmer = number_format(0,3);
							if(substr($keyPN,0,5)=='No.of'){
								$number_total_farmer  = $valuefarmerPN;							
							}
							if(substr($keyPN,0,10)=='Percentage'){							
								$total_farmer_np      = array_sum($total_farmer);
								if($number_total_farmer != '0' && $total_farmer_np != '0'){
									$percentage_of_farmer = number_format(($number_total_farmer/$total_farmer_np*100),3);
								}							
								$dataone[$keyPN] = $percentage_of_farmer;
							}						
						}
						foreach($dataone as $keyP => $valuepercentage){
							if(substr($keyP,0,10)=='Percentage'){
								$total_percentage[]   = $valuepercentage;							
							}
						}
						$dataone['S.N.'] =	'';
						$dataone['Total Farmers'] = array_sum($total_farmer);
						$dataone['Total Percent'] = round(array_sum($total_percentage));
						$returnDataMain[]         = $dataone;
					}
				}
			}

			$serial=1;
			foreach($returnDataMain as $returnArraykey => $returnArrayAll){
				$returnArrayAll['S.N.'] = $serial;
				$return[]               = $returnArrayAll;	
				$serial=$serial+1;
			}
			
		}
		return $return;
	}

	function analysisFarmerWiseResult($user_privacy){

		//echo '<pre>';print_r($_SESSION['joiningArray']);echo '</pre>';

		global $db;

		$return = $whereCombination = $whereCombinationloop = $innerwhereCombination = $displayCombination = $returnArray = $returnDataArray = $returnDataMainArray = $returnDataArrayMain = $percentage_calulate_array = $returnData = $tableJoinCondition = array();		
		$tableCombinationStr = $displayCombinationStr = $receiver_id_str = $user_sub_group_str  = $innerwhereCombinationStr = $tableJoinConditionStr = '';

		$language_type = $_SESSION['joiningArray']['language_type'];

		$displayCombination[]       = trim("msg.id as msg_id,msg.user_id,msg.receiver_id,us.pfirstname,us.plastname,us.username,us.gender");

		$displayCombination[]       = trim("usc.name as country,uss.name as state,usd.name as district,ust.name as tehsil, usv.name as village");

		$displayCombination[]       = trim("cs.name as content_status,msg. 	content_duration,msg.content_maxduration,msg.content_type,msg.content_time,msg.broadcast_date");
	
		$tablecombinationleftjoin[] = trim("`message_".$language_type."` msg");

		$tableJoinCondition[]       = trim("JOIN `users` us  ON us.id = msg.receiver_id");
		$tableJoinCondition[]       = trim("JOIN `india` usc ON usc.id = us.country");
		$tableJoinCondition[]       = trim("JOIN `india` uss ON uss.id = us.state");
		$tableJoinCondition[]       = trim("JOIN `india` usd ON usd.id = us.district");
		$tableJoinCondition[]       = trim("JOIN `india` ust ON ust.id = us.tehsil");
		$tableJoinCondition[]       = trim("JOIN `india` usv ON usv.id = us.village");
		$tableJoinCondition[]       = trim("JOIN `content_status` cs ON cs.id = msg.content_status");

		if(isset($_SESSION['joiningArray']['country']) && $_SESSION['joiningArray']['country']!=''){
			$innerwhereCombination[]  = trim("us.country = '".$_SESSION['joiningArray']['country']."' ");
		}

		if(isset($_SESSION['joiningArray']['state']) && $_SESSION['joiningArray']['state']!=''){
			$innerwhereCombination[]  = trim("us.state = '".$_SESSION['joiningArray']['state']."' ");
		}

		if(isset($_SESSION['joiningArray']['district']) && $_SESSION['joiningArray']['district']!=''){
			$innerwhereCombination[]  = trim("us.district = '".$_SESSION['joiningArray']['district']."' ");
		}

		if(isset($_SESSION['joiningArray']['tehsil']) && $_SESSION['joiningArray']['tehsil']!=''){
			$innerwhereCombination[]  = trim("us.tehsil = '".$_SESSION['joiningArray']['tehsil']."' ");
		}

		if(isset($_SESSION['joiningArray']['village']) && $_SESSION['joiningArray']['village']!='' && $_SESSION['joiningArray']['village']!='all'){
			$user_sub_group_str       = implode(',',$_SESSION['joiningArray']['village']);
			$innerwhereCombination[]  = trim("us.village IN (".$user_sub_group_str.") ");
		}

		if(isset($_SESSION['joiningArray']['receiver_id']) && $_SESSION['joiningArray']['receiver_id']!='' && $_SESSION['joiningArray']['receiver_id']!='all'){	
			$receiver_id_str       = implode(',',$_SESSION['joiningArray']['receiver_id']);
			$innerwhereCombination[]  = trim("msg.receiver_id IN (".$receiver_id_str.") ");
		}

		if(isset($user_privacy) && $user_privacy!=''){			
			$innerwhereCombination[]  = trim(" msg.user_id IN (".$user_privacy.") ");
		}

		if(defined('IS_PROJECT_ID')){			
			$innerwhereCombination[]  = trim(" msg.project_id = ".IS_PROJECT_ID." ");
		}

		if(isset($_SESSION['joiningArray']['content_status']) && $_SESSION['joiningArray']['content_status']!='0' && $_SESSION['joiningArray']['content_status']!='all'){			
				$innerwhereCombination[]  = trim("msg.content_status = '".$_SESSION['joiningArray']['content_status']."' ");
		}

		if(isset($_SESSION['joiningArray']['month']) && $_SESSION['joiningArray']['month']!='0' && $_SESSION['joiningArray']['month']!='all'){			
			$innerwhereCombination[]  = trim("MONTH(msg.broadcast_date) = '".$_SESSION['joiningArray']['month']."' ");
		}

		if(isset($_SESSION['joiningArray']['year']) && $_SESSION['joiningArray']['year']!='0' && $_SESSION['joiningArray']['year']!='all'){			
			$innerwhereCombination[]  = trim("YEAR(msg.broadcast_date) = '".$_SESSION['joiningArray']['year']."' ");
		}

		if(!empty($displayCombination)){
			$displayCombinationStr = implode(' , ',array_unique($displayCombination));
		}
		if(!empty($tablecombinationleftjoin)){
			$tableCombinationStr = implode(' ',array_unique($tablecombinationleftjoin));
		}

		if(!empty($tableJoinCondition)){
			$tableJoinConditionStr = implode('    ',array_unique($tableJoinCondition));
		}

		if(!empty($innerwhereCombination)){
			$innerwhereCombinationStr = implode(' and ',array_unique($innerwhereCombination));
		}		

		if(!empty($tableJoinCondition) && count($tableJoinCondition) >= '1'){
			$whereClause = " WHERE 1 and ";
		} else {
			$whereClause = " WHERE 1 ";
		}

		$sql = "SELECT ".$displayCombinationStr." FROM ".$tableCombinationStr." ".$tableJoinConditionStr." ".$whereClause." ".$innerwhereCombinationStr."";
		$result	= $db->run_query($sql);
		if(isset($result) && mysql_num_rows($result)>0){				
			while($row  = mysql_fetch_assoc($result)){
				$returnDataArray[$row['receiver_id']][] = $row;	
			}
		}

		//echo '<pre>';print_r($returnDataArray);echo '</pre>';
		
		$serial=1;
		foreach($returnDataArray as $receiver_id_key => $returnDataoneAll){
			foreach($returnDataoneAll as $key => $data){
				$receiverDetail = $db->getUniversalRow($table_name='users',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$receiver_id_key,$otherfields=null);
				$percentageReceived = $gender = '';
				if(!empty($receiverDetail)){
					$percentageReceived  = @number_format((($data['content_duration']/$data['content_maxduration'])*100),3);
					if($receiverDetail['gender']=='M'){
						$gender = 'Male';
					} else if($receiverDetail['gender']=='F'){
						$gender = 'Female';
					}else {
						$gender = 'Other';
					}

					$langObj  = new language();
					$messageData   = $langObj->functionGetSetting($tablename="message_".$language_type."", $dmlType='1', $id=$data['msg_id']);
					$c_sub_category_detail = $langObj->functionGetSetting($tablename='category', $dmlType='1', $messageData['c_sub_category']);
					$g_sub_category_detail = $langObj->functionGetSetting($tablename='category', $dmlType='1', $messageData['g_sub_category']);

					$c_sub_category	= (isset($c_sub_category_detail['category_name']))?trim($c_sub_category_detail['category_name']):'Not entered';
					$g_sub_category	= (isset($g_sub_category_detail['category_name']))?trim($g_sub_category_detail['category_name']):'Not entered';
					$message_subject	= (isset($messageData['message_subject']))?trim($messageData['message_subject']):'Not entered';

					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['S.N.'] = $serial;	
					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['Mobile No.'] = $receiverDetail['phone'];
					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['Name of farmer'] = $receiverDetail['pfirstname'].' '.$receiverDetail['plastname'];
					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['Gender'] = $gender;
					//$returnData[$receiverDetail['phone']][$data['content_status']][$key]['Age']	= '';
					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['State'] = $data['state'];
					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['District'] = $data['district'];
					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['Village Name'] = $data['village'];
					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['Message Date'] = date('d/m/Y',strtotime($data['broadcast_date']));					
					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['Message Time']   = $data['content_time'];		
					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['Message Subject'] = $message_subject;
					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['C Category'] = $c_sub_category;
					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['G Category'] = $g_sub_category;
					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['Duration']  = $data['content_maxduration'];
					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['Broadcasting time'] = date('h:i A',strtotime($data['broadcast_date']));
					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['Duration listened to message']      = $data['content_duration'];
					$returnData[$receiverDetail['phone']][$data['content_status']][$key]['Percent of time listened']      = $percentageReceived;
				}
				$serial=$serial+1;
			}
		}

		//echo '<pre>';print_r($returnData);echo '</pre>';

		return $returnData;
	}
	

	function analysisFarmerJoiningResult($user_privacy){

		//echo '<pre>';print_r($_SESSION['joiningFarmerArray']);echo '</pre>';

		global $db;

		$return = $whereCombination = $whereCombinationloop = $innerwhereCombination = $displayCombination = $returnArray = $returnDataArray = $returnDataMainArray = $returnDataArrayMain = $percentage_calulate_array = $returnData = $tableJoinCondition = array();		

		$tableCombinationStr = $displayCombinationStr = $receiver_id_str = $user_sub_group_str  = $innerwhereCombinationStr = $tableJoinConditionStr = '';

		$displayCombination[]       = trim("msg.id as msg_id,msg.user_id,msg.receiver_id,us.pfirstname,us.plastname,us.username");
		$displayCombination[]       = trim("usg.group_name as district,ussg.group_name as village");
		$displayCombination[]       = trim("cs.name as content_status,msg. 	content_duration,msg.content_maxduration,msg.content_type,msg.content_time,msg.broadcast_date");

		$tablecombinationleftjoin[] = trim("`users` us");

		$tableJoinCondition[]       = trim("JOIN `message` msg ON us.id = msg.receiver_id");
		$tableJoinCondition[]       = trim("JOIN `user_groups` usg ON usg.id = us.district");
		$tableJoinCondition[]       = trim("JOIN `user_groups` ussg ON ussg.id = us.village");
		$tableJoinCondition[]       = trim("JOIN `content_status` cs ON cs.id = msg.content_status");

		if(isset($_SESSION['joiningFarmerArray']['phone']) && $_SESSION['joiningFarmerArray']['phone']!='0'){
			$innerwhereCombination[]  = trim("us.phone = '".$_SESSION['joiningFarmerArray']['phone']."' ");
		}
		if(isset($_SESSION['joiningFarmerArray']['phone']) && $_SESSION['joiningFarmerArray']['phone']!='0'){
			$innerwhereCombination[]  = trim("us.username LIKE '%".$_SESSION['joiningFarmerArray']['phone']."%' ");
		}
		if(!empty($displayCombination)){
			$displayCombinationStr = implode(' , ',array_unique($displayCombination));
		}
		if(!empty($tablecombinationleftjoin)){
			$tableCombinationStr = implode(' ',array_unique($tablecombinationleftjoin));
		}

		if(!empty($tableJoinCondition)){
			$tableJoinConditionStr = implode('    ',array_unique($tableJoinCondition));
		}

		if(!empty($innerwhereCombination)){
			$innerwhereCombinationStr = implode(' or ',array_unique($innerwhereCombination));
		}		

		if(!empty($tableJoinCondition) && count($tableJoinCondition) >= '1'){
			$whereClause = " WHERE 1 and ";
		} else {
			$whereClause = " WHERE ";
		}

		$sql = "SELECT ".$displayCombinationStr." FROM ".$tableCombinationStr." ".$tableJoinConditionStr." ".$whereClause." (".$innerwhereCombinationStr.") ";
		$result	= $db->run_query($sql);
		if(isset($result) && mysql_num_rows($result)>0){				
			while($row  = mysql_fetch_assoc($result)){				
				if($row['district']=='Karnal'){
					$row['state']='Haryana';
				}else{
					$row['state']='Bihar';
				}
				$returnDataArray[$row['receiver_id']][] = $row;	
			}
		}

		//echo '<pre>';print_r($returnDataArray);echo '</pre>';die;

		return $returnData;
	}
}
?>