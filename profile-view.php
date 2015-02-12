<table class="data-table">	
	<tbody>

		<tr>
			<th><p class="pB5 "><?php echo $langVariables['form_var']['firstname']?><em><?php echo $langVariables['form_var']['str_star']?></em></p></th>
			<th>
				<input class="viewprofile" placeholder="Enter your first name" name="pfirstname" type="text" value="<?php if(isset($userDetail['pfirstname'])){ echo stripslashes($userDetail['pfirstname']); }?>" class="viewprofile" id="pfirstname" disabled="true"/>
			</th>
		</tr>

		<tr>
			<th><p class="pB5 "><?php echo $langVariables['form_var']['lastname']?><em><?php echo $langVariables['form_var']['str_star']?></em></p></th>
			<th>
				<input class="viewprofile" placeholder="Enter your last name" name="plastname" type="text" value="<?php if(isset($userDetail['plastname'])){ echo stripslashes($userDetail['plastname']); }?>" class="viewprofile" id="plastname" disabled="true"/>
			</th>
		</tr>

		<?php if(!isset($is_project_admin) && !isset($is_project_user)) {?>

		<tr>
			<th><p class="pB5"><?php echo $langVariables['form_var']['fathername']?><em><?php echo $langVariables['form_var']['str_star']?></em></p></th>
			<th>
				<input class="viewprofile" placeholder="Enter your father's name" name="pfathername" type="text" value="<?php if(isset($userDetail['pfathername'])){ echo stripslashes($userDetail['pfathername']); }?>" class="viewprofile" id="pfathername" disabled="true"/>
			</th>
		</tr>

		<?php } ?>

		<tr>
			<th><p class="pB5"><?php echo $langVariables['form_var']['email']?><em><?php echo $langVariables['form_var']['str_star']?></em></p></th>
			<th>
				<input <?php if(!empty($userDetail['email'])){?>disabled="true"<?php } ?> class="viewprofile" placeholder="Enter your email" name="email" value="<?php if(isset($userDetail['email'])){ echo stripslashes($userDetail['email']); }?>" type="text" id="email" />
			</th>
		</tr>

		<tr>
			<th><p class="pB5"><?php echo $langVariables['form_var']['phone']?><em><?php echo $langVariables['form_var']['str_star']?></em></p></th>
			<th>
				<input class="viewprofile" placeholder="Enter your phone Number" name="phone" type="text" value="<?php if(isset($userDetail['phone'])){ echo stripslashes($userDetail['phone']); }?>" id="phone" onchange="chckphone('phone')" disabled="true"/><em class="blue"><?php echo $langVariables['general_var']['ph_msg']?></em>
				<input  type="hidden" value="<?php echo stripslashes($userDetail['phone']); ?>" name="oldphone" id="oldphone" disabled="true"/>
			</th>
		</tr>

		<tr>
			<th><p class="pB5">Country</p></th>
			<th>
				<?php if(!empty($countryArray)) { ?>
					<select  onchange="javascript:if (typeof functionselectCountryRecord == 'function') {functionselectCountryRecord();}" class="wdthpercent83 viewprofile" id="country" name="country" disabled="true">
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
				<select onchange="javascript:if (typeof functionselectUniversalRecord == 'function') {functionselectUniversalRecord('state','district','3');}" class="wdthpercent83 viewprofile" id="state" name="state" disabled="true">
					<option value="">Select State </option>						
				</select>
			</th>
		</tr>

		<tr>
			<th><p class="pB5"><?php echo $langVariables['form_var']['district']?></p></th>
			<th>
				<select onchange="javascript:if (typeof functionselectUniversalRecord == 'function') {functionselectUniversalRecord('district','tahsil','2');}" class="wdthpercent83 viewprofile" id="district" name="district" disabled="true">
					<option value="">Select District </option>						
				</select>	
			</th>
		</tr>

		<tr>
			<th><p class="pB5"><?php echo $langVariables['form_var']['tehsil']?></p></th>
			<th>
				<select onchange="javascript:if (typeof functionselectUniversalRecord == 'function') {functionselectUniversalRecord('tahsil','village','1');}" class="wdthpercent83 viewprofile" id="tahsil" name="tahsil" disabled="true">
					<option value="">Select Tehsil </option>						
				</select>	
			</th>
		</tr>

		<tr>
			<th><p class="pB5"><?php echo $langVariables['form_var']['village']?></p></th>
			<th>
				<select onchange="javascript:if (typeof functionselectUniversalRecord == 'function') {functionselectUniversalRecord('village','villageotherid','0');}"class="wdthpercent83 viewprofile" id="village" name="village" disabled="true">
					<option value="">Select Village </option>						
				</select>
			</th>
		</tr>
		
		<tr>
			<th><p class="pB5"><?php echo $langVariables['form_var']['pincode']?></p></th>
			<th>
				<input class="viewprofile" type="number" placeholder="Enter your pincode" name="pincode" id="pincode" value="<?php if(isset($userDetail['pincode'])){ echo ($userDetail['pincode']);}?>" disabled="true"/>
			</th>
		</tr>

		<?php if(!isset($is_project_admin) && !isset($is_project_user)) {?>

		<tr>
			<th><p class="pB5"><?php echo $langVariables['form_var']['gender']?><em><?php echo $langVariables['form_var']['str_star']?></em></p></th>
			<th>
				<select class="viewprofile" id="gender" name="gender" disabled="true">
				  <option value=""><?php echo $langVariables['form_var']['gender']?></option>	<option <?php if(isset($userDetail['gender']) && $userDetail['gender'] == 'M'){ echo "selected='selected'"; }?> value="M"><?php echo $langVariables['form_var']['male']?></option>
				  <option <?php if(isset($userDetail['gender']) && $userDetail['gender'] == 'F'){ echo "selected='selected'"; }?> value="F"><?php echo $langVariables['form_var']['female']?></option>
				  <option <?php if(isset($userDetail['gender']) && $userDetail['gender'] == 'O'){ echo "selected='selected'"; }?> value="O"><?php echo $langVariables['form_var']['other']?></option>
			   </select>
			</th>
		</tr>

		<tr>
			<th><p class="pB5"><?php echo $langVariables['form_var']['date_ob']?><em><?php echo $langVariables['form_var']['str_star']?></em></p></th>
			<th>
				<select class="wdthpercent20 viewprofile" name="day" disabled="true">
				   <?php foreach($day_option as $key => $value){?>
					  <option value="<?php echo $value['id'];?>" <?php if(isset($daySet) && $daySet == $value['id']){ echo "selected='selected'"; } ?> ><?php echo $value['name'];?></option>       
				   <?php } ?>						   
				</select>				
				<select class="wdthpercent30 viewprofile" name="month" disabled="true">
				   <?php foreach($month_option as $key => $value){?>
					  <option value="<?php echo $key;?>" <?php if(isset($monthSet) && $monthSet == $key){ echo "selected='selected'"; } ?> ><?php echo $value;?></option>						       
				   <?php } ?>						   
				</select>
				<select class="wdthpercent30 viewprofile" name="year" disabled="true">
				   <?php foreach($year_r_option as $key => $value){?>
					  <option value="<?php echo $value['id'];?>" <?php if(isset($yearSet) && $yearSet == $value['id']){ echo "selected='selected'"; } ?> > <?php echo $value['name'];?></option>	       
				   <?php } ?>						   
				</select>
			</th>
		</tr>

		<?php } ?>

		<tr>
			<th>
				<input type="hidden" value="<?php if(isset($userDetail['id'])){ echo trim($userDetail['id']); }?>" name="userid">
			</th>
			<th>					
				<input onclick="javascript:window.history.go(-1)" type="button" value="Back" class="button">
			</th>
		</tr>
	</tbody>
</table>
<script type="text/javascript">jQuery(document).ready(function(){functionselectCountryRecord();});	</script>