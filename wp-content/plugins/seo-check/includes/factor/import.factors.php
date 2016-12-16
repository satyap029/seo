<?php
$dir = scandir(dirname(__FILE__));

foreach ($dir as $filename) {
    if (strpos($filename, "Factor") === 0) {        
        require_once $filename;
    }
}
