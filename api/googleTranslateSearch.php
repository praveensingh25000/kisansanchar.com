<?php
if(isset($_SESSION['LANG'])){
	$langTypeDefault = $_SESSION['LANG'];
}else{
	$langTypeDefault =  'ENGLISH';
}
$startLimit = 0;
$endLimit   = 10;
?>
<script src="https://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript">jQuery(document).ready(function(){jQuery("#more-link").click(function(){$('#more-link-show').toggle();});});</script>
<style>
	li{display: inline;padding: 10px;text-decoration: none;}
	a{text-decoration: none;}

	.languagelist .active {
		color: red;
	}
	#more-link{cursor:pointer;}
	#more-li-part ul {
		height: 31px;
		list-style: none outside none;
		margin: 0;
		padding: 1px;
	}

	#more-link-show ul li {
		display: block;
		list-style: none outside none;
		margin-top: 0;
		padding: 0 0 0 229px;
	}
	.languagelist,.searchtype ul{
		margin:0px !important;
		padding:0px !important;
	}
	.languagelist,.searchtype li{
		color:#70a300;
	}
</style>
<?php if($langTypeDefault!='ENGLISH'){?>
	<script type="text/javascript">
		google.load("elements", "1", {
			packages: "transliteration"
		});		

		function onLoad() {
			var langType = "<?php echo $langTypeDefault;?>";
			if(langType =='HINDI'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.HINDI],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='KANNADA'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.KANNADA],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='GUJARATI'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.GUJARATI],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='MALAYALAM'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.MALAYALAM],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}

			if(langType =='PUNJABI'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.PUNJABI],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='AMHARIC'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.AMHARIC],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='TIGRINYA'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.TIGRINYA],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='TELUGU'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.TELUGU],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='TAMIL'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.TAMIL],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='SINHALESE'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.SINHALESE],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='SERBIAN'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.SERBIAN],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='SANSKRIT'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.SANSKRIT],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='RUSSIAN'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.RUSSIAN],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='PERSIAN'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.PERSIAN],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='ORIYA'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.ORIYA],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='NEPALI'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.NEPALI],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='MARATHI'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.MARATHI],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='GREEK'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.GREEK],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='CHINESE'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.CHINESE],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='BENGALI'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.BENGALI],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='ARABIC'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.ARABIC],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			if(langType =='URDU'){
				var options = {
					sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
					destinationLanguage: [google.elements.transliteration.LanguageCode.URDU],
					shortcutKey: 'ctrl+g',
					transliterationEnabled: true
				};
			}
			var control = new google.elements.transliteration.TransliterationControl(options);
			control.makeTransliteratable(['searchkeyword']);
		}
		google.setOnLoadCallback(onLoad);
	</script>
<?php } ?>

<div class="search">
	<form id="searchmessagetagForm" name="searchmessagetagForm" method="POST" action="">

		<div id="searchlogo" class="logo">
		   <a href="index.php"><img alt="" src="/images/kisan.png" class="logoimage"></a>
		</div>

		<div class="wdthpercent100">	
			<div class="searchtype">
				<ul>					
					<li>
						<input type="radio" checked="true" value="message" name="searchtype" id="searchtypemessage">&nbsp;&nbsp;Search by Content
					</li>
					<li>
						<input type="radio" value="users" name="searchtype" id="searchtypeusers">&nbsp;&nbsp;Search by User
					</li>
				</ul>
			</div>
			<div class="wdthpercent100 left">
				<input type="hidden" value="<?php echo $_SERVER["REQUEST_URI"];?>" id="page_url">
				<input type="hidden" value="<?php echo $searchObj->getLanguageID($langTypeDefault);?>" id="language_type">
				<input id="searchkeyword" class="wdthpercent85 required" name="searchkeyword" value="<?php if(isset($_POST['searchkeyword'])){echo $_POST['searchkeyword'];}?>">&nbsp;&nbsp;&nbsp;	
				<input type="submit" class="searchbutton" name="search" value="Search">
				<span id="cloaderid" class="" style="display:none;"></span>
			</div>
		</div>
		<div class="clear"></div>

		<?php if(!empty($languageSelectedArray)) { ?>

			<div class="wdthpercent100 languagelist">			

				<ul>
					<?php foreach($languageSelectedArray as $languageselected) { ?>				
						<li>
							<a id="<?php echo strtoupper($languageselected['value']);?>" class="<?php if(isset($langTypeDefault) && $langTypeDefault==$languageselected['value']){echo 'active';} ?>" onclick="javascript: selectLanguageType('<?php echo strtoupper($languageselected['value']);?>');" href="javascript:;"><?php echo ucwords(strtolower($languageselected['value']));?></a>
						</li>
					<?php } ?>

					<?php if(!empty($languageUnSelectedArray)) {
						foreach($languageUnSelectedArray as $value) { 
							$languageUnSelectedinitial[] = strtoupper($value['value']);
						}
						?>

						<li id="more-li-part">
							<a id="more-link">+More</a>				
							<ul id="more-link-show" <?php if(!in_array($langTypeDefault,$languageUnSelectedinitial)){?>style="display:none;"<?php } ?>>
								<?php foreach($languageUnSelectedArray as $languageUnSelected) { ?>				
									<li>
										<a id="<?php echo strtoupper($languageUnSelected['value']);?>" class="<?php if(isset($langTypeDefault) && $langTypeDefault==$languageUnSelected['value']){echo 'active';} ?>" onclick="javascript: selectLanguageType('<?php echo strtoupper($languageUnSelected['value']);?>');" href="javascript:;"><?php echo ucwords(strtolower($languageUnSelected['value']));?></a>
									</li>
								<?php } ?>
							</ul>
						</li>	

					<?php } ?>

				</ul>
			</div>

		<?php } ?>
	</form>
</div>

