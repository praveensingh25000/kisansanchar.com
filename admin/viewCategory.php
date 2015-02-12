<?php
/******************************************
* @Modified on FEB 09, 2014
* @Package: Rand
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);

if(isset($_POST['parent_id'])){
	$parent_id    = $_SESSION['parent_id'] = $_POST['parent_id'];
	$categoryData = $adminObj-> selectActiveParentSubparentCategory($tablename='category', $select_type=$parent_id);
} else if(isset($_SESSION['parent_id'])){
	$parent_id    = $_SESSION['parent_id'];
	$categoryData = $adminObj-> selectActiveParentSubparentCategory($tablename='category', $select_type=$parent_id);
} else {
	$categoryData  = $langObj->functionGetSetting($tablename='category', $dmlType='');
}

if(isset($_GET['deleteid'])){
	$id=$_GET['deleteid'];
	$delete = $db->deleteUniversalRow($table_name='category',$updated_on_field='id',$updated_on_value=$id,$otherfields=null);
	if($delete){
		$_SESSION['msgsuccess'] = "";
	}
	header("location:viewCategory.php");
	exit;
}
//echo '<pre>';print_r($categoryData);echo '</pre>';die;
?>

<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading"><?php echo $langVariables['category_var']['viewcategory'];?>
		   <div class="right pR30">
			   <div class="wdthpercent50 left"><?php echo $langVariables['category_var']['category_sel'];?></div>
					<div class="wdthpercent50 left">				
						<form id="select_category_type" method="post" action="">
							<select id="parent_id" name="parent_id">
								<option <?php if(isset($_SESSION['parent_id']) && $_SESSION['parent_id']=='0'){ echo 'selected="selected"';}?> value="0"><?php echo $langVariables['category_var']['parent_category'];?></option>
								<option <?php if(isset($_SESSION['parent_id']) && $_SESSION['parent_id']=='1'){ echo 'selected="selected"';}?> value="1"><?php echo $langVariables['category_var']['sub_category'];?></option>
							</select>
							<script type="text/javascript">
							$(document).ready(function(){
								$("#parent_id").change(function(){
									if($("#parent_id").val()!='')
									$("#select_category_type").submit();
								});
							});
							</script>
						</form>				
					</div>			
			</div>

			<div id="" class="wdthpercent40 right pR10">
				<div class="wdthpercent20 left"><span class="listform"><?php echo $langVariables['general_var']['search']?></span></div>
				<div class="wdthpercent70 left">
					<input class="wdthpercent100" placeholder="enter name" type="text" id="searchContentCategory" style="width: 189px;"/>			
				</div>							
			</div>
		</h2>
		<div class="clear pB10"></div>
			<form action="" method="post" id="viewcategoryform" name="viewcategoryform">
				<table class="data-table" id="list_view">
					<tbody>
						<th ><?php echo $langVariables['category_var']['category_id']?></th>
						<th ><?php echo $langVariables['category_var']['category_name']?></th>
						<th ><?php echo $langVariables['msg_var']['msg_parent_category']?></th>
						<th ><?php echo $langVariables['category_var']['category_status']?></th>
						<th ><?php echo $langVariables['category_var']['category_description']?></th>		
						<th ><?php echo $langVariables['category_var']['category_action']?></th>
					</tbody>
					<?php if(!empty($categoryData)){?>
						 <?php foreach($categoryData as $data){
							 $patcategoryData  = $langObj->functionGetSetting($tablename='category', $dmlType='1',$data['parent_id']);							 
							 ?>
							<tr>
								<td><?php echo $data['id'];?></td>
								<td class="category_name"><?php echo $data['category_name'];?></td>
								<td><?php echo $patcategoryData['category_name'];?></td>
								<td><?php echo $data['is_active'];?></td>
								<td><?php echo $data['description'];?></td>
								<td>
									<a title="delete" onclick="javascript: return delete_action();" href="?deleteid=<?php echo $data['id'];?>" class="right pR10"><img src="/images/delete.png" alt="delete"/></a>
									<a title="edit" href="<?php echo URL_SITE ?>/admin/addCategory.php?id=<?php echo $data['id'];?>&action=edit" class="right pR10"><img src="/images/edit.png" alt="edit"/></a>
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