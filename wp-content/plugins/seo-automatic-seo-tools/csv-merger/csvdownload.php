<?php
$upload_dir = wp_upload_dir();
$upload_dir_dl = $upload_dir['url'].'/csv-merger/'.$_SESSION['csvmerger_session'].'/';
$csvext = $_REQUEST['csvext'];
$file = $upload_dir_dl.'merged-result.'.$csvext;
$remove_upload_dir = $upload_dir['path'].'/csv-merger/'.$_SESSION['csvmerger_session'];

// Force the download
header("Content-Disposition: attachment; filename=\"" . basename($file) . "\"");
//header("Content-Length: " . filesize($file));
header("Content-Type: text/".$csvext.";");
readfile($file);
deleteDir($remove_upload_dir);

function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            self::deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}
?>