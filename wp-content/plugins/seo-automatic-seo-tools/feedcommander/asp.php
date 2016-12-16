<?php
	$whatpage = ABSPATH.'feedcommander/feedcommander.sdh';
	$fp = fopen($whatpage,'r'); 
	$code = fread($fp, filesize($whatpage)); 
	fclose($fp);
	
	$feed = "<%\n";
	$feed .= "src = " . CHR(34) . $_REQUEST["src"] . CHR(34) . "\n";
	$feed .= "lines = " . CHR(34) . $_REQUEST["lines"] . CHR(34) . "\n";
	$feed .= "b_width = " . CHR(34) . $_REQUEST["b_width"] . CHR(34) . "\n";
	$feed .= "b_height = " . CHR(34) . $_REQUEST["b_height"] . CHR(34) . "\n";
	$feed .= "boxpadding = " . CHR(34) . $_REQUEST["boxpadding"] . CHR(34) . "\n";
	$feed .= "rb_color = " . CHR(34) . $_REQUEST["rb_color"] . CHR(34) . "\n";
	$feed .= "b_color = " . CHR(34) . $_REQUEST["b_color"] . CHR(34) . "\n";
	$feed .= "b_color_o = " . CHR(34) . $_REQUEST["b_color_o"] . CHR(34) . "\n";
	$feed .= "b_style = " . CHR(34) . $_REQUEST["b_style"] . CHR(34) . "\n";
	$feed .= "rb_b_color = " . CHR(34) . $_REQUEST["rb_b_color"] . CHR(34) . "\n";
	$feed .= "b_b_color = " . CHR(34) . $_REQUEST["b_b_color"] . CHR(34) . "\n";
	$feed .= "rb_b_color_o = " . CHR(34) . $_REQUEST["rb_b_color_o"] . CHR(34) . "\n";
	$feed .= "rb_b_weight = " . CHR(34) . $_REQUEST["rb_b_weight"] . CHR(34) . "\n";
	$feed .= "b_b_weight = " . CHR(34) . $_REQUEST["b_b_weight"] . CHR(34) . "\n";
	$feed .= "b_b_weight_o = " . CHR(34) . $_REQUEST["b_b_weight_o"] . CHR(34) . "\n";
	$feed .= "mq = " . CHR(34) . $_REQUEST["mq"] . CHR(34) . "\n";
	$feed .= "mq_di = " . CHR(34) . $_REQUEST["mq_di"] . CHR(34) . "\n";
	$feed .= "mq_n = " . CHR(34) . $_REQUEST["mq_n"] . CHR(34) . "\n";
	$feed .= "mq_dy = " . CHR(34) . $_REQUEST["mq_dy"] . CHR(34) . "\n";
	$feed .= "title = " . CHR(34) . $_REQUEST["title"] . CHR(34) . "\n";
	$feed .= "t_font = " . CHR(34) . $_REQUEST["t_font"] . CHR(34) . "\n";
	$feed .= "rt_color = " . CHR(34) . $_REQUEST["rt_color"] . CHR(34) . "\n";
	$feed .= "t_color = " . CHR(34) . $_REQUEST["t_color"] . CHR(34) . "\n";
	$feed .= "t_color_o = " . CHR(34) . $_REQUEST["t_color_o"] . CHR(34) . "\n";
	$feed .= "t_s_bold = " . CHR(34) . $_REQUEST["t_s_bold"] . CHR(34) . "\n";
	$feed .= "t_s_underline = " . CHR(34) . $_REQUEST["t_s_underline"] . CHR(34) . "\n";
	$feed .= "t_size = " . CHR(34) . $_REQUEST["t_size"] . CHR(34) . "\n";
	$feed .= "t_align = " . CHR(34) . $_REQUEST["t_align"] . CHR(34) . "\n";
	$feed .= "i_max_char = " . CHR(34) . $_REQUEST["i_max_char"] . CHR(34) . "\n";
	$feed .= "i_font = " . CHR(34) . $_REQUEST["i_font"] . CHR(34) . "\n";
	$feed .= "ri_color = " . CHR(34) . $_REQUEST["ri_color"] . CHR(34) . "\n";
	$feed .= "i_color = " . CHR(34) . $_REQUEST["i_color"] . CHR(34) . "\n";
	$feed .= "i_color_o = " . CHR(34) . $_REQUEST["i_color_o"] . CHR(34) . "\n";
	$feed .= "i_s_bold = " . CHR(34) . $_REQUEST["i_s_bold"] . CHR(34) . "\n";
	$feed .= "i_s_italic = " . CHR(34) . $_REQUEST["i_s_italic"] . CHR(34) . "\n";
	$feed .= "i_s_underline = " . CHR(34) . $_REQUEST["i_s_underline"] . CHR(34) . "\n";
	$feed .= "i_size = " . CHR(34) . $_REQUEST["i_size"] . CHR(34) . "\n";
	$feed .= "c_max_char = " . CHR(34) . $_REQUEST["c_max_char"] . CHR(34) . "\n";
	$feed .= "c_font = " . CHR(34) . $_REQUEST["c_font"] . CHR(34) . "\n";
	$feed .= "rc_color = " . CHR(34) . $_REQUEST["rc_color"] . CHR(34) . "\n";
	$feed .= "c_color = " . CHR(34) . $_REQUEST["c_color"] . CHR(34) . "\n";
	$feed .= "c_color_o = " . CHR(34) . $_REQUEST["c_color_o"] . CHR(34) . "\n";
	$feed .= "c_size = " . CHR(34) . $_REQUEST["c_size"] . CHR(34) . "\n";
	$feed .= "c_align = " . CHR(34) . $_REQUEST["c_align"] . CHR(34) . "\n";
	$feed .= "c_s_bold = " . CHR(34) . $_REQUEST["c_s_bold"] . CHR(34) . "\n";
	$feed .= "c_s_italic = " . CHR(34) . $_REQUEST["c_s_italic"] . CHR(34) . "\n";
	$feed .= "c_s_underline = " . CHR(34) . $_REQUEST["c_s_underline"] . CHR(34) . "\n";
	$feed .= "t_s_marquee = " . CHR(34) . $_REQUEST["t_s_marquee"] . CHR(34) . "\n";
	$feed .= "i_s_marquee = " . CHR(34) . $_REQUEST["i_s_marquee"] . CHR(34) . "\n";
	$feed .= "c_s_marquee = " . CHR(34) . $_REQUEST["c_s_marquee"] . CHR(34) . "\n";
	$feed .= "mq_height = " . CHR(34) . $_REQUEST["mq_height"] . CHR(34) . "\n";
	$feed .= "lb = " . CHR(34) . $_REQUEST["lb"] . CHR(34) . "\n";
	$feed .= "linkback1 = " . CHR(34) . $_REQUEST["linkback1"] . CHR(34) . "\n";
	$feed .= "linkback2 = " . CHR(34) . $_REQUEST["linkback2"] . CHR(34) . "\n";
	$feed .= "%>\n";
	
	$code = $feed . $code;
	$fileName = $_REQUEST["file"];	
	$myFile =  ABSPATH.'feedcommander/user/' . $fileName;
	$fh = fopen($myFile, 'w') or die("can't open file");
	fwrite($fh, $code);
	fclose($fh);

$filename = $myFile;
// required for IE, otherwise Content-disposition is ignored
if(ini_get('zlib.output_compression'))
  ini_set('zlib.output_compression', 'Off');

// addition by Jorg Weske
$file_extension = strtolower(substr(strrchr($filename,"."),1));

switch( $file_extension )
{
  case "sdh": $ctype="application/zip"; break;
  default: $ctype="application/force-download";
}
header("Pragma: public"); // required
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); // required for certain browsers 
header("Content-Type: $ctype");
// change, added quotes to allow spaces in filenames, by Rajkumar Singh
header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($filename));
readfile("$filename");
exit();
?>