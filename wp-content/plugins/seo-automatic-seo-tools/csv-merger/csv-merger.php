<?php

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

error_reporting(0);
// Create a unique session ID
session_start(); 

if (isset($_REQUEST['csvdownload']) && $_REQUEST['csvdownload'] == 'true') {
	include('csvdownload.php');
	exit();
}

function csvmerger_function() {	
?>
<script language="javascript">
function setCSVVisibility(id, visibility) {
	document.getElementById(id).style.display = visibility;
}
</script>
<?php
	$upload_dir = wp_upload_dir();
	$upload_dir = $upload_dir['path'].'/csv-merger';
	if (!isset($_SESSION['csvmerger_session'])) {
		$temp_sess = random_folder_name(10);
		$temp_folder = $upload_dir.'/'.$temp_sess;
		$_SESSION['csvmerger_session'] = $temp_sess;
	} else {
		$temp_sess = $_SESSION['csvmerger_session'];
		$temp_folder = $upload_dir.'/'.$temp_sess;
	}

	if (!file_exists($upload_dir)) {
		if (!mkdir($upload_dir, 0755, true)) {
		    $csvmergeroutput .= 'Failed to create main directory. You\'ll need to manually create it in your uploads folder with the name csv-merger and set your permissions to 755.<br />';
		}
	}

	if (isset($_REQUEST['showdownloadbutton']) && $_REQUEST['showdownloadbutton'] == 'true') {
		$csvext = $_REQUEST['csvext'];	
		if (!file_exists($temp_folder)) {
			if (!mkdir($temp_folder, 0755, true)) {
			    $csvmergeroutput .= 'Failed to create temp directory. If you\'re sure the permissions are correct on the main directory and this still fails, you most likely cannot use this tool. It requires the ability to dynamically create and delete temp folders and files.';
			}
		}
		
		$upload_dir = $upload_dir.'/';
		$temp_folder = $upload_dir.$_SESSION['csvmerger_session'].'/';
		
		// Here we define the file path and name
		$target_file = $temp_folder."merged-result.".$csvext;
		// Here we define the string data that is to be placed into the file
		$target_file_data = "";
		// Here we are creating a file(since it does not yet exist) and adding data to it
		$handle = fopen($target_file, "w");
		fwrite($handle, $target_file_data); // write it
		fclose($handle);
	}
	
	include('addfiles.php');
$csvmergeroutput .= '<div id="showhide">';	
	if (is_dir($temp_folder)) {
	    if ($dh = opendir($temp_folder)) {
	    	$y = 1;
	        while (false !== ($file = readdir($dh))) {
	            if ($file != "." && $file != "..") {
	            	if (isset($_REQUEST['showdownloadbutton']) && $_REQUEST['showdownloadbutton'] == 'true') {
		            	if ($file == 'merged-result.'.$csvext) {
		            		$csvmergeroutput .= "";
		            	} else {
		            		$csvmergeroutput .= "Merging file: ".$y."<br />";
		            		$y++;
		            	}
	            	}
	            	$csvcontents = file_get_contents($temp_folder.$file);
					$handle = fopen($target_file, "a");
					fwrite($handle, $csvcontents); // write it
					fclose($handle);           	
	            }
	        }
	        closedir($dh);

			// array to hold all "seen" lines
			$lines = array();

			// open the csv file
			if (($handle = fopen($target_file, "r")) !== false) {
			    // read each line into an array
			    while (($data = fgetcsv($handle, 8192, ",")) !== false) {
			        // build a "line" from the parsed data
			        $line = join(",", $data);

			        // if the line has been seen, skip it
			        if (isset($lines[$line])) continue;

			        // save the line
			        $lines[$line] = true;
			    }
			    fclose($handle);
			}

			// build the new content-data
			$contents = '';
			foreach ($lines as $line => $bool) $contents .= $line . "\r\n";

			// save it to a new file
			file_put_contents($target_file, $contents);
			
			chmod($target_file,0755);
			
			if (isset($_REQUEST['showdownloadbutton']) && $_REQUEST['showdownloadbutton'] == 'true') {
				$csvmergeroutput .= "<br /><br /><form method=post action=''><input type='hidden' name='csvdownload' value='true' /><input type='hidden' name='csvext' value='$csvext' /> <input type=submit value='Download Merged Result File' onclick=\"setCSVVisibility('showhide', 'none');\"></form>";
			}
$csvmergeroutput .= '</div>';			        
	    }
	}
	return $csvmergeroutput;	
}	

function random_folder_name($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

add_shortcode( 'csvmerger', 'csvmerger_function' );

?>