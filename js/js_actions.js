function windowLoader(){
	$(window).bind('beforeunload', function() {	
		scrollTop();
		//headerLoaderMessage('Loading...');
		jQuery('#content').addClass("fadeLoader");			
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
			textAlign:'left',position:'fixed',border: '2px solid #70A300',width:'98%',top:'0%',left:'0%',padding:'10px',backgroundColor:'#FFF','-webkit-border-radius':'10px','-moz-border-radius': '10px', opacity:'1.0',font:'30px', color: '#000', minHeight: '100px'
		} 
	});
}

function blockUI_divid(divid){
	jQuery.blockUI({
		message: jQuery('#'+divid+''),
		css: { 
			textAlign:'left',position:'fixed',border: '2px solid #70A300',width:'98%',top:'0%',left:'0%',padding:'10px',backgroundColor:'#FFF','-webkit-border-radius':'10px','-moz-border-radius': '10px', opacity:'1.0',font:'30px', color: '#000', minHeight: '100px'
		} 
	});
}

function BLOCKUI_DIVID_LARGE(divid){
	jQuery.blockUI({
		message: jQuery('#'+divid+''),
		css: { 
			textAlign:'left',position:'fixed',border: '5px solid #70A300',width:'55%',top:'40%',left:'20%',padding:'10px',backgroundColor:'#FFF','-webkit-border-radius':'10px','-moz-border-radius': '10px', opacity:'1.0',font:'30px', color: '#000' 
		} 
	});
}

function BLOCKUI_MSG_OBJECT(msgobj){
	jQuery.blockUI({ 
		message: msgobj, 
		css: { 
			textAlign:'left',position:'fixed',border: '2px solid #70A300',width:'98%',top:'0%',left:'0%',padding:'10px',backgroundColor:'#FFF','-webkit-border-radius':'10px','-moz-border-radius': '10px', opacity:'1.0',font:'30px', color: '#000', minHeight: '100px'
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
		url : URL_SITE+"/captcha_code_file.php?get_captcha_code=1",		
		success: function(msg){										
			jQuery("#captcha_code").html(msg);
		}							
	});	
}

function functiongetSubCategory(divid,fieldid){
	var parentid = jQuery('#'+divid+'').val();
	if(parentid!=''){
		jQuery('#'+divid+'').addClass("fadeLoader");
		jQuery("#loader").html('Loading...');	
		jQuery.ajax({
			type: "POST",
			data: 'parentid='+parentid+"&section_type=subcategory&fieldid="+fieldid,
			url : URL_SITE+"/actionAjax.php",		
			success: function(msg){	
				jQuery('#'+divid+'').removeClass("fadeLoader");
				jQuery('#loader').html('').hide();
				jQuery('#'+divid+'_sub_show').html(msg).show();
			}							
		});	
	}
}

function functionGetGereralSubCategory(divid,classname){
	var parentid = jQuery('#'+divid+'').val();
	if(parentid!=''){
		loader_show();
		jQuery("#loader").html('Loading...');	
		jQuery.ajax({
			type: "POST",
			data: 'parentid='+parentid+"&section_type=subcategorygeneral&classname="+classname,
			url : URL_SITE+"/actionAjax.php",		
			success: function(msg){	
				loader_unshow();
				jQuery('#loader').html('').hide();
				jQuery('#'+divid+'_sub_show').html(msg).show();
			}							
		});	
	}
}

function functiongetGenSubCategory(divid,fieldid){
	var parentid = jQuery('#'+divid+'').val();
	if(parentid!=''){
		jQuery('#'+divid+'').addClass("fadeLoader");
		jQuery("#loader").html('Loading...');	
		jQuery.ajax({
			type: "POST",
			data: 'parentid='+parentid+"&section_type=subcategorygeneral&fieldid="+fieldid,
			url : URL_SITE+"/actionAjax.php",		
			success: function(msg){	
				jQuery('#'+divid+'').removeClass("fadeLoader");
				jQuery('#loader').html('').hide();
				jQuery('#'+divid+'_sub_show').html(msg).show();
			}							
		});	
	}
}

jQuery(document).ready(function(){
	jQuery("#userSmsAndriodMessageForm_closed").submit(function(e){		
		e.preventDefault();			
		var pass_msg = jQuery("#userSmsAndriodMessageForm_closed").valid();
		
		//some validations
		if(pass_msg == false){
			return false;
		} else {
			loader_show();			
			jQuery.ajax({
				type: "POST",
				data: jQuery("#userSmsAndriodMessageForm_closed").serialize(),
				url : URL_SITE+"/actionAjax.php?submitmessage=1",
				success: function(msg) {
					loader_unshow();					
					succuss(msg);
					window.location= URL_SITE+"/texts.php";
				}
			});
		}
	});
});

/*
function functionSubmitPHPLoader(formid){
	var pass_msg = jQuery('#'+formid+'').valid();		
	//some validations
	if(pass_msg == false){
		return false;
	} else {
		loader_show();
		setInterval(function(){return true;},2000);				
	}
}
*/

jQuery(document).ready(function(){
	jQuery("#msg-menu-div").hover(function(){
		jQuery('#msg-submenu-div').show();
	},function(){
		jQuery('#msg-submenu-div').hide();
	});

	jQuery("#profile-login").hover(function(){
		jQuery('#main-profile').show();
	},function(){
		jQuery('#main-profile').hide();
	});
});

jQuery(document).ready(function(){
	jQuery("#change-image").click(function(){
		blockUI_divid("content-upload-image");
	});
	jQuery("#resetsetting").click(function(){
		if(confirm("This Action cannot be undone. Are you sure you want to reset all content?")){	
			jQuery("input").removeAttr('checked');
			jQuery(".hideall").hide();
			return true;
		}else{
			return false;
		}							
	});
});

function view_all(tablename,msgid,unique_div_id) {
	if(msgid > 0){
		jQuery("#loader"+unique_div_id).addClass('cLoader');
		jQuery.ajax({
			type: "POST",
			data: "tablename="+tablename+"&msgid="+msgid+"&unique_div_id="+unique_div_id+"&select_msg_body=1",
			url : URL_SITE+"/actionAjax.php",	
			success: function(msg){
			   jQuery("#loader"+unique_div_id).removeClass('cLoader');
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
	jQuery("#message_type , #language_type , #day, #month, #year").bind('change',function(){
		if(jQuery("#status").val()!='' || jQuery("#message_type").val()!='' || jQuery("#language_type").val()!='' || jQuery("#day").val()!='' || jQuery("#month").val()!='' || jQuery("#year").val()!=''){
			loader_show();
			jQuery("#selectLanguageTypeMessageTypeForm").submit();
		}
	});
});

jQuery(document).ready(function(){
	jQuery("#channel_id").change(function(){
		if(jQuery("#channel_id").val()!='')
		jQuery("#select_channel_type").submit();
	});
});

jQuery(document).ready(function(){
	jQuery("#content_type").change(function(){
		if(jQuery("#content_type").val()!='')
		jQuery("#select_content_type").submit();
	});
});

jQuery(document).ready(function(){
	jQuery('#language-type-check-all').click(function () {
		if(jQuery("#language-type-check-all").is(":checked")){
			jQuery("input[type='checkbox'][name='language_type_setting[]']").prop('checked', true);
		} else {
			jQuery("input[type='checkbox'][name='language_type_setting[]']:checked").removeAttr("checked");
		}
	});
	jQuery("input[type='checkbox'][name='language_type_setting[]']").click(function () {
		jQuery('#language-type-check-all').removeAttr("checked");
	});
});

jQuery(document).ready(function(){
	jQuery('#user-type-check-all').click(function () {
		if(jQuery("#user-type-check-all").is(":checked")){
			jQuery("input[type='checkbox'][name='user_type_setting[]']").prop('checked', true);
		} else {
			jQuery("input[type='checkbox'][name='user_type_setting[]']:checked").removeAttr("checked");
		}
	});
	jQuery("input[type='checkbox'][name='user_type_setting[]']").click(function () {
		jQuery('#user-type-check-all').removeAttr("checked");
	});
});

function category_subcategory_show(categoryid){
	if(jQuery("#parent_category_setting"+categoryid).is(":checked")){
		jQuery(".sub_category_div_show"+categoryid).attr('style','display:block;');						
	} else {
		jQuery(".sub_category_div_show"+categoryid).attr('style','display:none;');
		jQuery(".checked_sub_category"+categoryid).removeAttr('checked');
		jQuery("#category-subcategory-check-all"+categoryid).removeAttr("checked");
	}
}

function categorysubcategorycheckAll(categoryid){
	if(jQuery("#category_subcategory_check_all"+categoryid).is(":checked")){
		jQuery(".checked_sub_category"+categoryid).prop('checked', true);
	} else {
		jQuery(".checked_sub_category"+categoryid).removeAttr("checked");
	}	
	jQuery(".checked_sub_category"+categoryid).click(function () {
		jQuery("#category_subcategory_check_all"+categoryid).removeAttr("checked");
	});
}

function submitContentForm(unique_div_id){	
	var comment = $("#click_content_comment_"+unique_div_id).val();
	if(comment!=''){
		$("#click_content_comment_"+unique_div_id).removeClass("bordererror");
		$("#submit_comment_content_"+unique_div_id).addClass('cLoader');
		$("#click_content_comment_"+unique_div_id).css('style','border:1px solid;');											
		$.ajax({
			type: "POST",										
			data:$("#form_content_comment_"+unique_div_id).serialize(),
			url:URL_SITE+"/actionAjax.php?ajaxcontentcomment=1&recentcontentcomment=1",	
			success: function(msg){										
				$("#content_append_prepend_div_"+unique_div_id).append(msg);
				$("#submit_comment_content_"+unique_div_id).removeClass('cLoader');
				$("#click_content_comment_"+unique_div_id).css("style","resize: none; overflow: hidden; height:20px;");
				$("#click_content_comment_"+unique_div_id).val('');
			}
		});	
		return false;
	}else{
		$("#click_content_comment_"+unique_div_id).addClass("bordererror");
		return false;
	}
}

function functionDeleteContentComment(unique_div_id,content_comment_id){
	if(confirm("Do you really want to delete this content") && content_comment_id!=''){	
		$("#comment_delete_"+content_comment_id+"_"+unique_div_id).addClass('cLoader');
		$.ajax({
			type: "POST",										
			data:'unique_div_id='+unique_div_id+'&content_comment_id='+content_comment_id,
			url:URL_SITE+"/actionAjax.php?ajaxcontentcommentdelete="+content_comment_id,	
			success: function(msg){										
				$("#commentsslidetext_"+content_comment_id+"_"+unique_div_id).remove();
				$("#comment_delete_"+content_comment_id+"_"+unique_div_id).removeClass('cLoader');
				succuss(msg);			
			}
		});
	}else{
		return false;
	}
}
function functionLoadRemaining(unique_div_id, totalcontentcomment, content_id, content_type, message_user_id){
	var limit = Number(jQuery("#limitvalue_"+unique_div_id).val());
	jQuery(".comment_content_"+unique_div_id+" h3:first").removeClass("active");
	$("#content_comment_remaining_"+unique_div_id).addClass('cLoader');
	jQuery.ajax({
		type: "POST",
		data:'unique_div_id='+unique_div_id+"&limit="+limit+"&content_id="+content_id+"&content_type="+content_type+"&message_user_id="+message_user_id,
		url:URL_SITE+"/actionAjax.php?ajaxcontentcomment=1&loadoldcomment=1",	
		success: function(msg){	
			limit=	limit+10;
			jQuery("#content_append_prepend_div_"+unique_div_id).prepend(msg);
			$("#content_comment_remaining_"+unique_div_id).removeClass('cLoader');
			jQuery("#content_slide_div_"+unique_div_id).toggleClass("active");
			jQuery(this).toggleClass("active");
			jQuery("#limitvalue_"+unique_div_id).val(limit);			
			if(totalcontentcomment<=limit){
				jQuery("#content_comment_remaining_"+unique_div_id).hide();
			}						
		}					
	});
}
function functionLikeContentComment(content_id, content_type, unique_div_id, likestatus, user_id){
	if(user_id!='' && user_id!='0'){
		$("#like_loader_"+unique_div_id).addClass('cLoader').show();
		jQuery.ajax({
			type: "POST",
			data:'unique_div_id='+unique_div_id+"&likestatus="+likestatus+"&content_id="+content_id+"&content_type="+content_type+"&user_id="+user_id,
			url:URL_SITE+"/showcontentlikedislike.php?ajaxcontentlike=1",	
			success: function(msg){	
				jQuery("#content_like_div_"+unique_div_id).html(msg);
				$("#like_loader_"+unique_div_id).removeClass('cLoader').hide();
				if(likestatus == '0'){
					jQuery("#unlike_"+unique_div_id).hide();
					jQuery("#like_"+unique_div_id).show();
				} else {
					jQuery("#like_"+unique_div_id).hide();
					jQuery("#unlike_"+unique_div_id).show();
				}
			}					
		});
	} else {
		return false;
	}
}

jQuery(document).ready(function(){
	jQuery("#frontuserloginform").submit(function(e){		
		e.preventDefault();		
		var pass_msg = jQuery("#frontuserloginform").valid();		
		//some validations
		if(pass_msg == false){
			return false;
		} else {			
			jQuery('#Pagecontent').addClass("fadeLoader");
			jQuery.ajax({
				type: "POST",
				data: jQuery("#frontuserloginform").serialize(),
				url : URL_SITE+"/actionAjax.php?logging=1",				
				success: function(msg) {
					jQuery('#Pagecontent').removeClass("fadeLoader");
					var obj = jQuery.parseJSON(msg);
					if(obj.error == '0'){
						error(obj.message);
					}else{
						headerLoaderMessage('Logging in your account...Please wait...');
						setInterval(function(){window.location=URL_SITE+jQuery.trim(obj.url)},3000);	
					}			
				}							
			});	
		}
	});	 
});

function functionFilterSubCategory(parent_subcategory,landingpage) {
	loader_show();
	jQuery.ajax({
		type: "POST",
		data: "parent_subcategory="+parent_subcategory,
		url : URL_SITE+"/actionAjax.php?settingcatsession=1",	
		success: function(msg){
			//window.location = URL_SITE+landingpage;
			location.reload();
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

function add_percentage_function(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	var row = table.insertRow(rowCount);
	var colCount = table.rows[0].cells.length;
	for(var i=0; i<colCount; i++) {
		var newcell = row.insertCell(i);
		newcell.innerHTML = table.rows[0].cells[i].innerHTML;
		switch(newcell.childNodes[0].type) {
			case "text":
					newcell.childNodes[0].value = "";
					break;
			case "checkbox":
					newcell.childNodes[0].checked = false;
					break;
			case "select-one":
					newcell.childNodes[0].selectedIndex = 0;
					break;
		}
	}
}

function delete_percentage_function(tableID) {
	try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		for(var i=0; i<rowCount; i++) {
			var row = table.rows[i];
			var chkbox = row.cells[2].childNodes[0];
			if(null != chkbox && true == chkbox.checked) {
				if(rowCount <= 1) {
					break;
				}
				table.deleteRow(i);
				rowCount--;
				i--;
			}
		}
	}catch(e) {
		alert(e);
	}
}

jQuery(document).ready(function(){
	jQuery("#select_user_sub_Group_padding").hide();
	jQuery('#user_group').change(function(){
		var user_group = jQuery('#user_group').val();
		if(user_group != '0'){	
			loader_show();
			jQuery.ajax({
				type: "POST",
				data: "",
				url : URL_SITE+"/actionAjax.php?user_group="+user_group,			
				success: function(msg){
					loader_unshow();
					jQuery("#select_user_sub_Group").html(msg);
					jQuery("#select_user_sub_Group_padding").show();
					
				}							
			});	
		}else{
			return false;
		}
	});
});

function functionSelectAllUserGroupMobile(user_group,key){
	if(jQuery("#user_group_writemgs"+key).is(":checked") && user_group!='0'){
		loader_show();
		jQuery.ajax({
			type: "POST",
			data: "user_group="+user_group,
			url : URL_SITE+"/actionAjax.php?selectusergroup=1",			
			success: function(msg){
				loader_unshow();
				jQuery("#select_user_sub_group").append(msg).show();					
			}							
		});	
	}else{
		if(!jQuery("#user_group_writemgs"+key).is(":checked")){
			jQuery("#content_seleted_"+user_group).remove();
		}		
		return false;
	}
}

function select_user_sub_group(group_id){
	var user_group_id = jQuery('#user_group_id_'+group_id).val();
	if(user_group_id != '0'){	
		loader_show();
		jQuery.ajax({
			type: "POST",
			data: "",
			url : URL_SITE+"/actionAjax.php?user_group_id="+user_group_id,			
			success: function(msg){
				loader_unshow();
				jQuery("#user_sub_group_padding").html(msg).show();					
			}							
		});	
	}else{
		return false;
	}
}

jQuery(document).ready(function(){
	jQuery("#weather_report_weekly").click(function(){
		jQuery('#weekly_report_div').show();
		jQuery('#hourly_report_div').hide();
		jQuery('#weather_report_weekly').addClass("wactive");
		jQuery('#weather_report_hourly').removeClass("wactive");
	});
	jQuery("#weather_report_hourly").click(function(){
		jQuery('#weekly_report_div').hide();
		jQuery('#hourly_report_div').show();
		jQuery('#weather_report_weekly').removeClass("wactive");
		jQuery('#weather_report_hourly').addClass("wactive");
	});
});

jQuery(document).ready(function(){
	jQuery("#voice_type").change(function(){
		var voice_type = jQuery('#voice_type').val();
		if(voice_type!=''){
			loader_show();
			jQuery.ajax({
				type: "POST",
				data: "voice_type="+voice_type,
				url : URL_SITE+"/actionAjax.php",	
				success: function(msg){
					loader_unshow();
					jQuery('#bulk_group_type_content').html(msg);
				}
			});
		} else {
			jQuery('#bulk_group_type_content').html('');
			return false;
		}
	});
});

jQuery(document).ready(function(){
	jQuery("#sms_type").change(function(){
		var sms_type = jQuery('#sms_type').val();
		if(sms_type!=''){
			jQuery('#sms_type').addClass("fadeLoader");
			jQuery.ajax({
				type: "POST",
				data: "sms_type="+sms_type,
				url : URL_SITE+"/actionAjax.php?getsmstype=1",	
				success: function(msg){
					jQuery('#sms_type').removeClass("fadeLoader");
					jQuery('#bulk_group_type_text_content').html(msg);
				}
			});
		} else {
			jQuery('#bulk_group_type_text_content').html('');
			return false;
		}
	});
});

jQuery(document).ready(function(){
	jQuery("#job_type").change(function(){
		var job_type = jQuery('#job_type').val();
		if(job_type!=''){
			jQuery.ajax({
				type: "POST",
				data: "job_type="+job_type,
				url : URL_SITE+"/actionAjax.php",	
				success: function(msg){
					window.location = URL_SITE+'/message.php';
				}
			});
		} else {
			return false;
		}
	});
});

function functionDeleteMessages(message_id, unique_div_id, alertmessage){
	if(confirm(alertmessage)){	
		loader_show();
		jQuery.ajax({
			type: "POST",
			data:'message_id='+message_id,
			url:URL_SITE+"/actionAjax.php?deletemessage=1",
			success: function(msg){
				jQuery("#msgdiscriptiontxt_"+unique_div_id).remove();
				loader_unshow();
				succuss(msg);
			}					
		});
	} else {
		return false;
	}
}

function funSelectFarmerDistrictWise(group_id,divid){	
	if(group_id != '0' && group_id != ''){	
		loader_show();
		jQuery.ajax({
			type: "POST",
			data: "user_group="+group_id,
			url : URL_SITE+"/actionAjax.php?user_group_wise=1",			
			success: function(msg){
				loader_unshow();
				jQuery('#'+divid+'').html(msg).show();
				jQuery("#display_farmer_list").html('').hide();
				if(group_id!='all'){
					jQuery('#remove_on_all').show();
					if(!jQuery('#notrenderid').hasClass("notrenserclass")){
						jQuery('#'+divid+'').after('<tr id="notrenderid" class="notrenserclass"><td>&nbsp;</td><td>&nbsp;</td></tr>');
					}
				}else{
					jQuery('#remove_on_all').hide();	
				}
			}							
		});	
	}else{
		return false;
	}
}
jQuery(document).ready(function(){
	jQuery("#forgot-password-click").click(function(){
		blockUI_divid("forgot-password-link");
	});
});

//forgot-password.php
jQuery(document).ready(function(){
	jQuery("#forgot-password-form").submit(function(e){		
		e.preventDefault();			
		var pass_msg = jQuery("#forgot-password-form").valid();		
		//some validations
		if(pass_msg == false){
			return false;
		} else {
			var email = jQuery("#email").val();
			if(email!=''){		
				jQuery("#succuss-message").html('').hide();
				jQuery('#loader_forgot').addClass('cLoader');
				jQuery.ajax({
					type: "POST",
					data: 'email='+email,
					url : URL_SITE+"/actionAjax.php?forgotpasswordemail=1",
					success: function(msg) {			
						jQuery('#loader_forgot').removeClass('cLoader');
						jQuery("#email").val('');
						jQuery("#succuss-message").html(msg).show();
					}
				});
			}else{
				return false;
			}
		}
	});
});

function functionRemoveFilterSubCategory(landingpage) {
	loader_show();
	jQuery.ajax({
		type: "POST",
		data: "",
		url : URL_SITE+"/actionAjax.php?removeallfilter=1",	
		success: function(msg){
			location.reload();
		}
	});
}

jQuery(document).ready(function(){
	jQuery("#select_user_sub_group_padding_farmer").show();
	jQuery('#user_group_farmer_wise').change(function(){
		var user_group = jQuery('#user_group_farmer_wise').val();
		if(user_group != '0' && user_group != ''){	
			jQuery(".content_seleted_farmer_remove").remove();	
			loader_show();
			jQuery.ajax({
				type: "POST",
				data: "user_group="+user_group,
				url : URL_SITE+"/actionAjax.php?user_group_wise=1",			
				success: function(msg){
					loader_unshow();
					jQuery("#show_user_sub_Group_farmer_wise").html(msg);
					jQuery("#select_user_sub_Group_padding").show();					
				}							
			});	
		}else{
			return false;
		}
	});
});



jQuery(document).ready(function(){
	jQuery('#district_front').change(function(){
		var user_group = jQuery('#district_front').val();
		if(user_group != '0' && user_group != ''){
			jQuery("#village_front").addClass('sLoader');
			jQuery.ajax({
				type: "POST",
				data: "user_group="+user_group,
				url : URL_SITE+"/admin/actionAjax.php?user_group_wise=1",			
				success: function(msg){
					jQuery("#village_front").removeClass('sLoader');
					jQuery("#show_district_admin").html(msg);				
				}							
			});	
		}else{
			return false;
		}
	});
});

function FunctionSelectContentType(formid,attributeid){
	jQuery('#'+formid+'').submit();
	return true;
	
}

function FunctionSelectUniversal(displaydiv,valdiv,ajaxrequestvar,loaderdiv){
	if(valdiv == 'state'){
		jQuery('#show_district_list').html('<td class="wdthpercent50">District</td><td class="wdthpercent50"><select class="inputbox required" id="district" name="district"><option value="">Select district</option></select></td>');
		jQuery('#show_village_list').html('<td class="wdthpercent50">Village</td><td class="wdthpercent50"><select class="inputbox required" id="village" name="village"><option value="">Select village</option></select></td>');
	}
	if(valdiv == 'district'){
		jQuery('#show_village_list').html('<td class="wdthpercent50">Village</td><td class="wdthpercent50"><select class="inputbox required" id="village" name="village"><option value="">Select village</option></select></td>');
	}
	var datavalue = jQuery('#'+valdiv+'').val();
	if(state != '0' && state != ''){
		jQuery('#'+loaderdiv+'').addClass('sLoader');
		jQuery.ajax({
			type: "POST",
			data: "datavalue="+datavalue,
			url : URL_SITE+"/actionAjax.php?"+ajaxrequestvar+"=1",			
			success: function(msg){
				jQuery('#'+loaderdiv+'').removeClass('sLoader');
				jQuery('#'+displaydiv+'').html(msg);				
			}							
		});	
	}else{
		return false;
	}
}

function FunctionRemoveUniversal(projectid, contentid, removedivid, loaderdiv,ajaxrequestvar){
	if(confirm("Are you sure to perform this action?")){
		if(projectid && contentid){
			jQuery('#'+loaderdiv+contentid+'').addClass('sLoader');
			jQuery.ajax({
				type: "POST",
				data: "contentid="+contentid+"&projectid="+projectid+"&removedivid="+removedivid,
				url : URL_SITE+"/actionAjax.php?"+ajaxrequestvar+"=1",	
				success: function(msg){
					jQuery('#'+loaderdiv+contentid+'').removeClass('sLoader');
					if(ajaxrequestvar == 'remove_project_user'){
						jQuery('#'+removedivid+contentid+'').remove();
						succuss(msg);
					}					
					if(ajaxrequestvar == 'active_inactive_project_user'){
						jQuery('#active_inactive_'+contentid).html(msg);
						succuss('Enter has been updated.');
					}					
				}
			});
		} else {
			return false;
		}
	}
}

jQuery(document).ready(function(){
	jQuery("#userregistration").submit(function(e){

		e.preventDefault();

		$("html, body").scrollTop(0);

		error = 0;
		error_msg = "Please correct the following errors:\r\n";

		var pfirstname  = $('#pfirstname');
		var plastname   = $('#plastname');
		var pfathername = $('#pfathername');
		var phone       = $('#phone');
		var password    = $('#passwordfield');	
		var village     = $('#village');	
		var district    = $('#district');	
		var state       = $('#state');	
		var pincode     = $('#pincode');	
		var user_type   = $('#user_type');
		var gender      = $('#gender');
		
		if(pfirstname.val() == '') {
			error = 1;
			error_msg += "  + Please enter your first name.\r\n";
		}
		if(plastname.val() == '') {
			error = 1;
			error_msg += "  + Please enter your last name.\r\n";
		}
		if(pfathername.val() == '') {
			error = 1;
			error_msg += "  + Please enter your father name.\r\n";
		}
		if(phone.val() == '') {
			error = 1;
			error_msg += "  + Please enter your phone number.\r\n";
		}
		if(password.val() == '') {
			error = 1;
			error_msg += "  + Please enter your password.\r\n";
		}
		if(village.val() == '') {
			error = 1;
			error_msg += "  + Please enter your village.\r\n";
		}
		if(district.val() == '') {
			error = 1;
			error_msg += "  + Please enter your district.\r\n";
		}
		if(state.val() == '') {
			error = 1;
			error_msg += "  + Please enter your state.\r\n";
		}
		if(pincode.val() == '') {
			error = 1;
			error_msg += "  + Please enter your pincode.\r\n";
		}
		if(user_type.val() == '') {
			error = 1;
			error_msg += "  + Please enter your user type.\r\n";
		}
		if(gender.val() == '') {
			error = 1;
			error_msg += "  + Please enter your gender.\r\n";
		}
		
		if(error){
			alert(error_msg);
			return false;
		} else{
			jQuery(".entry").addClass("fadeLoader");
			loader_show();
			jQuery.ajax({
				type: "POST",
				data: jQuery("#userregistration").serialize(),
				url : URL_SITE+"/actionAjax.php?registering=1",				
				success: function(msg) {
					jQuery(".entry").removeClass("fadeLoader");	
					var obj = jQuery.parseJSON(msg);
					if(obj.error == '0'){
						succuss(obj.message);
					}else{
						succuss(obj.message);
						jQuery("#userregistration").html(obj.data);	
					}
				}							
			});	
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

function functionVillageProjectLocationUniversal(selectboxid, dataid, type){
	var contentid = jQuery('#'+selectboxid+'').val();
	if(contentid!=''){
		if(type != 'none'){
		jQuery('#'+selectboxid+'').after('<span class="spanloader">&nbsp;</span>');
		}
		jQuery.ajax({
			type: "POST",
			data: "contentid="+contentid,
			url : URL_SITE+"/actionAjax.php?project_village_country_wise=1&type="+type,			
			success: function(univarsaldata){
				jQuery('.spanloader').remove();
				jQuery('#'+selectboxid+dataid+'').html(univarsaldata);		
			}	
		});		
	}else{
		return false;
	}
}

function functionFarmerProjectLocationUniversal(selectboxid, dataid, type){

	var contentid = jQuery('#'+selectboxid+'').val();
	var gender    = jQuery('#gender').val();

	if(type=='v'){
		var datatransfer = "contentid="+contentid+"&returntype=checkbox&gender="+gender;
	}else{
		var datatransfer = "contentid="+contentid+"&gender="+gender;
	}
	
	if(contentid!=''){
		jQuery('#'+selectboxid+'').after('<span class="spanloader">&nbsp;</span>');
		jQuery.ajax({
			type: "POST",
			data: datatransfer,
			url : URL_SITE+"/actionAjax.php?project_farmer_country_wise=1&type="+type,			
			success: function(univarsaldata){
				jQuery('.spanloader').remove();
				jQuery(".content_seleted_farmer_remove").remove();
				jQuery('#'+selectboxid+dataid+'').html(univarsaldata);		
			}	
		});		
	}else{
		return false;
	}
}

function functionFarmerGenderProjectLocationUniversal(selectboxid, dataid, type){

	var contentid = jQuery('#'+selectboxid+'').val();
	var gender    = jQuery('#gender').val();

	if(type=='v'){
		var datatransfer = "contentid="+contentid+"&returntype=checkbox&gender="+gender;
	}else{
		var datatransfer = "contentid="+contentid+"&gender="+gender;
	}
	
	if(contentid!=''){
		jQuery('#'+dataid+'').addClass('sLoader');
		jQuery("#tahsilvillage").html('');
		jQuery("#districttahsil").html('');
		jQuery.ajax({
			type: "POST",
			data: datatransfer,
			url : URL_SITE+"/actionAjax.php?project_farmer_country_wise=1&type="+type,			
			success: function(univarsaldata){
				jQuery('#'+dataid+'').removeClass('fadeLoader');
				jQuery(".content_seleted_farmer_remove").remove();
				jQuery('#'+selectboxid+dataid+'').html(univarsaldata);		
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

function functionselectCountryRecordReport(returntype){
	var contentid = jQuery("#countryinitial").val();
	if(contentid!=''){
		jQuery(".content_seleted_farmer_remove").remove();
		jQuery("#state").addClass('fadeLoader');
		jQuery.ajax({
			type: "POST",
			data: "contentid="+contentid,
			url : URL_SITE+"/actionAjax.php?country_wise=1",			
			success: function(statemsg){
				jQuery("#state").removeClass('fadeLoader');
				jQuery("#state").html(statemsg);
				var contentid = jQuery("#stateinitial").val();
				jQuery("#state").val(contentid);
				jQuery("#district").addClass('fadeLoader');
				jQuery.ajax({
					type: "POST",
					data: "contentid="+contentid,
					url : URL_SITE+"/actionAjax.php?country_wise=1",			
					success: function(districtmsg){
						jQuery("#district").removeClass('fadeLoader');
						jQuery("#district").html(districtmsg);
						var contentid = jQuery("#districtinitial").val();
						jQuery("#district").val(contentid);
						jQuery("#tahsil").addClass('fadeLoader');
						jQuery.ajax({
							type: "POST",
							data: "contentid="+contentid,
							url : URL_SITE+"/actionAjax.php?country_wise=1",			
							success: function(tehsilmsg){
								jQuery("#tahsil").removeClass('fadeLoader');
								jQuery("#tahsil").html(tehsilmsg);
								var contentid = jQuery("#tehsilinitial").val();
								var gender    = jQuery('#gender').val();
								jQuery("#tahsil").val(contentid);								
								jQuery("#village").addClass('fadeLoader');
								jQuery.ajax({
									type: "POST",
									data: "contentid="+contentid+"&returntype="+returntype+"&gender="+gender,
									url : URL_SITE+"/actionAjax.php?country_wise=1",			
									success: function(villagemsg){
										jQuery("#village").removeClass('fadeLoader');
										jQuery("#village").html(villagemsg);
										var contentid = jQuery("#villageinitial").val();
										//jQuery("#village").val(contentid);
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

function functionselectUniversalRecordReport(selectboxid,dataid,level,returntype){
	var contentid = jQuery('#'+selectboxid+'').val();
	var gender    = jQuery('#gender').val();
	if(level=='tahsil'){
		var datatransfer = "contentid="+contentid+"&returntype="+returntype+"&gender="+gender;
	}else{
		var datatransfer = "contentid="+contentid+"&gender="+gender;
	}
	if(contentid!=''){
		jQuery(".content_seleted_farmer_remove").remove();
		jQuery("#removevillageotherid").remove();
		jQuery('#'+dataid+'').addClass('fadeLoader');
		jQuery.ajax({
			type: "POST",
			data: datatransfer,
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
						data: "contentid="+contentid+"&gender="+gender,
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
								data: "contentid="+contentid+"&returntype="+returntype+"&gender="+gender,	
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
						data: "contentid="+contentid+"&returntype="+returntype+"&gender="+gender,
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

function functionUserGroupMobileFarmerWise(user_sub_group, group_name, gender){	
	if(jQuery("#user_sub_group_select_"+user_sub_group).is(":checked") && user_sub_group!='0'){
		jQuery('.villlage-data').after('<span class="spanloader">&nbsp;</span>');
		//jQuery("#user_sub_group_select_"+user_sub_group).addClass('fadeLoader');
		jQuery.ajax({
			type: "POST",
			data: "user_sub_group="+user_sub_group+"&group_name="+group_name+"&gender="+gender,
			url : URL_SITE+"/actionAjax.php?farmer_selection_refine=1",			
			success: function(msg){				
				//jQuery("#user_sub_group_select_").removeClass('fadeLoader');
				jQuery(".spanloader").remove();
				scrollToSelected("user_sub_group_select_"+user_sub_group);
				jQuery("#display_farmer_wise_list").after(msg).show();	
			}							
		});	
	}else{
		if(!jQuery("#user_sub_group_select_"+user_sub_group).is(":checked")){
			jQuery("#content_seleted_farmer_"+user_sub_group).remove();
		}		
		return false;
	}
}

function selectLanguageType(LANG){
	if(LANG!=''){
		jQuery('#'+LANG+'').addClass('sLoader');
		jQuery.ajax({
			type: "POST",
			data: '',
			url : URL_SITE+"/searchAjax.php?LANG="+LANG,		
			success: function(msg){	
				window.location=URL_SITE+'/search.php';
			}							
		});	
	}
}

//public_html/dev/api/googleTranslateSearch.php
jQuery(document).ready(function(){
	jQuery("#searchmessagetagForm").submit(function(e){		
		e.preventDefault();			
		var searchkeyword = jQuery("#searchkeyword").val();
		var searchtype    = jQuery("input[name='searchtype']:checked").val();
		var language_type = jQuery("#language_type").val();
		if(searchkeyword.length <= 2 && searchtype!=''){
			return false;
		} else {
			jQuery("#search_result_display").remove();					
			jQuery("#search_pagination_div").hide();
			jQuery(".searchbutton").attr('type', 'button');
			jQuery(".searchbutton").val('SEARCHING');
			jQuery("#searchlogo").remove();
			jQuery("#search_result_display").html('').hide();
			jQuery('#cloaderid').addClass('cLoader').show();
			jQuery.ajax({
				type: "POST",
				data: 'searchkeyword='+searchkeyword+'&searchtype='+searchtype+"&language_type="+language_type,
				url : URL_SITE+"/searchAjax.php?search=1",
				success: function(msg) {
					jQuery(".search").after('<div id="search_result_display" class="pT10 pB10" style="display:none;padding:0px"><h2>Search Records</h2></div>').show();	
					jQuery(".searchbutton").attr('type', 'submit');
					jQuery(".searchbutton").val('SEARCH');
					jQuery("#cloaderid").removeClass('cLoader').hide();
					if(jQuery.trim(msg)=='false'){
						jQuery("#search_result_display").append('<div class="fullcontent">No record founds</div>').show();
						jQuery("#search_pagination_div").hide();
					}else{						
						jQuery("#searchlogo").remove();
						jQuery("#search_result_display").html(msg).show();
						jQuery("#search_pagination_div").show();
					}
				}
			});			
		}
	});
});

function SearchPagination(searchtype) {	
	var startLimit		= Number(jQuery('#startLimit').val());
	var totalMsg		= Number(jQuery("#totalMsg").val());
	var endLimit		= Number(jQuery('#endLimit').val());
	var searchkeyword   = jQuery("#searchkeyword").val();
	if(totalMsg > startLimit){
		jQuery('.id-load-total-display').addClass('cLoader');
		jQuery.ajax({
			type: "POST",
			data: "startLimit="+startLimit+"&endLimit="+endLimit+"&searchtype="+searchtype+"&searchkeyword="+searchkeyword,
			url : URL_SITE+"/searchAjax.php",	
			success: function(msgobj){
			   startLimit       = startLimit + 10;			   
			   var remainingmsg = totalMsg - startLimit;
			   if(remainingmsg<0){
				   jQuery("#load_more_message").html('No more result.').show();
			   } else {
					jQuery('.id-load-total-display').removeClass('cLoader');
			   }			  
			   jQuery('#startLimit').val(startLimit);			   
			   jQuery("#search_result_display_append").append(msgobj);
			}
		});
	} else {
		jQuery("#load_more_message").html('No more message.').show();
		return false;
	}
}

jQuery(document).ready(function(){
	jQuery("#addreportgroupmemberforms #selection_type").change(function(){
		var selection_type = jQuery(this).val();
		var group_id       = jQuery("#group_id").val();
		if(selection_type!=''){
			jQuery('#selection_type_display').html('');
			jQuery('#selection_type_display').addClass('sLoader').show();
			jQuery.ajax({
				type: "POST",
				data: "selection_type="+selection_type+"&group_id="+group_id,
				url : URL_SITE+"/actionAjax.php?selection_type_check=1",	
				success: function(msg){
					jQuery('#selection_type_display').removeClass('sLoader');
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

jQuery(document).ready(function(){
	jQuery('#click_on_all_users').click(function () {
		if(jQuery("#click_on_all_users").is(":checked")){
			jQuery('.ids').prop('checked', true);	
		} else {
			jQuery(".ids").removeAttr("checked");
		}
	});
});

jQuery(document).ready(function(){
	jQuery("#checkallVillage").click(function(){
		var checkedd =  this.checked ? true : false;
		if(checkedd){
			jQuery(".villageall option").prop('selected', true);
		}else{
			jQuery(".villageall option").removeAttr("selected");
		}
	});
	jQuery(".villageall").click(function(){							
		jQuery("#checkallVillage").removeAttr("checked");
	});
});

function functionselectCountryProjectLocation(){
	var contentid = jQuery("#countryinitial").val();
	var contentidtext = jQuery("#stateinitialtext").val();
	if(contentid!=''){
		jQuery.ajax({
			type: "POST",
			data: "contentid="+contentid+"&contentidtext="+contentidtext,
			url : URL_SITE+"/actionAjax.php?country_wise_project=1",			
			success: function(statemsg){
				jQuery("#state").html(statemsg);
				var contentid     = jQuery("#stateinitial").val();
				var contentidtext = jQuery("#districtinitialtext").val();
				jQuery('#state_'+contentid).prop('checked','true');
				jQuery.ajax({
					type: "POST",
					data: "contentid="+contentid+"&contentidtext="+contentidtext,
					url : URL_SITE+"/actionAjax.php?country_wise_project=1",			
					success: function(districtmsg){
						jQuery("#district").html(districtmsg);
						var contentid = jQuery("#districtinitial").val();
						var contentidtext = jQuery("#tehsilinitialtext").val();
						jQuery('#district_'+contentid).prop('checked','true');
						jQuery("#district").val(contentid);
						jQuery.ajax({
							type: "POST",
							data: "contentid="+contentid+"&contentidtext="+contentidtext,
							url : URL_SITE+"/actionAjax.php?country_wise_project=1",			
							success: function(tehsilmsg){
								jQuery("#tehsil").html(tehsilmsg);
								var contentid = jQuery("#tehsilinitial").val();
								var contentidtext = jQuery("#villageinitialtext").val();
								jQuery('#tehsil_'+contentid).prop('checked','true');
								jQuery("#tehsil").val(contentid);
								jQuery.ajax({
									type: "POST",
									data: "contentid="+contentid+"&contentidtext="+contentidtext,
									url : URL_SITE+"/actionAjax.php?country_wise_project=1",
									success: function(villagemsg){
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

function functionAddLocationUniversal(selectboxid,dataid,level){
	var contentid = [];
	jQuery('#'+selectboxid+' input:checkbox:checked').each(function(){
		 array = jQuery(this).val().split("-");
		 contentid.push(array[0]); 
	})
	console.log(contentid);
	var previousContentid = jQuery('#uncommonstringid').val();	
	if(contentid!=''){
		jQuery(".content_seleted_farmer_remove").remove();
		jQuery("#removevillageotherid").remove();
		jQuery('#'+dataid+'').addClass('fadeLoader');
		jQuery.ajax({
			type: "POST",
			data: "contentid="+contentid+"&previousContentid="+previousContentid+"&selectboxid="+selectboxid+"&dataid="+dataid,
			url : URL_SITE+"/actionAjax.php?selected_content_wise=1",			
			success: function(univarsaldata){
				jQuery('#uncommonstringid').val(contentid);
				jQuery('#'+dataid+'').removeClass('fadeLoader');
				jQuery('#'+dataid+'').html(univarsaldata).show();
				if(dataid =='villagedata'){
					jQuery('#villagedata').css('style','max-height: 400px');
				}
			}
		});
	}else{
		return false;
	}
}

function functionsetunsetrequried(sourceid,destinationid){

	if(sourceid == 'allvillagereport'){
		if(jQuery('#'+sourceid+'').is(":checked")){
			if(jQuery('#'+destinationid+'').hasClass("required")){
				jQuery('#'+destinationid+'').removeClass("required");
				jQuery('#'+destinationid+'').removeClass("error");
				jQuery('#hideselectallvillagediv').hide();	
				jQuery("#checkallVillage").removeAttr("checked");
				jQuery(".villageall option").removeAttr("selected");
			}
		} else {
			if(!jQuery('#'+destinationid+'').hasClass("required")){
				jQuery('#'+destinationid+'').addClass("required");
				jQuery('#hideselectallvillagediv').show();
			}
		}
	}else{
		if(jQuery('#'+sourceid+'').is(":checked")){
			if(jQuery('#'+destinationid+'').hasClass("required")){
				jQuery('#'+destinationid+'').removeClass("required");
				jQuery('#'+destinationid+'').removeClass("error");
			}
		} else {
			if(!jQuery('#'+destinationid+'').hasClass("required")){
				jQuery('#'+destinationid+'').addClass("required");
			}
		}
	}
}