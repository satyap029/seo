<script language="javascript"> 
function cssoptions(id) { // This gets executed when the user clicks on the checkbox
var obj = document.getElementById(id);
if (obj.style.display=="none") { // if it is checked, make it visible, if not, hide it
	obj.style.display = "inline";
} else {
	obj.style.display = "none";
}
}
function allbs(id){
var row = document.getElementById(id);
if (row.style.display == '') row.style.display = 'none';
else row.style.display = '';
}
//-->
</script>

<div align="center"><table width="400"><tr><td valign="top">
<?php
    if (isset($preview)) {
   	$previewurl=get_bloginfo('url')."/wp-content/plugins/seo-automatic-seo-tools/feedcommander/rssread.php?src=". /*urlencode*/($src) . ($option) . "&html=y"; 
        $ch = curl_init($previewurl);
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch);      
        curl_close($ch); 
        echo $output;
	}
?>
	

        
<?php if ($generate):?>
        <h2><font size="2">Get Your Code Here</font></h2>
        <p class="first">Below is the code you need to copy and paste to your own web page to include this RSS feed. The NOSCRIPT tag provides a link to a HTML display of the feed for users who may not have JavaScript enabled. </p>
        <span class="caption">cut and paste javascript:</span>
        <br />
        <textarea name="t" rows="8" cols="52">
&lt;script language="JavaScript" src="<?php echo htmlentities($rss_str)?>" type="text/javascript"&gt;&lt;/script&gt;

&lt;noscript&gt;
&lt;a href="<?php echo htmlentities($noscript_rss_str)?>"&gt;View RSS feed&lt;/a&gt;
&lt;/noscript&gt;
        </textarea>
<?php endif;?>

<?php if ($generate_php): ?>
        <h2><font size="2">Get Your Code Here</font></h2>
        <p class="first">Below is the code you need to copy and paste to your PHP source code to include this RSS feed.</p>
        <span class="caption">cut and paste php script:</span>
        <br />
        <textarea name="t" rows="8" cols="52">
&lt;?php
	$url="<?php echo($rss_str);?>";
	$ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $results=curl_exec($ch);
        curl_close($ch);
	print("$results");
?&gt;
        </textarea>
<?php endif;?>


<?php if ($generate_asp): ?>
<?php 
	$aspEncode = "feedcommander" . date('mdyhis') . ".sdh";
	$aspName = get_bloginfo('url')."/wp-content/plugins/seo-automatic-seo-tools/feedcommander/asp.php?file=" . $aspEncode . "&src=" . /*urlencode*/($src) . ($option) . "&lb=" . $lb . "&linkback1=" . $linkback[0] . "&linkback2=" . $linkback[1] . "&html=y";
?>
<form method="POST" action="<?php echo get_bloginfo('url').'/wp-content/plugins/seo-automatic-seo-tools/feedcommander/user/'.$aspEncode;?>" name="asp">
First you will need to download the ASP file.<br />
Save it to the folder on your server where you wish to display the RSS Feed.<br />
Then copy and paste the code below into the pages in the area the feed is to display.
<textarea name="t" rows="3" cols="57">&lt;!--#include file="<?php echo($aspEncode);?>"--&gt;</textarea>
<input type="submit" name="getASP" value="Download ASP File" />
</form>       
<?php endif;?>
        <form method="get" action=""  name="wizard">
        <p>
            <strong>URL</strong> Enter the web address of the RSS Feed<br />
            <input type="text" name="src" size="49" value="<?php echo $src;?>" />&nbsp;<input type="submit" name="preview" value="Preview!" /><br />
            
            <p>
                <strong>Number of item(s) to display.</strong> <br />
                <input type="text" name="lines" size="10" value="<?php echo $lines; ?>" /> item(s)<br />
                Enter the number of item(s) to be displayed (enter 0 to show all available)</p>

<p><b><input type="checkbox" name="nostyle" id="nostyle" value="y" <?php if ($_GET["nostyle"] == "y") echo "checked";?> onclick="javascript:cssoptions('hidecssone');allbs('b1');allbs('b2');allbs('b3');allbs('b4');allbs('b5');allbs('b6');allbs('b7');allbs('b8');allbs('b9');allbs('b10');allbs('b11');allbs('b12');allbs('b13');allbs('b14');allbs('b15');allbs('b16');allbs('b17');allbs('b18');allbs('b19');allbs('b20');allbs('b21');allbs('b22');allbs('b23');allbs('b24');allbs('b25');allbs('b26');" /><label for="nostyle">Use my own stylesheet.</label></b></p>
            <!--p>
                <strong>Specify the RSS Feed.</strong> <br />
                <input type="radio" name="rss" value="2" id="rss_2" <?php if ($rss == "2") echo "checked"; ?> /><label for="rss_2"> RSS 2.0 </label><input type="radio" name="rss" id="rss_1" value="1" <?php if ($rss == "1") echo "checked"; ?> /><label for="rss_1"> RSS 1.0</label>
            </p-->
 
<div id="hidecssone">
                    <fieldset>
                    <legend><strong>Display Box&nbsp;Properties</strong></legend>
                  
                    <table width="428" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
                        
				<tr>
                            <td width="113" align="left">Width</td>
                            <td width="441" align="left"><input type="text" name="b_width" size="5" value="<?php echo $b_width;?>" />&nbsp;<strong>0</strong>&nbsp;means&nbsp;Auto</td>
                        </tr>
                        <tr>
                            <td width="113" align="left">Height</td>
                            <td width="441" align="left"><input type="text" name="b_height" size="5" value="<?php echo $b_height;?>" />&nbsp;<strong>0</strong>&nbsp;means&nbsp;Auto</td>
                        </tr>
				<tr>
                            <td width="113" align="left">Padding</td>
                            <td width="441" align="left"><input type="text" name="boxpadding" size="5" value="<?php echo $boxpadding;?>" /></td>
                        </tr>                           
                        <tr>
                            <td rowspan="2" width="113" align="left">Background<br />
                            Color</td>
                            <td width="441" align="left">
                                <input type="radio" name="rb_color" value="s" <?php if ($rb_color == "s") echo "checked"; ?> />
                                <select name="b_color">
                                    <?php foreach($fix_color as $color) { ?>
                                    <option value="<?php echo($color[1]);?>" <?php if ($b_color == $color[1]) echo "selected";?> ><?php echo($color[0]);?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>             
                        <tr>
                            <td width="441" align="left">
                                <input type="radio" name="rb_color" value="o" id="rb_color_o" <?php if ($rb_color == "o") echo "checked"; ?> />
                                <label for="rb_color_o">Other&nbsp;</label><input type="text" name="b_color_o" size="7" value="<?php echo($b_color_o); ?>" />&nbsp;Exp.&nbsp;63aa7f
                            </td>
                        </tr>
                        <tr>
                            <td width="113" align="left">Border<br />
                            Type</td>
                            <td width="441" align="left">
                                <select name="b_style">
                                    <?php foreach($fix_border as $border) { ?>
                                    <option value="<?php echo($border);?>" <?php if ($b_style == $border) echo "selected"; ?> ><?php echo($border);?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" width="113" align="left">Border<br />
                            Color</td>
                            <td width="441" align="left">
                                <input type="radio" name="rb_b_color" value="s" <?php if ($rb_b_color == "s") echo "checked"; ?> />
                                <select name="b_b_color">
                                    <?php foreach($fix_color as $color) { ?>
                                    <option value="<?php echo($color[1]);?>" <?php if ($b_b_color == $color[1]) echo "selected";?> ><?php echo($color[0]);?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>             
                        <tr>
                            <td width="441" align="left">
                                <input type="radio" name="rb_b_color" value="o" id="rb_b_color_o" <?php if ($rb_b_color == "o") echo "checked"; ?> />
                                <label for="rb_b_color_o">Other&nbsp;</label><input type="text" name="b_b_color_o" size="7" value="<?php echo($b_b_color_o); ?>" />&nbsp;Exp.&nbsp;63aa7f
                            </td>
                        </tr>                        
                        <tr>
                            <td rowspan="2" width="113" align="left">Border<br />
                            Weight</td>
                            <td width="441" align="left">
                                <input type="radio" name="rb_b_weight" value="s" <?php if ($rb_b_weight == "s") echo "checked"; ?> />
                                <select name="b_b_weight">
                                    <?php foreach($fix_weight as $weight) { ?>
                                    <option value="<?php echo($weight);?>" <?php if ($b_b_weight == $weight) echo "selected";?> ><?php echo($weight);?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>             
                        <tr>
                            <td width="441" align="left">
                                <input type="radio" name="rb_b_weight" value="o" id="rb_b_weight_o" <?php if ($rb_b_weight == "o") echo "checked"; ?> />
                                <label for="rb_b_weight_o">Length&nbsp;</label><input type="text" name="b_b_weight_o" size="4" value="<?php echo($b_b_weight_o); ?>" />&nbsp;px
                            </td>
                        </tr>                              
                        <tr>
                            <td rowspan="5" width="113" align="left" valign="top">
                            <br />
                            Marquee</td>
                            <td width="441" align="left" valign="top">
                                <input type="checkbox" name="mq" id="mq" value="y" <?php if ($mq == "y") echo "checked"; ?> /><label for="mq">&nbsp;Use Marquee / Content rolls</label>
                                <br />
                                Select this box to scroll the entire table.<br />
                                Select 
                                the marquee checkboxes in the property boxes 
                                below for individual marquees.</td>
                        </tr></table></fieldset>
                        <p></p>
                        <fieldset><legend><strong>Marquee Settings</strong></legend>
                        <table width="429">
                        <tr>
                            <td width="423" align="left">
                                Height = <input type="text" name="mq_height" size="5" value="<?php echo $mq_height;?>" />&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td width="423" align="left">Direction = 
                                <select name="mq_di">
                                    <option value="LEFT" <?php if ($mq_di == "LEFT") echo "selected";?> >LEFT</option>
                                    <option value="RIGHT" <?php if ($mq_di == "RIGHT") echo "selected";?> >RIGHT</option>
                                    <option value="UP" <?php if ($mq_di == "TOP") echo "selected";?> >UP</option>
                                    <option value="DOWN" <?php if ($mq_di == "DOWN") echo "selected";?> >DOWN</option>
                                </select>
                            </td>
                        </tr>                    
                        <tr>
                            <td width="423" align="left">Scroll Amount = <input type="text" name="mq_n" size="5" value="<?php echo $mq_n;?>" />&nbsp;pixel(s)</td>
                        </tr>                    
                        <tr>
                            <td width="423" align="left">Scroll Delay = <input type="text" name="mq_dy" size="5" value="<?php echo $mq_dy;?>" />&nbsp;millisecond(s)</td>
                        </tr>                    
                    </table></fieldset>
                    
                    
                
            </p>
 </div>
 
                    <fieldset>
                    <legend><strong>Blog Title&nbsp;Properties</strong></legend>
                    
                    <table width="428" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
                        <tr><td colspan="2" height="60">
                        <p>
                <strong>Display Blog Title ?</strong> (yes/no) Display information about the publisher of the feed (yes=show the title; no=do not display anything) <br />
                <input type="radio" name="title" id="title_y" value="y" <?php if ($title == "y") echo "checked"; ?> /><label for="title_y"> yes </label><input type="radio" name="title" id="title_n" value="n" <?php if ($title == "n") echo "checked"; ?> /><label for="title_n"> no</label>
            			</p>
            			</td></tr>
						<tr id="b1">
                            <td width="64" align="left" height="22">Font&nbsp;</td>
                            <td width="400" align="left" height="22">
                                <select name="t_font">
                                    <?php foreach($fix_font as $font) { ?>
                                    <option value="<?php echo($font);?>" <?php if ($t_font == $font) echo "selected";?>><?php echo($font);?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr id="b2">
                            <td rowspan="2" width="64" align="left" height="44">Color&nbsp;</td>
                            <td width="400" align="left" height="22">
                                <input type="radio" name="rt_color" value="s" <?php if ($rt_color == "s") echo "checked"; ?> />
                                <select name="t_color">
                                    <?php foreach($fix_color as $color) { ?>
                                    <option value="<?php echo($color[1]);?>" <?php if ($t_color == $color[1]) echo "selected";?> ><?php echo($color[0]);?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>                        
                        <tr id="b3">
                            <td width="400" align="left" height="22">
                                <input type="radio" name="rt_color" value="o" id="rt_color_o" <?php if ($rt_color == "o") echo "checked"; ?> />
                                <label for="rt_color_o">Other&nbsp;</label><input type="text" name="t_color_o" size="7" value="<?php echo($t_color_o); ?>" />&nbsp;Exp.&nbsp;63aa7f
                            </td>
                        </tr>                        
                        <tr id="b4">
                            <td rowspan="4" width="64" align="left" height="80">Style&nbsp;</td>
                            <td width="400" align="left" height="20"><input type="checkbox" name="t_s_bold" id="t_s_bold" value="y" <?php if ($t_s_bold == "y") echo "checked";?> /><label for="t_s_bold"><strong>Bold</strong></label></td>
                        </tr>
                        <tr id="b5">
                            <td width="400" align="left" height="20"><input type="checkbox" name="t_s_italic" id="t_s_italic" value="y" <?php if ($t_s_italic == "y") echo "checked";?> /><label for="t_s_italic"><i>Italic</i></label></td>
                        </tr>
                        <tr id="b6">
                            <td width="400" align="left" height="20"><input type="checkbox" name="t_s_underline" id="t_s_underline" value="y" <?php if ($t_s_underline == "y") echo "checked";?> /><label for="t_s_underline"><u>Underline</u></label></td>
                        </tr>
                        <tr id="b7">
                            <td width="400" align="left" height="20"><input type="checkbox" name="t_s_marquee" id="t_s_marquee" value="y" <?php if ($t_s_marquee == "y") echo "checked";?> /><label for="t_s_marquee">Marquee</label></td>
                        </tr>                        
                        <tr id="b8">
                            <td width="64" align="left" height="22">Size&nbsp;</td>
                            <td width="400" align="left" height="22"><input type="text" name="t_size" size="4" value="<?php echo($t_size); ?>" />&nbsp;pt</td>
                        </tr>
                        <tr id="b9">
                            <td width="64" align="left" height="22">Alignment&nbsp;</td>
                            <td width="400" align="left" height="22">
                                <select name="t_align">
                                    <?php foreach($fix_align as $align) {?>
                                    <option value="<?php echo($align);?>" <?php if ($align == $t_align) echo "selected"; ?>><?php echo($align); ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    </fieldset>
               
            </p>
                         
                    <fieldset>
                    <legend><strong>News Item&nbsp;Title Properties</strong></legend>
                   
                    <table style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="0" width="428">
                        <tr>
                            <td width="66" align="left">Max&nbsp;Char&nbsp;</td>
                            <td width="243" align="left">
                                <input type="text" name="i_max_char" size="7" value="<?php echo($i_max_char); ?>" />&nbsp;<strong>0</strong>&nbsp;means
                                show&nbsp;all&nbsp;character
                            </td>
                        </tr>
                        <tr id="b10">
                            <td width="66" align="left">Font&nbsp;</td>
                            <td width="243" align="left">
                                <select name="i_font">
                                    <?php foreach($fix_font as $font) { ?>
                                    <option value="<?php echo($font);?>" <?php if ($i_font == $font) echo "selected";?>><?php echo($font);?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr id="b11">
                            <td rowspan="2" width="66" align="left">Color&nbsp;</td>
                            <td width="243" align="left">
                                <input type="radio" name="ri_color" value="s" <?php if ($ri_color == "s") echo "checked"; ?> />
                                <select name="i_color">
                                    <?php foreach($fix_color as $color) { ?>
                                    <option value="<?php echo($color[1]);?>" <?php if ($i_color == $color[1]) echo "selected";?> ><?php echo($color[0]);?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>                        
                        <tr id="b12">
                            <td width="243" align="left">
                                <input type="radio" name="ri_color" value="o" id="ri_color_o" <?php if ($ri_color == "o") echo "checked"; ?> />
                                <label for="ri_color_o">Other&nbsp;<br />
                                </label><input type="text" name="i_color_o" size="7" value="<?php echo($i_color_o); ?>" />&nbsp;Exp.&nbsp;63aa7f
                            </td>
                        </tr>                        
                        <tr id="b13">
                            <td rowspan="4" width="66" align="left">Style&nbsp;</td>
                            <td width="243" align="left"><input type="checkbox" name="i_s_bold" id="i_s_bold" value="y" <?php if ($i_s_bold == "y") echo "checked";?> /><label for="i_s_bold"><strong>Bold</strong></label></td>
                        </tr>
                        <tr id="b14">
                            <td width="243" align="left"><input type="checkbox" name="i_s_italic" id="i_s_italic" value="y" <?php if ($i_s_italic == "y") echo "checked";?> /><label for="i_s_italic"><i>Italic</i></label></td>
                        </tr>
                        <tr id="b15">
                            <td width="243" align="left"><input type="checkbox" name="i_s_underline" id="i_s_underline" value="y" <?php if ($i_s_underline == "y") echo "checked";?> /><label for="i_s_underline"><u>Underline</u></label></td>
                        </tr>
                        <tr id="b16">
                            <td width="243" align="left"><input type="checkbox" name="i_s_marquee" id="i_s_marquee" value="y" <?php if ($i_s_marquee == "y") echo "checked";?> /><label for="i_s_marquee">Marquee</label></td>
                        </tr>                                                
                        <tr id="b17">
                            <td width="66" align="left">Size&nbsp;</td>
                            <td width="243" align="left"><input type="text" name="i_size" size="4" value="<?php echo($i_size); ?>" />&nbsp;pt</td>
                        </tr>
                    </table>
                  </fieldset>
               
            </p>
                           
                    <fieldset>
                    <legend><strong>News Item Content&nbsp;Properties</strong></legend>
                   
                    <table width="428" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="66" align="left">Max&nbsp;Char&nbsp;</td>
                            <td width="215" align="left">
                                <input type="text" name="c_max_char" size="7" value="<?php echo($c_max_char); ?>" />&nbsp;<strong>0</strong> means show all characters, <strong>none</strong> means do not show any
                            </td>
                        </tr>
                        <tr id="b18">
                            <td width="66" align="left">Font&nbsp;</td>
                            <td width="215" align="left">
                                <select name="c_font">
                                    <?php foreach($fix_font as $font) { ?>
                                    <option value="<?php echo($font);?>" <?php if ($c_font == $font) echo "selected";?>><?php echo($font);?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr id="b19">
                            <td rowspan="2" width="66" align="left">Color&nbsp;</td>
                            <td width="215" align="left">
                                <input type="radio" name="rc_color" value="s" <?php if ($rc_color == "s") echo "checked"; ?> />
                                <select name="c_color">
                                    <?php foreach($fix_color as $color) { ?>
                                    <option value="<?php echo($color[1]);?>" <?php if ($c_color == $color[1]) echo "selected";?> ><?php echo($color[0]);?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>                        
                        <tr id="b20">
                            <td width="215" align="left">
                                <input type="radio" name="rc_color" value="o" id="rc_color_o" <?php if ($rc_color == "o") echo "checked"; ?> />
                                <label for="rc_color_o">Other&nbsp;</label><input type="text" name="c_color_o" size="7" value="<?php echo($c_color_o); ?>" />&nbsp;Exp.&nbsp;63aa7f
                            </td>
                        </tr>                        
                        <tr id="b21">
                            <td rowspan="4" width="66" align="left">Style&nbsp;</td>
                            <td width="215" align="left"><input type="checkbox" name="c_s_bold" id="c_s_bold" value="y" <?php if ($c_s_bold == "y") echo "checked";?> /><label for="c_s_bold"><strong>Bold</strong></label></td>
                        </tr>
                        <tr id="b22">
                            <td width="215" align="left"><input type="checkbox" name="c_s_italic" id="c_s_italic" value="y" <?php if ($c_s_italic == "y") echo "checked";?> /><label for="c_s_italic"><i>Italic</i></label></td>
                        </tr>
                        <tr id="b23">
                            <td width="215" align="left"><input type="checkbox" name="c_s_underline" id="c_s_underline" value="y" <?php if ($c_s_underline == "y") echo "checked";?> /><label for="c_s_underline"><u>Underline</u></label></td>
                        </tr>
                        <tr id="b24">
                            <td width="215" align="left"><input type="checkbox" name="c_s_marquee" id="c_s_marquee" value="y" <?php if ($c_s_marquee == "y") echo "checked";?> /><label for="c_s_marquee">Marquee</label></td>
                        </tr>                                                
                        <tr id="b25">
                            <td width="66" align="left">Size&nbsp;</td>
                            <td width="215" align="left"><input type="text" name="c_size" size="4" value="<?php echo($c_size); ?>" />&nbsp;pt</td>
                        </tr>
                        <tr id="b26">
                            <td width="66" align="left">Alignment&nbsp;</td>
                            <td width="215" align="left">
                                <select name="c_align">
                                    <?php foreach($fix_align as $align) {?>
                                    <option value="<?php echo($align);?>" <?php if ($align == $c_align) echo "selected"; ?>><?php echo($align); ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                   
               </fieldset>
            </p>            
            <p>
                
                    <!--input type="button" name="preview" value="Preview Feed" onClick="pr=window.open('preview.php?src=' + query_str(document.builder), 'prev', 'scrollbars,resizable,left=20,screenX=20,top=40,screenY=40,height=580,width=700'); pr.focus();" /-->
                    <p align="center">
                    <br />
                    <input type="submit" name="preview" value="Preview!" />
                    <input type="submit" name="generate" value="Generate JavaScript" />&nbsp;<input type="submit" name="generate_php" value="Generate PHP" />
             

            </p>
        </p>
        </form>
</td></tr></table></div>
	

