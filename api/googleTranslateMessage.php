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
            //transliterationEnabled: true,
            //shortcutKey: 'ctrl+g'
        };
        // Create an instance on TransliterationControl with the required
        // options.
        transliterationControl =
          new google.elements.transliteration.TransliterationControl(options);

        // Enable transliteration in the textfields with the given ids.
        var ids = ["message","message_tag","message_subject" ];
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
        document.getElementById('checkboxId').checked =
          transliterationControl.isTransliterationEnabled();

        // Populate the language dropdown
        var destinationLanguage =
          transliterationControl.getLanguagePair().destinationLanguage;
        var languageSelect = document.getElementById('languageDropDown');
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
        document.getElementById('checkboxId').checked = e.transliterationEnabled;
      }

      // Handler for checkbox's click event.  Calls toggleTransliteration to toggle
      // the transliteration state.
      function checkboxClickHandlerMessage() {
		$('#language_type_id').remove();	
		if($("#checkboxId").is(':checked')){		
			$('#english').remove();			
			$('#languageDropDown').removeAttr("disabled");
			$('#languageDropDown').removeAttr("style");
			$('#languageDropDown').val('hi');
		} else {
			$('#english').remove();
			$('#languageDropDown').prepend('<option id="english" value="en">ENGLISH</option>').val('en');
		}
		transliterationControl.toggleTransliteration();
      }

      // Handler for dropdown option change event.  Calls setLanguagePair to
      // set the new language.
      function languageChangeHandlerMessage() {
        var dropdown = document.getElementById('languageDropDown');
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
		  var language = "<?php if(isset($language_type) && $language_type!=''){echo $language_type; } ?>";
		  if(language){
			  if(language!='en'){	
				$("#checkboxId").prop('checked', true);	
				$('#languageDropDown').val(language);
			  }else{
				  $("#checkboxId").removeAttr('checked');
				  $('#languageDropDown').prepend('<option id="english" value="en">ENGLISH</option>').val('en');
			  }
		  }
	  });
</script>

<div class="wdthpercent100 pB10" id="translControl">
	<div class="wdthpercent30 left">
		<input type="checkbox" id="checkboxId" name="language_checked" value="en" onclick="javascript: checkboxClickHandlerMessage()"></input>
		Type in Local Language
	</div>
	<div class="wdthpercent70 left">
		<select disabled="true" style="color:#F9F3DF" name="language_type" class="wdthpercent100" id="languageDropDown" onchange="javascript: languageChangeHandlerMessage()"></select>
	</div>
</div>
<div class="clear pB10"></div>

<div class="wdthpercent100 pB10 pT10">
	<div class="wdthpercent30 left">Message Subject</div>
	<div class="wdthpercent70 left">
		<input type="text" placeholder="Type or copy your message Subject here" id="message_subject" class="wdthpercent100 required" name="message_subject" value="<?php if(isset($message_subject) && $message_subject!=''){echo $message_subject; } ?>">	
	</div>
	<div class="clear"></div>
</div>
<div class="clear"></div>

<div class="wdthpercent100 pB10 googleLanguage">
	<div class="wdthpercent30 left">Write Message</div>
	<div class="wdthpercent70 left">
		<textarea placeholder="Type your message here and press spacebar" id="message" class="wdthpercent100 required" name="message" <?php if(isset($channel_id) && $channel_id =='sms'){?>onKeyDown="limitText(this.form.message,this.form.countdown,1000);" onKeyUp="limitText(this.form.message,this.form.countdown,1000);" <?php } ?>><?php if(isset($message) && $message!=''){echo $message; } ?></textarea>
		<?php if(isset($channel_id) && $channel_id =='sms'){?>
		<br class="clear" />
		<font size="1">
			(Maximum characters: 1000)
			 <span class="right">You have <input readonly type="text" name="countdown" size="3" value="1000"> characters left.</span>
		</font>	
		<?php } ?>
	</div>
	<div class="clear"></div>	
</div>
<div class="clear"></div>

<div class="wdthpercent30">
	<div class="wdthpercent100" id="errorDiv"></div>
</div>
<div class="clear"></div>

<div class="wdthpercent100 pT10">
	<div class="wdthpercent30 left">Select Message Tag</div>
	<div class="wdthpercent70 left">
		<input type="text" placeholder="Type or copy your message TAG here" id="message_tag" class="wdthpercent100 required" name="message_tag" value="<?php if(isset($message_tag) && $message_tag!=''){echo $message_tag; } ?>">	
	</div>
	<div class="clear"></div>
</div>
<div class="clear"></div>