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
$smsTypeCheckboxData = $smsTypeCheckbox = array();
if(!isset($_GET['typeid'])){
	header("location: addsmstype.php");
	exit;
}

$userTypes = $db->getUniversalRowAll($table_name='user_types');
$smsTypes  = $db->getUniversalRowAll($table_name='sms_types');

$smsTypeCheckboxData = $langObj->functionGetSetting($tablename='sms_types_assign_settings', $dmlType='4',$_GET['typeid']);
if(!empty($smsTypeCheckboxData)){	
	$smsTypeCheckbox = explode(',',$smsTypeCheckboxData['menu_id']);	
}

if(isset($_POST['submitsmstypeassignforms'])){	
	$result  = $langObj->functionAssignSMSTypes($_POST);	
	if($result){
		$_SESSION['msgsuccess'] = "7";
	} else {
		$_SESSION['msgsuccess'] = "8";
	}
	header("location: smssetting.php?typeid=".$_POST['user_type_id']."");
	exit;	
}
?>
<!-- containerCenter -->
<section class="containerCenter">

	<div class="containercentercnt">

		<h2 class="heading"><?php echo $langVariables['module']['module_heading']?></h2>
		<div class="clear pB10"></div>
		<div class="wdthpercent100 register white">
			
			<?php if(!empty($userTypes)){ ?>
			    <div class="tabnav">
					<?php foreach($userTypes as $userType){?>
						<span class="wdthpercent25 left pT5 pB5"><a <?php if(isset($_GET['typeid']) && $_GET['typeid']==$userType['id']){ ?> class="active" <?php } ?> href="?typeid=<?php echo $userType['id'];?>"><?php echo $userType['user_type'];?></a></span>
					<?php } ?>
				</div>	
			<?php } ?>

			<form action="" method="post" id="addsmstypeassignforms" name="addsmstypeassignforms">				
				<table class="tabledata">				  
					<?php if(!empty($smsTypes)){ ?>							  
						  <?php foreach($smsTypes as $smsTypeskey => $smsType){ ?> 
								<tr>
									<td>
										<input <?php if(!empty($smsTypeCheckbox) && in_array($smsType['id'],$smsTypeCheckbox)){ echo 'checked="checked"';}?> type="checkbox" value="<?php echo $smsType['id'];?>" class="required" name="menu_id[]">
										<?php echo $smsType['menu_type'];?>
									</td>
								</tr>
						<?php } ?>

						<tr>
							<td colspan="2">								
								<input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submitsmstypeassignforms">
								<input type="hidden" value="<?php echo $_GET['typeid'];?>" name="user_type_id">
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">								
							</td>	
						<tr>

					<?php } else { ?>
						
						<tr>
							<td colspan="2">								
								No SMS Type added Yet.						
							</td>	
						<tr>

					<?php } ?>	

				</table> 			

			</form>	

	    </div>

	</div>

</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>