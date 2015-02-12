function windowLoader(){
	$(window).bind('beforeunload', function() {				
		scrollTop();
		//headerLoaderMessage('Loading...');	
		jQuery('#container').addClass("fadeLoader");			
	});
}

function succuss(message){		
	jQuery.blockUI({ 
		message: (message), 
		fadeIn: 700, 
		fadeOut: 700, 
		timeout: 6000, 
		showOverlay: false, 
		centerY: false, 
		css: {
			position:'absolute',border: '1px solid #C1D779',width:'100%',top:'0',left:'-12px',padding:'5px',backgroundColor:'#EFFEB9',font:'25px', color: '#70A300' 
		} 
	}); 
}

function error(message){		
	jQuery.blockUI({ 
		message: (message), 
		fadeIn: 700, 
		fadeOut: 700, 
		timeout: 6000, 
		showOverlay: false, 
		centerY: false, 
		css: {
			position:'absolute',border: '1px solid #C1D779',width:'100%',top:'0',left:'-12px',padding:'5px',backgroundColor:'#FAD5CF',font:'25px', color: 'red'
		} 
	}); 
}
function alertmsg(message){		
	jQuery.blockUI({ 
		message: (message), 
		fadeIn: 700, 
		fadeOut: 700, 
		timeout: 6000, 
		showOverlay: false, 
		centerY: false, 
		css: {

			position:'absolute',border: '1px solid #C1D779',width:'100%',top:'0',left:'-12px',padding:'5px',backgroundColor:'#FFE9AD',font:'25px', color: '#70A300'
		} 
	}); 
}

function headerLoaderMessage(message){		
	jQuery.blockUI({ 
		message: (message), 
		fadeIn: 700, 
		showOverlay: false, 
		centerY: false, 
		css: {
			position:'absolute',border: '1px solid #C1D779',width:'100%',top:'0',left:'-12px',padding:'5px',backgroundColor:'#EFFEB9',font:'25px', color: '#70A300'
		} 
	}); 
}

function loader_show(){
	//jQuery.blockUI({
		//message:'<span class="processing"></span>', 
		//css: {
			//position:'fixed',border: 'none',width:'34%',top:'45%',left:'31%',padding:'1px',backgroundColor:'none','-webkit-border-radius':'10px','-moz-border-radius': '10px', opacity:'1.0',font:'30px', color: '#000' 
		//}
	//});
}
function loader_unshow(){
	jQuery.unblockUI(); 
}

function blockUI_object(msgobj){
	jQuery.blockUI({ 
		message: msgobj, 
		css: {
			width: '511px', border: '5px solid #C1D779', padding:'0px', height:'auto', overflow:'hidden', top: '30%', left:'30%' 
		} 
	});
}

function blockUI_request_msg(msgobj){
	jQuery.blockUI({ 
		message: msgobj, 
		css: {
			width: '67%', border: '5px solid #C1D779', padding:'0px', height:'auto', overflow:'hidden', top: '30%', left:'15%' 
		} 
	});
}

function blockUI_divid(divid){
	jQuery.blockUI({
		message: jQuery('#'+divid+''),
		css: { 
			position:'fixed',border: '5px solid #70A300',width:'34%',top:'40%',left:'31%',padding:'10px',backgroundColor:'#FFF','-webkit-border-radius':'10px','-moz-border-radius': '10px', opacity:'0.8',font:'30px', color: '#000' 
		} 
	});
}

function showAttributes(div,divid){	
	jQuery('.allGraph').hide();	
	if($('#'+divid+'').attr('checked')) {
		jQuery('#'+div+'').show();
	}
}

function delete_action(){
	if(confirm("This Action cannot be undone. Are you sure you want to perform this action?")){		 
		return true;
	}else{
		return false;
	}
}

function send_action(){
	if(confirm("Are you sure you want to perform this action?")){		 
		return true;
	}else{
		return false;
	}
}

function scrollTop(){
	$("html, body").animate({ scrollTop: 0 }, "slow");
}
function scrollBottom(){
	$("html, body").animate({ scrollTop: $(document).height() }, 1000);
}

function scrollToSelected(divid){
	$('html, body').animate({ scrollTop: $('#'+divid+'').position().top }, 1000);
}

function ShowSubmitTextGlobal(textid,cancelid,formid){
	jQuery('#'+formid+'').submit(function(e){
		var pass_msg = jQuery('#'+formid+'').valid();
		if(pass_msg == false){
			return false;
		} else {
			scrollTop();
			headerLoaderMessage('Loading...Wait');
			jQuery('#'+textid+'').attr({'type':'button'});
			jQuery('#'+textid+'').addClass('fadeLoader');
			jQuery('#'+textid+'').val('Please...Wait');
			jQuery('#'+cancelid+'').hide();
			return true;
		}
	});
}

jQuery(document).ready(function(){
	jQuery("#profile-login").hover(function(){		
		jQuery(".notification").remove();
	});
	jQuery("#profile-login").hover(function(){
		jQuery('#main-profile').show();
	},function(){
		jQuery('#main-profile').hide();
	});
});

function refreshCaptchaCode(){
	jQuery.ajax({
		type: "POST",
		data: "",
		url : URL_SITE+"/captcha_code_file.php",		
		success: function(msg){										
			jQuery("#captcha_code").html(msg);
		}							
	});	
}

jQuery(document).ready(function(){
	jQuery('#searchContent').keyup(function() { 
		if(jQuery(this).val() == ''){
			jQuery("#grid_view td.phone").parent().show();
			jQuery("#no_result").hide();		
		} else {
			var value=jQuery("#grid_view td.phone:contains('" + jQuery(this).val() + "')").html();
		
			if(typeof(value) =='undefined'){
				jQuery("#grid_view td.phone:not(:contains('" + jQuery(this).val() + "'))").parent().hide();
				jQuery('#no_result').show();				
			}else{
				jQuery("#grid_view td.phone:contains('" + jQuery(this).val() + "')").parent().show();
				jQuery("#grid_view td.phone:not(:contains('" + jQuery(this).val() + "'))").parent().hide();
				jQuery('#no_result').hide();		
			}
		}
	});

	jQuery('#searchContentCategory').keyup(function() { 
		if(jQuery(this).val() == ''){
			jQuery("#list_view td.category_name").parent().show();
			jQuery("#no_result").hide();		
		} else {
			var value=jQuery("#list_view td.category_name:contains('" + jQuery(this).val() + "')").html();
		
			if(typeof(value) =='undefined'){
				jQuery("#list_view td.category_name:not(:contains('" + jQuery(this).val() + "'))").parent().hide();
				jQuery('#no_result').show();				
			}else{
				jQuery("#list_view td.category_name:contains('" + jQuery(this).val() + "')").parent().show();
				jQuery("#list_view td.category_name:not(:contains('" + jQuery(this).val() + "'))").parent().hide();
				jQuery('#no_result').hide();		
			}
		}
	});
});

jQuery(document).ready(function(){
	jQuery('#click_on_all_users').click(function () {
		if(jQuery("#click_on_all_users").is(":checked")){
			jQuery('.ids').prop('checked', true);	
		} else {
			jQuery(".ids").removeAttr("checked");
		}
	});
});

function checkUsers(action){							
	var atLeastOneIsChecked = $('input[name="ids[]"]:checked').length > 0;	
	if(atLeastOneIsChecked){
		if(action == "delete" || action == "remove"){
			var confirmcheck = confirm("Are you sure you want to delete them");
			if(!confirmcheck){
				return false;
			}
		}
		return true;
	} else {
		alert("Please tick the checkboxes first");
	}
	return false;
}

function chckphone(){
	//var filter = /^[0-9]{3}-[0-9]{3}-[0-9]{4}$/;
	//var filter = /^[0-9]$/;
	//var number = $("#phone").val();							
	//var test_bool = filter.test(number);
	//if(test_bool==false){
	  //alert('Please enter a valid phone number');
	  //$("#phone").val('');
	 //return false; 
	 //}
	 //return true;
}

function formLoaderPHP(formid){
	//var valid_form_status = jQuery('#'+formid+'').valid();
	//if(valid_form_status){
		//loader_show();
		//return true;
	//}else {
		//return false;
	//}
}
function view_all(tablename,msgid,unique_div_id) {
	if(msgid > 0){
		jQuery("#loader"+unique_div_id).html('Loading....').show();
		jQuery.ajax({
			type: "POST",
			data: "tablename="+tablename+"&msgid="+msgid+"&unique_div_id="+unique_div_id+"&select_msg_body=1",
			url : URL_SITE+"/actionAjax.php",	
			success: function(msg){
			   jQuery("#loader"+unique_div_id).html('').hide();
			   jQuery("#full_message_discription"+unique_div_id).html(msg).show();
			   jQuery("#half_message_discription"+unique_div_id).hide();	
			}
		});
	} else {
		return false;
	}
}
function fun_message_unshow(contentid,unique_div_id){
	jQuery("#half_message_discription"+unique_div_id).show();						
	jQuery("#full_message_discription"+unique_div_id).hide();		
}

jQuery(document).ready(function(){
	jQuery("#message_type , #language_type , #day, #month, #year, #status").bind('change',function(){
		if(jQuery("#message_type").val()!='' || jQuery("#language_type").val()!='' || jQuery("#day").val()!='' || jQuery("#month").val()!='' || jQuery("#year").val()!=''){
			loader_show();
			jQuery("#selectLanguageTypeMessageTypeForm").submit();
		}
	});
});
function functionApproveDisaprove(tablename, content_id, content_type, unique_div_id, status, approvemessage){
	if(confirm(approvemessage)){	
		$("#broadcast_unbroadcast_loader_"+unique_div_id).addClass('cLoader').show();
		jQuery.ajax({
			type: "POST",
			data:'tablename='+tablename+'&unique_div_id='+unique_div_id+"&status="+status+"&content_id="+content_id+"&content_type="+content_type,
			url:URL_SITE+"/admin/actionAjax.php?approvedissaprove=1",
			success: function(msg){		
				scrollTop();
				$("#broadcast_unbroadcast_loader_"+unique_div_id).removeClass('cLoader').show();
				jQuery("#timeline_aprrove_dissaprove_div_"+unique_div_id).html(msg);
				succuss(msg);
			}					
		});
	} else {
		return false;
	}
}

function functionSchuduledApproveDisaprove(tablename, content_id, content_type, unique_div_id, status, approvemessage){
	if(confirm(approvemessage)){	
		$("#broadcast_unbroadcast_loader_"+unique_div_id).addClass('cLoader').show();
		jQuery.ajax({
			type: "POST",
			data:'tablename='+tablename+'&unique_div_id='+unique_div_id+"&status="+status+"&content_id="+content_id+"&content_type="+content_type,
			url:URL_SITE+"/admin/actionAjax.php?schuduledapprovedissaprove=1",
			success: function(msg){		
				scrollTop();
				$("#broadcast_unbroadcast_loader_"+unique_div_id).removeClass('cLoader').show();
				jQuery("#schuduled_aprrove_dissaprove_div_"+unique_div_id).html(msg);
				succuss(msg);
			}					
		});
	} else {
		return false;
	}
}

function functionEditMessagePopup(unique_div_id){
	loader_show();
	jQuery.blockUI({
		message: jQuery('#edit_message_div_'+unique_div_id),
		css: {
			width: '67%', border: '5px solid #C1D779', padding:'0px', height:'auto', overflow:'hidden', top: '2%', left:'15%' 
		} 
	});		
}

jQuery(document).ready(function(){
	jQuery("#select_upload_File").click(function(){
		jQuery('#select_upload_file_div').show();
		jQuery('#select_upload_url_div').hide();
		jQuery("#select_upload_none_div").show();
		jQuery('#message_file_upload').addClass("required");
		jQuery('#message_url_upload').removeClass("required");
		jQuery('#select_upload_File_limit').show();
		jQuery('#select_upload_audio_limit').hide();
		jQuery('#select_upload_video_limit').hide();
	});
	jQuery("#select_upload_audio").click(function(){
		jQuery('#select_upload_file_div').show();
		jQuery('#select_upload_url_div').hide();
		jQuery("#select_upload_none_div").show();
		jQuery('#message_file_upload').addClass("required");
		jQuery('#message_url_upload').removeClass("required");
		jQuery('#select_upload_File_limit').hide();
		jQuery('#select_upload_audio_limit').show();
		jQuery('#select_upload_video_limit').hide();
	});
	jQuery("#select_upload_video").click(function(){
		jQuery('#select_upload_file_div').show();
		jQuery('#select_upload_url_div').hide();
		jQuery("#select_upload_none_div").show();
		jQuery('#message_file_upload').addClass("required");
		jQuery('#message_url_upload').removeClass("required");
		jQuery('#select_upload_File_limit').hide();
		jQuery('#select_upload_audio_limit').hide();
		jQuery('#select_upload_video_limit').show();
	});
	jQuery("#select_upload_url").click(function(){
		jQuery('#select_upload_url_div').show();
		jQuery('#select_upload_file_div').hide();
		jQuery("#select_upload_none_div").show();
		jQuery('#message_url_upload').addClass("required");
		jQuery('#message_file_upload').removeClass("required");
	});
	jQuery("#select_upload_none").click(function(){
		jQuery('#select_upload_url_div').hide();
		jQuery('#select_upload_file_div').hide();
		jQuery('#message_url_upload').removeClass("required");
		jQuery('#message_file_upload').removeClass("required");
	});
});

function functiongetSubCategory(divid){
	var parentid = jQuery('#'+divid+'').val();
	if(parentid!=''){
		loader_show();
		jQuery("#loader").html('Loading...');	
		jQuery.ajax({
			type: "POST",
			data: 'parentid='+parentid+"&section_type=subcategory",
			url : URL_SITE+"/actionAjax.php",		
			success: function(msg){	
				loader_unshow();
				jQuery('#loader').html('').hide();
				jQuery("#show_sub_category").html(msg).show();
			}							
		});	
	}
}

function functionDeleteMessages(tablename,message_id, unique_div_id, alertmessage){
	if(confirm(alertmessage)){	
		scrollTop();
		headerLoaderMessage('Sending SMS.. Please donot refresh the Page...');
		jQuery.ajax({
			type: "POST",
			data:'tablename='+tablename+'&message_id='+message_id,
			url:URL_SITE+"/admin/actionAjax.php?deletemessage=1",
			success: function(msg){
				scrollTop();
				jQuery("#msgdiscriptiontxt_"+unique_div_id).remove();
				succuss(msg);
			}					
		});
	} else {
		return false;
	}
}

function functionDeleteContentUniversal(content_id, alertmessage,divid){
	if(confirm(alertmessage)){	
		scrollTop();
		headerLoaderMessage('Sending SMS.. Please donot refresh the Page...');
		jQuery.ajax({
			type: "POST",
			data:'content_id='+content_id,
			url:URL_SITE+"/actionAjax.php?deleteuniversal=1",
			success: function(msg){
				scrollTop();
				jQuery("#"+divid+""+content_id).remove();
				succuss(msg);
			}					
		});
	} else {
		return false;
	}
}

jQuery(document).ready(function(){
	jQuery("#user_type_admin").change(function(){
		jQuery("#user_type_admin_form").submit();
	});
});

jQuery(document).ready(function(){
	jQuery('#district_admin').change(function(){
		var user_group = jQuery('#district_admin').val();
		if(user_group != '0' && user_group != ''){
			jQuery("#village_admin").addClass('sLoader');
			jQuery.ajax({
				type: "POST",
				data: "user_group="+user_group,
				url : URL_SITE+"/admin/actionAjax.php?user_group_wise=1",			
				success: function(msg){
					jQuery("#village_admin").removeClass('sLoader');
					jQuery("#show_district_admin").html(msg);				
				}							
			});	
		}else{
			return false;
		}
	});
});

function functionSendVoiceSms(tablename,content_id, content_type, unique_div_id, approvemessage){
	if(confirm(approvemessage)){	 
		scrollTop();
		headerLoaderMessage('Sending SMS.. Please donot refresh the Page...');
		jQuery.ajax({
			type: "POST",
			data: "tablename="+tablename+'&unique_div_id='+unique_div_id+"&content_id="+content_id+"&content_type="+content_type,
			url:URL_SITE+"/admin/actionAjax.php?sendvoicesmsajax=1",
			success: function(msg){			
				scrollTop();
				headerLoaderMessage(msg);
				jQuery("#msgdiscriptiontxt_"+unique_div_id).remove();	
			}					
		});
	} else {
		return false;
	}
}

jQuery(document).ready(function(){
	jQuery("#addreportgroupmemberforms input[name='selection_type']").click(function(){
		var selection_type = jQuery(this).val();
		var group_id       = jQuery("#group_id").val();
		if(selection_type!=''){
			jQuery('#selection_type_display').html('');
			jQuery('#sloader_selection').addClass('sLoader').show();
			jQuery.ajax({
				type: "POST",
				data: "selection_type="+selection_type+"&group_id="+group_id,
				url : URL_SITE+"/admin/actionAjax.php?selection_type_check=1",	
				success: function(msg){
					jQuery('#sloader_selection').removeClass('sLoader');
					var obj = jQuery.parseJSON(msg);
					if(obj.error=='1'){
						jQuery('#selection_type_display').html(obj.data).show();
					}else{
						jQuery('#selection_type_display').html(obj.message).show();
					}
				}
			});
		} else {
			jQuery('#selection_type_display').html('');
			return false;
		}
	});
});

jQuery(document).ready(function(){
	jQuery("#addreportgroupmemberforms").submit(function(){
		if(jQuery("ul li").hasClass("token-input-token")){
			return true;
		}else{
			return false;
		}
	});
});

function functionselectCountryRecord(){
	var contentid = jQuery("#countryinitial").val();
	if(contentid!=''){
		//jQuery("#state").addClass('sLoader');
		jQuery.ajax({
			type: "POST",
			data: "contentid="+contentid,
			url : URL_SITE+"/actionAjax.php?country_wise=1",			
			success: function(statemsg){
				//jQuery("#state").removeClass('sLoader');
				jQuery("#state").html(statemsg);
				var contentid = jQuery("#stateinitial").val();
				jQuery("#state").val(contentid);
				//jQuery("#district").addClass('sLoader');
				jQuery.ajax({
					type: "POST",
					data: "contentid="+contentid,
					url : URL_SITE+"/actionAjax.php?country_wise=1",			
					success: function(districtmsg){
						//jQuery("#district").removeClass('sLoader');
						jQuery("#district").html(districtmsg);
						var contentid = jQuery("#districtinitial").val();
						jQuery("#district").val(contentid);
						//jQuery("#tahsil").addClass('sLoader');
						jQuery.ajax({
							type: "POST",
							data: "contentid="+contentid,
							url : URL_SITE+"/actionAjax.php?country_wise=1",			
							success: function(tehsilmsg){
								//jQuery("#tahsil").removeClass('sLoader');
								jQuery("#tahsil").html(tehsilmsg);
								var contentid = jQuery("#tehsilinitial").val();
								jQuery("#tahsil").val(contentid);
								//jQuery("#village").addClass('sLoader');
								jQuery.ajax({
									type: "POST",
									data: "contentid="+contentid,
									url : URL_SITE+"/actionAjax.php?country_wise=1",			
									success: function(villagemsg){
										//jQuery("#village").removeClass('sLoader');
										jQuery("#village").html(villagemsg);
										var contentid = jQuery("#villageinitial").val();
										jQuery("#village").val(contentid);
									}							
								});
							}							
						});
					}							
				});		
			}	
		});		
	}else{
		return false;
	}
}

function functionselectUniversalRecord(selectboxid,dataid,level){

	if(level == '0'){
		var contenttext = jQuery('#'+selectboxid+' option:selected').text();
		console.log(contenttext);
		if(contenttext == 'Other'){
			jQuery('#'+dataid+'').after('<div id="removevillageotherid" class="wdthpercent100 pT10 pB10"><div class="leftcontent">&nbsp;</div><div class="rightcontent"><input placeholder="enter village name" type="text" name="other_village" class="inputbox required"/></div></div><div class="clear"></div>');
		}else{
			jQuery("#removevillageotherid").remove();
		}
		return false;
	}
	var contentid = jQuery('#'+selectboxid+'').val();
	console.log(contentid);
	if(contentid!=''){
		jQuery("#removevillageotherid").remove();
		jQuery('#'+dataid+'').addClass('fadeLoader');
		jQuery.ajax({
			type: "POST",
			data: "contentid="+contentid,
			url : URL_SITE+"/actionAjax.php?country_wise=1",			
			success: function(univarsaldata){
				jQuery('#'+dataid+'').removeClass('fadeLoader');
				jQuery('#'+dataid+'').html(univarsaldata);

				if(level=='3'){
					var contentid = jQuery("#district").val();
					console.log(contentid);
					jQuery("#tahsil").addClass('fadeLoader');
					jQuery.ajax({
						type: "POST",
						data: "contentid="+contentid,
						url : URL_SITE+"/actionAjax.php?country_wise=1",			
						success: function(districtmsg){
							jQuery("#tahsil").removeClass('fadeLoader');
							jQuery("#tahsil").html(districtmsg);
							var contentid = jQuery("#tahsil").val();
							console.log(contentid);
							jQuery("#tahsil").val(contentid);
							jQuery("#village").addClass('fadeLoader');
							jQuery.ajax({
								type: "POST",
								data: "contentid="+contentid,
								url : URL_SITE+"/actionAjax.php?country_wise=1",			
								success: function(districtmsg){
									jQuery("#village").removeClass('fadeLoader');
									jQuery("#village").html(districtmsg);
									var contentid = jQuery("#village").val();
									jQuery("#village").val(contentid);
								}							
							});
						}							
					});
				}
				if(level=='2'){
					var contentid = jQuery("#tahsil").val();
					jQuery("#tahsil").val(contentid);
					console.log(contentid);
					jQuery("#village").addClass('sLoader');
					jQuery.ajax({
						type: "POST",
						data: "contentid="+contentid,
						url : URL_SITE+"/actionAjax.php?country_wise=1",			
						success: function(districtmsg){
							jQuery("#village").removeClass('sLoader');
							jQuery("#village").html(districtmsg);
							var contentid = jQuery("#village").val();
							console.log(contentid);
							//jQuery("#village").val(contentid);
						}							
					});
				}					
			}
		});
	}else{
		return false;
	}
}
