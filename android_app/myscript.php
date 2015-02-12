<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

require_once('config.php');
//echo "ohk";exit();


//App urls
//Signin api:localhost/android_app/myscript.php?action=signin&username=kamal&password=kamalpass
//Get main category list:http://localhost/android_app/myscript.php?action=getmaincategory
//Get Sub Category list:http://localhost/android_app/myscript.php?action=getsubcategory&sub_parent=2
//Get Message List:http://localhost/android_app/myscript.php?action=getmessage&subcat_id=69,81&cat_tag=1,2&date=24-2-2014

//signin*************************************************************************
function signin(){
	$username = $_GET['username'];
	$password = $_GET['password'];
	$stSelect = "SELECT * FROM `users` WHERE (`username`='".$username."' or `phone` = '".$username."') and `password`='".$password."'";

	$rsResult = mysql_query($stSelect) or die('error in fetching record');
	if(isset($rsResult) && mysql_num_rows($rsResult) > 0){
		while($row = mysql_fetch_array($rsResult)){
			$return['status'] = "SUCCESS";
			$return['name'] = $row['id'];
			echo $returnStatusSininId =  '{"Result":'.json_encode($return).'}';exit();
		}	
	} else {

		$return['status'] ="FAILED";
		echo $returnStatusSininId     =  '{"Result":'.json_encode($return).'}';	exit();
	}
}

//GETMESSAGE*********************************************************************************
function getcategorymessage(){
	$return29 = array();
	extract($_GET);
	// $statusStr      = implode(',',$cat_tag);
	// $subcategoryStr = implode(',',$subcat_id);
	//$stSelect = " SELECT * FROM  `message` where `status_type` IN (".$statusStr.") and `parent_category`='".$parent_category."' and `sub_category` IN (".$subcategoryStr.") ";
	
	//vkh.......................
	$statusStr      =$cat_tag;
	$subcategoryStr =$subcat_id;
	$settingMode=$settingModeType;

	if($settingMode=='user')//User selected category 
	{
		$stSelect = " SELECT * FROM  `message` where `status_type` IN ($statusStr) and  `parent_category` IN ($subcategoryStr) ";

	}else //when new user login and no setting did for categories i.e defualt mode
	{
		$stSelect = "SELECT * FROM  `message` where `status_type` IN (1,2) and  `parent_category` IN (1)";
	}
	
	
	$rsResult = mysql_query($stSelect) or die('FAILED');//print_r($rsResult);
	if(isset($rsResult) && mysql_num_rows($rsResult) > 0){ 
		while($row = mysql_fetch_array($rsResult)){
			$return['message']  =  $row['message'];
			$return['user_type']=  $row['user_type'];
			$return['date']	    =  $row['date'];
			$return29[]		    =  $return;
		}
		echo $r =  '{"Result":{"data":'.json_encode($return29).'}}';exit();	
	}
	else{
		$return11['status'] =	"FAILED";
		echo $r1			=	'{"Result":data:{'.json_encode($return11).'}}';	exit();	
	}
}

//getmaincategory**********************kya***********************************************
function getmaincategory(){
	$parentCategory	  =	'0';
	$stSelect = "SELECT * FROM `category` where `parent_id`='".$parentCategory."'";
	$rsResult = mysql_query($stSelect) or die();
	if(mysql_num_rows($rsResult) > 0){
		while($row = mysql_fetch_array($rsResult)){
			$return1['categoryname'] = $row['category_name'];
			$return1['categoryid'] = $row['id'];
			$return29[]=$return1;
		}
		echo $r =  '{"Result":{"data":'.json_encode($return29).'}}';exit();	
	} else{
		$return11['status'] = "FAILED";
		echo $r1 =  '{"Result":data:{'.json_encode($return11).'}}';	exit();
	}
}

//getsubcategory*********************************************************************
function getsubcategory(){
	$subParent = trim($_GET['sub_parent']);
	$stSelect  = "SELECT * FROM `category` where `parent_id`='".$subParent."'";
	$rsResult  = mysql_query($stSelect) or die();

	if(mysql_num_rows($rsResult) > 0){
		while($row = mysql_fetch_array($rsResult)){
			$return1['categoryname'] = $row['category_name'];
			$return1['categoryid'] = $row['id'];
			$return29[]=$return1;
		}
		echo $r =  '{"Result":{"data":'.json_encode($return29).'}}';exit();
	} else{
		$return11['status'] = "FAILED";
		echo $r1 =  '{"Result":data:{'.json_encode($return11).'}}';	exit();
	}
}

//sentmessage*********************************************************************
function sentmessage(){

	$user_id  = $_GET['user_id'];
	$message  = $_GET['msg_body'];
	$photoCondition ='';
	if(isset($_FILES["fileToUpload"]["name"])){
		$photo    = time().'_'.$_FILES["fileToUpload"]["name"];
		//move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],SITEPATHDEV.$photo);
		move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],SITEPATHWEB.$photo);
		$photoCondition = " `message_file` = '".$photo."', ";
	}
	$stQuery = "insert into `message` SET `user_id`='".$user_id."', `status_type`='4', `user_type`='1', `parent_category`='135', `sub_category`='136', `message`='".addslashes($message)."', `message_type`='andriod', ".$photoCondition." `language_type`='en', `date`=NOW() ";	
	if(mysql_query($stQuery)){
		$return['status'] = 'Save Successfully';
	}
	echo $retid		=  '{"Result":'.json_encode($return).'}';
}



//action ******************************************************************************
switch($_GET['action']){
	case 'signup':
		  signup();
		  break;
	
	case 'signin':
		  signin();
		  break;
	
	case 'getmessage':
		  getmessage();
	      break;
	
	case 'sentmessage':
		  sentmessage();
	      break;
        
    case 'getcategorymessage':
	      getcategorymessage();
		  break;
	
	case 'getmaincategory':
		  getmaincategory();
		  break;
      
    case 'getsubcategory':
		  getsubcategory();
		  break;
	
	case 'getliveportal':
		  getliveportal();
		  break;
}
?>
