<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
*******************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$host_name	= "sms6.routesms.com";
$port		= "";
$username	= "kisansanchar";
$password	= "L5071300";
$sender		= "ECCAFS";
$message	= "Testing message from kisan sanchar";
$mobile		= "8699346113";
$msgtype    = "2";
$dlr		= "1";

//Call The Constructor.
$textsmsObj = new Textsms($host_name,$port,$username,$password,$sender,$message,$mobile,$msgtype,$dlr);
$response   = $textsmsObj->Submit ();

echo '<pre>';print_r($textsmsObj);echo '</pre>';
?>
<div class="container">

	<h1 class="title"></h1>

	<div class="entry bknone">
	</div>
</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>