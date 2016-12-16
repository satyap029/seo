<?php

//require 'interface.eranker.php';


class FactorLogo
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        if (!is_null($data)) {
            return "<a href='" . (self::fixURL(str_replace("'", "", strip_tags($data))) !== false ? self::fixURL(str_replace("'", "", strip_tags($data))) : str_replace("'", "", strip_tags($data))) . "' target='_blank'>"
            . "<img style='background: url(" . self::$imgfolder . "transparent-canvas-background-tile.jpg) center center; display: block; margin-bottom: 10px;max-width:100%;' src='" . (self::fixURL(str_replace("'", "", strip_tags($data))) !== false ? self::fixURL(str_replace("'", "", strip_tags($data))) : str_replace("'", "", strip_tags($data))) . "' alt='Website Logo'>"
            . "</a>";
        } else {
            return $endModel;
        }
    }

}