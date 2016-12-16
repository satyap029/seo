<p class="content_header">{$app.header}</p>
<div class="content_centered">
	<p>{$top_message}
	<br><form id="{$analyze_loader}" method="get" action="">
			<p><label for="url">Copy / Paste url from browser</label>
			<input class="seo-url" id="url" name="url" size="30" type="text" value="{$url2}" />	
			<input type="hidden" id="ref" name="ref" value="{$this_page}" />
			<input type="hidden" id="seoautorun" name="seoautorun" value="{$seoautorun}" />
			<input type="submit" value="{$button_text}" /></p>	
		</form>
		<br />
		<div id="legend">	
			<span class="problem">
				<img class="searchicon critical" src="{$this_theme}/images/icons/famfamfam/silk/stop.png" alt="{$heading_critical}" /> {$heading_critical}
			</span>	
			<span class="suggestion">
				<img class="searchicon problem" src="{$this_theme}/images/icons/famfamfam/silk/exclamation.png" alt="{$heading_problem}" /> {$heading_problem}
			</span>
			<span class="correct">
				<img class="searchicon correct" src="{$this_theme}/images/icons/famfamfam/silk/accept.png" alt="{$heading_correct}" /> {$heading_correct}
			</span>
		</div>	<br />
		{if $error}		
			<div id="error">
				{$error}
			</div><br />	
		{/if}	
		<div id="throbber" style="display: none;"><br />
			<img src="{$this_theme}/images/throbbers/loading01.gif" alt="Loading..." />	
		</div>	
		{if $results }
		<div id="seoautoresults">{include file="partials/results.tpl"}
		</div>	
		{else}
		<div class="noscreen" id="seoautoresults" style="display: none;"></div>	<br /><br />
		{/if}
		</div>
