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

$project_id = (defined('IS_PROJECT_ID'))?IS_PROJECT_ID:'';

if(isset($_POST['project_content_type'])){
	$pageDivType = $_SESSION['project_content_type']=$_POST['project_content_type'];
}else if(isset($_SESSION['project_content_type'])){
	$pageDivType = $_SESSION['project_content_type'];
}else if(isset($_GET['tab'])){
	if($_GET['tab'] == '1'){ 
		$pageDivType = $_SESSION['project_content_type'] = 'add_project_user_type_farmers';
	}else{ 
		$pageDivType = $_SESSION['project_content_type'] = 'add_project_user_type_scientists';
	}
}
?>
<div class="container">

	<h1 class="title">Add Project Detail<span class="right"><a href="<?php echo URL_SITE;?>/project-profile.php?tab=pus">Back</a></span></h1>

	<div class="entry">

		<div class="pL10 pT10">

			<div id="" class="pT5 pB5">

				<table class="wdthpercent100">
				
					<tr>
						<td class="wdthpercent50">
							Select Beneficiary Type
						</td>
						<td class="wdthpercent50">
							<form id="select_project_content_type" method="post" action="">
								<select onchange="javascript: FunctionSelectContentType('select_project_content_type');" class="wdthpercent90" id="project_content_type" name="project_content_type">
									<option value="">Select Beneficiary Type</option>
									<option <?php if(isset($_SESSION['project_content_type']) && $_SESSION['project_content_type']=='add_project_user_type_scientists'){ echo 'selected="selected"';}?> value="add_project_user_type_scientists">Add Project Scientist</option>
									<option <?php if(isset($_SESSION['project_content_type']) && $_SESSION['project_content_type']=='add_project_user_type_farmers'){ echo 'selected="selected"';}?> value="add_project_user_type_farmers">Add Project Farmer</option>
								</select>
							</form>
						</td>					
					</tr>

					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>

				</table>
			</div>

			<!-- add_project_user_type_scientists -->
			<?php if(isset($pageDivType) && $pageDivType=='add_project_user_type_scientists'){ ?>
				<?php require_once($DOC_ROOT.'add-project-user-scientists.php');?>
			<?php } ?>
			<!-- /add_project_user_type_scientists -->

			<!-- add_project_user_type_farmers -->
			<?php if(isset($pageDivType) && $pageDivType=='add_project_user_type_farmers'){ ?>
				<?php require_once($DOC_ROOT.'add-project-user-farmers.php');?>
			<?php } ?>
			<!-- /add_project_user_type_farmers -->

		</div>

	</div>

</div>

<!-- FOOTER -->
<?php include_once $basedir."/include/frontFooter.php"; ?>
<!-- /FOOTER -->