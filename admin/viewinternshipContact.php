<?php
/******************************************
* @Modified on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);

$contactusArray  = $db->getUniversalRowAll($table_name='contact_us',$otherfields=' and `content_type`= "2" order by status ');
$total_contact   = count($contactusArray);
$contactObj      = new PS_PaginationArray($contactusArray,10,1);
$contactusDetail = $contactObj->paginate();

if(isset($_POST['download'])){
	$contentid  = $_POST['contentid'];
	$contentDetail = $langObj->functionGetSetting($tablename='contact_us', $dmlType='1', $contentid);
	
	if(!empty($contentDetail)){
		downloadContent($contentDetail,'doc');
		exit;
	} else {
		$_SESSION['error_msg'] = 12;
		header('location: viewinternshipContact.php');
	}
}

//echo '<pre>';print_r($contactusDetail);echo '</pre>';
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading">
			Internship Contact Users <?php if(isset($total_contact)) { echo '( '.$total_contact.' )';} ?>
		</h2>
		<div class="clear pB10"></div>

		<div id="paginationcontent" class="entry">

			<?php if(!empty($contactusDetail)){?>

				<?php foreach($contactusDetail as $key => $contactus){?>

					<div class="msgdiscriptiontxt" id="msgdiscriptiontxt<?php echo $contactus['id'];?>">
						
						<div class="msgmain fullcontent">
							<div class="msgmain1">
								<div class="msgmain1L">
									<span class="wdthpercent20 left "><a href=""><?php echo ucwords($contactus['name']);?></a> </span>							
									<span class="right pR10"><?php echo show_date($contactus['date']);?></span>
								</div>
								<br class="clear">
							</div>
							<br class="clear">

							<!--Photo Gallery-->
							<div class="photomsgshow">

								<?php if(!empty($contactus['subject'])){?> 
									<span class="fontbld">Subject:</span> 
									<?php echo stripslashes(ucfirst($contactus['subject']));?> 
								<?php } ?>
								<?php if(!empty($contactus['message'])){?> 
									<p class="pT10 fontbld pB10">Message:<p>
									<span class="white pT5 pB5 pL5 pR5"><?php echo stripslashes(ucfirst($contactus['message']));?></span>
								<?php } ?>	

								<div class="msgresultbuttonleft">
									<ul>
										<li id="delete_contact_div_<?php echo $contactus['id'];?>">
											<a onclick="javascript: functionDeleteContentUniversal('<?php echo $contactus['id'];?>','Do you really want to delete this content','msgdiscriptiontxt');" title="delete" href="javascript:;">Trash</a>	
										</li>
										<!-- <li>|</li>
										<li>
											<a href="javascript:;">Reply</a>
										</li> -->
									</ul>
								</div>

								<?php if(!empty($contactus['uploaded_file'])){?> 
								<div class="msgresultbuttonright">
									<ul>
										<li id="delete_contact_div_<?php echo $contactus['id'];?>">
											<form method="post" action="">
												<input name="download" type="submit" value="Download CV">
												<input name="contentid" type="hidden" value="<?php echo $contactus['id'];?>">
											</form>	
										</li>
									</ul>
								</div>
								<?php } ?>
							</div>
						</div>
						<script type="text/javascript">
						jQuery(document).ready(function(){									
							jQuery.ajax({
								type: "POST",
								data: "content_id="+"<?php echo $contactus['id'];?>",
								url : URL_SITE+"/admin/actionAjax.php?update_contact_count=1",	
								success: function(msg){ return true; }							
							});											
						});
						</script>
					</div>
				<?php } ?>

			<?php } else { ?>
				<div class="msgdiscriptiontxt">
					<div class="photomsgshow txtcenter pT30">No user for Internship yet.</div>			
				</div>
			<?php } ?>	
			
			<br class="clear">
			
			<?php if(isset($total_contact) && $total_contact >10){?>	
			<!-- Pagination ----------->                      
			<div class="msgdiscriptiontxt fullcontent">
				<div class="txtcenter pR20 pagination">
					<?php echo $contactObj->renderFullNav();  ?>
				</div>
			</div>
			<!-- /Pagination ----------->
			<?php } ?>

		</div>

    </div>

</section>
<!-- /Containercenter -->


<?php include_once $basedir."/include/adminFooter.php"; ?>