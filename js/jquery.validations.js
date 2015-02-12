jQuery(document).ready(function(){

	/*FRONT END **********************************************************/
	
	jQuery('#frontuserloginform').validate();
	jQuery('#userSmsAndriodMessagePostingForm').validate();
	jQuery('#userprivicysettingform').validate();
	
	jQuery('#userregistration').validate({
		
		onkeyup: false,
		onclick: false,
		onchange:true,

		rules:{
			"email":{
				remote: "check_availability.php",
			},
			"phone":{
				remote:"check_availability.php"
			}
		},
		messages:{
			"email":{
				remote: jQuery.format("Already exists.")
			},
			"phone":{
				remote: jQuery.format("Already exists.")
			}
		}
	});
	//contactus form
	jQuery('#contactus').validate();
	
	//voice_sms.php form
	jQuery('#voicesmssendingform').validate();


	//reports.php form
	jQuery('#reports-percentage-village-wise-form').validate();
	jQuery('#reports-percentage-farmer-wise-form').validate();
	jQuery('#reports-farmer-joining-form').validate();	
	jQuery('#updateuserpassword').validate({
		rules : {
			confirmpassword : {                    
				equalTo : "#password"
			}
		}
	});
	
	//kisansan@192.186.222.198:/public_html/add-project-user.php
	jQuery('#uploadprojectuserforms').validate();

	/* /FRONT END **********************************************************/

	/*ADMIN END **********************************************************/

	jQuery('#adminformlogin').validate();
	jQuery('#addformsetting').validate();
	jQuery('#addmoduleformsetting').validate();
	jQuery('#addgroupform').validate();
	jQuery('#addadminstaffform').validate({
		
		onkeyup: false,
		onclick: false,
		onchange:true,

		rules:{
			"email":{
				remote: "check_availability.php",
			},
			"phone":{
				remote:"check_availability.php"
			}
		},
		messages:{
			"email":{
				remote: jQuery.format("Email already exists.")
			},
			"phone":{
				remote: jQuery.format("Phone number already exists.")
			}
		}
	});

	jQuery('#addparentmoduleforms').validate();
	jQuery('#addsubmoduleform').validate();
	jQuery('#updateuserprofileform').validate();
	jQuery('#textsmssendingform').validate();
	
	/*jQuery('#updateuserprofileform').validate({
		
		onkeyup: false,
		onclick: false,
		onchange:true,

		rules:{
			"email":{
				remote: {
					remote: URL_SITE+"/admin/check_availability.php?adminend=1",
					type: "POST",
					data: {
						email: function() {
							return $( "#email" ).val();
						},
						oldemail: function() {
							return $( "#oldemail" ).val();
						}
					}
						
				}
			},
			"phone":{
				minlength: 6,
				remote: {
					remote: URL_SITE+"/admin/check_availability.php?adminend=1",
					type: "POST",
					data: {
						phone: function() {
							return $( "#phone" ).val();
						},
						oldphone: function() {
							return $( "#oldphone" ).val();
						}
					}
				}
			}
		},
		messages:{
			"email":{
				remote: jQuery.format("Email already exists")
			},
			"phone":{
				minlenght: "phone should be of 10 digits",
				remote: jQuery.format("phone already exists")
			}
		}
	});
	*/
	
	//FILE LOCATION: ../admin/addsmstype.php
	jQuery('#addsmstypeform').validate();
	
	//FILE LOCATION: ../admin/addCategory.php
	jQuery('#addcategoryformsforms').validate();

	//FILE LOCATION: ../admin/addStatusMsg.php
	jQuery('#addStatusMsgformsforms').validate();

	//FILE LOCATION: ../admin/addProject.php
	jQuery('#addprojectforms').validate({
		
		onkeyup: false,
		onclick: false,
		onchange:true,

		rules:{
			"email":{
				remote: "check_availability.php",
			},
			"phone":{
				remote: "check_availability.php"
			}
		},
		messages:{
			"email":{
				remote: jQuery.format("Already exists.")
			},
			"phone":{
				remote: jQuery.format("Already exists.")
			}
		}
	});

	//FILE LOCATION: ../admin/addProject.php
	jQuery('#addgroupforms').validate();

	//FILE LOCATION: ../admin/addProject.php
	jQuery('#editgroupforms').validate();

	//FILE LOCATION: ../admin/addReportSmsGroup.php
	jQuery('#addreportgroupforms').validate();

	//FILE LOCATION: ../admin/addReportSmsGroupMember.php
	jQuery('#addreportgroupmemberforms').validate();
	
	//kisansan@192.186.222.198:/public_html/create-group-popup.php
	jQuery('#addreportgroupformspopup').validate();


	/* /ADMIN END **********************************************************/

});