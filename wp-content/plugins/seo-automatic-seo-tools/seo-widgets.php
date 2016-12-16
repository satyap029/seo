<?php
/*
* SEO Widget
*/
function autoseo_widget($args){
	extract($args);
	$option = get_option('autoseo_widget');
	$title = str_replace('[br]', '<br />', $option['title']);
	$before = $option['before'];
	$after = $option['after'];
	?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<?php echo $before; ?>
			<form id="autoseo-widget-form" method="GET" action="<?php echo $option['url']; ?>">
				<input id="autoseourl" name="url" type="text" value="" />
				<input type="submit" value="<?php echo $option['button']; ?>" />
			</form>
			<?php echo $after; ?>
		<?php echo $after_widget; ?>
<?php
}
function autoseo_widget_control() {
	$options = $newoptions = get_option('autoseo_widget');
	if ( isset($_POST['autoseo-widget-submit']) ) {
		$_POST = stripslashes_deep($_POST);
		$newoptions['title'] = $_POST['autoseo-widget-title'];
		$newoptions['url'] = $_POST['autoseo-widget-url'];
		$newoptions['button'] = $_POST['autoseo-widget-button'];
		$newoptions['before'] = $_POST['autoseo-widget-before'];
		$newoptions['after'] = $_POST['autoseo-widget-after'];
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('autoseo_widget', $options);
	}
	$title = attribute_escape($options['title']);
	$url = $options['url'];
	$button = $options['button'];
	$before = $options['before'];
	$after = $options['after'];
?>
			<p><label for="autoseo-widget-title">Title: (<small>force line break with [br]</small>)<input class="widefat" id="autoseo-widget-title" name="autoseo-widget-title" type="text" value="<?php echo $title; ?>" /></label></p>
			<p>Results Page:
			<select class="widefat" id="autoseo_widget_page" name="autoseo-widget-url">
			<?php $pages = get_pages(); 
			foreach ($pages as $page){
				$selected = '';
				$pageurl = get_permalink($page->ID);
				if ($url == $pageurl){
					$selected = 'selected="selected"';
				}?>
				<option value="<?php echo get_permalink($page->ID);?>" <?php echo $selected;?>><?php echo $page->post_title; ?></option>
			<?php } ?>
			</select>
			</p>
			<p>Before Form: (<small>html ok</small>)<br />
			<textarea class="widefat" name="autoseo-widget-before"><?php echo $before; ?></textarea>
			</p>
			<p>Button Text:<br /></p>
			<input name="autoseo-widget-button" type="text" value="<?php echo $button; ?>" class="button" style="cursor:text" />
			</p>
			<p>After Form: (<small>html ok</small>)<br />
			<textarea class="widefat" name="autoseo-widget-after"><?php echo $after; ?></textarea>
			<input type="hidden" id="autoseo-widget-submit" name="autoseo-widget-submit" value="1" />
<?php
}

/*
* Register Widgets
*/
function autoseo_widget_reg(){
	register_sidebar_widget('SEO Automatic', 'autoseo_widget');
	register_widget_control('SEO Automatic', 'autoseo_widget_control', null, 75);
}

add_action('init', 'autoseo_widget_reg'); // register widgets
?>