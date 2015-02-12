<?php
//$localhost = "127.0.0.1"; // YOUR LOCAL HOST, USUALLY localhost
//$dbuser = "root"; // YOUR DATABASE USERNAME
//$dbpass = "vertrigo"; // YOUR DATABASE PASSWORD
//$localhost = "localhost"; // YOUR LOCAL HOST, USUALLY localhost
//$dbuser = "root"; // YOUR DATABASE USERNAME
//$dbpass = ""; // YOUR DATABASE PASSWORD

$localhost = "192.186.222.198"; // YOUR LOCAL HOST, USUALLY localhost
$dbuser = "kisansanchar"; // YOUR DATABASE USERNAME
$dbpass = "lL5071300"; // YOUR DATABASE PASSWORD
$dbname = "kisansanchar"; // YOUR DATABASE NAME
$apiKey = "AIzaSyDpzRkVJ3aZ1G0-9dU4rV_BLlCRnjfUlV8";
$appSid = "APfdcdfbe23f5c2372f9126ef1b3c4e58b"; //  APPLICATION SID!

mysql_connect($localhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());

define('SITEPATH','/android_app/');
define('SITEPATHDEV',SITEPATH.'audios/');
define('SITEPATHWEB','/uploads/photos/');
define('SUCCESS','success');
define('FAILED','failed');
define('ERROR','error');
define('NOTFOUND','empty');
define('ALREADYEXISTS','AlreadyExists');
define('PROCEED','Proceed');
?>