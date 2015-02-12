<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      // Load the Google Transliterate API
      google.load("elements", "1", {
            packages: "transliteration"
          });

      var transliterationControl;
      function onLoad() {
        var options = {
            sourceLanguage: 'en',
            destinationLanguage: ['hi','ar','kn','ml','ta','te'],
            transliterationEnabled: true,
            shortcutKey: 'ctrl+g'
        };
        // Create an instance on TransliterationControl with the required
        // options.
        transliterationControl =
          new google.elements.transliteration.TransliterationControl(options);

        // Enable transliteration in the textfields with the given ids.
        var ids = ["message_tag" ];
        transliterationControl.makeTransliteratable(ids);

        // Add the STATE_CHANGED event handler to correcly maintain the state
        // of the checkbox.
        transliterationControl.addEventListener(
            google.elements.transliteration.TransliterationControl.EventType.STATE_CHANGED,
            transliterateStateChangeHandler);

        // Add the SERVER_UNREACHABLE event handler to display an error message
        // if unable to reach the server.
        transliterationControl.addEventListener(
            google.elements.transliteration.TransliterationControl.EventType.SERVER_UNREACHABLE,
            serverUnreachableHandler);

        // Add the SERVER_REACHABLE event handler to remove the error message
        // once the server becomes reachable.
        transliterationControl.addEventListener(
            google.elements.transliteration.TransliterationControl.EventType.SERVER_REACHABLE,
            serverReachableHandler);

        // Set the checkbox to the correct state.
        document.getElementById('checkboxId_tag').checked =
          transliterationControl.isTransliterationEnabled();

        // Populate the language dropdown
        var destinationLanguage =
          transliterationControl.getLanguagePair().destinationLanguage;
        var languageSelect = document.getElementById('languageDropDown_tag');
        var supportedDestinationLanguages =
          google.elements.transliteration.getDestinationLanguages(
            google.elements.transliteration.LanguageCode.ENGLISH);
        for (var lang in supportedDestinationLanguages) {
          var opt = document.createElement('option');
          opt.text = lang;
          opt.value = supportedDestinationLanguages[lang];
          if (destinationLanguage == opt.value) {
            opt.selected = true;
          }
          try {
            languageSelect.add(opt, null);
          } catch (ex) {
            languageSelect.add(opt);
          }
        }
      }

      // Handler for STATE_CHANGED event which makes sure checkbox status
      // reflects the transliteration enabled or disabled status.
      function transliterateStateChangeHandler(e) {
        document.getElementById('checkboxId_tag').checked = e.transliterationEnabled;
      }

      // Handler for checkbox's click event.  Calls toggleTransliteration to toggle
      // the transliteration state.
      function checkboxClickHandlerTag() {
		if($("#checkboxId_tag").is(':checked')){
			$('#language_type_tag').remove();
			$('#languageDropDown_tag').removeAttr('disabled');
			$('#english').remove();
			$('#languageDropDown_tag').val('hi');
		} else {
			$('#languageDropDown_tag').attr('disabled','true');
			$('#languageDropDown_tag').prepend('<option id="english" selected="selected" value="en">ENGLISH</option>').val('en');
			if(!$('#language_type_tag').hasClass('language_type_tag')){
			  $('#checkboxId_tag').after('<input class="language_type_tag" id="language_type_tag" name="language_type_tag" type="hidden" value="en">');
			}
		}
		transliterationControl.toggleTransliteration();
      }

      // Handler for dropdown option change event.  Calls setLanguagePair to
      // set the new language.
      function languageChangeHandlerTag() {
        var dropdown = document.getElementById('languageDropDown_tag');
        transliterationControl.setLanguagePair(
            google.elements.transliteration.LanguageCode.ENGLISH,
            dropdown.options[dropdown.selectedIndex].value);
      }

      // SERVER_UNREACHABLE event handler which displays the error message.
      function serverUnreachableHandler(e) {
        document.getElementById("errorDiv").innerHTML =
            "Transliteration Server unreachable";
      }

      // SERVER_UNREACHABLE event handler which clears the error message.
      function serverReachableHandler(e) {
        document.getElementById("errorDiv").innerHTML = "";
      }
      google.setOnLoadCallback(onLoad);

	  function limitText(limitField, limitCount, limitNum) {
		if (limitField.value.length > limitNum) {
			limitField.value = limitField.value.substring(0, limitNum);
		} else {
			limitCount.value = limitNum - limitField.value.length;
		}
	  }

	  jQuery(document).ready(function(){
		  var languagetag = "<?php if(isset($language_type) && $language_type!=''){echo $language_type; } ?>";
		  if(languagetag!=''){
			  if(languagetag=='en'){
				$('#languageDropDown_tag').attr('disabled','true');
				$('#languageDropDown_tag').prepend('<option id="english" value="en">ENGLISH</option>').val('en');
				if(!$('#language_type_tag').hasClass('language_type_tag')){
					$('#checkboxId_tag').after('<input class="language_type_tag" id="language_type_tag" name="language_type_tag" type="hidden" value="en">');
				}
			  } else {
				$('#languageDropDown_tag').val(languagetag);
			  }
		  }
	  });

</script>

<div class="wdthpercent100 pB10" id="translControl">
	<div class="wdthpercent30 left">
		<input type="checkbox" id="checkboxId_tag" name="checkboxId_tag" onclick="javascript: checkboxClickHandlerTag()"></input>
		Type in
	</div>
	<div class="wdthpercent70 left">
		<select name="language_type_tag" class="wdthpercent100" id="languageDropDown_tag" onchange="javascript: languageChangeHandlerTag()"></select>
	</div>
</div>
<div class="clear pB10"></div>

<div class="wdthpercent100 pB10 googleLanguage">
	<div class="wdthpercent30 left">Select Message Tag</div>
	<div class="wdthpercent70 left">
		<input type="text" placeholder="Type your message TAG here and press spacebar" id="message_tag" class="wdthpercent100 required" name="message_tag" value="<?php if(isset($message_tag) && $message_tag!=''){echo $message_tag; } ?>">	
	</div>
	<div class="clear"></div>
</div>
<div class="clear"></div>

<div class="wdthpercent30">
	<div class="wdthpercent100" id="errorDiv"></div>
</div>
<div class="clear"></div>