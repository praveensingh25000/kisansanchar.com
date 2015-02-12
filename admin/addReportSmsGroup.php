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

if(isset($_POST['submitreportgroupmembersforms'])){	
	$groupidinseerted  = $db->functionInsertUniversalData($tablename='sms_groups', $_POST);
	if($groupidinseerted){
		$_SESSION['msgsuccess'] = "7";
		header("location: addViewReportSmsGroupMember.php?group_id=".$groupidinseerted."");
		exit;	
	}else{
		$_SESSION['msgerror'] = "8";
		header("location: ".$_SERVER['REQUEST_URI']."");
		exit;	
	}
}
?>
<!-- containerCenter -->
<section class="containerCenter">
	
	<div class="containercentercnt">
		
		<h2 class="heading left">Add SMS Group<span class="right"><a href="viewAllReportSmsGroup.php">View All groups</a></span></h2>
		<div class="clear pB10"></div>
		
		<div class="pT10 pB10">
			<form action="" method="post" id="addreportgroupforms" name="addreportgroupforms">	
				
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left">SMS Group Name</div>
					<div class="wdthpercent80 left">
					   <input placeholder="Group Name" type="text" id="group_name" name="group_name" class="wdthpercent40 required" value="<?php if(isset($group_name)){ echo $group_name;} ?>" /><br>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left">SMS Group Status</div>
					<div class="wdthpercent80 left">
					   <input placeholder="Group Status" type="text" id="is_active" name="is_active" class="wdthpercent40 required" value="<?php if(isset($is_active)){ echo $is_active;} ?>" /><br>
					</div>
			    </div>
			    <div class="clear pB10"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left">&nbsp;</div>
					<div class="wdthpercent80 left">						
						<span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submitreportgroupmembersforms"></span>
						<span class="pL40">
						<input type="hidden" name="owner_id" value="<?php echo $admin_user_id;?>">
						<input type="hidden" name="date" value="<?php echo @date('Y-m-d H:i:s');;?>">
						<input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
						</span>					    					  
					</div>
			    </div>
			    <div class="clear"></div>

			</form>	
		</div>

	</div>

</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>