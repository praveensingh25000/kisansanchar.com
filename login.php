<?php
/******************************************
* @Created on JAN 27, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/
?>
<form action="javascript:;" method="post" id="frontuserloginform" name="frontuserloginform">		

	<div class="wdthpercent100">
		
		<div class="wdthpercent100">
			<div class="pB5"><?php echo $langVariables['form_var']['username_phone']?></div>
			<div class="">
			   <input placeholder="enter phone or email" type="text" id="username" name="username" class="required"/>
			</div>
		</div>
		<div class="clear pB10"></div>

		<div class="wdthpercent100">
			<div class="pB5"><?php echo $langVariables['form_var']['password']?></div>
			<div class="">
			   <input placeholder="enter password" type="password" id="password" name="password" class="required"/>
			</div>

			<span class="pT5 pB5">
				<a id="forgot-password-click" class="forgot" href="javascript:;">forgot password?</a>
			</span>
		<div class="clear"></div>
		</div>
		
		<div class="wdthpercent100">
			<div class="">&nbsp;</div>
			<div class="">
				<span class=""><input class="button" type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset"></span>
				<span class="pL10"><input class="button" type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="clickuserLogin"></span>
				<span id="loader_login"></span>
			</div>
		</div>
		<div class="clear"></div>
	
	</div> 

</form>	

<div id="forgot-password-link" style="display:none;">
	<?php include_once($DOC_ROOT.'forgot-password.php');?>
</div>	
<div class="clear"></div>