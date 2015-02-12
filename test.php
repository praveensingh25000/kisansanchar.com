<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
*******************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$host_name  = "www.routevoice.com";
$user_name  = "kisanvoicet";
$password   = "Pu1K!ta#KD";
$job_type   = "tts";
$message    = "hai this is a testing message";
$destination= "8699346113";

echo $message_code = "http://www.routevoice.com/httpApi/getAudio.php?user=kisanvoicet&pwd=Pu1K!ta#KD&path=".urlencode('http://kisansanchar.com/uploads/audios/biharnov1.1.mp3')."";

//http://www.routevoice.com/httpApi/genCalls.php?user=snowebvoi&pwd=sno38ebv&jobType=http-audio&dest=9899553606&msg=523_0.80998800_1399794091
 
//$senderObj = new Voicesms($host_name, $user_name, $password, $job_type, $message, $destination);
//$response = $senderObj->Submit();

echo '<pre>';print_r($senderObj);echo '</pre>';
?>
<div class="container">

	<h1 class="title"></h1>

	<div class="entry bknone">
	</div>
</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>