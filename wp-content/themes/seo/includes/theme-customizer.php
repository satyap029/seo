<?php
// Redefine colors in styles
$THEMEREX_custom_css = "";

function getThemeCustomStyles() {
	global $THEMEREX_custom_css;
	return $THEMEREX_custom_css;//str_replace(array("\n", "\r", "\t"), '', $THEMEREX_custom_css);
}

function addThemeCustomStyle($style) {
	global $THEMEREX_custom_css;
	$THEMEREX_custom_css .= "
		{$style}
	";
}

function prepareThemeCustomStyles() {
	// Custom fonts
	if (get_custom_option('typography_custom')=='yes') {
		$s = '';
		$fonts = getThemeFontsList(false);
		$fname = get_custom_option('typography_p_font');
		if (isset($fonts[$fname])) {
			$fstyle = explode(',', get_custom_option('typography_p_style'));
			$fname2 = ($pos=themerex_strpos($fname,' ('))!==false ? themerex_substr($fname, 0, $pos) : $fname;
			$i = in_array('i', $fstyle);
			$u = in_array('u', $fstyle);
			$c = get_custom_option('typography_p_color');
			$s .= "
				body, button, input, select, textarea {
					font-family: '".($fname2)."'".(isset($fonts[$fname]['family']) ? ", ".($fonts[$fname]['family']) : '').";
				}
				body {
					font-size: ".get_custom_option('typography_p_size')."px;
					font-weight: ".get_custom_option('typography_p_weight').";
					line-height: ".get_custom_option('typography_p_lineheight')."px;
					".($c ? "color: ".esc_attr($c).";" : '')."
					".($i ? "font-style: italic;" : '')."
					".($u ? "text-decoration: underline;" : '')."
				}
			";
		}
		for ($h=1; $h<=6; $h++) {
			$fname = get_custom_option('typography_h'.esc_attr($h).'_font');
			if (isset($fonts[$fname])) {
				$fstyle = explode(',', get_custom_option('typography_h'.esc_attr($h).'_style'));
				$fname2 = ($pos=themerex_strpos($fname,' ('))!==false ? themerex_substr($fname, 0, $pos) : $fname;
				$i = in_array('i', $fstyle);
				$u = in_array('u', $fstyle);
				$c = get_custom_option('typography_h'.esc_attr($h).'_color');
				$s .= "
					h".esc_attr($h).", .h".esc_attr($h)." {
						font-family: '".esc_attr($fname2)."'".(isset($fonts[$fname]['family']) ? ", ".esc_attr($fonts[$fname]['family']) : '').";
						font-size: ".get_custom_option('typography_h'.esc_attr($h).'_size')."px;
						font-weight: ".get_custom_option('typography_h'.esc_attr($h).'_weight').";
						line-height: ".get_custom_option('typography_h'.esc_attr($h).'_lineheight')."px;
						".($c ? "color: ".esc_attr($c).";" : '')."
						".($i ? "font-style: italic;" : '')."
						".($u ? "text-decoration: underline;" : '')."
					}
					h".esc_attr($h)." a, .h".esc_attr($h)." a {
						".($c ? "color: ".esc_attr($c).";" : '')."
					}
				";
			}
		}
		if (!empty($s)) addThemeCustomStyle($s);
	}

	// Submenu width
	$menu_width = (int) get_theme_option('menu_width');
	if ($menu_width > 50) {
		addThemeCustomStyle("
			.topWrap .topMenuStyleFon > ul > li ul,
			.topWrap .topMenuStyleLine > ul > li ul {
				width: {$menu_width}px;
			}
			.topWrap .topMenuStyleFon > ul > li ul li ul {
				left: ".($menu_width+10)."px;
			}
			.menu_right .topWrap .topMenuStyleFon ul.submenu_left {
				left: -".($menu_width+10)."px !important;
			}

			.topWrap .topMenuStyleLine > ul > li ul li ul {
				left: ".($menu_width+3)."px;
			}
			.menu_right .topWrap .topMenuStyleLine ul.submenu_left {
				left: -".($menu_width+4)."px !important;
			}
			ul#mainmenu .menu-panel ul.columns > li ul {
				max-width: ".($menu_width)."px;
			}

		");
	}

	// Logo height
	$logo_height = (int) get_custom_option('logo_height');
	$logo_offset = (int) get_custom_option('logo_offset');
	if ($logo_height > 10) {
		if (empty($logo_offset)) {
			$logo_offset = max(20, round((100 - $logo_height) / 2));
		}
		$add = max(0, round(($logo_offset*2 + $logo_height - 100) / 2)); 
		addThemeCustomStyle("
			header.noFixMenu .topWrap .logo {
				height: ".($logo_height)."px;
			}
			header.noFixMenu .topWrap .logo img {
				height: ".($logo_height)."px;
			}
			header.noFixMenu .topWrap .logo .logo_text {
				line-height: ".($logo_height)."px;
			}
			header.noFixMenu.menu_right .topWrap .openRightMenu,
			header.noFixMenu.menu_right .topWrap .search {
				margin-top: ".(33 + $add)."px;
				margin-bottom: ".(37 + $add)."px;
			}
			header.noFixMenu.menu_right .topWrap .topMenuStyleLine > ul > li,
			header.noFixMenu.menu_right .topWrap .topMenuStyleFon > ul > li {
				padding-top: ".(30 + $add)."px;
				padding-bottom: ".(30 + $add)."px;
			}
			header.noFixMenu.menu_right .topWrap .topMenuStyleFon > ul#mainmenu > li > .menu-panel,
			header.noFixMenu.menu_right .topWrap .topMenuStyleFon > ul > li > ul {
				top: ".(67 + $add)."px;
			}
			header.noFixMenu.menu_right .topWrap .topMenuStyleLine > ul#mainmenu > li > .menu-panel,
			header.noFixMenu.menu_right .topWrap .topMenuStyleLine > ul > li > ul {
				top: ".(100 + $add)."px;
			}
		");
	}

	// Logo top offset
	if ($logo_offset > 0) {
		addThemeCustomStyle("
			header.noFixMenu .topWrap .logo {
				padding: ".($logo_offset)."px 0 0 0;
			}
		");
	}

	$logo_height = (int) get_theme_option('logo_image_footer_height');
	if ($logo_height > 10) {
		addThemeCustomStyle("
			footer .logo img {
				height: ".($logo_height)."px;
			}
		");
	}
	
	// Main Slider height
	$slider_height = (int) get_custom_option('slider_height');
	if ($slider_height > 10) {
		addThemeCustomStyle("
			.sliderHomeBullets {
				height: ".($slider_height)."px;
			}
		");
	}
	

	// Custom css from theme options
	$css = get_custom_option('custom_css');
	if (!empty($css)) {
		addThemeCustomStyle($css);
	}

	$custom_style = '';
	$customizer = get_theme_option('show_theme_customizer') == 'yes';

	// Theme color from customizer
	$clr = '';
	if ($customizer)
		$clr = getValueGPC('theme_color', '');
	if (empty($clr))
		$clr = get_custom_option('theme_color');
	if (!empty($clr)) {
		$rgb = hex2rgb($clr);
		$custom_style .= '
a:hover,
.theme_accent,
.topWrap .topMenuStyleFon > ul li a:hover,
.topWrap .topMenuStyleFon > ul > li.sfHover > a,
.topWrap .topMenuStyleFon > ul > li > a.sf-with-ul:hover,
.topWrap .topMenuStyleFon > ul > li ul a.sf-with-ul:after,
.topWrap .topMenuStyleLine > ul > li ul li a:hover,
.topMenuStyleFon ul#mainmenu .menu-panel ul.columns > li > a,
.topMenuStyleFon ul#mainmenu .menu-panel ul.columns > li a:hover,
.topMenuStyleFon ul#mainmenu .menu-panel ul.columns > li ul li a:hover,
.topMenuStyleFon ul#mainmenu .menu-panel ul.thumb_title > li > a,
.topMenuStyleFon ul#mainmenu .menu-panel ul.thumb_title > li > a:hover,
.infoPost a:hover,
.tabsButton ul li a:hover,
.widgetWrap  ul  li:before,
.popularFiltr ul li a:hover,
.isotopeFiltr ul li a:hover,
.widget_popular_posts article h3:before,
.widgetTabs .widget_popular_posts article .post_info .post_date a:hover,
.sidebar .widget_popular_posts article .post_info .post_date a:hover,
.sidebar .widget_recent_posts article .post_info .post_date a:hover,
.main .widgetWrap a:hover,
.main .widgetWrap a:hover span,
.widgetWrap a:hover span,
.roundButton:hover a,
input[type="submit"]:hover,
input[type="button"]:hover,
.squareButton.border > a,
.roundButton.border > a,
.nav_pages_parts > a:hover,
.nav_comments > a:hover,
.comments_list a.comment-edit-link:hover,
.widget_area ul.tabs > li.squareButtonlite.ui-state-active > a,
.widget_calendar #wp-calendar tbody td a,
.wp-calendar tbody td a,
.widget_calendar #wp-calendar tbody td.today a:hover,
.wp-calendar tbody td.today a:hover,
blockquote cite,
blockquote cite a,
.sc_quote_title,
.sc_quote_title a,
.postLink a,
.masonry article .masonryInfo a:hover,
.masonry article .masonryInfo span.infoTags a:hover,
.relatedPostWrap article .relatedInfo a:hover,
.relatedPostWrap article .relatedInfo span.infoTags a:hover,
.infoPost span.infoTags a:hover,
.page404 p a,
.page404 .searchAnimation.sFocus .searchIcon,
.sc_team .sc_team_item .sc_team_item_position,
.copyWrap a,
.comments .commBody li.commItem .replyWrap .posted a:hover,
.comments .commBody li.commItem h4 a:hover,
.ratingItem span:before,
.reviewBlock .totalRating,
.widget_area .contactInfo .fContact:before,
.widget_area .widgetWrap a:hover,
.widget_area .widgetWrap a:hover span,
.widget_area .widgetWrap ul > li > a:hover,
.widget_area .widgetWrap ul > li > a:hover span,
.footerStyleLight .widget_area article .post_title:before,
.footerStyleLight .widget_area article .post_info a:hover,
.footerStyleLight .widget_area article .post_info .post_date a:hover,
.sc_list_style_arrows li:before,
.sc_list_style_arrows li a:hover,
.sc_list_style_iconed li a:hover,
.sc_accordion.sc_accordion_style_1 .sc_accordion_item .sc_accordion_title,
.sc_accordion.sc_accordion_style_1 .sc_accordion_item .sc_accordion_title:before,
.sc_accordion.sc_accordion_style_2 .sc_accordion_item.sc_active .sc_accordion_title,
.sc_accordion.sc_accordion_style_2 .sc_accordion_item.sc_active .sc_accordion_title:before,
.sc_accordion.sc_accordion_style_3 .sc_accordion_item.sc_active .sc_accordion_title,
.sc_toggles.sc_toggles_style_1 .sc_toggles_item .sc_toggles_title,
.sc_toggles.sc_toggles_style_1 .sc_toggles_item .sc_toggles_title:before,
.sc_toggles.sc_toggles_style_2 .sc_toggles_item.sc_active .sc_toggles_title,
.sc_toggles.sc_toggles_style_2 .sc_toggles_item.sc_active .sc_toggles_title:before,
.sc_toggles.sc_toggles_style_3 .sc_toggles_item.sc_active .sc_toggles_title,
.sc_tabs .sc_tabs_titles li a:hover,
.sc_dropcaps.sc_dropcaps_style_3 .sc_dropcap,
.sc_dropcaps.sc_dropcaps_style_4 .sc_dropcap,
.sc_dropcaps.sc_dropcaps_style_5 .sc_dropcap,
.sc_dropcaps.sc_dropcaps_style_6 .sc_dropcap,
.sc_highlight.sc_highlight_style_2,
.sc_price_item .sc_price_money,
.sc_price_item .sc_price_penny,
.sc_pricing_table .sc_pricing_columns ul li .sc_icon,
.sc_tooltip_parent,
.sc_title_icon:before,
.sc_scroll_controls .flex-direction-nav a:hover:before,
.sc_testimonials_style_1 .flex-direction-nav a:hover:before,
.sc_testimonials_style_3 .flex-direction-nav a:hover:before,
.sc_testimonials_style_3 .flex-direction-nav a:active:before,
.pagination .pageLibrary > li.libPage > .pageFocusBlock .flex-direction-nav a:hover:before,
.topWrap .usermenu_area ul.usermenu_list li.usermenu_currency > a:hover,
.topWrap .usermenu_area ul.usermenu_list li.usermenu_currency > a,
.topWrap .usermenu_area ul.usermenu_list li.usermenu_currency.sfHover > a,
.topWrap .usermenu_area ul.usermenu_list li ul li a:hover,
.topWrap .usermenu_area ul.usermenu_list li.usermenu_cart .widget_area ul li a:hover,
.sidemenu_wrap .usermenu_area ul.usermenu_list li.usermenu_currency > a:hover,
.sidemenu_wrap .usermenu_area ul.usermenu_list li.usermenu_currency > a,
.sidemenu_wrap .usermenu_area ul.usermenu_list li.usermenu_currency.sfHover > a,
.sidemenu_wrap .usermenu_area ul.usermenu_list li ul li a:hover,
.sidemenu_wrap .usermenu_area ul.usermenu_list li.usermenu_cart .widget_area ul li a:hover,
.sc_blogger a:hover,
.sc_blogger.style_date .load_more:before,
.sc_blogger.style_date .sc_blogger_item .sc_blogger_date .day_month,
.sc_blogger.style_date .sc_blogger_item .sc_blogger_info .comments_number,
.sc_blogger.style_accordion .sc_blogger_info .comments_number,
.widgetTabs .widgetTop ul > li:not(.tabs):before,
.widgetTabs .widgetTop ul > li:not(.tabs) > a:hover,
.widgetTabs .widgetTop ul > li:not(.tabs) > a:hover span,
.widgetTabs .widgetTop.widget_popular_posts article .post_title:before,
.swpRightPos .tabsMenuBody a:hover,
.swpRightPos .tabsMenuBody a:hover:before,
.openRightMenu:hover:before,
.topWrap .search:not(.searchOpen):hover:before,
.user-popUp .formItems.loginFormBody .remember .forgotPwd,
.user-popUp .formItems.loginFormBody .loginProblem,
.user-popUp .formItems.registerFormBody .i-agree a,
.sc_slider_pagination_area .flex-control-nav.manual .slide_info .slide_title,
#toc .toc_item.current .toc_icon,
#toc .toc_item:hover .toc_icon,
.sc_blogger a,
.relatedPostWrap article .relatedInfo a,
.sc_list_style_iconed li:before,
.sc_list_style_arrows li:before,
.sc_team .sc_team_item .sc_team_item_title,
.footerStyleLight .footerWidget .widgetWrap .title,
.widget_calendar #wp-calendar thead th span,
.wp-calendar thead th span,
.footerStyleLight .footerWidget .wp-calendar thead th,
.widget_calendar #wp-calendar thead tr + tr th,
.wp-calendar thead tr + tr th,
/*.sidebar.widget_area .tabs_area ul.tabs > li.ui-state-active,*/
/*.sidebar.widget_area .tabs_area ul.tabs > li.ui-state-active a,*/
/*.sidebar.widget_area .tabs_area ul.tabs > li a:hover,*/
.widget_area .search-form .search-button a:hover,
.sc_section.bg_tint_dark .sc_title a,
.sc_section.bg_tint_dark a,
.global .sc_title_icon:before,
.bg_tint_dark .sc_title_icon:before,
.infoPost a,
.masonry article .masonryInfo a
'.(!function_exists('is_woocommerce') ? '' : ',
.woocommerce div.product span.price, .woocommerce div.product p.price, .woocommerce #content div.product span.price, .woocommerce #content div.product p.price, .woocommerce-page div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page #content div.product p.price,.woocommerce ul.products li.product .price,.woocommerce-page ul.products li.product .price,
.woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce #content input.button.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce-page #content input.button.alt:hover,
.woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce #content input.button:hover, .woocommerce-page a.button:hover, .woocommerce-page button.button:hover, .woocommerce-page input.button:hover, .woocommerce-page #respond input#submit:hover, .woocommerce-page #content input.button:hover,
.woocommerce .quantity input[type="button"]:hover, .woocommerce #content input[type="button"]:hover, .woocommerce-page .quantity input[type="button"]:hover, .woocommerce-page #content .quantity input[type="button"]:hover,
.woocommerce ul.cart_list li > .amount, .woocommerce ul.product_list_widget li > .amount, .woocommerce-page ul.cart_list li > .amount, .woocommerce-page ul.product_list_widget li > .amount,
.woocommerce ul.cart_list li span .amount, .woocommerce ul.product_list_widget li span .amount, .woocommerce-page ul.cart_list li span .amount, .woocommerce-page ul.product_list_widget li span .amount,
.woocommerce ul.cart_list li ins .amount, .woocommerce ul.product_list_widget li ins .amount, .woocommerce-page ul.cart_list li ins .amount, .woocommerce-page ul.product_list_widget li ins .amount,
.woocommerce.widget_shopping_cart .total .amount, .woocommerce .widget_shopping_cart .total .amount, .woocommerce-page.widget_shopping_cart .total .amount, .woocommerce-page .widget_shopping_cart .total .amount,
.woocommerce a:hover h3, .woocommerce-page a:hover h3,
.woocommerce .cart-collaterals .order-total strong, .woocommerce-page .cart-collaterals .order-total strong,
.woocommerce .checkout #order_review .order-total .amount, .woocommerce-page .checkout #order_review .order-total .amount,
.woocommerce .star-rating, .woocommerce-page .star-rating, .woocommerce .star-rating:before, .woocommerce-page .star-rating:before,
.widget_area .widgetWrap ul > li .star-rating span, .woocommerce #review_form #respond .stars a, .woocommerce-page #review_form #respond .stars a
').'
{ color:'.esc_attr($clr).'; }

.infoPost .infoTags a:hover,
.footerStyleDark .widget_area a.button:hover,
.flip-clock-wrapper ul li a div div.inn,
.tabsButton ul li.ui-tabs-active a
{ color:'.esc_attr($clr).' !important; }

.theme_accent_bgc,
.topWrap,
.sidemenu_wrap .menuTranform,
.sc_video_player:active .sc_video_play_button:after,
input[type="submit"]:active,
input[type="button"]:active,
.squareButton.active > span,
.squareButton.active > a,
.squareButton.ui-state-active > a,
.roundButton > a:active,
.squareButton > a:active,
.squareButton.global > a,
.squareButton.light > a:hover,
.squareButton.border > a:hover,
.roundButton.border:hover > a,
.nav_pages_parts > span.page_num,
.nav_comments > span.current,
ul > li.likeActive:active > a,
.sc_table.sc_table_style_1 table tr:first-child th,
.sc_table.sc_table_style_1 table tr:first-child td,
.masonry article .status,
.portfolio .isotopeElement .folioShowBlock:before,
.post .postStatus,
.itemPageFull .itemDescriptionWrap .toggleButton:active,
.footerWrap .footerWidget .sc_video_player:active .sc_video_play_button:after,
/*.topWrap .topMenuStyleLine > ul > li ul,*/
.topMenuStyleLine > ul .menu-panel,
.sidemenu_wrap .sidemenu_button,
.userHeaderSection.global,
.userFooterSection.global,
.sliderLogo .elastislide-wrapper nav span:active:before,
.sc_skills_bar .sc_skills_item .sc_skills_count,
.sc_skills_counter .sc_skills_item.sc_skills_style_3 .sc_skills_count,
.sc_skills_counter .sc_skills_item.sc_skills_style_4 .sc_skills_count,
.sc_skills_counter .sc_skills_item.sc_skills_style_4 .sc_skills_info,
.sc_dropcaps.sc_dropcaps_style_1 .sc_dropcap,
.sc_dropcaps.sc_dropcaps_style_2 .sc_dropcap,
.sc_highlight.sc_highlight_style_1,
.sc_pricing_table .sc_pricing_columns .sc_pricing_title,
.sc_pricing_table .sc_pricing_columns:hover ul li.sc_pricing_title,
.sc_tooltip_parent .sc_tooltip,
.sc_tooltip_parent .sc_tooltip:before,
.sc_title_bg:before,
.sc_accordion.sc_accordion_style_3 .sc_accordion_item .sc_accordion_title,
.sc_toggles.sc_toggles_style_3 .sc_toggles_item .sc_toggles_title,
.sc_scroll_controls .flex-direction-nav a:active,
.sc_testimonials_style_1 .flex-direction-nav a:active,
.sc_testimonials_style_3 .sc_testimonials_items,
.sc_testimonials_style_3 .flex-direction-nav li,
.sc_testimonials_style_3 .flex-direction-nav a,
.pagination .pageLibrary > li.libPage > .pageFocusBlock .flex-direction-nav a:active,
.sc_popup_light:before,
.user-popUp ul.loginHeadTab li.ui-tabs-active:before,
.sc_banner:before,
.global_bg,
.widget .tagcloud a,
.widgetWrap .tagcloud a,
.widget .tagcloud a:active,
.widgetWrap .tagcloud a:active,
.sc_scroll_bar .swiper-scrollbar-drag:before,
.widgetTabs .widgetTop .tagcloud a:hover,
.widgetTabs .widgetTop .tagcloud a:active,
#custom_options .co_options #co_bg_images_list a.current,
#custom_options .co_options #co_bg_pattern_list a.current,
.fullScreenSlider.globalColor .sliderHomeBullets .rsContent:before,
.fullScreenSlider .sliderHomeBullets .rsContent .slide-3 .order p span,
ul.sc_list_style_disk li:before,
.sc_slider_pagination_area .flex-control-nav.manual .slide_date,
.sc_tabs.sc_tabs_style_2 .sc_tabs_titles li.ui-state-active a,
.sc_contact_form_custom .bubble label:hover,
.sc_contact_form_custom .bubble label.selected,
.sc_video_player:hover .sc_video_play_button:after,
.footerStyleLight .footerWidget .sc_video_player:hover .sc_video_play_button:after,
.sidebar.widget_area .tabs_area ul.tabs > li a,
.widget_area .search-form .search-button a,

.squareButton.light > a:after,
.squareButton.light > a:after,
.squareButton.light > span:after,
.squareButton.light > span:after
'.(!function_exists('is_woocommerce') ? '' : ',
.woocommerce .woocommerce-message:before, .woocommerce-page .woocommerce-message:before,.woocommerce .widget_price_filter .ui-slider .ui-slider-range,.woocommerce-page .widget_price_filter .ui-slider .ui-slider-range
').'
'.(!class_exists('TribeEvents') ? '' : ',
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"], .tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"] > a, #tribe_events_filters_wrapper input[type="submit"], .tribe-events-button, #tribe-events .tribe-events-button, .tribe-events-button.tribe-inactive, #tribe-events .tribe-events-button:hover, .tribe-events-button:hover, .tribe-events-button.tribe-active:hover
').'
{ background-color:'.esc_attr($clr).'; }

.sc_table.sc_table_style_1 table tr:first-child th,
.sc_table.sc_table_style_1 table tr:first-child td {
	border-top-color: '.esc_attr($clr).';
}
.sc_table.sc_table_style_1 table tr:first-child th:first-child,
.sc_table.sc_table_style_1 table tr:first-child td:first-child {
	border-left-color: '.esc_attr($clr).';
}
.sc_table.sc_table_style_1 table tr:first-child th:last-child,
.sc_table.sc_table_style_1 table tr:first-child td:last-child {
	border-right-color: '.esc_attr($clr).';
}


'.(!function_exists('is_woocommerce') ? '' : '
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle
{ background:'.esc_attr($clr).'; }
').'

'.(!class_exists('TribeEvents') ? '' : ',
#tribe-bar-form .tribe-bar-submit input[type="submit"]
{ background:'.esc_attr($clr).'; }
').'

.theme_accent_bg,
.ih-item.circle.effect1.colored .info,
.ih-item.circle.effect2.colored .info,
.ih-item.circle.effect3.colored .info,
.ih-item.circle.effect4.colored .info,
.ih-item.circle.effect5.colored .info .info-back,
.ih-item.circle.effect6.colored .info,
.ih-item.circle.effect7.colored .info,
.ih-item.circle.effect8.colored .info,
.ih-item.circle.effect9.colored .info,
.ih-item.circle.effect10.colored .info,
.ih-item.circle.effect11.colored .info,
.ih-item.circle.effect12.colored .info,
.ih-item.circle.effect13.colored .info,
.ih-item.circle.effect14.colored .info,
.ih-item.circle.effect15.colored .info,
.ih-item.circle.effect16.colored .info,
.ih-item.circle.effect18.colored .info .info-back,
.ih-item.circle.effect19.colored .info,
.ih-item.circle.effect20.colored .info .info-back,
.ih-item.square.effect1.colored .info,
.ih-item.square.effect2.colored .info,
.ih-item.square.effect3.colored .info,
.ih-item.square.effect4.colored .mask1,
.ih-item.square.effect4.colored .mask2,
.ih-item.square.effect5.colored .info,
.ih-item.square.effect6.colored .info,
.ih-item.square.effect7.colored .info,
.ih-item.square.effect8.colored .info,
.ih-item.square.effect9.colored .info .info-back,
.ih-item.square.effect10.colored .info,
.ih-item.square.effect11.colored .info,
.ih-item.square.effect12.colored .info,
.ih-item.square.effect13.colored .info,
.ih-item.square.effect14.colored .info,
.ih-item.square.effect15.colored .info,
.top_panel_opacity_transparent header.fixedTopMenu .topWrap,
.hoverIncrease .hoverIcon
{ background:'.esc_attr($clr).'; }

.ih-item.circle.effect1.colored .info,
.ih-item.circle.effect2.colored .info,
.ih-item.circle.effect5.colored .info .info-back,
.ih-item.circle.effect19.colored .info,
.ih-item.circle.effect20.colored .info .info-back,
.ih-item.square.effect4.colored .mask1,
.ih-item.square.effect4.colored .mask2,
.ih-item.square.effect6.colored .info,
.ih-item.square.effect7.colored .info,
.ih-item.square.effect12.colored .info,
.ih-item.square.effect13.colored .info,
.sc_image_shape_round:hover figcaption,
.post .sc_image_shape_round:hover figcaption
{ background: rgba('.esc_attr($rgb['r']).','.esc_attr($rgb['g']).','.esc_attr($rgb['b']).',0.6); }

.hoverIncrease .hoverShadow
{ background: rgba('.esc_attr($rgb['r']).','.esc_attr($rgb['g']).','.esc_attr($rgb['b']).',0.5); }

.ih-item.circle.effect1 .spinner
{border-right-color: #ffb72f; border-bottom-color: #ffb72f;}

.mejs-container, .mejs-embed, .mejs-embed body, .mejs-container .mejs-controls
{background: '.esc_attr($clr).' !important; }

.mejs-controls .mejs-volume-button .mejs-volume-slider
{ background-color: rgba('.esc_attr($rgb['r']).','.esc_attr($rgb['g']).','.esc_attr($rgb['b']).',0.7) !important; }

.top_panel_above .fullScreenSlider .topWrap
{ background-color: rgba('.esc_attr($rgb['r']).','.esc_attr($rgb['g']).','.esc_attr($rgb['b']).',0.8); }

.sc_slider_flex .sc_slider_info,
.sc_slider_swiper .sc_slider_info,
.sc_slider_flex .flex-direction-nav li,
.sc_slider_swiper .flex-direction-nav li
{ background-color: rgba('.esc_attr($rgb['r']).','.esc_attr($rgb['g']).','.esc_attr($rgb['b']).',0.8) !important; }

.theme_accent_border,
.postSharing > ul > li > a:active,
.postSharing > ul > li > span:active,
.squareButton.active > span,
.squareButton.active > a,
.roundButton > a:active,
.squareButton > a:active,
.squareButton.ui-state-active > a,
.squareButton.global > a,
.squareButton.border > a,
.roundButton.border > a,
.squareButton.light > a:hover,
.nav_pages_parts > span.page_num,
.nav_comments > span.current,
.widget_calendar #wp-calendar th,
.widget_calendar .wp-calendar thead tr + tr th,
.sc_skills_bar .sc_skills_item .sc_skills_count,
.itemPageFull .itemDescriptionWrap .toggleButton:active,
.footerWidget .sc_video_player:active .sc_video_play_button:after,
/*.topWrap .topMenuStyleLine > ul > li ul,*/
.topMenuStyleLine > ul#mainmenu ul.menu-panel,
.sc_scroll_controls .flex-direction-nav a:active,
.sc_testimonials_style_1 .flex-direction-nav a:active,
.pagination .flex-direction-nav a:active,
.sliderLogo .elastislide-wrapper nav span:active:before,
.sc_dropcaps.sc_dropcaps_style_4 .sc_dropcap,
.sc_dropcaps.sc_dropcaps_style_5 .sc_dropcap,
.sc_dropcaps.sc_dropcaps_style_6 .sc_dropcap,
.sc_accordion.sc_accordion_style_3 .sc_accordion_item,
.sc_toggles.sc_toggles_style_3 .sc_toggles_item,
.sc_tooltip_parent,
pre.code,
#toc .toc_item.current,
#toc .toc_item:hover,
.sidebar.widget_area .tabs_area ul.tabs > li a,
.widget_area .search-form .search-button a
{ border-color:'.esc_attr($clr).'; }

.squareButton.light > a:hover
{ border-color:'.esc_attr($clr).' !important; }

'.(!function_exists('is_woocommerce') ? '' : '
.woocommerce .woocommerce-message, .woocommerce-page .woocommerce-message,
.woocommerce a.button.alt:active, .woocommerce button.button.alt:active, .woocommerce input.button.alt:active, .woocommerce #respond input#submit.alt:active, .woocommerce #content input.button.alt:active, .woocommerce-page a.button.alt:active, .woocommerce-page button.button.alt:active, .woocommerce-page input.button.alt:active, .woocommerce-page #respond input#submit.alt:active, .woocommerce-page #content input.button.alt:active,
.woocommerce a.button:active, .woocommerce button.button:active, .woocommerce input.button:active, .woocommerce #respond input#submit:active, .woocommerce #content input.button:active, .woocommerce-page a.button:active, .woocommerce-page button.button:active, .woocommerce-page input.button:active, .woocommerce-page #respond input#submit:active, .woocommerce-page #content input.button:active
{ border-top-color:'.esc_attr($clr).'; }
').'

';
		$custom_style = apply_filters('theme_skin_set_theme_color', $custom_style, $clr);
	}

	// Theme color 2 from customizer
	$clr12 = '';
	if ($customizer)
		$clr12 = getValueGPC('theme_color2', '');
	if (empty($clr12))
		$clr12 = get_custom_option('theme_color2');
	if (!empty($clr12)) {
		$clr = $clr12;
		$rgb = hex2rgb($clr);
		$custom_style .= '

.theme_accent2,
.sc_title_linked:hover .sc_title,
.sc_team .sc_team_item .sc_team_item_position,
.sc_section.bg_tint_dark .pushButton > a:hover,
.sc_blogger h3 > a, .sc_blogger .h3 > a,
.openRightMenu:hover:before,
.topWrap .search:not(.searchOpen):hover:before,
.sliderHomeBullets.slider_alias_15 .order a:hover,
.sc_accordion.sc_accordion_style_1 .sc_accordion_item.sc_active .sc_accordion_title,
.sc_accordion.sc_accordion_style_1 .sc_accordion_item.sc_active .sc_accordion_title:before,
.sc_blogger.style_date .sc_blogger_item .sc_blogger_info .post_author,
.sc_blogger.style_date .sc_blogger_item .sc_blogger_info .comments_number,
.wp-calendar tbody td.today,
.wp-calendar tbody td.today a,
label.required:before,
.topWrap .usermenu_area a:hover,
.topWrap .usermenu_area ul.usermenu_list > li.sfHover > a,
h1,
.h1,
h1 > a,
.h1 > a
{color: ' . esc_attr($clr) . ';}

.theme_accent2_bgc,
.squareButton.global > a:hover,
.squareButton.dark > a:hover,
.sc_title_divider.theme_accent2 .sc_title_divider_before,
.sc_title_divider.theme_accent2 .sc_title_divider_after,
.sliderHomeBullets.slider_alias_15 .order a,
.dark .sc_slider_pagination_area .flex-control-nav.manual li.active .slide_date,
.dark .sc_slider_pagination_area .flex-control-nav.manual li.cs-active-pagination .slide_date,
.dark .sc_slider_pagination_area .flex-control-nav.manual li:hover .slide_date,
.sc_blogger.style_date .sc_blogger_item .sc_blogger_date,
.sc_video_player .sc_video_play_button:after,
.footerStyleLight .footerWidget .sc_video_player .sc_video_play_button:after,
.twitBlock,
.twitBlockWrap,
.sliderHomeBullets.slider_alias_13 .order a:hover,
.postAside,

.squareButton.global > a:hover:after,
.squareButton.global > a:active:after,
.squareButton.global > span:hover:after,
.squareButton.global > span:active:after,

.squareButton.dark > a:hover:after,
.squareButton.dark > a:active:after,
.squareButton.dark > span:hover:after,
.squareButton.dark > span:active:after,

.sidebar.widget_area .tabs_area ul.tabs > li a:hover,
.sidebar.widget_area .tabs_area ul.tabs > li.ui-state-active a

{background-color: ' . esc_attr($clr) . ';}

.twitBlock .sc_slider .flex-direction-nav li
{background-color: ' . esc_attr($clr) . ' !important;}

.theme_accent2_bg,
.widget .tagcloud a:hover,
.widgetWrap .tagcloud a:hover,
.widgetTabs .widgetTop .tagcloud a:hover,
.widgetTabs .widgetTop .tagcloud a:active,
.topTabsWrap
{background: ' . esc_attr($clr) . ';}

.theme_accent2_border,
/*.topWrap .topMenuStyleLine > ul > li ul,*/
.topWrap .openRightMenu:hover,
.topWrap .search:not(.searchOpen):hover,
.sliderHomeBullets.slider_alias_13 .order a:hover,

.sc_accordion.sc_accordion_style_1 .sc_accordion_item.sc_active .sc_accordion_title:before,
.sidebar.widget_area .tabs_area ul.tabs > li a:hover,
.sidebar.widget_area .tabs_area ul.tabs > li.ui-state-active a
{border-color: ' . esc_attr($clr) . ';}

.squareButton.global > a:hover,
.squareButton.dark > a:hover
{border-color: ' . esc_attr($clr) . ' !important;}

::selection {color: #fff; background-color: ' . esc_attr($clr) . ';}
::-moz-selection {color: #fff; background-color: ' . esc_attr($clr) . ';}

		';
		$custom_style = apply_filters('theme_skin_set_theme_color2', $custom_style, $clr);
	}

	// Theme color 2 from customizer
	$clr13 = '';
	if ($customizer)
		$clr13 = getValueGPC('theme_color3', '');
	if (empty($clr13))
		$clr13 = get_custom_option('theme_color3');
	if (!empty($clr13)) {
		$clr = $clr13;
		$rgb = hex2rgb($clr);
		$custom_style .= '

.theme_dark,
h2, h3, h4, h5, h6,
.h2, .h3, .h4, .h5, .h6,
h2 > a, h3 > a, h4 > a, h5 > a, h6 > a,
.h2 > a, .h3 > a, .h4 > a, .h5 > a, .h6 > a
{color: ' . esc_attr($clr) . ';}

.theme_dark_bgc
{background-color: ' . esc_attr($clr) . ';}

		';
		$custom_style = apply_filters('theme_skin_set_theme_color3', $custom_style, $clr);
	}

	addThemeCustomStyle(apply_filters('theme_skin_add_styles_inline', $custom_style));

	return getThemeCustomStyles();
};
?>