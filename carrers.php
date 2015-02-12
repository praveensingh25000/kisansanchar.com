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

	<h1 class="title">Volunteers & Interns</h1>

	<div class="entry bknone">
		
		<p class="pT10" style="margin:0px;">KISAN SANCHAR  invites Applications for Volunteers/ Interns from multi-disciplinary fields throughout the year.</p>

		<p class="pT10" style="margin:0px;">The key fields/ expertise required under Volunteership Programme are as follow:</p>

		<ul>
			<li>Agricultre Extension</li>
			<li>Agronomy</li>
			<li>Meteorology</li>
			<li>Plant Protection and Other disiciplines of agriculture</li>
			<li>MBA</li>
			<li>Rural Development</li>
			<li>Community Based Sustainable Livelihood Generation and Community Participatory Enterprise Development</li>
			<li>Project Management/Implementation/ Monitoring & Evaluation</li>
			<li>Information Management</li>
			<li>Information Technology</li>
			<li>Climate Change</li>
			<li>Disaster Management</li>
			<li>Natural Resource Management</li>
			<li>Community Based Tourism</li>
			<li>Gender Equity and Women Empowerment</li>
			<li>Dairy Farming</li>				
			<li>Company Secretary</li>
			<li>Community Radio</li>
			<li>Performing Arts </li>
			
		</ul>

		<h4>Procedure to Apply:</h4>

		<ul>
			<li>The applicants are required to contact Kisan Sanchar at least one Month before the commencement of the Volunteership Programme through e-mail mentioning their interest and expertise.</li>
		</ul>	

		<h4>Selection Procedure:</h4>

		<ul>
			<li>The Selection-Panel of Kisan Sanchar will short-list the desirable and potential candidates based on organisation's requirements.</li>
			<li>The selected candidates will have to acknowledge the receipt and communicate their availability through e-mail/ telephonically within Seven days from the receipt.</li>
			<li><b>Note:</b> The selected Candidates are required to report as communicated to them, failing which, their eligibility for Volunteership Programme may be cancelled.</li>
		</ul>	 

		<h1 style="padding-bottom:0px;">Apply Here</h1><hr>

		<div class="wdthpercent100">

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
						<input placeholder="Enter your Contact Number" name="phone" type="text" maxlength="10" value="<?php if(isset($contactmsg['phone'])){ echo stripslashes($contactmsg['phone']); }?>" class="wdthpercent90 digits required" id="phone" />
					</div>
				<div class="clear pB10"></div>
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
						<textarea rows="4" placeholder="Enter Message" name="message" type="text" value="<?php if(isset($contactmsg['contact_msg'])){ echo stripslashes($contactmsg['contact_msg']); }?>" class="wdthpercent90 required" id="message" /></textarea>
					</div>
				<div class="clear pB10"></div>
				</div>				

				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent30 left">Upload CV</div>
					<div class="wdthpercent60 left">
					   <input accept="DOC|PDF" type="file" id="uploaded_file" name="uploaded_file" class="required wdthpercent90" />
					</div>
				</div>
				<div class="clear"></div>
				
				<div class="wdthpercent100 left pT10">
					<div class="wdthpercent30 left">&nbsp;</div>
					<div class="wdthpercent60 left">
						<span class="">
							<input type="hidden" value="2" name="content_type">
							<input class="button" type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset">
							<input type="hidden" value="Submit" name="submitcarrerdetails">
						</span>						
						<span class="pL40"><input class="button" type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submit"></span>	
					</div>
				<div class="clear"></div>
				</div>
			</form>
			
		</div>
		<br class="clear"/>

	</div>

</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>