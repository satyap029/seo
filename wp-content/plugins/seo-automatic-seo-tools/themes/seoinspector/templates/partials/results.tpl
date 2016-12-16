<h2>Summary for {$url}</h2>

<table id="overview">
	<tbody>
		<tr class="even" style="font-size:14px;font-weight:bold;">
			<td>{$heading_overview}</td>
			<td style="color:red;text-align:center;">&bull; {if !empty($results->ugly)}<a style="color:red;" href="#critical"> {$results->ugly_count} {$heading_critical}</a>{else}{$results->ugly_count} {$heading_critical}{/if}</td>
			<td style="color:orange;text-align:center;">&bull; {if !empty($results->bad)}<a style="color:orange;" href="#problems">{$results->bad_count} {$heading_problem}</a>{else}{$results->bad_count} {$heading_problem}{/if}</td>
			<td style="color:green;text-align:center;">&bull; {if !empty($results->good)}<a style="color:green;"href="#correct">{$results->good_count} {$heading_correct} </a>{else}{$results->good_count} {$heading_correct}{/if}</td>
		</tr>
	</tbody>
</table>
<p>&nbsp;</p>
{if $title_enable || $description_enable || $h1_status_enable || $h2_status_enable || $keywords_enable || $image_dimensions_enable || $expires_headers_enable || $robots_enable}
<h4>Meta Information</h4>

<table id="meta_tags">
	{if $title_enable}
	<tr class="{cycle name=trbg values='even,odd'}">
		<td colspan="2" class="subject">Title Tag<p class="tooltip">{$locale.title.tooltip}</p>
		{if $results->title}
			<div class="message">
				<img class="icon correct" src="{$this_theme}/images/icons/famfamfam/silk/accept.png" alt="{$heading_correct}" />
				{$locale.title.correct} 
				<br><br>
					
				<em>{$results->title}</em>
			</div>
		{else}
			<div class="message">	
			{if $locale.title.important}
				<img class="icon critical" src="{$this_theme}/images/icons/famfamfam/silk/stop.png" alt="{$heading_critical}" />
			{else}
				<img class="icon problem" src="{$this_theme}/images/icons/famfamfam/silk/exclamation.png" alt="{$heading_problem}" />
			{/if}
			{$locale.title.problem}</div>
		{/if}
		</td>
	</tr>
	{/if}
	
{if $description_enable}
{foreach from=$results->meta item=meta_tag}
	{if $meta_tag->getAttribute('name') == 'description'}
		<tr class="{cycle name=trbg}">
			<td colspan="2" class="subject">Description Tag<p class="tooltip">{$locale.description.tooltip}</p>
			<div class="message">
	   			<img class="icon correct" src="{$this_theme}/images/icons/famfamfam/silk/accept.png" alt="{$heading_correct}" />
	   			{$locale.description.correct} <br /><br />
	   			<em>{$meta_tag->getAttribute('content')}</em>	
			</div>
			</td>
		</tr>
		{/if}
{/foreach}
{if !$results->meta_description}
<tr class="{cycle name=trbg}">
	<td colspan="2" class="subject">Description Tag<p class="tooltip">{$locale.description.tooltip}</p>
	<div class="message">
	{if $locale.description.important}
		<img class="icon critical" src="{$this_theme}/images/icons/famfamfam/silk/stop.png" alt="{$heading_critical}" />
	{else}
	<img class="icon problem" src="{$this_theme}/images/icons/famfamfam/silk/exclamation.png" alt="{$heading_problem}" />
	{/if}
	{$locale.description.problem}
	</div>
	</td>
</tr>
{/if}
{/if}
{if $keywords_enable}
{foreach from=$results->meta item=meta_tag}
{if $meta_tag->getAttribute('name') == 'keywords'}
	<tr class="{cycle name=trbg}">
		<td colspan="2" class="subject">Keyword Tag<p class="tooltip">{$locale.keywords.tooltip}</p>
		
		<div class="message">
			<img class="icon correct" src="{$this_theme}/images/icons/famfamfam/silk/accept.png" alt="{$heading_correct}" />
			{$locale.keywords.correct}<br><br>
			<em>{$meta_tag->getAttribute('content')}</em>
		</div></td>
	</tr>	
{/if}
{/foreach}
{if !$results->meta_keywords}
<tr class="{cycle name=trbg}">
	<td colspan="2" class="subject">Keyword Tag<p class="tooltip">{$locale.keywords.tooltip}</p>
	
	<div class="message">
		{if $locale.keywords.important}
			<img class="icon critical" src="{$this_theme}/images/icons/famfamfam/silk/stop.png" alt="{$heading_critical}" />
		{else}
			<img class="icon problem" src="{$this_theme}/images/icons/famfamfam/silk/exclamation.png" alt="{$heading_problem}" />
		{/if}
		{$locale.keywords.problem}
	</div></td>
</tr>	
{/if}
{/if}

{if $h1_status_enable}
<tr class="{cycle name=trbg}">
	<td colspan="2" class="subject">H1 Header Tag<p class="tooltip">{$locale.h1_status.tooltip}</p>
	<div class="message">
		
		{if $results->h1}
			<img class="icon correct" src="{$this_theme}/images/icons/famfamfam/silk/accept.png" alt="{$heading_correct}" />{$locale.h1_status.correct}<br><br>
			{foreach from=$results->h1 item=h1}
				<em>{$h1->textContent}</em><br />
			{/foreach}
		{else}		
			{if $locale.h1_status.important}
				<img class="icon critical" src="{$this_theme}/images/icons/famfamfam/silk/stop.png" alt="{$heading_critical}" />
			{else}
				<img class="icon problem" src="{$this_theme}/images/icons/famfamfam/silk/exclamation.png" alt="{$heading_problem}" />
			{/if}
			{$locale.h1_status.problem}
		{/if}</div></td>
		</tr>
{/if}


</table>
{/if}


{if $alt_attributes_enable}
<h4> Image attributes</h4>
<table id="alt_attributes">
	<tr class="{cycle name=trbg}">
		<td colspan="2" class="subject">ALT Tags for Images<p class="tooltip">{$locale.alt_attributes.tooltip}</p>
		<div class="message">
{if !$results->alt_attributes}
	<img class="icon problem" src="{$this_theme}/images/icons/famfamfam/silk/exclamation.png" alt="{$heading_problem}" />{$locale.alt_attributes.problem}
{else}
<img class="icon correct" src="{$this_theme}/images/icons/famfamfam/silk/accept.png" alt="{$heading_correct}" />
	{$locale.alt_attributes.correct}
	{foreach from=$results->alt_attributes item=image}
		<ul><li>{$image}</li></ul>
	{/foreach}
{/if}
</div></td>
</table>
{/if}

{$bottom_message}