<?php
class Sender {
var $host;
var $port;
/*
* Username that is to be used for submission
*/
var $strUserName;
/*
* password that is to be used along with username
*/
var $strPassword;
/*
* Job type for voice call as tts, http-audio,http-audio-contact.
*/
var $strJobType;
/*
* Message content that is to be transmitted
*/
var $strMessage;
/*
* Mobile No is to be transmitted.
*/
var $strMobile;
var $pulse;
//Constructor..
public function Sender($host,$port,$username, $password, $jobType,
$message, $tmobile,$pulse=1) {
$this->host
= $host;
$this->port =$port;
$this->strUserName = urlencode($username);
$this->strPassword = urlencode($password);
$this->strJobType = urlencode($jobType);
$this->strMessage = urlencode($message); //URL Encode The Message..
$this->strMobile = $tmobile;
$this->pulse=$pulse;
}
function Submit() {
try {
//Smpp http Url to send sms.
$live_url = "http://".$this->host. ":".$this->port."/voicetest/bulkvoice?user=" . $this->strUserName . "&pwd=" . $this->strPassword . "&jobType=" . $this->strJobType . "&dest=" . $this->strMobile ."&msg=" . $this->strMessage . "&pulse=".$this->pulse;
echo $live_url;
echo '<br>';
//use the curl code
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $live_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
$response = trim($response);

echo '<br>';
var_dump($response);
echo '<br>';echo '<br>';

if(strpos($response,'3001')===false)
{
throw new Exception("Call Can Not Be Sent. Respone Error Code :
$response");
}
else
{
echo "Call Sent Successfully.";
}
} catch (Exception $e) {
echo 'Message:' . $e->getMessage();
}
}
}


$host='121.241.242.107';
$port='8092';
$user_name='kisanvoicet';
$password='Pu1K!ta#KD';
$job_type='custom-survey-campaign';
$message='kisan_survey_test3';
$destination='291_0.22862400_1408622591';


$obj = new Sender("$host",
"$port","$user_name","$password","$job_type","$message","$destination");
$obj->Submit();
?>
