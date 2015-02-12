<?php
/******************************************
* @Modified on April 29, 2014
* @Package: kisansanchar
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

Class videoEmbed {

	function escape_data ($data){
		global $db; //declares by mysql_connect global
		if (ini_get('magic_quotes_gpc')) {
			$data = stripslashes($data);
		}
		return mysql_real_escape_string(trim($data), $db);
	} 

	function embeddedvideo($embbedcode){
		
		global $DOC_ROOT;		
		$root_path = $DOC_ROOT;

		if (strstr( $embbedcode, "vimeo.com" ) ){
			
			/*Vimeo Section */
			$urlid      = explode("http://vimeo.com/moogaloop.swf?clip_id", $embbedcode);
			$videoid    = explode("=",$urlid[1]);
			$expvideoid = explode("&",$videoid[1]);
			$imgid      = $expvideoid[0];
			$hash       = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
			
			/*Getting url from embbed code Vimeo*/				
			$imagelink  = $hash[0]['thumbnail_small'];
			$vediolink  = 'http://vimeo.com/'.$imgid;

		}elseif(strstr( $embbedcode, "yahoo.com" ) ){

			//yahoo.com
			$url        = explode("&", $embbedcode);
			$linkis     = explode("=",$url[1]);
			$videoid    = $linkis[1];
			$finalurl   = explode("=",$url[4]);
			$expstring  = explode("%3A", $finalurl[1]);

			/*Getting url from embbed code Yahoo*/				
			$imagelink  = "http:".$expstring[1];
			$vediolink  = 'http://video.yahoo.com/watch/'.$videoid;

		}else if(strstr($embbedcode, "youtube.com" )){

			$url = explode("/v/", $embbedcode);
			$vid = explode("\"",$url[1]);
			$vid = explode("&",$vid[0]);			
			$vi_id =  trim(trim(substr($vid[0],0, strpos($vid[0],"?")),"/"));
			$card['thumb'] = "http://img.youtube.com/vi/".$vi_id."/2.jpg";	
			
			//Getting url from embbed code Youtube				
			$imagelink = $card['thumb'];		
			$vediolink = 'http://www.youtube.com/watch?v='.$vid[0];

		}else if(strstr( $embbedcode, "google.com" )){
			
			//$code = explode(" ", $embbedcode);
			//$videoid_part1 = explode("=", $code[2]);
			//$videoid_part2 = explode("&", $videoid_part1[2])
			
			//require_once("rsslib.php");
			//$url       = "http://video.google.com/videofeed?docid=".$videoid_part2[0];
			//$string    =  RSS_Display($url, 15, true);
			
			//$arr       = explode('<img src=', $string);
			//$imgurl    = explode(' ', $arr[1]);
			//$code      = explode(" ", $embbedcode);

			//$length    = strlen($code[2]);
			//$imagelink = $imgurl[0];
			//$vediolink = substr($code[2], 4 , $length);
		}
		return array($imagelink, $vediolink, $embbedcode);
	}

	function embededcodewithurl($inputembbedcode){
		
		global $DOC_ROOT;
		$root_path = $DOC_ROOT;

		if(strstr($inputembbedcode, "youtube.com" )){			
			
			$url		   = explode("=", $inputembbedcode);
			$url2		   = explode("&", $url[1]);

			$card['thumb'] = "http://img.youtube.com/vi/".$url2[0]."/2.jpg";				
			/*Getting url from embbed code Youtube*/				
			$imagelink     = $card['thumb'];		
			$vediolink     = 'http://www.youtube.com/watch?v='.$url2[0];
			$embedcode     = '<object width="470" height="320"><param name="movie" value="http://www.youtube.com/v/'.$url2[0].'&hl=en_US&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/'.$url2[0].'&hl=en_US&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385"></embed></object>';

		} else if(strstr( $inputembbedcode, "vimeo.com" )){

			$url		= explode("/", $inputembbedcode);
			$imgid		= $url[3];	
			$hash		= unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));

			/*Getting url from embbed code Vimeo*/				
			$imagelink  = $hash[0]['thumbnail_small'];
			$vediolink  = 'http://vimeo.com/'.$imgid;

			$embedcode ='<object width="470" height="320"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id='.$imgid.'1&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=00adef&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id='.$imgid.'&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=00adef&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="400" height="225"></embed></object>';

		}else if(strstr( $inputembbedcode, "yahoo.com" )){
			
			$url		= explode("/", $inputembbedcode);
			$vid		= $url[4];
			if(!empty($url[5])){
				$id		= $url[5];
			}
			$url		= $inputembbedcode;
			$page		= self::get_web_page($url);
			$array		= explode("image_src" , $page['content'] );
			$image		= explode('"' , $array[1]);
			$imagelink	= $image[2];
									
			if(!empty($id)){
				$vediolink='http://video.yahoo.com/watch/'.$vid.'/'.$id;
				$embedcode='<object width="470" height="320"><param name="movie" value="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.46" /><param name="allowFullScreen" value="true" /><param name="AllowScriptAccess" VALUE="always" /><param name="bgcolor" value="#000000" /><param name="flashVars" value="id='.$id.'&vid='.$vid.'&lang=en-us&intl=us&thumbUrl='.$fullpath.'&embed=1" /><embed src="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.46" type="application/x-shockwave-flash" width="512" height="322" allowFullScreen="true" AllowScriptAccess="always" bgcolor="#000000" flashVars="id='.$id.'&vid='.$vid.'&lang=en-us&intl=us&thumbUrl='.$fullpath.'&embed=1" ></embed></object>';
			}else{
				$vediolink='http://video.yahoo.com/watch/'.$vid;
				$embedcode= '<object width="470" height="320"><param name="movie" value="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.46" /><param name="allowFullScreen" value="true" /><param name="AllowScriptAccess" VALUE="always" /><param name="bgcolor" value="#000000" /><param name="flashVars" value="vid='.$vid.'&lang=en-us&intl=us&thumbUrl='.$fullpath.'&embed=1" /><embed src="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.46" type="application/x-shockwave-flash" width="512" height="322" allowFullScreen="true" AllowScriptAccess="always" bgcolor="#000000" flashVars="vid='.$vid.'&lang=en-us&intl=us&thumbUrl='.$fullpath.'&embed=1&ap=10513021" ></embed></object>';
			}		
		}else if(strstr( $inputembbedcode, "google.com" )){

			//$fromurl   = explode("docid=" , $inputembbedcode);
			//$video_id  = explode("#" , $fromurl[1]);
			
			//require_once("rsslib.php");
			//$url       = "http://video.google.com/videofeed?docid=".$video_id[0];
			//$string    =  RSS_Display($url, 15, true);
			
			//$arr       = explode('<img src=', $string);
			//$imgurl    = explode(' ', $arr[1]);
			
			//$imagelink = $imgurl[0];
			//$vediolink = $inputembbedcode;
			//$embedcode = '<embed id=VideoPlayback src=http://video.google.com/googleplayer.swf?docid='.$video_id[0].'&hl=en&fs=true style=width:400px;height:326px allowFullScreen=true allowScriptAccess=always type=application/x-shockwave-flash> </embed>';
								
		}
		return array($imagelink, $vediolink, $embedcode);	
	}

	function get_web_page( $url ){

		$options = array(
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => false,    // don't return headers
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_USERAGENT      => "spider", // who am i
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
			CURLOPT_TIMEOUT        => 120,      // timeout on response
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
		);
	    
		$ch      = curl_init( $url );
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$header  = curl_getinfo( $ch );
		curl_close( $ch );

		$header['errno']   = $err;
		$header['errmsg']  = $errmsg;
		$header['content'] = $content;
		return $header;
	}
}
?>