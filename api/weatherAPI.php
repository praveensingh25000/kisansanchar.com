<?php
/******************************************
* @Created on JAN 27, 2014
* @Package: Kisan Sanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$basedir=dirname(__FILE__)."../../";
include_once $basedir."/include/specificHeader.php";

$conditionarray = array('Partlycloudy'=>'Partly Cloudy','Clear'=>'Clear','Chancetstorms'=>'Chance Tstorms','Chancerain'=>'Chance of rain');

if(isset($_SESSION['session_user_data']['id'])){
	if($_SESSION['session_user_data']['district']=='1'){ $ciites = 'Karnal';
	}else{ $ciites = 'Gaya'; }
} else {
	$ip = get_client_ip_address();
	$ipDtails = json_decode(file_get_contents("http://ipinfo.io/".$ip.""));
	if(empty($ipDtails->city)){
		$ipDtails->city = 'Karnal';
		$ciites = $ipDtails->city;
	} else {
		$ciites = $ipDtails->city;
	}
}

$json_string_weekly =  $json_string_hourly = '';
$weatherDataWeekly  =  $weatherDatahourly  = array();

//weekly record
$json_string_weekly = @file_get_contents("http://api.wunderground.com/api/3b2791219451b7b0/forecast10day/conditions/q/IN/".$ciites.".json"); 
$weatherDataWeekly = json_decode($json_string_weekly);

//hourly record
$json_string_hourly = @file_get_contents("http://api.wunderground.com/api/3b2791219451b7b0/hourly10day/conditions/q/IN/".$ciites.".json"); 
$weatherDatahourly = json_decode($json_string_hourly);

//echo '<pre>';print_r($weatherDataWeekly);echo '</pre>';

if(isset($weatherDataWeekly->current_observation->display_location->state_name) && $weatherDataWeekly->current_observation->display_location->state_name=='India'){?>

	<div id="weekly_report_div" class="pB10">
		
		<table cellspacing="5" class="wtable">

			<tbody>

				<?php if(!empty($weatherDataWeekly->forecast->txt_forecast->forecastday)){?>

				<?php $weatherData_out_array = array_slice($weatherDataWeekly->forecast->txt_forecast->forecastday,0,7);?>

					<tr>
						<td colspan="2">
							<?php echo $weatherDataWeekly->current_observation->display_location->full;?>
						</td>
					</tr>

					<tr>
						<td align="center" colspan="2"><img width="209" height="1" src="<?php echo URL_SITE;?>/images/puntos.gif"></td>
					</tr>
					
					<?php foreach($weatherData_out_array as $weather){?>

						<tr>
							<td class="font14" colspan="2"><?php echo $weather->title;?></td>
						</tr> 
						
						<tr>
							<td>
								<img width="29" height="29" align="absmiddle" src="<?php echo $weather->icon_url;?>" title="weather forecast for <?php echo $weather->title;?> is <?php echo ucwords($weather->icon);?>" alt="weather forecast for <?php echo $weather->title;;?> is <?php echo ucwords($weather->icon);?>">
								<span class="climate"> <?php echo ucwords($weather->icon);?></span>
							</td>						
						</tr>

						<tr>
							<td valign="bottom"><small class="font11"><?php echo $weather->fcttext;;?></small></td>
						</tr> 
						
						<tr>
							<td align="center" colspan="2"><img width="209" height="1" src="<?php echo URL_SITE;?>/images/puntos.gif"></td>
						</tr>  

					<?php } ?>				

				<?php } else { ?>
					
					<tr>
						<td>City not found</td>
					</tr> 

				<?php } ?>

			</tbody>

		</table>
		
	</div>
	
	<div id="hourly_report_div" class="pB10" style="display:none">
		
		<table cellspacing="5" class="wtable">

			<tbody>

				<?php if(!empty($weatherDatahourly->hourly_forecast)){?>

				<?php $weatherDatahourly_out_array = array_slice($weatherDatahourly->hourly_forecast,0,5);?>

					<tr>
						<td colspan="2">
							<?php echo $weatherDataWeekly->current_observation->display_location->full;?>
						</td>
					</tr>

					<tr>
						<td align="center" colspan="2"><img width="209" height="1" src="<?php echo URL_SITE;?>/images/puntos.gif"></td>
					</tr>
					
					<?php foreach($weatherDatahourly_out_array as $weather){?>

						<tr>
							<td class="font14"><?php echo $weather->FCTTIME->weekday_name_night;?></td>
							<td align="" colspan="2" class="font11"><?php echo $weather->FCTTIME->pretty;?></td>
						</tr>
						
						<tr>
							<td class="wdthpercent53">
								<img width="29" height="29" align="absmiddle" src="<?php echo $weather->icon_url;?>" title="weather forecast for <?php echo $weather->FCTTIME->weekday_name_night;?> is <?php echo ucwords($weather->condition);?>" alt="weather forecast for <?php echo $weather->FCTTIME->weekday_name_night;?> is <?php echo ucwords($weather->condition);?>">
								<span class="climate"> <?php echo ucwords($weather->icon);?></span>
							</td>	
							
							<td class="font11">MAX TEMP&nbsp;:&nbsp;<?php echo $weather->temp->english;?><br />MIN TEMP &nbsp;:&nbsp;<?php echo $weather->temp->metric;?></td>
						</tr>
						
						<tr>
							<td align="center" colspan="2"><img width="209" height="1" src="<?php echo URL_SITE;?>/images/puntos.gif"></td>
						</tr>  

					<?php } ?>				

				<?php } else { ?>
					
					<tr>
						<td>City not found</td>
					</tr> 

				<?php } ?>

			</tbody>

		</table>
		
	</div>

	
<?php } ?>