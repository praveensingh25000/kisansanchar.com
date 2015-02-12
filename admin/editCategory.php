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

if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){
	$category_id    = $_GET['id'];
	$categoryDetail = $langObj->functionGetSetting($tablename='category', $dmlType='1', $category_id);
	$category_name  = stripslashes($categoryDetail['category_name']);
	$description    = stripslashes($categoryDetail['description']);
	$is_active      = trim($categoryDetail['is_active']);
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
		</h2>
		<div class="clear pB10"></div>
			<form action="" method="post" id="viewcategoryform" name="viewcategoryform">
				<table class="data-table">
					<tbody>
						<th ><?php echo $langVariables['category_var']['category_id']?></th>
						<th ><?php echo $langVariables['category_var']['category_name']?></th>
						<th ><?php echo $langVariables['category_var']['category_status']?></th>
						<th ><?php echo $langVariables['category_var']['category_description']?></th>		
						<th ><?php echo $langVariables['category_var']['category_action']?></th>
					</tbody>
					<?php if(!empty($categoryData)){?>
						 <?php foreach($categoryData as $data){?>
							<tr>
								<td><?php echo $data['id'];?></td>
								<td><?php echo $data['category_name'];?></td>
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