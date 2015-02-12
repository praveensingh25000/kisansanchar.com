<?php
/******************************************
* @Modified on MAR 4, 2014
* @Package: Kisan Sanchar
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
********************************************/
$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";
checkSession(true,2);
$viewprojectArray  = $langObj->functionGetSetting($tablename='projects', $dmlType='');
$projectsettings   = $db->getUniversalFormattedArray($viewprojectArray,$key='id');

//echo '<pre>';print_r($projectsettings);echo '</pre>';
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading">
			<?php echo $langVariables['general_var']['view_project']?>
		</h2>
		<div class="clear pB10"></div>
		<form action="" method="post" id="viewprojectsetting" name="viewprojectsetting">
			<?php if(!empty($projectsettings)){?>
				<table class="data-table">
					<tbody>
							<th><?php echo $langVariables['project']['project_id']?></th>
							<th><?php echo $langVariables['project']['project_name']?></th>
							<th><?php echo $langVariables['project']['project_admin_name']?></th>
							<th><?php echo $langVariables['project']['project_assign_user']?></th>
							<th><?php echo $langVariables['project']['project_assign_staff']?></th>
							<th><?php echo $langVariables['project']['is_active']?></th>
							<th><?php echo $langVariables['project']['project_action']?></th>
					 </tbody>
					 <?php foreach($projectsettings as $id => $projectAll){
					 $projectheadArray  = $langObj->functionGetSetting($tablename='projects', $dmlType='1', $id);
			         ?>					
						 <?php foreach($projectAll as $project){?>							
							<tr>
								<td><?php echo $project['id'];?></td>
								<td><?php echo $project['project_name'];?></td>
								<td><?php echo $project['super_admin'];?></td>
								<td><?php echo $project['assigned_users'];?></td>
								<td><?php echo $project['assigned_staff'];?></td>
								<td><?php echo $project['is_active'];?></td>
								<td>
									<a title="edit" href="<?php echo URL_SITE ?>/admin/addProject.php?id=<?php echo $project['id'];?>&action=edit" class="right pR10"><img src="/images/edit.png"/></a>
								</td>
							</tr>
															
						 <?php } ?>				
					 <?php } ?>
				 </table>
			<?php } ?>
		</form>	
	</div>
</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>