<?php

//require 'interface.eranker.php';


class FactorFavicon
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $html = '';
        if ($data != null) {
            $source = (self::fixURL($data) !== false ? self::fixURL($data) : $data);

            $image = '<img src="'. $source .'" style="width:18px;height:18px;cursor:pointer;margin-right:6px;margin-top:-2px;">';

            $html .= '<a href="' . (self::fixURL($data) !== false ? self::fixURL($data) : $data) . '" style="color:#555" target="_blank">'
                . str_replace('imagefavic', $image, $endModel)
                . '</a>';
        } else {
            $html .= $endModel;
        }

        return $html;
    }

}