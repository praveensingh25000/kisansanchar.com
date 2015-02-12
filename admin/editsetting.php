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

if(!isset($_GET['groupid'])){
	header("location:viewsetting.php");
	exit;	
}

$groupid = $_GET['groupid'];
$settingArray  = $langObj->functionGetSetting($tablename='site_settings', $dmlType='2',$groupid);
$settingDetail = $db->getUniversalFormattedArray($settingArray,$key='groupid');

//echo '<pre>';print_r($settingDetail);echo '</pre>';
?>
<!-- containerCenter -->
<section class="containerCenter">
	<div class="containercentercnt">
		<h2 class="heading"><?php echo $langVariables['setting']['setting_head']?></h2>
		<div class="clear pB10"></div>		
		<?php if(!empty($settingDetail)){?>
		      <?php foreach($settingDetail as $groupid => $settingAll){
					 $groupArray  = $langObj->functionGetSetting($tablename='site_settings', $dmlType='2',$groupid);
			         ?>						 	
					 <div class="wdthpercent100 register">						
						 <h2 class=""><?php if(isset($groupArray[0]['group'])){ echo $groupArray[0]['group'];}?></h2>
						 <div class="clear pB10"></div>						 
						 <?php foreach($settingAll as $setting){?>						 
							<form action="" method="post" id="editformsettinggroup<?php echo $setting['id']?>" name="editformsettinggroup">	
							
							<div class="wdthpercent100 pT10 pB10">
								<div class="wdthpercent20 left"><?php echo $langVariables['setting']['setting_text']?></div>
								<div class="wdthpercent80 left">
								   <input placeholder="enter text" type="text" value="<?php echo $setting['text']?>" id="text" name="text" class="wdthpercent40 required"/><br>
								</div>
							</div>
							<div class="clear"></div>

							<div class="wdthpercent100 pT10 pB10">
								<div class="wdthpercent20 left"><?php echo $langVariables['setting']['setting_name']?></div>
								<div class="wdthpercent80 left">
								   <input disabled="true" placeholder="enter name" type="text" id="name" name="name" class="wdthpercent40 required" value="<?php echo $setting['name']?>" /><br>
								</div>
							</div>
							<div class="clear"></div>

							<script type="text/javascript">
								tinyMCE.init({
									// General options
									theme :		"advanced",
									mode:		"exact",
									elements :  "value<?php echo $setting['id']?>",
									relative_urls : false,
									remove_script_host : false,
									inline_styles : true,
									plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

									// Theme options
									theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
									theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
									theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
									theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
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
										$("#value<?php echo $setting['id']?>").valid();
									}
								});
							</script>
							
							<?php if($setting['name']=='address_1' || $setting['name']=='address_2' || $setting['name']=='support_text' || $setting['name']=='work_office' || $setting['name']=='work_office'){?>

							<div class="wdthpercent100 pT10 pB10">
								<div class="wdthpercent20 left"><?php echo $langVariables['setting']['setting_value']?></div>
								<div class="wdthpercent80 left">
								   <textarea placeholder="enter value" type="text" id="value<?php echo $setting['id']?>" name="value" class="wdthpercent40 required" /><?php echo $setting['value']?></textarea><br>
								</div>
							</div>
							<div class="clear"></div>		
							
							<?php } else {?>

							<div class="wdthpercent100 pT10 pB10">
								<div class="wdthpercent20 left"><?php echo $langVariables['setting']['setting_value']?></div>
								<div class="wdthpercent80 left">
								   <textarea placeholder="enter value" type="text" id="value" name="value" class="wdthpercent40 required" /><?php echo $setting['value']?></textarea><br>
								    <?php if($setting['name']=='site_status'){?><span class="red font12">Enter 'live' to activate the Website OR 'test' to deactivate the Website</span><?php } ?>
								</div>
							</div>
							<div class="clear"></div>	

							<?php } ?>

							<div class="wdthpercent100 pT10 pB10">
								<div class="wdthpercent20 left">&nbsp;</div>
								<div class="wdthpercent80 left">
									<span class="">
									     <input type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="editsitesetting<?php echo $setting['id']?>">
									     <input type="hidden" name="id" value="<?php echo $setting['id']?>">
									</span>	
								</div>
							</div>
							<div class="clear"></div>
							
							<script type="text/javascript">
							jQuery(document).ready(function(){
								jQuery("#editformsettinggroup<?php echo $setting['id']?>").validate();
								jQuery("#editformsettinggroup<?php echo $setting['id']?>").submit(function(e){	
									e.preventDefault();		
									var pass_msg = jQuery("#editformsettinggroup<?php echo $setting['id']?>").valid();		
									//some validations
									if(pass_msg == false){
										return false;
									} else {	
										jQuery(".msgsuccess").hide();
										jQuery("#msgsuccess").html('');
										jQuery.ajax({
											type: "POST",
											data: jQuery("#editformsettinggroup<?php echo $setting['id']?>").serialize(),
											url : URL_SITE+"/admin/adminActionAjax.php?settingsaved=1",
											success: function(msg) {
												jQuery(".msgsuccess").show();
												jQuery("#msgsuccess").html(msg).show();
											}							
										});	
									}
								});	 
							});
							</script>
							</form>														
						 <?php } ?>
					 </div>
					 <div class="clear pB10"></div>	
			  <?php } ?>
		<?php } ?>   		
	</div>
</section>
<!-- /Containercenter -->
<?php include_once $basedir."/include/adminFooter.php"; ?>