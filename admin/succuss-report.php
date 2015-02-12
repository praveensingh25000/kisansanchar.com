<?php
/******************************************
* @Created on JAN 27, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);

if(!isset($_SESSION['succuss_result'])){
	header("location:timeline.php");
	exit;	
}

$succuscount = (isset($_SESSION['succuss_result']['succuss']))?count($_SESSION['succuss_result']['succuss']):'0';
$failedcount = (isset($_SESSION['succuss_result']['failed']))?count($_SESSION['succuss_result']['failed']):'0';
$total_message = $succuscount + $failedcount;

?>
<!-- containerCenter -->
<section class="containerCenter">

	<div class="containercentercnt">

		<h2 class="heading">Message Report</h2>
		<div class="clear pB10"></div>

		<div class="wdthpercent100 pT10">
			<div class="wdthpercent30 left">Total Message</div>
			<div class="wdthpercent70 left"><?php echo $total_message;?> </div>
			<div class="clear pB10"></div>			
		</div>

		<div class="wdthpercent100 pT10">
			<div class="wdthpercent30 left">Total Message Sent</div>
			<div class="wdthpercent70 left"><?php echo $succuscount;?> </div>
			<div class="clear pB10"></div>			
		</div>

		<div class="wdthpercent100 pT10">
			<div class="wdthpercent30 left">Total Message Failed</div>
			<div class="wdthpercent70 left"><?php echo $failedcount;?> </div>
			<div class="clear pB10"></div>			
		</div>

		<div class="wdthpercent100 pT10">
			<div class="wdthpercent30 left">&nbsp;</div>
			<div class="wdthpercent70 left">
				<a href="timeline.php"><input class="button" type="button" value="Timeline"></a>
			</div>
			<div class="clear pB10"></div>			
		</div>

	</div>

</section>
<!-- CONTAINER -->