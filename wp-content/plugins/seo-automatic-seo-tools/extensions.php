<?php
	/********* USEFUL CONSTANTS *********/
	$alphabet = array( 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z' );

	/********* MATH *********/
	function human_size($size) {
		$filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
		return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
	}

	/********* STRING UTILITIES *********/
	function unslash_url($url) {
		// Removes the trailing slash from a url, if there is one
		if ( substr($url, -1) == '/') {
			return( rtrim($url, '/') );
		} else {
			return($url);
		}
	}
	
	/**
	 * Determine if a string is a url containing a subdomain other than www
	 *
	 * @param string $url
	 * @return bool
	 */
	function is_subdomain($url) {
		if ( preg_match('/(.*)\..*\..*/', $url, $subdomain) ) {
			if ( !stristr($subdomain[1], 'www') ) return (true);
		} else {
			return(false);
		}
	}
	
	function seoauto_is_valid_url($url) {
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	}
	
	/**
	 * Ensure that a url includes the protocol to use.
	 *
	 * @param string $url
	 * @param string $scheme Protocol to add if none exists
	 * @return string
	 */
	function ensure_url_scheme($url, $scheme = 'http') {
		if ( preg_match("/\w+\:\/\/.+/U", $url) ) {
			return($url);
		} else {
			return($scheme . '://' . $url);
		}
	}


	// Convert relative urls found in html $txt to absolute urls
	function absolute_url($txt, $base_url){
		$needles = array('href="', 'src="', 'background="');
		$new_txt = '';
		if(substr($base_url,-1) != '/') $base_url .= '/';
		$new_base_url = $base_url;
		$base_url_parts = parse_url($base_url);

		foreach($needles as $needle){
		  while($pos = strpos($txt, $needle)){
		    $pos += strlen($needle);
		    if(substr($txt,$pos,7) != 'http://' && substr($txt,$pos,8) != 'https://' && substr($txt,$pos,6) != 'ftp://' && substr($txt,$pos,9) != 'mailto://'){
		      if(substr($txt,$pos,1) == '/') $new_base_url = $base_url_parts['scheme'].'://'.$base_url_parts['host'];
		      $new_txt .= substr($txt,0,$pos).$new_base_url;
		    } else {
		      $new_txt .= substr($txt,0,$pos);
		    }
		    $txt = substr($txt,$pos);
		  }
		  $txt = $new_txt.$txt;
		  $new_txt = '';
		}
		return $txt;
	}
	
	// Return everything before the last "/"
	function base_url($url) {
		$parsed = parse_url($url);
		$parts = explode('/', $parsed['path']);
		$file = array_pop($parts);
		return( $parsed['scheme'] . '://' . $parsed['host'] . implode('/', $parts) . '/' );
	}
	
	/********* ARRAY UTILITIES *********/
	function array_ul($a, $ul = "<ul>", $li = "<li>") {
		// Accepts an array and returns an unordered html list of it's elements
		// Optional $tag and $li parameters allows you to set attributes (such as <ul class="">)
		$list = $ul;
		foreach ($a as $item) {
			$list = $list . $li . $item . "</li>";
		}
		$list = $list . "</ul>";
		return($list);
	}
	
	function starts_with_in_array($letter, $array) {
		// Returns all the elements of $array that start with the char $letter
		$results = array();
		foreach ($array as $element) {
			if ( strtolower($element{0}) == strtolower($letter) ) {
				$results[] = $element;
			}
		}
		return $results;
	}
	
	function set_default($array, $key, $value) {
		if ( !array_key_exists($key, $array) ) $array[$key] = $value;
		return ($array);
	}
	
	/********* SESSIONS *********/
	
	function ensure_admin() {
		session_start();
		header("Cache-control: private");
		if ($_SESSION["access"] == "granted") {
			return(true);
		} else {
			header("Location: ./login");
		}
	}
	
	/********* FORM VALIDATION *********/
	class FormValidator {
		
	    function validate_email($email, $checkDomain = false) {
	    	$regex = '/^((\"[^\"\f\n\r\t\v\b]+\")|([\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+(\.[\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+)*))@((\[(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))\])|(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))|((([A-Za-z0-9\-])+\.)+[A-Za-z\-]+))$/';
			
	        if (preg_match($regex, $email)) {
	            if ($checkDomain && function_exists('checkdnsrr')) {
	                $tokens = explode('@', $email);
	                if (checkdnsrr($tokens[1], 'MX') || checkdnsrr($tokens[1], 'A')) {
	                    return true;
	                }
	                return false;
	            }
	            return true;
	        }
	        return false;
	    }

	}
	
	/********* NAVIGATION *********/
	function alpha_navigation($url_prefix = '', $url_suffix = '') {
		global $alphabet;
		// Returns each letter in an array with a url and a name
		$i=0;
		foreach ($alphabet as $letter) {
			$links[$i]['name'] = strtolower($letter);
			$links[$i]['url'] = $url_prefix . strtolower($letter) . $url_suffix;
			$i++;
		}
		return($links);
	}
	
	/********* DEBUGGING / ERROR HANDLING *********/
	
	/**
	 * Capture HTML-formatted var_dump contents (returned, not displayed)
	 * @param mixed $var
	 * @param string $pre_attributes Injected into <pre> tag
	 * @return string The <pre>-wrapped var_dump contents
	 */
	function var_dump_html($var, $pre_attributes = '') {
		$out = "\n<pre $pre_attributes>\n";
		ob_start();
		var_dump($var);
		$out .= htmlspecialchars( ob_get_contents(), ENT_QUOTES );
		ob_end_clean();
		$out .= "\n</pre>\n";
		return($out);
	}
?>
