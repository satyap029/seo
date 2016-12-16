<?php
$csvcontent = $_POST['csvresults'];
$filename = "results-".rand().".csv";
//Set some headers now, so browser knows what to do with, and how to deal with content it's being sent.
// required for IE, otherwise Content-disposition is ignored
if(ini_get('zlib.output_compression')) {
    ini_set('zlib.output_compression', 'Off');
}
header("Pragma: public"); // required
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false); // required for certain browsers
header("Content-Type: application/octet-stream");
header('Content-Disposition: attachment; filename="' . $filename . '"');
header("Content-Length: " . strlen($csvcontent));
ob_clean();
flush();
echo $csvcontent;
exit;
?>
