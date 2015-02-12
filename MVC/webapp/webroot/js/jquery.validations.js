jQuery(document).ready(function(){

	/*FRONT END **********************************************************/

	jQuery('#farmerregistrationform').validate({
		
		onkeyup: false,
		onclick: false,
		onchange:true,

		rules:{
			"alteno":{
				remote: "check_availability.php",
			},
			"phone":{
				remote:"check_availability.php"
			},
			"landlineno":{
				remote:"check_availability.php"
			}
		},
		messages:{
			"alteno":{
				remote: jQuery.format("Already exists.")
			},
			"phone":{
				remote: jQuery.format("Already exists.")
			},
			"landlineno":{
				remote: jQuery.format("Already exists.")
			}
		}
	});
	
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

	//kisanorg@kisansanchar.org@ftp.kisansanchar.org:/upload_forms.php
	jQuery('#uploadrawfarmerformbyagentform').validate();

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
	
	//FILE LOCATION: ../admin/addsmstype.php
	jQuery('#addsmstypeform').validate();
	
	//FILE LOCATION: ../admin/addCategory.php
	jQuery('#addcategoryformsforms').validate();

	//FILE LOCATION: ../admin/addStatusMsg.php
	jQuery('#addStatusMsgformsforms').validate();

	//FILE LOCATION: ../admin/addProject.php
	jQuery('#addprojectforms').validate();

	//FILE LOCATION: ../admin/addProject.php
	jQuery('#addgroupforms').validate();

	//FILE LOCATION: ../admin/addProject.php
	jQuery('#editgroupforms').validate();

	//FILE LOCATION: ../ivrCampaignReport-farmer-wise.php
	jQuery('#ivrCampaignReportform').validate();

	//FILE LOCATION: ../ivrCampaignReport-farmer-wise.php
	jQuery('#ivrCampaignReportfilterform').validate();

	//FILE LOCATION: ../admin/add-pincode-detail.php
	jQuery('#addpincodedetailform').validate();

	//FILE LOCATION: ../admin/form_element_settings.php
	jQuery('#addformementsettingsform').validate();

    //FILE LOCATION: ../admin/form_element_settings.php
	jQuery('#editformementsettingsform').validate();
	
	//FILE LOCATION: ../admin/filter_farmer_data.php
	jQuery('#uploaduniquerecordform').validate();

	/* /ADMIN END **********************************************************/

});