
//signup**************************************************************************
function signup(){
	extract($_GET);
	$stSelect	=	"SELECT * FROM `users` where `username`='".$username."'";
	$rsResult	=	mysql_query($stSelect) or die();
	if(isset($rsResult) && mysql_num_rows($rsResult) > 0){
		$return['status']    = ALREADY EXISTS;
		echo $returnStatusSinupId =  '{"Result":'.json_encode($return).'}';
	} else {
		$stQuery = "INSERT into `users`  SET `firstname`='".mysql_real_escape_string($firstname)."', `lastname`='".mysql_real_escape_string($lastname)."', `username`='".mysql_real_escape_string($username)."', `email`='".mysql_real_escape_string($email)."', `password`='".$password."', `phone`='".$phone."', `dob` = '".$dob."', `gender`='".$gender."', `user_type`='1', `date`=NOW() ";
		$stRes = mysql_query($stQuery);
		$insert_user_id = mysql_insert_id();			
		if($insert_user_id){
			$sql	= "insert into `user_privacy_settings` set `user_id` ='".$insert_user_id."', `user_type_setting` = '1', `parent_category_setting` ='1', `sub_category_setting` = '1', date=NOW() ";
			$return['status'] = SUCCESS;
			$return['id']     = $insert_user_id;
		}
		echo $returnStatusSinupId  =  '{"Result":'.json_encode($return).'}';
	}
}





//sentmessage*********************************************************************
function sentmessage(){

	$user_id  = $_GET['user_id'];
	$message  = $_GET['msg_body'];
	$photo    = time().'_'.$_FILES["fileToUpload"]["name"];

	move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],SITEPATHDEV.$photo);
	move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],SITEPATHWEB.$photo);

	$stQuery = "insert into `message` SET `user_id`='".$user_id."', `status_type`='4', `user_type`='1', `parent_category`='135', `sub_category`='136', `message`='".addslashes($message)."', `message_type`='andriod', `language_type`='en', `date`=NOW() ";	
	if(mysql_query($stQuery)){
		$return['status'] = 'Save Successfully';
	}
	echo $retid		=  '{"Result":'.json_encode($return).'}';
}

//getcategorymessage*********************************************************************
function getcategorymessage(){
	$catid			=	$_GET['cat_id'];
	//$catstring	=	explode("$",$catid);
	$subcatid		=	$_GET['sub_category'];
	$catstring		=	explode("$",$subcatid);
	$msgtype		=	$_GET['msg_type'];
	$newtagarr		=	explode("$",$tag);
	$countsubcat	=	count($catstring);
	$countag		=	count($newtagarr);
	$date			=	$_GET['date'];
	
	if($countsubcat == $countag){
		for($a	=	0;	$a<count($catstring);	$a++){
			$stSelect	 = "SELECT * FROM  `message` where `broadcast_date`='".$date."' and (sub_category ='".$catstring[$a]."' or new_category='".$newtagarr[$a]."')";
			$rsResult	 = mysql_query($stSelect) or die();
			if(mysql_num_rows($rsResult) > 0){
				while($row	 = mysql_fetch_array($rsResult)){
					$return1['message']  = $row['message'];
					$return1['date']	 = $row['broadcast_date'];
					if(!empty($return1)){
						$return29[]		 = $return1;
					}
				}
			} else {
				$return11['status'] = FAILED;
				echo $r1			=  '{"Result":data:{'.json_encode($return11).'}}';	
			}
		}
		echo $r				=  '{"Result":{"data":'.json_encode($return29).'}}';
	}

	if($countsubcat > $countag){
		for($a	=	0;$a<count($catstring);$a++){
			$stSelect = "SELECT * FROM  `message` where `broadcastDate`='".$date."' and (sub_category ='".$catstring[$a]."' or new_category='".$newtagarr[$a]."')";
			$rsResult = mysql_query($stSelect) or die();
			if(mysql_num_rows($rsResult) > 0){
				while($row = mysql_fetch_array($rsResult)){
					$return1['message'] = $row['message'];
					$return1['date']    = $row['broadcast_date'];
					if(!empty($return1)){
						$return29[]=$return1;
					}
				}
			} else {
				if(empty($return1)){
					$return11['status'] = FAILED;
				}
			}
		}
		if(empty($return29)){
			echo $r1 =  '{"Result":data:{'.json_encode($return11).'}}';	
		}
		if(!empty($return29)){
			echo $r	 =  '{"Result":{"data":'.json_encode($return29).'}}';
		}
	}

	if($countsubcat < $countag){
		for($a=0;$a<count($newtagarr);$a++){
			$stSelect = "SELECT * FROM  `message` where `broadcast_date`='".$date."' and (sub_category ='".$catstring[$a]."' or new_category='".$newtagarr[$a]."')";
			$rsResult = mysql_query($stSelect) or die();
			if(mysql_num_rows($rsResult) > 0){
				while($row = mysql_fetch_array($rsResult)){
					$return1['message'] = $row['message'];
					$return1['date']    = $row['broadcast_date'];
					if(!empty($return1)){
						$return29[]=$return1;
					}
				}
			} else {
				$return11['status'] = FAILED;
				echo $r1 =  '{"Result":data:{'.json_encode($return11).'}}';	
			}
		}
		echo $r =  '{"Result":{"data":'.json_encode($return29).'}}';
	}

}




//getliveportal*********************************************************************
function getliveportal(){
	$mobile		=	"andriod";
	$stSelect	=	"SELECT * FROM  `message` where `message_type`='".$mobile."'";
	$rsResult	=	mysql_query($stSelect) or die();
	if(mysql_num_rows($rsResult) > 0){
		while($row = mysql_fetch_array($rsResult)){
			$return1['message']         = $row['message'];
			$return1['parent_category'] = $row['parent_category'];
			$return29[]=$return1;
		}
		echo $r =  '{"Result":{"data":'.json_encode($return29).'}}';	
	} else {
		$return11['status'] = FAILED;
		echo $r1 =  '{"Result":data:{'.json_encode($return11).'}}';	
	}
}