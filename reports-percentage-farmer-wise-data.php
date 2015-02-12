<?php
/******************************************
* @Created on APL 20, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
*******************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

checkSession(false,2);
checkDashboard($dashbordType);

$userStr = '';

if(defined('IS_PROJECT_ID')){
	$project_id = (defined('IS_PROJECT_ID'))?IS_PROJECT_ID:'';
	$userStr    = $projectObj->getprojectUsers($project_id,2);	
}
if(isset($_POST['searchfarmerwise']) && $_POST['searchfarmerwise']=='searchfarmerwise') {
	$_SESSION['joiningArray']  = $_POST;
	$joiningData               = $analysisObj->analysisFarmerWiseResult($userStr);
	$_SESSION['joiningData']   = $joiningData;
}
?>
<div class="container">

	<h1 class="title">
		Analysis Report	<div class="right"><a href="javascript:;" onclick="javascript: window.history.go(-1);">Back</a></div>
	</h1>

	<div class="entry">

		<div class="wdthpercent100 pL20">
			
			<?php if(!empty($_SESSION['joiningData'])){?>
					
					<div class="pT10">

						<div class="left"><h3 class="">Search Records</h3></div>

						<div class="right pR40">				

							<ul class="submenu">

								<!-- DOWNLOAD ------>
								<!-- <li id="download_link" class="">						
									<a href="<?php echo URL_SITE;?>/download-farmer-wise.php?type=csv">CSV</a>	
								</li>	 -->

								<li id="download_link" class="">						
									<a href="<?php echo URL_SITE;?>/download-farmer-wise.php?type=excel">EXCEL</a>	
								</li>
								<!-- /DOWNLOAD ------->

								<!-- PRINT PREVIEW -->
								<li id="print_link" class="">	
									 <div id="aside">
										<a href="javascript:;" onclick="window.print();">Print</a>
									 </div>
								</li>
								<!-- /PRINT PREVIEW -->

							</ul>
						</div>
					</div>

					<div class="pT10">
						<table class="data-table">	

							<?php if(!empty($_SESSION['joiningData'])){?>

								<?php foreach($_SESSION['joiningData'] as $keymobile => $kisanValueAlloneAll){ ?>										
										
										<tr>
											<th colspan="3">											
												<h3>Mobile Number : <?php echo $keymobile;?></h3>
											</th>
											<?php $farmerData = $adminObj->SelectFarmerDetail($keymobile);
											//echo '<pre>';print_r($farmerData);echo '</pre>';
											if(!empty($farmerData)){?>
											<th colspan="4">
												<?php if(isset($farmerData['pfirstname'])){echo stripslashes($farmerData['pfirstname']);}?>&nbsp;<?php if(isset($farmerData['plastname'])){echo trim(stripslashes($farmerData['plastname']));}?>
												<?php if(isset($farmerData['gender']) && $farmerData['gender']=='M' ){echo ', S/o ';} else { echo ', D/o ';}?>
												<?php if(!empty($farmerData['pfathername'])){
													echo stripslashes($farmerData['pfathername']);
												} else if(!empty($farmerData['sfathername'])){
													echo stripslashes($farmerData['sfathername']);
												} else {
													echo '----';
												}?>
											</th>
											<th colspan="11">											
												<?php if(isset($farmerData['village'])){echo stripslashes($farmerData['village']);}?>
												<?php if(isset($farmerData['district'])){echo ', '.stripslashes($farmerData['district']);}?>
												<?php if(isset($farmerData['state'])){echo ', '.stripslashes($farmerData['state']);}?>
											</th>
											<?php } ?>
										</tr>									    

										<?php foreach($kisanValueAlloneAll as $keyStatus => $kisanValueAll){?>

										<tr>
											<th colspan="17">
												<h4>Status: <?php echo $keyStatus;?></h4>
											</th>
										</tr>							

										<tr>
											<?php
											if(isset($kisanValueAll[0])){
												foreach($kisanValueAll[0] as $keyField => $fieldValue){?>
													<th>
														<?php echo str_replace("_"," ",$keyField);?>
													</th>
												<?php } ?>
											<?php } ?>
										</tr>										

										<tbody>
											<?php foreach($kisanValueAll as $resultkey => $resultTD){?>

												<tr>
													<?php foreach($resultTD as $tdkey => $resultTDvalue){?>

														<td class="analysis" align="left"><?php echo $resultTDvalue;?></td>

													<?php } ?>

												</tr>

											<?php } ?>	
										<tbody>

									<?php } ?>

								<?php } ?>

							<?php } ?>

						</table>

					</div>
				<?php } else {?>
						<h3 class="pT10 pB10 pL10">Search Records</h3>
						<div class="pT10 pB10 pL10">No result found</div>
				<?php } ?>					

			</div>		
	  </div>

</div>

<!-- FOOTER -->
<?php include_once $basedir."/include/frontFooter.php"; ?>
<!-- /FOOTER -->