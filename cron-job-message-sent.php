<?php
/******************************************
* @Created on DEC 23, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/actionHeader.php";

header("Content-type: text/html; charset=utf-8");
ERROR_REPORTING(0);

$succuss       = $ordinatesData = array();
$sendDate      = date('Y-m-d H');
$languageArray = array('en','hi','pa');

foreach($languageArray as $language){
	$sqlordinates  = "SELECT mo.*, m.*, m.date as mdate FROM `message_ordinates_".$language."` mo JOIN `message_".$language."` m ON mo.msg_id = m.id WHERE DATE_FORMAT(m.date,'%Y-%m-%d %H') = '".$sendDate."' and m.status = '7' and m.content_type!= '' ";
	$ordinatesData[$language] = $db->getAll($db->run_query($sqlordinates));
}

//echo '<pre>';print_r($ordinatesData);echo '</pre>';die;

if(!empty($ordinatesData)){
	foreach($ordinatesData as $language_type => $messageContent){
		foreach($messageContent as $key => $messageData){

			if(is_array($messageData) && !empty($messageData['content_type']) && !empty($messageData['id'])){

				if(isset($messageData['content_type']) && $messageData['content_type']=='txt'){
					$responseCode = $msgObj->functionSendTextSmsMsg('message_'.$language_type,$messageData['id']);
					if($response == '1701'){
						$succuss[$messageData['language_type']] = $messageData['id'];
					}
				}

				if(isset($messageData['content_type']) && $messageData['content_type']=='wav'){
					$responseCode = $msgObj->functionSendVoiceSmsMsg('message_'.$language_type,$messageData['id']);
					if($response == '3001'){
						$succuss[$messageData['language_type']] = $messageData['id'];
					}
				}	
			}			
		}		
	}		
}

if(!empty($succuss)){
	foreach($succuss as $langname => $totalcountarray){
		echo 'Total: '.count($totalcountarray).' || Message('.$langname.') has been sent succussfully. \n\n';
	}
}
?>