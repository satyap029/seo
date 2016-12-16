=== SEO Tools ===
Contributors: cyber49
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FC2PBBP6BY8QC
Tags: google, seo, seo automatic, rss, feedcommander, url checker, link variance, keyword marriage, keyword multiplier, seo tools
Requires at least: 3.1
Tested up to: 4.4.2
Stable tag: 3.7.5

These are eight of the tools for member use at SEO Automatic, and they're now available for use on your own site too.

== Description ==
<a href="http://www.seoautomatic.com/plugins/unique-seo-tools/" target="_blank">Plugin Page</a> | <a href="http://www.seoautomatic.com/forum/seo-tools-plugin-support/" target="_blank">Plugin Support</a>

This plug-in combines several unique SEO tools developed for Search Commander, Inc. and enables their use from inside WordPress. Paste the corresponding short code in place on the page or post where you wish to offer the tool.

Tools included are:

= 1. URL Checker =
Allow your users to instantly run URL reviews for five common search ranking factors. Title Tag, Description Tag, Keyword Tag, H1 Tag and ALT Tag.  Show whether they exist or not, and provide your own input and feedback, edited in the WordPress admin.
= To use, add the shortcode: [urlchecker] =

= &nbsp; =
= &nbsp; =

= 2. Keyword List Multiplier =
Allow your site visitors to easily and instantly create a combination of keyword lists to "cover all their bases" for all the different variations of cities, states, categories etc. when setting up a PPC campaign, including google match types. 

There is an additional option (not to be used with Adwords) that will keep any spaces or other characters you may add, such as the pipe | or spaces. When checked, the tool will not add its own spaces. This option makes this tool suitable for nearly any other need, such as insterting options into content spinning software.
= To use, add the shortcode: [keyword-marriage] =

= &nbsp; =
= &nbsp; =



= 3. Bulk URL checker =
Allow your site visitors to check the server response of just one or a large batch of URL's to see which ones might be redirected or which ones might come up 404 not found, and then make that list available for download. The longer the list of URL's, the longer the tool will take to run.
= To use, add the shortcode: [bulkurlchecker] =

= &nbsp; =
= &nbsp; =



= 4. Link Variance =
Allow your site visitors to put a list of URLs on one side, then a list of varied anchor text on the other side, press a button, and get a complete list of every possible variation of text link and landing page. This list can then be given to bloggers, authors, programmers, etc. to use throughout your content.
= To use, add the shortcode: [link-variance] =

= &nbsp; =
= &nbsp; =


= 5. RSS Feed Commander =
Allow your site visitors to format any valid RSS feed to display as they wish. They may then use the generated code on any website they like. 
= To use, add the shortcode: [feedcommander] =

= &nbsp; =
= &nbsp; =


= 6. Structured Data Tool for Local Businesses =
Easily generate structured data in a way Google understands, and add it to a website without affecting how it looks. This tool uses the JSON-LD type of structured data, which Google officially endorsed as a markup format in January, of 2015.
= To use, add the shortcode: [schematool] =

= &nbsp; =
= &nbsp; =


= 7. File Merger =
Time spent copy and pasting can be tedious, and this tool lets your users merge multiple .csv files or .txt files into one downloadable file.   They'll just select multiple files to upload, then choose the output filetype, and press the button.
= To use, add the shortcode: [csvmerger] =

= &nbsp; =
= &nbsp; =


= 8. Analytics Spam Filter Tool =
This tool lets you apply Google Analytics spambot referral filters directly to any linked Google Analytics account.
= To use, add the shortcode: [spamtool] =

= &nbsp; =
= &nbsp; =

== Installation ==

1. Unzip the download
2. Upload the entire folder: `seo-automatic-seo-tools` to the `/wp-content/plugins/` directory
3. Activate the plugin through your 'Plugins' menu
4. View the short codes listed in the SEO Automatic > SEO Tools menu to add the tools to pages or posts.

Installation for the URL Checker:

1. Edit your settings on the SEO Automatic > URL Checker admin page
2. If the URL checker fails: CHMOD the /wp-content/plugins/seo-automatic-seo-tools/writable folder to 766.

== Frequently Asked Questions ==

= What version of Wordpress is required? =

The minimum requirement is 3.1 and use with any prior versions are not supported.

= What is this all about, anyway? =

Write your own advice and tips in your WordPress admin, then provide your visitors with an instant "on-page" SEO analysis of the top five on page ranking factors. Also included are four other niche tools, explained in detail with videos.   

= This is amazing! I wish I could get a white label tool like this for more than just five ranking factors.

You can! Editing and offering nearly 20 ranking factors can be done with the Pro version at <a href="http://www.seoautomatic.com/pricing-plans/" target="_blank">SEO Automatic</a>.

= How do I get the SEO tools to display on my site? =

Any tool can appear on any page you like. After activation of the plug-in, simply look up the shortcode on the SEO Tools admin screen. Then paste the corresponding shortcode into any page or post, and the tool will display. 

= File Merger adding extra code to result file. =

This is typically caused by incorrect folder permission on uploads/csv-merger. The file merger creates that folder with 755 permissions, but on some servers you may need to manually set that. If the problem persists, you can try setting to 777. 

= Note:  =

In late 2012, we changed the Bulk URL Checker shortcode to [bulkurlchecker], and the original [urlchecker] now shows the URL Checker. The original shortcode for the URL Checker [seotool] will continue to work, but it's recommended that you also edit to use [urlchecker] instead.

= Where do I go for support, or what if I have a problem? =

Please visit the <a href="http://www.seoautomatic.com/forum/" target="_blank">support forum</a>.

== Screenshots ==

1. SEO Tools Menu
2. SEO Tools Admin
3. URL Checker Admin

== Changelog ==

= 3.7.5 =

* Correction to keyword multiplier results.

= 3.7.4 =

* Changed keyword multiplier to not show regular broad match by default.

= 3.7.3 =

* Updated spam filter host lists.
* Verified compatability with wordpres 4.3+.

= 3.7.2 =

* Addition of business hours and description to structured data tool.

= 3.7.1 =

* Addition of beta version of Google Analytics Spam Filter Tool.

= 3.7 =

* Addition of CSV File Merger tool.

= 3.6 =

* To coincide with Google's new structured data tester, we've added a new tool that uses JSON-LD to easily pass the test.

= 3.5.2.4 =

* Edit to cURL code in feedcommander
* Unchecked match boxes in keyword multiplier by default.
* Added force disable on matches when negative is selected.

= 3.5.2.3 =

* Removed some of the unneeded files in tools.
* Cleaned up some of the outdated code.
* Added broad modifier and negative matches to keyword multiplier.

= 3.5.2.2 =

* Changed setting field for backlink.
* Tested all tools with wordpress 3.9 and updated tested up to in readme.

= 3.5.2.1 =

* Edit to url checker advice to shorten titles for google.

= 3.5.2 =

* Edit to show new tool on admin panel when using Core Tweaks.

= 3.5.1 =

* Changed function name throughout plugin for compatibilty with WP to Twitter plugin.

= 3.5 =

* Edited changelog to version number layout instead of date-based.
* Separated url checker code for easier editing.
* Edited wording on settings page.
* Shortcode changes: [urlchecker] for Bulk URL Checker, changed to [bulkurlchecker], URL Review Tool changed to URL Checker using shortcode [urlchecker]. Current users with shortcode [seotool] will continue to work, but recommend editing that shortcode to the new [urlchecker] for future functionality.
* Updated readme with new shortcodes and an FAQ on the Bulk URL Checker.
* Removed LPD Tool.
* Major version jump to correspond with the latest Wordpress version for easier version control on our end and to reference large changes in the plugin.

= 3.1.10 =

* New default advice settings for url checker.
* Admin wording changes for url checker.
* New fix for servers without gzip capability.

= 3.1.9 =

* Default set to off for backlink.

= 3.1.8 =

* Removed get_download.php file due to security vulnerability.
* Added backlink removal option.

= 3.1.7 =

* Major fix for url review tool to prevent report failures.

= 3.1.6 =

* Additional url checker report fixes

= 3.1.5 =

* Changed rssread include path to wp-config to prevent sub-domain errors.

= 3.1.4 =

* Combined Url Checker tool add-on into SEO Tools.
* Added validation script.
* Edited readme.

= 3.1.3 =

* Major fix for url review tool to prevent report failures.

= 3.1.2 =

* Added sitemap_index.xml check to URL Review tool
* Advice text edits for initial install

= 3.1.1 =

* Wording edits.

= 3.1.1 =

* Change to landing page determinator for jQuery conflicts.
* Addition of SEO Review Lite
* Minor text/word editing.

= 3.1 =

* Added Landing Page Determinator

= 2.0 =

* Added linkback settings.
* Updated main menu page.

== Other Notes ==
The tools in this plug-in are available for your own use, and for the use of your site visitors without alteration of the code. Please note that any editing of the tools or the plug-in may prevent future upgrades from working properly, so do so at your own risk.

=Worth knowing:=

To change the initial message displaying above the output of facts -  
/wp-content/plugins/seo-automatic/themes/seoinspector/templates/partials/results.tpl

To change the CSS for the tool results themselves:  
/wp-content/plugins/seo-automatic/seo-automatic-styles.css

To edit the admin screen that the user sees in their WP - 
/wp-content/plugins/seo-automatic/seo-automatic.php

[SEO Automatic Plugins](http://www.seoautomatic.com/plugins/ "Other plugins from SEO Automatic")
[SEO Tools](http://www.seoautomatic.com/plugins/unique-seo-tools/ "SEO Tools Homepage") 