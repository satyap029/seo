<?php
function autoseo_options_page() {
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

<div class="wrap seoautoreview">
<br />
<div id="dashboard-widgets-wrap">
<div id='dashboard-widgets' class='metabox-holder'>

<div class='postbox-container' style='width:60%;'>
<div id='normal-sortables' class='meta-box-sortables'>

<div id="main-admin-box" class="postbox">
<h3><span><img src="<?php echo plugins_url();?>/seo-automatic-seo-tools/images/favicon.png" alt="SEO Automatic" /> SEO Tool URL Checker</span></h3>
<div class="inside">
<?php
	if (isset($_POST['seoupload'])){
		if(seoauto_import($_FILES['seofile']['tmp_name']))
			$message = "Options Successfully Imported!";
		else
			$message = "<span style='border:1px solid red;font-weight:bold'>There was an error importing the file.  Your settings have not been changed.</span>";
	}
	if (isset($_POST['info_update'])) {
		update_option('autoseo_options', stripslashes_deep($_POST));
		$message = "Options Updated!";
	}
	if (isset($message)){
	?><div id="message" class="updated fade"><p><strong><?php echo $message; ?></strong></p></div><?php
	}
	$settings = get_option('autoseo_options');	
	// below is what displays on the options page  
	?>	
		<?php if (!is_writable(ABSPATH . PLUGINDIR . '/seo-automatic-seo-tools/writable')){?>
		<div style="width:100%;text-align:center;border:1px solid red;">In order for this tool to work this folder must be writable by the server:<br /><strong><?php echo ABSPATH . PLUGINDIR . '/seo-automatic-seo-tools/writable';?></strong></div>
		<?php } ?> 
		<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
			<input type="hidden" name="info_update" id="info_update" value="true" />
			<input type="hidden" name="app[theme]" value="seoinspector" />
	<h3>Instructions:</h3>
	
<p>You need to edit and personalize your "advice" below, and you can also uncheck each ranking factor if you'd like the report to be shorter.</p>
<p>Individual factor definitions go in the far left box, "positive feedback" result in the center, and negative items are on the the right.&nbsp;</p>
<p>Note that the boxes DO accept .html code.</p>
<p>You may define an area as a "higher priority" item by checking the box to the right of the negative comment section, which will shade those boxes red for your quick identification.</p>
<p>Also, for a few of the factors, such as page size or outbound links, use the small box to the right of each one for editing those variables to a size or quantity that YOU deem to be too large.</p>
<p>To display the tool for the end user, simply place [seotool] within the body of any page or post from the admin / edit screen, USING THE .HTML TAB.</p>
<p>The tool appears on any page where you've placed the [seotool] shortcode, and that's where the results will display.</p>
<p>Please note that sometimes, some URLs (should be under 2%) will simply fail without explanation. We're sorry, but that's the way it is.&nbsp;</p>
<p>Sometimes this is the result of some sort of redirect on the url, which is resolved after a copy / paste out of the address bar.&nbsp;</p>
<p>Other times, different web hosts have their security cranked up, and will block our scanning too for YOUR protection.&nbsp;</p>
<p>Finally, Some failures simply cannot be explained in certain situations - sort of like MS Windows. When that happens, you can usually (and inexplicably) run the report from a second installation on another domain / host of your own.  Go figure.</p>
<p>If you do need help, please feel free to contact Scott Hendison via Twitter @shendison, create a support post at SEO Automatic, or phone 877-241-4453.</p>

<br />

<table>
		<tr>
			<td><h3>Report Headers</h3></td>
		</tr>
		<tr>
			<td title="Explain the importance of the item."><input type="text" value="<?php echo $settings['heading']['overview'];?>" name="heading[overview]" class="overview" /></td>
		</tr>
		<tr>
			<td title="Result is correct."><input type="text" value="<?php echo $settings['heading']['correct'];?>" name="heading[correct]" class="correct" /></td>
		</tr>
		<tr>
			<td title="Result is incorrect and worth reviewing."><input type="text" value="<?php echo $settings['heading']['problem'];?>" name="heading[problem]" class="problem" /></td>
		</tr>
		<tr>
			<td title="Result is incorrect and demands immediate attention."><input type="text" value="<?php echo $settings['heading']['critical'];?>" name="heading[critical]" class="important" /></td>
		</tr>
		<tr>
			<td><br /><h3>Misc.</h3></td>
		</tr>
		<tr>
		<td><p><b>You can force a message to display above the tool box anywhere that the [seotool] short code is displayed by typing it into the box below.</p></td></tr>
		<tr>
			<td><h4 style="padding-top:0;margin-top:0">Message Above Form</h4></td>
		</tr>
		<tr>
			<td title="The message that is displayed above the URL form.">
			<textarea rows="3" cols="40" name="misc[top-message]"><?php echo $settings['misc']['top-message'];?></textarea></td>
		</tr>
		<tr>
			<td><h4>Submit Button text</h4></td>
		</tr>
		<tr>
			<td><input type="text" value="<?php echo $settings['misc']['button'];?>" name="misc[button]" class="button-text" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><p><input type="checkbox" name="misc[fixed-table]" <?php if($settings['misc']['fixed-table']){echo 'checked';}?> /> Fixed Tables (Play with this checkbox if you have weird theme issues with the results tables)</p></td>
		</tr>
</table><br /><table>
		<tr>
			<td><h3>Results Text</h3></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><h4 style="margin-top:0;padding-top:0">Title Tag</h4></td>
		</tr>
		<tr>
			<td>Enable&nbsp;&nbsp;<input type="checkbox" name="locale[title][enable]" id="title-enable" class="tog-enable" <?php if($settings['locale']['title']['enable']){echo 'checked';}?> /></td>
		</tr>
		<tr id="e-title-enable" <?php if(!$settings['locale']['title']['enable']){echo 'style="display:none"';}?>>
			<td><textarea name="locale[title][tooltip]" rows="5" cols="40"><?php echo $settings['locale']['title']['tooltip']; ?></textarea></td>
			<td><textarea name="locale[title][correct]" rows="5" class="correct" cols="40"><?php echo $settings['locale']['title']['correct']; ?></textarea></td>
			<td><textarea name="locale[title][problem]" id="p-title" class="problem<?php if($settings['locale']['title']['important']){echo ' important';}?>" rows="5" cols="40"><?php echo $settings['locale']['title']['problem']; ?></textarea></td>
			<td class="checkbox"><input type="checkbox" name="locale[title][important]" id="title" class="tog-imp" <?php if(isset($settings['locale']['title']['important'])){echo 'checked';}?> /></td>
		</tr>
		<tr>
			<td><h4>Description Tag</h4></td>
		</tr>
		<tr>
			<td>Enable&nbsp;&nbsp;<input type="checkbox" name="locale[description][enable]" id="description-enable" class="tog-enable" <?php if($settings['locale']['description']['enable']){echo 'checked';}?> /></td>
		</tr>
		<tr id="e-description-enable" <?php if(!$settings['locale']['description']['enable']){echo 'style="display:none"';}?>>
			<td><textarea name="locale[description][tooltip]" rows="5" cols="40"><?php echo $settings['locale']['description']['tooltip']; ?></textarea></td>
			<td><textarea name="locale[description][correct]" rows="5" class="correct" cols="40"><?php echo $settings['locale']['description']['correct']; ?></textarea></td>
			<td><textarea name="locale[description][problem]" id="p-description" class="problem<?php if($settings['locale']['description']['important']){echo ' important';}?>" rows="5" cols="40"><?php echo $settings['locale']['description']['problem']; ?></textarea></td>
			<td class="checkbox"><input type="checkbox" name="locale[description][important]" id="description" class="tog-imp" <?php if(isset($settings['locale']['description']['important'])){echo 'checked';}?> /></td>
		</tr>
		<tr>
			<td><h4>H1 Tag</h4></td>
		</tr>
		<tr>
			<td>Enable&nbsp;&nbsp;<input type="checkbox" name="locale[h1_status][enable]" id="h1_status-enable" class="tog-enable" <?php if($settings['locale']['h1_status']['enable']){echo 'checked';}?> /></td>
		</tr>
		<tr id="e-h1_status-enable" <?php if(!$settings['locale']['h1_status']['enable']){echo 'style="display:none"';}?>>
			<td><textarea name="locale[h1_status][tooltip]" rows="5" cols="40"><?php echo $settings['locale']['h1_status']['tooltip']; ?></textarea></td>
			<td><textarea name="locale[h1_status][correct]" rows="5" class="correct" cols="40"><?php echo $settings['locale']['h1_status']['correct']; ?></textarea></td>
			<td><textarea name="locale[h1_status][problem]" id="p-h1_status" class="problem<?php if($settings['locale']['h1_status']['important']){echo ' important';}?>" rows="5" cols="40"><?php echo $settings['locale']['h1_status']['problem']; ?></textarea></td>
			<td class="checkbox"><input type="checkbox" name="locale[h1_status][important]" id="h1_status" class="tog-imp" <?php if(isset($settings['locale']['h1_status']['important'])){echo 'checked';}?> /></td>
		</tr>
		<tr>			<td><h4>Keyword Meta Tag</h4></td>		</tr>
		<tr>
			<td>Enable&nbsp;&nbsp;<input type="checkbox" name="locale[keywords][enable]" id="keywords-enable" class="tog-enable" <?php if($settings['locale']['keywords']['enable']){echo 'checked';}?> /></td>
		</tr>
		<tr id="e-keywords-enable" <?php if(!$settings['locale']['keywords']['enable']){echo 'style="display:none"';}?>>
			<td><textarea name="locale[keywords][tooltip]" rows="5" cols="40"><?php echo $settings['locale']['keywords']['tooltip']; ?></textarea></td>
			<td><textarea name="locale[keywords][correct]" rows="5" class="correct" cols="40"><?php echo $settings['locale']['keywords']['correct']; ?></textarea></td>
			<td><textarea name="locale[keywords][problem]" id="p-keywords" class="problem<?php if($settings['locale']['keywords']['important']){echo ' important';}?>" rows="5" cols="40"><?php echo $settings['locale']['keywords']['problem']; ?></textarea></td>
			<td class="checkbox"><input type="checkbox" name="locale[keywords][important]" id="keywords" class="tog-imp" <?php if(isset($settings['locale']['keywords']['important'])){echo 'checked';}?> /></td>
		</tr>
		<tr>			<td><h4>Image ALT Tags</h4></td>		</tr>
		<tr>
			<td>Enable&nbsp;&nbsp;<input type="checkbox" name="locale[alt_attributes][enable]" id="alt_attributes-enable" class="tog-enable" <?php if($settings['locale']['alt_attributes']['enable']){echo 'checked';}?> /></td>
		</tr>
		<tr id="e-alt_attributes-enable" <?php if(!$settings['locale']['alt_attributes']['enable']){echo 'style="display:none"';}?>>
			<td><textarea name="locale[alt_attributes][tooltip]" rows="5" cols="40"><?php echo $settings['locale']['alt_attributes']['tooltip']; ?></textarea></td>
			<td><textarea name="locale[alt_attributes][correct]" class="correct" rows="5" cols="40"><?php echo $settings['locale']['alt_attributes']['correct']; ?></textarea></td>
			<td><textarea name="locale[alt_attributes][problem]" id="p-alt_attributes" class="problem<?php if($settings['locale']['alt_attributes']['important']){echo ' important';}?>" rows="5" cols="40"><?php echo $settings['locale']['alt_attributes']['problem']; ?></textarea></td>
			<td class="checkbox"><input type="checkbox" name="locale[alt_attributes][important]" id="alt_attributes" class="tog-imp" <?php if(isset($settings['locale']['alt_attributes']['important'])){echo 'checked';}?> /></td>
		</tr>
		</table>
		<p><input type="submit" value="Update Settings" class="button" /></p>
		</form>
<br />
		<h3>Import / Export Settings</h3>
		<h4>Import data (above) from another export (below) on another installation</h4>
		<form name="seoimport" enctype="multipart/form-data" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="POST">
			<p title="Choose an xml file to import"><input name="seofile" type="file" /></p>
			<input type="hidden" name="seoupload" value="true" />
			<input type="submit" value="Import" class="button" title="Submit" />
		</form>
		<h4>EXPORT to SAVE your work from above!</h4>
		<p title="Save a backup of your settings"><a class="button" target="_blank" href="?page=seo-automatic-plugin&seoexport=true">Download XML</a></p>
<br />
		<h3>Stats</h3>
		<?php $urls = get_option('autoseo_urls');
		if (!$urls){ ?>
		<p>It doesn't look like the tool has been used yet.  Check back later for stats.</p>
		<?php } else { ?>
		<p>wow! This tool has already been run <strong><?php echo get_option('autoseo_count'); ?> times</strong> to check <strong><?php echo count($urls); ?> domains</strong>. Can you believe that?</p>
		<p>Domains checked:</p>
		<table id="urls" class="tablesorter">
		<thead>
		<tr>
			<th>Domain</th>
			<th style="width:50px">Count</th>
		</tr>
		</thead>
		<?php
		$i=0;
		foreach ($urls as $domain => $count){ ?>
		<tr<?php if ($i > 9){echo ' class="table-more"';}?>>
			<td style="border:1px solid black"><?php echo $domain; ?></td>
			<td style="border:1px solid black"><?php echo $count; ?></td>
		</tr>
		<?php $i++;} //end foreach ?>
		</table>
		<?php if ($i > 10){echo '<a id="show-table" href="#">Show all ' . $i . ' domains.</a>';} //only print more text if we have 11 or more urls
		 } //end if urls 
		 ?>

</div></div>

</div></div>

<?php include('seoauto-sidebar.php'); ?>
<div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->

</div></div><!-- wrap -->
<?php
}

/*
* Import / Export Helpers
*/

function seoauto_import($xmlpath){
	if (empty($xmlpath))
		return false;
	include('libs/assoc_array2xml.php');
	$converter = new assoc_array2xml;
	$xml = file_get_contents($xmlpath);
	$newsettings = $converter->xml2array($xml);
	$newsettings = $newsettings['array'];
	array_walk_recursive($newsettings, 'seoauto_prepare_import');
	if(!is_array($newsettings['locale']['title'])) //validate it is an actual seoauto export
		return false;

	$oldsettings = get_option('autoseo_options');
	
	if(is_array($oldsettings['paypal']))
		$newsettings['paypal']['require'] = $oldsettings['paypal']['require']; //We don't export this setting to avoid conflicts so we will keep the original setting
	else
		unset($newsettings['paypal']['require']);
	
	update_option('autoseo_options', $newsettings);
	return true;
}
function seoauto_export(){
	if (isset($_GET['seoexport']) && current_user_can('activate_plugins')){
		include('libs/assoc_array2xml.php');
		header('Content-type: text/xml');
		header('Content-disposition: attachment; filename=seo-settings.xml');
		$array = get_option('autoseo_options');
		unset($array['paypal']['require']); // This could cause conflicts with people who do not have the paypal plugin if we left it set.
		array_walk_recursive($array, 'seoauto_prepare_export');
		$converter = new assoc_array2xml;
		$xml = $converter->array2xml($array);
		echo $xml;
		die;
	}
}
// walker functions
function seoauto_prepare_export(&$var, $key){
	$var = base64_encode($var);
}
function seoauto_prepare_import(&$var, $key){
	$var = base64_decode($var);
}
add_action('init', 'seoauto_export',99);
?>