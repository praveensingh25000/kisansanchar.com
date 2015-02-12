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
ERROR_REPORTING(E_ALL);

$pagename = basename($_SERVER['PHP_SELF']);
require_once('connect.php');
require_once($DOC_ROOT.'classes/database.class.php');
require_once($DOC_ROOT.'classes/language.class.php');
require_once($DOC_ROOT.'classes/admin.class.php');
require_once($DOC_ROOT.'classes/user.class.php');
require_once($DOC_ROOT.'classes/mailer.class.php');
require_once($DOC_ROOT.'classes/ps_pagination.php');
require_once($DOC_ROOT.'classes/ps_paginationArray.php');

$db = new db(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DB);

//getting all language variable
require_once($DOC_ROOT.'include/language.php');
require_once($DOC_ROOT.'include/functions.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Kisan Sanchar</title>
	<link href="<?php echo URL_SITE; ?>/css/style.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo URL_SITE; ?>/css/token-input.css" type="text/css" />
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="<?php echo URL_SITE; ?>/js/html5.js" type="text/javascript"></script>
	<script> var URL_SITE = '<?php echo URL_SITE; ?>'</script>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery-1.9.0.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery.validations.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE;?>/js/jquery.blockUI.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery.tablednd.js"></script>
	<script type="text/javascript" src="<?php echo URL_SITE;?>/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript" src="<?php echo URL_SITE; ?>/libraries/jquery.tokeninput.js"></script> 
	
	<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/js_actions.js"></script>	
</head>

<body class="admin">

	<!-- Wrapper -->
    <div id="wrapper">

	      <!-- top navigation -->
          <div class="headertop">

            	<div class="quicklinks">

                	<ul class="login-nav">

						<?php if(isset($_SESSION['user_session'])){ ?>							
							<li>
								<a href="logout.php" title="<?php echo URL_SITE; ?>/admin/Logout" class=""><i class="icon-unlock"></i><?php echo $langVariables['general_var']['logout']?></a>
							</li>

							<li id="profile-login">
								<a href="<?php echo URL_SITE; ?>/profile.php?action=view">Hello</a>
								<!-- /hide - show -->
								<div class="login-main-div" id="main-profile" style="display: none;">
									<div class="image-div">
										<a href="<?php echo URL_SITE; ?>/profile.php">
										   <img title="<?php echo $_SESSION['user_session']['phone'];?>" alt="<?php echo $_SESSION['user_session']['phone'];?>" width="65px" height="65px" <?php if(!empty($_SESSION['user_session']['image'])){ ?> src="<?php echo URL_SITE;?>/uploads/profiles/<?php echo $_SESSION['user_session']['id'];?>/<?php echo $_SESSION['user_session']['image']?>" <?php } else { ?> src="<?php echo URL_SITE;?>/images/profile.png" <?php } ?> />
										</a>
									</div>
									<div class="right-side">
										<ul>
											<li>
												<a href="<?php echo URL_SITE; ?>/profile.php">View Profile</a>
											</li>	
											<li>
												<a href="<?php echo URL_SITE; ?>/profile.php">Edit Profile</a>
											</li>	
										</ul>
									</div>
								</div>
								<script>
									jQuery("#profile-login").hover(function(){
										jQuery('#main-profile').show();
									},function(){
										jQuery('#main-profile').hide();
									});
								</script>
								<!-- /hide - show -->
							</li>
						<?php } else { ?>
							<li><a class="login" href="<?php echo URL_SITE; ?>/login.php"><i class="icon-lock"></i>Login</a></li>
							<li><a href="<?php echo URL_SITE; ?>/register.php">Register</a></li>
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
                       <a href="<?php echo URL_SITE; ?>/index.php"><img class="logoimage" src="<?php echo URL_SITE; ?>/images/kisan.png" alt=""></a>
                    </div>
                    <!-- /logo -->
                    <div class="logo">
                       <a href="<?php echo URL_SITE; ?>/index.php"><img class="logoimage" src="<?php echo URL_SITE; ?>/images/kisansanchar.jpg" alt="" ></a>
                    </div>
                </section>
                <!-- /header left -->

                <!-- header right -->
                <section class="headerright">
                	<nav>
                    	<ul>
                           <li></li><br>  
						</ul>
                    </nav>
					<div class="clear pT15"></div>
					
                </section>
                <!-- /header right -->

            </div>
            <!-- /Main div -->

			<nav class="category-nav category-navAdmin"><hr></nav>
			
			</header>
			<!-- /header -->

			<!-- Container -->
			<section id="container">

				<!-- containerLeft -->
				<section class="containerLeft">
				<?php if(isset($_SESSION['user_session'])){ ?>
					<?php require_once($DOC_ROOT.'include/containerLeft.php');?>
				<?php } else { ?>
					&nbsp;
				<?php } ?>
				</section>
