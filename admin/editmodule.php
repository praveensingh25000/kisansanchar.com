<?php
/******************************************
* @Modified on Feb 12, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @Edit: Gurtej Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);

if(!isset($_GET['module_id'])){
	header("location:viewmodule.php");
	exit;	
}

$module_id = $_GET['module_id'];
$moduleArray  = $langObj->functionGetSetting($tablename='module_sub_settings', $dmlType='3',$module_id);
$moduleDetail = $db->getUniversalFormattedArray($moduleArray,$key='module_id');

//echo '<pre>';print_r($moduleDetail);echo '</pre>'; die;
?>
<!-- containerCenter -->
<section class="containerCenter">

	<div class="containercentercnt">

		<h2 class="heading"><?php echo $langVariables['module']['module_heading']?></h2>
		<div class="clear pB10"></div>		

		<?php if(!empty($moduleDetail)){?>
		      <?php foreach($moduleDetail as $moduleid => $moduleDetailAll){
					 $moduleHeadArray  = $langObj->functionGetSetting($tablename='module_sub_settings', $dmlType='3',$moduleid);
			         ?>						 	
					 <div class="wdthpercent100 register">
						
						 <h2 class=""><?php if(isset($moduleHeadArray['module_head'])){ echo $moduleHeadArray['module_head'];}?></h2>
						 <div class="clear pB10"></div>
						 
						 <?php foreach($moduleDetailAll as $modules){?>
						 
							<form action="" method="post" id="editformmodule<?php echo $modules['id']?>" name="editformmodule<?php echo $modules['id']?>">
							
							<div class="wdthpercent100 pT10 pB10">
								<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_name'];?></div>
								<div class="wdthpercent80 left">
								   <input placeholder="<?php echo $langVariables['module']['sub_module_name'];?>" type="text" id="sub_module_name" name="sub_module_name" class="wdthpercent40 required" value="<?php echo $modules['sub_module_name']?>" /><br>
								</div>
							</div>
							<div class="clear"></div>

							<div class="wdthpercent100 pT10 pB10">
								<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_link'];?></div>
								<div class="wdthpercent80 left">
								   <input placeholder="<?php echo $langVariables['module']['sub_module_link'];?>" type="text" id="sub_module_name" name="sub_module_link" class="wdthpercent40 required" value="<?php echo $modules['sub_module_link']?>" /><br>
								</div>
							</div>
							<div class="clear"></div>

							<div class="wdthpercent100 pT10 pB10">
								<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_status'];?></div>
								<div class="wdthpercent80 left">
								   <input placeholder="<?php echo $langVariables['module']['module_status'];?>" type="text" id="is_active" name="is_active" class="wdthpercent40 required" value="<?php echo $modules['is_active']?>" /><br>
								</div>
							</div>
							<div class="clear"></div>			

							<div class="wdthpercent100 pT10 pB10">
								<div class="wdthpercent20 left">&nbsp;</div>
								<div class="wdthpercent80 left">
									<span class="">
									<input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="editsitesetting<?php echo $setting['id']?>">
									<input type="hidden" name="id" value="<?php echo $modules['id']?>">
									</span>	
								</div>
							</div>
							<div class="clear"></div>
							
							<script type="text/javascript">
							jQuery(document).ready(function(){
								jQuery("#editformmodule<?php echo $modules['id'];?>").validate();
								jQuery("#editformmodule<?php echo $modules['id'];?>").submit(function(e){	
									e.preventDefault();		
									var pass_msg = jQuery("#editformmodule<?php echo $modules['id'];?>").valid();		
									//some validations
									if(pass_msg == false){
										return false;
									} else {	
										jQuery(".msgsuccess").hide();
										jQuery("#msgsuccess").html('');
										jQuery.ajax({
											type: "POST",
											data: jQuery("#editformmodule<?php echo $modules['id'];?>").serialize(),
											url : URL_SITE+"/admin/adminActionAjax.php?modulesaved=1",
											success: function(msg) {
												jQuery(".msgsuccess").show();
												jQuery("#msgsuccess").html(msg).show();
											}							
										});	
									}
								});	 
							});
							</script>

							</form>
														
						 <?php } ?>

					 </div>
					 <div class="clear pB10"></div>	

			  <?php } ?>

		<?php } ?>   		

	</div>

</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>