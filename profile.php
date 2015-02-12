<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
******************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

checkSession(false,2);

$fullname = '';

$action_type = (isset($_GET['action']))?trim($_GET['action']):'view';

if(isset($action_type) && ($action_type == 'view' || $action_type == 'edit')){
	
	$countryArray = $db->getUniversalRowAll($table_name='india'," and `parent_id` ='0' ");

	$userDetail			=	$db->getUniversalRow($table_name='users', $coloum_name_str='*', $updated_on_field='id', $updated_on_value=$front_user_id, $otherfields	= null);
	$userTypeDetail		=	$db->getUniversalRow($table_name='users',$coloum_name_str='*',$updated_on_field='id',$updated_on_value=$userDetail['user_type'],$otherfields=null);
	$usertypesAll		=	 $db->getUniversalRowAll($table_name='users');

	$fullname   = getUserName($userDetail,'join');

	if(!empty($userDetail['dob'])){
		$dobArray		=	explode('-', $userDetail['dob']);
		$yearSet		=	(isset($dobArray[0]))?trim($dobArray[0]):'';
		$monthSet		=	(isset($dobArray[1]))?trim($dobArray[1]):'';
		$daySet			=	(isset($dobArray[2]))?trim($dobArray[2]):'';
	}
}
?>
<div class="container">

	<h1 class="title"><?php echo ucwords($fullname); ?><?php echo $langVariables['general_var']['user_profile']?><span class="right"><!-- <a href="javascript:window.history.go(-1)"><?php echo $langVariables['general_var']['back']?></a> --><a href="<?php echo URL_SITE.$timeline_url;?>">Go To Timeline</a></span></h1>

	<div class="entry">

		<div class="wdthpercent100 pT10 pB10 pL10">

			<div class="tabnav pT5 pB5">		
				<div class="pL10 pT5">
					<?php echo $langVariables['general_var']['show']?><a href="profile.php?id=<?php echo $front_user_id; ?>&action=view" <?php if($action_type!='edit'){ ?> class="none" <?php } ?>><?php echo $langVariables['general_var']['head_profile']?></a>&nbsp;&nbsp;
					<a href="profile.php?id=<?php echo $front_user_id; ?>&action=edit" <?php if($action_type=='edit'){ ?> class="none" <?php } ?>><?php echo $langVariables['general_var']['edit_profile']?></a>&nbsp;&nbsp;
				</div>
			</div>
			<br class="clear" />
			
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

	</div>

</div>


<!-- FOOTER -->
<?php include_once $basedir."/include/frontFooter.php"; ?>
<!-- /FOOTER -->