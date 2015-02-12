<div class="contentdiv" id="">
	<a id="load_more_message" href="javascript:;" onclick="javascript: return Pagination('<?php echo $tablenamemsg;?>');">
		Load More Message&nbsp;<span class="id-load-total-display"></span>
		<input type="hidden" name="startLimit" id="startLimit" value="<?php echo $endLimit+1;?>">
		<input type="hidden" name="endLimit" id="endLimit" value="<?php echo $endLimit;?>">
		<input type="hidden" name="totalMsg" id="totalMsg" value="<?php echo $totalMsg;?>">
		<input type="hidden" name="message_type" id="message_type" value="<?php echo $message_type;?>">
		<input type="hidden" name="language_type" id="language_type" value="<?php echo $language_type;?>">
		<input type="hidden" name="user_privacy_settings" id="user_privacy_settings" value='<?php echo $user_privacy_settings_sql;?>'>
		<input type="hidden" name="day" id="day" value="<?php echo $day;?>">
		<input type="hidden" name="month" id="month" value="<?php echo $month;?>">
		<input type="hidden" name="year" id="year" value="<?php echo $year;?>">
		<input type="hidden" name="sectionType" id="sectionType" value="<?php echo $sectionType;?>">
		<input type="hidden" name="commenting_status" id="commenting_status" value="<?php echo $commenting_status;?>">
		<input type="hidden" name="parent_subcategory" id="parent_subcategory" value="all">
		<input type="hidden" name="edit_setter_var" id="edit_setter_var" value="<?php echo $edit_setter_var;?>">
		<input type="hidden" name="categoryCondition" id="categoryCondition" value="<?php echo $categoryCondition;?>">
		<input type="hidden" name="messagetagsetCondition" id="messagetagsetCondition" value="<?php echo $messagetagsetCondition;?>">
		<input type="hidden" name="status" id="status" value="<?php echo $status;?>">
	</a>
</div>
<script type="text/javascript">
<!--
function Pagination(tablename) {			
	var startLimit = Number(jQuery('#startLimit').val());
	var totalMsg   = Number(jQuery("#totalMsg").val());
	var endLimit   = Number(jQuery('#endLimit').val());
	if(totalMsg > startLimit){
		var status			       = jQuery("#status").val();
		var message_type		   = jQuery('#message_type').val();
		var language_type		   = jQuery("#language_type").val();
		var user_privacy_settings  = jQuery("#user_privacy_settings").val();
		var day					   = jQuery('#day').val();
		var month		           = jQuery("#month").val();
		var year                   = jQuery("#year").val();
		var sectionType            = jQuery("#sectionType").val();
		var commenting_status      = jQuery("#commenting_status").val();
		var parent_subcategory     = jQuery("#parent_subcategory").val();
		var edit_setter_var        = jQuery("#edit_setter_var").val();
		var categoryCondition      = jQuery("#categoryCondition").val();
		var messagetagsetCondition = jQuery("#messagetagsetCondition").val();
		jQuery('.id-load-total-display').addClass('cLoader');
		jQuery.ajax({
			type: "POST",
			data: "startLimit="+startLimit+"&endLimit="+endLimit+"&tablename="+tablename+"&language_type="+language_type+"&message_type="+message_type+"&user_privacy_settings="+user_privacy_settings+"&day="+day+"&month="+month+"&year="+year+"&sectionType="+sectionType+"&commenting_status="+commenting_status+"&parent_subcategory="+parent_subcategory+"&edit_setter_var="+edit_setter_var+"&categoryCondition="+categoryCondition+"&messagetagsetCondition="+messagetagsetCondition+"&status="+status,
			url : URL_SITE+"/actionAjax.php",	
			success: function(msg){
			   startLimit       = startLimit + 10;			   
			   var remainingmsg = totalMsg - startLimit;
			   if(remainingmsg<0){
				   jQuery("#load_more_message").html('No more message.').show();
			   } else {
					//jQuery('.id-load-total-display').html(remainingmsg);
					jQuery('.id-load-total-display').removeClass('cLoader');
			   }			  
			   jQuery('#startLimit').val(startLimit);			   
			   jQuery("#paginationcontent").append(msg);
			}
		});
	} else {
		jQuery("#load_more_message").html('No more message.').show();
		return false;
	}
}
//-->
</script>