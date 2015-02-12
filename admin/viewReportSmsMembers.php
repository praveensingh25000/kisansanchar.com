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
	header("location: viewAllReportSmsGroup.php");
	exit;
}

$group_id = (isset($_GET['group_id']))?trim($_GET['group_id']):'';

$wherejoinid_str = " `sms_groups_members`.`group_id`= '".$group_id."' ";
$coloum_name_str =' `sms_groups_members`.`id` as member_id, `sms_groups_members`.`date` as member_date, `sms_groups_members`.*, `users`.*';
$memberDetailArray = $db->getUniversalJoinData($table_name1='sms_groups_members', $table_name2='users', $join_type='JOIN', $onjoinid1='user_id' , $onjoinid2='id', $wherejoinid_str, $coloum_name_str, $andcondition='1', $otherfields=' order by sms_groups_members.id DESC'); 
$memberDetail_obj  = new PS_PaginationArray($memberDetailArray,50,1,"id=".$group_id."");
$memberDetail	   = $memberDetail_obj->paginate();

//echo '<pre>';print_r($memberDetail);echo '</pre>';

?>
<!-- containerCenter -->
<section class="containerCenter">
	
	<div class="containercentercnt">

		<div class="wdthpercent100 left">

			<h2 class="heading left">Total Group Member<?php if(!empty($memberDetailArray)) { echo '('.count($memberDetailArray).')'; } ?><span class="right"><a onclick="javascript:history.go(-1)" href="javascript:;">Back</a></span></h2>
			<div class="clear"></div>
			
			<div class="member">
				<?php if(!empty($memberDetail)){?>

					<?php foreach($memberDetail as $members){?>
						
						<div class="wdthpercent15 left pT10 pB10">

							<div class="checkrm">
								<input type="checkbox" name="user_id[]" value="<?php echo $members['user_id'];?>">
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

				<?php } else { ?>

					<div class="wdthpercent100 pT10 pB10">
						<div class="wdthpercent20 left">&nbsp;</div>
						<div class="wdthpercent80 left">No group Member added Yet.</div>
					</div>
					<div class="clear pB10"></div>				

				<?php } ?>	
			</div>
			
		</div>

	</div>

</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>