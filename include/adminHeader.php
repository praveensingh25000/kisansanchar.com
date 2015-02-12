<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
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
	<title><?php echo 'Admin-'.SITE_NAME;?></title>
	<link href="<?php echo URL_SITE; ?>/css/admin/style.css" type="text/css" rel="stylesheet">
	<link href="<?php echo URL_SITE; ?>/css/admin/timeline.css" type="text/css" rel="stylesheet">
	<link href="<?php echo URL_SITE; ?>/css/admin/menu.css" type="text/css" rel="stylesheet">
	<link href="<?php echo URL_SITE; ?>/css/admin/popup.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo URL_SITE; ?>/css/admin/token-input.css" type="text/css" />
	<link rel='shortcut icon' href='<?php echo URL_SITE; ?>/images/favicon.ico' type='image/x-icon'/ >
	<script> var URL_SITE = '<?php echo URL_SITE; ?>'</script>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery-1.9.0.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery.validations.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE;?>/js/jquery.blockUI.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/js_admin.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery.tablednd.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE;?>/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery.tokeninput.js"></script>
</head>

<body class="admin">

	<!-- Wrapper -->
    <div id="wrapper">

	      <!-- top navigation -->
          <div class="headertop">
            	<div class="quicklinks">
                	<ul class="login-nav right">
						<?php if(isset($_SESSION['admin_session'])){ ?>							
							<li style="border-right:none;">
								<a href="logout.php" title="<?php echo URL_SITE; ?>/admin/Logout" class=""><i class="icon-unlock"></i><?php echo $langVariables['general_var']['logout']?></a>
							</li>
						<?php } else { ?>
							<li><a class="login" href="<?php echo URL_SITE; ?>/admin/index.php"><i class="icon-lock"></i><?php echo $langVariables['general_var']['login']?></a></li>
							<li><a target="_blank" class="login" href="<?php echo URL_SITE; ?>"><?php echo $langVariables['general_var']['frontsite']?></a></li>
						<?php } ?>
                    </ul>                   
                </div>
            </div>
            <!-- /top navigation -->

			<!-- Meaasge --->
			<?php require_once($DOC_ROOT.'include/message.php');?>
			<!-- /Message -->

      	    <header>
        	<!-- Main div -->

    		<div id="inner-mainshell">
            	<!-- header left -->
                <section class="headerleft">
                	<!-- logo -->
                    <div class="logo">
                       <a href="<?php echo URL_SITE; ?>/admin/index.php"><img class="logoimage" src="<?php echo URL_SITE; ?>/images/kisan.png" alt=""></a>
                    </div>
                    <!-- /logo -->
                    <div class="logo">
                       <a href="<?php echo URL_SITE; ?>/admin/index.php"><img class="logoimage" src="<?php echo URL_SITE; ?>/images/kisansanchar.jpg" alt="" ></a>
                    </div>
                </section>
                <!-- /header left -->

                <!-- header right -->
                <section class="headerright">
                	<nav>
                    	<ul>
                           <li></li>                           
                        </ul>
                    </nav>
					<div class="clear pT15"></div>
					
                </section>
                <!-- /header right -->

            </div>
            <!-- /Main div -->

			<!-- NAVIGATION -->
			<div id="cssmenu">
				<?php if(isset($_SESSION['admin_session'])){ ?>
					<?php require_once($DOC_ROOT.'include/admin-top-menu.php');?>
				<?php } else { echo '<ul><li>&nbsp;&nbsp;</li></ul>';} ?>
			</div>			
			<!-- /NAVIGATION -->
			
			</header>
			<!-- /header -->

			<!-- Container -->
			<section id="container">

