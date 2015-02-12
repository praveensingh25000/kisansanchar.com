<?php
/******************************************
* @Created on June 22, 2014
* @Package: Kisan Sanchar
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
*******************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

if(isset($_GET['action'])){
	if($_GET['action'] == 'farmer'){
		$contentDetail = array('uploaded_file' => 'Kisan_Sanchar_Membership_Form_Revised on 22_6_2014.pdf');
	}
	if(!empty($contentDetail)){
		downloadContent($contentDetail,'doc');
		exit;
	} else {
		header('location: cdownload.php');
	}
}
?>
<div class="container">

	<h1 class="title">Download</h1>

	<div class="entry pL10 pR10">		
		<div class="pT10 pB10 download">			
			<h2>
				<a id="download_first_click" class="plus" href="javascript:;"><span class="membership">Membership Form</span></a>
			</h2>			
			<ul id="download_first_div" style="display:none;">
				<li>
					<a href="?action=farmer">For Farmers</a>
				</li>
			</ul>
		</div>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#download_first_div').show();
			jQuery("#download_first_click").click(function(){
				jQuery('#download_first_div').toggle();
				if(jQuery('#download_first_click').hasClass("plus")){
					jQuery('#download_first_click').removeClass("plus");
					jQuery('#download_first_click').addClass("minus");
				}else{
					jQuery('#download_first_click').removeClass("minus");
					jQuery('#download_first_click').addClass("plus");
				}
			});
		});
		</script>

	</div>

</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>