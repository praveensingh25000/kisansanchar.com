<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

class ivrCreate {
	
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
	* New Campaign name.
	*/
	var $ivrName;
	/*
	Interval in seconds
	*/
	var $interval;

	//Constructor..
	public function ivrCreate($host,$username, $password, $ivrName, $interval=10) {
		$this->host = $host;
		$this->strUserName = urlencode($username);
		$this->strPassword = urlencode($password);
		$this->ivrName     = urlencode($ivrName);
		$this->interval    = urlencode($interval);
	}
	public function Submit() {
		try {
			//http url to create new campaign.
			$live_url = "http://".$this->host. "/httpApi/genCampaign.php?user=" . $this->strUserName . "&pwd=" . $this->strPassword . "&ivrname=" . $this->ivrName. "&interval=".$this->interval;
			
			//use the curl code			
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $live_url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			$response = curl_exec($ch);
			$response = trim($response);
			
			if(strpos($response,'3001')===false){
				throw new Exception("Campaign not created");
			}else{
				return "Campaign created Successfully.";
			}
		} catch (Exception $e) {
			return 'Message:' . $e->getMessage();
		}
	}
}
?>