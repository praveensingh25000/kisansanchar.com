<?php
/******************************************
* @Created on May 31, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
******************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

checkSession(false,2);
checkDashboard($dashbordType);

$countryArray  = $db->getUniversalRowAll($table_name='india'," and `parent_id` ='0' ");
$language_type = 'hi';
?>
<div class="container">

	<h1 class="title">Add Project Location<span class="right"><a href="<?php echo URL_SITE;?>/project-profile.php?tab=pls">Back</a></span></h1>

	<div class="entry">

		<div class="wdthpercent100 pL20 pT10">

			<form action="action.php" method="POST" id="add-project-location-form" name="add-project-location-form">

			   <style>#country, #states, #district, #telshil, #village, #user_type, #gender { padding: 0px 0px 0px 0px !important;margin: 0px 0px 0px 0px !important;}</style>
					
				<div class="wdthpercent100 pT10 pB10">
					<div class="leftcontentpro">
						Country
					</div>
					<div class="rightcontent">
						<?php if(!empty($countryArray)) { ?>
							<select onchange="javascript:if (typeof functionAddLocationUniversal == 'function') {functionAddLocationUniversal('country','state');}" class="wdthpercent77 required" id="country" name="country[]">
								<?php foreach($countryArray as $country) { ?>							
									<option data="<?php echo $country['id'];?>" value="<?php echo $country['id'];?>-0"><?php echo ucwords($country['name']);?></option>
								<?php } ?>							
							</select>
							<input type="hidden" id="countryinitial" value="1" />
							<input type="hidden" id="stateinitial" value="6" />
							<input type="hidden" id="districtinitial" value="143" />
							<input type="hidden" id="tehsilinitial" value="2690" />
							<input type="hidden" id="villageinitial" value="119502" />
							<input type="hidden" id="stateinitialtext" value="state" />
							<input type="hidden" id="districtinitialtext" value="district" />
							<input type="hidden" id="tehsilinitialtext" value="tehsil" />
							<input type="hidden" id="villageinitialtext" value="village" />
							<input type="hidden" id="uncommonstringid" value="" />
						<?php } ?>			
					</div>
				</div>
				<div class="clear pB10"></div>

				<div class="wdthpercent100 pT10 pB10" id="state">
				</div>
				<div class="clear pB10"></div>

				<div class="wdthpercent100 pT10 pB10" id="district">
				</div>
				<div class="clear pB10"></div>

				<div class="wdthpercent100 pT10 pB10" id="tehsil">
				</div>
				<div class="clear pB10"></div>

				<div class="wdthpercent100 pT10 pB10" id="village">
				</div>
				<div class="clear pB10"></div>

				<div class="wdthpercent100 pT10 pB10">
					<div class="leftcontent">&nbsp;</div>
					<div class="rightcontent">
						<input type="hidden" value="addlocation" name="submitaddprojectlocation">
						<input type="hidden" value="<?php echo $project_id;?>" name="project_id">
						<input type="submit" id="submitid" onclick="javascript:ShowSubmitTextGlobal('submitid','reset','add-project-location-form');" class="button" name="search" value="Submit" />
					</div>
				</div>
				<div class="clear"></div>

				<script type="text/javascript">jQuery(document).ready(function(){functionselectCountryProjectLocation();});	</script>

				</table>

			</form>

		</div>

	</div>

</div>

<!-- FOOTER -->
<?php include_once $basedir."/include/frontFooter.php"; ?>
<!-- /FOOTER -->