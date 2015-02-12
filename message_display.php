<?php if(!empty($message['message'])){
	$msgArray = explode(' ',$message['message']);
	if(isset($msgArray)&& count($msgArray)>150){
		$msgArrayShort = array_slice($msgArray,0,150);
		$msgStr        = implode(' ',$msgArrayShort);
		$stackLimiter  = 1;
	}else{
		$msgStr = implode(' ',$msgArray);
	}
	if(isset($msgStr) && isset($stackLimiter)){?>
		<?php  echo stripslashes($msgStr).'...';?>
		<br/>
		<a onclick="javascript: view_all('<?php echo $content_type;?>','<?php echo $message['id'];?>','<?php echo $unique_div_id;?>');" class="blue" href="javascript:;">View More..<span class="pL30" id="loader<?php echo $unique_div_id;?>"></span></a>
	<?php } else { ?>
	   <?php  echo stripslashes($msgStr);?>
	<?php } ?>
<?php } ?>