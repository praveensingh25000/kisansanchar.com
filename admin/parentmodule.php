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

$dataArray  = $langObj->functionGetSetting($tablename='module_settings', $dmlType='');

if(isset($_GET['deleteid'])){
	$module_id=$_GET['deleteid'];
	$delete = $db->deleteUniversalRow($table_name='module_settings',$updated_on_field='id',$updated_on_value=$module_id,$otherfields=null);
	if($delete){
		$_SESSION['msgsuccess'] = "7";
	}
	header("location:parentmodule.php");
	exit;
}

//echo '<pre>';print_r($dataArray);echo '</pre>';die;
?>
<!-- containerCenter -->
<section class="containerCenter">

	<div class="containercentercnt">

		<h2 class="heading"><?php echo $langVariables['module']['parent_module_heading']?></h2>
		<div class="clear pB10"></div>
		<form action="" method="post" id="viewformsetting" name="viewformsetting">
			<table class="data-table">
				<tbody>
					<th><?php echo $langVariables['module']['module_id']?></th>
					<th><?php echo $langVariables['module']['module_name']?></th>
					<th><?php echo $langVariables['module']['module_status']?></th>
					<th><?php echo $langVariables['module']['module_action']?></th>					
				</tbody>
					
			<?php if(!empty($dataArray)){?>
		   		 <?php foreach($dataArray as $data){?>
					<tr>
						<td><?php echo $data['id'];?></td>
						<td><?php echo $data['module_name'];?></td>
						<td><?php echo $data['is_active'];?></td>
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