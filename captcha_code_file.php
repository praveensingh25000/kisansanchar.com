<?php
/******************************************
* @Created on JAN 27, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

if(isset($_GET['get_captcha_code']) && $_GET['get_captcha_code']=='1'){
	$basedir=dirname(__FILE__)."";
	include_once $basedir."/include/actionHeader.php";
}

// Math operators
$operators=array('+','-','*');

// first number random value
$first_num = rand(1,5);

// second number random value
$second_num = rand(6,11);

shuffle($operators);

$expression = $second_num. "&nbsp;&nbsp;".$operators[0]."&nbsp;&nbsp;".$first_num."&nbsp;&nbsp;=&nbsp;&nbsp;";

eval("\$session_var=".$second_num.$operators[0].$first_num.";");

$_SESSION['security_number'] = $session_var;
?>

<span class="captcha"><?php echo $expression?></span>
<span class="wdthpercent55"><input placeholder="value here" name="captcha_code" type="text" class="wdthpercent55 inputbox required"></span><br />
<small class="cattch-refresh"><?php echo $langVariables['form_var']['canot_read']?><a href='javascript: refreshCaptchaCode();'><?php echo $langVariables['form_var']['click_here'];?></a> <?php echo $langVariables['form_var']['to_refresh']?> </small>