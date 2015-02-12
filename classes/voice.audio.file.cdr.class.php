<?php
/******************************************
* @Created on June 06, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

class CDRVoiceApi {

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
	* date for which log to be downloaded
	*/
	var $strDate;

	//Constructor..
	public function CDRVoiceApi($host,$username, $password, $dtDate) {
		$this->host = $host;
		$this->strUserName = urlencode($username);
		$this->strPassword = urlencode($password);
		$this->strDate     = urlencode($dtDate);
	}

	public function Submit() {
		try {
			//Smpp http Url to send sms.
			$live_url = "http://".$this->host."/httpApi/cdr.php?user=" . $this->strUserName . "&pwd=" . $this->strPassword . "&dtDate=" . $this->strDate . "";

			//use the curl code
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $live_url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);
			$response = trim($response);
			if(is_numeric($response)){
				throw new Exception("Can not extract CDR.Respone Error Code : $response");
			}else{
				return $xml_result = simplexml_load_string($response);
				//echo $response;
			}
		} catch (Exception $e) {
			echo 'Message:' . $e->getMessage();
		}
	}
}
?>