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
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">

	</div>
</section>
<!-- /Containercenter -->

<!-- containerRight -->
<section class="containerRight">
	<?php if(isset($_SESSION['admin'])){ ?>
		containerRight
	<?php } else { ?>
		&nbsp;
	<?php } ?>
</section>

<?php include_once $basedir."/include/adminFooter.php"; ?>