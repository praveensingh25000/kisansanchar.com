<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
*******************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$page_title			= 'All Groups';
$page_link_title	= '+Add New Group';
$page_link			= 'create-group.php'; 
$page_image			= '';

checkSession(false,2);

if(isset($_GET['group_id']) && is_numeric($_GET['group_id'])){
	$result = $adminObj->functionDeleteGroupRelatedData($_GET['group_id']);
	if($result){
		$_SESSION['msgsuccess'] = "13";	
	}else{
		$_SESSION['msgerror'] = "8";	
	}
	header("location: viewAllGroup.php");
	exit;
}

$ownersmsgroupsArray       = $db->getUniversalRowAll($table_name='sms_groups',$otherfields=" and `owner_id`='".$front_user_id."' and  `is_active` ='1'");
$ownersmsgroupsArray_obj   = new PS_PaginationArray($ownersmsgroupsArray,50,1);
$ownersmsgroupsArray       = $ownersmsgroupsArray_obj->paginate();
?>

<div class="container">

	<!-- TITLE HEADING -->
	<?php require_once($DOC_ROOT.'include/title_heading.php');?>	
	<!-- /TITLE HEADING -->

	<div class="entry bknone">
		
		<div class="pT10 pB10">
			
			<form action="" id="frmAllCat" name="frmAllCat" method="post">	
				
				<table class="data-table">
					<thead>
						<tr>
							<th bgcolor="#eeeeee">Group Name</th>
							<th bgcolor="#eeeeee">Number of Group</th>
							<th bgcolor="#eeeeee">Action</th>
						</tr>
					</thead>

					<?php if(!empty($ownersmsgroupsArray)){?>

						<tbody>
							<?php foreach($ownersmsgroupsArray as $key => $smsgroupone){
								$allgroupmemberDetail = $userDetail = array();
								$allgroupmemberDetail = $db->getUniversalRowAll($table_name='sms_groups_members', $otherfields=" and `group_id`='".$smsgroupone['id']."' and `is_active`='1' ");
								?>
							<tr>
								<td align="left"><?php echo $smsgroupone['group_name'];?></td>
								<td align="left"><?php if(!empty($allgroupmemberDetail)) { echo count($allgroupmemberDetail); } ?></td>
								<td align="left">
									<a href="addViewGroupMember.php?group_id=<?php echo $smsgroupone['id'];?>">View</a> | 
									<a onclick="return delete_action();" href="?group_id=<?php echo $smsgroupone['id'];?>">Delete</a>
								</td>
							</tr>
							<?php } ?>
						</tbody>

						<thead>
							<tr>																	
								<td bgcolor="#eeeeee" colspan="10">
									<!-- Pagination ----------->                      
									<div class="txtcenter pR20 pagination">
										<?php echo $ownersmsgroupsArray_obj->renderFullNav();  ?>
									</div>
									<!-- /Pagination -----------> 
								</td>
							</tr>
						</thead>

					<?php } else { ?>

						<tbody>
							<tr>
								<td colspan="4" align="left">No group added.</td>
							</tr>
						</tbody>			

				<?php } ?>	

				</table>

			</form>
			
		</div>		

	</div>

</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>