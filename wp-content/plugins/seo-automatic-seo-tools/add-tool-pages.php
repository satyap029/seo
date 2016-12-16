<?php
include('thisplugin.php');
if (function_exists('plugins_url')) {
	$path=trailingslashit(plugins_url(basename(dirname(__FILE__))));
	} else {
	$path = dirname(__FILE__);
	$path = str_replace("\\","/",$path);
	$path = trailingslashit(get_bloginfo('wpurl')) . trailingslashit(substr($path,strpos($path,"wp-content/")));
}
	$blogpath = get_bloginfo('url');
	if (substr($blogpath, -1) != '/') {
		$blogpath.="/";
	}	
if (get_bloginfo('version') < 2.8) {
	echo '<style>.postbox-container { float: left; } #side-sortables { padding-left: 20px; }';
} else {
	echo '<style>';
}
?>
.postbox .inside { padding: 8px !important; }
#about-plugins a, #resources a {text-decoration: none;}
#about-plugins img, #resources img {float: left; padding-right: 3px;}
#success li, #success h3 {color: #006600; }
#fail li, #fail h3 {color: #ff0000; }
#resources li { clear: both; }
#about-plugins li { clear: both; }
</style>

<div class="wrap">
<br />
<div id="dashboard-widgets-wrap">
<div id='dashboard-widgets' class='metabox-holder'>

<div class='postbox-container' style='width:60%;'>
<div id='normal-sortables' class='meta-box-sortables'>

<div id="main-admin-box" class="postbox">
<h3><span><img src="<?php echo plugins_url();?>/seo-automatic-seo-tools/images/favicon.ico" alt="SEO Automatic" /> SEO Tools - Add pages</span></h3>
<div class="inside">


<?php
global $wpdb;

if ($_REQUEST['url_review_pro'] == "ON") {
	$info = array(
	'post_status' => 'publish', 
	'post_type' => 'page',
	'post_author' => 1,
	'post_title' => 'URL Checker',
	'post_content' => '[urlchecker]');
	if(wp_insert_post($info)) { echo '<p style="color: #347C17"><b>URL Checker page created.</b></p>'; } else { echo '<p style="color: #800517"><b>URL Checker page could not be created. You will have to add it through Pages > Add New.</b></p>'; }
}
if ($_REQUEST['keyword_list_multiplier'] == "ON") {
	$info = array(
	'post_status' => 'publish', 
	'post_type' => 'page',
	'post_author' => 1,
	'post_title' => 'Keyword List Multiplier',
	'post_content' => '[keyword-marriage]');
	if(wp_insert_post($info)) { echo '<p style="color: #347C17"><b>Keyword List Multiplier page created.</b></p>'; } else { echo '<p style="color: #800517"><b>Keyword List Multiplier page could not be created. You will have to add it through Pages > Add New.</b></p>'; }
}
if ($_REQUEST['bulk_url_checker'] == "ON") {
	$info = array(
	'post_status' => 'publish', 
	'post_type' => 'page',
	'post_author' => 1,
	'post_title' => 'Bulk URL Checker',
	'post_content' => '[bulkurlchecker]');
	if(wp_insert_post($info)) { echo '<p style="color: #347C17"><b>Bulk URL Checker page created.</b></p>'; } else { echo '<p style="color: #800517"><b>Bulk URL Checker page could not be created. You will have to add it through Pages > Add New.</b></p>'; }
}
if ($_REQUEST['link_variance'] == "ON") {
	$info = array(
	'post_status' => 'publish', 
	'post_type' => 'page',
	'post_author' => 1,
	'post_title' => 'Link Variance',
	'post_content' => '[link-variance]');
	if(wp_insert_post($info)) { echo '<p style="color: #347C17"><b>Link Variance page created.</b></p>'; } else { echo '<p style="color: #800517"><b>Link Variance page could not be created. You will have to add it through Pages > Add New.</b></p>'; }
}
if ($_REQUEST['rss_feed_commander'] == "ON") {
	$info = array(
	'post_status' => 'publish', 
	'post_type' => 'page',
	'post_author' => 1,
	'post_title' => 'RSS Feed Commander',
	'post_content' => '[feedcommander]');
	if(wp_insert_post($info)) { echo '<p style="color: #347C17"><b>RSS Feed Commander page created.</b></p>'; } else { echo '<p style="color: #800517"><b>RSS Feed Commander page could not be created. You will have to add it through Pages > Add New.</b></p>'; }
}
 if ($_REQUEST['url_review_lite'] == "ON" || $_REQUEST['keyword_list_multiplier'] == "ON" || $_REQUEST['bulk_url_checker'] == "ON" || $_REQUEST['link_variance'] == "ON" || $_REQUEST['rss_feed_commander'] == "ON") {
	echo '<br /><hr /><br />';
 }
if ($_REQUEST['schema_tool'] == "ON") {
	$info = array(
	'post_status' => 'publish', 
	'post_type' => 'page',
	'post_author' => 1,
	'post_title' => 'Structured Data Tool for Local Businesses',
	'post_content' => '[schematool]');
	if(wp_insert_post($info)) { echo '<p style="color: #347C17"><b>Structured Data Tool for Local Businesses page created.</b></p>'; } else { echo '<p style="color: #800517"><b>Structured Data Tool for Local Businesses page could not be created. You will have to add it through Pages > Add New.</b></p>'; }
}
 if ($_REQUEST['url_review_lite'] == "ON" || $_REQUEST['keyword_list_multiplier'] == "ON" || $_REQUEST['bulk_url_checker'] == "ON" || $_REQUEST['link_variance'] == "ON" || $_REQUEST['rss_feed_commander'] == "ON" || $_REQUEST['schema_tool'] == "ON") {
	echo '<br /><hr /><br />';
 } 
if ($_REQUEST['csv_tool'] == "ON") {
	$info = array(
	'post_status' => 'publish', 
	'post_type' => 'page',
	'post_author' => 1,
	'post_title' => 'CSV File Merger',
	'post_content' => '[csvmerger]');
	if(wp_insert_post($info)) { echo '<p style="color: #347C17"><b>CSV Merger page created.</b></p>'; } else { echo '<p style="color: #800517"><b>CSV Merger page could not be created. You will have to add it through Pages > Add New.</b></p>'; }
}
if ($_REQUEST['spam_tool'] == "ON") {
	$info = array(
	'post_status' => 'publish', 
	'post_type' => 'page',
	'post_author' => 1,
	'post_title' => 'Analytics Spam Filter Tool',
	'post_content' => '[spamtool]');
	if(wp_insert_post($info)) { echo '<p style="color: #347C17"><b>Analytics Spam Filter Tool page created.</b></p>'; } else { echo '<p style="color: #800517"><b>Analytics Spam Filter Tool page could not be created. You will have to add it through Pages > Add New.</b></p>'; }
}
?>
<p><b>You can use the shortcodes anywhere, but if you want to instantly create pages that already include the shortcode you can do that here.</b></p>
<p><b>Select which pages you would like to create:</b></p>
<form action="" method="post">
<p><input type="checkbox" name="url_review_pro" value="ON"  /> URL Checker</p>
<p><input type="checkbox" name="keyword_list_multiplier" value="ON"  /> Keyword List Multiplier</p>
<p><input type="checkbox" name="bulk_url_checker" value="ON"  /> Bulk URL Checker</p>
<p><input type="checkbox" name="link_variance" value="ON"  /> Link Variance</p>
<p><input type="checkbox" name="rss_feed_commander" value="ON"  /> RSS Feed Commander</p>
<p><input type="checkbox" name="schema_tool" value="ON"  /> Structured Data Tool for Local Businesses</p>
<p><input type="checkbox" name="csv_tool" value="ON"  /> CSV File Merger</p>
<p><input type="checkbox" name="spam_tool" value="ON"  /> Analytics Spam Filter Tool</p>
<input type="submit" value="Create Pages" />
</form>
</div></div>

</div></div>

<?php include('seoauto-sidebar.php'); ?>

<div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->

</div><!-- wrap -->