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
			textAlign:'left',position:'fixed',border: '2px solid #70A300',width:'98%',top:'0%',left:'0%',padding:'10px',backgroundColor:'#FFF','-webkit-border-radius':'10px','-moz-border-radius': '10px', opacity:'1.0',font:'30px', color: '#000', minHeight: '100px'
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
	jQuery("#profile-login").hover(function(){		
		jQuery(".notification").remove();
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
					var obj = jQuery.parseJSON(msg);
					if(obj.error == '0'){
						jQuery('#Pagecontent').removeClass("fadeLoader");
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

function add_percentage_function(tableID){
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

function delete_percentage_function(tableID){
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
						jQuery('#submitid').attr({'type':'submit'});
						jQuery('#submitid').removeClass('fadeLoader');
						jQuery('#submitid').val('Submit');
						jQuery('#reset').show();
						headerLoaderMessage(obj.message);
					}else{
						headerLoaderMessage(obj.message);
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

function FunctionSelectContentType(formid,attributeid){
	jQuery('#'+formid+'').submit();
	return true;
}

function FunctionSelectContentPopUp(attributeid){
	blockUI_divid(attributeid);
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

function FunctionEditUniversal(contentid, loaderdivid,ajaxrequestvar){
	if(contentid){
		jQuery('#'+loaderdivid+contentid+'').addClass('sLoader');
		jQuery.ajax({
			type: "POST",
			data: "contentid="+contentid,
			url : URL_SITE+"/uploadAjax.php?"+ajaxrequestvar+"=1",	
			success: function(msg){
				jQuery('#'+loaderdivid+contentid+'').removeClass('sLoader');				
				BLOCKUI_MSG_OBJECT(msg);										
			}
		});
	} else {
		return false;
	}	
}

jQuery(document).ready(function(){
	$( "#fromdate" ).datepicker({ dateFormat: "yy-mm-dd" });
	$( "#todate" ).datepicker({ dateFormat: "yy-mm-dd" });
});

jQuery(document).ready(function(){
	$( "#from_filter" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$( "#to_filter" ).datepicker({ dateFormat: 'yy-mm-dd' });
});


jQuery(document).ready(function(){
	jQuery("#ivrCampaignReportfilterform").submit(function(e){
		e.preventDefault();
		var from_filter  = $('#from_filter').val();
		var to_filter    = $('#to_filter').val();
	
		if(!from_filter && !to_filter){
			return false;
		} else{
			jQuery("#ivrCampaignReportfilterform").addClass("fadeLoader");
			jQuery("#append_after_this_farmer_wise_form").addClass("fadeLoader");
			jQuery.ajax({
				type: "POST",
				data: jQuery("#ivrCampaignReportfilterform").serialize(),
				url : URL_SITE+"/actionAjax.php?selected_farmer_report_form=1",				
				success: function(msg) {
					jQuery("#ivrCampaignReportfilterform").removeClass("fadeLoader");	
					jQuery("#append_after_this_farmer_wise_form").removeClass("fadeLoader");
					var obj = jQuery.parseJSON(msg);
					if(obj.error == '0'){
						scrollTop();	
						jQuery("#append_after_this_farmer_wise_form").html(obj.data).show();
						error(obj.message);
					}else{
						jQuery("#append_after_this_farmer_wise_form").html(obj.data).show();
					}
				}							
			});
		}
	});
});

function FunctionActionUniversal(contentid,is_active, removedivid, loaderdiv,ajaxrequestvar){
	if(confirm("Are you sure to perform this action?")){
		if(contentid){
			jQuery('#'+loaderdiv+contentid+'').addClass('sLoader');
			jQuery.ajax({
				type: "POST",
				data: "contentid="+contentid+"&removedivid="+removedivid+"&is_active="+is_active,
				url : URL_SITE+"/actionAjax.php?"+ajaxrequestvar+"=1",	
				success: function(msg){
					jQuery('#'+loaderdiv+contentid+'').removeClass('sLoader');
					if(ajaxrequestvar == 'remove_action'){
						jQuery('#'+removedivid+contentid+'').remove();
						succuss(msg);
					}					
					if(ajaxrequestvar == 'active_inactive_action'){
						jQuery('#'+removedivid+contentid+'').html(msg).show();
						succuss('Enter has been updated.');
					}					
				}
			});
		} else {
			return false;
		}
	}
}

function FunctionUniversalToggle(divid){
	jQuery('#'+divid+'').toggle('slow');
}

function functionRawFarmerAreaUniversal(selectboxid, dataid, type){
	var contentid = jQuery('#'+selectboxid+'').val();
	var datatransfer = "contentid="+contentid;	
	if(contentid!=''){
		jQuery('#'+selectboxid+dataid+'').html('<div class="wdthpercent40 left">&nbsp;</div><div class="wdthpercent30 left green">Loading....</div><div class="clear"></div>').show();
		jQuery.ajax({
			type: "POST",
			data: datatransfer,
			url : URL_SITE+"/actionAjax.php?raw_farmer_country_wise=1&type="+type,			
			success: function(univarsaldata){
				jQuery('.spanloader').remove();
				jQuery(".content_seleted_farmer_remove").remove();
				jQuery('#'+selectboxid+dataid+'').html(univarsaldata).show();		
			}	
		});		
	}else{
		return false;
	}
}

function functionFilterDownloadFarmerUniversal(selectboxid, dataid, type){
	var contentid = jQuery('#'+selectboxid+'').val();
	if(contentid!=''){
		if(type != 'none'){
		jQuery('#'+selectboxid+'').after('<span class="spanloader">&nbsp;</span>');
		}
		jQuery.ajax({
			type: "POST",
			data: "contentid="+contentid,
			url : URL_SITE+"/actionAjax.php?filter_download_wise=1&type="+type,			
			success: function(univarsaldata){
				jQuery('.spanloader').remove();
				jQuery('#'+selectboxid+dataid+'').html(univarsaldata);		
			}	
		});		
	}else{
		return false;
	}
}

function toggleUniversal(dividname,classname,type,textchangeidname){
	if(type =='class'){
		var togglename = classname;
		jQuery('.'+togglename+'').toggle('slow');
	}else{
		var togglename = dividname;
		jQuery('#'+togglename+'').toggle('slow');
	}
	if(jQuery('#'+textchangeidname+'').hasClass('openform')){
		jQuery('#'+textchangeidname+'').removeClass('openform');
		jQuery('#'+textchangeidname+'').addClass('closeform');
		jQuery('#'+textchangeidname+'').html('Close Filter Form');
	}else{
		jQuery('#'+textchangeidname+'').removeClass('closeform');
		jQuery('#'+textchangeidname+'').addClass('openform');		
		jQuery('#'+textchangeidname+'').html('Open Filter Form');
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

jQuery(document).ready(function(){
	jQuery("#filter_download_form").submit(function(e){		
		e.preventDefault();			
		var pass_msg = jQuery("#filter_download_form").valid();
		
		//some validations
		if(pass_msg == false){
			return false;
		} else {
			jQuery('#submitid').addClass('sLoader');
			jQuery.ajax({
				type: "POST",
				data: jQuery("#filter_download_form").serialize(),
				url : URL_SITE+"/actionAjax.php?filter_download_form=1",
				success: function(msg) {
					jQuery('#submitid').removeClass('sLoader');
					var obj = jQuery.parseJSON(msg);
					if(obj.error == '0'){
						scrollTop();
						error(obj.message);
					}else{
						window.location=URL_SITE+jQuery.trim(obj.url);	
					}
				}
			});
		}
	});
});