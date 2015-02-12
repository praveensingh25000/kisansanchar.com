<?php 

echo '<title>Voice SMS</title>';

require('classes/voice.audio.csv.upload.class.php');
require('classes/voice.audio.file.upload.class.php');
require('classes/voice.audio.send.sms.class.php');

die('Blocked by Praveen Singh');

$host   	= "routevoice.com";
$port		= "8080";
$username   = 'kisanvoicet';
$password   = 'Pu1K!ta#KD';
$jobType    = 'http-audio-contact';
//$jobType  = 'http-audio';
$audio_path = 'http://kisansanchar.com/uploads/audios/biharnov1.1.wav';
$csv_path   = 'http://kisansanchar.com/uploads/audios/kisancsv.csv';

$audiouploadObj			 = new AudioUpload($host, $username, $password, $audio_path);
$voice_clip_ref_no		 = $audiouploadObj->Submit();

$csvuploadObj            = new CSVUpload($host, $username, $password, $csv_path);
$dest_csv_path_ref_no    = $csvuploadObj->Submit();

$audiosmsObj			 = new AudioSms ($host, $username, $password, $jobType, $dest_csv_path_ref_no, $voice_clip_ref_no);
$responseCode			 = $audiosmsObj->Submit();

if($responseCode == '3001'){
	echo 'Voice Message Sent';exit;
}else {
	echo 'Voice Message sending failed';exit;
}
?>