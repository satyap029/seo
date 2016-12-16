<?php /* Smarty version 2.6.18, created on 2016-10-21 06:00:06
         compiled from partials/results.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'partials/results.tpl', 19, false),)), $this); ?>
<h2>Summary for <?php echo $this->_tpl_vars['url']; ?>
</h2>

<table id="overview">
	<tbody>
		<tr class="even" style="font-size:14px;font-weight:bold;">
			<td><?php echo $this->_tpl_vars['heading_overview']; ?>
</td>
			<td style="color:red;text-align:center;">&bull; <?php if (! empty ( $this->_tpl_vars['results']->ugly )): ?><a style="color:red;" href="#critical"> <?php echo $this->_tpl_vars['results']->ugly_count; ?>
 <?php echo $this->_tpl_vars['heading_critical']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['results']->ugly_count; ?>
 <?php echo $this->_tpl_vars['heading_critical']; ?>
<?php endif; ?></td>
			<td style="color:orange;text-align:center;">&bull; <?php if (! empty ( $this->_tpl_vars['results']->bad )): ?><a style="color:orange;" href="#problems"><?php echo $this->_tpl_vars['results']->bad_count; ?>
 <?php echo $this->_tpl_vars['heading_problem']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['results']->bad_count; ?>
 <?php echo $this->_tpl_vars['heading_problem']; ?>
<?php endif; ?></td>
			<td style="color:green;text-align:center;">&bull; <?php if (! empty ( $this->_tpl_vars['results']->good )): ?><a style="color:green;"href="#correct"><?php echo $this->_tpl_vars['results']->good_count; ?>
 <?php echo $this->_tpl_vars['heading_correct']; ?>
 </a><?php else: ?><?php echo $this->_tpl_vars['results']->good_count; ?>
 <?php echo $this->_tpl_vars['heading_correct']; ?>
<?php endif; ?></td>
		</tr>
	</tbody>
</table>
<p>&nbsp;</p>
<?php if ($this->_tpl_vars['title_enable'] || $this->_tpl_vars['description_enable'] || $this->_tpl_vars['h1_status_enable'] || $this->_tpl_vars['h2_status_enable'] || $this->_tpl_vars['keywords_enable'] || $this->_tpl_vars['image_dimensions_enable'] || $this->_tpl_vars['expires_headers_enable'] || $this->_tpl_vars['robots_enable']): ?>
<h4>Meta Information</h4>

<table id="meta_tags">
	<?php if ($this->_tpl_vars['title_enable']): ?>
	<tr class="<?php echo smarty_function_cycle(array('name' => 'trbg','values' => 'even,odd'), $this);?>
">
		<td colspan="2" class="subject">Title Tag<p class="tooltip"><?php echo $this->_tpl_vars['locale']['title']['tooltip']; ?>
</p>
		<?php if ($this->_tpl_vars['results']->title): ?>
			<div class="message">
				<img class="icon correct" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/accept.png" alt="<?php echo $this->_tpl_vars['heading_correct']; ?>
" />
				<?php echo $this->_tpl_vars['locale']['title']['correct']; ?>
 
				<br><br>
					
				<em><?php echo $this->_tpl_vars['results']->title; ?>
</em>
			</div>
		<?php else: ?>
			<div class="message">	
			<?php if ($this->_tpl_vars['locale']['title']['important']): ?>
				<img class="icon critical" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/stop.png" alt="<?php echo $this->_tpl_vars['heading_critical']; ?>
" />
			<?php else: ?>
				<img class="icon problem" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/exclamation.png" alt="<?php echo $this->_tpl_vars['heading_problem']; ?>
" />
			<?php endif; ?>
			<?php echo $this->_tpl_vars['locale']['title']['problem']; ?>
</div>
		<?php endif; ?>
		</td>
	</tr>
	<?php endif; ?>
	
<?php if ($this->_tpl_vars['description_enable']): ?>
<?php $_from = $this->_tpl_vars['results']->meta; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['meta_tag']):
?>
	<?php if ($this->_tpl_vars['meta_tag']->getAttribute('name') == 'description'): ?>
		<tr class="<?php echo smarty_function_cycle(array('name' => 'trbg'), $this);?>
">
			<td colspan="2" class="subject">Description Tag<p class="tooltip"><?php echo $this->_tpl_vars['locale']['description']['tooltip']; ?>
</p>
			<div class="message">
	   			<img class="icon correct" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/accept.png" alt="<?php echo $this->_tpl_vars['heading_correct']; ?>
" />
	   			<?php echo $this->_tpl_vars['locale']['description']['correct']; ?>
 <br /><br />
	   			<em><?php echo $this->_tpl_vars['meta_tag']->getAttribute('content'); ?>
</em>	
			</div>
			</td>
		</tr>
		<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php if (! $this->_tpl_vars['results']->meta_description): ?>
<tr class="<?php echo smarty_function_cycle(array('name' => 'trbg'), $this);?>
">
	<td colspan="2" class="subject">Description Tag<p class="tooltip"><?php echo $this->_tpl_vars['locale']['description']['tooltip']; ?>
</p>
	<div class="message">
	<?php if ($this->_tpl_vars['locale']['description']['important']): ?>
		<img class="icon critical" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/stop.png" alt="<?php echo $this->_tpl_vars['heading_critical']; ?>
" />
	<?php else: ?>
	<img class="icon problem" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/exclamation.png" alt="<?php echo $this->_tpl_vars['heading_problem']; ?>
" />
	<?php endif; ?>
	<?php echo $this->_tpl_vars['locale']['description']['problem']; ?>

	</div>
	</td>
</tr>
<?php endif; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['keywords_enable']): ?>
<?php $_from = $this->_tpl_vars['results']->meta; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['meta_tag']):
?>
<?php if ($this->_tpl_vars['meta_tag']->getAttribute('name') == 'keywords'): ?>
	<tr class="<?php echo smarty_function_cycle(array('name' => 'trbg'), $this);?>
">
		<td colspan="2" class="subject">Keyword Tag<p class="tooltip"><?php echo $this->_tpl_vars['locale']['keywords']['tooltip']; ?>
</p>
		
		<div class="message">
			<img class="icon correct" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/accept.png" alt="<?php echo $this->_tpl_vars['heading_correct']; ?>
" />
			<?php echo $this->_tpl_vars['locale']['keywords']['correct']; ?>
<br><br>
			<em><?php echo $this->_tpl_vars['meta_tag']->getAttribute('content'); ?>
</em>
		</div></td>
	</tr>	
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php if (! $this->_tpl_vars['results']->meta_keywords): ?>
<tr class="<?php echo smarty_function_cycle(array('name' => 'trbg'), $this);?>
">
	<td colspan="2" class="subject">Keyword Tag<p class="tooltip"><?php echo $this->_tpl_vars['locale']['keywords']['tooltip']; ?>
</p>
	
	<div class="message">
		<?php if ($this->_tpl_vars['locale']['keywords']['important']): ?>
			<img class="icon critical" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/stop.png" alt="<?php echo $this->_tpl_vars['heading_critical']; ?>
" />
		<?php else: ?>
			<img class="icon problem" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/exclamation.png" alt="<?php echo $this->_tpl_vars['heading_problem']; ?>
" />
		<?php endif; ?>
		<?php echo $this->_tpl_vars['locale']['keywords']['problem']; ?>

	</div></td>
</tr>	
<?php endif; ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['h1_status_enable']): ?>
<tr class="<?php echo smarty_function_cycle(array('name' => 'trbg'), $this);?>
">
	<td colspan="2" class="subject">H1 Header Tag<p class="tooltip"><?php echo $this->_tpl_vars['locale']['h1_status']['tooltip']; ?>
</p>
	<div class="message">
		
		<?php if ($this->_tpl_vars['results']->h1): ?>
			<img class="icon correct" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/accept.png" alt="<?php echo $this->_tpl_vars['heading_correct']; ?>
" /><?php echo $this->_tpl_vars['locale']['h1_status']['correct']; ?>
<br><br>
			<?php $_from = $this->_tpl_vars['results']->h1; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['h1']):
?>
				<em><?php echo $this->_tpl_vars['h1']->textContent; ?>
</em><br />
			<?php endforeach; endif; unset($_from); ?>
		<?php else: ?>		
			<?php if ($this->_tpl_vars['locale']['h1_status']['important']): ?>
				<img class="icon critical" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/stop.png" alt="<?php echo $this->_tpl_vars['heading_critical']; ?>
" />
			<?php else: ?>
				<img class="icon problem" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/exclamation.png" alt="<?php echo $this->_tpl_vars['heading_problem']; ?>
" />
			<?php endif; ?>
			<?php echo $this->_tpl_vars['locale']['h1_status']['problem']; ?>

		<?php endif; ?></div></td>
		</tr>
<?php endif; ?>


</table>
<?php endif; ?>


<?php if ($this->_tpl_vars['alt_attributes_enable']): ?>
<h4> Image attributes</h4>
<table id="alt_attributes">
	<tr class="<?php echo smarty_function_cycle(array('name' => 'trbg'), $this);?>
">
		<td colspan="2" class="subject">ALT Tags for Images<p class="tooltip"><?php echo $this->_tpl_vars['locale']['alt_attributes']['tooltip']; ?>
</p>
		<div class="message">
<?php if (! $this->_tpl_vars['results']->alt_attributes): ?>
	<img class="icon problem" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/exclamation.png" alt="<?php echo $this->_tpl_vars['heading_problem']; ?>
" /><?php echo $this->_tpl_vars['locale']['alt_attributes']['problem']; ?>

<?php else: ?>
<img class="icon correct" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/accept.png" alt="<?php echo $this->_tpl_vars['heading_correct']; ?>
" />
	<?php echo $this->_tpl_vars['locale']['alt_attributes']['correct']; ?>

	<?php $_from = $this->_tpl_vars['results']->alt_attributes; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['image']):
?>
		<ul><li><?php echo $this->_tpl_vars['image']; ?>
</li></ul>
	<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
</div></td>
</table>
<?php endif; ?>

<?php echo $this->_tpl_vars['bottom_message']; ?>