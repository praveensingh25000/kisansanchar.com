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
$sitenavigation = $sitenavigationdata = array();
if(!isset($_GET['groupid'])){
	header("location: parentmodule.php");
	exit;
}

$groupArray  = $langObj->functionGetSetting($tablename='group_settings', $dmlType='');
$moduleCheckboxDataArray  = $langObj->functionGetSetting($tablename='module_assign_settings', $dmlType='2',$_GET['groupid']);
$moduleArray  = $db->getUniversalJoinData($table_name1='module_settings', $table_name2='module_sub_settings', $join_type='JOIN', $onjoinid1='id' , $onjoinid2='module_id', $wherejoinid_str = ' module_settings.is_active=1 and module_sub_settings.isactive=1 ', $coloum_name_str='*', $andcondition=null, $otherfields=null);

if(!empty($moduleArray)){
	foreach($moduleArray as $module){
	   $sitenavigationdata[$module['module_name']][$module['id']] = $module['sub_module_name'];
	}
}

if(!empty($moduleCheckboxDataArray)){
	foreach($moduleCheckboxDataArray as $moduleCheckbox){
	   $moduleCheckboxData = explode(',',$moduleCheckbox['module_id']);
	}
}

if(isset($_POST['submitsubmoduleforms'])){	
	$result  = $langObj->functionAssignModules($_POST);	
	if($result){
		$_SESSION['msgsuccess'] = "7";
	} else {
		$_SESSION['msgsuccess'] = "8";
	}
	header("location: assignmodule.php?groupid=".$_POST['groupid']."");
	exit;	
}
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading"><?php echo $langVariables['module']['module_heading']?></h2>
		<div class="clear pB10"></div>
		<div class="wdthpercent100 register white">
			<?php if(!empty($groupArray)){ ?>
				<div class="tabnav">
					<?php foreach($groupArray as $groups){?>
						<?php if($groups['id']!='1') {?>						
							<a <?php if(isset($_GET['groupid']) && $_GET['groupid']==$groups['id']){ ?> class="active" <?php } ?> href="?groupid=<?php echo $groups['id'];?>"><?php echo strtoupper($groups['group_name']);?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>			
		
			<form action="" method="post" id="addsubmoduleform" name="addsubmoduleform">		
				<div class="wdthpercent100">
					<table class="tabledata">
						<?php if(!empty($sitenavigationdata)){ ?>							  
							  <?php foreach($sitenavigationdata as $sitenavigationkey => $sitenavigationAll){ ?>   								  
								  <tr>
									<th><?php echo $sitenavigationkey;?></th>	
								  <tr>
								  <tr>
									  <?php foreach($sitenavigationAll as $moduleid => $sitenavigation){ ?>
										<td>
											<input <?php if(!empty($moduleCheckboxData) && in_array($moduleid,$moduleCheckboxData)){ echo 'checked="checked"';}?> type="checkbox" value="<?php echo $moduleid;?>" class="required" name="module_id[]">
											<?php echo $sitenavigation;?>
										</td>										
									  <?php } ?>
								  </tr>									  
							<?php } ?>									
						<?php } ?>	
						<tr>
							<td colspan="2">								
								<input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submitsubmoduleforms">
								<input type="hidden" value="<?php echo $_GET['groupid'];?>" name="groupid">
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">								
							</td>	
						<tr>
				  </table>				
				</div> 
			</form>	
		</div>
	</div>
</section>
<!-- /Containercenter -->
<?php include_once $basedir."/include/adminFooter.php"; ?>