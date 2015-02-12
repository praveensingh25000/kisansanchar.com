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

$messagestatussettingsArray  = $langObj->functionGetSetting($tablename='message_status_settings', $dmlType='');

//echo '<pre>';print_r($messagestatussettingsArray);echo '</pre>';die;
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading"><?php echo $langVariables['category_var']['view_msg_status_category'];?></h2>
		<div class="clear pB10"></div>
		<form action="" method="post" id="viewformsetting" name="viewformsetting">
			<table class="data-table">
				<tbody>
					<th><?php echo $langVariables['category_var']['category_id']?></th>
					<th><?php echo $langVariables['category_var']['msg_status_category_name']?></th>
					<th><?php echo $langVariables['category_var']['msg_status_logo']?></th>
					<th><?php echo $langVariables['category_var']['category_status']?></th>
					<th><?php echo $langVariables['category_var']['category_action']?></th>
				</tbody>
				<?php if(!empty($messagestatussettingsArray)){?>
					 <?php foreach($messagestatussettingsArray as $messagestatusCategory){?>
						<tr>
							<td><?php echo $messagestatusCategory['id'];?></td>
							<td><?php echo stripslashes($messagestatusCategory['message_status_name']);?></td>
							<td>
								<?php
								$logo = stripslashes($messagestatusCategory['logo']);
								if(!empty($logo)){ ?>
								  <div class="clear"></div>
								  <span class="statusimg left">
									  <img class="logo" title="<?php echo $logo;?>" alt="<?php echo $logo;?>" <?php if(!empty($logo)){ ?> src="/uploads/general/<?php echo $logo;?>" <?php } ?> />
								  </span>
								<?php } ?>
							</td>
							<td><?php echo $messagestatusCategory['is_active'];?></td>
							<td>
								<a title="delete" onclick="javascript: return delete_action();" href="?deleteid=<?php echo $messagestatusCategory['id'];?>" class=""><img src="/images/delete.png" alt="delete"/></a>
								<a title="edit" href="<?php echo URL_SITE ?>/admin/addStatusMsg.php?id=<?php echo $messagestatusCategory['id'];?>&action=edit" class=""><img src="/images/edit.png" alt="edit"/></a>
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