<?php
class Bulk404Object {
function sc_404_page(){
	$sc_plugin_dir =  get_option('siteurl').'/wp-content/plugins/seo-automatic-seo-tools/sc-bulk-url-checker/';	
	echo '<script type="text/javascript" src="'.$sc_plugin_dir.'tablesorter/jquery-latest.js"></script>';	
	echo '<script type="text/javascript" src="'.$sc_plugin_dir.'tablesorter/jquery.metadata.js"></script>';
	echo '<script type="text/javascript" src="'.$sc_plugin_dir.'tablesorter/jquery.tablesorter.js"></script>';
	echo '<script type="text/javascript" src="'.$sc_plugin_dir.'tablesorter/addons/pager/jquery.tablesorter.pager.js"></script>';
	echo '<script type="text/javascript" src="'.$sc_plugin_dir.'include/jquery-1.3.2.min.js"></script>';
	echo '<script type="text/javascript" src="'.$sc_plugin_dir.'include/script.js"></script>';

if(isset($_POST['urls'])){
	$urls = $_POST['urls'];
	$url3 = preg_replace('/\s+/', ' ', $urls);
	$urls2 = explode(' ', $url3);
	$urllisttext = $url3;
	
}
else{
	$urllisttext = "";
}

	echo '
<form method="post" action="">
<textarea name="urls" cols="40" rows="5">'.$urllisttext.'</textarea><br />
<input type="submit" value="Submit" />
</form>';


if(isset($urls2)){
	echo '
	<div id="urlchecker" style="overflow: auto;">
	<table class="tablesorter"> 
<thead> 
<tr> 
	<th id="url" align="left">URL</th> 
	<th id="status" align="left">Status</th> 
	<th id="redirect" align="left">Redirect</th>
</tr> 
</thead> 
<tbody> 
	
	';

	foreach ($urls2 as $url){
			  $url = trim($url);
			  if ($url != ''){
			  $status = getHttpResponseCode($url);
	  echo '<tr class="';
	  if (!preg_match('/:|:/', $status)){
	if ('NoResponse' === $status)
		echo 'yellow';
	elseif ('200' != $status){
	  echo 'red';
	  }
	  echo '"><td height="15">'.$url.'</td>';
	  echo '<td>'.$status.'</td><td></td></tr>';
	$data[] = array("url" => $url , "status" => $status, "Redirect" => "");
} else {
	$status2 = explode(':|:', $status);
	if ('404' == $status2[0])
		echo 're';
	elseif ('200' != $status2[0])
	  echo 'purple';
	  echo '"><td height="15">'.$url.'</td>';
	  echo '<td>'.$status2[0].'</td><td>'.$status2[1].'</td></tr>';
	$data[] = array("url" => $url , "status" => $status2[0] , "Redirect" => $status2[1]);	
	
}
}  
	}
	echo '</tbody></table></div>';
	echo '<div id="next"><form id="excel" method="post" action="'.$sc_plugin_dir.'download.php"><input type="hidden" name="download" value="'.$urllisttext.'" /><input type="hidden" name="run" value="yes" /><input type="submit" value="Download Excel"></form>';

	echo '</div>';
} else {



}

?>
<script type="text/javascript">
$(document).ready(function() { 
	// call the tablesorter plugin 
	$("table").tablesorter({ 
		// sort on the first column and third column, order asc 
		sortList: [[0,0],[2,0]] 
	}); 
}); 
</script>

<?php }} ?>