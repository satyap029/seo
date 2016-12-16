<?php

$directaccess = substr($_SERVER['REQUEST_URI'], -38); 
if ($directaccess == '/seo-automatic-seo-tools/index.php') { 
	echo '<html><head></head><body><p>This page is not meant to be directly accessed.</p><p>To try out the SEO Automatic URL Checker, please visit <a href="http://www.seoautomatic.com/unique-tools/instant-seo-review" rel="nofollow">here</a>.</p></body></html>';
	exit();
}

	if (!class_exists('WP_Query')){
		require_once ('../../../wp-blog-header.php');
		set_include_path(ABSPATH . PLUGINDIR . '/seo-automatic-seo-tools/');
		}
	require_once('extensions.php');
	require_once('init.php');
	require_once('libs/seoinspector.php');
	$page['name'] = 'Inspect';
	global $user_ID;
	
	if (!class_exists('SEOSite')){
		class SEOSite extends SEOInspector {
			public $good = array();
			public $bad = array();
			public $ugly = array();
			public $internal_links = array();
			public $external_links = array();
			
			public $description;
			public $good_count;
			public $bad_count;
			public $ugly_count;
			public $total_page_size;
			
			public $internal_link_count = 0;
			public $external_link_count = 0;
			
		//	public $filtered_page_objects;
		
			function __construct($url) {
				parent::__construct($url);
				
				// Categorize the critical problems, problems, and successful checks
				self::analyze();
				
				// Remove checks that we don't want to display in the review

				//unset($this->good[array_search('meta', $this->good)]);

/*
				unset($this->good[array_search('h1_status', $this->good)]);
				unset($this->good[array_search('h2_status', $this->good)]);
				unset($this->good[array_search('gzip_size', $this->good)]);
				unset($this->good[array_search('alt_attributes', $this->good)]);
				unset($this->good[array_search('anchor_text', $this->good)]);
				unset($this->good[array_search('compression_ratio', $this->good)]);
				unset($this->bad[array_search('gzip_size', $this->bad)]);
				unset($this->ugly[array_search('gzip_size', $this->ugly)]);
*/
					// Count the totals
					$this->good_count = count($this->good);
					$this->bad_count = count($this->bad);
					$this->ugly_count = count($this->ugly);
						$this->total_page_size = $this->html_size;

						foreach ($this->page_objects as $obj) {
							if ($obj->size(true) != '0 Bytes') 
							$this->total_page_size += $obj->size();
							$filtered_page_objects[] = $obj;
						}

					if ($this->total_page_size < $settings['locale']['total_page_size']['max']) {$this->good[] ='total_page_size';	} else { $problems[]='total_page_size'; } 
			
				//$this->total_page_size = humanize($this->total_page_size);
				$this->page_objects = $filtered_page_objects;
			}
			private function analyze() {
				global $settings;
				if (empty($settings))
					$settings = get_option('autoseo_options');
				$problems = array();
				$this->good = array();
				if($settings['locale']['html_size']['enable']){if ($this->html_size < $settings['locale']['html_size']['max']) { $this->good[] = 'html_size'; } else { $problems[] = 'html_size'; }}
				if($settings['locale']['gzip']['enable']){if ($this->gzip) { $this->good[] = 'gzip'; } else { $problems[] = 'gzip'; $problems[]='compression_ratio';}}
				if($settings['locale']['xcache']['enable']){if ($this->xcache) { $this->good[] = 'xcache'; } else { $problems[] = 'xcache'; }}
				if($settings['locale']['keywords']['enable']){if (count($this->meta) > 0) { $this->good[] = 'meta'; } else { $problems[] = 'meta'; }}
				if($settings['locale']['h1_status']['enable']){if (count($this->h1) > 0) { $this->good[] = 'h1_status'; } else { $problems[] = 'h1_status'; }}
				if($settings['locale']['h2_status']['enable']){if (count($this->h2) > 0) { $this->good[] = 'h2_status'; } else { $problems[] = 'h2_status'; }}
				if($settings['locale']['robots_txt']['enable']){if ($this->robots_txt) { $this->good[] = 'robots_txt'; } else { $problems[] = 'robots_txt'; }}
				if($settings['locale']['canonical_url']['enable']){if (!$this->is_subdomain) if ($this->canonical_url) { $this->good[] = 'canonical_url'; } else { $problems[] = 'canonical_url'; }}
				if($settings['locale']['nested_tables']['enable']){if (!$this->nested_tables) { $this->good[] = 'nested_tables'; } else { $problems[] = 'nested_tables'; }}
				if($settings['locale']['image_dimensions']['enable']){if ($this->image_dimensions) { $this->good[] = 'image_dimensions'; } else { $problems[] = 'image_dimensions'; }}
				if($settings['locale']['expires_headers']['enable']){if ($this->expires_headers) { $this->good[] = 'expires_headers'; } else { $problems[] = 'expires_headers'; }}
				if($settings['locale']['inline_styles']['enable']){if (!$this->inline_styles) { $this->good[] = 'inline_styles'; } else { $problems[] = 'inline_styles'; }}
				if($settings['locale']['inline_script']['enable']){if (!$this->inline_script) { $this->good[] = 'inline_script'; } else { $problems[] = 'inline_script'; }}
				if($settings['locale']['favicon']['enable']){if ($this->favicon) { $this->good[] = 'favicon'; } else { $problems[] = 'favicon'; }}
				if($settings['locale']['favicon_linked']['enable']){if ($this->favicon_linked) { $this->good[] = 'favicon_linked'; } else { $problems[] = 'favicon_linked'; }}
				if($settings['locale']['alt_attributes']['enable']){if ($this->alt_attributes) { $this->good[] = 'alt_attributes'; } else { $problems[] = 'alt_attributes'; }}
				if($settings['locale']['anchor_text']['enable']){if ($this->anchor_text) { $this->good[] = 'anchor_text'; } else { $problems[] = 'anchor_text'; }}
				
				if($settings['locale']['title']['enable']){if ($this->title) {$this->good[] = 'title';} else {$problems[]= 'title';}}
				if($settings['locale']['description']['enable']){if ($this->meta_description) {$this->good[] = 'description';} else { $problems[]= 'description';  }}
				if($settings['locale']['robots']['enable']){if ($this->meta_robots) { $this->good[] = 'robots'; } else { $problems[]= 'robots';  }}
				if($settings['locale']['keywords']['enable']){if ($this->meta_keywords) { $this->good[] = 'keywords'; } else { $problems[]= 'keywords';  }}
				
				foreach ($this->anchor_text as $link){
					if ($link['local']) {
						if($settings['locale']['internal_link']['enable']){
							$this->internal_link_count += 1;
							$this->internal_links[] = $link;
						}
					}
					else{ 
						if($settings['locale']['external_link']['enable']){
							$this->external_link_count +=1;
							$this->external_links[] = $link;
						}
						}
				}
				if($settings['locale']['internal_link']['enable']){
					if ($this->internal_link_count <= $settings['locale']['internal_link']['max']) {
						$this->good[] = 'internal_link';
					} else { $problems[] = 'internal_link';}
				}
				if($settings['locale']['external_link']['enable']){
					if ($this->external_link_count <= $settings['locale']['external_link']['max']) {
						$this->good[] = 'external_link';
					} else { $problems[] = 'external_link';}
				}
				// Separate bad and ugly from $problems
				foreach ($problems as $problem) {
					if ($settings['locale'][$problem]['important']) {
						$this->ugly[] = $problem;
					} else {
						$this->bad[] = $problem;
					}
				}
			}
		}
	}
	
	/******************************************/
	
	$smarty->assign('extend_header', '
		<script src="themes/' . $settings['app']['theme'] . '/js/seoinspector.js" type="text/javascript"></script>
	');
	$smarty->compile_dir = ABSPATH . PLUGINDIR . '/seo-automatic-seo-tools/writable';
	//$smarty->template_dir = ABSPATH . PLUGINDIR . '/seo-automatic-seo-tools/libs/smarty/templates';
	$smarty->config_dir = ABSPATH . PLUGINDIR . '/seo-automatic-seo-tools/libs/smarty/configs';
	$smarty->plugins_dir = array(ABSPATH . PLUGINDIR . '/seo-automatic-seo-tools/libs/smarty/plugins');
	/*****************************************/
	$smarty->assign('page', $page);
	if(empty($_REQUEST['url']) && !empty($_POST['seourl']))
		$_REQUEST['url'] = $_POST['seourl'];
	if ( isset($_REQUEST['url']) || isset($_POST['seourl']) || isset($_REQUEST['seoprint']) ) {
		$url = ensure_url_scheme($_REQUEST['url'], 'http');
		if (empty($_REQUEST['url']))
			die('That doesn\'t look like a valid url.');
		
		if ( seoauto_is_valid_url($url) ) {
			$settings = get_option('autoseo_options');
			if(function_exists('aw_paypal_user_has_credits') && $settings['paypal']['require']){ 
				if(!aw_paypal_user_has_credits()){
					die("Oops! You don't have enough credits to run that report.");
				}
				aw_paypal_charge_credits();
			}
			$smarty->assign('url', $url);
			if ($settings['ungrouped']['resultset']) { $showungrouped = 'ON'; } else { $showungrouped = 'OFF'; } //Heather
			$smarty->assign('showungrouped', $showungrouped); //Heather
			$results = new SEOSite($url);
			$smarty->assign_by_ref('results', $results);
			
			//$postid = autoseo_save_report($results, $url); // function defined in seo-automatic.php
			if(empty($user_ID))
				$token = '&token=' . wp_create_nonce(wp_salt() . $postid); //add a nonce to the end of print urls for security

			$smarty->assign('print_url', unslash_url($_POST['ref']) . '/?url='.$url.'&seoprint=1' . $token);

			if ( isset($_REQUEST['seoprint'])){
					$smarty->assign('url', $url);
			} else {
					autoseo_tracking($url);
			}

		} else {
			$smarty->assign('error', "Oops! You need to enter a valid URL.");
		}
	}
	//Print Versions
	if ( isset($_REQUEST['seoprint']) && isset($_REQUEST['reportid']) ){
//		if (empty($_REQUEST['reportid']))
//			die('There was a problem accessing this report');
//		error_reporting(0);
//		$report = get_post($_REQUEST['reportid']);
//		$results = unserialize(base64_decode($report->post_content));
//		if (isset($_REQUEST['token'])){
//			if (!wp_verify_nonce($_REQUEST['token'], wp_salt() . $report->ID))
//				die('You are not authorized to access that report.');
//		} else {
//			if(!current_user_can('activate_plugins') && $report->post_author != $user_ID)
//				die('You are not authorized to access that report');
//		}
//		$smarty->assign('url', $report->post_title);
	}

	if ( isset($_REQUEST['output']) ) {
		
		if ($_REQUEST['output'] == 'html') {
			$smarty->display('partials/results.tpl');
		} elseif ($_REQUEST['output'] == 'pdfhtml') {
			$smarty->assign('pdf', true);
			$smarty->display('partials/results.tpl');
		}
	} else {
		global $post;
		if(!$post && !is_admin())
			die('please don\'t access this page directly');
		//$smarty->display('index.tpl');
	}
?>