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

$userTypes = $db->getUniversalRowAll($table_name='user_types');

//echo '<pre>';print_r($groupArray);echo '</pre>';die;
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading"><?php echo $langVariables['user_type']['user_type_heading']?></h2>
		<div class="clear pB10"></div>
		<form action="" method="post" id="viewformsetting" name="viewformsetting">
			<table class="data-table">
				<tbody>
					<th><?php echo $langVariables['user_type']['user_type_id']?></th>
					<th><?php echo $langVariables['user_type']['user_type_name']?></th>
					<th><?php echo $langVariables['user_type']['user_type_status']?></th>
					<th><?php echo $langVariables['user_type']['user_type_action']?></th>
				</tbody>
				<?php if(!empty($userTypes)){?>
					<?php foreach($userTypes as $userType){?>
						<tr class="wdthpercent100 pT10 pB10">
							<td><?php echo $userType['id'];?></td>
							<td><?php echo $userType['user_type'];?></td>
							<td><?php echo $userType['is_active'];?></td>
							<td>
								<a title="delete" onclick="javascript: return delete_action();" href="?deleteid=<?php echo $data['id'];?>" class="right pR10"><img src="/images/delete.png" alt="delete"/></a>
								<a title="edit" href="<?php echo URL_SITE ?>/admin/addparentmodule.php?id=<?php echo $data['id'];?>&action=edit" class="right pR10"><img src="/images/edit.png" alt="edit"/></a>
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