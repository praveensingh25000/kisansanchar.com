<div class="wdthpercent100 pT10 pB10">
    <div class="right">
		<a class="close" onclick="javascript:loader_unshow();" href="javascript:;"></a>		
    </div>
	<form action="<?php echo URL_SITE; ?>/uploadAjax.php" method="post" id="uploaduserimageform" enctype="multipart/form-data">		
		<div class="wdthpercent100 pT10 pB10 pL30">
			<div class="wdthpercent25 left"><input type="file" name="file" class="button required"></div>
			<div class="wdthpercent10 left">
			   <input type="hidden" name="contentid" value="<?php echo $_SESSION['session_user_data']['id'];?>">
			   <input type="submit" id="upload" name="upload" value="Upload" class="button">
			</div>
			<div style="display:none;" id="progressbar" class="wdthpercent50 left progress">
				<div class="bar"></div>
		        <div class="percent">0%</div>			   
			</div>
		</div>
		<div class="clear"></div>		
	</form>	
	<div class="txtcenter" id="status"></div>
</div>

<script>
(function() {  
var bar     = $('.bar');
var percent = $('.percent');
var status  = $('#status');
var upload  = $('#upload');
var progressbar = $('#progressbar');
   
$('#uploaduserimageform').ajaxForm({
    beforeSubmit: function() {
	    return $("#uploaduserimageform").valid();
        status.empty();
        var percentVal = '0%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
		progressbar.show();
		upload.attr('disabled','true');
		upload.removeClass('button');
        var percentVal = percentComplete + '%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    success: function() {
        var percentVal = '100%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
	complete: function(xhr) {
		upload.addClass('button');
		upload.removeAttr('disabled');
		status.html(xhr.responseText);
		location.reload();
	}
}); 

})();       
</script>