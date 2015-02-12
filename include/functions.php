<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

function throw_ex($er){  
  throw new Exception($er);  
} 

function encrypt($text) { 
    return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, SALT, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)))); 
} 

function decrypt($text){ 
    return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, SALT, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))); 
}

function md5Hash($password){
	return md5($password);
}

function function_json_encode($contentarray){
	return json_encode($contentarray);
}

function function_json_decode($contentjson){
	return json_decode($contentjson);
}

function checkSession($is_admin = false,$lang_msg='2'){
	if($is_admin){
		if(!isset($_SESSION['admin_session'])){
			$_SESSION['msgalert'] = $lang_msg;
			header('location: '.URL_SITE.'/admin/index.php');
			exit;
		}
	} else {
		if(!isset($_SESSION['session_user_data'])){
			$_SESSION['msgalert'] = $lang_msg;
			header('location: '.URL_SITE.'/index.php');
			exit;
		}
	}
}

function checkDashboard($dashbordType=null){
	if(!isset($dashbordType) || is_numeric($dashbordType)){
		$_SESSION['msgalert'] = '15';
		header('location: '.URL_SITE.'/index.php');
		exit;
	}
}

function checksession_with_message($sessionType,$redirectpage,$messagetype,$msgnumber){
	if($sessionType){
		if(!isset($_SESSION['admin'])){
			$_SESSION[$messagetype] = $msgnumber;
			header('location: '.$redirectpage.'');
			exit;
		}
	} else {
		if(!isset($_SESSION['user'])){
			$_SESSION[$messagetype] = $msgnumber;
			header('location: '.$redirectpage.'');
			exit;
		}
	}
}

function getTableNames($refresh = false){
	global $dbDatabase;
	$admin = new admin();
	
	if(!isset($_SESSION['tables']) || $refresh){
		$_SESSION['tables'] = array();
		$tablesResult = $admin->showAllTables();
		$tables = $dbDatabase->getAll($tablesResult);
		
		foreach($tables as $key => $tableDetail){
			$col = "Tables_in_".$dbDatabase->DBDATABASE."";
			$_SESSION['tables'][] = $tableDetail[$col];
		}
	}

	
	return $_SESSION['tables'];
}
function fetchGenralSettings($group = ""){
	global $db;
	if($group!=""){
		$sql="select * from generalsettings where groupid = '".$group."'";
	} else {
		$sql="select * from generalsettings order by groupid";
	}
	$source=$db->run_query($sql);

	$rowsAll = $db->getAll($source);

	$generalSettings = array();
	if(count($rowsAll)>0){
		foreach($rowsAll as $key => $row){
			$group = $row['groupid'];
			$generalSettings[$group][] = $row;
		}
	}

	return $generalSettings;
}
//To get extension of file
function getExtension($str){
	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}

function mail_function($receivename,$receivermail,$fromname,$fromemail,$mailbody,$subject, $attachments = array(),$addcc=array()) {
	
	$mail=new PHPmailer;//object of mailer function
	$mail->isHTML(true);
	$name= $receivename;
	$emails_to= $receivermail;				
	$mail->FromName = $fromname;
	$mail->From= $fromemail;
	$mail->AddAddress($emails_to,$receivename);
	$mail->Subject  = $subject;
	$mail->Body     = $mailbody;
	$mail->WordWrap = 50;
	
	if(!$mail->Send()){
		return false;
	}else{
		return true;
	}				
}

function getnumberofDays($startTime,$endTime) {

	$numDays	 = 0;
	$day		 = 86400;
	$startTime   = date('Y-m-d', strtotime($startTime));
	$endTime     = date('Y-m-d', strtotime($endTime));	
    $start_time  = strtotime($startTime);
    $end_time    = strtotime($endTime);
	$num_Days    = floor(($end_time - $start_time) / $day);
	if($num_Days >= 0){ $numDays = $num_Days; }
	return $numDays;
}

function getEndDatefromdays($currentDate,$numberofdays) {
	return $enddate = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($currentDate)) . " +".$numberofdays."days"));
}

function array_sort($array, $on, $order=SORT_ASC) {
	
	$new_array = array();
	$sortable_array = array();

	if (count($array) > 0) {
		foreach ($array as $k => $v)
		{
			if (is_array($v)) 
			{
				foreach ($v as $k2 => $v2) 
				{
					if ($k2 == $on) 
					{
						$sortable_array[$k] = $v2;
					}
				}
			} else {
				$sortable_array[$k] = $v;
			}
		}

		switch ($order) {
			case SORT_ASC:
				asort($sortable_array);
				break;
			case SORT_DESC:
				arsort($sortable_array);
				break;
		}

		foreach ($sortable_array as $k => $v) {
			$new_array[$k] = $array[$k];
		}
	}
	unset($array,$sortable_array);
	return $new_array;
}

function getMac(){
	$mac ='';
	exec("ipconfig /all", $output);
	foreach($output as $line){
		if (preg_match("/(.*)Physical Address(.*)/", $line)){
			$mac = $line;
			$mac = str_replace("Physical Address. . . . . . . . . :","",$mac);
		}
	}
	return $mac;
}

function getIPAddressofSystem(){
	$exec = exec("hostname"); //the "hostname" is a valid command in both windows and linux
	$hostname = trim($exec); //remove any spaces before and after
	return $ip = gethostbyname($hostname); //resolves the hostname using local hosts resolver or DNS
}

function getRealIpAddr() {
	$ip='';

    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function getPageURL() {
	 $pageURL = 'http';
	 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	return $pageURL;
}

function utf8_encoding($string,$flag=null,$encoding='UTF-8'){
	return htmlentities($string,$flag,$encoding);
}
function utf8_decoding($string,$flag=null,$encoding='UTF-8'){
	return html_entity_decode($string,$flag,$encoding);
}	
function isotoutf8($string){
	return iconv("ISO-8859-1","UTF-8//TRANSLIT",$string);
}

function currencySign($price){
	return ((CURRENCY_SIGN=='kr')?$price.CURRENCY_SIGN:CURRENCY_SIGN.$price);
}

function uploadFiles($folder, $formdata, $contentid = null) {

	global $DOC_ROOT;

	// setup dir names absolute and relative  
	$folder_url = $DOC_ROOT . $folder;
	$rel_url    = $folder;

	// if contentid is set create an contentid folder  
	if ($contentid) {
		// set new absolute folder  
		$folder_url = $DOC_ROOT . $folder . '/' . $contentid;
		// set new relative folder  
		$rel_url = $folder . '/' . $contentid;
	} else {
		// setup dir names absolute and relative  
		$folder_url = $DOC_ROOT . $folder;
		$rel_url    = $folder;
	}

	// create directory  
	if (!is_dir($folder_url)) {
		mkdir($folder_url);
		chmod($folder_url,0777); 
	}

	// list of permitted file types, this is only images but documents can be added  
	$permitted = array('image/gif', 'image/jpeg', 'image/pjpeg','image/png');

	// loop through and deal with the files  
	foreach ($formdata as $file) {
		// replace spaces with underscores  
		$filename = str_replace(' ', '_', $file['name']);
		// assume filetype is false  
		$typeOK = false;
		// check filetype is ok  
		foreach ($permitted as $type) {
			if ($type == $file['type']) {
				$typeOK = true;
				$result['errors'][] = "Error uploaded $filename.Acceptable gif|jpeg|pjpeg|mp3|wav.";
				break;
			}
		}

		// if file type ok upload the file  
		if ($typeOK) {
			// switch based on error code  
			switch ($file['error']) {
				case 0:
					// check filename already exists  
					if (!file_exists($folder_url . '/' . $filename)) {
						// create full filename  
						$full_url = $folder_url . '/' . $filename;
						// upload the file  
						$success = move_uploaded_file($file['tmp_name'], $full_url);
					} else {
						// create unique filename and upload file                              
						$now = (int) gmdate('U');
						$filename = $now . $filename;
						$full_url = $folder_url . '/' . $filename;
						$success = move_uploaded_file($file['tmp_name'], $full_url);
					}
					// if upload was successful  
					if ($success) {
						// save the url of the file                              
						$result['urls'][] = $filename;
					} else {
						$result['errors'][] = "Error uploaded $filename. Please try again.";
					}
					break;
				case 3:
					// an error occured  
					$result['errors'][] = "Error uploading $filename. Please try again.";
					break;
				default:
					// an error occured  
					$result['errors'][] = "System error uploading $filename. Contact webmaster.";
					break;
			}
		} elseif ($file['error'] == 4) {
			// no file was selected for upload  
			$result['nofiles'][] = "No file Selected";
		} else {
			// unacceptable file type  
			$result['errors'][] = "$filename cannot be uploaded. Acceptable gif|jpeg|pjpeg.";
		}
	}
	return $result;
}
function uploadAllTypeFiles($folder, $formdata, $contentid = null) {

	global $DOC_ROOT;

	$result = array();

	// if contentid is set create an contentid folder  
	if ($contentid) {
		// set new absolute folder  
		$folder_url = $DOC_ROOT . $folder . '/' . $contentid;
		// set new relative folder  
		$rel_url = $folder . '/' . $contentid;
	} else {
		// setup dir names absolute and relative  
		$folder_url = $DOC_ROOT . $folder;
		$rel_url    = $folder;
	}

	// create directory  
	if (!is_dir($folder_url)) {
		mkdir($folder_url);
		chmod($folder_url,0777); 
	}

	// list of permitted file types, this is only images but documents can be added  
	$permitted = array('image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'audio/mp3', 'audio/wav', 'audio/x-wav', 'audio/mpeg', 'video/mp4', 'application/octet-stream', 'application/msword', 'text/csv', 'application/pdf','application/vnd.ms-excel','text/comma-separated-values');

	// loop through and deal with the files  
	foreach ($formdata as $file) {
		// replace spaces with underscores  
		$filename = str_replace(' ', '_', $file['name']);
		// assume filetype is false  
		$typeOK = false;
		// check filetype is ok  
		foreach ($permitted as $type) {
			if ($type == $file['type']) {
				$typeOK = true;
				$result['errors'][] = "Error uploaded $filename.Acceptable gif|jpeg|pjpeg|mp3|wav.";
				break;
			}
		}

		// if file type ok upload the file  
		if ($typeOK) {
			// switch based on error code  
			switch ($file['error']) {
				case 0:
					// check filename already exists  
					if (!file_exists($folder_url . '/' . $filename)) {
						// create full filename  
						$full_url = $folder_url . '/' . $filename;
						// upload the file  
						$success = move_uploaded_file($file['tmp_name'], $full_url);
					} else {
						// create unique filename and upload file                              
						$now = (int) gmdate('U');
						$filename = $now . $filename;
						$full_url = $folder_url . '/' . $filename;
						$success = move_uploaded_file($file['tmp_name'], $full_url);
					}
					// if upload was successful  
					if ($success) {
						// save the url of the file                              
						$result['urls'][] = $filename;
					} else {
						$result['errors'][] = "Error uploaded $filename. Please try again.";
					}
					break;
				case 3:
					// an error occured  
					$result['errors'][] = "Error uploading $filename. Please try again.";
					break;
				default:
					// an error occured  
					$result['errors'][] = "System error uploading $filename. Contact webmaster.";
					break;
			}
		} elseif ($file['error'] == 4) {
			// no file was selected for upload  
			$result['nofiles'][] = "No file Selected";
		} else {
			// unacceptable file type  
			$result['errors'][] = "$filename cannot be uploaded. Acceptable gif|jpeg|pjpeg|mp3|wav.";
		}
	}
	return $result;
}
function dateDiffNew($time1, $time2, $precision = 6) {			// Returns difference as days, months ,weeks, seconds ,minutes etc.
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }
 
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
 
    // Set up intervals and diffs arrays
    $intervals = array('year','month','week','day','hour','minute','second');
    $diffs = array();
 
    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Set default diff to 0
      $diffs[$interval] = 0;
      // Create temp time from time1 and interval
      $ttime = strtotime("+1 " . $interval, $time1);
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
	$time1 = $ttime;
	$diffs[$interval]++;
	// Create new temp time from time1 and interval
	$ttime = strtotime("+1 " . $interval, $time1);
      }
    }
 
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
	break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
	// Add s if value is not 1

	//if ($value != 1) {
	 // $interval .= "s";
	//}

	// Add value and interval to times array
	$times[$interval] = $value  ;
	$count++;
      }
    }
 
    // Return string with times
    //return implode(", ", $times);
	return $times;
}
function date_diff_hour_min($date)
{
	$string = "";

	//global  MONTHS, MONTH, DAYS, DAY, YEARS, YEAR, MINUTE, MINS, WEEK, WEEKS;
	$todaydate = date('Y-m-d H:i:s');
	$time = dateDiffNew($date, $todaydate);
	if(array_key_exists('year', $time))
	{
		$string .= $time['year'];
		if(array_key_exists('month', $time)) {
			$string .= $time['month'];
		}
	}
	else if(array_key_exists('month', $time)) {
		if(array_key_exists('week', $time)) {
			if($time['week']>3) {
				$time['month'] = $time['month']+1;
			}
		}
		if($time['month']!=1)
			$string .= $time['month']." ".'Months';
		else
			$string .= $time['month']." ".'Month';
	}
	else if(array_key_exists('week', $time)) {
		if(array_key_exists('day', $time)) {
			if($time['day']>3) {
				$time['week'] = $time['week']+1;
			}
		}
		if($time['week']!=1)
			$string .= $time['week']." ".'Weeks';
		else
			$string .= $time['week']." ".'Week';
	}
	else if(array_key_exists('day', $time)) {
		if(array_key_exists('hour', $time)) {
			if($time['hour']>13) {
				$time['day'] = $time['day']+1;
			}
		}
		if($time['day']!=1)
			$string .= $time['day']." ".'Days';
		else
			$string .= $time['day']." ".'Day';
	}
	else if(array_key_exists('hour', $time)) {
		if(array_key_exists('minute', $time)) {
			if($time['minute']>30) {
				$time['hour'] = $time['hour']+1;
			}
		}
		if($time['hour']!=1)
			$string .= $time['hour']." ".'Hours';
		else
			$string .= $time['hour']." ".'Hour';
	}
	else if(array_key_exists('minute', $time)) {
		if($time['minute']!=1)
			$string .= $time['minute']." ".'Mins';
		else
			$string .= $time['minute']." ".'Minute';
	}
	else
	{
		$string .= "0 ".'Minute';
	}

	$string .= " ".'Ago';
	return $string;
}

function get_client_ip_address(){
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    
    return $ipaddress;
}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function show_date($date){
	return date('d M Y',strtotime($date));
}

function downloadContent($contentDetail, $type){
	global $DOC_ROOT;	
	switch($type){
		case "doc":
			$uploaded_file = $contentDetail['uploaded_file'];
			$fullPath = $DOC_ROOT."uploads/contacts/".$uploaded_file;
			break;
		default:
			break;
	}
	
	if(isset($fullPath) && file_exists($fullPath) ){
		$fsize      = filesize($fullPath);
		$path_parts = pathinfo($fullPath);

		$ext = strtolower($path_parts["extension"]); 
		switch ($ext) {
		  case "pdf": $ctype="application/pdf"; break;
		  case "exe": $ctype="application/octet-stream"; break;
		  case "zip": $ctype="application/zip"; break;
		  case "doc": $ctype="application/msword"; break;
		  case "xls": $ctype="application/vnd.ms-excel"; break;
		  case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
		  case "gif": $ctype="image/gif"; break;
		  case "png": $ctype="image/png"; break;
		  case "jpeg":
		  case "jpg": $ctype="image/jpg"; break;
		  default: $ctype="application/force-download";
		} 
		header("Pragma: public"); // required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false); // required for certain browsers
		header("Content-Type: $ctype");
		header("Content-Disposition: attachment; filename=\"".basename($fullPath)."\";" );
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".$fsize);
		ob_clean();
		flush();
		readfile( $fullPath );
	}
}

function xml2array($xml){
    $arr = $formatedarray = array();
	if(isset($xml)){
		foreach ($xml as $key => $element){
			$tag = $element->getName();
			$e = get_object_vars($element);
			if (!empty($e)){
				$arr[$tag][] = $element instanceof SimpleXMLElement ? xml2array($element) : $e;
			}else{
				$arr[$tag] = trim($element);
			}
		}
	}
    return $arr;
}

function format_array_cdr($arr){
	$formatedarray = array();
	if(!empty($arr)){
		foreach(@$arr as $arrAll){
			foreach(@$arrAll as $arrAlloneAll){
				foreach(@$arrAlloneAll as $arrAllone){
					$formatedarray = $arrAllone;
				}		
			}
		}
	}
	return $formatedarray;
}
function highlight_word($content, $searchword, $class) {
    $replace = '<span class="'.$class.'">'.$searchword.'</span>'; // create replacement
    $content = str_ireplace( $searchword, $replace, $content ); // replace content
    return $content; // return highlighted data
}
function funExplode($array){
	$return     = (isset($array['array_key_element']))?explode('_',$array['array_key_element']):'';
	return $id  = (isset($return[2]))?$return[2]:'0';
}

function getCSVData($fileDir=NULL){
	$fileData   = array();
	$handle = fopen($fileDir, "r");
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){
		$fileData[]  = $data;	
	}
	fclose($handle);
	return $fileData;
}

function getQuickExtension($filename){
	return pathinfo($filename, PATHINFO_EXTENSION);
}

function is_uploaded($filename){
	return is_uploaded_file($filename);
}

function getElement($array,$position,$delemeter='-'){
	$data = explode($delemeter,$array);
	return ((!empty($data) && array_key_exists($position,$data)))?trim($data[$position]):'';
}

function getExploded($datastr,$delemeter,$returnpart=null){
	if($returnpart==null){
		return explode($delemeter,$datastr);
	}else{
		$dataArray = explode($delemeter,$datastr);
		return (!empty($dataArray))?trim($dataArray[$returnpart]):'';
	}
}

function getImploded($data,$delemeter){
	return implode($delemeter,$data);
}

function getUserName($userDetail,$associated=null){
	if(!empty($userDetail['pfirstname']) && empty($userDetail['plastname'])){ 
		$fullname = $userDetail['pfirstname']; 
	} else if(!empty($userDetail['pfirstname']) && !empty($userDetail['plastname'])){ 
		$fullname = $userDetail['pfirstname'].' '.$userDetail['plastname']; 
	} else if(!empty($userDetail['username'])){
		$kvkvar = substr($userDetail['username'],0,3);
		if($kvkvar=='kvk'){
			$fullname = ucwords(substr($userDetail['username'],0,3).' '.substr($userDetail['username'],3));
		} else {
			$fullname = $userDetail['username'];
		}
	}
	if($associated=='both'){
		return $fullname.'('.$userDetail['phone'].')';
	}else if($associated=='join'){
		return str_replace(' ','',strtolower($fullname));
	}else if($associated=='onlyphone'){
		return trim($userDetail['phone']);
	}else{
		return $fullname;
	}
}

function sendMailToServiceProvider($sender_name,$receivename,$receivermail){
	$fromname		=	FROM_NAME;
	$fromemail		=	FROM_EMAIL;
	$mailbody		=	$receivename.', <br /><p>Please approve a sender ID : '.trim($sender_name).'</p><br />
	<p>Thank You </p>
	'.SUPPORT_TEXT.'';
	$subject     = 'Request for Sender ID Approval';	
	$send_mail   = mail_function($receivename,$receivermail,$fromname,$fromemail,$mailbody,$subject, $attachments = array(),$addcc=array());	
}

function printr($arr=array()){
	echo '<pre>';print_r($arr);echo '</pre>';die;
}
?>