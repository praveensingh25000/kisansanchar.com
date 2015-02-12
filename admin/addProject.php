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

if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){
	$project_id     = $_GET['id'];
	$project_one    = $langObj->functionGetSetting($tablename='projects', $dmlType='1', $project_id);
	$project_name   = stripslashes($project_one['project_name']);
	$is_active      = trim($project_one['is_active']);
}
?>

<!-- containerCenter -->
<section class="containerCenter">

	<div class="containercentercnt">

		<h2 class="heading">
			<?php echo $langVariables['project']['project_head']?>			
			<a class="right plane pR10" href="javascript:;" onclick="javascript:window.history.go(-1);"><?php echo $langVariables['general_var']['back']?></a>
		</h2>
		<div class="clear pB10"></div>
		
		<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?>
			<form action="action.php" method="post" id="editprojectforms" name="editprojectforms">
		<?php } else {?>
			<form action="action.php" method="post" id="addprojectforms" name="addprojectforms">	
		<?php }?>
		
			<div class="wdthpercent100">
				
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['project']['project_name']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['project']['project_name']?>" type="text" id="project_name" name="project_name" class="wdthpercent40 required" value="<?php if(isset($project_name)){echo $project_name;} ?>"/>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['form_var']['email']?></div>
					<div class="wdthpercent80 left">
					    <input placeholder="<?php echo $langVariables['form_var']['email']?>" type="text" id="email" name="email" value="<?php if(isset($_SESSION['register_data']['email'])){ echo $_SESSION['register_data']['email']; }?>" class="wdthpercent40 email required"/>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['form_var']['phone']?></div>
					<div class="wdthpercent80 left">
					    <input placeholder="<?php echo $langVariables['form_var']['phone']?>" type="text" id="phone" name="phone" value="<?php if(isset($_SESSION['register_data']['phone'])){ echo $_SESSION['register_data']['phone']; }?>" class="wdthpercent40 digits required"/>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['form_var']['password']?></div>
					<div class="wdthpercent80 left">
					    <input placeholder="<?php echo $langVariables['form_var']['password']?>" type="password" name="password" class="wdthpercent40 required"/>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left">Sender Name</div>
					<div class="wdthpercent80 left">
					   <input placeholder="Sender Name" type="text" id="sender_name" name="sender_name" class="wdthpercent40 required" value="<?php if(isset($is_active)){echo $is_active;} ?>" />
					   <span class="green"><input type="checkbox" name="sender_name_check" value="1">&nbsp;Send Mail to Provider</span>
					</div>
			    </div>
			    <div class="clear"></div>
				
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['category_var']['category_status']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['category_var']['category_status']?>" type="text" id="is_active" name="is_active" class="wdthpercent40 required" value="<?php if(isset($is_active)){echo $is_active;}else{echo '1';} ?>" />
					   <small class="red"><?php echo $langVariables['general_var']['status_msg']?></small>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left">&nbsp;</div>

					<div class="wdthpercent80 left">
						<?php if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='edit'){ ?>
							<span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="updateprojectforms"></span>
							<span class="pL40">
								<input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
								<input type="hidden" name="id" value="<?php echo $project_id;?>">
							</span>
						<?php } else {?>
							<span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submitprojectforms"></span>
							<span class="pL40">
							    <input type="hidden" name="receivename" value="Dear Yamini Ji and Rashul Sir">
								<input type="hidden" name="receivermail" value="yamini.shukla@routesms.com">
								<input type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
							</span>
						<?php }?>					  
					</div>

			    <div class="clear"></div>
			
			</div> 

		</form>	

	</div>

</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>