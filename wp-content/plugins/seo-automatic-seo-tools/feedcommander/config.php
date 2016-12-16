<?php
    // MAGPIE SETUP ----------------------------------------------------
    // Define path to Magpie files and load library
    // The easiest setup is to put the 4 Magpie include
    // files in the same directory:
    // define('MAGPIE_DIR', './')

    // Otherwise, provide a full valid file path to the directory
    // where magpie sites

    define('MAGPIE_DIR',  dirname(__FILE__).'/magpie/');

    // access magpie libraries
    require_once(MAGPIE_DIR . 'rss_fetch.inc');
    require_once(MAGPIE_DIR . 'rss_utils.inc');

    // value of 2 optionally show lots of debugging info but breaks JavaScript
    // This should be set to 0 unless debugging
    define('MAGPIE_DEBUG', 0);

    // Define cache age in seconds.
    define('MAGPIE_CACHE_AGE', 60*60);
    
    define('MAGPIE_CACHE_DIR', MAGPIE_DIR . 'cache/');
        
    // Fixed Color
    $fix_color = array (
            array("White", "ffffff"),
            array("Dark Blue", "4444aa"),
            array("Dark Green", "44aa44"),
            array("Dark Yellow", "aaaa44"),
            array("Dark Cyan", "44aaaa"),
            array("Dark Magenta", "aa44aa"),
            array("Light Blue", "aaaaff"),
            array("Light Green", "aaffaa"),
            array("Light Yellow", "ffffaa"),
            array("Light Cyan", "aaffff"),
            array("Light Magenta", "ffaaff"),
            array("Dark Gray", "aaaaaa"),
            array("Medium Gray", "bfbfbf"),
            array("Light Gray", "dfdfdf"),
            array("Black", "000000"),
            array("None", "none")
        );
    
    // Fixed Border Style
    $fix_border = array (
            "none", "dotted", "dashed", "solid", "double", "groove", "ridge", "inset", "outset"
        );
    
    // Fixed Border Weight
    $fix_weight = array (
            "thin", "medium", "thick"
        );
        
    // Fixed Font Family
    $fix_font = array (
            "Arial", "Garamond", "Verdana", "Sans-Serif", "Tahoma", "Times%20New%20Roman", "Trebuchet%20MS"
        );
    
    $fix_align = array (
            "left", "right", "center", "justify"
        );
      
    require_once(dirname(__FILE__).'/setup.txt');
?>