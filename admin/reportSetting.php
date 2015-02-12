<?php
/******************************************
* @Modified on JULY 20, 2014
* @Package: Kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);

?>
<!-- containerCenter -->
<section class="containerCenter">

	<div class="containercentercnt">
		<h2 class="heading left">
			Report Setting
			<a class="right pR10" href="javascript:;" onclick="javascript:window.history.go(-1);"><?php echo $langVariables['general_var']['back']?></a>
		</h2>
		<div class="clear pB10"></div>		

	</div>

</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>