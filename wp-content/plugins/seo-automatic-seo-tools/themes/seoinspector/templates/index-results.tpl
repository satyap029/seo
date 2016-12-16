<p class="content_header">{$app.header}</p>
<div class="content_centered">
	<form name="analyze" method="get" action="{$url_path}" id="seosubmit">
			<input class="seo-url" id="url" name="url" type="hidden" value="{$url2}" />	
			<input type="hidden" id="ref" name="ref" value="{$this_page}" />
			<input type="submit" value="{$button_text}" style="display:none" />
		</form>
		{$results_top}
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
		</div>	
		{if $error}		
			<div id="error">
				{$error}
			</div><br />	
		{/if}	
		<div id="throbber" class="noscreen"><br />
			<img src="{$this_theme}/images/throbbers/loading01.gif" alt="Loading..." />	
		</div>	
		{if $results }
		<div id="results">{include file="partials/results.tpl"}
		</div>	
		{else}
		<div class="noscreen" id="results">{$this_theme}</div>	
		{/if}
		</div>