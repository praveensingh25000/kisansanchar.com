<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

checkSession(false,2);
?>

<div class="container">
	<h1 class="title"><?php echo $langVariables['form_var']['photo_header']?></h1>

	<div class="entry">		
	
	</div>
</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>