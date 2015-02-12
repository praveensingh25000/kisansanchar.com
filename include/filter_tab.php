<div class="wdthpercent100 tabnav">			
	<form id="selectLanguageTypeMessageTypeForm" name="selectLanguageTypeMessageTypeForm" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
		<div class="wdthpercent34 left">			
			<div class="dayfilter">
				<select class="" id="day" name="day">
				   <?php foreach($day_option as $key => $value){?>
					  <option value="<?php echo $value['id'];?>" <?php if(isset($day) && $day == $value['id']){ echo "selected='selected'"; } ?>><?php echo $value['name'];?></option>
				   <?php } ?>						   
				</select>
			</div>
			<div class="monthfilter">
				<select class="" id="month" name="month">
				   <?php foreach($month_option as $key => $value){?>
					  <option value="<?php echo $key;?>" <?php if(isset($month) && $month == $key){ echo "selected='selected'";}?>><?php echo $value;?></option>
				   <?php } ?>						   
				</select>
			</div>			
			<div class="yearfilter">
				<select class="" id="year" name="year">
				   <?php foreach($year_option as $key => $value){?>
					  <option value="<?php echo $value['id'];?>" <?php if(isset($year) && $year == $value['id']){ echo "selected='selected'"; } ?> > <?php echo $value['name'];?></option>	       
				   <?php } ?>						   
				</select>
			</div>
		</div>		
		<div class="lanfilter">
		   <?php if(!empty($languageArray)) { ?>
				<select id="language_type" name="language_type">
					<!-- <option <?php if(isset($language_type) && $language_type=='all') { echo 'selected="selected"';}?> value="all">Languages</option> -->
					<?php foreach($languageArray as $language) { ?>
						<option value="<?php echo $language['name'];?>" <?php if(isset($language_type) && $language_type == $language['name']){ echo "selected='selected'"; } ?> ><?php echo ucwords(strtolower($language['value']));?></option>
					<?php } ?>							
				</select>						
			<?php } ?>					
		</div>
		<div class="mediafilter">
			<select class="wdthpercent100 left" id="message_type" name="message_type">
				<option <?php if(isset($message_type) && $message_type=='all') { echo 'selected="selected"';}?> value="all">Select Channel</option>
				<option <?php if(isset($message_type) && $message_type=='andriod') { echo 'selected="selected"';}?> value="andriod"><?php echo $langVariables['msg_var']['andriod_channel'];?></option>
				<option <?php if(isset($message_type) && $message_type=='sms') { echo 'selected="selected"';}?> value="sms"><?php echo $langVariables['msg_var']['sms_channel'];?></option>				
			</select>
		</div>
		
		<?php if(isset($sectionType) && $sectionType=='front'){?>
			<?php if(isset($_SESSION['filter_data']) || isset($_SESSION['parent_subcategory'])){?>
			<div class="mediafilter pL20 pB5">
				<a onclick="javascript: functionRemoveFilterSubCategory('<?php echo $_SERVER['REQUEST_URI'];?>')" href="javascript:;"><input class="button" type="button" value="Reset Filter"></a>
			</div>	
			<?php } ?>
		<?php } ?>

		<?php if(isset($sectionType) && $sectionType=='admin'){?>
		<div class="mediafilter">			
			<select class="wdthpercent100 left" id="status" name="status">
				<option <?php if(isset($status) && $status=='all') { echo 'selected="selected"';}?> value="all">All Status</option>
				<option <?php if(isset($status) && $status=='1') { echo 'selected="selected"';}?> value="1">Broadcasted</option>
				<option <?php if(isset($status) && $status=='0') { echo 'selected="selected"';}?> value="0">Unbroadcasted</option>				
			</select>
		</div>			
		<?php } ?>

	</form>
</div>
<br class="clear" />