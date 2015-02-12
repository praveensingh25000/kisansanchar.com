<div class="wdthpercent100 pT10 pB10">	
	<form method="post" action="voice_sms_action.php" name="voicesmssendingform" id="voicesmssendingform" enctype="multipart/form-data">
		
		<div class="wdthpercent100 pT10 pB10">
			<div class="wdthpercent30 left"> Project Name</div>
			<div class="wdthpercent68 left user">
				<?php if(!empty($projectDetail)) { echo $projectDetail['user_type'].' User';} else {echo 'Project User';}?>	
				<input name="user_type" type="hidden" value="<?php if(!empty($projectDetail)) { echo $projectDetail['id'];}else {echo '17';}?>">
				<input name="message_type" type="hidden" value="<?php if(isset($channel_id)) { echo $channel_id;}?>">
				<input name="user_id" type="hidden" value="<?php if(isset($_SESSION['session_user_data']['id'])) { echo $_SESSION['session_user_data']['id'];}?>">
			</div>
		</div>
		<div class="clear"></div>

		<?php if(!empty($messagestatusDetail)) { ?>					
		<div class="wdthpercent100 pT10 pB10">
			<div class="wdthpercent30 left">Select Status Category</div>
			<div class="wdthpercent70 left">
				<select class="wdthpercent100 required" id="status_type" name="status_type">
					<option value="">Select Status Category</option>
					<?php foreach($messagestatusDetail as $key => $category){ ?>
						<option value="<?php echo $category['id']; ?>" <?php if(isset($parentcat) && $parentcat == $category['id']){ echo "selected=selected"; } ?>><?php echo $category['message_status_name']; ?></option>
					<?php } ?>
				</select>
				<div id="loader" style="display:none;"></div>
			</div>						
		</div>
		<div class="clear"></div>
		<?php } ?>
		
		<?php if(!empty($categoryDetail) && !defined('IS_PROJECT_ID')) { ?>			
		<div class="wdthpercent100 pT10 pB10">
			<div class="wdthpercent30 left"><?php echo $langVariables['category_var']['select_category'];?></div>
			<div class="wdthpercent70 left">
				<select onchange="javascript: functiongetGenSubCategory('parent_category','sub_category');"  class="wdthpercent100 required" id="parent_category" name="parent_category">
					<option value=""><?php echo $langVariables['category_var']['select_category'];?></option>
					<?php foreach($categoryDetail as $key => $category){ ?>
						<option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
					<?php } ?>
				</select>							
			</div>						
		</div>
		<div class="clear"></div>

		<div id="parent_category_sub_show" class="wdthpercent100 pT10" style="display:none;">	
		</div>
		<div class="clear"></div>

		<?php } ?>

		<?php if(!empty($categoryDetail) && defined('IS_PROJECT_ID')) { ?>
		<div class="wdthpercent100 pT10 pB10">
			<div class="wdthpercent30 left">Select C Category</div>
			<div class="wdthpercent70 left">
				<select onchange="javascript: functiongetSubCategory('c_parent_category','c_sub_category');"  class="wdthpercent100 required" id="c_parent_category" name="c_parent_category">
					<option value="">Select C Category</option>
					<option value="261">C Category</option>								
				</select>							
			</div>						
		</div>
		<div class="clear"></div>

		<div id="c_parent_category_sub_show" class="wdthpercent100 pT10" style="display:none;">	
		</div>
		<div class="clear"></div>

		<div class="wdthpercent100 pT10 pB10">
			<div class="wdthpercent30 left">Select G Category</div>
			<div class="wdthpercent70 left">
				<select onchange="javascript: functiongetSubCategory('g_parent_category','g_sub_category');"  class="wdthpercent100 required" id="g_parent_category" name="g_parent_category">
					<option value="">Select G Category</option>
					<option value="275">G Category</option>								
				</select>							
			</div>						
		</div>
		<div class="clear"></div>

		<div id="g_parent_category_sub_show" class="wdthpercent100 pT10" style="display:none;">	
		</div>
		<div class="clear"></div>

		<?php } ?>

		<div id="parent_category_sub_show" class="wdthpercent100 pT10" style="display:none;">	
		</div>
		<div class="clear"></div>

		<div class="wdthpercent100 pT10">
			<!-- call transliterate service -->
			<?php require_once($DOC_ROOT.'api/googleTranslateMessage.php');?> 
			<!-- call transliterate service -->
		</div>
		<div class="clear"></div>

		<div class="wdthpercent100 pT10">
			<div class="wdthpercent30 left">Select voice type</div>
			<div class="wdthpercent70 left">
				<select class="wdthpercent100 required" id="voice_type" name="voice_type">
					<option value="">Select voice type</option>	
					<?php if(defined('PROJECTDASHBORD')){?>
					<option value="bulk">Bulk</option>
					<option value="group">Group</option>
					<?php } else if(defined('FRONT_USER_ID') && FRONT_USER_ID=='1503'){?>
					<option value="bulk">Bulk</option>
					<option value="group">Group</option>
					<?php }else if(!defined('PROJECTDASHBORD')){?>
					<option value="group">Group</option>
					<?php } ?>
				</select>
			</div>
			<div class="clear pB10"></div>			
		</div>
		
		<div id="bulk_group_type_content"></div>	
		
		<div class="wdthpercent100 pT10 pB10">
			<div class="wdthpercent30 left"> Select Message Date</div>
			<div class="wdthpercent68 left">				
				<input type="text" id="date_voice" name="date" class="wdthpercent100 required">
				<script type="text/javascript">
				jQuery(document).ready(function(){jQuery('#date_voice').datetimepicker({format:'Y-m-d H:i:s'});});
				</script>
			</div>
		</div>
		<div class="clear"></div>

		<div class="wdthpercent100 pT10 pB10">				
			<span class="right">
			<input class="button" id="submitid" onclick="javascript:ShowSubmitTextGlobal('submitid','reset','voicesmssendingform');" type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="submit">
			<input type="hidden" value="1" name="submitvoicemessage">
			<input type="hidden" id="project_id" name="project_id" value="<?php echo (defined('IS_PROJECT_ID'))?IS_PROJECT_ID:'0'?>" />
			</span>
			<span class="right pR20"><input class="button" type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset"></span>
		</div>
		<div class="clear"></div>

	</form>

</div>