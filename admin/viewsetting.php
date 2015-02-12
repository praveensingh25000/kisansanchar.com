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

$settingArray  = $langObj->functionGetSetting($tablename='site_settings', $dmlType='');
$settingDetail = $db->getUniversalFormattedArray($settingArray,$key='groupid');

//echo '<pre>';print_r($settingDetail);echo '</pre>';
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading">
			<?php echo $langVariables['setting']['setting_head']?>
			<a class="right pR30 fontwhite" href="setting.php"><?php echo $langVariables['general_var']['add']?></a>
		</h2>
		<div class="clear pB10"></div>
		<form action="" method="post" id="viewformsetting" name="viewformsetting">
			<?php if(!empty($settingDetail)){?>
		       <?php foreach($settingDetail as $groupid => $settingAll){
					 $groupArray  = $langObj->functionGetSetting($tablename='site_settings', $dmlType='2', $groupid);
			         ?>			          
				<div class="wdthpercent100 register">
					<h2 class=""><?php if(isset($groupArray[0]['group'])){ echo $groupArray[0]['group'];}?><a title="edit" class="right pR30" href="editsetting.php?groupid=<?php echo $groupid;?>"><img src="/images/edit.png" alt="edit"/></a></h2>
					 <div class="clear pB10"></div>
						 <?php foreach($settingAll as $setting){?>							
							<div class="wdthpercent100 pT10 pB10">
								<div class="wdthpercent30 left"><?php echo $setting['text'];?></div>
								<div class="wdthpercent30 left"><?php echo $setting['name'];?></div>
								<div class="wdthpercent30 left"><?php echo $setting['value'];?></div>
							</div>
							<div class="clear"></div>								
						 <?php } ?>
					 </div>
					 <div class="clear pB10"></div>
			  <?php } ?>
		<?php } ?>   

		</form>	

	</div>

</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>