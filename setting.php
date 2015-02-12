<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

checkSession(false,2);

$page_title			= 'Setting';
$page_link_title	= 'Write Message';
$page_link			= 'message.php'; 
$page_image			= 'message.png';
?>
<!-- CONTAINER -->
<div class="container">

	<!-- TITLE HEADING -->
	<?php require_once($DOC_ROOT.'include/title_heading.php');?>	
	<!-- /TITLE HEADING -->

	<div class="entry font15">
		
		<br class="clear" />

		<?php if(isset($dashbordType)) { ?>
		<div class="setting pT10">
			<div class="wdthpercent30 left">
				Create Group
			</div>
			<div class="wdthpercent60 left">
				<a class="right" href="<?php echo URL_SITE;?>/create-group.php">Click</a>
			</div>
		<div class="clear"></div>
		</div>
		<br class="clear" />
		<?php } ?>

		<div class="setting pT10">
			<div class="wdthpercent30 left">
				Change Password
			</div>
			<div class="wdthpercent60 left">
				<a class="right" href="<?php echo URL_SITE;?>/change-password.php">Click</a>
			</div>
		<div class="clear"></div>
		</div>

		<br class="clear" />

		<div class="setting pT10">
			<div class="wdthpercent30 left">
				Language Type Setting
			</div>
			<div class="wdthpercent60 left">
				<a class="right" href="<?php echo URL_SITE;?>/language-setting.php">Click</a>
			</div>
		<div class="clear"></div>
		</div>

		<br class="clear" />

		<div class="setting pT10">
			<div class="wdthpercent30 left">
				User Type Setting
			</div>
			<div class="wdthpercent60 left">
				<a class="right" href="<?php echo URL_SITE;?>/usertype-setting.php">Click</a>
			</div>
		<div class="clear"></div>
		</div>

		<br class="clear" />

		<div class="setting pT10">
			<div class="wdthpercent30 left">
				Content Type Setting
			</div>
			<div class="wdthpercent60 left">
				<a class="right" href="<?php echo URL_SITE;?>/categorytype-setting.php">Click</a>
			</div>
		<div class="clear"></div>
		</div>

	</div>
	<div class="clear"></div>

</div>
<!-- CONTAINER -->

<!-- FOOTER -->
<?php include_once $basedir."/include/frontFooter.php"; ?>
<!-- /FOOTER -->