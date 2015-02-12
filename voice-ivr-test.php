<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
*******************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$host_name       = "www.routevoice.com";
$user_name       = "kisanvoicet";
$password        = "Pu1K!ta#KD";

$job_type        = "custom-survey-campaign";
$ivrName         = 'kisan_survey_test9';

//Creating IVR Name
$ivrcreateObj	 = new ivrCreate($host_name,$user_name, $password, $ivrName, $interval=10);
echo '<b>STEP 1: </b>'.$ivrcreate_ref_no	= $ivrcreateObj->Submit();

echo '<br>';echo '<br>';

echo '<b>STEP 2: </b>';
echo '<br>';echo '<br>';

//Uploading AUDIO
$audio_path_array = array('0'=>$URL_SITE.'/uploads/temp/survey_question1.wav','1'=>$URL_SITE.'/uploads/temp/survey_question2.wav');
foreach($audio_path_array as $audio_path){
	$audiouploadObj	     = new ivraudioUpload($host_name, $user_name, $password, $audio_path, $ivrName);
	$voice_clip_ref_no[] = $audiouploadObj->Submit();
}

echo '<pre>';print_r($voice_clip_ref_no);echo '</pre>';
echo '<br>';echo '<br>';

//Uploading CSV
$csv_path        = $URL_SITE.'/uploads/temp/test.csv';
$csvuploadObj    = new ivrCSVUpload($host_name, $user_name, $password, $csv_path);
echo '<b>STEP 3: </b>'.$dest_csv_path_ref_no    = $csvuploadObj->Submit();

echo '<br>';echo '<br>';

//SENDING IVR CALL
//$ivrserveyaudiosmsObj	= new ivrserveyAudioSms ($host_name, $user_name, $password, $job_type, $ivrName, $dest_csv_path_ref_no);
//echo '<b>STEP 4: </b>'.$responseCode	= $ivrserveyaudiosmsObj->Submit();

echo '<br>';echo '<br>';
?>
<div class="container">

	<h1 class="title">IVR Survey Test</h1>

	<div class="entry bknone">
	</div>
</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>