<ul>								
	<?php if(isset($message['status']) && $message['status']=='0') { ?>
	
	<li id="timeline_aprrove_dissaprove_div_<?php echo $unique_div_id;?>">
		<a href="javascript:;" onclick="javascript: functionApproveDisaprove('<?php echo $content_type;?>','<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','1','Do you really want to approve this message');" id="timeline_aprove_div_<?php echo $unique_div_id;?>">Approve for Timeline </a>
	</li>
	<li>|</li>

	<li id="schuduled_aprrove_dissaprove_div_<?php echo $unique_div_id;?>">
		<a href="javascript:;" onclick="javascript: functionSchuduledApproveDisaprove('<?php echo $content_type;?>','<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','7','Do you really want to approve this message for Schuduled Message');" id="schuduled_aprove_div_<?php echo $unique_div_id;?>">Approve Schuduled Message </a>
	</li>
	<li>|</li>
	
	<li id="edit_click_div_<?php echo $unique_div_id;?>">
		
		<?php if(isset($message['message_type']) && $message['message_type']=='sms' && isset($message['content_type']) && $message['content_type']=='txt'){?>
			<a target="_blank" title="edit" href="<?php echo URL_SITE;?>/admin/edit_text_msg.php?id=<?php echo $message['id'];?>&lang=<?php echo $message['language_type'];?>">Modify-Send</a>
		<?php }else if(isset($message['message_type']) && $message['message_type']=='sms' && isset($message['content_type']) && $message['content_type']=='mp3'){?>
			<a target="_blank" title="edit" href="<?php echo URL_SITE;?>/admin/edit_voice_msg.php?id=<?php echo $message['id'];?>&lang=<?php echo $message['language_type'];?>">Modify-Send</a>
		<?php }else if(isset($message['message_type']) && $message['message_type']=='sms' && isset($message['content_type']) && $message['content_type']=='wav'){?>
			<a target="_blank" title="edit" href="<?php echo URL_SITE;?>/admin/edit_voice_msg.php?id=<?php echo $message['id'];?>&lang=<?php echo $message['language_type'];?>">Modify-Send</a>
		<?php } else{?>
			<a target="_blank" title="edit" href="<?php echo URL_SITE;?>/admin/edit_andriod_msg.php?id=<?php echo $message['id'];?>&lang=<?php echo $message['language_type'];?>">Modify</a>
		<?php } ?>	

	</li>

	<?php if(isset($message['message_type']) && $message['message_type']=='sms' && isset($message['content_type']) && ($message['content_type']=='txt' || $message['content_type']=='mp3' || $message['content_type']=='wav')){?>
	<li>|</li>
	<li id="send_voice_click_div_<?php echo $unique_div_id;?>">
		<a href="javascript:;" onclick="javascript: functionSendVoiceSms('<?php echo $content_type;?>','<?php echo $content_id;?>','<?php if(isset($message['content_type']) && $message['content_type']=='txt'){?>textmsg<?php }else if(isset($message['content_type']) && $message['content_type']=='mp3'){?>voicemsg<?php }else if(isset($message['content_type']) && $message['content_type']=='wav'){?>voicemsg<?php } ?>','<?php echo $unique_div_id;?>','Do you really want to send this message to all associated users.It will cost you.');" id="send_voice_div_<?php echo $unique_div_id;?>">Send</a>	
	</li>
	<?php } ?>

	<li>|</li>
	<li id="delete_click_div_<?php echo $unique_div_id;?>">
		<a href="javascript:;" onclick="javascript: functionDeleteMessages('<?php echo $content_type;?>','<?php echo $message_id;?>','<?php echo $unique_div_id;?>','Do you really want to delete this message');" title="delete">Trash</a>								
	</li>
	<?php } ?>

	<?php if(isset($message['status']) && ($message['status']=='1' || $message['status']=='5' || $message['status']=='6')) {?>
	<li id="aprrove_dissaprove_div_<?php echo $unique_div_id;?>">
		<a href="javascript:;" id="dissaprove_div_<?php echo $unique_div_id;?>" onclick="javascript: functionApproveDisaprove('<?php echo $content_type;?>','<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $unique_div_id;?>','0','Do you really want to approve this message');">Invisible</a>
	</li>
	<li>|</li>
	<li id="delete_click_div_<?php echo $unique_div_id;?>">
		<a href="javascript:;" onclick="javascript: functionDeleteMessages('<?php echo $content_type;?>','<?php echo $message_id;?>','<?php echo $unique_div_id;?>','Do you really want to delete this message');" title="delete">Trash</a>								
	</li>
	<?php } ?>
	<li>
		<a id="broadcast_unbroadcast_loader_<?php echo $unique_div_id;?>"  href="javascript:;"></a>
	</li>
</ul>