<?php
Class AudioUpload {

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
	* Path Content the urlencoded_http_path
	*/
	var $strPath;

	//Constructor...
	public function AudioUpload ($host,$username, $password, $path) {
		$this->host = $host;
		$this->strUserName = urlencode ($username);
		$this->strPassword = urlencode ($password);
		$this->strPath = urlencode ($path); //urlencoded_http_path..
	}
	public function Submit() {
		try {
			//Smpp http Url to Upload audio.
			$live_url = "http://".$this->host."/httpApi/getAudio.php?user=".$this->strUserName."&pwd=$this->strPassword"."&path=$this->strPath";
			
			//use the curl code
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $live_url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);
			$response = trim($response);
			
			if(strpos($response,'23001')===false){
				throw new Exception("Unable to save Audio clip. Respone Error Code : $response");
			} else {
				$finalResp=explode('||',$response);
				//echo "Audio clip saved Successfully : Audio File Reference Code:".$finalResp[1];
				return $finalResp[1];
			}
		} catch (Exception $e) {
			echo 'Message:' . $e->getMessage();
		}
	}
}
?>