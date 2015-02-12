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

$groupArray  = $langObj->functionGetSetting($tablename='group_settings', $dmlType='');

if(isset($_GET['deleteid'])){
	$id=$_GET['deleteid'];
	$delete = $db->deleteUniversalRow($table_name='group_settings',$updated_on_field='id',$updated_on_value=$id,$otherfields=null);
	if($delete){
		$_SESSION['msgsuccess'] = "7";
	}
	header("location:viewgroup.php");
	exit;
}
//echo '<pre>';print_r($groupArray);echo '</pre>';die;
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading"><?php echo $langVariables['group']['group_heading']?></h2>
		<div class="clear pB10"></div>
		<form action="" method="post" id="viewformsetting" name="viewformsetting">
			<table class="data-table">
				<tbody>
					<th><?php echo $langVariables['group']['group_id']?></th>
					<th><?php echo $langVariables['group']['group_name']?></th>
					<th><?php echo $langVariables['group']['group_status']?></th>
					<th><?php echo $langVariables['group']['group_action']?></th>
				</tbody>
				<?php if(!empty($groupArray)){?>
					 <?php foreach($groupArray as $groups){?>
						<tr>
							<td><?php echo $groups['id'];?></td>
							<td><?php echo $groups['group_name'];?></td>
							<td><?php echo $groups['is_active'];?></td>
							<td>
								<a title="delete" onclick="javascript: return delete_action();" href="?deleteid=<?php echo $groups['id'];?>" class=""><img src="/images/delete.png" alt="delete"/></a>
								<a title="edit" href="<?php echo URL_SITE ?>/admin/group.php?id=<?php echo $groups['id'];?>&action=edit" class=""><img src="/images/edit.png" alt="edit"/></a>
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