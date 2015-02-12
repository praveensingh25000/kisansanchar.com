<!-- DISPLAY SUCCESS OR ERROR MESSAGE ON ANY ACTION -->

<div class="notification msgsuccess pB20" style="display:none;">
	<a class="close"></a>
	<p id="msgsuccess"></p>
</div>

<?php
if(!empty($_SESSION['msgheader'])){
	$msg_main=@$_SESSION['msgheader'];?>
	<script> headerLoaderMessage('<?php echo $msg_main;?>');</script> 
	<?php unset($_SESSION['msgheader']);
} 
if(!empty($_SESSION['msgsuccess'])){
	$msg_main=@$session_message[$_SESSION['msgsuccess']];?>
	<script> succuss('<?php echo $msg_main;?>');</script> 
	<?php unset($_SESSION['msgsuccess']);
} 
if(!empty($_SESSION['msgerror'])){
	$msg_main=@$session_message[$_SESSION['msgerror']];?>
	<script> error('<?php echo $msg_main;?>');</script> 
	<?php unset($_SESSION['msgerror']); 
}
if(!empty($_SESSION['msgalert'])){
	$msg_main=@$session_message[$_SESSION['msgalert']];?>
	<script> alertmsg('<?php echo $msg_main;?>');</script> 
	<?php unset($_SESSION['msgalert']); 
}
?>	

<?php
if(!empty($_SESSION['successmsg'])){
	$msg_main=@$_SESSION['successmsg'];?>
	<script> succuss('<?php echo $msg_main;?>');</script> 
	<?php unset($_SESSION['successmsg']);
} 
if(!empty($_SESSION['errormsg'])){
	$msg_main=@$_SESSION['errormsg'];?>
	<script> error('<?php echo $msg_main;?>');</script> 
	<?php unset($_SESSION['errormsg']); 
}
if(!empty($_SESSION['alertmsg'])){
	$msg_main=@$_SESSION['alertmsg'];?>
	<script> alertmsg('<?php echo $msg_main;?>');</script> 
	<?php unset($_SESSION['alertmsg']); 
}
?>	
<!-- DISPLAY SUCCESS OR ERROR MESSAGE ON ANY ACTION -->