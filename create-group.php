<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
*******************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$page_title			= 'Create Group';
$page_link_title	= 'View Groups';
$page_link			= 'viewAllGroup.php'; 
$page_image			= '';

checkSession(false,2);

if(isset($_POST['submitreportgroupmembersforms'])){	
	$groupidinseerted  = $db->functionInsertUniversalData($tablename='sms_groups', $_POST);
	if($groupidinseerted){
		$_SESSION['msgsuccess'] = "7";
		header("location: addViewGroupMember.php?group_id=".$groupidinseerted."");
		exit;	
	}else{
		$_SESSION['msgerror'] = "8";
		header("location: ".$_SERVER['REQUEST_URI']."");
		exit;	
	}
}
?>

<div class="container">

	<!-- TITLE HEADING -->
	<?php require_once($DOC_ROOT.'include/title_heading.php');?>	
	<!-- /TITLE HEADING -->

	<div class="entry bknone">
		
		<div class="pT10 pB10">
			<form action="" method="post" id="addreportgroupforms" name="addreportgroupforms">	
				
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent40 left">SMS Group Name</div>
					<div class="wdthpercent60 left">
					   <input placeholder="Group Name" type="text" id="group_name" name="group_name" class="wdthpercent60 required" value="<?php if(isset($group_name)){ echo $group_name;} ?>" /><br>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent40 left">SMS Group Status</div>
					<div class="wdthpercent60 left">
					   <input placeholder="Group Status" type="text" id="is_active" name="is_active" class="wdthpercent60 required" value="<?php if(isset($is_active)){ echo $is_active;} ?>" /><small class="red">1 for Active and 0 for Inactive</small><br>
					</div>
			    </div>
			    <div class="clear pB10"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent40 left">&nbsp;</div>
					<div class="wdthpercent60 left">						
						<span class=""><input type="submit" class="button" value="<?php echo $langVariables['form_var']['submit']?>" name="submitreportgroupmembersforms"></span>
						<span class="pL40">
						<input type="hidden" name="owner_id" value="<?php echo $front_user_id;?>">
						<input type="hidden" name="date" value="<?php echo @date('Y-m-d H:i:s');;?>">
						<input type="reset" class="button" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
						</span>					    					  
					</div>
			    </div>
			    <div class="clear"></div>

			</form>	
		</div>

	</div>

</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>