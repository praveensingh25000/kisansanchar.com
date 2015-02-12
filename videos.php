<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$videosData = array(
	'1'=> array('id'=>'1','title'=>'About Us','source'=>'https://www.youtube.com/watch?v=8ss_3E9aXQo'),
	'2'=> array('id'=>'2','title'=>'Our Role in promoting Innovators and Innovations','source'=>'https://www.youtube.com/watch?v=VEpwUSUPjig'),
	'3'=> array('id'=>'3','title'=>'Mobile for good award 2011','source'=>'https://www.youtube.com/watch?v=EKoz1WMhv5o'),
	'4'=> array('id'=>'4','title'=>'mBillinth Award 2011','source'=>'https://www.youtube.com/watch?v=mCQS-6Gr8gM'),
	'5'=> array('id'=>'5','title'=>'Kisan Sanchar Tutorial in English','source'=>'https://www.youtube.com/watch?v=Y64kuWYKwwU'),
	'6'=> array('id'=>'6','title'=>'Kisan Sanchar Tutorial in Punjabi','source'=>'https://www.youtube.com/watch?v=RcSAlVGYHp4'),
	
)
?>

<div class="container">
	<h1 class="title">Kisan Sanchar Videos</h1>

	<div class="entry pL10 pR10">
		<?php if(!empty($videosData)){?>
			<?php foreach($videosData as $id => $video){
				$embedcode ='';
				list($imagelink, $vediolink, $embedcode) = $videoembedObj->embededcodewithurl($video['source']);				
				?>				
				<div class="wdthpercent100">
					<div class="left">
						<h2><?php echo $video['title'];?></h2>					
					</div>
					<br class="clear" />
					<div class="txtcenter pL20">
						<div class="urlframe">
							<?php echo $embedcode;?>
						</div>						
					</div>
				</div>
				<br class="clear" />

			<?php } ?>
		<?php } ?>
	
	</div>
</div>

<?php include_once $basedir."/include/frontFooter.php";?>