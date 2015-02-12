<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Gurtej Singh
* @URL : http://kisansanchar.com/
*******************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

if(isset($_POST['updatepassword'])){
	$password = md5($_POST['password']);
	$updatepassword = $db->updateUniversalRow($table_name='users',$coloum_name_str=" password='".$password."' ",$updated_on_field='id',$updated_on_value=null,$otherfields=null);
	$_SESSION['msgsuccess'] = '11';
	header("location:".$URL_SITE."/setting.php");
}

?>

<!-- CONTAINER -->
<div class="container">
	<h1 class="title">Change Password</h1>
		<div class="wdthpercent100 font15">
			<form name="updateuserpassword" method="post" action="" id="updateuserpassword">
				<input id="password" type="password" name="password" placeholder="New Password" class="wdthpercent70 required mT20 pT10 pB10"><br>
				<input id="confirmpassword" type="password" name="confirmpassword" placeholder="<?php echo $langVariables['form_var']['cpassword'];?>" class="wdthpercent70 required mT20 mB10 pT10 pB10"><br>
				<input type="submit" name="updatepassword" value="Submit" class="button">
				<input type="reset" name="reset" value="reset" class="button">
			</form>
		</div>
	<div class="clear"></div>
</div>
<!-- CONTAINER -->

<!-- FOOTER -->
<?php include_once $basedir."/include/frontFooter.php"; ?>
<!-- /FOOTER -->