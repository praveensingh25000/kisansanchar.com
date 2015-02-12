<h1 class="title">
	<?php echo $page_title;?>
	<?php if(isset($_SESSION['session_user_data']['id']) && isset($sectionType) && $sectionType=='front'){?>
		 <?php if(isset($page_link_title) && isset($page_link) && isset($page_image) && $page_link!='' && $page_image!='' && $page_link_title!=''){?>
		<div class="right plus">
			<a href="<?php echo URL_SITE; ?>/<?php echo $page_link;?>"> <?php echo $page_link_title;?><img src="/images/<?php echo $page_image;?>" class="pL5"></a>
		</div>
		<?php } else {?>
		<div class="right plus">
			<a href="<?php echo URL_SITE; ?>/<?php if(isset($page_link)) echo $page_link;?>"> <?php if(isset($page_link_title)) echo $page_link_title;?></a>
		</div>
		<?php } ?>
	<?php } ?>
</h1>