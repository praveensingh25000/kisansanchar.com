<?php

require_once('config.php');
function signup()
{
	$name = $_GET['name'];
	$username = $_GET['username'];
	$altphone = $_GET['altphone'];
	$email = $_GET['email'];
	$password = $_GET['password'];
	$address = $_GET['address'];
	//$usertag = $_GET['usertag'];
	$date = date("Y-m-d");


	$stSelect = "SELECT * FROM userdata where username='".$username."'";
	$rsResult = mysql_query($stSelect) or die();
	if(mysql_num_rows($rsResult) > 0)
	{
		$return11['status'] = 'ALREADY EXISTS';
		echo $r1 =  '{"Result":'.json_encode($return11).'}';
	}
	else
	{
	$stQuery = "INSERT INTO userdata(name, username, email, password, address, altphone, date) VALUES ('".$name."', '".$username."', '".$email."', '".$password."', '".$address."', '".$altphone."','".$date."')";
		if(mysql_query($stQuery))
		{
			$return['status'] = 'SUCCESS';
			$return['id'] = mysql_insert_id();
		}
		//echo $return['id'];
	echo $retid =  '{"Result":'.json_encode($return).'}';
   }
}

function signin()
{
	 
	$username=$_GET['username'];
	$password=$_GET['password'];
	
	$stSelect = "SELECT * FROM userdata where username='".$username."' and password='".$password."'";
	$rsResult = mysql_query($stSelect) or die();
	
	
	if(mysql_num_rows($rsResult) > 0)
	{
		while($row = mysql_fetch_array($rsResult))
		{
		$return1['status'] = SUCCESS;
		$return1['name'] = $row['user_id'];
		echo $r =  '{"Result":'.json_encode($return1).'}';
		}
			
	}
	else
	{
		$return11['status'] = FAILED;
		echo $r1 =  '{"Result":'.json_encode($return11).'}';	
	}
}

function getmessage()
	{
		$date = $_GET['date'];
		$tag= $_GET['tag'];
		$stSelect = "SELECT * FROM  usermessage where date='".$date."' and cat_tag='".$tag."'";
		$rsResult = mysql_query($stSelect) or die();
		if(mysql_num_rows($rsResult) > 0)
		{
		while($row = mysql_fetch_array($rsResult))
		{
		$return1['message'] = $row['message'];
		$return1['kvkname'] = $row['kvk_name'];
		$return1['date'] = $row['date'];
		$return29[]=$return1;
		}
		echo $r =  '{"Result":{"data":'.json_encode($return29).'}}';	
		}
		else
		{
		$return11['status'] = FAILED;
		echo $r1 =  '{"Result":data:{'.json_encode($return11).'}}';	
		}
		
		
	}


//{"Result":{"message":"this is first message posted by harish","kvkname":"testuser29","date":"2012-11-12"}}{"Result":{"message":"this is second message","kvkname":"testuser30","date":"2012-11-12"}}

//{"Result":data:{{"message":"this is first message posted by harish","kvkname":"testuser29","date":"2012-11-12"}{"message":"this is second message","kvkname":"testuser30","date":"2012-11-12"}}}
	
function sentmessage()
	{
		
		$userid = $_GET['user_id'];
		$msg_body= $_GET['msg_body'];
		$photo= time().'_'.$_FILES["fileToUpload"]["name"];
		$date = date("Y-m-d");
		
		move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],SITEPATHDEV.$fileToUpload);
		$stQuery = "INSERT INTO  sentmessage(user_id, msg_body, photo, date) VALUES ('".$userid."', '".$msg_body."', '".$photo."','".$date."')";
		if(mysql_query($stQuery))
		{
			$return['status'] = 'Save Successfully';
			//$return['id'] = mysql_insert_id();
		}
		//echo $return['id'];
	echo $retid =  '{"Result":'.json_encode($return).'}';
		
	}
function getcategorymessage()
        {
         	$catid=$_GET['cat_id'];
         	$catstring=explode("$",$catid);
         	$subcatid=$_GET['subcat_id'];
         	$catstring=explode("$",$subcatid);
         	$tag=$_GET['cat_tag'];
         	$date=$_GET['date'];
         	for($a=0;$a<count($catstring);$a++)
         	{
         	$stSelect = "SELECT * FROM  messages where broadcastDate='".$date."' and (subCategoryId ='".$catstring[$a]."' or new_category='".$tag."')";
			$rsResult = mysql_query($stSelect) or die();
			if(mysql_num_rows($rsResult) > 0)
			{
			while($row = mysql_fetch_array($rsResult))
			{
			$return1['message'] = $row['simpleText'];
			$return1['date'] = $row['broadcastDate'];
			if(!empty($return1))
			{
			$return29[]=$return1;
			}
			}
			
			}
			else
			{
			$return11['status'] = FAILED;
			echo $r1 =  '{"Result":data:{'.json_encode($return11).'}}';	
			}
			}
			echo $r =  '{"Result":{"data":'.json_encode($return29).'}}';
			}
        
function getmaincategory()
        {
        
         	$cat ='0';
		$stSelect = "SELECT * FROM  sms_ideas where parentCategoryId='".$cat."'";
		$rsResult = mysql_query($stSelect) or die();
		if(mysql_num_rows($rsResult) > 0)
		{
		while($row = mysql_fetch_array($rsResult))
		{
		$return1['categoryname'] = $row['categoryName'];
		$return1['categoryid'] = $row['categoryId'];
		$return29[]=$return1;
		}
		echo $r =  '{"Result":{"data":'.json_encode($return29).'}}';	
		}
		else
		{
		$return11['status'] = FAILED;
		echo $r1 =  '{"Result":data:{'.json_encode($return11).'}}';	
		}
        }
        
function getsubcategory()
	{
		$subcatid =$_GET['subcat_id'];
		$stSelect = "SELECT * FROM  sms_ideas where parentCategoryId='".$subcatid."'";
		$rsResult = mysql_query($stSelect) or die();
		if(mysql_num_rows($rsResult) > 0)
		{
		while($row = mysql_fetch_array($rsResult))
		{
		$return1['categoryname'] = $row['categoryName'];
		$return1['categoryid'] = $row['categoryId'];
		$return29[]=$return1;
		}
		echo $r =  '{"Result":{"data":'.json_encode($return29).'}}';	
		}
		else
		{
		$return11['status'] = FAILED;
		echo $r1 =  '{"Result":data:{'.json_encode($return11).'}}';	
		}
	
	}
	
function getliveportal()
		{
		$mobile="mobile";
		$stSelect = "SELECT * FROM  messages where source='".$mobile."'";
		$rsResult = mysql_query($stSelect) or die();
		if(mysql_num_rows($rsResult) > 0)
		{
		while($row = mysql_fetch_array($rsResult))
		{
		$return1['messagetext'] = $row['simpleText'];
		$return1['newcategory'] = $row['new_category'];
		$return29[]=$return1;
		}
		echo $r =  '{"Result":{"data":'.json_encode($return29).'}}';	
		}
		else
		{
		$return11['status'] = FAILED;
		echo $r1 =  '{"Result":data:{'.json_encode($return11).'}}';	
		}
		}
        //http://kamaljeet.in/demo/myscript.php?action=getliveportal
       // http://kamaljeet.in/demo/myscript.php?action=getmaincategory
        
        //http://kamaljeet.in/demo/myscript.php?action=getsubcategory&subcat_id=15
//http://kamaljeet.in/demo/myscript.php?action=sentmessage&user_id=29&msg_body=first message posted by user&photo=myphoto	
//http://kamaljeet.in/demo/myscript.php?action=signin&username=rohilla&password=testing123

//http://kamaljeet.in/demo/myscript.php?action=getcategory&cat_id=0&subcat_id=15&cat_tag=organic&date=2012-12-11

//http://kamaljeet.in/demo/myscript.php?action=getmessage&date=2012-11-12&tag=wheat

//http://kamaljeet.in/demo/myscript.php?action=signup&name=harish&username=rohilla&email=test29harish@gmail.com&password=testing123&address=9329&altphone=9813098130
switch($_GET['action']) 
{
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
