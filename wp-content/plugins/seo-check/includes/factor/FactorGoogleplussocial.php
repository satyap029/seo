<?php

//require 'interface.eranker.php';


class FactorGoogleplussocial
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '<div class="row guigoogleplussocial">';

        if (!empty($data)) {
            (isset($data['image_background']) && $data['image_background'] != '') ? $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft googleplusfactor">'
                . '<a href="' . (self::fixURL($data['image_background']) !== false ? self::fixURL($data['image_background']) : $data['image_background']) . '" target="_blank">'
                . '<img src="' . (self::fixURL($data['image_background']) !== false ? self::fixURL($data['image_background']) : $data['image_background']) . '" class="imgbgrdgoogleplus">'
                . '</a>'
                . '</div>' : $out .= '';

            (isset($data['google_plus']) && $data['google_plus'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><img src="' . self::$imgfolder . 'technologies/Google Plus One Button.png" style="margin-right:6px;margin-top:-2px;width: 18px;height: 18px;"></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">'
                . '<a href="' . (self::fixURL($data["google_plus"]) !== false ? self::fixURL($data["google_plus"]) : $data["google_plus"]) . '" target="_blank">' . $data['google_plus']
                . '</a>'
                . '</div>' : $out .= '';

            ((isset($data['name']) && $data['name'] != '') && (isset($data['image_profile']) && $data['image_profile'] != '')) ? ($out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("name", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">'
                . '<img src="' . (self::fixURL($data["image_profile"]) !== false ? self::fixURL($data["image_profile"]) : $data["image_profile"]) . '" style="width:18px;height:18px;cursor:pointer;margin-right:6px;margin-top:-2px;">' . ucfirst($data['name'])
                . '</div>') : ((isset($data['name']) && $data['name'] != '') ? ($out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("name", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . ucfirst($data['name']) . '</div>') : $out .= '');

            (isset($data['tagline']) && $data['tagline'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("tagline", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . ucfirst($data['tagline']) . '</div>' : $out .= '';

            (isset($data['introduction']) && $data['introduction'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("introduction", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . ucfirst($data['introduction']) . '</div>' : $out .= '';

            (isset($data['email']) && $data['email'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("email", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . ucfirst($data['email']) . '</div>' : $out .= '';

            (isset($data['followers']) && $data['followers'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("followers", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . $data['followers'] . '</div>' : $out .= '';

            (isset($data['views']) && $data['views'] != "") ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("views", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . $data['views'] . '</div>' : $out .= '';
        } else {
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">' . self::translate("model_red", $factor) . '</div>';
        }

        $out .= '</div>';

        return $out;
    }

}