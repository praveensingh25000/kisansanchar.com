<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

Class ivraudioUpload {

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
	/*
	* IvrName Content the campaign name
	*/
	var $strIvrName;

	//Constructor...
	public function ivraudioUpload($host, $username, $password, $path, $ivrName) {
		$this->host        = $host;
		$this->strUserName = urlencode($username);
		$this->strPassword = urlencode($password);
		$this->strPath     = urlencode($path); //urlencoded_http_path..
		$this->strIvrName  = urlencode($ivrName);
	}

	public function Submit() {
		try {
			//Smpp http Url to Upload audio.
			echo $live_url = "http://".$this->host."/httpApi/getSurveyAudio.php?user=".$this->strUserName."&pwd=".$this->strPassword."&path=".$this->strPath."&ivrname=".$this->strIvrName;

			echo '<br>';
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $live_url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);
			$response = trim($response);
			if (strpos($response, '3001') === false) {
				throw new Exception($response);
			} else {
				return $response = trim($response);
			}
		} catch(Exception $e){
			return $e->getMessage();
		}
	}
	
}
?>