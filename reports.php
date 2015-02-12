<?php
/******************************************
* @Created on APL 20, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
*******************************************/

$basedir=dirname(__FILE__)."";
include_once $basedir."/include/frontHeader.php";

checkSession(false,2);
checkDashboard($dashbordType);

$project_id    = (defined('IS_PROJECT_ID'))?IS_PROJECT_ID:'';
$pageType	   = (isset($_GET['tab']))?trim($_GET['tab']):'percentage';
$actionType	   = (isset($_GET['type']))?trim($_GET['type']):'1';

$usergroup     = $db->getUniversalRowAll($table_name="user_groups"," and `parent_id`= '0' ORDER BY id ");
$contentstatus = $db->getUniversalRowAll($table_name="content_status");
$maxminDate    = $projectObj->getStartingEndingDateofReport($project_id,$languageArray);
//echo '<pre>';print_r($maxminDate);echo '</pre>';
?>

<div class="container">

	<h1 class="title">Analysis Report<div class="right"><a href="<?php echo URL_SITE.$timeline_url;?>">Timeline</a></div></h1>

	<div class="entry">

		<div class="reportnav">
			<ul>
				<li><a <?php if(isset($pageType) && $pageType=='percentage'){ ?>class="selected"<?php } ?> href="?tab=percentage">Listening Report</a></li>
				<!--<li><a <?php if(isset($pageType) && $pageType=='joining'){ ?>class="selected"<?php } ?> href="?tab=joining">Joining Report</a></li>
				 <li><a <?php if(isset($pageType) && $pageType=='max'){ ?>class="selected"<?php } ?> href="?tab=max">Max Listen Report</a></li>
				<li><a <?php if(isset($pageType) && $pageType=='picked'){ ?>class="selected"<?php } ?> href="?tab=picked">Max Picked Report</a></li> -->
			</ul>
		</div>

		<br class="clear pB10" />

		<div class="wdthpercent100 pL20 pB10">
			<table class="data-table">				
				<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
				<tr class="pT10 pB10">
					<td class="lft-td">Report Criteria</td>
					<td class="rht-td">
					    <?php if(!empty($maxminDate['starting']) && !empty($maxminDate['ending'])){?>
							<span class="red fontbld">&nbsp;Records available from <?php echo $maxminDate['starting'];?> to <?php echo $maxminDate['ending'];?>.</span>
						<?php } else {?>
						    <span class="red fontbld">&nbsp;Records unavailable at this time</span>
						<?php } ?>
					</td>					
				</tr>
			</table>
		</div>

		<?php if(isset($pageType) && $pageType=='percentage'){ ?>

			<div class="wdthpercent100 pL20 pB10">
				<table class="data-table">

					<tr>
						<td class="lft-td">Select Report Type</td>
						<td class="rht-td">
							<a class="checktab" href="?tab=<?php if(isset($pageType))echo $pageType;?>&type=1"><input <?php if(isset($actionType) && $actionType=='1'){ ?>checked<?php } ?> type="radio" id="select_percentage_type" name="select_percentage_type" value="villagewise">&nbsp;&nbsp;Village Wise</a>
							<a class="checktab" href="?tab=<?php if(isset($pageType))echo $pageType;?>&type=2"><input <?php if(isset($actionType) && $actionType=='2'){ ?>checked<?php } ?>  type="radio" id="select_percentage_type" name="select_percentage_type" value="farmerwise">&nbsp;&nbsp;Number Wise</a>	
						</td>					
					</tr>
				</table>
			</div>
			<?php if(isset($actionType) && $actionType=='1'){ ?>
			<?php require_once($DOC_ROOT.'reports-percentage-village-wise.php');?>
			<?php } ?>

			<?php if(isset($actionType) && $actionType=='2'){ ?>
			<?php require_once($DOC_ROOT.'reports-percentage-farmer-wise.php');?>
			<?php } ?>
		<?php } ?>

		<?php if(isset($pageType) && $pageType=='joining'){ ?>
			<?php require_once($DOC_ROOT.'reports-farmer-joining.php');?>
		<?php } ?>

		<?php if(isset($pageType) && $pageType=='max'){ ?>
			<?php //require_once($DOC_ROOT.'reports-'.$pageType.'.php');?>
		<?php } ?>

		<?php if(isset($pageType) && $pageType=='picked'){ ?>
			<?php //require_once($DOC_ROOT.'reports-'.$pageType.'.php');?>
		<?php } ?>
			
	</div>

</div>


<!-- FOOTER -->
<?php include_once $basedir."/include/frontFooter.php"; ?>
<!-- /FOOTER -->