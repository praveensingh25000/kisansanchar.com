<?php
/******************************************
* @Created on May 31, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
******************************************/

$filterassignduserJson = '';

if(isset($_POST['user_addition_type'])){
	$pageDivTypeAddition = $_SESSION['user_addition_type']=$_POST['user_addition_type'];
}else if(isset($_SESSION['user_addition_type'])){
	$pageDivTypeAddition = $_SESSION['user_addition_type'];
}

$districtgroup = $db->getUniversalRowAll($table_name="user_groups"," and `parent_id`= '0' ORDER BY id ");

$filterassigneduserJson  = $userObj->getGlobalUserNameJsonType($tablename='users',$otherfields = ' and groupid IN (1)', $type='by_name');
//echo '<pre>';print_r($filterassigneduserArray);echo '</pre>';
?>
<div id="" class="pT5 pB5">

	<table class="wdthpercent100">
	
		<tr>
			<td class="wdthpercent50">
				Select addition Type
			</td>
			<td class="wdthpercent50">
				<form id="select_content_type_form" method="post" action="">
					<select onchange="javascript: FunctionSelectContentType('select_content_type_form');" class="wdthpercent90" id="user_addition_type" name="user_addition_type">
						<option value="">Select addition Type</option>
						<option <?php if(isset($_SESSION['user_addition_type']) && $_SESSION['user_addition_type']=='individually'){ echo 'selected="selected"';}?> value="individually">Existing farmer from KS Database</option>
						<option <?php if(isset($_SESSION['user_addition_type']) && $_SESSION['user_addition_type']=='grouply'){ echo 'selected="selected"';}?> value="grouply">New Farmer in project</option>
						<option <?php if(isset($_SESSION['user_addition_type']) && $_SESSION['user_addition_type']=='importcsv'){ echo 'selected="selected"';}?> value="importcsv">Import CSV User Data</option>
					</select>
				</form>
			</td>					
		</tr>
	</table>

	<?php if(isset($pageDivTypeAddition) && $pageDivTypeAddition=='importcsv'){ ?>

	<form action="action.php" method="post" id="uploadprojectuserforms" name="uploadprojectuserforms" enctype="multipart/form-data">
		<table class="wdthpercent100">
		
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td class="wdthpercent50">
					Upload CSV
				</td>
				<td class="wdthpercent50">
					<input type="file" accept=".csv" name="importcsv" id="importcsv" class="button required">
				</td>					
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td class="wdthpercent50">&nbsp;</td>
				<td class="wdthpercent50">
					 <span class="">
						<input type="submit" class="button" value="<?php echo $langVariables['form_var']['submit']?>" name="uploadprojectassigneduser">
						<input type="hidden" value="<?php echo $project_id;?>" name="project_id">
					</span>
					<span class="pL40">
						<input type="reset" class="button" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
					</span>
				</td>					
			</tr>							
		</table>
	</form>

	<?php } ?>

	<?php if(isset($pageDivTypeAddition) && $pageDivTypeAddition=='individually'){ ?>

	<form action="action.php" method="post" id="addprojectforms" name="addprojectforms">	
		<table class="wdthpercent100">
		
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td class="wdthpercent50">
					<?php echo $langVariables['form_var']['project_assign_user']?>
				</td>
				<td class="wdthpercent50">
					 <input type="text" name="assigned_users" id="assigned_users" class="wdthpercent40 required"/>
					 <script type="text/javascript">
					 $(document).ready(function() {	
						$("#assigned_users").tokenInput(<?php echo $filterassigneduserJson; ?>, {	
							preventDuplicates: true
						});		
					 });					
					 </script>
				</td>					
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td class="wdthpercent50">&nbsp;</td>
				<td class="wdthpercent50">
					 <span class="">
						<input type="submit" class="button" value="<?php echo $langVariables['form_var']['submit']?>" name="updateprojectassigneduser">
						<input type="hidden" value="<?php echo $project_id;?>" name="project_id">
					</span>
					<span class="pL40">
						<input type="reset" class="button" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
					</span>
				</td>					
			</tr>							
		</table>
	</form>
	<?php } ?>

	<?php if(isset($pageDivTypeAddition) && $pageDivTypeAddition=='grouply'){ 
		$userTypes = $db->getUniversalRowAll($table_name='user_types');
		?>
		<style type="text/css">.inputbox {width:323px !important;}</style>
		<div class="pT10">
			
			<form action="action.php" method="post" id="userregistration" name="userregistration">

				<table class="wdthpercent100">
		
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td class="wdthpercent50">
						<?php echo $langVariables['form_var']['firstname']?>
					</td>
					<td class="wdthpercent50">
						 <input placeholder="<?php echo $langVariables['form_var']['firstname']?>" type="text" id="pfirstname" name="pfirstname" value="<?php if(isset($_SESSION['register_data']['pfirstname'])){ echo $_SESSION['register_data']['pfirstname']; }?>" class="inputbox required"/><br />
					<label style="display:none;" for="pfirstname" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
					</td>					
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td class="wdthpercent50">
						<?php echo $langVariables['form_var']['lastname']?>
					</td>
					<td class="wdthpercent50">
						 <input placeholder="<?php echo $langVariables['form_var']['lastname']?>" type="text" id="plastname" name="plastname" value="<?php if(isset($_SESSION['register_data']['plastname'])){ echo $_SESSION['register_data']['plastname']; }?>" class="inputbox required"/><br />
						<label style="display:none;" for="plastname" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
					</td>					
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td class="wdthpercent50">
						Father Name
					</td>
					<td class="wdthpercent50">
						<input placeholder="Fathers Name" type="text" id="pfathername" name="pfathername" value="<?php if(isset($_SESSION['register_data']['pfathername'])){ echo $_SESSION['register_data']['pfathername']; }?>" class="inputbox required"/><br />
					<label style="display:none;" for="pfathername" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
					</td>					
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td class="wdthpercent50">
						<?php echo $langVariables['form_var']['email']?>
					</td>
					<td class="wdthpercent50">
						 <input placeholder="<?php echo $langVariables['form_var']['email']?>" type="text" id="email" name="email" value="<?php if(isset($_SESSION['register_data']['email'])){ echo $_SESSION['register_data']['email']; }?>" class="email inputbox required"/><br />
						 <label style="display:none;" for="email" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>	
					</td>					
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td class="wdthpercent50">
						<?php echo $langVariables['form_var']['phone']?>
					</td>
					<td class="wdthpercent50">
						 <input placeholder="<?php echo $langVariables['form_var']['phone']?>" type="text" id="phone" name="phone" value="<?php if(isset($_SESSION['register_data']['phone'])){ echo $_SESSION['register_data']['phone']; }?>" class="digits inputbox required"/><br />
						 <label style="display:none;" for="phone" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
					</td>					
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td class="wdthpercent50">
						<?php echo $langVariables['form_var']['password']?>
					</td>
					<td class="wdthpercent50">
						 <input placeholder="<?php echo $langVariables['form_var']['password']?>" type="password" name="password" class="inputbox required"/><br />
					     <label style="display:none;" for="password" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
					</td>					
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td class="wdthpercent50">
					  State						
					</td>
					<td class="wdthpercent50">
						<select onchange="javascript: FunctionSelectUniversal('show_district_list','state','district_state_wise','district');" class="inputbox required" id="state" name="state">
						  <option value="">Select State</option>	
						  <option <?php if(isset($_SESSION['register_data']['state']) && $_SESSION['register_data']['state'] == 'hr'){ echo "selected='selected'"; } ?> value="hr">Haryana</option>	
						  <option <?php if(isset($_SESSION['register_data']['state']) && $_SESSION['register_data']['state'] == 'br'){ echo "selected='selected'"; } ?> value="br">Bihar</option>	
					   </select><br />
					   <label style="display:none;" for="state" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>							
					</td>					
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr id="show_district_list">
					<td class="wdthpercent50">
						District
					</td>
					<td class="wdthpercent50">
						<select class="inputbox required" id="district" name="district">
						    <option value="">Select district</option>	
					    </select><br />
					    <label style="display:none;" for="district" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
					</td>					
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr id="show_village_list">
					<td class="wdthpercent50">
						Village
					</td>
					<td class="wdthpercent50">
						<select class="inputbox required" id="village" name="village">
						    <option value="">Select village</option>	
					    </select><br />
					    <label style="display:none;" for="village" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>
					</td>					
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td class="wdthpercent50">
					  Pincode						
					</td>
					<td class="wdthpercent50">
						<input placeholder="Pincode" type="text" id="pincode" name="pincode" value="<?php if(isset($_SESSION['register_data']['pincode'])){ echo $_SESSION['register_data']['pincode']; }?>" class="inputbox required"/><br />
					    <label style="display:none;" for="pincode" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>					
					</td>					
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td class="wdthpercent50">
					  <?php echo $langVariables['form_var']['select_user_type']?>			
					</td>
					<td class="wdthpercent50">
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
					</td>					
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td class="wdthpercent50">
					    <?php echo $langVariables['form_var']['gender']?>		
					</td>
					<td class="wdthpercent50">
						<select class="inputbox required" id="gender" name="gender">
						  <option value=""><?php echo $langVariables['form_var']['gender']?></option>	
						  <option <?php if(isset($_SESSION['register_data']['gender']) && $_SESSION['register_data']['gender'] == 'M'){ echo "selected='selected'"; }?> value="M"><?php echo $langVariables['form_var']['male']?></option>
						  <option <?php if(isset($_SESSION['register_data']['gender']) && $_SESSION['register_data']['gender'] == 'F'){ echo "selected='selected'"; }?> value="F"><?php echo $langVariables['form_var']['female']?></option>
						  <option <?php if(isset($_SESSION['register_data']['gender']) && $_SESSION['register_data']['gender'] == 'O'){ echo "selected='selected'"; }?> value="O"><?php echo $langVariables['form_var']['other']?></option>
					   </select><br />
					   <label style="display:none;" for="gender" generated="true" class="error"><?php echo $langVariables['form_var']['str_star']?></label>	
					</td>					
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>		

				<tr>
					<td class="wdthpercent50">
					   &nbsp;
					</td>
					<td class="wdthpercent50">
						<span>
							<input class="button" type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
						</span>
						<span class="pL40">
							<input class="button" type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submitregisterformbutton">
							<input type="hidden" value="<?php echo $project_id;?>" name="project_id">
						</span>						
					</td>					
				</tr>

			</table>

		</form>	

	</div>

	<?php } ?>

</div>