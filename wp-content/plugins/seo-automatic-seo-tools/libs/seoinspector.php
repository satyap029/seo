<?php
require_once('easywebfetch.php');
require('phpQuery/phpQuery/phpQuery.php');
//require_once('extensions.php');
require_once('gziptools.php');

//error handler function
$senderrs_heather = NULL;
function seoautoError($errno, $errstr, $errfile, $errline)  {
	global $senderrs_heather;
	if (strpos($errstr, 'Undefined index') === false && strpos($errstr, 'GZipTools') === false && strpos($errstr, 'DOMDocument') === false) {
		$senderrs_heather .= "<p><b>Error:</b> [$errno] $errstr<br />$errline - [$errfile]</p>";	
		//print_r("<p><b>Error:</b> [$errno] $errstr<br />$errline - [$errfile]</p>");
	}
}
//set error handler
set_error_handler("seoautoError");

function send_heather_errs() {
	global $url; global $senderrs_heather;
	if ($senderrs_heather != NULL) {
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'To: Heather <heather@dzynit.net>, Scott <scott@gmail.com>' . "\r\n";
		$headers .= 'From: Heather <heather@dzynit.net>' . "\r\n";
		ob_start();
		echo 'SEO Auto Tool errors - <br />';
		echo 'URL used: '.$url.'<br />';
		echo 'Hosting site: '.$_SERVER['SERVER_NAME'].'<br />';
		echo 'Tool version: '.$_SERVER["PHP_SELF"].'<br />';
		echo $senderrs_heather;
		$msg = ob_get_clean();
		mail('heather@dzynit.net', 'SEO Auto tool errors', $msg, $headers);	
	}
}

/**
 * PageObject
 * @package SEOInspector
 */
class PageObject {
	public $url;
	public $file;
	
	function __construct($url, $validate = false, $headers_only = false) {
		if ( !seoauto_is_valid_url($url) && $validate == true) {
			throw new Exception('Invalid URL: ' . $url);
		} else {
			if($headers_only != true) {
				$this->url = $url;
				$this->file = self::get(); 
			} else {
				$this->url = $url;
				$this->file = self::getHead(); 
			}
		}
	}
	
	private function get() {
		$file = new EasyWebFetch();
		$file->get($this->url);
		return($file);
	}
	
	private function getHead(){
		$file = new EasyWebFetch();
		$file->get($this->url, true);
		return($file);
	}
			
	public function size($humanize = false) {
		if ( !$r = $this->file->getHeaders('content-length') ) $r = $this->file->getHeaders('content_length');
		if ($humanize) $r = human_size($r);
		return($r);
	}
	
	public function type() {
		if ( !$r = $this->file->getHeaders('content-type') ) $r = $this->file->getHeaders('content_type');
		return($r);
	}
	
}

/**
 * SEOInspector
 * 
 * Collect data from a website relevant to search engine optimization.
 *
 * @version	0.1
 * @author 	Logan Koester <logan@logankoester.com>
 * @package SEOInspector
 *
 * @todo robots_txt() should output URL if it finds one.
 *
 */
class SEOInspector {

	/**
	 * @var string	The website you wish to inspect.
	 */
	public $url;
	
	private $html;
	private $headers;
	
	/**
	 * @var string	The <title> of the page
	 */
	public $title;
	
	/**
	 * @var mixed	The gzipped filesize (in bytes) of the page, or false if the server does not support gzip
	 */
	public $gzip;
	
	/**
	 * @var int	Uncompressed filesize (in bytes) of the page
	 */
	public $html_size;
	
	/**
	 * @var bool True if the server supports X-Cache
	 */
	public $xcache;
	
	/**
	 * @var array All <meta> tags collected from the page as an array of DOMElement objects
	 */
	public $meta;
	
  /**
   * @var array All <h1> tags collected from the page as an array of DOMElement objects
   */
	public $h1;
	
  /**
   * @var array All <h2> tags collected from the page as an array of DOMElement objects
   */	
	public $h2;

  /**
   * @var bool True if the page contains nested <table> elements
   */
	public $nested_tables;
	
  /**
   * @var bool True if -all- images on the page have a specified width and height
   */
	public $image_dimensions;

  /**
   * @var bool True if a robots.txt file is found
   */
	public $robots_txt;

	/**
	 * @var bool True if the same page exists with the www subdomain as without.
	 */
	public $canonical_url;
	
	/**
	 * @var mixed The url of the favicon if one was found, otherwise false
	 */
	public $favicon;
	
	/**
	 * @var bool True if the favicon was linked to correctly from the page,
	 * false if the favicon exists in the default location but was not linked to,
	 * or if no favicon exists.
	 */
	public $favicon_linked;

	/**
	 * @var bool True if the url is a subdomain other than www
	 */
	public $is_subdomain;
	
	/**
	 * @var array PageObject objects found in the HTML and CSS
	 */
	 public $page_objects;
	
	/**
	 * @var string "expires" header value for the first image on this domain found in the page
	 */
	 public $expires_headers;
	 
	/**
	 * @var boolean true if CSS found embedded in the page
	 */
	 public $inline_styles = false;

	/**
	 * @var boolean true if script is found embedded in the page
	 */
	 public $inline_script = false;
	 
	/**
	 * @var array list of alt attributes for images found in the page
	 */
	 public $alt_attributes;
	 		 
	/**
	 * @var array List of anchor text for links found in the page
	 */
	 public $anchor_text;
	 
	/**
	 * @var int Compressed filesize if the server were using gzip
	 */
	 public $predictive_gzip = false;
	
	/**
	 * @var int Compression ratio as a %
	 */
	 public $compression_ratio;
	 
	 public $meta_keywords = false;
	 public $meta_robots = false;
	 public $meta_description = false;

	/**
	 * @var string Configured by default to mimick Firefox 3 running on Linux
	 */
	private $user_agent = 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.1) Gecko/2008072820 Firefox/3.0.1';

	/**
	 * @param  	string	$url	The URL of the website you wish to inspect
	 * @param		string	$user_agent		Optional. Use if you want to override the default user agent
	 */
	function __construct($url, $user_agent = null) {
		if ($user_agent) $this->user_agent = $user_agent;
		// Fetch the remote page
		$website = new EasyWebFetch;
		$website->setUserAgent($this->user_agent);
		$website->get($url);
		$statusCode = $website->getStatus();
		if ($statusCode != 200) die('Please enter a valid URL which is not being redirected at the server.<br /><br />'); //throw new Exception( "\"$url\" responded with HTTP status " . $website->getStatus() );
		$url = $website->getRequestUrl();
		$this->url = $url;
		if ( is_subdomain($url) ) $this->is_subdomain = true;
		$this->html = absolute_url( $website->getContents(), base_url($url) );
		$this->headers = $website->getHeaders();
		$this->title = self::title();
		
		// Run tests on the page
		$this->gzip = self::gzip($url, $this->user_agent);
		$this->html_size = self::html_size();
		$this->xcache = self::xcache();
		$this->meta = self::meta();
		$this->h1 = self::h1();
		$this->h2 = self::h2();
		$this->nested_tables = self::nested_tables();
		$this->image_dimensions = self::image_dimensions();
		
		// Check for a robots.txt file
		$this->robots_txt = self::robots_txt();
				
		// Check for URL canonicalization
		// Don't bother if the domain being checked is a subdomain other than www
		if ( !$this->is_subdomain ) $this->canonical_url = self::canonical_url();
		
		// Look for a favicon
		$this->favicon = self::favicon();
		
		// Collect page objects
		$this->page_objects = self::page_objects();
		
		// Find an image on the daomin and check it's headers
		foreach ($this->page_objects as $obj) {
			if ( stristr($obj->type(), 'image') 
					&& parse_url($obj->url, PHP_URL_HOST) == parse_url($this->url, PHP_URL_HOST) ) {
				$this->expires_headers = self::expires_header($obj->url);
				break;
			}
		}

		// Check for inline scripts
		self::inline_script();
		
		// Get a list of image alt attributes
		$this->alt_attributes = self::alt_attributes();
		
		// Get a list of anchor text
		$this->anchor_text = self::anchor_text();

		$this->compression_ratio = (int) GZipTools::compression_ratio($this->html);
		if (!$this->gzip) $this->predictive_gzip = GZipTools::compression_filesize($this->html);
		
		// Determine what meta tags are present
		foreach ($this->meta as $tag) {
			if ( strtolower( $tag->getAttribute('name') ) == 'description' ) $this->meta_description = true;
			if ( strtolower( $tag->getAttribute('name') ) == 'robots' ) $this->meta_robots = true;
			if ( strtolower( $tag->getAttribute('name') ) == 'keywords' ) $this->meta_keywords = true;
		}
		
		// Overcomplicates var_dump, so we're removing these for dev
		$this->html = null;
		$this->headers = null;
		//send_heather_errs();
	}
	
	/**
	 * Determine whether a webserver supports gzip compression
	 *
	 * @param string $url
	 * @param string $user_agent Optional
	 * @return mixed Compressed filesize in bytes, or false
	 */
	public function gzip($url =  null, $user_agent = null) {
		$website = new EasyWebFetch;
		if (!$url) $url = $this->url;
		if ($user_agent) $website->setUserAgent($user_agent);
		$website->setExtraHeaders('Accept-Encoding: gzip, deflate');
		$website->get($url);
		if ($website->getStatus() != 200) {
			throw new Exception( "\"$url\" responded with HTTP status " . $website->getStatus() );
		} else {
			if ( @$website->getHeaders('content_encoding') == 'gzip' ) {
				return( self::html_size( $website->getContents() ) );
			} else {
				return(false);
			}
		}
	}
	
	/**
	 * Convert bytes to kilobytes, megabytes, etc
	 *
	 * @param int $bytes
	 * @return string $bytes in human-readable form, eg "50.2 MB"
	 */
	public function humanize($bytes) {
		return( human_size($bytes) );
	}
	
	public function html_size($html = null) {
		if (!$html) $html = $this->html;
		return( mb_strwidth($html) );
	}
	
	public function xcache($headers = null) {
		if (!$headers) $headers = $this->headers;
		if (isset($headers['x_cache'])) {
			return(true);
		} else {
			return(false);
		}
	}

	/**
	 * Find the title of an HTML page
	 * @param string $html
	 * @return string Contents of the <title> tag
	 */
	public function title($html = null) {
		if (!$html) $html = $this->html;
		phpQuery::newDocument($html);
		return( pq('title')->text() );
	}
	
	/**
	 * Extract <meta> tags, returning an array
	 * of DOMElement objects.
	 *
	 * @param string $html
	 * @return array <meta> DOMElements
	 */
	public function meta($html = null) {
		if (!$html) $html = $this->html;
		phpQuery::newDocument($html);
		return( pq('meta')->get() );
	}
	
	/**
	 * Extract <h1> tags, returning an array
	 * of DOMElement objects.
	 *
	 * @param string $html
	 * @return array <h1> DOMElements
	 */	public function h1($html = null) {
		if (!$html) $html = $this->html;
		phpQuery::newDocument($html);
		return( pq('h1')->get() );
	}
	
	/**
	 * Extract <h2> tags, returning an array
	 * of DOMElement objects.
	 *
	 * @param string $html
	 * @return array <h2> DOMElements
	 */
	public function h2($html = null) {
		if (!$html) $html = $this->html;
		phpQuery::newDocument($html);
		return( pq('h2')->get() );
	}
	
	/**
	 * Check if there is a robots.txt file for a given URL
	 *
	 * @param string $url
	 * @return bool
	 */
	public function robots_txt($url = null) {
		if (!$url) $url = $this->url;
		$website = new EasyWebFetch;
		$website->get( 'http://' . parse_url($url, PHP_URL_HOST) . '/robots.txt');
		if ( $website->getStatus() == '200') {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Check if there is an XML sitemap for a given URL
	 *
	 * @param string URL of the directory (or a file within) where to look
	 * @return string The URL of the sitemap if one is found.
	 */
	public function sitemap_xml($url = null) {
		if (!$url) $url = $this->url;
		$url = parse_url($url);
		
		//doesn't function when passed a path, the explode was to get rid of sitemap.xml -sc 6/18/10
		//$location = 'http://'.$url['host'].implode("/", explode("/", $url['path'], -1));
		
		$location1 = 'http://'.$url['host'].implode("/", explode("/", $url['path'], -1));
		$location2 = 'http://'.$url['host'].implode("/", explode("/", $url['path'], -2));
		$location = 'http://'.$url['host'];
		
		$urls[0] = $location . '/sitemap.xml';
		$urls[1] = $location . '/sitemap.gz';
		$urls[2] = $location . '/sitemap.xml.gz';
		$urls[3] = $location1 . '/sitemap.xml';
		$urls[4] = $location1 . '/sitemap.gz';
		$urls[5] = $location1 . '/sitemap.xml.gz';
		$urls[6] = $location2 . '/sitemap.xml';
		$urls[7] = $location2 . '/sitemap.gz';
		$urls[8] = $location2 . '/sitemap.xml.gz';
		$urls[9] = $location . '/sitemap_index.xml';
		$urls[10] = $location . '/sitemap_index.gz';
		$urls[11] = $location . '/sitemap_index.xml.gz';
		$urls[12] = $location1 . '/sitemap_index.xml';
		$urls[13] = $location1 . '/sitemap_index.gz';
		$urls[14] = $location1 . '/sitemap_index.xml.gz';
		$urls[15] = $location2 . '/sitemap_index.xml';
		$urls[16] = $location2 . '/sitemap_index.gz';
		$urls[17] = $location2 . '/sitemap_index.xml.gz';

		foreach ($urls as $candidate) {
			$sitemap_xml = new EasyWebFetch;
			$sitemap_xml->get( $candidate );
			if ($sitemap_xml->getStatus() == '200') {
				return($candidate);
				exit();
			}
		}
		return(false);
	}
	
	/**
	 * Determine if a string contains any nested HTML tables
	 *
	 * @param string $html
	 * @return bool
	 */
	public function nested_tables($html = null) {
		if (!$html) $html = $this->html;
		phpQuery::newDocument($html);
		foreach ( pq('table') as $table ) {
			$tables = pq($table)->find('table')->get();
			if ( $tables[0] ) return (true);
		}
		return(false);
	}
	
	/**
	 * Determine if the same page is served for a url
	 * with and without the www subdomain by comparing
	 * the <title>
	 *
	 * @param string $url
	 * @return bool true if no canonical url problems.
	 */
	public function canonical_url($url = null) {
		if (!$url) {
			$url = $this->url;
			
			$title = $this->title;
		} else {
			// Fetch the original page and grab it's title for comparison
			$website = new EasyWebFetch();
			$website->get($url);
			$title = self::title( $website->getContents() );
		}
		if ( preg_match('/\w+:\/\/www\..*/', $url) ) {
			$alt_url = preg_replace('/www\./', '', $url);
		} else {
			$alt_url = preg_replace('/\w+:\/\//', 'http://www.', $url);
		}
		$alt = new EasyWebFetch();
		$alt->get($alt_url);
		$html = $alt->getContents();
		phpQuery::newDocument($html);
		if ( pq('title')->text() == $title ) {
			return(true);
		} else {
			return(false);
		}
	}
	
	/**
	 * Make sure all <img> tags have width and height attributes
	 *
	 * @param string $html
	 * @return bool If an image with missing width/height attributes is found, false will be returned
	 */
	public function image_dimensions($html = null) {
		if (!$html) $html = $this->html;
		phpQuery::newDocument($html);
		foreach ( pq('img') as $image ) {
			if ( pq($image)->attr('height') ) {
				if ( !pq($image)->attr('width') ) {
					return(false); // Missing width attribute
				}
			} else {
				return(false); // Missing height attribute
			}
		}
		return(true);
	}

	/**
	 * Attempt to find a favicon on the website, first by checking the html and then by looking in
	 * the default location if no <link rel="shortcut icon"> is found. If the favicon is linked to from
	 * the html document, $this->favicon_linked will be set to true.
	 *
	 * @return string|false favicon location (may be relative) or false if none found.
	 */
	private function favicon() {
		// First check for a favicon link in the webpage (the correct method)
		phpQuery::newDocument($this->html);
		foreach ( pq('link') as $link ) {
			if ( strtolower( pq($link)->attr('rel') ) == 'shortcut icon') {
				$this->favicon_linked = true;
				return pq($link)->attr('href');
			}
		}
		// Oh well, let's see if the file exists anyway
		$this->favicon_linked = false;
		$favicon = new EasyWebFetch();
		$url = parse_url($this->url);
		$favicon_url = 'http://' . $url['host'] . '/favicon.ico';
		$favicon->get($favicon_url);
		if ( $favicon->getStatus() == '200' ) {
			return($favicon_url);
		} else {
			return(false);
		}
	}
	
	/**
	 * Check if Apache is serving images with an Expires header
	 *
	 * @param string $image_url URL must be an image
	 * @return mixed Expires value (string ) or null
	 */	
	public function expires_header($image_url = null) {
		$image = new EasyWebFetch();
		$image->get($image_url, true);
		//echo "Expires:";
		return ( $image->getHeaders('Expires') );
	}
	
	/**
	 * Scan for urls in a string of CSS code
	 * Will not recurse through css (stylesheets referenced only as
	 * an include from another stylesheet will not be indexed)
	 *
	 * @param string $css The CSS code to search through
	 * @return array Array of found urls (strings) or null.
	 */

	private function find_urls_in_css($css) {
//		$g = 0;	$newmatches = array(); $nullholder = array();
//		$nullholder = array("" => "empty");
//		preg_match_all('/url\((.*)\)/', $css, $matches);	
//		foreach ($matches[1] as $match) { 
//			$match = str_replace("'","",$match);
//			$match = str_replace('"',"",$match);
//			$match = str_replace(' ',"",$match);
//			$newmatches[1][$g] = $match;
//			$g++;
//		}
//
//		if ($matches) {
//			print_r(var_dump($newmatches[1]).'<br /><br />');
//			if (!isset($newmatches[1])) { 
//				return($nullholder);
//			} else {
//				return($newmatches[1]);
//			}
//		} else {
//			return(false);
//		}
	}

	/**
	 * Scan for embedded images, css, javascript, and css images
	 * Will not recurse through css (stylesheets referenced only as
	 * an include from another stylesheet will not be indexed)
	 *
	 * @return array Array of found PageObjects or null.
	 */		
	 
	 private function page_objects() {
		$css_files = array();
		$image_files = array();
		$script_files = array();

		phpQuery::newDocument($this->html);
		// Find inline styles	
		foreach ( pq('style') as $stylesheet ) {
			$this->inline_styles = true;
			// Find CSS images
			foreach ( self::find_urls_in_css( pq($stylesheet)->text() ) as $image) {
			//	ensure url is absolute
				$parsed_url = parse_url($image);
				if (!$parsed_url['host']) $image = base_url($this->url) . $image;
				$image_files[] = new PageObject($image, false, true);
			}
		}

		// Find external styles
		foreach ( pq('link') as $link ) {
			if ( strtolower( pq($link)->attr('type') ) === 'text/css' ) {
				$stylesheet = new PageObject( pq($link)->attr('href') );
				// Find CSS images
				foreach ( self::find_urls_in_css( $stylesheet->file->getContents() ) as $image ) {
					$parsed_url = parse_url($image);
					if (!$parsed_url['host']) $image = base_url($stylesheet->url) . $image;
					$image_files[] = new PageObject($image, false, true);
				}
				$css_files[] = $stylesheet;
			}
		}
		
		// Find images in HTML
		foreach ( pq('img') as $image ) {
			$image_files[] = new PageObject( pq($image)->attr('src'), false, true );
		}
		
		// Find external scripts
		foreach ( pq('script') as $script ) {
			if ( is_string( pq($script)->attr('src') ) ) {
				try {
					$script_files[] = new PageObject( pq($script)->attr('src') );
				} catch (exception $e) {
					
				}
			}
		}
	
	return( array_merge($css_files, $image_files, $script_files) );
	}
	
	private function inline_script() {
		phpQuery::newDocument($this->html);
		foreach ( pq('script') as $script) {
			if ( !pq($script)->attr('href') ) $this->inline_script = true;
			break;
		}
	}
	
	/**
	 * @return array|false List of ALT attribute strings for images, or false if none found
	 */
	private function alt_attributes() {
		phpQuery::newDocument($this->html);
		$alt_attributes = array();
		foreach ( pq('img') as $image) {
			if ( pq($image)->attr('alt') ) $alt_attributes[] = pq($image)->attr('alt');
		}
		if ( empty($alt_attributes) ) {
			return(false);
		} else {
			return($alt_attributes);
		}
	}
	
	/**
	 * @return array Multidimensional array of link URLs and anchor text
	 */
	private function anchor_text() {
		phpQuery::newDocument($this->html);
		$links = array();
		$i=0;
		foreach ( pq('a') as $a ) {
			if ( preg_match('/\w+/', pq($a)->text() ) ) {
				$links[$i]['url'] = pq($a)->attr('href');
				$links[$i]['text'] = trim( pq($a)->text() );
				$links[$i]['rel'] = pq($a)->attr('rel');
				
				$url1 = parse_url($this->url);
				$urlhost = $url1['host'];
				
				if (strstr($links[$i]['url'],$urlhost)){
				$links[$i]['local'] = true;} else
				{ $links[$i]['local'] = false; }
				
				/* doesn't find deep links -sc 6/19/10
				if (strstr($links[$i]['url'],$this->url)){
				$links[$i]['local'] = true;} else
				{ $links[$i]['local'] = false; }
				*/
				$i++;
			}
		}
		return($links);
	}
}

?>