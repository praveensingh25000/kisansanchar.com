<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$newsData = array(
	'1'=> array('id'=>'1','title'=>'Punjab Keshri 01 Jan 2014','href'=>'#','subtitle'=>'','source'=>'uploads/news/News Clippings.JPG'),
	'2'=> array('id'=>'2','title'=>'Live mint Sunday 29 May 2011','href'=>'http://www.livemint.com/Industry/ySOaq95Ce0QaSp74L8krXJ/Helping-farmers-track-best-prices-for-crops.html','subtitle'=>'Helping farmers track best prices for crops','source'=>'uploads/news/JMD-8.JPG'),
	'3'=> array('id'=>'3','title'=>'Amar Ujala 11 June 2009','href'=>'#','subtitle'=>'','source'=>'uploads/news/Amar ujala.jpg'),
	'4'=> array('id'=>'4','title'=>'Hari Bhumi 11 June 2009','href'=>'#','subtitle'=>'','source'=>'uploads/news/Hari Bhumi.jpg'),
	'5'=> array('id'=>'5','title'=>'Punjab Keshri 12 May 2011','href'=>'#','subtitle'=>'','source'=>'uploads/news/News of Kisan Sanchar.jpg')
)
?>

<div class="container">
	<h1 class="title">Kisan Sanchar Videos</h1>

	<div class="entry pL10 pR10">
		<?php if(!empty($newsData)){?>
			<?php foreach($newsData as $id => $news){?>				
				<div class="wdthpercent100">
					<div class="">
						<h2><a target="_blank" href="<?php echo $news['href'];?>"><?php echo strtoupper($news['title']);?></a></h2>					
					</div>
					<br class="clear" />
					<div class="news txtcenter">
						<span class="fontbld font20"><?php echo ucwords($news['subtitle']);?></span>
						<a target="_blank" href="<?php echo URL_SITE.'/'.$news['source'];?>"><img class="media" src="<?php echo $news['source'];?>" alt="<?php echo $news['title'];?>"></a>		
					</div>
				</div>
				<br class="clear" />

			<?php } ?>
		<?php } ?>
	
	</div>
</div>

<?php include_once $basedir."/include/frontFooter.php";?>