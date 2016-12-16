<?php
/*
Plugin Name: SEO Tools by SEO Automatic 
Plugin URI: http://www.seoautomatic.com/plugins/unique-seo-tools/
Description: Unique SEO tools for your visitors or employees to perform repetetive tasks efficiently, or to otherwise save time.  Created by Search Commander, Inc. for free distribution. <br />See <a href="admin.php?page=seo-automatic-options">SEO Automatic</a> > <a href="admin.php?page=seo-automatic-seo-tools/settings.php">SEO Tools</a> for options. 
Version: 3.7.5
Author: cyber49
Author URI: http://www.seoautomatic.com/plugins/unique-seo-tools/
*/

include('schematool.php');
include('csv-merger/csv-merger.php');
include('spam-filter-tool/spam-tool.php');

//bulk url checker
function cleanData(&$str) { 
	$str = preg_replace("/\t/", "\\t", $str); 
	$str = preg_replace("/\n/", "\\n", $str);
}

    function getHttpResponseCode($url)
    {
        $ch = @curl_init($url);
        @curl_setopt($ch, CURLOPT_HEADER, TRUE);
        @curl_setopt($ch, CURLOPT_NOBODY, TRUE);
        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $status = array();
        $response = @curl_exec($ch);
        preg_match('/HTTP\/.* ([0-9]+) .*/', $response, $status);
        if ($status[1] == '301'){
	        preg_match('/location: ([^\s]+)/i', $response, $redirect);
			$statusredirect = $status[1].':|:'.$redirect[1];
		return $statusredirect;	
	
		} elseif ($response == ''){
		return 'NoResponse';

		} else 
		return trim($status[1]);
    }

function sc_404_header_scripts() {
	$sc_plugin_dir =  get_option('siteurl').'/wp-content/plugins/seo-automatic-seo-tools/sc-bulk-url-checker/';
	echo '<link rel="stylesheet" href="'.$sc_plugin_dir.'tablesorter/themes/blue/style.css" type="text/css" id="bulkurl" media="print, projection, screen" />';
}

add_action('wp_head', 'sc_404_header_scripts');

function sc_get_404_page(){
	ob_start();
		require_once(ABSPATH.PLUGINDIR.'/seo-automatic-seo-tools/sc-bulk-url-checker/index.php');
		$bulkpage = new Bulk404Object;
		$bulkpage->sc_404_page();
	$return = ob_get_contents();
	ob_end_clean();
	return $return;
}


function sc_add_404_page(){
	if(get_option('seo_tools_linkback_seotools') == 'on') {
		$seotools = '<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><small><a href="http://www.seoautomatic.com/free-tools/bulk-url-checker/" target="_blank">This Bulk Url Checker was provied by SEO Automatic</a></small>';
	} else {
		$seotools = '';
	}
	return sc_get_404_page().$seotools;
}

add_shortcode('bulkurlchecker', 'sc_add_404_page');


//feedcommander
function sc_get_feedcommander(){
ob_start();
    require_once(ABSPATH.'wp-content/plugins/seo-automatic-seo-tools/feedcommander/'.'feedcommander.php');
	$bulkpage = new feedcommander_free;
	$bulkpage->sc_feedcommander_free();
$return = ob_get_contents();
ob_end_clean();
return $return;
}


function sc_add_feedcommander(){
	if(get_option('seo_tools_linkback_seotools') == 'on') {
		$seotools = '<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><small><a href="http://www.seoautomatic.com/free-tools/feedcommander/" target="_blank">This Feed Commander was provided by SEO Automatic</a></small>';
	} else {
		$seotools = '';
	}
	return sc_get_feedcommander().$seotools;
}

add_shortcode('feedcommander', 'sc_add_feedcommander');


//link variance
class linkvariance {
	function sc_linkvariance(){
		if ($_REQUEST['run'] == "yes") {
			
			extract($_REQUEST);
			if ($nofollow == "ON") { $rel = ' rel="nofollow"'; }
			if ($newtab == "ON") { $newwin = ' target="_blank"'; }
			$keywords = "";
			 
			$list1 = preg_replace('/\r\n|\r/', ',', $input1);
			$list2 = preg_replace('/\r\n|\r/', ',', $input2);
			$list1 = explode( ",", $list1 );
			$list2 = explode( ",", $list2 );
		 
			if ($novary == "ON") { 
				$nvx = 0;
				$nv = count($list2);
				while ($nvx < $nv):
					$keywords = $keywords ."\n". '<a href="' . trim($list1[$nvx]) . '"' . $rel . $newwin . '>' . trim($list2[$nvx]) . '</a>';
					$nvx++;
				endwhile;	
			} else {		 
			   foreach( $list1 as $word1 ) {		 
				  foreach( $list2 as $word2 ) {		 		 
						$keywords = $keywords ."\n". '<a href="' . trim($word1) . '"' . $rel . $newwin . '>' . trim($word2) . '</a>';
					 }			 
				}	
			}
		}
?>

	<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" name="linkvariance">
	<input type="hidden" name="run" value="yes" />
	  <div align="center">
		
		<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="482">
		  <tr>
			<td width="100" align="center" valign="top">URL List</td>
			<td width="10" align="center" valign="top">&nbsp;</td>
			<td width="100" align="center" valign="top">Anchor Text</td>
		 </tr>
		  <tr>
			<td width="100" align="center" valign="top">
			<textarea rows="23" id="input1" name="input1" cols="24"><?php echo $input1;?></textarea></td>
			<td width="10" align="center" valign="top">&nbsp;</td>
			<td width="100" align="center" valign="top">
			<textarea rows="23" id="input2" name="input2" cols="24"><?php echo $input2;?></textarea></td>
		  </tr>
		  <tr>
			<td colspan="3" align="center" valign="top"><br />
			<input type="checkbox" name="nofollow" value="ON" checked> Add nofollow  &nbsp;<input type="checkbox" name="newtab" value="ON" checked> Open Links in New Window<br /><input type="checkbox" name="novary" value="ON"> Do not vary phrases <font size="1">(This will create just one .html link per phrase, retaining the order in which they're entered.)</font>
			<br /><input type="submit" value="Process" name="submit"> <input type="reset" value="Reset" name="B2"></td>
		  </tr>
		</table>
		
	  </div>
	  <p align="center"><textarea rows="23" id="links" name="links" cols="59"><?php echo $keywords;?></textarea></p>
	  <p>&nbsp;</p>
	</form>
<?php
	}
}

function sc_get_linkvariance(){
ob_start();
	$bulkpage = new linkvariance;
	$bulkpage->sc_linkvariance();
$keywords = ob_get_contents();
ob_end_clean();
return $keywords;
}


function sc_add_linkvariance(){
	if(get_option('seo_tools_linkback_seotools') == 'on') {
		$seotools = '<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><small><a href="http://www.seoautomatic.com/free-tools/link-variance/" target="_blank">This Link Variance Tool was provided by SEO Automatic</a></small>';
	} else {
		$seotools = '';
	}
	return sc_get_linkvariance().$seotools;
}

add_shortcode('link-variance', 'sc_add_linkvariance');


include('kwmultiplier.php');

function sc_get_keywordmarriage(){
ob_start();
	$bulkpage = new keywordmarriage;
	$bulkpage->sc_keywordmarriage();
$return = ob_get_contents();
ob_end_clean();
return $return;
}


function sc_add_keywordmarriage(){
	if(get_option('seo_tools_linkback_seotools') == 'on') {
		$seotools = '<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><small><a href="http://www.seoautomatic.com/free-tools/keyword-multiplier/" target="_blank">This Keyword Multiplier was provided by SEO Automatic</a></small>';
	} else {
		$seotools = '';
	}
	return sc_get_keywordmarriage().$seotools;
}

add_shortcode('keyword-marriage', 'sc_add_keywordmarriage');


//Landing Page Determinator
//function sc_get_lpd(){
//ob_start();
//    require_once(ABSPATH.'wp-content/plugins/seo-automatic-seo-tools/lpd/'.'index.php');
//	$bulkpage = new lpd;
//	$bulkpage->sc_lpd();
//$return = ob_get_contents();
//ob_end_clean();
//return $return;
//}
//
//
//function sc_add_lpd(){
//	if(get_option('seo_tools_linkback_seotools') == 'on') {
//		$seotools = '<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><small><a href="http://www.seoautomatic.com/unique-tools/best-page-determinator/" target="_blank">This Landing Page Determinator was provided by SEO Automatic</a></small>';
//	} else {
//		$seotools = '';
//	}
//	return sc_get_lpd().$seotools;
//}
//
//add_shortcode('lpd-tool', 'sc_add_lpd');

add_action('admin_menu', 'seo_tools_admin', 1);

function seo_tools_admin() { // Add the menu
	global $menu;
	foreach ($menu as $i) {
		$key = array_search('toplevel_page_seo-automatic-options', $i);
		if ($key != '') {
			$menu_added = true;
		}
	}
	if ($menu_added) {
	} else {
		add_menu_page('SEO Automatic by Search Commander, Inc.', 'SEO Automatic', 'activate_plugins', 'seo-automatic-options', 'seo_tools_home_page',plugins_url() . '/seo-automatic-seo-tools/images/favicon.png');
		add_submenu_page('seo-automatic-options', 'SEO Tools Admin', 'Admin', 'activate_plugins', 'seo-automatic-options', 'seo_tools_home_page');
	}
	add_submenu_page('seo-automatic-options', 'SEO Tools', 'SEO Tools', 'activate_plugins', dirname(__FILE__) . '/settings.php', 'seo_tools_settings_page');
	add_submenu_page(null, '', ' - add tool pages', 'activate_plugins', dirname(__FILE__) . '/add-tool-pages.php');
}
function seo_tools_home_page(){
	include('home.php');
}
function seo_tools_settings_page(){
	include('settings.php');
}

function seo_tools_set_linkback() {
	if (!get_option('seo_tools_linkback_url')) {
		$url = get_option('siteurl');
		update_option('seo_tools_linkback_url', $url);
	}
	if (!get_option('seo_tools_linkback_on')) {
		update_option('seo_tools_linkback_on', 'on');
	}
	if (!get_option('seo_tools_linkback_text')) {
		update_option('seo_tools_linkback_text', 'add RSS feeds to any website');
	}
}

add_action('admin_menu', 'seo_tools_set_linkback');

register_activation_hook(__FILE__,'autoseo_activate');


$directaccess = 'no';

function autoseo_activate(){
	if (get_option('autoseo_options')) {
		delete_option('seo_tools_linkback_seotools');
	}
	if (!get_option('autoseo_options'))
		seoauto_import(ABSPATH . PLUGINDIR . '/seo-automatic-seo-tools/default-settings.xml');
		update_option('seo_tools_linkback_seotools','off');
}

/*
* Load Widgets
*/
include('seo-widgets.php');

/*
* Add additional items in the header
*/
function autoseo_wp_head(){
	?>
	<link rel="stylesheet" href="<?php echo plugins_url(); ?>/seo-automatic-seo-tools/seo-automatic-styles.css" type="text/css" media="screen, projection, tv" />	
	<!--[if lte IE 6]><link rel="stylesheet" type="text/css" href="<?php echo plugins_url(); ?>/seo-automatic-seo-tools/themes/seoinspector/css/seoinspector-ie.css" media="screen, projection, tv" />
    <![endif]-->
<?php	
}

/*
* Add scripts to run tool
*/
add_action('wp_head', 'autoseo_wp_head');
if (!is_admin()){
	wp_enqueue_script('htmltooltip', plugins_url() . '/seo-automatic-seo-tools/themes/seoinspector/js/htmltooltip.js', array('jquery'));
	wp_enqueue_script('seoinspector', plugins_url() . '/seo-automatic-seo-tools/themes/seoinspector/js/seoinspector.js', array('jquery'));
}

/*
* Runs the tool
*/
function seoautomatic_run(){
	global $seoresults_tpl;
	set_include_path(ABSPATH . PLUGINDIR . '/seo-automatic-seo-tools/');
	include('index.php'); //loads smarty stuff and all options from admin are stored in $settings
	
	if ($seoresults_tpl)
		$template = 'index-results.tpl';
	elseif (!empty($settings['misc']['results-page'])) // $settings is set with the include of index.php
		$template = 'index-noajax.tpl';
	else
		$template = 'index.tpl';

	$return = $smarty->fetch($template);

	if ($settings['misc']['fixed-table']){ 
		$return ="<style>\n".
		"#results table{table-layout:fixed}\n".
		"#result table#overview{table-layout:automatic}\n". //the overview table should never expand larger than the theme allows
		"</style>\n" . $return;
	}
	if ( isset($_REQUEST['seoprint']) && isset($_REQUEST['reportid']) ){
		$return .= $smarty->fetch('partials/print-results.tpl');
	}
	return $return;
}


/*
* Save reports
*/

function autoseo_save_report($results, $url){
	global $user_ID;
	if (function_exists('aw_paypal_user_has_credits')){
		if (empty($user_ID))
			return;
		$postarray = array( 'post_author' =>  $user_ID,
		  'post_content' =>  base64_encode(serialize($results)), 
		  'post_title' => $url, 
		  'post_type' => 'seoreport'
		  );
	} else {
		$postarray = array( // we don't set post_author if the pp plugin is not installed
		  'post_content' =>  base64_encode(serialize($results)), 
		  'post_title' => $url, 
		  'post_type' => 'seoreport'
		  );
	}
	return wp_insert_post($postarray);
}

/*
* Retrieve Printer Friendly Reports
*/

function autoseo_get_report(){
	set_include_path(ABSPATH . PLUGINDIR . '/seo-automatic-seo-tools/');
	require('index.php'); //index.php does all the dirty work
	$smarty->display('partials/print-results.tpl');
}
// load printer friendly theme
function autoseo_template_filter($theme){
	global $user_ID;
	if(!isset($_GET['seoprint']))
		return $theme;
	
	$theme = 'seo-print-theme';
	return $theme;
}
add_filter('stylesheet','autoseo_template_filter');
add_filter('template','autoseo_template_filter');

/*
* Short Code
*/
function autoseo_shortcode() {
	$options = get_option('autoseo_options');
	if(get_option('seo_tools_linkback_seotools') == 'on') {
		$seotools = '<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><small><a href="http://www.seoautomatic.com/unique-tools/instant-seo-review/" target="_blank">This URL Review Lite was provided by SEO Automatic</a></small>';
	} else {
		$seotools = '';
	}
	if(isset($options['paypal']['require']))
		return seoautomatic_paypal_run($options).$seotools;
	else
		return seoautomatic_run().$seotools;
}
function autoseo_results_shortcode(){
	global $seoresults_tpl;
	$seoresults_tpl = true;
	if(get_option('seo_tools_linkback_seotools') == 'on') {
		$seotools = '<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><small><a href="http://www.seoautomatic.com/unique-tools/instant-seo-review/" target="_blank">This URL Review Lite was provided by SEO Automatic</a></small>';
	} else {
		$seotools = 'This URL Review Lite was provided by SEO Automatic';
	}
	return autoseo_shortcode().$seotools;
}
add_shortcode('seotool', 'autoseo_shortcode');
add_shortcode('urlchecker', 'autoseo_shortcode');
add_shortcode('seoresults', 'autoseo_results_shortcode');

/*
* Tracking
*/
function autoseo_tracking($url){
	$newurl =  str_replace("http://", "", $url); //incase someone entered the http://
	if (strpos($newurl, 'www.') === 0){ //get rid of the www. so we don't have repeated domains but we still allow for subdomains
		$newurl = substr($newurl, 4);
	}
	$slashpos = strpos($newurl, '/'); // get rid of everything after the /
	if ($slashpos !== false){
		$newurl = substr($newurl, 0,$slashpos);
	}
	$quepos = strpos($newurl, '?'); // get rid of everything after the ?
	if ($quepos !== false){
		$newurl = substr($newurl, 0,$quepos);
	}
	$urls = get_option('autoseo_urls'); //existing urls
	if(!is_array($urls)){
		$urls = array();
	}
	if (array_key_exists($newurl, $urls)){ //check if this url has been searched for
		$urls[$newurl] = $urls[$newurl]+1;
	} else {
		$newurl = array($newurl => 1);
		$urls = array_merge($urls, $newurl);
	}
	arsort($urls);
	update_option('autoseo_urls', $urls);
	
	// update count of how many times tool has been run
	update_option('autoseo_count', get_option('autoseo_count')+1);
}

/*
* Admin Menu
*/
add_action('admin_menu', 'autoseo_add_pages', 1);

function autoseo_add_pages() { // Add the menu
	global $menu;
	foreach ($menu as $i) {
		$key = array_search('toplevel_page_seo-automatic-options', $i);
		if ($key != '') {
			$menu_added = true;
		}
	}
	if (isset($menu_added)) {
	} else {
    add_menu_page('SEO Automatic by Search Commander, Inc.', 'SEO Automatic', 'activate_plugins', 'seo-automatic-options', 'autoseo_home_page',plugins_url() . '/seo-automatic-seo-tools/images/favicon.png');
	add_submenu_page('seo-automatic-options', 'Admin', 'Admin', 'activate_plugins', 'seo-automatic-options', 'autoseo_home_page');
	}

	$autoseo_page = add_submenu_page('seo-automatic-options', 'SEO Automatic by Search Commander, Inc.', 'URL Checker', 'activate_plugins', 'seo-automatic-plugin', 'autoseo_options_page');
	add_action( "admin_print_scripts-$autoseo_page", 'autoseo_admin_scripts' );
	add_action( "admin_head-$autoseo_page", 'autoseo_admin_head' );


}
function autoseo_home_page(){
	include('home.php');
}
function autoseo_admin_scripts(){
	//wp_enqueue_script('seoeffects', plugins_url() . '/seo-automatic-seo-tools/themes/seoinspector/js/jquery-ui-personalized-1.6rc2.min.js', array('jquery'));
	wp_enqueue_script('tablesorter', plugins_url() . '/seo-automatic-seo-tools/themes/seoinspector/js/jquery.tablesorter.min.js', array('jquery'));
	wp_enqueue_script('jqcheckbox', plugins_url() . '/seo-automatic-seo-tools/themes/seoinspector/js/jquery.checkbox.js', array('jquery'));
}
function autoseo_admin_head(){
	echo '<link rel="stylesheet" href=" ' . plugins_url() . '/seo-automatic-seo-tools/themes/seoinspector/css/tables-style.css" type="text/css" media="print, projection, screen" />';
	?>
	<script src="http://ui.jquery.com/latest/ui/effects.core.js"></script>
	<script src="http://ui.jquery.com/latest/ui/effects.slide.js"></script>
	<script type="text/javascript">
	jQuery(document).ready(function() {
	  jQuery('a#show-table').click(function() {
		jQuery('#show-table').hide();
		showtable();
		return false;
	  });
	  function showtable(){jQuery('.table-more').show();}
	});
	</script>
	<style>
	.table-more{display:none}
	td h4{margin-top:1.6em;margin-bottom:0;padding-bottom:0} 
	.problem{background-color:#FFFFCC} 
	.important{background-color:#FFCCCC} 
	.correct{background-color:#CCFFCC} 
	.checkbox{padding-left:30px}
	</style>
<?php
}

include('url-checker.php');

?>