<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

$statewisebeneficiariesData = $db->getUniversalRowAll($table_name='statewise_beneficiaries');
?>

<div class="container">
	<h1 class="title">State Wise Beneficiaries of Kisan Sanchar as on 31 March 2014</h1>

	<div class="entry">		

		<?php if(!empty($statewisebeneficiariesData)){?>
			<table class="data-table">
				<thead>
					<th>S.No</th>
					<th>State</th>
					<th>Number of Beneficiaries</th>
				</thead>
				
				<tbody>
				<?php foreach($statewisebeneficiariesData as $id => $statewisebeneficiaries){?>
					<?php if($statewisebeneficiaries['id']!='31'){?>
						<tr style="background:#f9f3df;padding:5px;">
							<td style="padding:5px;" align="center"><?php echo $statewisebeneficiaries['id'];?></td>
							<td style="padding:5px;" align="left"><?php echo $statewisebeneficiaries['state'];?></td>
							<td style="padding:5px;" align="right"><?php echo $statewisebeneficiaries['number_beneficiaries'];?></td>
						</tr>
						<tr><td colspan="3">&nbsp;</td></tr>
					<?php } else {?>
						<tr style="background:#f9f3df;padding:5px;">
							<td style="padding:5px;" align="center">&nbsp;</td>
							<td style="padding:5px;font-weight:bold;" align="left"><?php echo $statewisebeneficiaries['state'];?></td>
							<td style="padding:5px;font-weight:bold;" align="right"><?php echo $statewisebeneficiaries['number_beneficiaries'];?></td>
						</tr>
						<tr><td colspan="3">&nbsp;</td></tr>
					<?php } ?>
				<?php } ?>
				</tbody>
			</table>
		<?php } ?>

	</div>
</div>

<?php include_once $basedir."/include/frontFooter.php"; ?>