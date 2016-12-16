<?php

//require 'interface.eranker.php';

class FactorTwitter
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '<div class="row guitwitter">';

        if (!empty($data)) {
            (isset($data['img_background']) && $data['img_background'] != '') ? $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft"><a href="' . (self::fixURL($data['img_background']) !== false ? self::fixURL($data['img_background']) : $data['img_background']) . '" target="_blank">'
                . '<img src="' . (self::fixURL($data['img_background']) !== false ? self::fixURL($data['img_background']) : $data['img_background']) . '" style="width:100%;margin-bottom:25px;margin-top:5px">'
                . '</a>'
                . '</div>' : $out .= '';

            (isset($data['twitter']) && $data['twitter'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><img src="' . self::$imgfolder . 'technologies/Twitter Follow Button.png" style="margin-right:6px;margin-top:-2px;width: 18px;height: 18px;"></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">'
                . '<a href="' . (self::fixURL($data["twitter"]) !== false ? self::fixURL($data["twitter"]) : $data["twitter"]) . '" target="_blank">' . $data['twitter']
                . '</a>'
                . '</div>' : $out .= '';

            ((isset($data['name']) && $data['name'] != '') && (isset($data['img_profile']) && $data['img_profile'] != '')) ? ($out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("name", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">'
                . '<img src="' . (self::fixURL($data["img_profile"]) !== false ? self::fixURL($data["img_profile"]) : $data["img_profile"]) . '" style="width:18px;height:18px;cursor:pointer;margin-right:6px;margin-top:-2px;">' . ucfirst($data['name'])
                . '</div>') : ((isset($data['name']) && $data['name'] != '') ? ($out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("name", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . ucfirst($data['name']) . '</div>') : $out .= '');

            (isset($data['followers']) && $data['followers'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("followers", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . $data['followers'] . '</div>' : $out .= '';

            (isset($data['bio']) && $data['bio'] != "") ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("bio", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . $data['bio'] . '</div>' : $out .= '';

            (isset($data['location']) && $data['location'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("location", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . $data['location'] . '</div>' : $out .= '';

            (isset($data['tweets']) && $data['tweets'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("tweets", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . $data['tweets'] . '</div>' : $out .= '';
        } else {
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">' . self::translate("model_red", $factor) . '</div>';
        }

        $out .= '</div>';

        return $out;
    }

}