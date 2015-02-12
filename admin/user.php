<?php
/******************************************
* @Modified on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @edited: Gurtej Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."/..";
require_once $basedir."/include/adminHeader.php";

checkSession(true,2);

$action_type = (isset($_GET['action']))?trim($_GET['action']):'viewall';
$userid      = (isset($_GET['id']))?trim($_GET['id']):'0';

if(isset($action_type) && ($action_type == 'view' || $action_type == 'edit')){	
	$view_status_update = $db->updateUniversalRow($table_name='users',$coloum_name_str="`view_status`='1'",$updated_on_field='id',$updated_on_value=$userid,$otherfields=null);
	$countryArray       = $db->getUniversalRowAll($table_name='india'," and `parent_id` ='0' ");
	$userTypes          = $db->getUniversalRowAll($table_name='user_types');
	$userDetail			=	$db->getUniversalRow($table_name='users', $coloum_name_str='*', $updated_on_field='id', $updated_on_value=$userid, $otherfields	= null);
	$userTypeDetail		=	$db->getUniversalRow($table_name='users',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$userDetail['user_type'],$otherfields=null);
	$usertypesAll		=	 $db->getUniversalRowAll($table_name='users');
	$fullname           =    (getUserName($userDetail))?trim(getUserName($userDetail)):'';
	if(!empty($userDetail['dob'])){
		$dobArray		=	explode('-', $userDetail['dob']);
		$yearSet		=	(isset($dobArray[0]))?trim($dobArray[0]):'';
		$monthSet		=	(isset($dobArray[1]))?trim($dobArray[1]):'';
		$daySet			=	(isset($dobArray[2]))?trim($dobArray[2]):'';
	}
}
?>

<!-- containerCenter -->
<section class="containerCenter">	
	<div class="containercentercnt">
		<h2><?php echo ucwords($fullname); ?><?php echo $langVariables['general_var']['user_profile']?><span class="right"><a href="javascript:window.history.go(-1)"><?php echo $langVariables['general_var']['back']?></a></span></h2><br>
			
			<div class="tabnav mB10">		
				<div class="pL10 pT5" id="">
					<?php echo $langVariables['general_var']['show']?><a href="user.php?id=<?php echo $userid; ?>&action=view" <?php if($action_type!='edit'){ ?> class="active" <?php } ?>><?php echo $langVariables['general_var']['head_profile']?></a>&nbsp;&nbsp;
					<a href="user.php?id=<?php echo $userid; ?>&action=edit"<?php if($action_type=='edit'){ ?> class="active" <?php } ?>><?php echo $langVariables['general_var']['edit_profile']?></a>&nbsp;&nbsp;
				</div>
			</div>

			<br class="clear" />
			
			<!-- --------------- VIEW USER PROFILE -------------------------------------------->
			<?php if(!empty($userDetail) && isset($action_type) && ($action_type == 'view')) { ?>
				<?php require_once($DOC_ROOT.'admin/profile-view.php');?>			
			<?php } ?>
			<!------------------/VIEW USER PROFILE ------------------------------------>


			<!------------------EDIT USER PROFILE ------------------------------------->
			<?php if(!empty($userDetail) && isset($action_type) && ($action_type == 'edit')) { ?>
				<?php require_once($DOC_ROOT.'admin/profile-edit.php');?>	
			<?php } ?>
			<!-- ---------------/EDIT USER PROFILE ------------------------------------>
	
	</div>
</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>