<?php
Class CSVUpload {

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
	* HTTP path of the Call List
	*/
	var $strPath;

	//Constructor...
	public function CSVUpload($host,$username, $password, $path) {
		$this->host = $host;
		$this->strUserName = urlencode ($username);
		$this->strPassword = urlencode ($password);
		$this->strPath = urlencode ($path); // HTTP path of the Call List
	}
	public function Submit() {
		try {
			//Smpp http Url to Upload audio.
			$live_url = "http://".$this->host."/httpApi/getContacts.php?user=" .
			$this->strUserName. "&pwd=$this->strPassword" . "&path=$this->strPath";
			//use the curl code
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $live_url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);
			$response = trim($response);
			if(strpos($response,'33001')===false){
				throw new Exception("Unable to save Call List. Respone Error Code : $response");
			}else{
				$finalResp=explode('||',$response);
				//echo "Call List saved Successfully ,Contact File Reference Code:".$finalResp[1];
				return $finalResp[1];
			}
		} catch (Exception $e) {
			echo 'Message:' . $e->getMessage();
		}
	}
}
?>