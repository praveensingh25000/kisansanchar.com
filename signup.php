<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$userTypes    = $db->getUniversalRowAll($table_name='user_types');
$countryArray = $db->getUniversalRowAll($table_name='india'," and `parent_id` ='0' ");

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
	
	<div class="entry pL30">
		<form action="" method="post" id="userregistration" name="userregistration">
			
			<div class="wdthpercent100 pT10 pB10">
				<div class="leftcontent">
					<?php echo $langVariables['form_var']['firstname']?>
				</div>
				<div class="rightcontent">
					<input placeholder="<?php echo $langVariables['form_var']['firstname']?>" type="text" id="pfirstname" name="pfirstname" value="<?php if(isset($_SESSION['register_data']['pfirstname'])){ echo $_SESSION['register_data']['pfirstname']; }?>" class="inputbox required"/>
				</div>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<div class="leftcontent">
					<?php echo $langVariables['form_var']['lastname']?>
				</div>
				<div class="rightcontent">
					<input placeholder="<?php echo $langVariables['form_var']['lastname']?>" type="text" id="plastname" name="plastname" value="<?php if(isset($_SESSION['register_data']['plastname'])){ echo $_SESSION['register_data']['plastname']; }?>" class="inputbox required"/>
				</div>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<div class="leftcontent">
					Fathers Name
				</div>
				<div class="rightcontent">
					<input placeholder="Fathers Name" type="text" id="pfathername" name="pfathername" value="<?php if(isset($_SESSION['register_data']['pfathername'])){ echo $_SESSION['register_data']['pfathername']; }?>" class="inputbox required"/>
				</div>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<div class="leftcontent">
					<?php echo $langVariables['form_var']['email']?>
				</div>
				<div class="rightcontent">
					<input placeholder="<?php echo $langVariables['form_var']['email']?>" type="text" id="emailfield" name="email" value="<?php if(isset($_SESSION['register_data']['email'])){ echo $_SESSION['register_data']['email']; }?>" class="email inputbox required"/>
				</div>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">	
				<div class="leftcontent">
					<?php echo $langVariables['form_var']['phone']?>
				</div>
				<div class="rightcontent">
					<input placeholder="<?php echo $langVariables['form_var']['phone']?>" type="text" id="phone" name="phone" value="<?php if(isset($_SESSION['register_data']['phone'])){ echo $_SESSION['register_data']['phone']; }?>" class="digits inputbox required"/>
				</div>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<div class="leftcontent">
					<?php echo $langVariables['form_var']['password']?>
				</div>
				<div class="rightcontent">				
					<input placeholder="<?php echo $langVariables['form_var']['password']?>" type="password" name="password" id="passwordfield" class="inputbox required"/>
				</div>
			</div>
			<div class="clear"></div>	

			<div class="wdthpercent100 pT10 pB10">
				<div class="leftcontent">
					User Type
				</div>
				<div class="rightcontent">
					<?php if(!empty($userTypes)) { ?>
						<select class="wdthpercent83 required" id="user_type" name="user_type">
							<option value=""><?php echo $langVariables['form_var']['select_user_type']?> </option>
							<?php foreach($userTypes as $userTypes) { ?>
								<?php if($userTypes['id']!='17'){?>
									<option value="<?php echo $userTypes['id'];?>" <?php if(isset($_SESSION['register_data']['user_type']) && $_SESSION['register_data']['user_type'] == $userTypes['id']){ echo "selected='selected'"; } ?> ><?php echo ucwords($userTypes['user_type']);?></option>
								<?php } ?>	
							<?php } ?>							
						</select>	
					<?php } ?>	
				</div>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">	
				<div class="leftcontent">
					Gender
				</div>
				<div class="rightcontent">
					<select class="wdthpercent83 required" id="gender" name="gender">
						  <option value=""><?php echo $langVariables['form_var']['gender']?></option>	
						  <option <?php if(isset($_SESSION['register_data']['gender']) && $_SESSION['register_data']['gender'] == 'M'){ echo "selected='selected'"; }?> value="M"><?php echo $langVariables['form_var']['male']?></option>
						  <option <?php if(isset($_SESSION['register_data']['gender']) && $_SESSION['register_data']['gender'] == 'F'){ echo "selected='selected'"; }?> value="F"><?php echo $langVariables['form_var']['female']?></option>
						  <option <?php if(isset($_SESSION['register_data']['gender']) && $_SESSION['register_data']['gender'] == 'O'){ echo "selected='selected'"; }?> value="O"><?php echo $langVariables['form_var']['other']?></option>
					</select>
				</div>	
			</div>
			<div class="clear"></div>
							
			<div class="wdthpercent100 pT10 pB10">
				<div class="leftcontent">
					<?php echo $langVariables['form_var']['dob']?>					
				</div>
				<div class="rightcontent">
					<div class="wdthpercent28 left">
						<select class="wdthpercent99 required" name="month">
						   <?php foreach($month_option as $key => $value){?>
							  <option value="<?php echo $key;?>" <?php if(isset($_SESSION['register_data']['month']) && $_SESSION['register_data']['month'] == $key){ echo "selected='selected'"; } ?> ><?php echo $value;?></option>						       
						   <?php } ?>						   
						</select><br />
						<label style="display:none;" for="month" generated="true" class="error">*</label>
					</div>
					<div class="wdthpercent28 left">
						<select class="wdthpercent99 required" name="day">
						   <?php foreach($day_option as $key => $value){?>
							  <option value="<?php echo $value['id'];?>" <?php if(isset($_SESSION['register_data']['day']) && $_SESSION['register_data']['day'] == $value['id']){ echo "selected='selected'"; } ?> ><?php echo $value['name'];?></option>       
						   <?php } ?>						   
						</select><br />
						<label style="display:none;" for="day" generated="true" class="error">*</label>	
					</div>
					<div class="wdthpercent28 left">
						<select class="wdthpercent97 required" name="year">
						   <?php foreach($year_condition_register as $key => $value){?>
							  <option value="<?php echo $value['id'];?>" <?php if(isset($_SESSION['register_data']['year']) && $_SESSION['register_data']['year'] == $value['id']){ echo "selected='selected'"; } ?> > <?php echo $value['name'];?></option>	       
						   <?php } ?>						   
						</select><br />
						<label style="display:none;" for="year" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
					</div>
				</div>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<div class="leftcontent">
					Country
				</div>
			    <div class="rightcontent">
					<?php if(!empty($countryArray)) { ?>
						<select onchange="javascript:if (typeof functionselectCountryRecord == 'function') {functionselectCountryRecord();}" class="wdthpercent83 required" id="country" name="country">
							<?php foreach($countryArray as $country) { ?>							
								<option value="<?php echo $country['id'];?>"><?php echo ucwords($country['name']);?></option>
							<?php } ?>							
						</select>
						<input type="hidden" id="countryinitial" value="<?php echo (isset($_SESSION['register_data']['country'])?$_SESSION['register_data']['country']:'1'); ?>" />
						<input type="hidden" id="stateinitial" value="<?php echo (isset($_SESSION['register_data']['state'])?$_SESSION['register_data']['state']:'13'); ?>" />
						<input type="hidden" id="districtinitial" value="<?php echo (isset($_SESSION['register_data']['district'])?$_SESSION['register_data']['district']:'203'); ?>" />
						<input type="hidden" id="tehsilinitial" value="<?php echo (isset($_SESSION['register_data']['tahsil'])?$_SESSION['register_data']['tahsil']:'3117'); ?>" />
						<input type="hidden" id="villageinitial" value="<?php echo (isset($_SESSION['register_data']['village'])?$_SESSION['register_data']['village']:'162584'); ?>" />
					<?php } ?>			
				</div>		
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<div class="leftcontent">
					State
				</div>
				<div class="rightcontent">
					<select onchange="javascript:if (typeof functionselectUniversalRecord == 'function') {functionselectUniversalRecord('state','district','3');}" class="wdthpercent83 required" id="state" name="state">
						<option value="">Select State </option>						
					</select>
				</div>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">				
				<div class="leftcontent">
					District
				</div>
				<div class="rightcontent">
					<select onchange="javascript:if (typeof functionselectUniversalRecord == 'function') {functionselectUniversalRecord('district','tahsil','2');}" class="wdthpercent83 required" id="district" name="district">
						<option value="">Select District </option>						
					</select>	
				</div>			
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<div class="leftcontent">
					Tahsil
				</div>
				<div class="rightcontent">
					<select onchange="javascript:if (typeof functionselectUniversalRecord == 'function') {functionselectUniversalRecord('tahsil','village','1');}" class="wdthpercent83 required" id="tahsil" name="tahsil">
						<option value="">Select Tahsil </option>						
					</select>	
				</div>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">	
				<div class="leftcontent">
					Village
				</div>
				<div class="rightcontent">
					<select onchange="javascript:if (typeof functionselectUniversalRecord == 'function') {functionselectUniversalRecord('village','villageotherid','0');}"class="wdthpercent83 required" id="village" name="village">
						<option value="">Select Village </option>						
					</select>
				</div>
			</div>
			<div id="villageotherid" class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<div class="leftcontent">
					Pincode
				</div>
				<div class="rightcontent">
					<input placeholder="Pincode" type="text" id="pincode" name="pincode" value="<?php if(isset($_SESSION['register_data']['pincode'])){ echo $_SESSION['register_data']['pincode']; }?>" class="inputbox required"/>
				</div>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">	
				<div class="leftcontent">
					<?php echo $langVariables['form_var']['captcha'];?>				
				</div>
				<div class="rightcontent" id="captcha_code">
					<?php require_once($DOC_ROOT.'captcha_code_file.php'); ?>				
				</div>							  	
			</div>
			<div class="clear pB10"></div>

			<div class="wdthpercent100 pT10 pB10">				
				<div class="leftcontent">&nbsp;							
				</div>
				<div class="rightcontent">				
					<span><input class="button" type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset"></span>
					<span class="pL40">
						<input class="button" type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="clickregister">
						<input type="hidden" value="clickregister" name="clickregisterbutton">
						<input type="hidden" value="1" name="registration_type">					
					</span>
				</div>			
			</div>
			<div class="clear"></div>

			<script type="text/javascript">jQuery(document).ready(function(){functionselectCountryRecord();});	</script>

		</form>	
		
	</div>

</div>
<!-- CONTAINER -->

<!-- FOOTER -->
<?php include_once $basedir."/include/frontFooter.php"; ?>
<!-- /FOOTER -->