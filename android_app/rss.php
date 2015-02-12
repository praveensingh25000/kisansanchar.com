<?php
$ch = curl_init();
$timeout = 5; // in seconds, you can change this lower if you want
curl_setopt ($ch, CURLOPT_URL, 'http://app.feed.informer.com/digest3/XH5R8RMWKS.html');
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$file_contents = curl_exec($ch);
curl_close($ch);
echo $file_contents;
?>