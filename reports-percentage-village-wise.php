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
<div class="wdthpercent100 pL20">

	<form action="<?php echo URL_SITE;?>/reports-percentage-village-wise-data.php" method="post" id="reports-percentage-village-wise-form">

		<table class="data-table">
			
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
						<select onchange="javascript:if (typeof functionVillageProjectLocationUniversal == 'function') {functionVillageProjectLocationUniversal('country','state','s');}" class="wdthpercent77 required" id="country" name="country">
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
					Select State
				</td>
				<td class="rht-td">
					<select onchange="javascript:if (typeof functionprojectLocationUniversal == 'function') {functionprojectLocationUniversal('state','district','d');}" class="wdthpercent77 required" id="state" name="state">
						<option value="">Select State </option>						
					</select>
				</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>			
				<td class="lft-td">
					District
				</td>
				<td class="rht-td">
					<select onchange="javascript:if (typeof functionprojectLocationUniversal == 'function') {functionprojectLocationUniversal('district','tahsil','t');}" class="wdthpercent77 required" id="district" name="district">
						<option value="">Select District </option>						
					</select>
					<input onclick="javascript: functionsetunsetrequried('alldistrictreport','district');" type="checkbox" id="alldistrictreport" name="alldistrictreport" value="1">&nbsp;All
				</td>			
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td class="lft-td">
					Tehsil
				</td>
				<td class="rht-td">
					<select onchange="javascript:if (typeof functionprojectLocationUniversal == 'function') {functionprojectLocationUniversal('tahsil','village','v');}" class="wdthpercent77 required" id="tahsil" name="tehsil">
						<option value="">Select Tahsil </option>						
					</select>	
					<input type="checkbox" onclick="javascript: functionsetunsetrequried('alltahsilreport','tahsil');" id="alltahsilreport" name="alltahsilreport" value="1">&nbsp;All
				</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td class="lft-td">
					Village
				</td>
				<td class="rht-td">
					<select multiple size="10" class="wdthpercent77 required villageall" id="village" name="village[]">
						<option value="">Select Village </option>						
					</select>
					<input type="checkbox" onclick="javascript: functionsetunsetrequried('allvillagereport','village');" id="allvillagereport" name="allvillagereport" value="1">&nbsp;All
					<span id="hideselectallvillagediv">
						<br />
						<em class="red font12">press control to select multiple</em>
						<input type="checkbox" id="checkallVillage">&nbsp;All
						<script type="text/javascript">
						jQuery(document).ready(function(){
							jQuery("#checkallVillage").click(function(){
								var checkedd =  this.checked ? true : false;
								if(checkedd){
									jQuery(".villageall option").prop('selected', true);
								}else{
									jQuery(".villageall option").removeAttr("selected");
								}
							});
							jQuery(".villageall").click(function(){							
								jQuery("#checkallVillage").removeAttr("checked");
							});
						});
					  </script>
				  </span>
				</td>
			<tr id="villageotherid" />

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr id="select_user_sub_Group"></tr>

			<tr id="select_user_sub_Group_padding"><td>&nbsp;</td><td>&nbsp;</td></tr> -->

			<!-- <tr>
				<td class="lft-td">
					Select For all Village
				</td>
				<td class="rht-td">	
					<input onclick="javascript: functionsetunsetrequried('allvillagereport','village');" type="checkbox" id="allvillagereport" name="allvillagereport" value="1">&nbsp;Check for all village Report at a time.	
				</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr> -->

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
						  <option value="<?php echo $key;?>" <?php if('08' == $key){ echo "selected='selected'";}?>><?php echo $value;?></option>
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
				<td class="lft-td">
					Percentage Fields
				</td>

				<td class="rht-td">
					<TABLE id="PercentageTable" class="data-table wdthpercent77">
						<TR>
							<TD>
								<INPUT class="wdthpercent90 required" placeholder="To %" id="" type="text" name="percentageto[]" class="from" />
							</TD>
							<TD>
								<INPUT class="wdthpercent90 required" placeholder="From %" id="" type="text" name="percentagefrom[]" class=""/>
							</TD>
							<TD><INPUT class="wdthpercent90" type="checkbox" name=""/>&nbsp;&nbsp;&nbsp;<span class="blue font10">Remove</span></TD>
						</TR>
					</TABLE>
				</td>
			</tr>

			<tr>
				<td class="lft-td">&nbsp;</td>
				<td class="rht-td">
					<input type="button" class="button" value="Add Row" onclick="add_percentage_function('PercentageTable')" />
					<input type="button" class="button" value="Delete Row" onclick="delete_percentage_function('PercentageTable')" />
				</td>
			</tr>

			<tr>
				<td class="lft-td">&nbsp;</td>
				<td class="rht-td">
					<input type="hidden" value="searchvillagewise" name="searchvillagewisedata">
					<input type="submit" id="submitid" onclick="javascript:ShowSubmitTextGlobal('submitid','reset','reports-percentage-village-wise-form');" class="button" name="search" value="Generate Report" />
				</td>
			</tr>

			<script type="text/javascript">jQuery(document).ready(function(){functionVillageProjectLocationUniversal('country','state','s');});</script>

		</table>

	</form>
</div>