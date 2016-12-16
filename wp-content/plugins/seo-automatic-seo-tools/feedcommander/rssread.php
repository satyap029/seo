<?php
    require_once(dirname(__FILE__).'/config.php');

    // Utility to remove return characters from strings that might
    // pollute JavaScript commands. While we are at it, substitute 
    // valid single quotes as well and get rid of any escaped quote
    // characters
    function strip_returns ($text, $linefeed = " ") {
        $subquotes = ereg_replace("&apos;", "'", stripslashes($text));
        return ereg_replace("(\r\n|\n|\r)", $linefeed, $subquotes);
    }    
    // Error Checking for the Source
    $src = (isset($_GET["src"]) ? $_GET["src"] : "");
    
    // trap for missing src param for the feed, use a dummy one so it gets displayed.
    if ( empty($src) or strpos($src, "http://") != 0 ) 
        $src=  dirname(__FILE__).'/nosource.php';
    
    // default setting for no conversion of linebreaks
    $html = (isset($_GET["html"]) ? $_GET["html"] : "n");
    
    // flag to show feed as full html output rather than JavaScript, used for alternative
    // views for JavaScript-less users. 
    //     y = display html only for non js browsers
    //     n = default (JavaScript view)
    //     a = display javascript output but allow HTML 
    //     p  = display text only items but convert linefeeds to BR tags
    
    $br = ' ';
    if ($html == 'a') {
    	$desc = 1;
    } elseif ($html == 'p') {
    	$br = '<br />';
    }
        
    $title = (isset($_GET["title"]) ? $_GET["title"] : "y");
    $lines = (isset($_GET["lines"]) ? $_GET["lines"] : 0);
    if ($lines == 0)
        $lines = 100;
 
 
    // indicator to show item description,  0 = no; 1=all; n>1 = characters to display
    // values of -1 indicate to displa item without the title as a link
    // (default=0)
    $desc = 1;

    // flag to show date of posts, values: no/yes (default=no)
    $date = "n";

    // time zone offset for making local time, 
    // e.g. +7, =-10.5; 'feed' = print the time string in the RSS w/o conversion
    $tz = "feed";

    // optional parameter to use different class for the CSS container
    $play_podcast = "n";
        
    // Box Properties
    $b_width = ( isset($_GET["b_width"]) ? $_GET["b_width"] : 640 );
    $b_width = (( is_numeric($b_width) && ($b_width != 0) ) ? $b_width : "auto");
    $b_height = ( isset($_GET["b_height"]) ? $_GET["b_height"] : 480 );
    $b_height = (( is_numeric($b_height) && ($b_height != 0) ) ? $b_height : "auto");
    $h_bar = ( isset($_GET["h_bar"]) ? $_GET["h_bar"] : "y" );
    $v_bar = ( isset($_GET["v_bar"]) ? $_GET["v_bar"] : "y" );
    $mq = ( isset($_GET["mq"]) ? $_GET["mq"] : "n" );
    $mq_di = ( isset($_GET["mq_di"]) ? $_GET["mq_di"] : "DOWN" );
    $mq_n = ( isset($_GET["mq_n"]) ? $_GET["mq_n"] : "0" );
    $mq_dy = ( isset($_GET["mq_dy"]) ? $_GET["mq_dy"] : "1000" );
    $b_color = ( isset($_GET["b_color"]) ? $_GET["b_color"] : "ffffff");
    $b_style = ( isset($_GET["b_style"]) ? $_GET["b_style"] : "none");
    $b_b_color = ( isset($_GET["b_b_color"]) ? $_GET["b_b_color"] : "ffffff");
    $b_b_weight = ( isset($_GET["b_b_weight"]) ? $_GET["b_b_weight"] : "ffffff");
    $boxpadding = (( is_numeric($boxpadding) && ($boxpadding != 0) ) ? $boxpadding : 5);

    $box_style = "padding:" . $boxpadding . "px;";
    $box_style .= "width: " . $b_width . ";height: " . $b_height . ";";
    $box_style .= "overflow-x: " . (($h_bar == "y") ? "scroll" : "hidden") . ";overflow-y: " . (($v_bar == "y") ? "scroll" : "hidden") . ";";
    $box_style .= "background-color: #" . $b_color . ";";
    $box_style .= "border: " . $b_b_weight . (is_numeric($b_b_weight) ? "px" : "") . " " . $b_style . " #" . $b_b_color . ";";
    

    // Title Properties
    $t_font = ( isset($_GET["t_font"]) ? $_GET["t_font"] : "Arial");
    $t_s_bold = ( isset($_GET["t_s_bold"]) ? $_GET["t_s_bold"] : "y");
    $t_s_italic = ( isset($_GET["t_s_italic"]) ? $_GET["t_s_italic"] : "n");
    $t_s_underline = ( isset($_GET["t_s_underline"]) ? $_GET["t_s_underline"] : "y");
    $t_s_marquee = ( isset($_GET["t_s_marquee"]) ? $_GET["t_s_marquee"] : "n"); 
    $t_size = ( isset($_GET["t_size"]) ? $_GET["t_size"] : "12");
    $t_align = ( isset($_GET["t_align"]) ? $_GET["t_align"] : "center");
    $t_color = ( isset($_GET["t_color"]) ? $_GET["t_color"] : "4444aa");
    
    $title_style = "font: " . (($t_s_bold == "y" ) ? "bold " : "" ) . (($t_s_italic == "y") ? "italic " : "") . $t_size . "px " . $t_font . ";";
    $title_style .= "text-decoration: " . (($t_s_underline == "y") ? "underline" : "none") . ";color: #" . $t_color . ";";
    $div_title_style = $title_style . "text-align: " . $t_align . ";";
    
    // Item Properties
    $i_max_char = ( isset($_GET["i_max_char"]) ? $_GET["i_max_char"] : 0);
    $i_font = ( isset($_GET["i_font"]) ? $_GET["i_font"] : "");
    $i_s_bold = ( isset($_GET["i_s_bold"]) ? $_GET["i_s_bold"] : "");
    $i_s_italic = ( isset($_GET["i_s_italic"]) ? $_GET["i_s_italic"] : "");
    $i_s_underline = ( isset($_GET["i_s_underline"]) ? $_GET["i_s_underline"] : "");
    $i_s_marquee = ( isset($_GET["i_s_marquee"]) ? $_GET["i_s_marquee"] : ""); 
    $i_size = ( isset($_GET["i_size"]) ? $_GET["i_size"] : "");
    $i_align = ( isset($_GET["i_align"]) ? $_GET["i_align"] : "");
    $i_color = ( isset($_GET["i_color"]) ? $_GET["i_color"] : "");
    
    $item_style = "font: " . (($i_s_bold == "y" ) ? "bold " : "" ) . (($i_s_italic == "y") ? "italic " : "") . $i_size . "px " . $i_font . ";";
    $item_style .= "text-decoration: " . (($i_s_underline == "y") ? "underline" : "none") . ";color: #" . $i_color . ";";
    // Content Properties
    $c_max_char = ( isset($_GET["c_max_char"]) ? $_GET["c_max_char"] : 0);
    $c_font = ( isset($_GET["c_font"]) ? $_GET["c_font"] : "Arial");
    $c_s_bold = ( isset($_GET["c_s_bold"]) ? $_GET["c_s_bold"] : "y");
    $c_s_italic = ( isset($_GET["c_s_italic"]) ? $_GET["c_s_italic"] : "n");
    $c_s_underline = ( isset($_GET["c_s_underline"]) ? $_GET["c_s_underline"] : "y");
    $c_s_marquee = ( isset($_GET["c_s_marquee"]) ? $_GET["c_s_marquee"] : "n"); 
    $c_size = ( isset($_GET["c_size"]) ? $_GET["c_size"] : "12");
    $c_align = ( isset($_GET["c_align"]) ? $_GET["c_align"] : "center");
    $c_color = ( isset($_GET["c_color"]) ? $_GET["c_color"] : "4444aa");
    $bt = ( isset($_GET["bt"]) ? $_GET["bt"] : ""); 

    $content_style = "font: " . (($c_s_bold == "y" ) ? "bold " : "" ) . (($c_s_italic == "y") ? "italic " : "") . $c_size . "px " . $c_font . ";";
    $content_style .= "text-decoration: " . (($c_s_underline == "y") ? "underline" : "none") . ";color: #" . $c_color . ";";
    $content_style .= "text-align: " . $c_align . ";";

	if ($_GET["nostyle"] == "y") {
		$item_style = "";
		$div_title_style = "";
		$content_style = "";
	}
   
    $rss = @feedcommander_fetch_rss( $src );
	if ($bt == "y") {
		$blank_target = " ";
	} else {
		$blank_target = " target=\"_blank\"";
	}
    // begin javascript output string for channel info
    $str = "document.write('<div style=\"" . $box_style . "\">');\n";
    if ($mq=='y') $str .= "document.write('<marquee style=\"" . "\" DIRECTION=\"" . $mq_di . "\" BEHAVIOR=SCROLL SCROLLAMOUNT=\"" . $mq_n . "\" SCROLLDELAY=\"" . $mq_dy . "\">');\n";
    
    if  (!$rss) {
        $str .= "document.write('<p class=\"rss-item\"><em>Error:</em> Feed failed! Causes may be (1) No data  found for RSS feed $src; (2) There are no items are available for this feed; (3) The RSS feed does not validate.<br /><br /> Please verify that the URL <a".$blank_target."  href=\"$src\">$src</a> works first in your browser and that the feed passes a <a".$blank_target."  href=\"http://feedvalidator.org/check.cgi?url=" . urlencode($src) . "\">validator test</a>.</p></div>');\n";
    } else {   
        if ($title == "y") {
            $t_btag_marquee = ""; $t_etag_marquee = "";
            if ($t_s_marquee == "y") {
                $t_btag_marquee = "<marquee>";
                $t_etag_marquee = "</marquee>";
            }
      
            $str .= "document.write('<h3 class=\"rss-title\" style=\"" . $div_title_style . "\">" . $t_btag_marquee . "<a".$blank_target."  class=\"rss-title\" style=\"" . $title_style . "\" href=\"" . trim($rss->channel['link']) . "\">" . addslashes(strip_returns($rss->channel['title'])) . "</a>" . $t_etag_marquee . "</h3>');\n";            
        }
        // begin item listing
        //$str .= "document.write('<p class=\"rss-items\">');\n";
        
        // Walk the items and process each one
        $all_items = array_slice($rss->items, 0, $lines);
        
        foreach ( $all_items as $item ) {
            // set defaults thanks RPFK
            if (!isset($item['summary'])) $item['summary'] = ''; 
            $more_link = '';
            
            if ($item['link']) {
                // link url
                $my_url = addslashes($item['link']);
            } elseif  ($item['guid']) {
                //  feeds lacking item -> link
                $my_url = ($item['guid']);
            }
            
            if ($item['title']) {
                // format item title
                $my_title = addslashes(strip_returns($item['title']));
                           
                if ($i_max_char != 0) {
                    $cnt_i = strlen($my_title);
                    $my_title = substr($my_title, 0, $i_max_char);
                    if ($i_max_char < $cnt_i)
                        $my_title .= "...";
                } 
                
				$my_title = htmlentities($my_title);

				 $my_title = str_replace('?','-',$my_title);
				 if ($my_title[strlen($my_title)-1] == '-') {
					 $my_title = substr($my_title,0,-1).'?'; 
				 } 
                $my_title = str_replace('-t',"'t",$my_title);
				$my_title = str_replace('-s',"'s",$my_title);
				$my_title = str_replace('- - '," - ",$my_title);

                $i_btag_marquee = ""; $i_etag_marquee = "";
                if ($i_s_marquee == "y") {
                    $i_btag_marquee = "<marquee>";
                    $i_etag_marquee = "</marquee>";
                }
                            
                // create a title attribute. thanks Seb!
                $title_str = substr(addslashes(strip_returns(strip_tags(($item['summary'])))), 0, 255) . '...'; 

                // write the title strng
                $str .= "document.write('<p class=\"rss-item-title\" style=\"" . $content_style . "\" >" . $i_btag_marquee . "<a".$blank_target."  class=\"rss-item\" style=\"" . $item_style . "\" href=\"" . trim($my_url) . "\">" . $my_title . "</a>" . $i_etag_marquee . "</p>');\n";

            } else {
                // if no title, build a link to tag on the description
                $str.= "document.write('<p class=\"rss-item-excerpt\" style=\"" . $content_style . "\">');\n";
                $more_link = " 
<a".$blank_target."  class=\"rss-item\" style=\"" . $item_style     . "\" href=\"" . trim($my_url) . "\">&laquo;details&raquo;</a></p>";
            }
        
            // print out date if option indicated

            if ($date == 'y') {
                        
                if ($tz == 'feed') {
                //   echo the date/time stamp reported in the feed

                    if ($item['pubdate'] != '') {
                        // RSS 2.0 is alreayd formatted, so just use it
                        $pretty_date = 'published on ' . $item['pubdate'];
                    } elseif ($item['published'] != "") {
                        // ATOM 1.0 format, remove the "T" and "Z" and the time zone offset
                        $pretty_date = str_replace("T", " ", $item['created']);
                        $pretty_date= 'published on ' . str_replace("Z", " ", $pretty_date);
        
                    } elseif ($item['issued'] != "") {
                        // ATOM 0.3 format, remove the "T" and "Z" and the time zone offset
                        $pretty_date = str_replace("T", " ", $item['issued']);
                        $pretty_date= 'published on ' . str_replace("Z", " ", $pretty_date);
                    } elseif ( $item['dc']['date'] != "") {
                        // RSS 1.0, remove the "T" and the time zone offset
                        $pretty_date = str_replace("T", " ", $item['dc']['date']);
                        $pretty_date = 'published on ' . substr($pretty_date, 0,-6);
                    } else {
                    
                        // no time/date stamp, just use the server time
                        $pretty_date =  'published date n/a';
                    }

                } else {
                    // convert to local time via conversion to GMT + offset
                    
                    // adjust local server time to GMT and then adjust time according to user
                    // entered offset.
                    
                    $pretty_date = 'published on ' . date($date_format, $item['date_timestamp'] - $tz_offset + $tz * 3600);
                
                }
        
                $str.= "document.write('<span class=\"rss-date\">$pretty_date</span><br />');\n"; 
            }

            // link to podcast media if availavle
            
            if ($play_podcast == 'y' and is_array($item['enclosure'])) {
                $str.= "document.write('<div class=\"pod-play-box\">');\n";
                for ($i = 0; $i < count($item['enclosure']); $i++) {
                
                    // display only if enclosure is a valid URL
                    //if (strpos($item['enclosure'][$i]['url'], 'http://')!=0) {
                        $str.= "document.write('<a".$blank_target."  class=\"pod-play\" href=\"" . trim($item['enclosure'][$i]['url']) . "\" title=\"Play Now\" target=\"_blank\"><em>Play</em> <span> " .  substr(trim($item['enclosure'][$i]['url']), -3)  . "</span></a> ');\n";
                    //}
                }
                $str.= "document.write('</div>');\n";
            }

        
		// output description of item if desired
		if ($desc) {
		 // Atom/encocded content support (thanks David Carter-Tod)
			if (!empty($item['content']['encoded'])) {
				$my_blurb = html_entity_decode ( $item['content']['encoded'], ENT_NOQUOTES);
				
	
			} else {   
				$my_blurb = $item['summary'];
			}

			// strip html
			if ($html != 'a') $my_blurb = strip_tags($my_blurb);
			
			// trim descriptions
			if ($desc > 1) {		
				// display specified substring numbers of chars;
				//   html is stripped to prevent cut off tags
				$my_blurb = substr($my_blurb, 0, $desc) . '...';
			}
            
            if ($c_max_char != 0) {
                $cnt_c = strlen($my_blurb);
                $my_blurb = substr($my_blurb, 0, $c_max_char);
                if ($c_max_char < $cnt_c)
                    $my_blurb .= "...";
				$my_blurb = '<p class="rss-content">'.$my_blurb."</p>";
            } 
			if ($c_max_char == 'none') {
				$my_blurb = '';
			}
                
            if ($c_s_marquee == "y")
                $my_blurb = "<marquee>" . $my_blurb . "</marquee>";
            
			
			$str.= "document.write('" . $my_blurb . "');\n"; 
			
		}             
             
            $str.= "document.write('$more_link');\n";	
        }


        $str .= "document.write('');\n";        
    }
    // javascript for linkback
    //if ($lb == "2") {
		require_once('../../../../wp-config.php');
		mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error('Database is unable to connect.'));
		mysql_select_db(DB_NAME) or die(mysql_error('Database is unable to connect.'));
		$table = $table_prefix.'options';
		$linkon = mysql_query("SELECT * FROM $table WHERE option_name = 'seo_tools_linkback_on'") 
		or die(mysql_error()); 
//		while($row = mysql_fetch_array($linkon)) {
//			$linkon = $row['option_value'];
//		} 
		$linkurl = mysql_query("SELECT * FROM $table WHERE option_name = 'seo_tools_linkback_url'") 
		or die(mysql_error());  
//		while($row = mysql_fetch_array($linkurl)) {
//			$linkurl = $row['option_value'];
//		} 
		$linktxt = mysql_query("SELECT * FROM $table WHERE option_name = 'seo_tools_linkback_text'") 
		or die(mysql_error());  
//		while($row = mysql_fetch_array($linktxt)) {
//			$linktxt = $row['option_value'];
//			echo '<br />continued... '.$linktxt.'<br />';
			if ($linktxt != 'change this anchor text in the SEO Tools admin' && $linktxt != 'add RSS feeds to any website') {
			} else {
				$linktxt = 'change this anchor text in the SEO Tools admin';
				$linkurl = get_bloginfo('wpurl').'/wp-admin/admin.php?page=seo-automatic-seo-tools-pro/settings.php';
			}
//		} 
	if ($linkon == 'on') {
        $str .= "document.write('<div class=\"rss-link-back\" style=\"font: 10px Arial; text-align:right;\">');\n";
            $str .= "document.write('<a".$blank_target."  href=\"" . $linkurl . "\">" . $linktxt . "</a>&nbsp;');\n";
        $str .= "document.write('</div>');\n";
    }
    
    if ($t_s_marquee == "y") $str .= "document.write('</marquee>');\n";
    $str .= "document.write('</div>');\n";

    if ( $_GET['html'] != "n" ) {
        $str = preg_replace("/document.write\(\'/", "", $str);
        $str = preg_replace("/\'\)\;/", "", $str);
        $str = stripslashes($str);    
    
    	// Now write a basic page with the feed as content
    	/*
		echo "<html><head><title>RSS Feed: " . $rss->channel['title'] . "</title></head>";
    	echo '<body bgcolor="#FFFFFF"><div id="content">';
    	echo '<h1>RSS Feed for ' . $rss->channel['title'] . '</h1><p>Note: Content for this RSS feed is provided as a text alternative to inline RSS feeds that may not display on all browsers.</p>';
			*/
		echo "$str"; //</div></body></html>";  
    } else {
        if (!empty($rss)) {
            header("Content-type: application/x-javascript");
        }

$str = str_replace(chr(10), " ", $str); //remove carriage returns
$str = str_replace(chr(13), " ", $str); //remove carriage returns 
$str = str_replace('<br /> document.write', "document.write('<br />'); document.write", $str); //remove carriage returns 
$str = str_replace('<br> document.write', "document.write('<br />'); document.write", $str); //remove carriage returns 
$str = str_replace("'t","\'t",$str);
$str = str_replace("'s","\'s",$str);
$str = str_replace("'l","\'l",$str);
$str = str_replace("'r","\'r",$str);
$str = str_replace("'n","\'n",$str);

echo $str;    
    }

?>