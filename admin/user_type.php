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

if(isset($_POST['submitUserTypeforms'])){	
	$result  = $langObj->functionAddUserType($_POST);	
	$_SESSION['msgsuccess'] = "7";
	header("location:user_type.php");
	exit;	
}
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading"><?php echo $langVariables['user_type']['user_type_heading']?></h2>
		<div class="clear pB10"></div>
		<form action="" method="post" id="addgroupform" name="addgroupform">
			<div class="wdthpercent100 register">
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['user_type']['user_type_name']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['user_type']['user_type_name']?>" type="text" id="user_type" name="user_type" class="wdthpercent40 required"/><br>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['user_type']['user_type_status']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="<?php echo $langVariables['user_type']['user_type_status']?>" type="text" id="is_active" name="is_active" class="wdthpercent40 required"/><br>
					</div>
			    </div>
			    <div class="clear"></div>	

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left">&nbsp;</div>
					<div class="wdthpercent80 left">
					    <span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submitUserTypeforms"></span>
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