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

$groupArray  = $langObj->functionGetSetting($tablename='group_settings', $dmlType='');

if(isset($_POST['submitmoduleforms'])){	
	$result  = $langObj->functionAddModule($_POST);	
	$_SESSION['msgsuccess'] = "7";
	header("location:module.php");
	exit;	
}
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading"><?php echo $langVariables['module']['module_heading']?></h2>
		<div class="clear pB10"></div>
		<form action="" method="post" id="addmoduleformsetting" name="addmoduleformsetting">			

			<div class="wdthpercent100 register">			
				<div class="wdthpercent100 pT10 pB10">
				   <div class="wdthpercent20 left"><?php echo $langVariables['group']['select_module_type']?></div>
				   <div class="wdthpercent80 left">
				   <?php if(!empty($groupArray)) { ?>
						<select class="wdthpercent40 inputbox required" id="groupid" name="groupid">
							<option value=""><?php echo $langVariables['module']['select_module_type']?> </option>
							<?php foreach($groupArray as $groups) { ?>
								<option value="<?php echo $groups['id'];?>"><?php echo $groups['group_name'];?></option>
							<?php } ?>							
						</select><br />					
					<?php } ?>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_id']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="enter module id" type="text" id="module_id" name="module_id" class="wdthpercent40 required"/><br>
					</div>
			    </div>
			    <div class="clear"></div>
				
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_head'];?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="enter module head" type="text" id="module_head" name="module_head" class="wdthpercent40 required"/><br>
					</div>
			    </div>
			    <div class="clear"></div>
				
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_name']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="enter module name" type="text" id="module_name" name="module_name" class="wdthpercent40 required"/><br>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_link']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="enter module link" type="text" id="module_link" name="module_link" class="wdthpercent40 required"/><br>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['module']['module_status']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="enter module status" type="text" id="is_active" name="is_active" class="wdthpercent40 required"/><br>
					</div>
			    </div>
			    <div class="clear"></div>	

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left">&nbsp;</div>
					<div class="wdthpercent80 left">
					    <span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submitmoduleforms"></span>
						<span class="pL40"><input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset"></span>					  
					</div>
			    </div>
			    <div class="clear"></div>			
			</div> 
		</form>	
	</div>
</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>