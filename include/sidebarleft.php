<div class="sidebar" id="Sidebarleft">
	<ul>
		<?php if(USER_LOGIN == '1'){ ?>		
			<?php if($session_set == '0'){?>			
			<!-- LOGIN -->
			<li id="login">
				<h2>Login</h2>
				<div id="login_wrap">
				
					<!-- start sidebarleft -->		
					<?php require_once($DOC_ROOT.'login.php');?>			
					<!-- end sidebarleft -->
					
					<?php if(USER_REGISTRATION == '1'){ ?>
						<div class="account">Need an account!</div>
						<div class="">Click here to <a href="<?php echo URL_SITE; ?>/register.php">Register</a></div>
					<?php } ?>	
					
				</div>
			</li>
			<!-- /LOGIN -->

			<?php } else { ?>

			<?php 
			$userDetail = $db->getUniversalRow($table_name='users',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$_SESSION['session_user_data']['id'],$otherfields=null);
			?>

			<!-- LOGINED IN -->
			<li id="login">
				<h2><?php echo ucwords($userDetail['pfirstname'].' '.$userDetail['plastname']);?></h2>
				
				<div class="profile-pic">
				
					<div class="usimg">
						<a href="<?php echo URL_SITE; ?>/profile.php?id=<?php echo $userDetail['id'];?>&action=view">
							<img class="pic" title="<?php echo $userDetail['pfirstname'];?>" alt="<?php echo $userDetail['image'];?>" <?php if(!empty($userDetail['image'])){ ?> src="<?php echo URL_SITE;?>/classes/showimage.php?filename=../uploads/users/<?php echo $userDetail['id'];?>/<?php echo $userDetail['image']?>&width=150&height=150" <?php } else { ?> src="<?php echo URL_SITE;?>/classes/showimage.php?filename=../images/profile.png&width=150&height=150" <?php } ?> />
						</a>
					</div>					
					
					<!------- CHANGE PHOTO ----------->
					<?php if(PROFILE_IMAGE == '1'){ ?>
					<div class="pT5 pB5"><a href="javascript:;" id="change-image">Change Photo</a></div>	
					<div id="content-upload-image" style="display:none;">
						<?php include_once($DOC_ROOT.'upload.php');?>
					</div>					
					<div class="clear"></div>
					<?php } ?>

					<!------- CHANGE PHOTO ------------->
					<?php if(EDIT_PROFILE == '1'){ ?>
					<div class="pT5 pB5">
						<?php if(defined('PROJECTDASHBORD')){?>
							<a href="<?php echo URL_SITE; ?>/project-profile.php?id=<?php echo $userDetail['id'];?>&action=edit">Associated Users</a>
						<?php } else { ?>
							<a href="<?php echo URL_SITE; ?>/profile.php?id=<?php echo $userDetail['id'];?>&action=edit">Modify Profile</a>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if(defined('PROJECTDASHBORD')){?>
						<div class="pT5 pB5"><a href="<?php echo URL_SITE; ?>/reports.php">Generate Report</a></div>
					<?php } ?>

				</div>
			</li>
			<!-- /LOGINED IN -->

			<?php } ?>

		<?php } ?>

		<?php if($session_set != '0'){?>
		<li id="categories-1">
			<h2>Content Menu</h2>
			<ul>							
				<li>
					<a class="" href="<?php echo URL_SITE; ?>/mydashboard.php">My Messages</a>
				</li>
			</ul>
		</li>		
		<?php } ?>

		<li id="categories-1">
		    <!-- start sidebarleft -->		
			<?php require_once($DOC_ROOT.'include/category_list.php');?>			
			<!-- end sidebarleft -->			
		</li>

	</ul>
</div>