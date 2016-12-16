<?php
	if (!class_exists('WP_Query')){
		require_once ('../../../wp-blog-header.php');
		set_include_path(ABSPATH . PLUGINDIR . '/seo-automatic-seo-tools/');
		}

	// Make sure magic_quotes_gpc is disabled
	if (get_magic_quotes_gpc()) {
	  $_POST = array_map('stripslashes_deep', $_POST);
	  $_GET = array_map('stripslashes_deep', $_GET);
	  $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
	  $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
	}

	require_once('libs/smarty/Smarty.class.php');
	require_once ('extensions.php');
	
	// Load settings
	$settings = get_option('autoseo_options');
	if (!$settings) {
		echo "<h1>Congratulations, it works!</h1>You need to set up a few things from the
		admin panel, though.\n";
	}
	
	// Remove trailing slash if there is one
	$settings['app']['url'] = unslash_url(plugins_url() . '/seo-automatic-seo-tools/');
	//print_r(get_option('a0seo-1956'));

	// Initialize templating engine
	$smarty = new Smarty();
	$smarty->template_dir = ABSPATH . PLUGINDIR . '/seo-automatic-seo-tools/themes/' . $settings['app']['theme'] . '/templates';
	$smarty->compile_dir = ABSPATH . PLUGINDIR . '/seo-automatic-seo-tools/writable';
	$smarty->cache_dir = ABSPATH . PLUGINDIR . '/seo-automatic-seo-tools/libs/smarty/cache';
	$smarty->config_dir = ABSPATH . PLUGINDIR . '/seo-automatic-seo-tools/libs/smarty/configs';
	
//	if ($settings['debug']) {
		$smarty->force_compile = true;
//	} else {
//		$smarty->force_compile = false;
//	}
	global $post, $user_ID;
	if(!empty($settings['misc']['results-page']))
		$urlpath = $settings['misc']['results-page'];
	else
		$urlpath = unslash_url('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

	if(isset($_POST['seourl']))
		$url2 =str_replace("http://", "", isset($_POST['seourl']));
	else
		$url2 = str_replace("http://", "", isset($_GET['url']));

	if ($url2 == '1') { $url2 = ''; }
	$seoautorun = plugins_url().'/seo-automatic-seo-tools/index.php';

	$smarty->assign( 'app', $settings['app']); // Site Branding
	$smarty->assign( 'locale', $settings['locale']);
	$smarty->assign( 'this_theme', plugins_url() . '/seo-automatic-seo-tools/themes/' . $settings['app']['theme']);
	$smarty->assign( 'navigation', isset($settings['navigation']));
	$smarty->assign( 'this_page', get_permalink($post->ID)); //for permalinks
	$smarty->assign( 'perma_page', unslash_url(isset($_POST['ref']))); //for permalinks
	$smarty->assign( 'heading_correct', $settings['heading']['correct']);
	$smarty->assign( 'heading_problem', $settings['heading']['problem']);
	$smarty->assign( 'heading_critical', $settings['heading']['critical']);
	$smarty->assign( 'heading_overview', $settings['heading']['overview']);
	$smarty->assign( 'button_text', $settings['misc']['button']);
	$smarty->assign( 'url_path', $urlpath);
	$smarty->assign( 'analyze_loader', 'analyze');
	$smarty->assign( 'url2', $url2);
	$smarty->assign( 'seoautorun', $seoautorun);
	$smarty->assign( 'top_message', str_replace('[number-credits]', get_usermeta($user_ID,'paypalcredits'), $settings['misc']['top-message']));
	// Disable functions
	$smarty->assign('title_enable', $settings['locale']['title']['enable']);
	$smarty->assign('description_enable', $settings['locale']['description']['enable']);
	$smarty->assign('h1_status_enable', $settings['locale']['h1_status']['enable']);
	$smarty->assign('h2_status_enable', $settings['locale']['h2_status']['enable']);
	$smarty->assign('keywords_enable', $settings['locale']['keywords']['enable']);
	$smarty->assign('image_dimensions_enable', $settings['locale']['image_dimensions']['enable']);
	$smarty->assign('expires_headers_enable', $settings['locale']['expires_headers']['enable']);
	$smarty->assign('robots_enable', $settings['locale']['robots']['enable']);
	$smarty->assign('robots_txt_enable', $settings['locale']['robots_txt']['enable']);
	$smarty->assign('canonical_url_enable', $settings['locale']['canonical_url']['enable']);
	$smarty->assign('nested_tables_enable', $settings['locale']['nested_tables']['enable']);
	$smarty->assign('inline_styles_enable', $settings['locale']['inline_styles']['enable']);
	$smarty->assign('inline_script_enable', $settings['locale']['inline_script']['enable']);
	$smarty->assign('favicon_enable', $settings['locale']['favicon']['enable']);
	$smarty->assign('favicon_linked_enable', $settings['locale']['favicon_linked']['enable']);
	$smarty->assign('alt_attributes_enable', $settings['locale']['alt_attributes']['enable']);
	$smarty->assign('anchor_text_enable', $settings['locale']['anchor_text']['enable']);
	$smarty->assign('internal_link_enable', $settings['locale']['internal_link']['enable']);
	$smarty->assign('external_link_enable', $settings['locale']['external_link']['enable']);
	$smarty->assign('total_page_size_enable', $settings['locale']['total_page_size']['enable']);
	$smarty->assign('html_size_enable', $settings['locale']['html_size']['enable']);
	$smarty->assign('gzip_enable', $settings['locale']['gzip']['enable']);
	$smarty->assign('compression_ratio_enable', $settings['locale']['compression_ratio']['enable']);
	$smarty->assign('gzip_size_enable', $settings['locale']['gzip_size']['enable']);
	$smarty->assign('xcache_enable', $settings['locale']['xcache']['enable']);

	$page = array(); // Page-specific hash of template assignments (such as page title for building the <title> tag, form values, etc)
?>
