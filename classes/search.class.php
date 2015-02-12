<?php
/******************************************
* @Modified on JUNE 20, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

class search {

	function searchResult($searchtype, $keyword, $startLimit='0', $endLimit='10',$language_type='en'){
		global $db;
		mysql_set_charset('utf8');
		$searchData = $searchDataArray = array();

		if(isset($searchtype) && $searchtype =='message'){
			$sql = "select m.id as msg_id, m.message,m.message_subject,m.message_tag,m.message_file,m.content_type,m.date,m.broadcast_date,u.id as user_id,u.pfirstname,u.plastname,u.sfirstname,u.slastname,u.phone,u.username from `message_".trim($language_type)."` m JOIN `users` u ON u.id = m.user_id where m.status IN (1,5) and (m.`message` LIKE '%".$keyword."%' or m.`message_tag` LIKE '%".$keyword."%') order by m.id DESC";
		}
		if(isset($searchtype) && $searchtype =='users'){
			$sql = "select u.id as user_id,u.*,ut.user_type as user_type from `users` u JOIN `user_types` ut ON u.user_type = ut.id where ut.is_active='1' and (u.`pfirstname` LIKE '%".$keyword."%' or u.`plastname` LIKE '%".$keyword."%' or u.`sfirstname` LIKE '%".$keyword."%' or u.`slastname` LIKE '%".$keyword."%' or u.`phone` = '".$keyword."') order by u.id DESC ";
		}
		$searchDataArray = $db->getAll($db->run_query($sql));
		if(!empty($searchDataArray)){
			$_SESSION['searchData'] = $searchDataArray;
			$nextpage   = round(($startLimit-1) * $endLimit);
			$searchData = array_slice($searchDataArray, $nextpage,$endLimit,true);
		}
		return $searchData;
	}

	function getLanguageID($langValue){
		global $db;
		$sql = "SELECT * from `language` WHERE `value` = '".$langValue."'";
		$langValue = $db->getRow($sql);
		return (!empty($langValue['name']))?trim($langValue['name']):'en';
	}

}
?>