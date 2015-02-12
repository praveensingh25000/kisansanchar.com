<fieldset style="border: 1px solid #cccccc; padding: 10px;">	
	<form action="action.php" id="updatebackuserprofile" name="updatebackuserprofile" method="post">															
		<table class="data-table">	
			<tbody>

				<tr>
					<th><p class="pB5"><?php echo $langVariables['form_var']['firstname']?><em><?php echo $langVariables['form_var']['str_star']?></em></p></th>
					<th>
						<input placeholder="Enter your first name" name="pfirstname" type="text" value="<?php if(isset($userDetail['pfirstname'])){ echo stripslashes($userDetail['pfirstname']); }?>" class="wdthpercent80 inputbox required" id="pfirstname" />
					</th>
				</tr>

				<tr>
					<th><p class="pB5"><?php echo $langVariables['form_var']['lastname']?><em><?php echo $langVariables['form_var']['str_star']?></em></p></th>
					<th>
						<input placeholder="Enter your last name" name="plastname" type="text" value="<?php if(isset($userDetail['plastname'])){ echo stripslashes($userDetail['plastname']); }?>" class="wdthpercent80 inputbox required" id="plastname" />
					</th>
				</tr>

				<?php if(!$projectObj->checkProjectUser($userDetail['id']) && is_numeric($userDetail['user_type'])) {?>

				<tr>
					<th><p class="pB5"><?php echo $langVariables['form_var']['fathername']?><em><?php echo $langVariables['form_var']['str_star']?></em></p></th>
					<th>
						<input placeholder="Enter your father's name" name="pfathername" type="text" value="<?php if(isset($userDetail['pfathername'])){ echo stripslashes($userDetail['pfathername']); }?>" class="wdthpercent80 inputbox required" id="pfathername" />
					</th>
				</tr>

				<?php } ?>

				<tr>
					<th><p class="pB5"><?php echo $langVariables['form_var']['email']?><em><?php echo $langVariables['form_var']['str_star']?></em></p></th>
					<th>
						<input <?php if(!empty($userDetail['email'])){?>disabled="true"<?php } ?>class="wdthpercent80 inputbox email required" placeholder="Enter your email" name="email" value="<?php if(isset($userDetail['email'])){ echo stripslashes($userDetail['email']); }?>" type="text" id="email" />
					</th>
				</tr>

				<tr>
					<th><p class="pB5"><?php echo $langVariables['form_var']['phone']?><em><?php echo $langVariables['form_var']['str_star']?></em></p></th>
					<th>
						<input class="wdthpercent80 inputbox required" placeholder="Enter your phone Number" name="phone" type="text" value="<?php if(isset($userDetail['phone'])){ echo stripslashes($userDetail['phone']); }?>" id="phone" onchange="chckphone('phone')"/><em class="blue"><?php echo $langVariables['general_var']['ph_msg']?></em>
						<input  type="hidden" value="<?php echo stripslashes($userDetail['phone']); ?>" name="oldphone" id="oldphone" />
					</th>
				</tr>

				<tr>
					<th><p class="pB5"><?php echo $langVariables['form_var']['password']?></p></th>
					<th>
						<input type="password" placeholder="Enter your password" name="password" id="password" class="wdthpercent80 inputbox" /><br>
						<em class="blue"><?php echo $langVariables['general_var']['password_msg']?></em>
					</th>
					<script type="text/javascript">jQuery(document).ready(function(){jQuery("#password").val('');});</script>
				</tr>

				<?php if(!$projectObj->checkProjectUser($userDetail['id']) && is_numeric($userDetail['user_type'])) {?>

				<tr>
					<th><p class="pB5">User Type</p></th>
					<th>
						<?php if(!empty($userTypes)) { ?>
							<select class="wdthpercent82 required" id="user_type" name="user_type">
								<option value=""><?php echo $langVariables['form_var']['select_user_type']?> </option>
								<?php foreach($userTypes as $userTypes) { ?>
									<?php if($userTypes['id']!='17'){?>
										<option value="<?php echo $userTypes['id'];?>" <?php if(isset($userDetail['user_type']) && $userDetail['user_type'] == $userTypes['id']){ echo "selected='selected'"; } ?> ><?php echo ucwords($userTypes['user_type']);?></option>
									<?php } ?>	
								<?php } ?>							
							</select>	
						<?php } ?>	
					</th>					
				</tr>

				<?php } ?>

				<tr>
					<th><p class="pB5">Country</p></th>
					<th>
						<?php if(!empty($countryArray)) { ?>
							<select onchange="javascript:if (typeof functionselectCountryRecord == 'function') {functionselectCountryRecord();}" class="wdthpercent82 required" id="country" name="country">
								<?php foreach($countryArray as $country) { ?>							
									<option value="<?php echo $country['id'];?>"><?php echo ucwords($country['name']);?></option>
								<?php } ?>							
							</select>
							<input type="hidden" id="countryinitial" value="<?php echo (isset($_SESSION['register_data']['country'])?$_SESSION['register_data']['country']:'1'); ?>" />
							<input type="hidden" id="stateinitial" value="<?php if(isset($userDetail['state'])){ echo ($userDetail['state']);}?>" />
							<input type="hidden" id="districtinitial" value="<?php if(isset($userDetail['district'])){ echo ($userDetail['district']);}?>" />
							<input type="hidden" id="tehsilinitial" value="<?php if(isset($userDetail['tehsil'])){ echo ($userDetail['tehsil']);}?>" />
							<input type="hidden" id="villageinitial" value="<?php if(isset($userDetail['village'])){ echo ($userDetail['village']);}?>" />
						<?php } ?>		
					</th>
				<tr>

				<tr>
					<th><p class="pB5"><?php echo $langVariables['form_var']['state']?></p></th>
					<th>
						<select onchange="javascript:if (typeof functionselectUniversalRecord == 'function') {functionselectUniversalRecord('state','district','3');}" class="wdthpercent82 required" id="state" name="state">
							<option value="">Select State </option>						
						</select>
					</th>
				</tr>

				<tr>
					<th><p class="pB5"><?php echo $langVariables['form_var']['district']?></p></th>
					<th>
						<select onchange="javascript:if (typeof functionselectUniversalRecord == 'function') {functionselectUniversalRecord('district','tahsil','2');}" class="wdthpercent82 required" id="district" name="district">
							<option value="">Select District </option>						
						</select>	
					</th>
				</tr>

				<tr>
					<th><p class="pB5"><?php echo $langVariables['form_var']['tehsil']?></p></th>
					<th>
						<select onchange="javascript:if (typeof functionselectUniversalRecord == 'function') {functionselectUniversalRecord('tahsil','village','1');}" class="wdthpercent82 required" id="tahsil" name="tehsil">
							<option value="">Select Tahsil </option>						
						</select>	
					</th>
				</tr>

				<tr>
					<th><p class="pB5"><?php echo $langVariables['form_var']['village']?></p></th>
					<th>
						<select onchange="javascript:if (typeof functionselectUniversalRecord == 'function') {functionselectUniversalRecord('village','villageotherid','0');}"class="wdthpercent82 required" id="village" name="village">
							<option value="">Select Village </option>						
						</select>
					</th>
				</tr>
				
				<tr>
					<th><p class="pB5"><?php echo $langVariables['form_var']['pincode']?></p></th>
					<th>
						<input class="wdthpercent80 inputbox required digits" type="text" placeholder="Enter your pincode" name="pincode" id="pincode" value="<?php if(isset($userDetail['pincode'])){ echo ($userDetail['pincode']);}?>"/>
					</th>
				</tr>

				<?php if(!$projectObj->checkProjectUser($userDetail['id']) && is_numeric($userDetail['user_type'])) {?>

				<tr>
					<th><p class="pB5"><?php echo $langVariables['form_var']['gender']?><em><?php echo $langVariables['form_var']['str_star']?></em></p></th>
					<th>
						<select class="wdthpercent80 inputbox required" id="gender" name="gender">
						  <option value=""><?php echo $langVariables['form_var']['gender']?></option>	<option <?php if(isset($userDetail['gender']) && $userDetail['gender'] == 'M'){ echo "selected='selected'"; }?> value="M"><?php echo $langVariables['form_var']['male']?></option>
						  <option <?php if(isset($userDetail['gender']) && $userDetail['gender'] == 'F'){ echo "selected='selected'"; }?> value="F"><?php echo $langVariables['form_var']['female']?></option>
						  <option <?php if(isset($userDetail['gender']) && $userDetail['gender'] == 'O'){ echo "selected='selected'"; }?> value="O"><?php echo $langVariables['form_var']['other']?></option>
					   </select><br />
					   <label style="display:none;" for="gender" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?><?php echo $langVariables['form_var']['required']?></label>	
					</th>
				</tr>

				<tr>
					<th><p class="pB5"><?php echo $langVariables['form_var']['date_ob']?><em><?php echo $langVariables['form_var']['str_star']?></em></p></th>
					<th>
						<select class="wdthpercent20" name="day">
						   <?php foreach($day_option as $key => $value){?>
							  <option value="<?php echo $value['id'];?>" <?php if(isset($daySet) && $daySet == $value['id']){ echo "selected='selected'"; } ?> ><?php echo $value['name'];?></option>       
						   <?php } ?>						   
						</select>
						<label style="display:none;" for="day" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?><?php echo $langVariables['form_var']['required']?></label>	
						
						<select class="wdthpercent30" name="month">
						   <?php foreach($month_option as $key => $value){?>
							  <option value="<?php echo $key;?>" <?php if(isset($monthSet) && $monthSet == $key){ echo "selected='selected'"; } ?> ><?php echo $value;?></option>						       
						   <?php } ?>						   
						</select>
						<label style="display:none;" for="month" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?><?php echo $langVariables['form_var']['required']?></label>			
					
						<select class="wdthpercent30" name="year">
						   <?php foreach($year_r_option as $key => $value){?>
							  <option value="<?php echo $value['id'];?>" <?php if(isset($yearSet) && $yearSet == $value['id']){ echo "selected='selected'"; } ?> > <?php echo $value['name'];?></option>	       
						   <?php } ?>						   
						</select>
						<label style="display:none;" for="year" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?><?php echo $langVariables['form_var']['required']?></label>
					</th>
				</tr>

				<?php } ?>

				<tr>
					<th>
						<input type="hidden" value="<?php if(isset($userDetail['id'])){ echo trim($userDetail['id']); }?>" name="userid">
						<input type="hidden" value="Submit" name="updateuserprofileadmin">
						<input type="hidden" value="<?php echo $sectionType;?>" name="sectionType">
					</th>
					<th>
						<input type="submit" value="Submit" name="updateuserprofile" class="button" /> &nbsp;&nbsp;&nbsp;
						<input onclick="javascript:window.history.go(-1)" type="button" value="Back" class="button">
					</th>
				</tr>
			</tbody>
		</table>
		<script type="text/javascript">jQuery(document).ready(function(){functionselectCountryRecord();});	</script>
	</form>
</fieldset>	