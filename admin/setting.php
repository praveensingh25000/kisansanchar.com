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

if(isset($_POST['addsitesetting'])){	
	$result  = $langObj->functionAddSetting($_POST);	
	$_SESSION['msgsuccess'] = "7";
	header("location:viewsetting.php");
	exit;	
}
?>
<!-- containerCenter -->
<section class="containerCenter">

	<div class="containercentercnt">

		<h2 class="heading"><?php echo $langVariables['setting']['setting_head']?></h2>
		<div class="clear pB10"></div>

		<form action="" method="post" id="addformsetting" name="addformsetting">
			<div class="wdthpercent100 register">
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['setting']['setting_group_id']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="enter group id" type="text" id="groupid" name="groupid" class="wdthpercent40 required"/><br>
					</div>
			    </div>
			    <div class="clear"></div>
				
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['setting']['setting_group']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="enter group name" type="text" id="group" name="group" class="wdthpercent40 required"/><br>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['setting']['setting_text']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="enter text" type="text" id="text" name="text" class="wdthpercent40 required"/><br>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['setting']['setting_name']?></div>
					<div class="wdthpercent80 left">
					   <input placeholder="enter name" type="text" id="name" name="name" class="wdthpercent40 required"/><br>
					</div>
			    </div>
			    <div class="clear"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left"><?php echo $langVariables['setting']['setting_value']?></div>
					<div class="wdthpercent80 left">
					   <textarea placeholder="enter value" type="text" id="value" name="value" class="wdthpercent40 required"/></textarea><br>
					</div>
			    </div>
			    <div class="clear"></div>				

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent20 left">&nbsp;</div>
					<div class="wdthpercent80 left">
					    <span class=""><input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="addsitesetting"></span>
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