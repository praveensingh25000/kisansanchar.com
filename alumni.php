<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$alumniData = array(
	'2013'=> array(
		'1'=> array('id'=>'1','name'=>'Arunimia Khullar','name_href'=>'https://www.linkedin.com/pub/arunima-khullar/68/25b/aa5','institutite'=>'Narsee Monjee Institute of Management Studies, Mumbai','inst_href'=>'http://business.nmims.edu/'),
		'2'=> array('id'=>'2','name'=>'Saurabh Kapoor','name_href'=>'https://www.linkedin.com/profile/view?id=98727481&authType=NAME_SEARCH&authToken=ETcK&locale=en_US&srchid=183998001403459294279&srchindex=1&srchtotal=170&trk=vsrp_people_res_name&trkInfo=VSRPsearchId%3A183998001403459294279%2CVSRPtargetId%3A98727481%2CVSRPcmpt%3Aprimary','institutite'=>'Narsee Monjee Institute of Management Studies, Mumbai','inst_href'=>'http://business.nmims.edu/'),
		'3'=> array('id'=>'3','name'=>'Isha Bansal','name_href'=>'https://www.linkedin.com/profile/view?id=197542429&authType=NAME_SEARCH&authToken=B_Cp&locale=en_US&srchid=183998001403461717817&srchindex=3&srchtotal=48&trk=vsrp_people_res_name&trkInfo=VSRPsearchId%3A183998001403461717817%2CVSRPtargetId%3A197542429%2CVSRPcmpt%3Aprimary','institutite'=>'Narsee Monjee Institute of Management Studies, Mumbai','inst_href'=>'http://business.nmims.edu/')	
	),
	'2014'=> array(
		'1'=> array('id'=>'1','name'=>'Aakershit Gupta','name_href'=>'https://www.linkedin.com/profile/view?id=245712822&authType=NAME_SEARCH&authToken=zt6s&locale=en_US&trk=tyah&trkInfo=tarId%3A1403459442293%2Ctas%3AAakershit%20Gupta%2Cidx%3A1-1-1','institutite'=>'Narsee Monjee Institute of Management Studies, Mumbai','inst_href'=>'http://business.nmims.edu/'),
		'2'=> array('id'=>'2','name'=>'Neeraj Gupta','name_href'=>'https://www.linkedin.com/profile/view?id=273408420&authType=NAME_SEARCH&authToken=M4j7&locale=en_US&srchid=183998001403459475700&srchindex=1&srchtotal=1&trk=vsrp_people_res_name&trkInfo=VSRPsearchId%3A183998001403459475700%2CVSRPtargetId%3A273408420%2CVSRPcmpt%3Aprimary','institutite'=>'Narsee Monjee Institute of Management Studies, Mumbai','inst_href'=>'http://business.nmims.edu/'),
		'3'=> array('id'=>'3','name'=>'Bhushan Kumar Gupta','name_href'=>'https://www.linkedin.com/profile/view?id=74151995&authType=NAME_SEARCH&authToken=YiTs&locale=en_US&srchid=183998001403459511813&srchindex=1&srchtotal=3&trk=vsrp_people_res_name&trkInfo=VSRPsearchId%3A183998001403459511813%2CVSRPtargetId%3A74151995%2CVSRPcmpt%3Aprimary','institutite'=>'Narsee Monjee Institute of Management Studies, Mumbai','inst_href' => 'http://business.nmims.edu/')		
	)	
);
?>

<div class="container">
	<h1 class="title">Kisan Sanchar Alumni</h1>

	<div class="entry pL10 pR10">
		<?php if(!empty($alumniData)){?>
			<?php foreach($alumniData as $yearkey => $alumniAll){ ?>
				
				<table class="data-table">

					<thead>
						<th colspan="3"><?php echo $yearkey;?></th>
					</thead>				
				
					<?php if($yearkey=='2013'){?>
					<thead>
						<th>S.No</th>
						<th>Alumni Name</th>
						<th>Institute</th>
					</thead>
					<?php } ?>

					<tbody>
					<?php foreach($alumniAll as $key => $alumni){ ?>
						<tr style="background:#f9f3df;padding:5px;">
							<td style="padding: 5px 5px 5px 38px;" align="center">
								<a target="_blank" href="<?php echo $alumni['name_href'];?>"><?php echo $alumni['id'];?></a>
							</td>
							<td style="padding: 5px 5px 5px 52px;" align="left">
								<a target="_blank" href="<?php echo $alumni['name_href'];?>"><?php echo $alumni['name'];?></a>
							</td>
							<td style="padding: 5px 5px 5px 26px;" align="left">
								<a target="_blank" href="<?php echo $alumni['inst_href'];?>"><?php echo $alumni['institutite'];?></a>
							</td>
						</tr>
						<tr><td colspan="3">&nbsp;</td></tr>
					<?php } ?>
					</tbody>
			    </table>
			<?php } ?>
		<?php } ?>
	
	</div>
</div>

<?php include_once $basedir."/include/frontFooter.php";?>