<?php

//require 'interface.eranker.php';


class FactorInstagram
    extends eRankerBase
    implements FactorDisplay
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '<div class="row guiinstagram">';

        if (!empty($data)) {
            ((isset($data['name']) && $data['name'] != '') && (isset($data['profile_icon']) && $data['profile_icon'] != '')) ? ($out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("name", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">'
                . '<img src="' . (self::fixURL($data["profile_pic"]) !== false ? self::fixURL($data["profile_pic"]) : $data["profile_pic"]) . '" style="width:18px;height:18px;cursor:pointer;margin-right:6px;margin-top:-2px;">' . ucfirst($data['name'])
                . '</div>') : ((isset($data['name']) && $data['name'] != '') ? ($out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("name", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . ucfirst($data['name']) . '</div>') : $out .= '');

            (isset($data['instagram']) && $data['instagram'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><img src="' . self::$imgfolder . 'technologies/instagram-icon.png" style="margin-right:6px;margin-top:-2px;width: 18px;height: 18px;"></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft"><a href="' . (self::fixURL($data["instagram"]) !== false ? self::fixURL($data["instagram"]) : $data["instagram"]) . '" target="_blank">' . $data['instagram'] . '</a></div>' : $out .= '';

            (isset($data['biography']) && $data['biography'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("biography", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . ucfirst($data['biography']) . '</div>' : $out .= '';

            (isset($data['followedby']) && $data['followedby'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("followedby", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . $data['followed_by'] . '</div>' : $out .= '';

            (isset($data['following']) && $data['following'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("following", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . $data['following'] . '</div>' : $out .= '';
        } else {
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">' . self::translate("model_red", $factor) . '</div>';
        }

        $out .= '</div>';

        return $out;
    }

}