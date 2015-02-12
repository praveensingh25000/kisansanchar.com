<?php
/******************************************
* @Created on JUNE 20, 2014
* @Package: Kisan Sanchar
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
*******************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$languageSelectedArray = $db->getUniversalRowAll($table_name='language',$otherfields=" and `status` = '1' and `orderby`!='0' order by orderby ");
$languageUnSelectedArray = $db->getUniversalRowAll($table_name='language',$otherfields=" and `status` = '1' and `orderby`='0' order by orderby ");
?>

<div class="container">

	<h1 class="title">Search</h1>

	<div class="entry">		
		<!-- call transliterate service -->
		<?php require($DOC_ROOT.'api/googleTranslateSearch.php');?> 
		<!-- call transliterate service -->	
	</div>
</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>