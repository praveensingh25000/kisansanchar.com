<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
* @Purpose:Sharing Content On Facebook
********************************************/
$facebook_url = 'http://www.facebook.com/sharer.php';
$title        = 'Copy and paste the below message above to share as facebook wall';
$summary      = stripslashes($message['message']);
$url          = URL_SITE;
?>
<!-- SHARE CONTENT ON FACEBOOK -->
<meta property="og:title" content="<?php echo $title;?>" />
<meta property="og:description" content="<?php echo $summary;?>" />
<meta property="og:image" content="<?php echo URL_SITE;?>/images/kisan.png" />

<a href="<?php echo $facebook_url;?>?s=100&amp;p[title]=<?php echo $summary;?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo URL_SITE;?>/images/kisan.png" onclick="return !window.open(this.href, 'Facebook', 'width=400px,height=400px')"><?php echo $langVariables['form_var']['fb_share']?></a>
<!-- /SHARE CONTENT ON FACEBOOK -->