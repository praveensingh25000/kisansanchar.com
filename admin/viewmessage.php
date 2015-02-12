<?php
/******************************************
* @Modified on FEB 11, 2014
* @Package: Rand
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);
$filter_data        = array();
$activeClasspending = $activeClassapproved ='';
$status = 0;

$languageArray  = $langObj->functionGetSetting($tablename='language', $dmlType='');

if(isset($_POST['message_type']) || isset($_POST['language_type']) || isset($_POST['status'])){
	$filter_data  = $_SESSION['filter_data'] = $_POST;
} else if(isset($_SESSION['filter_data'])){
	$filter_data  = $_SESSION['filter_data'];
} else {
	$filter_data  = array('message_type' => 'all','language_type' => 'all','status' => '0');	
}
extract($filter_data);
$messageData = $adminObj->selectActiveMessageAndriodCategory($tablename='message', $message_type, $language_type, $status);
$total_count = count($messageData);
//echo '<pre>';print_r($messageData);echo '</pre>';die;
?>

<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading"><?php echo $langVariables['msg_var']['view_msg'];?></h2>
		<div class="clear pB10"></div>

		<div class="wdthpercent100 tabnav">			
			<form id="selectLanguageTypeMessageTypeForm" method="post" action="">
				<div class="wdthpercent20 left">
					<div class="wdthpercent50 left">
					    <input type="submit" name="status" value="Pending">
					</div>
					<div class="wdthpercent50 left">
					    <input type="submit" name="status" value="Approved">
					</div>								
				</div>

				<div class="wdthpercent10 right pR10 ">
				   <?php if(!empty($languageArray)) { ?>
						<select id="language_type" name="language_type">
							<option value="">Select Language</option>
							<option <?php if(isset($language_type) && $language_type=='all') { echo 'selected="selected"';}?> value="all">All Language</option>
							<?php foreach($languageArray as $language) { ?>
								<option value="<?php echo $language['name'];?>" <?php if(isset($language_type) && $language_type == $language['name']){ echo "selected='selected'"; } ?> ><?php echo $language['value'];?></option>
							<?php } ?>							
						</select>						
					<?php } ?>					
				</div>			    

				<div class="wdthpercent10 right pR10 ">
					<select id="message_type" name="message_type">
					    <option <?php if(isset($message_type) && $message_type=='all') { echo 'selected="selected"';}?> value="all"><?php echo $langVariables['msg_var']['allMsg']?></option>
						<option <?php if(isset($message_type) && $message_type=='sms') { echo 'selected="selected"';}?> value="sms"><?php echo $langVariables['msg_var']['smsMsg']?></option>
						<option <?php if(isset($message_type) && $message_type=='andriod') { echo 'selected="selected"';}?> value="andriod"><?php echo $langVariables['msg_var']['andMsg']?></option>
					</select>
				</div>

			</form>

			<script type="text/javascript">
			$(document).ready(function(){
				$("#message_type , #language_type").bind('change',function(){
					if($("#message_type").val()!='' || $("#language_type").val()!=''){
						loader_show();
						$("#selectLanguageTypeMessageTypeForm").submit();
					}
				});
			});
			</script>

		</div>

		<div class="wdthpercent100">
			<form action="" method="post" id="viewmessageform" name="viewmessageform">
					<table class="data-table">
						<tbody>
							<th><?php echo $langVariables['msg_var']['msg_id']?></th>					
							<th><?php echo $langVariables['msg_var']['msg_status_type']?></th>
							<th><?php echo $langVariables['msg_var']['msg_user_type']?></th>
							<th><?php echo $langVariables['msg_var']['msg_parent_category']?></th>		
							<th><?php echo $langVariables['msg_var']['msg_sub_category']?></th>
							<th><?php echo $langVariables['msg_var']['msg_message']?></th>
							<th><?php echo $langVariables['msg_var']['msg_language_type']?></th>		
							<th><?php echo $langVariables['msg_var']['msg_date']?></th>
							<th><?php echo $langVariables['msg_var']['msg_status']?></th>
							<th><?php echo $langVariables['msg_var']['msg_action']?></th>
						</tbody>
						
						<?php if(!empty($messageData)){?>
							 <?php foreach($messageData as $mdata){
							       $languageArray  = $db->getUniversalRow($tablename='language',$coloum_name_str='*',$updated_on_field='name',$updated_on_value=$mdata['language_type'],$otherfields=null);
								   $StatusArray  = $db->getUniversalRow($tablename='message_status_settings',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$mdata['status_type'],$otherfields=null);
								   $userTypeArray  = $db->getUniversalRow($tablename='user_types',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$mdata['user_type'],$otherfields=null);
								   $parentcategoryArray  = $db->getUniversalRow($tablename='category',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$mdata['parent_category'],$otherfields=null);
								   $subCategoryArray  = $db->getUniversalRow($tablename='category',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$mdata['sub_category'],$otherfields=null);
								?>
								<tr>
									<td><?php echo $mdata['id'];?></td>									
									<td>
										<?php if(isset($StatusArray['message_status_name'])) {echo $StatusArray['message_status_name'];}?>
									</td>
									<td>
										<?php if(isset($userTypeArray['user_type'])) {echo $userTypeArray['user_type'];}?>
									</td>
									<td>
										<?php if(isset($parentcategoryArray['category_name'])) {echo $parentcategoryArray['category_name'];}?>
									</td>
									<td>
										<?php if(isset($subCategoryArray['category_name'])) {echo $subCategoryArray['category_name'];}?>						
									</td>
									<td><?php echo $mdata['message'];?></td>
									<td>
										<?php if(isset($languageArray['value'])) {echo $languageArray['value'];}?>
									</td>
									<td>
										<?php if(isset($mdata['date'])) { echo date('d M Y',strtotime($mdata['date']));}?>
									</td>
									<td>
									    <?php if(isset($mdata['status']) && $mdata['status']=='0'){
											echo '<span class="red">Pending</span>';
										} else if(isset($mdata['status']) && $mdata['status']=='1'){
										    echo '<span class="green">Broadcasted</span>';
										} else if(isset($mdata['status']) && $mdata['status']=='2'){
										    echo '<span class="red">Failed</span>';
										} else if(isset($mdata['status']) && $mdata['status']=='3'){
										    echo '<span class="blue">Cancel</span>';
										}
						                ?>
									</td>
									<td>
										<a title="send" href="<?php echo URL_SITE ?>/admin/.php?id=<?php echo $mdata['id'];?>&action=send" class="right pR10"><img src="/images/send.png" alt="send"/></a>
										<a title="delete" onclick="javascript: return delete_action();" href="?deleteid=<?php echo $mdata['id'];?>" class="right pR10"><img src="/images/delete.png" alt="delete"/></a>
										<a title="edit" href="<?php echo URL_SITE ?>/admin/.php?id=<?php echo $mdata['id'];?>&action=edit" class="right pR10"><img src="/images/edit.png" alt="edit"/></a>		
									</td>
								</tr>
							 <?php } ?>				 
						<?php } else { ?>
								<tr>
									<td colspan="10"><?php echo $langVariables['msg_var']['noMsg']?></td>
								</tr>
						<?php } ?>	

					</table>
				</form>

		</div>
		
	</div>

</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>