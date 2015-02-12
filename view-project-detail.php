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
$userTypes     = $db->getUniversalRowAll($table_name='user_types',$otherfields = ' and `id` in (1,2)');

if(isset($_POST['user_type'])){
	$user_type  = $_POST['user_type'];
}else if(isset($_GET['tab'])){
	$user_type  = $_GET['tab'];
}else{
	$user_type  = '1';
}

if($project_id && $user_type){
	$projectUserDataArray  = $projectObj->SelectFarmerAllUserProjectDetail($project_id,$user_type);
	$projectUserData	   = (!empty($projectUserDataArray))?$projectUserDataArray:array();
	$projectUser_obj       = new PS_PaginationArray($projectUserData,30,1,'tab=view');
	$projectUserAll        = $projectUser_obj->paginate();
	$totalProjectUser      = count($projectUserData);
}

//echo '<pre>';print_r($projectUserAll);echo '</pre>';
?>
<div class="container">

	<h1 class="title">View Project Detail<span class="right"><a href="<?php echo URL_SITE;?>/project-profile.php?tab=pus">Back</a></span></h1>

	<div class="entry">

		<div class="pT10 right pR10">
					
			<form id="user_filter_admin_form" action="" method="post">
				
				<table class="search-table">

					<tbody>
						<tr>
							<td>
								<?php echo $langVariables['form_var']['select_user_type']?>
							</td>
							<td>
								<?php if(!empty($userTypes)){?>							
									<select class="wdthpercent100" id="user_type_admin" name="user_type">
										<?php foreach($userTypes as $userType) { ?>
											<option value="<?php echo $userType['id'];?>" <?php if(isset($user_type) && $user_type == $userType['id']){ echo "selected='selected'"; } ?> ><?php echo ucwords($userType['user_type']);?></option>
										<?php } ?>							
									</select>
								<?php } ?>									
							</td>

							<td>
								<input class="button" type="submit" value="GO" name="submitsearchkey">
							</td>

						</tr>
					</tbody>
				</table>
			</form>						
		</div>
		<br class="clear" />

		<div class="wdthpercent100 pT10 pB10">
				
			<form action="" id="frmAllCat" name="frmAllCat" method="post">	
				<table class="user-table font12">
					<tbody>
						<tr>
							<th><input type="checkbox" id="click_on_all_users" /></th>
							<th><?php echo $langVariables['form_var']['user_name']?></th>
							<th><?php echo $langVariables['form_var']['phone']?></th>
							<th><?php echo $langVariables['form_var']['usertype']?></th>
							<th>State</th>
							<th>District</th>
							<th>Tehsil</th>
							<th>Village</th>
							<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $langVariables['form_var']['form_action']?></th>
						</tr>

						<?php if(!empty($projectUserAll)) { ?>

							<?php foreach($projectUserAll as $key => $userDetail){
								
								$userTypeDetail	= $db->getUniversalRow($table_name='user_types',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$userDetail['user_type'],$otherfields=null);
								?>
								
								<tr id="remove_div<?php echo $userDetail['user_id'];?>">
									<td>
										<input type="checkbox" class="ids" name="ids[]" value="<?php echo $userDetail['user_id'];?>"/>
									</td>
									<td>
										<?php echo ucwords($userDetail['pfirstname'].' '.$userDetail['plastname']); ?>
									</td>
									
									<td>
										<?php if(!empty($userDetail['phone'])){echo $userDetail['phone'];} else {echo 'Not entered';}; ?>
									</td>
									<td>
										<?php if(!empty($userTypeDetail['user_type'])){echo stripslashes($userTypeDetail['user_type']);} else {echo 'Project';}; ?>
									</td>
									<td>
										<?php echo stripslashes($userDetail['state']);?>	
									</td>
									<td>
										<?php echo stripslashes($userDetail['district']);?>		
									</td>

									<td>
										<?php echo stripslashes($userDetail['tehsil']);?>		
									</td>

									<td>
										<?php echo stripslashes($userDetail['village']);?>		
									</td>
														
									<td>
										<span id="active_inactive_<?php echo $userDetail['user_id'];?>">
											<a id="loader_div<?php echo $userDetail['user_id'];?>" onclick="javascript: FunctionRemoveUniversal('<?php echo $project_id;?>', '<?php echo $userDetail['user_id'];?>','0','loader_div','active_inactive_project_user');" href="javascript:;">Deactivate</a>
										</span> | 
										<span id="trash_<?php echo $userDetail['user_id'];?>">
											<a id="loader_div<?php echo $userDetail['user_id'];?>" onclick="javascript: FunctionRemoveUniversal('<?php echo $project_id;?>', '<?php echo $userDetail['user_id'];?>','remove_div','loader_div','remove_project_user');" href="javascript:;">Trash</a>
										</span>				
									</td>
								</tr>
							<?php } ?>

							<tr>																	
								<td colspan="9" class="txtcenter pagination">
									<!-- Pagination ----------->                      
									<?php echo $projectUser_obj->renderFullNav();  ?>
									<!-- /Pagination -----------> 
								</td>
							</tr>

						<?php } else {?>

							<tr>
								<td align="center" colspan="9">No user associated.&nbsp;&nbsp;Click here to&nbsp;<a href="add-project-detail.php?tab=<?php if(isset($user_type) && $user_type=='1'){echo '1';}else{echo '2';}?>"><?php if(isset($user_type) && $user_type=='1'){echo 'Add Farmer';}else{echo 'Add Scientist';}?></a></td>
							</tr>						

						<?php } ?>

					</tbody>
				</table>

			</form>

		</div>

	</div>

</div>

<!-- FOOTER -->
<?php include_once $basedir."/include/frontFooter.php"; ?>
<!-- /FOOTER -->