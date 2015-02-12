<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

// To delete all the Comments of the events
if(isset($_GET['del'])){
	$basedir=dirname(__FILE__)."";
	include_once $basedir."/include/actionHeader.php";
	if(isset($_GET['event_id'])){
		$event_id=$_GET['event_id'];
		$comment_id=$_GET['comment_id'];
		$unique_div_id=trim($_GET['id']);
		$commenting =$_GET['commenting'];
		//Event::eventCommentsLikDisDel($comment_id);
		return true;
	}
}
$limit = 2;
$contentDetailArray  = $msgObj->selectContentComments($content_id, $content_type,$orderby='order by id', $startlimit='all', $endlimit='all');
$totalcontentcomment = count($contentDetailArray);
if($totalcontentcomment>0){	
	$contentDetail = array_sort($contentDetailArray,'date');
}
?>							

<div id="recentcontentComment_<?php echo $unique_div_id;?>">
	
	<div class="commentsslide comment_content_<?php echo $unique_div_id;?>"  style="display:none;">
		
		<h3 id="update_connter_<?php echo $unique_div_id;?>">
			<?php echo $totalcontentcomment;?>&nbsp;<?php if($totalcontentcomment < 2) { echo 'Answer';} else { echo 'Answers';}?>		
		</h3>	

		<script language="javascript">			
			$(document).ready(function(){			
				$(".comment_content_<?php echo $unique_div_id;?> h3:first").removeClass("active");
				$(".comment_content_<?php echo $unique_div_id;?> h3").bind('click',function(){
					$("#content_slide_div_<?php echo $unique_div_id;?>").slideToggle("slow");
					$("#content_slide_div_<?php echo $unique_div_id;?>").toggleClass("active");
					$(this).toggleClass("active");
				});
			});			
			$(document).ready(function(){				
				$("#comment_open_<?php echo $unique_div_id;?>").bind('click',function(){
					$(".comment_content_<?php echo $unique_div_id;?>").slideToggle("slow");
					$("#content_slide_div_<?php echo $unique_div_id;?>").toggleClass("active");
					$(this).toggleClass("active");
				});
			});	
		</script>

		<div id="content_slide_div_<?php echo $unique_div_id;?>">
			
			<?php
			if($totalcontentcomment > $limit){
				$leftCount = $totalcontentcomment - $limit;
				?>		
				<p onclick="functionLoadRemaining('<?php echo $unique_div_id;?>','<?php echo $totalcontentcomment;?>','<?php echo $content_id;?>','<?php echo $content_type;?>','<?php echo $message_user_id;?>');" class="more" id="content_comment_remaining_<?php echo $unique_div_id;?>">
					<a href="javascript:;" id="newcontentvalue_<?php echo $unique_div_id?>"><?php if($leftCount < 2){ echo str_replace('#',$leftCount,'# more'); } else { echo str_replace('#',$leftCount,'# more'); } ?> </a>
					<input type="hidden" value="<?php echo $limit ?>" id="limitvalue_<?php echo $unique_div_id; ?>" />	
				</p>
			<?php } ?>

			<div id="content_append_prepend_div_<?php echo $unique_div_id;?>">
				
			<?php if($totalcontentcomment > 0){						
				$contentDetailout = array_slice($contentDetail,0,2);	
				foreach($contentDetailout as $contents){						
					$content_comment_id = $contents['id'];	
					$user = $db->getUniversalRow($table_name='users',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$contents['user_id'],$otherfields=null);
					?>			   
										   
					<div class="answerslidetext" id="commentsslidetext_<?php echo $content_comment_id;?>_<?php echo $unique_div_id;?>">
													
						<div class="msgmain fullcontent">
							<div class="msgdisplay">
								<h5>
									<a href="#"><?php echo $user['pfirstname'];?></a>
								</h5>
								<span class="font12">
									<?php echo date_diff_hour_min($contents['date']);?>
								</span>
								<p><?php echo addslashes($contents['comment'])?></p>				
								<?php if((isset($session_user_id) && $session_user_id==$contents['user_id']) || (isset($message_user_id) && (isset($session_user_id)) && $message_user_id==$session_user_id)) {?>
									<ul>
										<li>
											<a id="comment_delete_<?php echo $content_comment_id;?>_<?php echo $unique_div_id;?>" href="javascript:;" onclick="javascript:functionDeleteContentComment('<?php echo $unique_div_id;?>','<?php echo $content_comment_id;?>')">Delete</a>
										</li>
									</ul>	
								<?php } ?>									
							</div>

						  </div>

					  </div>

					<?php } ?>	
				
				 <?php } ?>		     	
				
			</div>

			<?php if(isset($commenting_status) && $commenting_status==1){ ?>
			<!---------COMMENT FORM---------------------->
			<script type="text/javascript" src="<?php echo URL_SITE; ?>/js/jquery.flexibleArea.js"></script>​
			<script type="text/javascript">$(function() {$("#click_content_comment_<?php echo $unique_div_id;?>").flexible();})</script>
			<div class="commentsslidetext">				
				<div class="textmain fullcontent">
					<div class="textdisplay">
						<form method="POST" id="form_content_comment_<?php echo $unique_div_id;?>" onsubmit="return submitContentForm('<?php echo $unique_div_id;?>');">		
							<textarea placeholder="post your answer" rows="1" id="click_content_comment_<?php echo $unique_div_id;?>" class="textareacomment required" name="comment"></textarea>	
							<span class="right pT5 pB5">								
								<input type="hidden" name="content_type" value="<?php echo $content_type;?>">
								<input type="hidden" name="content_id" value="<?php echo $content_id;?>">
								<input type="hidden" name="unique_div_id" value="<?php echo $unique_div_id;?>">	
								<input type="hidden" name="user_id" value="<?php echo $session_user_id;?>">	
								<input type="submit" class="button" name="postcontentcomment" value="Comment" id="submit_comment_content_<?php echo $unique_div_id;?>">
							</span>
						</form>
				   </div>
			  </div>			  
		   </div>
		   <!---------/COMMENT FORM---------------------->
		   <?php } ?>

	   </div>

	</div>	
	
</div>