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

$userStr = '';

if(isset($_SESSION['session_user_data']) && !is_numeric($_SESSION['session_user_data']['user_type'])){
	//ACCORDING TO CONTENT SETTING
	$user_type_var = explode('-', $_SESSION['session_user_data']['user_type']);
	if(!empty($user_type_var[1]))
	$projectData   = $langObj->functionGetSetting($tablename='projects', $dmlType='1', $id=$user_type_var[1]);
	$userStr = implode(',',explode(';', $projectData['assigned_users']));
}

if(isset($_POST['search']) || isset($_SESSION['joiningFarmerArray'])) {
	$_SESSION['joiningFarmerArray'] = $_POST;
	$resultData              = $analysisObj->analysisFarmerJoiningResult($userStr);
	$_SESSION['resultData']  = $resultData;
}
?>
<div class="container">

	<h1 class="title">
		Analysis Report		
		<div class="right"><a href="javascript:;" onclick="javascript: window.history.go(-1);">Back</a></div>
	</h1>

	<div class="entry">

		<div class="wdthpercent100 pL20">
			
			<?php if(!empty($_SESSION['resultData'][1])){?>
					
					<div class="pT10">

						<div class="left"><h3 class="">Search Records</h3></div>

						<div class="right pR40">				

							<ul class="submenu">

								<!-- DOWNLOAD ------>
								<li id="download_link" class="">						
									<a href="<?php echo URL_SITE;?>/download.php?type=csv">CSV</a>		
								</li>	

								<li id="download_link" class="">						
									<a href="<?php echo URL_SITE;?>/download.php?type=excel">EXCEL</a>	
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

							<?php if(!empty($_SESSION['resultData'])){?>

								<thead>
									<tr>
										<?php $headerData = $_SESSION['resultData'][1];
										foreach($headerData as $keyField => $fieldValue){ ?>
											<th>
												<?php echo str_replace("_"," ",$keyField);?>
											</th>
										<?php } ?>
									</tr>
								</thead>

								<tbody>
										<?php foreach($_SESSION['resultData'] as $resultkey => $resultTD){?>

											<tr>
												<?php foreach($resultTD as $tdkey => $resultTDvalue){?>

													<td class="analysis" align="left"><?php echo $resultTDvalue;?></td>

												<?php } ?>

											</tr>

										<?php } ?>				

								<tbody>

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