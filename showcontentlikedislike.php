<?php
/******************************************
* @Modified on June 01, 2012
* @Package: Maduhaa
* @Developer: Praveen Singh
* @URL : http://www.maduhaa.com
********************************************/

if(isset($_GET['ajaxcontentlike'])){
	$basedir=dirname(__FILE__)."";
	include_once $basedir."/include/actionHeader.php";

	$content_id     = trim($_POST['content_id']);	
	$content_type   = trim($_POST['content_type']);	
	$unique_div_id  = trim($_POST['unique_div_id']);
	$user_id        = trim($_POST['user_id']);
	$like_status    = trim($_POST['likestatus']);
	$status_id      = $msgObj->insertContentLike($user_id,$content_id, $content_type, $like_status);
}

//number of likes
$totalcontentlikes_result  = $msgObj->liked_byUsersAll($content_id, $content_type);
$totalcontentlikes_alluser = $db->count_rows($totalcontentlikes_result);
?>

<!-- LIKES DISLIKES SECTION -->
<ul>
	<?php if($totalcontentlikes_alluser > 1){?>	
		<li><a onclick="javascript:functioncontentLikedBy('<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','1');" id="countlike_<?php echo $unique_div_id;?>" href="javascript:;" onclick=""><?php echo $totalcontentlikes_alluser;?>&nbsp;Thanks</a></li>		
	<?php } elseif($totalcontentlikes_alluser > 0){?>				
		<li><a onclick="javascript:functioncontentLikedBy('<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','1');" id="countlike_<?php echo $unique_div_id;?>" href="javascript:;" onclick=""><?php echo $totalcontentlikes_alluser;?>&nbsp;Thanks</a></li>
	<?php } else {?>			
		<li><a id="countlike_<?php echo $unique_div_id;?>" href="javascript:;"><?php echo $totalcontentlikes_alluser;?>&nbsp;Thanks</a></li>
	<?php }	?>

	<script language="javascript">
	function functioncontentLikedBy(content_id, content_type, unique_div_id, like_status){
		loader_show();
		jQuery.ajax({
			type: "POST",
			data:'unique_div_id='+unique_div_id+"&like_status="+like_status+"&content_id="+content_id+"&content_type="+content_type,
			url:URL_SITE+"/actionAjax.php?ajaxcontentlikedBy=1",
			success: function(msg){
				loader_unshow();						
				blockUI_object(msg);
			}
		});			
	}
	</script>
</ul>
<!-- LIKES DISLIKES SECTION -->