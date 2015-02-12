<?php
/******************************************
* @Modified on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);

$active = $is_deleted = 0;

if(isset($_GET['show']) && $_GET['show'] == 'deactive')     { $active = 1;     } 
else if(isset($_GET['show']) && $_GET['show'] == 'deleted') { $is_deleted = 1; }  
else { $_GET['show']= 'active';}

$usersResult = $adminObj->showAllActiveDeactiveStaff($active,$is_deleted);
$total	     = $db->count_rows($usersResult);
$usersAll    = $db->getAll($usersResult);
$total_users = count($usersAll);

$staffObj    =	new PS_PaginationArray($usersAll,500,5);
$staffArray  =	$staffObj->paginate();

if(isset($_POST['actionperform'])){
	$action		= strtolower($_POST['actionperform']);
	$ids		= implode(',', $_POST['ids']);
	$showurl	= trim($_POST['show']);	
	$tablename='users';	
	if($action =='active'){
		$_SESSION['msgsuccess'] = "9";
		$status=0;  
	} else if($action =='in-active'){	
		$_SESSION['msgsuccess'] = "9";
		$status=1;  
	} else if($action =='delete'){
		$_SESSION['msgsuccess'] = "9";
		$status=1; 
	}
	$return = $adminObj->activedeactiveStatus($tablename, $ids, $action,$status);
	header('location: staff.php?show='.$showurl.' ');
	exit;
}
?>

<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading" style="width:95%"><?php echo $langVariables['heading_var']['staff_heading']?></h2>
		
		<div class="tabnav left">		
				<div id="" class="wdthpercent30 left pL10 pT5">
					Show: <a <?php if(isset($_GET['show']) && $_GET['show'] == 'active') { ?> class="active" <?php } ?> href="?show=active"><?php echo $langVariables['general_var']['active']?></a>&nbsp;&nbsp;
					<a <?php if(isset($_GET['show']) && $_GET['show'] == 'deactive'){ ?> class="active" <?php } ?> href="?show=deactive"><?php echo $langVariables['general_var']['inactive']?></a>&nbsp;&nbsp;
					<a <?php if(isset($_GET['show']) && $_GET['show'] == 'deleted'){ ?> class="active" <?php } ?> href="?show=deleted"><?php echo $langVariables['form_var']['delete_status']?></a>
				</div>

				<div id="" class="wdthpercent40 right pR10">
					<div class="wdthpercent20 left"><span class="listform"><?php echo $langVariables['general_var']['search']?></span></div>
					<div class="wdthpercent70 left">
						<input class="wdthpercent100" placeholder="enter phone" type="text" id="searchContent" style="width: 189px;"/>			
					</div>							
				</div>
			</div>			
			<br class="clear" />

		<div class="clear pB10"></div>
		<form action="" method="post" id="addadminstaffform" name="addadminstaffform">			
			<table class="data-table" id="grid_view">
				<tbody>
					<th><input type="checkbox" id="click_on_all_users" /></th>
					<th><?php echo $langVariables['form_var']['firstname']?></th>
					<th><?php echo $langVariables['form_var']['lastname']?></th>
					<th><?php echo $langVariables['form_var']['username']?></th>
					<th><?php echo $langVariables['form_var']['email']?></th>
					<th><?php echo $langVariables['form_var']['phone']?></th>
					<th><?php echo $langVariables['form_var']['usertype']?></th>
					<th><?php echo $langVariables['form_var']['gender']?></th>
					<th><?php echo $langVariables['form_var']['form_action']?></th>
				</tbody>
				<?php if(!empty($staffArray)){?>
				   <?php foreach($staffArray as $staff){?>
						<tr class="remove_class selected_<?php echo $staff['id'];?>">
						    <td align="middle">
								<input type="checkbox" class="ids" name="ids[]" value="<?php echo $staff['id'];?>"/>
							</td>
							<td><?php echo $staff['pfirstname'];?></td>
							<td><?php echo $staff['plastname'];?></td>
							<td><?php echo $staff['username'];?></td>
							<td><?php echo $staff['email'];?></td>
							<td  align="left" class="phone"><?php echo $staff['phone'];?></td>
							<td><?php echo $staff['user_type'];?></td>
							<td><?php echo $staff['gender']?></td>
							<td>
								<a title="delete" onclick="javascript: return delete_action();" href="?deleteid=<?php echo $staff['id'];?>" class="right pR10"><img src="/images/delete.png" alt="delete"/></a>
								<a title="edit" href="<?php echo URL_SITE ?>/admin/addstaff.php?id=<?php echo $staff['id'];?>&action=edit" class="right pR10"><img src="/images/edit.png" alt="edit"/></a>
							</td>
							<script type="text/javascript">
								jQuery(document).ready(function(){
									jQuery(".selected_<?php echo $staff['id'];?>").hover(function () {
										jQuery(".remove_class").removeClass("tab");
										jQuery(".selected_<?php echo $staff['id'];?>").addClass("tab");
									});
									jQuery("body,.main-cell").hover(function () {
										jQuery(".remove_class").removeClass("tab");			
									});
								});
							</script>
						</tr>	
					 <?php } ?>

					 <tr>
						<td colspan="8">
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
						<td bgcolor="#eeeeee" colspan="8">
							<!-- Pagination ----------->                      
							<div class="txtcenter pR20 pagination">
								<?php echo $staffObj->renderFullNav();  ?>
							</div>
							<!-- /Pagination -----------> 
						</td>
					</tr>
				<?php } else { ?>
					<tr>																	
						<td colspan="9"><h4>No Staff.</h4></td>					
					</tr>								
				<?php } ?>
			</table>
		</form>	
	</div>
</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>