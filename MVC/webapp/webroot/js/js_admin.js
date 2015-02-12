/******************************************
* @Created on AUG 30, 2014
* @Package: Adopt Mobile Survey
* @Developer: Praveen Singh
* @URL : http://adoptmobilesurvey.com/
********************************************/

function goBack() {
	window.history.go(-1);
}

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

function loadershow(){
	jQuery.blockUI({
		message:'<span class="processing"></span>', 
		css: {
			position:'fixed',border: 'none',width:'34%',top:'45%',left:'31%',padding:'1px',backgroundColor:'none','-webkit-border-radius':'10px','-moz-border-radius': '10px', opacity:'1.0',font:'30px', color: '#000' 
		}
	});
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
				jQuery("#aprrove_dissaprove_div_"+unique_div_id).html(msg);
				succuss(msg);
			}					
		});
	} else {
		return false;
	}
}

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

function functionDownloadUniqueData(formid,startlimit,endlimit){

	var pass_msg = jQuery('#'+formid+'').valid();
	if(pass_msg == false){
		return false;
	} else {
		var startlimit = jQuery('#'+startlimit+'').val();
		var endlimit   = jQuery('#'+endlimit+'').val();

		window.location = URL_SITE+"/admin/download_unique_farmer_data.php?type=excel&startlimit="+startlimit+"&endlimit="+endlimit;
	}

}

function functionDownloadRawFormData(form_id){
	if(form_id){
		jQuery("#loader_"+form_id).addClass('sLoader');
		jQuery.ajax({
			type: "POST",
			data: "form_id="+form_id,
			url : URL_SITE+"/admin/actionAjax.php?download_raw_form=1",			
			success: function(msg){
				jQuery("#loader_"+form_id).removeClass('sLoader');
				var obj      = jQuery.parseJSON(msg);
				if(obj.error == '0'){
					error(obj.message);
				}else{
					jQuery("#status_"+form_id).html(obj.data);
					window.location = URL_SITE+'/uploads/rawForms/'+obj.userid+'/'+obj.form_name;
					return true;
				}			
			}							
		});
	}else{
		return false;
	}	
}

function functionFarmerProjectLocationUniversal(selectboxid, dataid, type){
	var contentid    = jQuery('#'+selectboxid+'').val();	
	var datatransfer = "contentid="+contentid;	
	if(contentid!=''){
		loadershow();
		jQuery('#'+selectboxid+'').after('<span class="spanloader">&nbsp;</span>');
		jQuery.ajax({
			type: "POST",
			data: datatransfer,
			url : URL_SITE+"/admin/actionAjax.php?adding_record_india_table=1&type="+type,			
			success: function(univarsaldata){
				loader_unshow();
				jQuery('.spanloader').remove();
				jQuery(".content_seleted_farmer_remove").remove();
				jQuery('#'+selectboxid+dataid+'').html(univarsaldata);		
			}	
		});		
	}else{
		return false;
	}
}