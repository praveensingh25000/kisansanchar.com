<?php 
/******************************************
* @Created on JAN 27, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/

*-------------------------------------------
* Example utility file for dynamically displaying images
* @author      Ian Selby
* @version     1.0 (php 4 version)
********************************************/

//reference thumbnail class
include_once('thumbnail.class.php');

$thumb = new Thumbnail($_GET['filename']);
$size  = getimagesize($_GET['filename']);

/* ERROR Image */
if(!file_exists($_GET['filename'])) {	
	$_GET['filename'] = "../images/no-image.jpeg";
	if(empty($_GET['width'])){
		$_GET['width'] = $size[0];
	}
}
/* End of error image */

/* width and height setting and resize width and height with respect to image width and height  */
if(!empty($_GET['width'])){
	if($size[0] > $_GET['width']){
		$_GET['width'] = $_GET['width'];
	}else{
		$_GET['width'] = $size[0];
	}
}
if(!empty($_GET['height'])){
	if($size[1] > $_GET['height']){
		$_GET['height'] = $_GET['height'];
	}else{
		$_GET['height'] = $size[0];
	}
}
/* end of setting */

//check to see if file exists
$thumb->resize($_GET['width'],$_GET['height']);
//$thumb->crop(110,120,$_GET['width'],$_GET['height']);

if(isset($_GET['filename'])){
	$thumb->show();
}else{
	$thumb->destruct();
}
exit;
?>