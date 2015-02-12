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

if(isset($_POST['submitgroupforms'])){	
	$result  = $langObj->functionAddGroups($_POST);	
	$_SESSION['msgsuccess'] = "7";
	header("location:group.php");
	exit;	
}
/*gurtej*/

if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){
	$groupid			 =	$_GET['id'];
	$groupdetails		 =	$langObj->functionGetSetting($tablename='group_settings', $dmlType='1', $groupid);
	$group_name			 =	stripslashes($groupdetails['group_name']);	
	$is_active			 =	trim($groupdetails['is_active']);

}

if(isset($_POST['updategroupheadforms'])){	
	$result  = $langObj->functionupdateGroups($_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";
	}
	header("location:group.php?id=".$_POST['id']."&action=edit");
	exit;	
}

/*gurtej*/

?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading"><?php echo $langVariables['group']['group_heading']?></h2>
		<div class="clear pB10"></div>
		<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?>
			<form action="" method="post" id="editgroupform" name="editgroupform">
		<?php } else {?>
			<form action="" method="post" id="addgroupform" name="addgroupform">	
		<?php }?>
			<div class="wdthpercent100 register">	
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['group']['group_name']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['group']['group_name']?>" type="text" id="group_name" name="group_name" class="wdthpercent40 required" value="<?php if(isset($group_name)){echo $group_name;} ?>"/><br>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['group']['group_status']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['group']['group_status']?>" type="text" id="is_active" name="is_active" class="wdthpercent40 required" value="<?php if(isset($is_active)){echo $is_active;} ?>"/><br>
					</div>
			    </div>
			    <div class="clear"></div>	

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left">&nbsp;</div>
					<!--<div class="wdthpercent80 left">
					    <span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submitgroupforms"></span>
						<span class="pL40"><input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset"></span>					  
					</div>-->

					<div class="wdthpercent80 left">
						<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?>
							<span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="updategroupheadforms"></span>
							<span class="pL40">
								<input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
								<input type="hidden" name="id" value="<?php echo $groupid;?>">
							</span>
						<?php } else {?>
							<span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submitgroupforms"></span>
							<span class="pL40">
								<input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
							</span>
						<?php }?>					  
					</div>	
			    </div>
			    <div class="clear"></div>			
			</div> 
		</form>	
	</div>
</section>
<!-- /Containercenter -->
<?php include_once $basedir."/include/adminFooter.php"; ?>