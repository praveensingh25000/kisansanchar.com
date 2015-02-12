<?php
//$url = 'http://example.com/image.php';
//$img = '/my/folder/flower.gif';
//file_put_contents($img, file_get_contents($url));
/*
 $data = fopen ($image, 'rb');
$size=filesize ($image);
$contents= fread ($data, $size);
fclose ($data);
$encoded= base64_encode($contents);

 */
//$return = array();

$fileToUpload =  time().'_'.$_FILES["file"]["name"];
//$vname = $_REQUEST['vname']; 

$folder= 'audios/'.$fileToUpload;
move_uploaded_file($_FILES["file"]["tmp_name"],$folder);
//echo $vname = $_REQUEST['vname']; 
/*
if ($_FILES["fileToUpload"]["error"] > 0)
{
	$return['status'] =ERROR;
}
elseif(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],SITEPATHDEV.$fileToUpload))
{	
	$vname = $_REQUEST['vname'];

	$stQuery = "INSERT INTO tblAudio(vname, vaudio) VALUES ('".$vname."', '".$fileToUpload."')";
	if(mysql_query($stQuery))
	{
		$return['status'] =SUCCESS;
	}
	else
	{
		$return['status'] =ERROR;
	}
}
else
{
	$return['status'] =ERROR;
}

echo $r =  '{"Result":'.json_encode($return).'}';*/
?>
