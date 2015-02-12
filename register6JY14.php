<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$userTypes = $db->getUniversalRowAll($table_name='user_types');

if(isset($_POST['clickregisterbutton'])){
	if($_SESSION['security_number'] == $_POST['captcha_code']) {
		$result     = $userObj->registration($_POST);	
		if($result) {
			$receivename	=   ucwords($_POST['pfirstname'].' '.$_POST['plastname']);
			$receivermail	=   trim($_POST['email']);
			$endode_email   =   base64_encode($receivermail);
			$fromname		=	FROM_NAME;
			$fromemail		=	FROM_EMAIL;			
			
			$mailbody		=	'Welcome '.$receivename.', <br /><p>You have successfully created a Kisan Sanchar Account! Please click the link below to verify your email address. </p><p><a href="'.URL_SITE.'/index.php?verification='.$endode_email.'">'.URL_SITE.'/index.php?verification='.$endode_email.'</a> </p>
			<p>If you are having trouble clicking on the link, please copy and paste it into your browser. </p><br />
			<p>Thank You </p>
			'.SUPPORT_TEXT.'';

			$subject='Registration Verfication Mail';	
			$send_mail= mail_function($receivename,$receivermail,$fromname,$fromemail,$mailbody,$subject, $attachments = array(),$addcc=array());	
			$_SESSION['msgsuccess'] = "4";
			unset($_SESSION['register_data']);
			header("location:".$URL_SITE."/index.php");
			exit;
		}	
	} else {
		$_SESSION['register_data']   = $_POST;
		$_SESSION['msgerror']        = '3';
		header("location:register.php");
		exit;
	 }	
	
}
?>
<!-- CONTAINER -->
<div class="container">
	<h1 class="txtcenter title"><?php echo $langVariables['heading_var']['register']?></h1>
	<p class="meta"></p>
	
	<div class="entry txtcenter">
		<form action="" method="post" id="userregistration" name="userregistration">
			<div class="wdthpercent100 pT10 pB10">
				<input placeholder="Saluation" type="text" id="saluation" name="saluation" value="<?php if(isset($_SESSION['register_data']['saluation'])){ echo $_SESSION['register_data']['saluation']; }?>" class="inputbox required"/><br />
				<label style="display:none;" for="saluation" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<input placeholder="<?php echo $langVariables['form_var']['firstname']?>" type="text" id="pfirstname" name="pfirstname" value="<?php if(isset($_SESSION['register_data']['pfirstname'])){ echo $_SESSION['register_data']['pfirstname']; }?>" class="inputbox required"/><br />
				<label style="display:none;" for="pfirstname" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<input placeholder="<?php echo $langVariables['form_var']['lastname']?>" type="text" id="plastname" name="plastname" value="<?php if(isset($_SESSION['register_data']['plastname'])){ echo $_SESSION['register_data']['plastname']; }?>" class="inputbox required"/><br />
				<label style="display:none;" for="plastname" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<input placeholder="Fathers Name" type="text" id="pfathername" name="pfathername" value="<?php if(isset($_SESSION['register_data']['pfathername'])){ echo $_SESSION['register_data']['pfathername']; }?>" class="inputbox required"/><br />
				<label style="display:none;" for="pfathername" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">				
				 <input placeholder="<?php echo $langVariables['form_var']['email']?>" type="text" id="emailfield" name="email" value="<?php if(isset($_SESSION['register_data']['email'])){ echo $_SESSION['register_data']['email']; }?>" class="email inputbox required"/><br />
				<label style="display:none;" for="email" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>	
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">					
				<input placeholder="<?php echo $langVariables['form_var']['phone']?>" type="text" id="phone" name="phone" value="<?php if(isset($_SESSION['register_data']['phone'])){ echo $_SESSION['register_data']['phone']; }?>" class="digits inputbox required"/><br />
				<label style="display:none;" for="phone" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<input placeholder="<?php echo $langVariables['form_var']['password']?>" type="password" name="password" class="inputbox required"/><br />
				<label style="display:none;" for="password" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
			</div>
			<div class="clear"></div>				
			
			<div class="wdthpercent100 pT10 pB10">
				<input placeholder="Village" type="text" id="village" name="village" value="<?php if(isset($_SESSION['register_data']['village'])){ echo $_SESSION['register_data']['village']; }?>" class="inputbox required"/><br />
				<label style="display:none;" for="village" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<input placeholder="District" type="text" id="district" name="district" value="<?php if(isset($_SESSION['register_data']['district'])){ echo $_SESSION['register_data']['district']; }?>" class="inputbox required"/><br />
				<label style="display:none;" for="district" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<input placeholder="State" type="text" id="state" name="state" value="<?php if(isset($_SESSION['register_data']['state'])){ echo $_SESSION['register_data']['state']; }?>" class="inputbox required"/><br />
				<label style="display:none;" for="state" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<input placeholder="Pincode" type="text" id="pincode" name="pincode" value="<?php if(isset($_SESSION['register_data']['pincode'])){ echo $_SESSION['register_data']['pincode']; }?>" class="inputbox required"/><br />
				<label style="display:none;" for="pincode" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
			   <?php if(!empty($userTypes)) { ?>
					<select class="inputbox required" id="user_type" name="user_type">
						<option value=""><?php echo $langVariables['form_var']['select_user_type']?> </option>
						<?php foreach($userTypes as $userTypes) { ?>
							<?php if($userTypes['id']!='17'){?>
								<option value="<?php echo $userTypes['id'];?>" <?php if(isset($_SESSION['register_data']['user_type']) && $_SESSION['register_data']['user_type'] == $userTypes['id']){ echo "selected='selected'"; } ?> ><?php echo ucwords($userTypes['user_type']);?></option>
							<?php } ?>	
						<?php } ?>							
					</select><br />
					<label style="display:none;" for="user_type" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>	
				<?php } ?>					
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">				  
				<select class="inputbox required" id="gender" name="gender">
					  <option value=""><?php echo $langVariables['form_var']['gender']?></option>	
					  <option <?php if(isset($_SESSION['register_data']['gender']) && $_SESSION['register_data']['gender'] == 'M'){ echo "selected='selected'"; }?> value="M"><?php echo $langVariables['form_var']['male']?></option>
					  <option <?php if(isset($_SESSION['register_data']['gender']) && $_SESSION['register_data']['gender'] == 'F'){ echo "selected='selected'"; }?> value="F"><?php echo $langVariables['form_var']['female']?></option>
					  <option <?php if(isset($_SESSION['register_data']['gender']) && $_SESSION['register_data']['gender'] == 'O'){ echo "selected='selected'"; }?> value="O"><?php echo $langVariables['form_var']['other']?></option>
				</select><br />
				<label style="display:none;" for="gender" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>	
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 dobtext">
				<?php echo $langVariables['form_var']['dob']?>					
			</div>
			<div class="clear"></div>
							
			<div class="wdthpercent100 pT10 pB10" style="margin-left: 87px;">	
				<div class="wdthpercent10 left">
					<select class="dob required" name="month">
					   <?php foreach($month_option as $key => $value){?>
						  <option value="<?php echo $key;?>" <?php if(isset($_SESSION['register_data']['month']) && $_SESSION['register_data']['month'] == $key){ echo "selected='selected'"; } ?> ><?php echo $value;?></option>						       
					   <?php } ?>						   
					</select><br />
					<label style="display:none;" for="month" generated="true" class="error">*</label>
				</div>
				<div class="wdthpercent10 left">
					<select class="dob required" name="day">
					   <?php foreach($day_option as $key => $value){?>
						  <option value="<?php echo $value['id'];?>" <?php if(isset($_SESSION['register_data']['day']) && $_SESSION['register_data']['day'] == $value['id']){ echo "selected='selected'"; } ?> ><?php echo $value['name'];?></option>       
					   <?php } ?>						   
					</select><br />
					<label style="display:none;" for="day" generated="true" class="error">*</label>	
				</div>
				<div class="wdthpercent10 left">
					<select class="dob required" name="year">
					   <?php foreach($year_condition_register as $key => $value){?>
						  <option value="<?php echo $value['id'];?>" <?php if(isset($_SESSION['register_data']['year']) && $_SESSION['register_data']['year'] == $value['id']){ echo "selected='selected'"; } ?> > <?php echo $value['name'];?></option>	       
					   <?php } ?>						   
					</select><br />
					<label style="display:none;" for="year" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
				</div>
			</div>
			<div class="clear pB10"></div>

			<div class="wdthpercent100 dobtext">					
				<?php echo $langVariables['form_var']['captcha'];?>					   				
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10 gender">									
				<span id="captcha_code">
					<?php require_once($DOC_ROOT.'captcha_code_file.php'); ?>
			   </span>				  	
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">				
				<span class="">
				<input class="button" type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="clickregister">
				<input type="hidden" value="clickregister" name="clickregisterbutton">
				<input type="hidden" value="1" name="registration_type">
				</span>
				<span class="pL40"><input class="button" type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset"></span>
			</div>
			<div class="clear"></div>

		</form>	
		
	</div>

</div>
<!-- CONTAINER -->

<!-- FOOTER -->
<?php include_once $basedir."/include/frontFooter.php"; ?>
<!-- /FOOTER -->