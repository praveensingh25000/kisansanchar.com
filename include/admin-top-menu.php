<ul>
   <?php if(isset($_SESSION['admin_session']) && $_SESSION['admin_session']['groupid']=='2'){ ?>
	   <li class="has-sub">
	      <a href="javascript:;"><span>General</span></a>
		  <ul>
			 <li class="has-sub"><a href="javascript:;"><span>Parent Module Management</span></a>
				<ul>
				   <li><a href="<?php echo URL_SITE; ?>/admin/parentmodule.php"><span>View Parent Module</span></a></li>
				   <li class="last"><a href="<?php echo URL_SITE; ?>/admin/addparentmodule.php"><span>Add Parent Module</span></a></li>
				</ul>
			 </li>
			 <li class="has-sub"><a href="javascript:;"><span>Sub Module Management</span></a>
				<ul>
				   <li><a href="<?php echo URL_SITE; ?>/admin/addsubtmodule.php"><span>Add Sub Module</span></a></li>
				   <li><a href="<?php echo URL_SITE; ?>/admin/subtmodule.php"><span>View Sub Module</span></a></li>
				   <li class="last"><a href="<?php echo URL_SITE; ?>/admin/assignmodule.php?groupid=2"><span>Assign Site User Module</span></a></li>
				</ul>
			 </li>
			 <li class="has-sub"><a href="javascript:;"><span>Project Management</span></a>
				<ul>
				   <li><a href="<?php echo URL_SITE; ?>/admin/addProject.php"><span>Add Project</span></a></li>
				   <li><a href="<?php echo URL_SITE; ?>/admin/viewProject.php"><span>View Project</span></a></li>
				   <li class="last"><a href="<?php echo URL_SITE; ?>/admin/assignproject.php"><span>Assign Project</span></a></li>
				</ul>
			 </li>
			 
		  </ul>
	   </li>
   <?php } ?>

   <!-- function call in include/language.php File -->
   <?php if(!empty($getModuleNames)){?>	
		  <li class="has-sub">
			<a href="javascript:;"><span>Menu</span></a>
			<ul>
				<?php foreach($getModuleNames as $module_head_key => $getModuleNamesAll){?>

				<li class="has-sub">
					<a href="javascript:;"><span><?php echo $module_head_key;?></span></a>
					<ul>
						<?php foreach($getModuleNamesAll as $sub_module_link => $sub_module_name){?>
							<li>
								<a href="<?php echo URL_SITE; ?>/<?php echo $sub_module_link;?>"><span><?php echo $sub_module_name;?></span></a>
							</li>
						<?php } ?>
					</ul>
				</li>
				<?php } ?>	
			</ul>
		</li>
	<?php } ?>

	<!-- contact and Intership contact user count notification ------------>
	<?php
	$contactusArray  = $db->getUniversalRowAll($table_name='contact_us',$otherfields=' and `content_type`= "1" and `status`= "0" order by status ');
	$total_contact   = count($contactusArray);

	$contactusArray  = $db->getUniversalRowAll($table_name='contact_us',$otherfields=' and `content_type`= "2" and `status`= "0" order by status ');
	$total_int_contact   = count($contactusArray);

	if((isset($total_contact) && $total_contact > 0) || (isset($total_int_contact) && $total_int_contact > 0)){?>
		 <li class="has-sub">
	        <a href="javascript:;"><span>Notification</span>&nbsp;<span class="red">NEW</span></a>
		    <ul>
			   <li class="has-sub"><a href="javascript:;"><span>Contact Notification</span><span class="red"><?php if(isset($total_contact)) { echo '('.$total_contact.')';} ?></span></a>
				 <ul>
				    <li><a href="<?php echo URL_SITE; ?>/admin/viewContact.php"><span class="left">View Contact</span></a></li>
				 </ul>
			   </li>

			   <li class="has-sub"><a href="javascript:;"><span>Internship Notification</span><span class="red"><?php if(isset($total_int_contact)) { echo '('.$total_int_contact.')';} ?></span></a>
				 <ul>
				    <li><a href="<?php echo URL_SITE; ?>/admin/viewinternshipContact.php"><span class="left">View Internship</span></a></li>
				 </ul>
			   </li>

		   </ul>
	   </li>
	<?php } ?>
	<!-- contact and Intership contact user count notification ------------>

</ul>


