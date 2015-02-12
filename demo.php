<html>
<head>
	<link href="//www.webrtc-experiment.com/style.css" rel="stylesheet">
	<script async="" src="https://www.webrtc-experiment.com/dependencies/messenger.js"></script>
	<script src="//www.webrtc-experiment.com/RecordRTC.js"> </script>
</head>
<section class="experiment">  
	<h2 class="header">Record Audio</h2>
	<div style="height: 5em;" class="inner">
		<audio controls="" loop="" autoplay="" id="audio"></audio>
		<button id="record-audio">Record</button>
		<button disabled="" id="stop-recording-audio">Stop</button>
		<h2 id="audio-url-preview"></h2>
	</div>
</section>
<script>
	function getByID(id) {
		return document.getElementById(id);
	}

	var recordAudio = getByID('record-audio'),
		recordVideo = getByID('record-video'),
		recordGIF = getByID('record-gif'),
		stopRecordingAudio = getByID('stop-recording-audio'),
		stopRecordingVideo = getByID('stop-recording-video'),
		stopRecordingGIF = getByID('stop-recording-gif');

	var videoWidth_input = getByID('video-width-input'),
		videoHeight_input = getByID('video-height-input');

	var canvasWidth_input = getByID('canvas-width-input'),
		canvasHeight_input = getByID('canvas-height-input');

	var video = getByID('video');
	var audio = getByID('audio');

	var videoConstraints = {
		audio: false,
		video: {
			mandatory: { },
			optional: []
		}
	};

	var audioConstraints = {
		audio: true,
		video: false
	};

</script>
<script>
	var audioStream;
	var recorder;

	recordAudio.onclick = function() {
		if (!audioStream){
			navigator.getUserMedia(audioConstraints, function(stream) {
				if (window.IsChrome) stream = new window.MediaStream(stream.getAudioTracks());
				audioStream = stream;

				audio.src = URL.createObjectURL(audioStream);
				audio.play();

				// "audio" is a default type
				recorder = window.RecordRTC(stream, {
					type: 'audio'
				});
				recorder.startRecording();
			}, function() {
			});
		}else {
			audio.src = URL.createObjectURL(audioStream);
			audio.play();
			if (recorder) recorder.startRecording();
		}

		window.isAudio = true;

		this.disabled = true;
		stopRecordingAudio.disabled = false;
	};

	var screen_constraints;

	function isCaptureScreen() {
		if (document.getElementById('record-screen').checked) {
			screen_constraints = {
				mandatory: { chromeMediaSource: 'screen' },
				optional: []
			};
			videoConstraints.video = screen_constraints;
		}
	}

	stopRecordingAudio.onclick = function() {
		this.disabled = true;
		recordAudio.disabled = false;
		audio.src = '';

		if (recorder)
			recorder.stopRecording(function(url) {
				document.getElementById('audio-url-preview').innerHTML = '&lt;a href="' + url + '" target="_blank"&gt;Recorded Audio URL&lt;/a&gt;';
			});
	};
</script>