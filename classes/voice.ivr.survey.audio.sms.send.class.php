<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

class ivrserveyAudioSms {
	
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
	public function ivrserveyAudioSms($host, $username, $password, $jobType,
	$message, $tmobile,$pulse=1) {
		$this->host = $host;
		$this->strUserName = urlencode($username);
		$this->strPassword = urlencode($password);
		$this->strJobType  = urlencode($jobType);
		$this->strMessage  = urlencode($message); //URL Encode The Message..
		$this->strMobile   = $tmobile;
		$this->pulse       = $pulse;
	}
	
	function Submit() {
		try {

			//Smpp http Url to send ivr call.
			echo $live_url = "http://".$this->host."/httpApi/voiceRequster.php?app=kisan&user=" . $this->strUserName . "&pwd=" . $this->strPassword . "&jobType=" . $this->strJobType . "&dest=" . $this->strMobile ."&msg=" . $this->strMessage . "&pulse=".$this->pulse;
		
			//use the curl code
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $live_url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);
			$response = trim($response);

			echo '<br>';echo '<br>';
			var_dump($response);		
			echo '<br>';echo '<br>';

			if(strpos($response,'3001')===false){
				throw new Exception("Call Can Not Be Sent. Respone Error Code : $response");
			}else{
				return $response;
			}
		} catch (Exception $e) {
			echo 'Message:' . $e->getMessage();
		}
	}
}

?>