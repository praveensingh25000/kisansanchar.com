<?php
/******************************************
* @Created on JAN 27, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir = dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$host   		 = "routevoice.com";
$port			 = "8080";
$username		 = 'kisanvoicet';
$password		 = 'Pu1K!ta#KD';
$date		     = (isset($_GET['date']))?$_GET['date']:date('Y-m-d');

$cdrvoiceapiObj	 = new CDRVoiceApi($host, $username, $password, $date);
$cdrvoicexml     = $cdrvoiceapiObj->Submit();
$cdrvoicearray   = xml2array($cdrvoicexml);
$cdrvoiceData    = format_array_cdr($cdrvoicearray);

foreach($cdrvoiceData as $data){
	//$cdrvoiceDataArray[$data['destination']][] = $data;
}


echo '<pre>';print_r($cdrvoiceData);echo '</pre>';die;
?>