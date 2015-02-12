<?php
/******************************************
* @Created on May 31, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
******************************************/

$countryArray  = $db->getUniversalRowAll($table_name='india'," and `parent_id` ='0' ");
$language_type = 'hi';
?>
<div class="wdthpercent100 pL20 pB10">

	<form action="<?php echo URL_SITE;?>/reports-percentage-farmer-wise-data.php" method="post" id="reports-percentage-farmer-wise-form">

		<table class="data-table">
			
			<tr>
				<td class="lft-td"><?php echo $langVariables['form_var']['gender']?></td>
				<td class="rht-td">
					<select onchange="javascript:if (typeof functionFarmerGenderProjectLocationUniversal == 'function') {functionFarmerGenderProjectLocationUniversal('country','state','s');}" class="wdthpercent77 required" id="gender" name="gender">
					   <option value="all">All</option>
					   <option value="M"><?php echo $langVariables['form_var']['male']?></option>
					   <option value="F"><?php echo $langVariables['form_var']['female']?></option>
				   </select>	
				</td>
			</tr>

			<tr>
				<td class="lft-td">
					Language
				</td>
			    <td class="rht-td">
					<?php if(!empty($languageArray)) { ?>
						<select id="language_type" class="wdthpercent77 required" name="language_type">
							<?php foreach($languageArray as $language) { ?>
								<option <?php if(isset($language_type) && $language_type == $language['name']){ echo "selected='selected'"; } ?> value="<?php echo $language['name'];?>"><?php echo ucwords(strtolower($language['value']));?></option>
							<?php } ?>							
						</select>						
					<?php } ?>
				</td>		
			</tr>

			<tr>
				<td class="lft-td">
					Country
				</td>
			    <td class="rht-td">
					<?php if(!empty($countryArray)) { ?>
						<select onchange="javascript:if (typeof functionFarmerProjectLocationUniversal == 'function') {functionFarmerProjectLocationUniversal('country','state','s');}" class="wdthpercent77 required" id="country" name="country">
							<?php foreach($countryArray as $country) { ?>							
								<option value="<?php echo $country['id'];?>"><?php echo ucwords($country['name']);?></option>
							<?php } ?>							
						</select>
						<input type="hidden" id="countryinitial" value="<?php echo (isset($_SESSION['register_data']['country'])?$_SESSION['register_data']['country']:'1'); ?>" />						
					<?php } ?>			
				</td>		
			</tr>

			<tr id="countrystate"></tr>
			<tr id="statedistrict"></tr>
			<tr id="districttahsil"></tr>
			<tr id="tahsilvillage"></tr>

			<!-- <tr>
				<td class="lft-td">
					Country
				</td>
			    <td class="rht-td">
					<?php if(!empty($countryArray)) { ?>
						<select onchange="javascript:if (typeof functionselectUniversalRecordReport == 'function') {functionselectUniversalRecordReport();}" class="wdthpercent70 required" id="country" name="country">
							<?php foreach($countryArray as $country) { ?>							
								<option value="<?php echo $country['id'];?>"><?php echo ucwords($country['name']);?></option>
							<?php } ?>							
						</select>
						<input type="hidden" id="countryinitial" value="<?php echo (isset($_SESSION['register_data']['country'])?$_SESSION['register_data']['country']:'1'); ?>" />
						<input type="hidden" id="stateinitial" value="<?php echo (isset($_SESSION['register_data']['state'])?$_SESSION['register_data']['state']:'13'); ?>" />
						<input type="hidden" id="districtinitial" value="<?php echo (isset($_SESSION['register_data']['district'])?$_SESSION['register_data']['district']:'203'); ?>" />
						<input type="hidden" id="tehsilinitial" value="<?php echo (isset($_SESSION['register_data']['tahsil'])?$_SESSION['register_data']['tahsil']:'3118'); ?>" />
						<input type="hidden" id="villageinitial" value="<?php echo (isset($_SESSION['register_data']['village'])?$_SESSION['register_data']['village']:'162584'); ?>" />
					<?php } ?>			
				</td>		
			</tr>

			<tr>
				<td class="lft-td">
					State
				</td>
				<td class="rht-td">
					<select onchange="javascript:if (typeof functionselectUniversalRecordReport == 'function') {functionselectUniversalRecordReport('state','district','3','checkbox');}" class="wdthpercent70 required" id="state" name="state">
						<option value="">Select State </option>						
					</select>
				</td>
			</tr>

			<tr>			
				<td class="lft-td">
					District
				</td>
				<td class="rht-td">
					<select onchange="javascript:if (typeof functionselectUniversalRecordReport == 'function') {functionselectUniversalRecordReport('district','tahsil','2','checkbox');}" class="wdthpercent70 required" id="district" name="district">
						<option value="">Select District </option>						
					</select>	
				</td>			
			</tr>

			<tr>
				<td class="lft-td">
					Tehsil
				</td>
				<td class="rht-td">
					<select onchange="javascript:if (typeof functionselectUniversalRecordReport == 'function') {functionselectUniversalRecordReport('tahsil','village','tahsil','checkbox');}" class="wdthpercent70 required" id="tahsil" name="tehsil">
						<option value="">Select Tahsil </option>						
					</select>	
				</td>
			</tr>

			<tr id="village">
				<td class="lft-td">&nbsp;</td>
				<td class="rht-td"><span class="sLoader">Loading...</span></td>
			</tr> -->

			<tr id="display_farmer_wise_list"></tr>

			<tr>
				<td class="lft-td">
					Select Message Status
				</td>
				<td class="rht-td">	
					<?php if(!empty($contentstatus)){?>								
						<select class='wdthpercent77' name='content_status' id='content_status'>
							<option value="0">select Message Status</option>
							<option selected="selected" value="all">All</option>
							<?php foreach($contentstatus as $key => $status){ ?>
								<option value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
							<?php } ?>
						</select>
					<?php } ?>			
				</td>
			</tr>

			<tr>
				<td class="lft-td">
					Select Duration Status
				</td>
				<td class="rht-td">			
					<select class="wdthpercent36" name="month">
					   <?php foreach($month_analysis_option as $key => $value){?>
						  <option value="<?php echo $key;?>" <?php if('11' == $key){ echo "selected='selected'";}?>><?php echo $value;?></option>
					   <?php } ?>						   
					</select>					
					<select class="wdthpercent40" name="year">
					   <?php foreach($year_condition_analysis as $key => $value){?>
						  <option value="<?php echo $value['id'];?>" <?php if($value['id']=='2013'){ echo "selected='selected'"; } ?> > <?php echo $value['name'];?></option>    
					   <?php } ?>						   
					</select>
				</td>
			</tr>

			<tr>
				<td class="lft-td">&nbsp;</td>
				<td class="rht-td">
					<input type="hidden" value="searchfarmerwise" name="searchfarmerwise">
					<input type="submit" id="submitid" onclick="javascript:ShowSubmitTextGlobal('submitid','reset','reports-percentage-farmer-wise-form');" class="button" name="search" value="Generate Report" />
				</td>
			</tr>

			<!-- <script type="text/javascript">jQuery(document).ready(function(){functionselectCountryRecordReport('checkbox');});</script> -->
			<script type="text/javascript">jQuery(document).ready(function(){functionFarmerProjectLocationUniversal('country','state','s');});</script>

		</table>

	</form>
</div>