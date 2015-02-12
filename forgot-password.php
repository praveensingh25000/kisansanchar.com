<div class="wdthpercent100 pT10 pB10">
    <div class="wdthpercent100">
		<div class="right">
			<a class="fontbld" onclick="javascript:loader_unshow();" href="javascript:;">Close</a>
		</div>		
    </div>
	<div class="clear pB10"></div>
	
	<form action="" method="post" id="forgot-password-form" enctype="multipart/form-data">
	
		<div id="" class="wdthpercent100">	
			<div class="wdthpercent30 left">Enter your email</div>
			<div class="wdthpercent60 left">
				<input placeholder="enter email" type="text" id="email" name="email" class="wdthpercent90 required"/>
				<span id="loader_forgot"></span>
			</div>
			<div class="clear pB10"></div>
		</div>

		<div id="" class="wdthpercent100">	
			<div class="wdthpercent30 left">&nbsp;</div>
			<div class="wdthpercent70 left">
				<span class=""><input class="button" type="reset" value="<?php echo $langVariables['form_var']['reset']?>" id="reset"></span>
				<span class="pL10"><input class="button" type="submit" value="<?php echo $langVariables['form_var']['submit']?>" name="sendpasswordemail"></span>
			</div>
			<div class="clear"></div>
		</div>

		<div class="wdthpercent100">	
			<div id="succuss-message"></div>			
			<div class="clear"></div>
		</div>



		

	</form>

</div>