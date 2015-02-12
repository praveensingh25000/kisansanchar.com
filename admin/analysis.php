<?php
/******************************************
* @Modified on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);

$userTypes = $db->getUniversalRowAll($table_name='user_types');
$groupArray  = $langObj->functionGetSetting($tablename='group_settings', $dmlType='');

?>
<!-- containerCenter -->
<section class="containerCenter">

	<div class="containercentercnt">

		<h2 class="heading">Select Analysis Criteria</h2>
		<div class="clear pB10"></div>

		<form action="" method="post" id="addadminstaffform" name="addadminstaffform"> 

		</form>	

	</div>

</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>