<?php
class feedcommander_free {
function sc_feedcommander_free(){
    include(ABSPATH.'wp-content/plugins/seo-automatic-seo-tools/feedcommander/'."config.php");

    // check for status of submit buttons	
	unset($preview);
    if (isset($_GET["preview"])) $preview = $_GET["preview"];
	unset($generate);
    if (isset($_GET["generate"])) $generate = $_GET["generate"];
	unset($generate_php);
    if (isset($_GET["generate_php"])) $generate_php = $_GET["generate_php"];
    unset($generate_asp);
    if (isset($_GET["generate_asp"])) $generate_asp = $_GET["generate_asp"];
    
    // GET VARIABLES ---------------------------------------------
    // Get variables from input form and set default values
    $src = ( isset($_GET["src"]) ? $_GET["src"] : "" );
    $title = ( isset($_GET["title"]) ? $_GET["title"] : "y" );
    $lines = ( isset($_GET["lines"]) ? $_GET["lines"] : "0" );
    
    $is_gen = ((isset($_GET["generate"]) || isset($_GET["generate_php"]) || isset($_GET["generate_asp"]) || isset($_GET["preview"])) ? true : false ); 
    
    // Box Properties
    $b_width = ( isset($_GET["b_width"]) ? $_GET["b_width"] : 0 );
    $b_height = ( isset($_GET["b_height"]) ? $_GET["b_height"] : 00 );
    $h_bar = ( isset($_GET["h_bar"]) ? $_GET["h_bar"] : "n" );
    $v_bar = ( isset($_GET["v_bar"]) ? $_GET["v_bar"] : "n" );
    $mq = ( isset($_GET["mq"]) ? $_GET["mq"] : "n" );
    $mq_di = ( isset($_GET["mq_di"]) ? $_GET["mq_di"] : "DOWN" );
    $mq_n = ( isset($_GET["mq_n"]) ? $_GET["mq_n"] : "3" );
    $mq_dy = ( isset($_GET["mq_dy"]) ? $_GET["mq_dy"] : "200" );
    $rb_color = ( isset($_GET["rb_color"]) ? $_GET["rb_color"] : "s");
    $b_color = ( isset($_GET["b_color"]) ? $_GET["b_color"] : "ffffff");
    $b_color_o = ( isset($_GET["b_color_o"]) ? $_GET["b_color_o"] : "");
    $b_style = ( isset($_GET["b_style"]) ? $_GET["b_style"] : "none");
    $rb_b_color = ( isset($_GET["rb_b_color"]) ? $_GET["rb_b_color"] : "s");
    $b_b_color = ( isset($_GET["b_b_color"]) ? $_GET["b_b_color"] : "ffffff");
    $b_b_color_o = ( isset($_GET["b_b_color_o"]) ? $_GET["b_b_color_o"] : "");
    $rb_b_weight = ( isset($_GET["rb_b_weight"]) ? $_GET["rb_b_weight"] : "s");
    $b_b_weight = ( isset($_GET["b_b_weight"]) ? $_GET["b_b_weight"] : "ffffff");
    $b_b_weight_o = ( isset($_GET["b_b_weight_o"]) ? $_GET["b_b_weight_o"] : "");
    $boxpadding = (( is_numeric($boxpadding) && ($boxpadding != 0) ) ? $boxpadding : 10);
    $mq_height = $_GET["mq_height"];

    // Title Properties
    $t_font = ( isset($_GET["t_font"]) ? $_GET["t_font"] : "Arial");
    $t_s_bold = ( isset($_GET["t_s_bold"]) ? $_GET["t_s_bold"] : ($is_gen ? "n" : "y"));
    $t_s_italic = ( isset($_GET["t_s_italic"]) ? $_GET["t_s_italic"] : "n");
    $t_s_underline = ( isset($_GET["t_s_underline"]) ? $_GET["t_s_underline"] : ($is_gen ? "n" : "y"));
    $t_s_marquee = ( isset($_GET["t_s_marquee"]) ? $_GET["t_s_marquee"] : "n"); 
    $t_size = ( isset($_GET["t_size"]) ? $_GET["t_size"] : "16");
    $t_align = ( isset($_GET["t_align"]) ? $_GET["t_align"] : "center");
    $rt_color = (isset($_GET["rt_color"]) ? $_GET["rt_color"] : "s");
    $t_color = ( isset($_GET["t_color"]) ? $_GET["t_color"] : "4444aa");
    $t_color_o = (isset($_GET["t_color_o"]) ? $_GET["t_color_o"] : "");
    
    // Item Properties
    $i_max_char = ( isset($_GET["i_max_char"]) ? $_GET["i_max_char"] : 0);
    $i_font = ( isset($_GET["i_font"]) ? $_GET["i_font"] : "Arial");
    $i_s_bold = ( isset($_GET["i_s_bold"]) ? $_GET["i_s_bold"] : ($is_gen ? "n" : "y"));
    $i_s_italic = ( isset($_GET["i_s_italic"]) ? $_GET["i_s_italic"] : "n");
    $i_s_underline = ( isset($_GET["i_s_underline"]) ? $_GET["i_s_underline"] : ($is_gen ? "n" : "y"));
    $i_s_marquee = ( isset($_GET["i_s_marquee"]) ? $_GET["i_s_marquee"] : "n"); 
    $i_size = ( isset($_GET["i_size"]) ? $_GET["i_size"] : "12");
    $ri_color = (isset($_GET["ri_color"]) ? $_GET["ri_color"] : "s");
    $i_color = ( isset($_GET["i_color"]) ? $_GET["i_color"] : "4444aa");
    $i_color_o = (isset($_GET["i_color_o"]) ? $_GET["i_color_o"] : "");
    
    // Content Properties
    $c_max_char = ( isset($_GET["c_max_char"]) ? $_GET["c_max_char"] : 0);
    $c_font = ( isset($_GET["c_font"]) ? $_GET["c_font"] : "Arial");
    $c_s_bold = ( isset($_GET["c_s_bold"]) ? $_GET["c_s_bold"] : "n");
    $c_s_italic = ( isset($_GET["c_s_italic"]) ? $_GET["c_s_italic"] : "n");
    $c_s_underline = ( isset($_GET["c_s_underline"]) ? $_GET["c_sunderline"] : "n");
    $c_s_marquee = ( isset($_GET["c_s_marquee"]) ? $_GET["c_s_marquee"] : "n"); 
    $c_size = ( isset($_GET["c_size"]) ? $_GET["c_size"] : "10");
    $c_align = ( isset($_GET["c_align"]) ? $_GET["c_align"] : "justify");
    $rc_color = (isset($_GET["rc_color"]) ? $_GET["rc_color"] : "s");
    $c_color = ( isset($_GET["c_color"]) ? $_GET["c_color"] : "000000");
    $c_color_o = (isset($_GET["c_color_o"]) ? $_GET["c_color_o"] : "");    
    $lb = (isset($_GET["lb"]) ? $_GET["lb"] : "");    

    // HTML Option ....
    $option = "";
    $option .= "&title=" . $title . "&lines=" . $lines;
    $option .= "&boxpadding=" . (($boxpadding >= 0) ? $boxpadding : 0);
    $option .= "&b_width=" . (($b_width >= 0) ? $b_width : 0);
    $option .= "&b_height=" . (($b_height >= 0) ? $b_height : 0);
    $option .= "&h_bar=" . $h_bar . "&v_bar=" . $v_bar;
    $option .= "&mq=" . $mq . "&mq_di=" . $mq_di . "&mq_n=" . $mq_n . "&mq_dy=" . $mq_dy;
    $option .= "&b_color=";
    if ($rb_color == "s") $option .= $b_color;
    else $option .= $b_color_o;
    $option .= "&b_style=" . $b_style;
    $option .= "&b_b_color=";
    if ($rb_b_color == "s") $option .= $b_b_color;
    else $option .= $b_b_color_o;
    $option .= "&b_b_weight=";
    if ($rb_b_weight == "s") $option .= $b_b_weight;
    else $option .= $b_b_weight_o;
    $option .= "&t_font=" . $t_font . "&t_s_bold=" . $t_s_bold . "&t_s_italic=" . $t_s_italic . "&t_s_underline=" . $t_s_underline . "&t_s_marquee=" . $t_s_marquee . "&t_size=" . $t_size;
    $option .= "&t_align=" . $t_align . "&t_color=";
    if ($rt_color == "s") $option .= $t_color;
    else $option .= $t_color_o;
    $option .= "&i_max_char=" . $i_max_char . "&i_font=" . $i_font . "&i_s_bold=" . $i_s_bold . "&i_s_italic=" . $i_s_italic . "&i_s_underline=" . $i_s_underline . "&i_s_marquee=" . $i_s_marquee . "&i_size=" . $i_size;
    $option .= "&i_color=";
    if ($ri_color == "s") $option .= $i_color;
    else $option .= $i_color_o;    
    $option .= "&c_max_char=" . $c_max_char . "&c_font=" . $c_font . "&c_s_bold=" . $c_s_bold . "&c_s_italic=" . $c_s_italic . "&c_s_underline=" . $c_s_underline . "&c_s_marquee=" . $c_s_marquee . "&c_size=" . $c_size;
    $option .= "&c_align=" . $c_align . "&c_color=";
    if ($rc_color == "s") $option .= $c_color;
    else $option .= $c_color_o;
	$option .= '&nostyle='.$_GET["nostyle"];

	if ($_GET["nostyle"] == "y") {
		$item_style = "";
		$div_title_style = "";
		$content_style = "";
	}

    if ($is_gen) {
            // URLs for a preview or a generated feed link
            $rss_str = get_bloginfo('url')."/wp-content/plugins/seo-automatic-seo-tools/feedcommander/rssread.php?src=" . /*urlencode*/($src) . htmlentities($option) . (strlen($generate_php) > 0 ? htmlentities("&html=y") : "&html=n"); 
            $noscript_rss_str = $my_dir . "wp-content/plugins/seo-automatic-seo-tools/feedcommander/free/rssread.php?src=" . /*urlencode*/($src) . htmlentities($option . "&html=y");
    }
    include(ABSPATH.'wp-content/plugins/seo-automatic-seo-tools/feedcommander/'."template.php");
}}
?>