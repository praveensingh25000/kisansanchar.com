<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
*******************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

checkSession(false,2);

if(!isset($_GET['group_id'])){
	$_SESSION['msgalert'] = "8";
	header("location: create-group.php");
	exit;
}

$group_id = (isset($_GET['group_id']))?trim($_GET['group_id']):'';
$groupDetail = $db->getUniversalRow($table_name='sms_groups',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$group_id,$otherfields='');

$page_title			= $groupDetail['group_name'].' Group Detail';
$page_link_title	= '+Add New Group';
$page_link			= 'create-group.php'; 
$page_image			= '';

$wherejoinid_str = " `sms_groups_members`.`group_id`= '".$group_id."' ";
$coloum_name_str =' `sms_groups_members`.`id` as member_id, `sms_groups_members`.`date` as member_date, `sms_groups_members`.*, `users`.*';
$memberDetailArray = $db->getUniversalJoinData($table_name1='sms_groups_members', $table_name2='users', $join_type='JOIN', $onjoinid1='user_id' , $onjoinid2='id', $wherejoinid_str, $coloum_name_str, $andcondition='1', $otherfields=' order by sms_groups_members.id DESC'); 
$memberDetail_obj  = new PS_PaginationArray($memberDetailArray,30,1,"group_id=".$group_id."");
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

<div class="container">

	<!-- TITLE HEADING -->
	<?php require_once($DOC_ROOT.'include/title_heading.php');?>	
	<!-- /TITLE HEADING -->

	<div class="entry bknone">
		
		<div class="pT10 pB10">
			<form action="" method="post" id="addreportgroupmemberforms" name="addreportgroupmemberforms">	
				
				<div class="wdthpercent100 pT10 pB10">
					<div class="wdthpercent30 left">Select Group Addition Type </div>
					<div class="wdthpercent70 left">
						<select class="wdthpercent100 required" id="selection_type" name="selection_type">
							<option value="">Select Group Addition Type</option>
							<option value="by_name">By User Name</option>
							<option value="by_phone_number">By User Phone Number</option>					
						</select>
						<input type="hidden" name="group_id" id="group_id" value="<?php echo $group_id;?>"> 
					</div>
				</div>
				<div class="clear pB10"></div>

				<div id="selection_type_display" class="wdthpercent100 pT10 pB10" style="display:none;">
				</div>
				<div class="clear"></div>

			</form>	
		</div>
		<div class="clear"></div>

		<div class="wdthpercent100 left">

			<h2 style="padding-top: 5px;" class="heading">Total Group Member<?php if(!empty($memberDetail)) { echo '('.count($memberDetail).')'; } ?><span class="right"><input type="checkbox" id="click_on_all_users" />&nbsp;Check All</span></h2>
			<div class="clear"></div>			
			
			<div class="member">

			    <form action="" method="post" id="addviewreportsmsgroupmember" name="addviewreportsmsgroupmember">
					<?php if(!empty($memberDetail)){?>

						<?php foreach($memberDetail as $members){?>
							
							<div class="wdthpercent50 left pT10 pB10">

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
							<input class="button" type="submit" name="actionperform" value="Remove" onclick="javascript: return checkUsers('remove');"/>
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

</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>