<?php
/******************************************
* @Modified on FEB 12, 2014
* @Package: Rand
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";
checkSession(true,2);
$modulesettingsArray  = $langObj->functionGetSetting($tablename='module_sub_settings', $dmlType='');
$modulesettings       = $db->getUniversalFormattedArray($modulesettingsArray,$key='module_id');
//echo '<pre>';print_r($modulesettings);echo '</pre>';
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading"><?php echo $langVariables['module']['module_heading']?></h2>
		<div class="clear pB10"></div>
		<form action="" method="post" id="viewformsetting" name="viewformsetting">
			<?php if(!empty($modulesettings)){?>
				<div class="wdthpercent100 pT10 pB10 head">
							<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_id']?></div>
							<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_name']?></div>
							<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_link']?></div>
							<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_status']?></div>
							<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_action']?></div>
						 </div>
		        <?php foreach($modulesettings as $module_id => $moduleAll){
					 $moduleheadArray  = $langObj->functionGetSetting($tablename='module_sub_settings', $dmlType='3', $module_id);
			         ?>			          
					 <div class="wdthpercent100 register">
						 <h2 class=""><?php if(isset($moduleheadArray['module_head'])){ echo $moduleheadArray['module_head'];}?><a class="right pR50" href="editmodule.php?module_id=<?php echo $module_id;?>"><img src="/images/edit.png" alt="edit"/></a></h2>
						 <div class="clear "></div>	
						 <?php foreach($moduleAll as $module){?>							
							<div class="wdthpercent100">
								<div class="wdthpercent20 left"><?php echo $module['id'];?></div>
								<div class="wdthpercent20 left"><?php echo $module['sub_module_name'];?></div>
								<div class="wdthpercent20 left"><?php echo $module['sub_module_link'];?></div>
								<div class="wdthpercent20 left"><?php echo $module['is_active'];?></div>
							</div>
							<div class="clear"></div>								
						 <?php } ?>
					 </div>					
				  <?php } ?>
			<?php } ?>
		</form>	

	</div>

</section>
<!-- /Containercenter -->
<?php include_once $basedir."/include/adminFooter.php"; ?>