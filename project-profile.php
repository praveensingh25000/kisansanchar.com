<?php
/******************************************
* @Created on May 31, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
******************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

checkSession(false,2);
checkDashboard($dashbordType);

$project_id    = (defined('IS_PROJECT_ID'))?trim(IS_PROJECT_ID):'';
$pageType	   = (isset($_GET['tab']))?trim($_GET['tab']):'pls';
$actionType	   = (isset($_GET['type']))?trim($_GET['type']):'1';
?>
<div class="container">

	<h1 class="title"><?php echo ucwords($fullname); ?><?php echo $langVariables['general_var']['user_profile']?><span class="right"><a href="<?php echo URL_SITE.$timeline_url;?>">Go To Timeline</a></span></h1>

	<div class="entry">

		<div class="reportnav">
			<ul>
				<li><a <?php if(isset($pageType) && $pageType=='pls'){ ?>class="selected"<?php } ?> href="?tab=pls">Project Location Setting</a></li>
				<li><a <?php if(isset($pageType) && $pageType=='pus'){ ?>class="selected"<?php } ?> href="?tab=pus">Project Users Setting</a></li>				
			</ul>
		</div>

		<!-- PROJECT_LOCATION_SETTING --->
		<?php if(isset($pageType) && $pageType=='pls'){ ?>
			<?php require_once($DOC_ROOT.'project_location_setting.php');?>
		<?php } ?>
		<!-- /PROJECT_LOCATION_SETTING -->

		<!-- PROJECT_USERS_SETTING ------>
		<?php if(isset($pageType) && $pageType=='pus'){ ?>
			<?php require_once($DOC_ROOT.'project_users_setting.php');?>
		<?php } ?>
		<!-- /PROJECT_USERS_SETTING ---->

	</div>

</div>

<!-- FOOTER -->
<?php include_once $basedir."/include/frontFooter.php"; ?>
<!-- /FOOTER -->