<?php
/******************************************
* @Modified on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);

$active    = $is_deleted = '0';
$onpage    = (isset($_GET['page']))?$_GET['page']:'1';
$searchkey = array();

if(isset($_GET['show']) && $_GET['show'] == 'deactive')     { $active = 1;     } 
else if(isset($_GET['show']) && $_GET['show'] == 'deleted') { $is_deleted = 1; }  
else { $_GET['show']= 'active';}

$userTypes     = $db->getUniversalRowAll($table_name='user_types');
$districtgroup = $db->getUniversalRowAll($table_name="user_groups"," and `parent_id`= '0' ORDER BY id ");

if(isset($_POST['submitsearchkey'])){
	$searchkey     = $_SESSION['searchkey'] = $_POST;
}else if(isset($_SESSION['searchkey'])){
	$searchkey     = $_SESSION['searchkey'];
}
$usersAll      = $userObj->showAllActiveDeactiveUsers($active,$is_deleted,$searchkey);
$total_users   = count($usersAll);
$usersAll_obj  = new PS_PaginationArray($usersAll,25,5);
$users		   = $usersAll_obj->paginate();
$totapages     = 'Pages: '.$onpage.' of ' .number_format($total_users/25);
?>

<!-- containerCenter -->
<section class="containerCenter">
	
	<div class="containercentercnt">
		
			<h3><a href="">List of Users <?php if(isset($total_users)) echo '('.$total_users.')'; ?></a><span class="pagecounter"><?php echo $totapages;?></span><span class="right"><a href="javascript:window.history.go(-1)"><?php echo $langVariables['general_var']['back']?></a></span></h3><br>

			<div class="tabnav left">		
				<div id="" class="wdthpercent50 left pL10 pT5">
					Show: <a <?php if(isset($_GET['show']) && $_GET['show'] == 'active') { ?> class="active" <?php } ?> href="?show=active"><?php echo str_replace(' ','-',$langVariables['form_var']['active_status']);?></a>&nbsp;&nbsp;
					<a <?php if(isset($_GET['show']) && $_GET['show'] == 'deactive'){ ?> class="active" <?php } ?> href="?show=deactive"><?php echo str_replace(' ','-',$langVariables['form_var']['inactive_status']);?></a>&nbsp;&nbsp;
					<a <?php if(isset($_GET['show']) && $_GET['show'] == 'deleted'){ ?> class="active" <?php } ?> href="?show=deleted"><?php echo $langVariables['form_var']['delete_status']?></a>
				</div>

				<div id="" class="wdthpercent90">
					
					<form id="user_filter_admin_form" action="" method="post" name="user_filter_admin_form">
						
						<table class="search-table">

							<tbody>
								<tr>
									<td>
										<?php if(!empty($userTypes)) { ?>							
											<select class="wdthpercent100" id="user_type_admin" name="user_type">
												<option value=""><?php echo $langVariables['form_var']['select_user_type']?> </option>
												<?php foreach($userTypes as $userTypes) { ?>
													<?php if($userTypes['id']!='17'){?>
														<option value="<?php echo $userTypes['id'];?>" <?php if(isset($searchkey['user_type']) && $searchkey['user_type'] == $userTypes['id']){ echo "selected='selected'"; } ?> ><?php echo ucwords($userTypes['user_type']);?></option>
													<?php } ?>	
												<?php } ?>							
											</select>
										<?php } ?>									
									</td>

									<td>
										<input class="wdthpercent90 left" placeholder="enter keyword" type="text" id="searchkey" name="searchkey" />
									</td>

									<td>
										<input type="submit" value="GO" class="left" name="submitsearchkey">
									</td>

								</tr>
							</tbody>
						</table>
					</form>						
				</div>
			</div>			
			<br class="clear" />

			<div id="" class="pT20">
				<?php if(isset($users) && count($users) > 0) { ?>
			
				<form action="action.php" id="frmAllCat" name="frmAllCat" method="post">	
					<table class="data-table">
						<tbody>

							<tr>
								<th bgcolor="#eeeeee"><input type="checkbox" id="click_on_all_users" /></th>								
								<th bgcolor="#eeeeee"><?php echo $langVariables['form_var']['user_name']?></th>
								<th bgcolor="#eeeeee">Joined On</th>
								<th bgcolor="#eeeeee"><?php echo $langVariables['form_var']['username']?></th>
								<th bgcolor="#eeeeee"><?php echo $langVariables['form_var']['email']?></th>
								<th bgcolor="#eeeeee"><?php echo $langVariables['form_var']['phone']?></th>
								<th bgcolor="#eeeeee"><?php echo $langVariables['form_var']['usertype']?></th>
								<th bgcolor="#eeeeee"><?php echo $langVariables['form_var']['is_verified']?></th>
								<th bgcolor="#eeeeee"><?php echo $langVariables['form_var']['is_block']?></th>
								<th bgcolor="#eeeeee"><?php echo $langVariables['form_var']['registration_type']?></th>
								<th bgcolor="#eeeeee"><?php echo $langVariables['form_var']['form_action']?></th>								
							</tr>

							<?php foreach($users as $key => $userDetail){

								if(!is_numeric($userDetail['user_type'])){
									$user_type = stripslashes('Project');
								}else{								
									$userTypeDetail	= $db->getUniversalRow($table_name='user_types',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$userDetail['user_type'],$otherfields=null);
									$user_type = stripslashes($userTypeDetail['user_type']);
								}
								?>
								
								<tr class="remove_class selected_<?php echo $userDetail['id'];?>">
									<td align="middle">
										<input type="checkbox" class="ids" name="ids[]" value="<?php echo $userDetail['id'];?>"/>
									</td>
									
									<td>
										<a href="<?php echo URL_SITE;?>/admin/user.php?action=view&id=<?php echo $userDetail['id'];?>"><?php echo ucwords($userDetail['pfirstname'].' '.$userDetail['plastname']); ?></a><?php if($userDetail['view_status']=='0'){?><span class="blink">New</span><?php } ?>
									</td>
									<td>
										<?php echo show_date($userDetail['date']); ?>
									</td>
									<td align="left">
										<?php if(!empty($userDetail['username'])){echo $userDetail['username'];} else {echo 'Not entered';}; ?>
									</td>
									<td>
										<?php if(!empty($userDetail['email'])){echo $userDetail['email'];} else {echo 'Not entered';}; ?>
									</td>
									<td  align="left" class="phone">
										<?php if(!empty($userDetail['phone'])){echo $userDetail['phone'];} else {echo 'Not entered';}; ?>
									</td>
									<td align="center">
										<?php echo $user_type;?>
									</td>
									<td align="center">
										<?php if($userDetail['active_status'] == '0'){ echo "No"; } else { echo "Yes"; } ?>
									</td>
									<td align="center">
										<?php if($userDetail['block_status'] == '0'){ echo "No"; } else { echo "Yes"; } ?>
									</td>
									

									<td>
										<?php if(!empty($userDetail['registration_type']) && $userDetail['registration_type']=='1'){ echo 'Site User';} else {echo 'Other User';}; ?>
									</td>
														
									<td align="center">
										<a href="<?php echo URL_SITE;?>/admin/user.php?action=view&id=<?php echo $userDetail['id'];?>">View</a>
											
									</td>

									<script type="text/javascript">
										jQuery(document).ready(function(){
											jQuery(".selected_<?php echo $userDetail['id'];?>").hover(function () {
												jQuery(".remove_class").removeClass("tab");
												jQuery(".selected_<?php echo $userDetail['id'];?>").addClass("tab");
											});
											jQuery("body,.main-cell").hover(function () {
												jQuery(".remove_class").removeClass("tab");			
											});
										});
									</script>

								</tr>

							<?php } ?>
							
							<tr>
								<td colspan="11">
									<?php if(isset($_GET['show']) && $_GET['show'] == 'active'){ ?>

										<input type="submit" name="actionperform" value="In-active" onclick="javascript: return checkUsers('deactive');"/>&nbsp;
										<input type="submit" name="actionperform" value="Delete" onclick="javascript: return checkUsers('delete');"/>

									<?php } ?>

									<?php if(isset($_GET['show']) && $_GET['show'] == 'deactive'){ ?>
										
										<input type="submit" name="actionperform" value="Active" onclick="javascript: return checkUsers('active');"/>&nbsp;
										<input type="submit" name="actionperform" value="Delete" onclick="javascript: return checkUsers('delete');"/>

									<?php } ?>

									<?php if(isset($_GET['show']) && $_GET['show'] == 'deleted'){ ?>
									
										<input type="submit" name="actionperform" value="Active" onclick="javascript: return checkUsers('active');"/>&nbsp;
										<input type="submit" name="actionperform" value="In-active" onclick="javascript: return checkUsers('deactive');"/>

									<?php } ?>
									<input type="hidden" name="show" value="<?php echo $_GET['show'];?>">
												
								</td>	
								
							</tr>

							<tr>																	
								<td bgcolor="#eeeeee" colspan="11">
									<!-- Pagination ----------->                      
									<div class="txtcenter pR20 pagination">
										<?php echo $usersAll_obj->renderFullNav();  ?>
									</div>
									<!-- /Pagination -----------> 
								</td>
							</tr>
							
						</tbody>
					</table>

				</form>

				<?php } else { ?>
					<h4>No users.</h4>				
				<?php } ?>

			</div>
	</div>

</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>