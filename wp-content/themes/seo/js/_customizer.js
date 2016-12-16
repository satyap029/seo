// Customization panel

jQuery(document).ready(function() {
	"use strict";

	if (jQuery("#custom_options").length===1) {

		// Reset custom settings to default
		jQuery("#custom_options .co_reset_to_default" ).click(function(e) {
			"use strict";
			clearCustomCookies();
			window.location = jQuery("#custom_options #co_site_url").val();
			e.preventDefault();
			return false;
		});

		// Body and Main menu style
		jQuery("#custom_options .switcher a,#custom_options .switcher2 a" ).draggable({
			axis: 'x',
			containment: 'parent',
			stop: function() {
				var left = parseInt(jQuery(this).css('left'), 10);
				var curStyle = left < 25 ? (jQuery(this).parent().hasClass('switcher') ? 'wide' : 'line') : (jQuery(this).parent().hasClass('switcher') ? 'boxed' : 'fon');
				switchBox(jQuery(this).parent(), curStyle, true);
			}
		});
		jQuery("#custom_options .switcher, #custom_options .switcher2" ).click(function(e) {
			"use strict";
			switchBox(jQuery(this));
			e.preventDefault();
			return false;
		});
		jQuery("#custom_options .co_switch_box .co_switch_label").click(function(e) {
			"use strict";
			var state = jQuery(this).hasClass('boxed') ? 'boxed' : (jQuery(this).hasClass('wide') ? 'wide' : (jQuery(this).hasClass('line') ? 'line' : 'fon'));
			switchBox(jQuery(this).siblings('div'), state);
			e.preventDefault();
			return false;
		});

		// Main theme color and Background color
		iColorPicker();
		jQuery('#custom_options .iColorPicker').click(function (e) {
			"use strict";
			iColorShow(null, jQuery(this), changeThemeColor);
		});
		
		// Background patterns
		jQuery('#custom_options #co_bg_pattern_list a').click(function(e) {
			"use strict";
			jQuery("#custom_options .co_switch_box .boxed").trigger('click');
			jQuery('#custom_options #co_bg_pattern_list .co_pattern_wrapper,#custom_options #co_bg_images_list .co_image_wrapper').removeClass('current');
			var obj = jQuery(this).addClass('current');
			var val = obj.attr('id').substr(-1);
			if (THEMEREX_remember_visitors_settings) {
				jQuery.cookie('bg_color', null, {expires: -1, path: '/'});
				jQuery.cookie('bg_image', null, {expires: -1, path: '/'});
				jQuery.cookie('bg_pattern', val, {expires: 1, path: '/'});
			}
			jQuery(document).find('body').removeClass('bg_pattern_1 bg_pattern_2 bg_pattern_3 bg_pattern_4 bg_pattern_5 bg_image_1 bg_image_2 bg_image_3').addClass('bg_pattern_' + val);
			e.preventDefault();
			return false;
		});
		// Background images
		jQuery('#custom_options #co_bg_images_list a').click(function(e) {
			"use strict";
			jQuery("#custom_options .co_switch_box .boxed").trigger('click');
			jQuery('#custom_options #co_bg_images_list .co_image_wrapper,#custom_options #co_bg_pattern_list .co_pattern_wrapper').removeClass('current');
			var obj = jQuery(this).addClass('current');
			var val = obj.attr('id').substr(-1);
			if (THEMEREX_remember_visitors_settings) {
				jQuery.cookie('bg_color', null, {expires: -1, path: '/'});
				jQuery.cookie('bg_pattern', null, {expires: -1, path: '/'});
				jQuery.cookie('bg_image', val, {expires: 1, path: '/'});
			}
			jQuery(document).find('body').removeClass('bg_pattern_1 bg_pattern_2 bg_pattern_3 bg_pattern_4 bg_pattern_5 bg_pattern_6 bg_pattern_7 bg_pattern_8 bg_pattern_9 bg_pattern_0 bg_image_1 bg_image_2 bg_image_3 bg_image_4 bg_image_5 bg_image_6').addClass('bg_image_' + val);
			e.preventDefault();
			return false;
		});
		jQuery('#custom_options #co_bg_pattern_list a,#custom_options #co_bg_images_list a').hover(
			function() {
				"use strict";
				var pattern = jQuery(this).parent().attr('id')=='co_bg_pattern_list';
				jQuery(this).parent().parent().css({
					'backgroundImage': 'url('+jQuery(this).find('img').attr('src').replace('_thumb2', '_thumb')+')',
					'backgroundRepeat': pattern ? 'repeat' : 'no-repeat'
				});
			},
			function() {
				"use strict";
				jQuery(this).parent().parent().css('backgroundImage', 'none');
			}
		);
	}
});


function clearCustomCookies() {
	jQuery.cookie('theme_color', null, {expires: -1, path: '/'});
	jQuery.cookie('theme_color2', null, {expires: -1, path: '/'});
	jQuery.cookie('theme_color3', null, {expires: -1, path: '/'});
	jQuery.cookie('bg_image', null, {expires: -1, path: '/'});
	jQuery.cookie('bg_pattern', null, {expires: -1, path: '/'});
	jQuery.cookie('bg_color', null, {expires: -1, path: '/'});
	jQuery.cookie('body_style', null, {expires: -1, path: '/'});
	jQuery.cookie('menu_style', null, {expires: -1, path: '/'});
}


function switchBox(box) {
	"use strict";
	var toStyle = arguments[1] ? arguments[1] : '';
	var important = arguments[2] ? arguments[2] : false;
	var switcher = box.find('a').eq(0);
	var left = parseInt(switcher.css('left'), 10);
	var newStyle = left < 5 ? (box.hasClass('switcher') ? 'boxed' : 'fon') : (box.hasClass('switcher') ? 'wide' : 'line');
	if (toStyle==='' || important || newStyle === toStyle) {
		if (toStyle==='') {toStyle = newStyle;}
		var right = box.width() - switcher.width() - 7;
		if (toStyle === 'wide' || toStyle === 'line')
			switcher.animate({left: 0}, 200);
		else
			switcher.animate({left: right}, 200);
		if (box.hasClass('switcher')) {
			if (THEMEREX_remember_visitors_settings) jQuery.cookie('body_style', toStyle, {expires: 1, path: '/'});
			jQuery(document).find('body').removeClass(toStyle==='boxed' ? 'wide' : 'boxed').addClass(toStyle);
			jQuery(document).trigger('resize');
		} else {
			if (THEMEREX_remember_visitors_settings) jQuery.cookie('menu_style', toStyle, {expires: 1, path: '/'});
			jQuery(document).find('.menuTopWrap').removeClass(toStyle==='fon' ? 'topMenuStyleLine' : 'topMenuStyleFon').addClass('topMenuStyle'+(toStyle==='fon' ? 'Fon' : 'Line'));
			calcMenuColumnsWidth();
		}
	}
	return newStyle;
}


function changeThemeColor(fld, clr) {
	"use strict";
	fld.css('backgroundColor', clr);
	fld.siblings('input').attr('value', clr);

	if (fld.attr('id')==='co_bg_color') {
		jQuery("#custom_options .co_switch_box .boxed").trigger('click');
		jQuery('#custom_options #co_bg_pattern_list .co_pattern_wrapper,#custom_options #co_bg_images_list .co_image_wrapper').removeClass('current');
		if (THEMEREX_remember_visitors_settings) {
			jQuery.cookie('bg_image', null, {expires: -1, path: '/'});
			jQuery.cookie('bg_pattern', null, {expires: -1, path: '/'});
			jQuery.cookie('bg_color', clr, {expires: 1, path: '/'});
		}
		jQuery(document).find('body').removeClass('bg_pattern_1 bg_pattern_2 bg_pattern_3 bg_pattern_4 bg_pattern_5 bg_image_1 bg_image_2 bg_image_3').css('backgroundColor', clr);
		return;
	}

	if (THEMEREX_remember_visitors_settings) {
		if (fld.attr('id')==='co_theme_color')
			jQuery.cookie('theme_color', clr, {expires: 1, path: '/'});
		else if (fld.attr('id')==='co_theme_color2')
			jQuery.cookie('theme_color2', clr, {expires: 1, path: '/'});
		else if (fld.attr('id')==='co_theme_color3')
			jQuery.cookie('theme_color3', clr, {expires: 1, path: '/'});
	}

	// This way - with page reload
	//window.location = jQuery("#custom_options #co_site_url").val();
	// This way - without reload
	var styles = jQuery('#theme-skin-css').length > 0 ? jQuery('#theme-skin-css').next() : '';
	if (styles.length == 0 || styles.attr('type')!='text/css') styles = jQuery('#packed-styles-css').length > 0 ? jQuery('#packed-styles-css').next() : '';
	if (styles.length == 0 || styles.attr('type')!='text/css') styles = jQuery('#shortcodes-css').length > 0 ? jQuery('#shortcodes-css').next() : '';
	if (styles.length > 0 && styles.attr('type')=='text/css') {
		clr = rgb2hex(jQuery('#co_theme_color').css('backgroundColor'));
		var rgb = hex2rgb(clr);
		var css_text =
			'' +
			'a:hover,' +
			'.theme_accent,' +
			'.topWrap .topMenuStyleFon > ul li a:hover,' +
			'.topWrap .topMenuStyleFon > ul > li.sfHover > a,' +
			'.topWrap .topMenuStyleFon > ul > li > a.sf-with-ul:hover,' +
			'.topWrap .topMenuStyleFon > ul > li ul a.sf-with-ul:after,' +
			'.topWrap .topMenuStyleLine > ul > li ul li a:hover,' +
			'.topMenuStyleFon ul#mainmenu .menu-panel ul.columns > li > a,' +
			'.topMenuStyleFon ul#mainmenu .menu-panel ul.columns > li a:hover,' +
			'.topMenuStyleFon ul#mainmenu .menu-panel ul.columns > li ul li a:hover,' +
			'.topMenuStyleFon ul#mainmenu .menu-panel ul.thumb_title > li > a,' +
			'.topMenuStyleFon ul#mainmenu .menu-panel ul.thumb_title > li > a:hover,' +
			'.infoPost a:hover,' +
			'.tabsButton ul li a:hover,' +
			'.widgetWrap  ul  li:before,' +
			'.popularFiltr ul li a:hover,' +
			'.isotopeFiltr ul li a:hover,' +
			'.widget_popular_posts article h3:before,' +
			'.widgetTabs .widget_popular_posts article .post_info .post_date a:hover,' +
			'.sidebar .widget_popular_posts article .post_info .post_date a:hover,' +
			'.sidebar .widget_recent_posts article .post_info .post_date a:hover,' +
			'.main .widgetWrap a:hover,' +
			'.main .widgetWrap a:hover span,' +
			'.widgetWrap a:hover span,' +
			'.roundButton:hover a,' +
			'input[type="submit"]:hover,' +
			'input[type="button"]:hover,' +
			'.squareButton.border > a,' +
			'.roundButton.border > a,' +
			'.nav_pages_parts > a:hover,' +
			'.nav_comments > a:hover,' +
			'.comments_list a.comment-edit-link:hover,' +
			'.widget_area ul.tabs > li.squareButtonlite.ui-state-active > a,' +
			'.widget_calendar #wp-calendar tbody td a,' +
			'.wp-calendar tbody td a,' +
			'.widget_calendar #wp-calendar tbody td.today a:hover,' +
			'.wp-calendar tbody td.today a:hover,' +
			'blockquote cite,' +
			'blockquote cite a,' +
			'.sc_quote_title,' +
			'.sc_quote_title a,' +
			'.postLink a,' +
			'.masonry article .masonryInfo a:hover,' +
			'.masonry article .masonryInfo span.infoTags a:hover,' +
			'.relatedPostWrap article .relatedInfo a:hover,' +
			'.relatedPostWrap article .relatedInfo span.infoTags a:hover,' +
			'.infoPost span.infoTags a:hover,' +
			'.page404 p a,' +
			'.page404 .searchAnimation.sFocus .searchIcon,' +
			'.sc_team .sc_team_item .sc_team_item_position,' +
			'.copyWrap a,' +
			'.comments .commBody li.commItem .replyWrap .posted a:hover,' +
			'.comments .commBody li.commItem h4 a:hover,' +
			'.ratingItem span:before,' +
			'.reviewBlock .totalRating,' +
			'.widget_area .contactInfo .fContact:before,' +
			'.widget_area .widgetWrap a:hover,' +
			'.widget_area .widgetWrap a:hover span,' +
			'.widget_area .widgetWrap ul > li > a:hover,' +
			'.widget_area .widgetWrap ul > li > a:hover span,' +
			'.footerStyleLight .widget_area article .post_title:before,' +
			'.footerStyleLight .widget_area article .post_info a:hover,' +
			'.footerStyleLight .widget_area article .post_info .post_date a:hover,' +
			'.sc_list_style_arrows li:before,' +
			'.sc_list_style_arrows li a:hover,' +
			'.sc_list_style_iconed li a:hover,' +
			'.sc_accordion.sc_accordion_style_1 .sc_accordion_item .sc_accordion_title,' +
			'.sc_accordion.sc_accordion_style_1 .sc_accordion_item .sc_accordion_title:before,' +
			'.sc_accordion.sc_accordion_style_2 .sc_accordion_item.sc_active .sc_accordion_title,' +
			'.sc_accordion.sc_accordion_style_2 .sc_accordion_item.sc_active .sc_accordion_title:before,' +
			'.sc_accordion.sc_accordion_style_3 .sc_accordion_item.sc_active .sc_accordion_title,' +
			'.sc_toggles.sc_toggles_style_1 .sc_toggles_item .sc_toggles_title,' +
			'.sc_toggles.sc_toggles_style_1 .sc_toggles_item .sc_toggles_title:before,' +
			'.sc_toggles.sc_toggles_style_2 .sc_toggles_item.sc_active .sc_toggles_title,' +
			'.sc_toggles.sc_toggles_style_2 .sc_toggles_item.sc_active .sc_toggles_title:before,' +
			'.sc_toggles.sc_toggles_style_3 .sc_toggles_item.sc_active .sc_toggles_title,' +
			'.sc_tabs .sc_tabs_titles li a:hover,' +
			'.sc_dropcaps.sc_dropcaps_style_3 .sc_dropcap,' +
			'.sc_dropcaps.sc_dropcaps_style_4 .sc_dropcap,' +
			'.sc_dropcaps.sc_dropcaps_style_5 .sc_dropcap,' +
			'.sc_dropcaps.sc_dropcaps_style_6 .sc_dropcap,' +
			'.sc_highlight.sc_highlight_style_2,' +
			'.sc_price_item .sc_price_money,' +
			'.sc_price_item .sc_price_penny,' +
			'.sc_pricing_table .sc_pricing_columns ul li .sc_icon,' +
			'.sc_tooltip_parent,' +
			'.sc_title_icon:before,' +
			'.sc_scroll_controls .flex-direction-nav a:hover:before,' +
			'.sc_testimonials_style_1 .flex-direction-nav a:hover:before,' +
			'.sc_testimonials_style_3 .flex-direction-nav a:hover:before,' +
			'.sc_testimonials_style_3 .flex-direction-nav a:active:before,' +
			'.pagination .pageLibrary > li.libPage > .pageFocusBlock .flex-direction-nav a:hover:before,' +
			'.topWrap .usermenu_area ul.usermenu_list li.usermenu_currency > a:hover,' +
			'.topWrap .usermenu_area ul.usermenu_list li.usermenu_currency > a,' +
			'.topWrap .usermenu_area ul.usermenu_list li.usermenu_currency.sfHover > a,' +
			'.topWrap .usermenu_area ul.usermenu_list li ul li a:hover,' +
			'.topWrap .usermenu_area ul.usermenu_list li.usermenu_cart .widget_area ul li a:hover,' +
			'.sidemenu_wrap .usermenu_area ul.usermenu_list li.usermenu_currency > a:hover,' +
			'.sidemenu_wrap .usermenu_area ul.usermenu_list li.usermenu_currency > a,' +
			'.sidemenu_wrap .usermenu_area ul.usermenu_list li.usermenu_currency.sfHover > a,' +
			'.sidemenu_wrap .usermenu_area ul.usermenu_list li ul li a:hover,' +
			'.sidemenu_wrap .usermenu_area ul.usermenu_list li.usermenu_cart .widget_area ul li a:hover,' +
			'.sc_blogger a:hover,' +
			'.sc_blogger.style_date .load_more:before,' +
			'.sc_blogger.style_date .sc_blogger_item .sc_blogger_date .day_month,' +
			'.sc_blogger.style_date .sc_blogger_item .sc_blogger_info .comments_number,' +
			'.sc_blogger.style_accordion .sc_blogger_info .comments_number,' +
			'.widgetTabs .widgetTop ul > li:not(.tabs):before,' +
			'.widgetTabs .widgetTop ul > li:not(.tabs) > a:hover,' +
			'.widgetTabs .widgetTop ul > li:not(.tabs) > a:hover span,' +
			'.widgetTabs .widgetTop.widget_popular_posts article .post_title:before,' +
			'.swpRightPos .tabsMenuBody a:hover,' +
			'.swpRightPos .tabsMenuBody a:hover:before,' +
			'.openRightMenu:hover:before,' +
			'.topWrap .search:not(.searchOpen):hover:before,' +
			'.user-popUp .formItems.loginFormBody .remember .forgotPwd,' +
			'.user-popUp .formItems.loginFormBody .loginProblem,' +
			'.user-popUp .formItems.registerFormBody .i-agree a,' +
			'.sc_slider_pagination_area .flex-control-nav.manual .slide_info .slide_title,' +
			'#toc .toc_item.current .toc_icon,' +
			'#toc .toc_item:hover .toc_icon,' +
			'.sc_blogger a,' +
			'.relatedPostWrap article .relatedInfo a,' +
			'.sc_list_style_iconed li:before,' +
			'.sc_list_style_arrows li:before,' +
			'.sc_team .sc_team_item .sc_team_item_title,' +
			'.footerStyleLight .footerWidget .widgetWrap .title,' +
			'.widget_calendar #wp-calendar thead th span,' +
			'.wp-calendar thead th span,' +
			'.footerStyleLight .footerWidget .wp-calendar thead th,' +
			'.widget_calendar #wp-calendar thead tr + tr th,' +
			'.wp-calendar thead tr + tr th,' +
			//'.sidebar.widget_area .tabs_area ul.tabs > li.ui-state-active,' +
			//'.sidebar.widget_area .tabs_area ul.tabs > li.ui-state-active a,' +
			//'.sidebar.widget_area .tabs_area ul.tabs > li a:hover,' +
			'.widget_area .search-form .search-button a:hover,' +
            '.sc_section.bg_tint_dark .sc_title a,' +
            '.sc_section.bg_tint_dark a,' +
            '.global .sc_title_icon:before,' +
            '.bg_tint_dark .sc_title_icon:before,' +
            '.infoPost a,' +
            '.masonry article .masonryInfo a' +
			'{color: ' + clr + ';} ' +
			'' +
			'.infoPost .infoTags a:hover,' +
			'.footerStyleDark .widget_area a.button:hover,' +
			'.flip-clock-wrapper ul li a div div.inn,' +
			'.tabsButton ul li.ui-tabs-active a' +
			'{color: ' + clr + ' !important;}' +
			'' +
			'' +
			'' +
			'.theme_accent_bgc,' +
			'.topWrap,' +
			'.sidemenu_wrap .menuTranform,' +
			'.sc_video_player:active .sc_video_play_button:after,' +
			'input[type="submit"]:active,' +
			'input[type="button"]:active,' +
			'.squareButton.active > span,' +
			'.squareButton.active > a,' +
			'.squareButton.ui-state-active > a,' +
			'.roundButton > a:active,' +
			'.squareButton > a:active,' +
			'.squareButton.global > a,' +
			'.squareButton.light > a:hover,' +
			'.squareButton.border > a:hover,' +
			'.roundButton.border:hover > a,' +
			'.nav_pages_parts > span.page_num,' +
			'.nav_comments > span.current,' +
			'ul > li.likeActive:active > a,' +
			'.sc_table.sc_table_style_1 table tr:first-child th,' +
			'.sc_table.sc_table_style_1 table tr:first-child td,' +
			'.masonry article .status,' +
			'.portfolio .isotopeElement .folioShowBlock:before,' +
			'.post .postStatus,' +
			'.itemPageFull .itemDescriptionWrap .toggleButton:active,' +
			'.footerWrap .footerWidget .sc_video_player:active .sc_video_play_button:after,' +
			//'.topWrap .topMenuStyleLine > ul > li ul,' +
			'.topMenuStyleLine > ul .menu-panel,' +
			'.sidemenu_wrap .sidemenu_button,' +
			'.userHeaderSection.global,' +
			'.userFooterSection.global,' +
			'.sliderLogo .elastislide-wrapper nav span:active:before,' +
			'.sc_skills_bar .sc_skills_item .sc_skills_count,' +
			'.sc_skills_counter .sc_skills_item.sc_skills_style_3 .sc_skills_count,' +
			'.sc_skills_counter .sc_skills_item.sc_skills_style_4 .sc_skills_count,' +
			'.sc_skills_counter .sc_skills_item.sc_skills_style_4 .sc_skills_info,' +
			'.sc_dropcaps.sc_dropcaps_style_1 .sc_dropcap,' +
			'.sc_dropcaps.sc_dropcaps_style_2 .sc_dropcap,' +
			'.sc_highlight.sc_highlight_style_1,' +
			'.sc_pricing_table .sc_pricing_columns .sc_pricing_title,' +
			'.sc_pricing_table .sc_pricing_columns:hover ul li.sc_pricing_title,' +
			'.sc_tooltip_parent .sc_tooltip,' +
			'.sc_tooltip_parent .sc_tooltip:before,' +
			'.sc_title_bg:before,' +
			'.sc_accordion.sc_accordion_style_3 .sc_accordion_item .sc_accordion_title,' +
			'.sc_toggles.sc_toggles_style_3 .sc_toggles_item .sc_toggles_title,' +
			'.sc_scroll_controls .flex-direction-nav a:active,' +
			'.sc_testimonials_style_1 .flex-direction-nav a:active,' +
			'.sc_testimonials_style_3 .sc_testimonials_items,' +
			'.sc_testimonials_style_3 .flex-direction-nav li,' +
			'.sc_testimonials_style_3 .flex-direction-nav a,' +
			'.pagination .pageLibrary > li.libPage > .pageFocusBlock .flex-direction-nav a:active,' +
			'.sc_popup_light:before,' +
			'.user-popUp ul.loginHeadTab li.ui-tabs-active:before,' +
			'.sc_banner:before,' +
			'.global_bg,' +
			'.widget .tagcloud a,' +
			'.widgetWrap .tagcloud a,' +
			'.widget .tagcloud a:active,' +
			'.widgetWrap .tagcloud a:active,' +
			'.sc_scroll_bar .swiper-scrollbar-drag:before,' +
			'.widgetTabs .widgetTop .tagcloud a:hover,' +
			'.widgetTabs .widgetTop .tagcloud a:active,' +
			'#custom_options .co_options #co_bg_images_list a.current,' +
			'#custom_options .co_options #co_bg_pattern_list a.current,' +
			'.fullScreenSlider.globalColor .sliderHomeBullets .rsContent:before,' +
			'.fullScreenSlider .sliderHomeBullets .rsContent .slide-3 .order p span,' +
			'ul.sc_list_style_disk li:before,' +
			'.sc_slider_pagination_area .flex-control-nav.manual .slide_date,' +
			'.sc_tabs.sc_tabs_style_2 .sc_tabs_titles li.ui-state-active a,' +
			'.sc_contact_form_custom .bubble label:hover,' +
			'.sc_contact_form_custom .bubble label.selected,' +
			'.sc_video_player:hover .sc_video_play_button:after,' +
			'.footerStyleLight .footerWidget .sc_video_player:hover .sc_video_play_button:after,' +
			'.sidebar.widget_area .tabs_area ul.tabs > li a,' +
			'.widget_area .search-form .search-button a,' +
			'' +
			'.squareButton.light > a:after,' +
			'.squareButton.light > a:after,' +
			'.squareButton.light > span:after,' +
			'.squareButton.light > span:after' +
			'' +
			'{background-color: ' + clr + ';}' +
			'' +
			'' +
			'.sc_table.sc_table_style_1 table tr:first-child th,' +
			'.sc_table.sc_table_style_1 table tr:first-child td' +
			'{border-top-color: ' + clr + ';}' +
			''+
			'.sc_table.sc_table_style_1 table tr:first-child th:first-child,' +
			'.sc_table.sc_table_style_1 table tr:first-child td:first-child' +
			'{border-left-color: ' + clr + ';}' +
			'' +
			'.sc_table.sc_table_style_1 table tr:first-child th:last-child,' +
			'.sc_table.sc_table_style_1 table tr:first-child td:last-child' +
			'{border-right-color: ' + clr + ';}' +
			'' +
			'.theme_accent_bg,' +
			'.ih-item.circle.effect1.colored .info,' +
			'.ih-item.circle.effect2.colored .info,' +
			'.ih-item.circle.effect3.colored .info,' +
			'.ih-item.circle.effect4.colored .info,' +
			'.ih-item.circle.effect5.colored .info .info-back,' +
			'.ih-item.circle.effect6.colored .info,' +
			'.ih-item.circle.effect7.colored .info,' +
			'.ih-item.circle.effect8.colored .info,' +
			'.ih-item.circle.effect9.colored .info,' +
			'.ih-item.circle.effect10.colored .info,' +
			'.ih-item.circle.effect11.colored .info,' +
			'.ih-item.circle.effect12.colored .info,' +
			'.ih-item.circle.effect13.colored .info,' +
			'.ih-item.circle.effect14.colored .info,' +
			'.ih-item.circle.effect15.colored .info,' +
			'.ih-item.circle.effect16.colored .info,' +
			'.ih-item.circle.effect18.colored .info .info-back,' +
			'.ih-item.circle.effect19.colored .info,' +
			'.ih-item.circle.effect20.colored .info .info-back,' +
			'.ih-item.square.effect1.colored .info,' +
			'.ih-item.square.effect2.colored .info,' +
			'.ih-item.square.effect3.colored .info,' +
			'.ih-item.square.effect4.colored .mask1,' +
			'.ih-item.square.effect4.colored .mask2,' +
			'.ih-item.square.effect5.colored .info,' +
			'.ih-item.square.effect6.colored .info,' +
			'.ih-item.square.effect7.colored .info,' +
			'.ih-item.square.effect8.colored .info,' +
			'.ih-item.square.effect9.colored .info .info-back,' +
			'.ih-item.square.effect10.colored .info,' +
			'.ih-item.square.effect11.colored .info,' +
			'.ih-item.square.effect12.colored .info,' +
			'.ih-item.square.effect13.colored .info,' +
			'.ih-item.square.effect14.colored .info,' +
			'.ih-item.square.effect15.colored .info,' +
			'.top_panel_opacity_transparent header.fixedTopMenu .topWrap,' +
			'.hoverIncrease .hoverIcon'+
			'{background: ' + clr + ';}' +
			'' +
			'.ih-item.circle.effect1.colored .info,' +
			'.ih-item.circle.effect2.colored .info,' +
			'.ih-item.circle.effect5.colored .info .info-back,' +
			'.ih-item.circle.effect19.colored .info,' +
			'.ih-item.circle.effect20.colored .info .info-back,' +
			'.ih-item.square.effect4.colored .mask1,' +
			'.ih-item.square.effect4.colored .mask2,' +
			'.ih-item.square.effect6.colored .info,' +
			'.ih-item.square.effect7.colored .info,' +
			'.ih-item.square.effect12.colored .info,' +
			'.ih-item.square.effect13.colored .info,' +
			'.sc_image_shape_round:hover figcaption,' +
			'.post .sc_image_shape_round:hover figcaption' +
			'{background: rgba(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ', 0.6);}' +
			'' +
			'.hoverIncrease .hoverShadow' +
			'{background: rgba(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ', 0.5);}' +
			'' +
			'.ih-item.circle.effect17.colored a:hover .img:before {' +
			'box-shadow: inset 0 0 0 110px ' + clr + ', inset 0 0 0 16px rgba(255, 255, 255, 0.8), 0 1px 2px rgba(0, 0, 0, 0.1);' +
			'box-shadow: inset 0 0 0 110px rgba(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ', 0.6), inset 0 0 0 16px rgba(255, 255, 255, 0.8), 0 1px 2px rgba(0, 0, 0, 0.1);' +
			'}' +
			'' +
			'.ih-item.circle.effect1 .spinner' +
			'{border-right-color: ' + clr + '; border-bottom-color: ' + clr + ';}' +
			'' +
			'.mejs-container, .mejs-embed, .mejs-embed body, .mejs-container .mejs-controls' +
			'{background: ' + clr + ' !important; }' +
			'' +
			'.mejs-controls .mejs-volume-button .mejs-volume-slider' +
			'{background: rgba(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ', 0.7) !important; }' +
			'' +
			'.top_panel_above .fullScreenSlider .topWrap' +
			'{background-color: rgba(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ', 0.8);}' +
			'' +
			'.sc_slider_flex .sc_slider_info,' +
			'.sc_slider_swiper .sc_slider_info,' +
			'.sc_slider_flex .flex-direction-nav li,' +
			'.sc_slider_swiper .flex-direction-nav li' +
			'{background-color: rgba(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ', 0.8) !important;}' +
			'' +
			'.theme_accent_border,' +
			'.postSharing > ul > li > a:active,' +
			'.postSharing > ul > li > span:active,' +
			'.squareButton.active > span,' +
			'.squareButton.active > a,' +
			'.roundButton > a:active,' +
			'.squareButton > a:active,' +
			'.squareButton.ui-state-active > a,' +
			'.squareButton.global > a,' +
			'.squareButton.border > a,' +
			'.roundButton.border > a,' +
			'.squareButton.light > a:hover,' +
			'.nav_pages_parts > span.page_num,' +
			'.nav_comments > span.current,' +
			'.widget_calendar #wp-calendar th,' +
			'.widget_calendar .wp-calendar thead tr + tr th,' +
			'.sc_skills_bar .sc_skills_item .sc_skills_count,' +
			'.itemPageFull .itemDescriptionWrap .toggleButton:active,' +
			'.footerWidget .sc_video_player:active .sc_video_play_button:after,' +
			//'.topWrap .topMenuStyleLine > ul > li ul,' +
			'.topMenuStyleLine > ul#mainmenu ul.menu-panel,' +
			'.sc_scroll_controls .flex-direction-nav a:active,' +
			'.sc_testimonials_style_1 .flex-direction-nav a:active,' +
			'.pagination .flex-direction-nav a:active,' +
			'.sliderLogo .elastislide-wrapper nav span:active:before,' +
			'.sc_dropcaps.sc_dropcaps_style_4 .sc_dropcap,' +
			'.sc_dropcaps.sc_dropcaps_style_5 .sc_dropcap,' +
			'.sc_dropcaps.sc_dropcaps_style_6 .sc_dropcap,' +
			'.sc_accordion.sc_accordion_style_3 .sc_accordion_item,' +
			'.sc_toggles.sc_toggles_style_3 .sc_toggles_item,' +
			'.sc_tooltip_parent,' +
			'pre.code,' +
			'#toc .toc_item.current,' +
			'#toc .toc_item:hover,' +
			'.sidebar.widget_area .tabs_area ul.tabs > li a,' +
			'.widget_area .search-form .search-button a' +
			'{border-color: ' + clr + ';}' +
			'' +
			'';

		if (window.theme_skin_set_theme_color)
			css_text = theme_skin_set_theme_color(css_text, clr);


		// Theme (Accent) color 2
		clr = rgb2hex(jQuery('#co_theme_color2').css('backgroundColor'));
		rgb = hex2rgb(clr);

		css_text +=
			'' +
			'.theme_accent2,' +
			'.sc_title_linked:hover .sc_title,' +
			'.sc_team .sc_team_item .sc_team_item_position,' +
			'.sc_section.bg_tint_dark .pushButton > a:hover,' +
			'.sc_blogger h3 > a, .sc_blogger .h3 > a,' +
			'.openRightMenu:hover:before,' +
			'.topWrap .search:not(.searchOpen):hover:before,' +
			'.sliderHomeBullets.slider_alias_15 .order a:hover,' +
			'.sc_accordion.sc_accordion_style_1 .sc_accordion_item.sc_active .sc_accordion_title,' +
			'.sc_accordion.sc_accordion_style_1 .sc_accordion_item.sc_active .sc_accordion_title:before,' +
			'.sc_blogger.style_date .sc_blogger_item .sc_blogger_info .post_author,' +
			'.sc_blogger.style_date .sc_blogger_item .sc_blogger_info .comments_number,' +
			'.wp-calendar tbody td.today,' +
			'.wp-calendar tbody td.today a,' +
			'label.required:before,' +
			'.topWrap .usermenu_area a:hover,' +
			'.topWrap .usermenu_area ul.usermenu_list > li.sfHover > a,' +
			'h1,' +
			'.h1,' +
			'h1 > a,' +
			'.h1 > a' +
			'{color: ' + clr + ';}' +
			'' +
			'.theme_accent2_bgc,' +
			'.squareButton.global > a:hover,' +
			'.squareButton.dark > a:hover,' +
			'.sc_title_divider.theme_accent2 .sc_title_divider_before,' +
			'.sc_title_divider.theme_accent2 .sc_title_divider_after,' +
			'.sliderHomeBullets.slider_alias_15 .order a,' +
			'.dark .sc_slider_pagination_area .flex-control-nav.manual li.active .slide_date,' +
			'.dark .sc_slider_pagination_area .flex-control-nav.manual li.cs-active-pagination .slide_date,' +
			'.dark .sc_slider_pagination_area .flex-control-nav.manual li:hover .slide_date,' +
			'.sc_blogger.style_date .sc_blogger_item .sc_blogger_date,' +
			'.sc_video_player .sc_video_play_button:after,' +
			'.footerStyleLight .footerWidget .sc_video_player .sc_video_play_button:after,' +
			'.twitBlock,' +
			'.twitBlockWrap,' +
			'.sliderHomeBullets.slider_alias_13 .order a:hover,' +
			'.postAside,' +
			'' +
			'.squareButton.global > a:hover:after,' +
			'.squareButton.global > a:active:after,' +
			'.squareButton.global > span:hover:after,' +
			'.squareButton.global > span:active:after,' +
			'' +
			'.squareButton.dark > a:hover:after,' +
			'.squareButton.dark > a:active:after,' +
			'.squareButton.dark > span:hover:after,' +
			'.squareButton.dark > span:active:after,' +
			'' +
			'.sidebar.widget_area .tabs_area ul.tabs > li a:hover,' +
			'.sidebar.widget_area .tabs_area ul.tabs > li.ui-state-active a' +
			'' +
			'{background-color: ' + clr + ';}' +
			'' +
			'.twitBlock .sc_slider .flex-direction-nav li' +
			'{background-color: ' + clr + ' !important;}' +
			'' +
			'.theme_accent2_bg,' +
			'.widget .tagcloud a:hover,' +
			'.widgetWrap .tagcloud a:hover,' +
			'.widgetTabs .widgetTop .tagcloud a:hover,' +
			'.widgetTabs .widgetTop .tagcloud a:active,' +
			'.topTabsWrap' +
			'{background: ' + clr + ';}' +
			'' +
			'.theme_accent2_border,' +
			//'.topWrap .topMenuStyleLine > ul > li ul,' +
			'.topWrap .openRightMenu:hover,' +
			'.topWrap .search:not(.searchOpen):hover,' +
			'.sliderHomeBullets.slider_alias_13 .order a:hover' +
			'' +
			'.sc_accordion.sc_accordion_style_1 .sc_accordion_item.sc_active .sc_accordion_title:before,' +
			'.sidebar.widget_area .tabs_area ul.tabs > li a:hover,' +
			'.sidebar.widget_area .tabs_area ul.tabs > li.ui-state-active a' +
			'{border-color: ' + clr + ';}' +
			'' +
			'.squareButton.global > a:hover,' +
			'.squareButton.dark > a:hover' +
			'{border-color: ' + clr + ' !important;}' +
			'' +
			'::selection {color: #fff; background-color: ' + clr + ';}' +
			'::-moz-selection {color: #fff; background-color: ' + clr + ';}' +
			'' +
			'';

		if (window.theme_skin_set_theme_color2)
			css_text = theme_skin_set_theme_color2(css_text, clr);

		// Theme (Accent) color 3
		clr = rgb2hex(jQuery('#co_theme_color3').css('backgroundColor'));
		rgb = hex2rgb(clr);

		css_text +=
			'' +
			'.theme_color3 ' +
			'.theme_dark,' +
			'h2, h3, h4, h5, h6,' +
			'.h2, .h3, .h4, .h5, .h6,' +
			'h2 > a, h3 > a, h4 > a, h5 > a, h6 > a,' +
			'.h2 > a, .h3 > a, .h4 > a, .h5 > a, .h6 > a' +
			'{color: ' + clr + ';}' +
			'' +
			'.theme_dark_bgc' +
			'{background-color: ' + clr + ';}' +
			'' +
			'';

		if (window.theme_skin_set_theme_color3)
			css_text = theme_skin_set_theme_color3(css_text, clr);

		// Apply styles
		styles.html(css_text);
	}
}
