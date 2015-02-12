<?php
/******************************************
* @Modified on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);

$user_groups = $db->getUniversalRowAll($table_name='user_groups');

//echo '<pre>';print_r($user_groups);echo '</pre>';die;
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading">View User Groups</h2>
		<div class="clear pB10"></div>
		<form action="" method="post" id="viewusergroup" name="viewusergroup">
			<table class="data-table">
				<tbody>
					<th><?php echo $langVariables['general_var']['id']?></th>
					<th><?php echo $langVariables['general_var']['parent_id']?></th>
					<th><?php echo $langVariables['general_var']['group_name']?></th>
					<th><?php echo $langVariables['general_var']['description']?></th>
					<th><?php echo $langVariables['general_var']['active']?></th>
					<th><?php echo $langVariables['general_var']['action']?></th>
				</tbody>
				<?php if(!empty($user_groups)){?>
					<?php foreach($user_groups as $userGroup){?>
						<tr class="wdthpercent100 pT10 pB10">
							<td><?php echo $userGroup['id'];?></td>
							<td><?php echo $userGroup['parent_id'];?></td>
							<td><?php echo $userGroup['group_name'];?></td>
							<td><?php echo $userGroup['description'];?></td>
							<td><?php echo $userGroup['is_active'];?></td>
							<td>
								<a title="delete" onclick="javascript: return delete_action();" href="?deleteid=<?php echo $userGroup['id'];?>" class="right pR10"><img src="/images/delete.png" alt="delete"/></a>
								<a title="edit" href="<?php echo URL_SITE ?>/admin/adduserGroup.php?id=<?php echo $userGroup['id'];?>&action=edit" class="right pR10"><img src="/images/edit.png" alt="edit"/></a>
							</td>
						</tr>
					 <?php } ?>				 
				<?php } ?>   
			 </table>
		</form>	
	 </div>
</section>
<!-- /Containercenter -->
<?php include_once $basedir."/include/adminFooter.php"; ?>