<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
*******************************************/
?>	

<div class="wdthpercent100">
	<div id="errordisplaydiv" class="pT5 pB5"></div>

	<div class="right">
		<a class="close" onclick="javascript:loader_unshow();" href="javascript:;"></a>		
	</div>

	<div class="pT10 pB10" id="contendsmsgroupdivdisplay">

		<form action="" method="post" id="addreportgroupformspopup" name="addreportgroupformspopup">	
			
			<div class="wdthpercent100 pT10 pB10">
				<div class="wdthpercent40 left">SMS Group Name</div>
				<div class="wdthpercent60 left">
				   <input placeholder="Group Name" type="text" id="group_name" name="group_name" class="wdthpercent80 required" value="<?php if(isset($group_name)){ echo $group_name;} ?>" /><br>
				</div>
			</div>
			<div class="clear"></div>

			<div class="wdthpercent100 pT10 pB10">
				<div class="wdthpercent40 left">SMS Group Status</div>
				<div class="wdthpercent60 left">
				   <input placeholder="Group Status" type="text" id="is_active" name="is_active" class="wdthpercent80 required" value="1" /><br>
				</div>
			</div>
			<div class="clear pB10"></div>

			<div class="wdthpercent100 pT10 pB10">
				<div class="wdthpercent40 left">&nbsp;</div>
				<div class="wdthpercent60 left">						
					<span class="">
						<input type="submit" class="button" value="<?php echo $langVariables['form_var']['submit']?>" id="submitbutton" name="submitreportgroupmembersforms">
					</span>
					<span class="pL40">
						<input type="hidden" name="owner_id" value="<?php echo $front_user_id;?>">
						<input type="hidden" name="date" value="<?php echo $current_date;?>">
						<input type="button" id="closebutton" class="button" value="Close" onclick="javascript:loader_unshow();" id="reset">
					</span>					    					  
				</div>
			</div>
			<div class="clear"></div>
			<script type="text/javascript">
			//public_html/dev/api/googleTranslateSearch.php
			jQuery(document).ready(function(){
				jQuery("#addreportgroupformspopup").submit(function(e){		
					e.preventDefault();	
					var valid = jQuery("#addreportgroupformspopup").valid();		
					if(!valid){
						return false;
					} else{
						jQuery("#errordisplaydiv").html('').hide();
						jQuery("#submitbutton").val("Please Wait..");
						jQuery("#closebutton").hide();
						loader_show();
						jQuery.ajax({
							type: "POST",
							data: jQuery("#addreportgroupformspopup").serialize(),
							url : URL_SITE+"/actionAjax.php?addingsmsgroupname=1",				
							success: function(msg) {
								jQuery("#errordisplaydiv").addClass('txtcenter fontbld');
								var obj = jQuery.parseJSON(msg);
								if(obj.error == '0'){
									jQuery("#errordisplaydiv").removeClass('green');
									jQuery("#errordisplaydiv").addClass('red');
									jQuery("#errordisplaydiv").html(obj.message).show();	
									jQuery("#submitbutton").val("Submit");
									jQuery("#closebutton").show();
								}else{
									jQuery("#errordisplaydiv").addClass('green');
									jQuery("#errordisplaydiv").removeClass('red');
									jQuery("#errordisplaydiv").html(obj.message).show();
									jQuery("#contendsmsgroupdivdisplay").html(obj.data);	
								}
							}							
						});
					}
				});
			});
			</script>

		</form>	
	</div>
</div>