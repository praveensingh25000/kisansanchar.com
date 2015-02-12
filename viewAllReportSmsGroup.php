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

$smsgroupsArray  = $db->getUniversalRowAll($table_name='sms_groups',$otherfields=" and `is_active` ='1'");
$smsgroups_obj   = new PS_PaginationArray($smsgroupsArray,50,1);
$smsgroupsAll    = $smsgroups_obj->paginate();
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading left">All Groups</h2>
		<div class="clear pB10"></div>
		
		<div class="pT10 pB10">
			
			<form action="" id="frmAllCat" name="frmAllCat" method="post">	
				
				<table class="data-table">
					<thead>
						<tr>
							<th bgcolor="#eeeeee">GROUPID</th>
							<th bgcolor="#eeeeee">Owner Name</th>
							<th bgcolor="#eeeeee">Number of Group</th>
							<th bgcolor="#eeeeee">Action</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($smsgroupsAll as $key => $smsgroupone){
							$allgroupDetail = $userDetail = array();
							$userDetail     = $db->getUniversalRow($table_name='users', $coloum_name_str='*', $updated_on_field='id', $updated_on_value=$smsgroupone['owner_id'], $otherfields='');
							$allgroupDetail = $db->getUniversalRowAll($table_name='sms_groups', $otherfields=" and `owner_id`='".$smsgroupone['owner_id']."' and `is_active`='1' ");			
							?>
						<tr>
							<td align="left"><?php echo $smsgroupone['id'];?></td>
							<td align="left"><?php echo $userObj->getUserName($userDetail);?></td>
							<td align="left"><?php if(!empty($allgroupDetail)) { echo count($allgroupDetail); } ?></td>
							<td align="left"><a href="<?php echo $smsgroupone['id'];?>">View groups</a></td>
						</tr>
						<?php } ?>
					</tbody>

					<thead>
						<tr>																	
							<td bgcolor="#eeeeee" colspan="10">
								<!-- Pagination ----------->                      
								<div class="txtcenter pR20 pagination">
									<?php echo $smsgroups_obj->renderFullNav();  ?>
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