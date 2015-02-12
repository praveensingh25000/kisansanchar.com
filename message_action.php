<ul>								
	<?php										
	if(isset($message['status']) && $message['status']=='0') {?>
	<li id="aprrove_dissaprove_div_<?php echo $unique_div_id;?>">
		<a onclick="javascript: functionApproveDisaprove('<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','1','Do you really want to approve this message');" id="aprove_div_<?php echo $unique_div_id;?>" href="javascript:;">Visible</a>
	</li>
	<li>|</li>
	<li id="edit_click_div_<?php echo $unique_div_id;?>">
		
		<?php if(isset($message['content_type']) && $message['content_type']=='text'){?>
			<a target="_blank" title="edit" href="<?php echo URL_SITE;?>/admin/edit_text_msg.php?id=<?php echo $message['id'];?>">Modify-Send</a>
		<?php }else if(isset($message['content_type']) && $message['content_type']=='mp3'){?>
			<a target="_blank" title="edit" href="<?php echo URL_SITE;?>/admin/edit_voice_msg.php?id=<?php echo $message['id'];?>">Modify-Send</a>
		<?php }else if(isset($message['content_type']) && $message['content_type']=='wav'){?>
			<a target="_blank" title="edit" href="<?php echo URL_SITE;?>/admin/edit_voice_msg.php?id=<?php echo $message['id'];?>">Modify-Send</a>
		<?php } else{?>
			<a target="_blank" title="edit" href="<?php echo URL_SITE;?>/admin/edit_andriod_msg.php?id=<?php echo $message['id'];?>">Modify</a>
		<?php } ?>	

	</li>

	<?php if(isset($message['content_type']) && ($message['content_type']=='text' || $message['content_type']=='mp3' || $message['content_type']=='wav')){?>
	<li>|</li>
	<li id="send_voice_click_div_<?php echo $unique_div_id;?>">
		<a onclick="javascript: functionSendVoiceSms('<?php echo $content_id;?>','<?php if(isset($message['content_type']) && $message['content_type']=='text'){?>textmsg<?php }else if(isset($message['content_type']) && $message['content_type']=='mp3'){?>voicemsg<?php }else if(isset($message['content_type']) && $message['content_type']=='wav'){?>voicemsg<?php } ?>','<?php echo $unique_div_id;?>','Do you really want to send this message to all associated users.It will cost you.');" id="send_voice_div_<?php echo $unique_div_id;?>" href="javascript:;">Send</a>	
	</li>
	<?php } ?>

	<li>|</li>
	<li id="delete_click_div_<?php echo $unique_div_id;?>">
		<a onclick="javascript:functionDeleteMessages('<?php echo $message_id;?>','<?php echo $unique_div_id;?>','Do you really want to delete this message');" title="delete" href="javascript:;">Trash</a>								
	</li>
	<?php } ?>
	<?php if(isset($message['status']) && $message['status']=='1') {?>
	<li id="aprrove_dissaprove_div_<?php echo $unique_div_id;?>">
		<a onclick="javascript:functionApproveDisaprove('<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','0','Do you really want to disapprove this message');" id="dissaprove_div_<?php echo $unique_div_id;?>" href="javascript:;">Invisible</a>
	</li>
	<li>|</li>
	<li id="delete_click_div_<?php echo $unique_div_id;?>">
		<a onclick="javascript:functionDeleteMessages('<?php echo $message_id;?>','<?php echo $unique_div_id;?>','Do you really want to delete this message');" title="delete" href="javascript:;">Trash</a>								
	</li>
	<?php } ?>
	<li>
		<a id="broadcast_unbroadcast_loader_<?php echo $unique_div_id;?>"  href="javascript:;"></a>
	</li>
</ul>