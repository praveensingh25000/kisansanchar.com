<?php
/******************************************
* @Created on June 08, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

$sql       = "SELECT * FROM `may2014` order by id";
$result    = mysql_query($sql);
$count     = mysql_num_rows($result);
while($row = mysql_fetch_assoc($result)){	
	$actualData[$row['id']] = $row;
}

echo "<pre>";print_r($actualData);echo "</pre>"; die;

foreach($actualData as $key => $data){

	set_time_limit(0);

	extract($data);

	$sql_user  = "select * from users where phone='".$receiver_id."' or username='".$receiver_id."'";
	$resultUser= mysql_query($sql_user);
	$userData = mysql_fetch_assoc($resultUser);
	if(!empty($userData)){
		$sql = "INSERT into `message` set 
		`user_id`             = '".$user_id."', 
		`receiver_id`         = '".$userData['id']."', 
		`status`			  = '".$status."',
		`status_type`		  = '".$status_type."',
		`user_type`			  = '".$user_type."',
		`parent_category`	  = '".$parent_category."',
		`sub_category`		  = '".$sub_category."',
		`c_parent_category`	  = '".$c_parent_category."',
		`c_sub_category`	  = '".$c_sub_category."',
		`g_parent_category`	  = '".$g_parent_category."',
		`g_sub_category`	  = '".$g_sub_category."',
		`user_group`		  = '".$userData['district']."',
		`user_sub_group`      = '".$userData['village']."',
		`message_subject`	  = '".$message_subject."',
		`message`			  = '".$message."',
		`message_tag`		  = '".$message_tag."',
		`content_type`		  = '".$content_type."',
		`content_status`      = '".$content_status."',
		`content_duration`    = '".$content_duration."',
		`content_maxduration` = '".$content_maxduration."',
		`content_time`        = '".$content_time."',
		`message_file`        = '".$message_file."',
		`message_url`         = '".$message_url."',
		`message_type`        = '".$message_type."',
		`language_type`       = '".$language_type."',
		`broadcast_date`      = '".date("Y-m-d H:i:s",strtotime($broadcast_date))."',
		`date` = NOW()	
		";
		//echo '<br>';echo '<br>';echo '<br>';echo '<br>';
		//mysql_query($sql);
	} else {
		$nouser[$receiver_id] = $receiver_id;
	}
}

echo "<pre>";print_r($nouser);echo "</pre>"; die;
?>