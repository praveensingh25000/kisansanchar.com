<?php
Class AudioSms {

	var $host;
	/*
	* Username that is to be used for submission
	*/
	var $strUserName;
	/*
	* password that is to be used along with username
	*/
	var $strPassword;
	/*
	* jobType
	*/
	var $jobType;
	/*
	* dest
	*/
	var $dest;
	/*
	* msg
	*/
	var $msg;

	//Constructor...
	public function AudioSms ($host,$username, $password, $jobType, $dest , $msg ) {
		$this->host = $host;
		$this->strUserName = urlencode ($username);
		$this->strPassword = urlencode ($password);
		$this->strJobType  = $jobType;
		$this->strDest     = $dest;
		$this->strMsg      = $msg;

	}
	public function Submit() {
		try {
			//For Campaign Generation
			$live_url = "http://".$this->host."/httpApi/genCalls.php?user=".$this->strUserName."&pwd=".$this->strPassword."&jobType=".$this->strJobType."&dest=".$this->strDest."&msg=".$this->strMsg." ";
			
			//use the curl code
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $live_url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);
			return $response = trim($response);
		} catch (Exception $e) {
			echo 'Message:' . $e->getMessage();
		}
	}
}
?>