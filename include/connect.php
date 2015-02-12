<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

ini_set('memory_limit', '-1');
ini_set('post_max_size', '40M');
ini_set('upload_max_filesize', '40M');
ini_set('max_file_uploads', '10');

define('DATABASE_HOST', '192.186.222.198');
define('DATABASE_USER', 'kisansanchar');
define('DATABASE_PASSWORD', 'lL5071300');
define('DATABASE_DB', 'kisansanchar');

$DOC_ROOT      = $_SERVER['DOCUMENT_ROOT'].'/';
$protocolArray = explode('/', $_SERVER['SERVER_PROTOCOL']);
$URL_SITE      = strtolower($protocolArray[0]).'://'.$_SERVER['HTTP_HOST'];

define('URL_SITE', $URL_SITE);
define('DOC_ROOT', $DOC_ROOT);
define('SALT', 'kisansanchar'); 
define('INFO_EMAIL', 'info@kisanasanchar.com');

//TEXT MSG API DETAIL
define('TEXT_HOST_NAME', 'sms6.routesms.com');
define('TEXT_PORT', '');
define('TEXT_USERNAME', 'kisansanchar'); 
define('TEXT_PASSWORD', 'L5071300');
define('TEXT_MSGTYPE', '2');
define('TEXT_DLR', '1');

//VOICE MSG API DETAIL
define('VOICE_HOST_NAME', 'routevoice.com');
define('VOICE_PORT', '8080');
define('VOICE_USERNAME', 'kisanvoicet'); 
define('VOICE_PASSWORD', 'Pu1K!ta#KD');

//SETS THE TIMEZONE OR REGION
$timezone = "Asia/Calcutta"; 
if(function_exists('date_default_timezone_set')){
    date_default_timezone_set($timezone); 
}
$current_date = Date('Y-m-d H:i:s');
define('CURRENT_DATE', $current_date);

$groupsArray = array(0 => 'Site Settings', '1' => 'Email Settings', '2' => 'Contact Settings', '3' => 'Facebook Settings', '4' => 'Twitter Settings', '5' => 'Google Settings', '6' => 'Linked In Settings','7' => 'Group Plan Setting','8' => 'IPs and Mail Setting');
?>