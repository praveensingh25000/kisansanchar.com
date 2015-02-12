<?php
$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$actualData = array();

$sql    = "SELECT * FROM users_uta ";
$result = mysql_query($sql);
while($row = mysql_fetch_assoc($result)){		
	set_time_limit(0);		
	$actualData[$row['id']] = $row;		
}

echo "<pre>";print_r($actualData);echo "</pre>"; die;

foreach($actualData as $user_id => $data){

	$sql    = "SELECT * FROM users where phone = '".$data['phone']."' ";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	if($count == '0'){
		$insertStr = $insertData = '';
		foreach($data as $coloumname => $value){
			if($coloumname != 'id' && $coloumname != 'submit'){
				if($coloumname == 'date'){
					$value = date('Y-m-d H:i:s',strtotime($value));
				}
				$insertStr.= "`".$coloumname ."` = '".$value."',";
			}
		}
		$insertData = substr($insertStr,0,-1);		
		//echo $sql	= "INSERT into `users`  SET  ".$insertData." ";
		//$result = mysql_query($sql);
		//$insert_user_id = mysql_insert_id();
		//echo '<br>';echo '<br>';
		//if($insert_user_id){
			//echo $sql	= "INSERT into `user_privacy_settings` set `user_id` ='".$insert_user_id."', `user_type_setting` = '1', `parent_category_setting` ='1', `sub_category_setting` = '1', date='".date('Y-m-d H:i:s',strtotime($data['date']))."' ";
			//echo '<br>';echo '<br>';
			//mysql_query($sql);
		//}

		//echo '<br>';echo '<br>===================================================';
	}	
}
?>