<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$userTypes = $db->getUniversalRowAll($table_name='user_types');
?>
<!-- CONTAINER -->
<div class="container">
	
	<h1 class="title">Kisan Feeds <div class="right"><a href="<?php echo URL_SITE; ?>/writeMessage.php">Write Message</a></div></h1>
	
	<p class="meta"></p>
	
	<div class="entry">
		
	</div>

</div>
<!-- CONTAINER -->

<!-- FOOTER -->
<?php include_once $basedir."/include/frontFooter.php"; ?>
<!-- /FOOTER -->