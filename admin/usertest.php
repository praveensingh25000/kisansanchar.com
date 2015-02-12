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

if(isset($_GET['action'])){
	$action_type	=	$_GET['action'];
} else {
	$action_type	=	'viewall';
}

if($action_type == "delete"){
	$parent_id		=	 $_GET['id'];
	$id				=	 trim($_GET['deleteid']);
	$user->deleteUserPermanent($id, $parent_id);
	header('location:user.php?action=view&id='.$parentid.'');
	exit;
}

if(isset($_POST['updatebackuserprofile'])){
	$result			=	 $userObj->updateRegistration($_POST);
	$_SESSION['msgsuccess'] = "7";
	header('location: usertest.php?action=edit&id='.$_POST['userid'].'');
	exit;
}

if(isset($action_type) && ($action_type == 'view' || $action_type == 'edit') && isset($_GET['id']) && $_GET['id']!=''){	
	$userid				=	 trim($_GET['id']);

	$countryArray		=	$db->getUniversalRowAll($table_name='india'," and `parent_id` ='0' ");

	$update_view_status =    $db->updateUniversalRow($table_name='users',$coloum_name_str=" `view_status`='1' ",$updated_on_field='id',$updated_on_value=$userid, $otherfields	= null);
	$userDetail			=	 $db->getUniversalRow($table_name='users',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$userid, $otherfields	= null);
	$userTypeDetail		=	 $db->getUniversalRow($table_name='user_types',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$userDetail['user_type'],$otherfields=null);
	$usertypesAll		=	 $db->getUniversalRowAll($table_name='user_types');
	if(!empty($userDetail['dob'])){
		$dobArray		=	 explode('-', $userDetail['dob']);
		$yearSet		=	 trim($dobArray[0]);
		$monthSet		=	 trim($dobArray[1]);
		$daySet			=	 trim($dobArray[2]);
	}
}
?>

<!-- containerCenter -->
<section class="containerCenter">	
	<div class="containercentercnt">
		<h2><?php echo ucwords($userDetail['pfirstname'].' '.$userDetail['plastname']); ?><?php echo $langVariables['general_var']['user_profile']?><span class="right"><a href="javascript:window.history.go(-1)"><?php echo $langVariables['general_var']['back']?></a></span></h2><br>
			<div class="tabnav mB10">		
				<div class="pL10 pT5" id="">
					<?php echo $langVariables['general_var']['show']?><a href="user.php?id=<?php echo $userid; ?>&action=view" <?php if($action_type!='edit'){ ?> class="none" <?php } ?>><?php echo $langVariables['general_var']['head_profile']?></a>&nbsp;&nbsp;
					<a href="user.php?id=<?php echo $userid; ?>&action=edit"<?php if($action_type=='edit'){ ?> class="none" <?php } ?>><?php echo $langVariables['general_var']['edit_profile']?></a>&nbsp;&nbsp;
				</div>
			</div>

			<!-- --------------- VIEW USER PROFILE -------------------------------------------->
			<?php if(!empty($userDetail) && isset($action_type) && ($action_type == 'view')) { ?>
				<?php require_once($DOC_ROOT.'profile-view.php');?>			
			<?php } ?>
			<!------------------/VIEW USER PROFILE ------------------------------------>


			<!------------------EDIT USER PROFILE ------------------------------------->
			<?php if(!empty($userDetail) && isset($action_type) && ($action_type == 'edit')) { ?>
				<?php require_once($DOC_ROOT.'profile-edit.php');?>	
			<?php } ?>
			<!-- ---------------/EDIT USER PROFILE ------------------------------------>
	</div>
</section>
<!-- /Containercenter -->

<?php include_once $basedir."/include/adminFooter.php"; ?>