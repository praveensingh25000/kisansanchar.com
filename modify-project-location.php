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

$project_id          = (defined('IS_PROJECT_ID'))?trim(IS_PROJECT_ID):'';
$projectlocationData = $projectObj->getProjectLocation($tablename='projects_locations',$project_id);
//echo '<pre>';print_r($locationData);echo '</pre>';
?>

<script> 
$(document).ready(function(){
  $("#flip").click(function(){
    $("#panel").slideToggle("1000");
  });
});
</script>
<style type="text/css">
#panel
{
display:none;
}
</style>

<div class="container">

	<h1 class="title">Modify Project Location<span class="right"><a href="<?php echo URL_SITE;?>/project-profile.php?tab=pls">Back</a></span></h1>

	<div class="entry">

		<div class="locationnav pT5 pB5 pL5 font15 fontbld" id="flip">click here to view/hide villages</div>

		<div class="wdthpercent100 pT10" id="panel">
			
			<?php if(!empty($projectlocationData)){
				foreach($projectlocationData as $country => $countryDataAll){
					foreach($countryDataAll as $state => $stateDataAll){
						foreach($stateDataAll as $district => $districtDataAll){
							foreach($districtDataAll as $tehsil => $tehsilDataAll){?>
								
								<div class="locationnav pT5 pB5 pL5 font15 fontbld">
									<span><?php echo $country;?></span>&nbsp;>>&nbsp;
									<span><?php echo $state;?></span>&nbsp;>>&nbsp;
									<span><?php echo $district;?></span>&nbsp;>>&nbsp;
									<span><?php echo $tehsil;?></span>
								</div>

								<br class="clear" />

								<div class="locationtab pT10"><!---->										
									<div class="wdthpercent30 left">
										VILLAGE NAME
									</div>
									<div class="wdthpercent60 left">
										<a class="right pR30" href="javascript:;">ACTION</a>
									</div>
								<div class="clear"></div>
								</div>

								<?php foreach($tehsilDataAll as $village => $villagename){?>
									<div class="setting pT10">										
										<div class="wdthpercent30 left">
											<?php echo $villagename;?>
										</div>
										<div class="wdthpercent60 left">
											<a class="right" href="javascript:;">Inactive | Remove</a>
										</div>
									<div class="clear"></div>
									</div>
									<?php if(isset($tehsilDataAll) && count($tehsilDataAll)>1){echo '<br class="clear" />';}?>
								<?php } ?> 

							<?php } ?>
							
						<?php } ?> 

					<?php } ?> 

				<?php } ?> 

			<?php } ?> 

			
		</div>

	</div>

</div>

<!-- FOOTER -->
<?php include_once $basedir."/include/frontFooter.php"; ?>
<!-- /FOOTER -->