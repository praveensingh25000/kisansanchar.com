<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

ob_start();
session_start();

ini_set("display_errors","2");
ERROR_REPORTING(0);
//ERROR_REPORTING(E_ALL);

ini_set('max_execution_time', '8000');
ini_set('memory_limit', '11500000000000M');

$array = array();

$pagename = basename($_SERVER['PHP_SELF']);

require_once('connect.php');
require_once($DOC_ROOT.'classes/database.class.php');
require_once($DOC_ROOT.'classes/language.class.php');
require_once($DOC_ROOT.'classes/admin.class.php');
require_once($DOC_ROOT.'classes/user.class.php');
require_once($DOC_ROOT.'classes/search.class.php');
require_once($DOC_ROOT.'classes/analysis.class.php');
require_once($DOC_ROOT.'classes/message.class.php');
require_once($DOC_ROOT.'classes/project.class.php');
require_once($DOC_ROOT.'classes/videoembed.class.php');
require_once($DOC_ROOT.'classes/textsms.class.php');
require_once($DOC_ROOT.'classes/voice.audio.csv.upload.class.php');
require_once($DOC_ROOT.'classes/voice.audio.file.upload.class.php');
require_once($DOC_ROOT.'classes/voice.audio.send.sms.class.php');
require_once($DOC_ROOT.'classes/voice.audio.file.cdr.class.php');
require_once($DOC_ROOT.'classes/voice.ivr.survey.create.ivrname.class.php');
require_once($DOC_ROOT.'classes/voice.ivr.survey.audio.upload.class.php');
require_once($DOC_ROOT.'classes/voice.ivr.survey.audio.csv.upload.class.php');
require_once($DOC_ROOT.'classes/voice.ivr.survey.audio.sms.send.class.php');
require_once($DOC_ROOT.'classes/mailer.class.php');
require_once($DOC_ROOT.'classes/ps_pagination.php');
require_once($DOC_ROOT.'classes/ps_paginationArray.php');

$db = new db(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DB);

//getting all language variable
require_once($DOC_ROOT.'include/language.php');
require_once($DOC_ROOT.'include/functions.php');
require_once($DOC_ROOT.'include/setting.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>	
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo SITE_NAME;?></title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link href="<?php echo URL_SITE; ?>/css/style.css" type="text/css" rel="stylesheet">
	<link href="<?php echo URL_SITE; ?>/css/timeline.css" type="text/css" rel="stylesheet">	
	<link rel="stylesheet" href="<?php echo URL_SITE; ?>/css/token-input.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo URL_SITE; ?>/css/jquery.pageLoader.css" type="text/css" />
	<!-- <link rel='shortcut icon' href='<?php echo URL_SITE; ?>/images/favicon.ico' type='image/x-icon'/ > -->
	<script> var URL_SITE = '<?php echo URL_SITE; ?>'</script>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery-1.9.0.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery.validations.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE;?>/js/jquery.blockUI.js"></script>	
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery.tablednd.js"></script>	
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery.form.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE;?>/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery.tokeninput.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery.pageLoader.js"></script>
	<?php if($pagename == 'message.php'){?>
	<link rel="stylesheet" href="<?php echo URL_SITE; ?>/css/jquery.datetimepicker.css" type="text/css" />
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery.datetimepicker.js"></script>
	<?php } ?>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/js_actions.js"></script>	
</head>

<body>

	<!-- HEADER -->
	<?php require_once($DOC_ROOT.'include/top_header.php');?>	
	<!-- /HEADER -->

	<!-- Pagecontent -->
	<div id="Pagecontent" <?php if(in_array($pagename,$divtonotShowArray)){?>style="width:100%"<?php } ?>>
	    
		<!-- Meaasge --->
		<?php require_once($DOC_ROOT.'include/message.php');?>
		<!-- /Message -->

		<?php if(!in_array($pagename,$divtonotShowsidebarleft) || in_array($pagename,$divtoshowArray)){?>
		<!-- start sidebarleft -->		
	    <?php require_once($DOC_ROOT.'include/sidebarleft.php');?>			
		<!-- end sidebarleft -->
		<?php } ?>

		<!-- start content -->
		<div id="content" 
		<?php 
		if(in_array($pagename,$divtonotShowArray) && $pagename!='search.php'){?>
			style="float: left;width:160%"
		<?php } else if($pagename=='search.php') { ?>
			style="float: left;width:96%"
		<?php } else if($pagename=='reports.php'){ ?>
			style="float: left;width:79%"
		<?php } ?>
		<?php if(!empty($divtonotShowsidebarright) && in_array($pagename,$divtonotShowsidebarright)){?>
			style="float: left;width: 80%;"
		<?php } ?>
		>		
		