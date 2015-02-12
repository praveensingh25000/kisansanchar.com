<?php if(isset($file_type) && $file_type=='photo'){?>
	<?php if(isset($file_url) && $file_url!=''){?>
	<!-- MEDIA DIV -->
	<div id="<?php echo $file_type;?><?php echo $unique_div_id;?>" class="timeline pB10">		
		<img class="media" title="<?php echo $file;?>" alt="<?php echo $file;?>" src="<?php echo $file_url;?>" />						
	</div>								
	<!-- /MEDIA DIV -->
	<?php } ?>
<?php } ?>

<?php if(isset($file_type) && $file_type=='audio') {?>
	<?php if(isset($file_url) && $file_url!=''){?>
	<!-- MEDIA DIV -->
	<audio id="<?php echo $file_type;?><?php echo $unique_div_id;?>" controls="controls">
	  <source src="<?php echo URL_SITE;?><?php echo $file_url;?>" type="<?php echo $file_type;?>/<?php echo $action_div_type;?>">					  
	  Your browser doesn't support <?php echo $file_type;?>
	</audio>				
	<!-- /MEDIA DIV -->
	<?php } ?>
<?php } ?>

<?php if(isset($file_type) && $file_type=='video') {?>
	<?php if(isset($file_url) && $file_url!=''){?>
	<!-- MEDIA DIV -->
	<video id="<?php echo $file_type;?><?php echo $unique_div_id;?>" width="320" height="240" controls="controls">
	  <source src="<?php echo URL_SITE;?><?php echo $file_url;?>" type="<?php echo $file_type;?>/<?php echo $action_div_type;?>">					  
	  Your browser doesn't support <?php echo $file_type;?>
	</video>				
	<!-- /MEDIA DIV -->
	<?php } ?>
<?php } ?>

<?php if(isset($file_type) && $file_type=='embeddedUrl') {?>
	<?php if(isset($file_url) && $file_url!=''){?>
	<!-- MEDIA DIV -->
		<?php echo $file_url;?>
	<!-- /MEDIA DIV -->
	<?php } ?>
<?php } ?>