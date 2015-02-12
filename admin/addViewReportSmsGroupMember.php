<?php
/******************************************
* @Modified on JAN 26, 2014
* @Package: Kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);

if(!isset($_GET['group_id'])){
	$_SESSION['msgalert'] = "8";
	header("location: addReportSmsGroup.php");
	exit;
}

$group_id = (isset($_GET['group_id']))?trim($_GET['group_id']):'';

$wherejoinid_str = " `sms_groups_members`.`group_id`= '".$group_id."' ";
$coloum_name_str =' `sms_groups_members`.`id` as member_id, `sms_groups_members`.`date` as member_date, `sms_groups_members`.*, `users`.*';
$memberDetailArray = $db->getUniversalJoinData($table_name1='sms_groups_members', $table_name2='users', $join_type='JOIN', $onjoinid1='user_id' , $onjoinid2='id', $wherejoinid_str, $coloum_name_str, $andcondition='1', $otherfields=' order by sms_groups_members.id DESC'); 
$memberDetail_obj  = new PS_PaginationArray($memberDetailArray,50,1,"group_id=".$group_id."");
$memberDetail	   = $memberDetail_obj->paginate();
//echo '<pre>';print_r($memberDetail);echo '</pre>';

if(isset($_POST['submitreportgroupforms']) && !empty($_POST['assigned_users'])){	
	$result  = $adminObj->functionInsertGroupMembersData($tablename='sms_groups_members', $_POST);
	if($result){
		$_SESSION['msgsuccess'] = "7";	
	}else{
		$_SESSION['msgerror'] = "8";	
	}
	header("location: ".$_SERVER['REQUEST_URI']."");
	exit;
}

if(isset($_POST['actionperform']) && !empty($_POST['ids'])){
	$action		= strtolower($_POST['actionperform']);
	$ids		= implode(',', $_POST['ids']);
	$tablename  = ' `sms_groups_members` ';	
	$return     = $db->functionUniversalAction($tablename, $action, $ids,$status='',$otherfields='');
	header("location: ".$_SERVER['REQUEST_URI']."");
	exit;
}
?>
<!-- containerCenter -->
<section class="containerCenter">
	
	<div class="containercentercnt">
		
		<div class="maxheight">
			<h2 class="heading left">Add Group Member<span class="right"><a onclick="javascript:history.go(-1)" href="javascript:;">Back</a></span></h2>
			<div class="clear pB10"></div>
			
			<div class="pT10 pB10">
				<form action="" method="post" id="addreportgroupmemberforms" name="addreportgroupmemberforms">	
					
					<div class="wdthpercent100 pT10 pB10">
						<div class="wdthpercent20 left">Select Group Type </div>
						<div class="wdthpercent60 left">
						   <span class="wdthpercent20 left"><input type="radio" id="selection_type_byname" name="selection_type" class="required" value="by_name" />&nbsp;&nbsp;By Name</span>
						   <span id="sloader_selection" class="wdthpercent60 left"><input type="radio" id="selection_type_byphonenumber" name="selection_type" class="required" value="by_phone_number" />&nbsp;&nbsp;By Phone Number</span>
						   <input type="hidden" name="group_id" id="group_id" value="<?php echo $group_id;?>">
						</div>
					</div>
					<div class="clear pB10"></div>

					<div id="selection_type_display" class="wdthpercent100 pT10 pB10" style="display:none;">
					</div>
					<div class="clear"></div>

				</form>	
			</div>
		</div>
		<div class="clear"></div>

		<div class="wdthpercent100 left">

			<h2 class="heading left">Total Group Member<?php if(!empty($memberDetail)) { echo '('.count($memberDetail).')'; } ?><span class="right"><input type="checkbox" id="click_on_all_users" />&nbsp;Check All</span></h2>
			<div class="clear"></div>
			
			<div class="member">

			    <form action="" method="post" id="addviewreportsmsgroupmember" name="addviewreportsmsgroupmember">
					<?php if(!empty($memberDetail)){?>

						<?php foreach($memberDetail as $members){?>
							
							<div class="wdthpercent15 left pT10 pB10">

								<div class="checkrm">
									<input type="checkbox" class="ids" name="ids[]" value="<?php echo $members['member_id'];?>">
								</div>
								<div class="popupimg left pL10">							
									<?php if(!empty($members['image'])){?>
										<a href="javascript:;"><img src="<?php echo URL_SITE;?>/uploads/users/<?php echo $members['user_id'];?>/<?php echo $members['image'];?>" alt="<?php echo $userObj->getUserName($members);?>"></a>
									<?php } else { ?>
										<a href="javascript:;"><img src="<?php echo URL_SITE;?>/images/no-image.jpeg" alt="<?php echo $userObj->getUserName($members);?>"></a>
									<?php } ?>
								</div>	
								<div class="left pL10">
									<a href="javascript:;"><?php echo $userObj->getUserName($members);?></a>
									<br />
									<span class="font11"><?php echo date('d M Y h:i a',strtotime($members['member_date']));?></span>
								</div>					
							</div>

						<?php } ?>	

						<br class="clear pB10" />
						
						<!-- Pagination ----------->                      
						<div class="txtcenter pR20 pagination">
							<?php echo $memberDetail_obj->renderFullNav();  ?>
						</div>
						<!-- /Pagination -----------> 

						<!-- DELETE BUTTON ----------->    
						<div class="pT5">
							<input type="submit" name="actionperform" value="Remove" onclick="javascript: return checkUsers('remove');"/>
						</div>
						<!-- DELETE BUTTON -----------> 

					<?php } else { ?>

						<div class="wdthpercent100 pT10 pB10">
							<div class="wdthpercent20 left">&nbsp;</div>
							<div class="wdthpercent80 left">No group Member added Yet.</div>
						</div>
						<div class="clear pB10"></div>				

					<?php } ?>					

				</form>

			</div>
			
		</div>

	</div>

</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>