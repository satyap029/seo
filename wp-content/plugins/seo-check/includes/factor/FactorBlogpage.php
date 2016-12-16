<?php

//require 'interface.eranker.php';


class FactorBlogpage
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        if (!is_null($data)) {
            $html = '<a href="' . (self::fixURL($data) !== false ? self::fixURL($data) : $data) . '" rel="nofollow" style="color:#555" target="_blank">' . (is_null($endModel) ? $data : $endModel) . '</a>';
        } else {
            $html = is_null($endModel) ? $factor[id] : $endModel;
        }
        return $html;
    }

}