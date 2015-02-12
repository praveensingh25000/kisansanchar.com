<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
*******************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$contactmsg = $db->getUniversalRowAll($table_name='contact_us');
?>
<div class="container">

	<h1 class="title"><?php echo $langVariables['form_var']['contact_heading']?></h1>

	<div class="entry bknone">

		<h4 class="pT10"><?php echo $langVariables['form_var']['contact_request']?></h4>

		<div class="wdthpercent100">

			<div class="wdthpercent70 left pT30">
				<form name="contactus" id="contactus" method="post" action="action.php" enctype="multipart/form-data">
					<div class="wdthpercent100 left pT10">
						<div class="wdthpercent30 left">
							<?php echo $langVariables['form_var']['contact_name']?>
						</div>
						<div class="wdthpercent60 left">
							<input placeholder="Enter your Name" name="name" type="text" value="<?php if(isset($contactmsg['contact_name'])){ echo stripslashes($contactmsg['contact_name']); }?>" class="wdthpercent90 required" id="contact_name" />
						</div>
					<div class="clear"></div>
					</div>

					<div class="wdthpercent100 left pT10">
						<div class="wdthpercent30 left">
							<?php echo $langVariables['form_var']['email']?>
						</div>
						<div class="wdthpercent60 left">
							<input placeholder="Enter your Email ID" name="email" type="text" value="<?php if(isset($contactmsg['email'])){ echo stripslashes($contactmsg['email']); }?>" class="wdthpercent90 required" id="email" />
						</div>
					<div class="clear"></div>
					</div>

					<div class="wdthpercent100 left pT10">
						<div class="wdthpercent30 left">
							<?php echo $langVariables['form_var']['phone']?>
						</div>
						<div class="wdthpercent60 left">
							<input placeholder="Enter your Contact Number" name="phone" maxlength="10" type="text" value="<?php if(isset($contactmsg['phone'])){ echo stripslashes($contactmsg['phone']); }?>" class="wdthpercent90 digits required" id="phone" />
						</div>
					<div class="clear pB10"></div>
					</div>

					<div class="wdthpercent100 pT10 pB10">
						<div class="wdthpercent30 left">Upload Doc</div>
						<div class="wdthpercent60 left">
						   <input type="file" id="uploaded_file" name="uploaded_file" class="wdthpercent90" />
						</div>					
					<div class="clear"></div>
					</div>

					<div class="wdthpercent100 left pT10">
						<div class="wdthpercent30 left">
							<?php echo $langVariables['form_var']['contact_sub']?>
						</div>
						<div class="wdthpercent60 left">
							<input placeholder="Enter Subject" name="subject" type="text" value="<?php if(isset($contactmsg['contact_sub'])){ echo stripslashes($contactmsg['contact_sub']); }?>" class="wdthpercent90 required" id="contact_sub" />
						</div>
					<div class="clear"></div>
					</div>

					<div class="wdthpercent100 left pT10">
						<div class="wdthpercent30 left">
							<?php echo $langVariables['form_var']['contact_msg']?>
						</div>
						<script type="text/javascript">
							tinyMCE.init({
								// General options
								theme    :	"advanced",
								mode     :	"exact",
								elements :  "message",
								relative_urls : false,
								remove_script_host : false,
								inline_styles : true,
								plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

								// Theme options
								theme_advanced_toolbar_location : "top",
								theme_advanced_toolbar_align : "left",
								theme_advanced_statusbar_location : "bottom",
								theme_advanced_resizing : true,

								// Example content CSS (should be your site CSS)
								content_css : "",

								// Drop lists for link/image/media/template dialogs
								template_external_list_url : "lists/template_list.js",
								external_link_list_url : "lists/link_list.js",
								external_image_list_url : "lists/image_list.js",
								media_external_list_url : "lists/media_list.js",

								// Style formats
								style_formats : [
									{title : 'Bold text', inline : 'b'},
									{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
									{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
									{title : 'Example 1', inline : 'span', classes : 'example1'},
									{title : 'Example 2', inline : 'span', classes : 'example2'},
									{title : 'Table styles'},
									{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
								],
								relative_urls: false,
								convert_urls: false,
								onchange_callback: function (editor){
									tinyMCE.triggerSave();
									$("#message").valid();
								}
							});
						</script>
						<div class="wdthpercent60 left">
							<textarea rows="4" placeholder="Enter Message" name="message" id="message" value="<?php if(isset($contactmsg['contact_msg'])){ echo stripslashes($contactmsg['contact_msg']); }?>" class="wdthpercent90 required" /></textarea>
						</div>
					<div class="clear"></div>
					</div>
					
					<div class="wdthpercent100 left pT10">
						<div class="wdthpercent30 left">
							<?php echo $langVariables['form_var']['captcha'];?>		
						</div>
						<div class="wdthpercent60 left">
							<span id="captcha_code">
								<?php require_once($DOC_ROOT.'captcha_code_file.php'); ?>
							</span>	
						</div>
					</div>
					<div class="clear"></div>

					<div class="wdthpercent100 left pT10">
						<div class="wdthpercent30 left">&nbsp;</div>
						<div class="wdthpercent60 left">
							<span class="">
								<input type="hidden" value="1" name="content_type">
								<input class="button" type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submit">
								<input type="hidden" value="Submit" name="submitcontactdetails">
							</span>
							<span class="pL40">
								<input class="button" type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
							</span>
						</div>
					<div class="clear"></div>
					</div>
				</form>
			</div>

			<div class="wdthpercent30 left pT30">
				<div class="wdthpercent100 left pT10">
					<h1 class="title left">
						<?php echo FLAT_DETAIL_FLAT_DETAIL;?>
					</h1>
					<div class="office pT10 pB10 left"><?php echo FLAT_DETAIL;?></div>
				</div>
				<div class="wdthpercent100 left pT10">
					<h1 class="title left">
						<?php echo WORK_OFFICE_WORK_OFFICE;?>
					</h1>
					<div class="office pT10 pB10 left"><?php echo WORK_OFFICE;?></div>
				</div>
			</div>
			
		</div>

	</div>
</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>