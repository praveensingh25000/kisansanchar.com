<?php
/******************************************
* @Modified on JAN 26, 2014
* @Package: Kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);

$category_id = $description = '';

if(!isset($_GET['owner_id'])){
	$_SESSION['msgalert'] = "8";
	header("location: viewAllReportSmsGroup.php");
	exit;
}

$owner_id = (isset($_GET['owner_id']))?trim($_GET['owner_id']):'';

$ownersmsgroupsArray       = $db->getUniversalRowAll($table_name='sms_groups',$otherfields=" and `owner_id`='".$owner_id."' and  `is_active` ='1'");
$ownersmsgroupsArray_obj   = new PS_PaginationArray($ownersmsgroupsArray,50,1);
$ownersmsgroupsArray       = $ownersmsgroupsArray_obj->paginate();
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading left">Individual Groups Detail<span class="right"><a onclick="javascript:history.go(-1)" href="javascript:;">Back</a></span></h2>
		<div class="clear pB10"></div>
		
		<div class="pT10 pB10">
			
			<form action="" id="frmAllCat" name="frmAllCat" method="post">	
				
				<table class="data-table">
					<thead>
						<tr>
							<th bgcolor="#eeeeee">GROUPID</th>
							<th bgcolor="#eeeeee">Owner Name</th>
							<th bgcolor="#eeeeee">Group Name</th>
							<th bgcolor="#eeeeee">Number of Group Members</th>
							<th bgcolor="#eeeeee">Action</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($ownersmsgroupsArray as $key => $smsgroupone){
							$allgroupmemberDetail = $userDetail = array();
							$userDetail     = $db->getUniversalRow($table_name='users', $coloum_name_str='*', $updated_on_field='id', $updated_on_value=$smsgroupone['owner_id'], $otherfields='');
							$allgroupmemberDetail = $db->getUniversalRowAll($table_name='sms_groups_members', $otherfields=" and `group_id`='".$smsgroupone['id']."' and `is_active`='1' ");			
							?>
						<tr>
							<td align="left"><?php echo $smsgroupone['id'];?></td>
							<td align="left"><?php echo $userObj->getUserName($userDetail);?></td>
							<td align="left"><?php echo $smsgroupone['group_name'];?></td>
							<td align="left"><?php if(!empty($allgroupmemberDetail)) { echo count($allgroupmemberDetail); } ?></td>
							<td align="left"><a href="addViewReportSmsGroupMember.php?group_id=<?php echo $smsgroupone['id'];?>">View Members</a></td>
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

				</table>

			</form>
			
		</div>

	</div>

</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>