<div class="top_border"></div>
<div class="headbg">






<div id="header">
	<div id="logo">
		<h1>
			<?php if(!isset($_SESSION['session_user_data'])){ ?>
			<a href="<?php echo URL_SITE.$timeline_url;?>"><?php echo SITE_NAME;?></a>
			<?php } else {?>
			<a href="<?php echo URL_SITE.$timeline_url;?>"><?php echo SITE_NAME;?></a>
			<?php } ?>
			<br>
			<span class="cin">CIN:U85300DL2012NPL232913</span>
		</h1>
		
	</div>
	<div id="menu">
		<ul>
			<li><a href="<?php echo URL_SITE.$timeline_url;?>">Home</a></li>
			<li><a href="<?php echo URL_SITE; ?>/acknowledgement.php">Acknowledgement</a></li>
			<li><a href="<?php echo URL_SITE; ?>/beneficiary.php">Beneficiaries</a></li>
			<li><a href="<?php echo URL_SITE; ?>/cdownload.php">Download</a></li>
			<li><a href="<?php echo URL_SITE; ?>/carrers.php">Internship</a></li>			
			<?php if(!isset($_SESSION['session_user_data']) && USER_REGISTRATION == '1'){ ?>	
			<li><a href="<?php echo URL_SITE; ?>/register.php">Register</a></li>
			<?php } ?>			
			<li><a href="<?php echo URL_SITE; ?>/search.php">Search</a></li>			
			<li><a href="<?php echo URL_SITE; ?>/videos.php">Videos</a></li>
			<li><a href="<?php echo URL_SITE; ?>/news.php">News</a></li>
			<li><a href="<?php echo URL_SITE; ?>/alumni.php">Alumni</a></li>
			<li><a target="_blank" href="https://play.google.com/store/apps/details?id=com.kisansanchar.org">Apps</a></li>
			<li><a href="<?php echo URL_SITE; ?>/contact.php">Contact</a></li>			
			<?php if(isset($_SESSION['session_user_data'])){ ?>
			<li id="profile-login" class="last">
				<a href="<?php echo URL_SITE; ?>/profile.php?action=view">My Account</a>
					<!-- /hide - show -->
					<div class="login-main-div" id="main-profile" style="display: none;">		
						<ul style="padding:0px 0px 0px;">
							<li>
								<a href="<?php echo URL_SITE; ?>/profile.php?action=view">Profile</a>
							</li>
							<li>
								<a href="<?php echo URL_SITE; ?>/setting.php">Setting</a>
							</li>
							<li>
								<a href="<?php echo URL_SITE; ?>/logout.php"><?php echo $langVariables['general_var']['logout']?></a>
							</li>											
						</ul>									
					</div>					
					<!-- /hide - show -->
				</a>				
			</li>
			<?php } ?>
		</ul>
	</div>

	<!-- <div id="search">
		<!-- call transliterate service -->
		<?php //require($DOC_ROOT.'api/googleTranslateSearch.php');?> 
		<!-- call transliterate service --
	</div> -->

</div>
</div>