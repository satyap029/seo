<?php /* Smarty version 2.6.18, created on 2016-10-24 08:54:54
         compiled from index.tpl */ ?>
<p class="content_header"><?php echo $this->_tpl_vars['app']['header']; ?>
</p>
<div class="content_centered">
	<p><?php echo $this->_tpl_vars['top_message']; ?>

	<br><form id="<?php echo $this->_tpl_vars['analyze_loader']; ?>
" method="get" action="">
			<p><label for="url">Copy / Paste url from browser</label>
			<input class="seo-url" id="url" name="url" size="30" type="text" value="<?php echo $this->_tpl_vars['url2']; ?>
" />	
			<input type="hidden" id="ref" name="ref" value="<?php echo $this->_tpl_vars['this_page']; ?>
" />
			<input type="hidden" id="seoautorun" name="seoautorun" value="<?php echo $this->_tpl_vars['seoautorun']; ?>
" />
			<input type="submit" value="<?php echo $this->_tpl_vars['button_text']; ?>
" /></p>	
		</form>
		<br />
		<div id="legend">	
			<span class="problem">
				<img class="searchicon critical" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/stop.png" alt="<?php echo $this->_tpl_vars['heading_critical']; ?>
" /> <?php echo $this->_tpl_vars['heading_critical']; ?>

			</span>	
			<span class="suggestion">
				<img class="searchicon problem" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/exclamation.png" alt="<?php echo $this->_tpl_vars['heading_problem']; ?>
" /> <?php echo $this->_tpl_vars['heading_problem']; ?>

			</span>
			<span class="correct">
				<img class="searchicon correct" src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/icons/famfamfam/silk/accept.png" alt="<?php echo $this->_tpl_vars['heading_correct']; ?>
" /> <?php echo $this->_tpl_vars['heading_correct']; ?>

			</span>
		</div>	<br />
		<?php if ($this->_tpl_vars['error']): ?>		
			<div id="error">
				<?php echo $this->_tpl_vars['error']; ?>

			</div><br />	
		<?php endif; ?>	
		<div id="throbber" style="display: none;"><br />
			<img src="<?php echo $this->_tpl_vars['this_theme']; ?>
/images/throbbers/loading01.gif" alt="Loading..." />	
		</div>	
		<?php if ($this->_tpl_vars['results']): ?>
		<div id="seoautoresults"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "partials/results.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>	
		<?php else: ?>
		<div class="noscreen" id="seoautoresults" style="display: none;"></div>	<br /><br />
		<?php endif; ?>
		</div>