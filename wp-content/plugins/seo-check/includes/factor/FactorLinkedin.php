<?php

class FactorLinkedin
    extends eRankerBase
    implements FactorDisplay
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '<div class="row guilinkedin">';
        //var_dump($data);
        if (!empty($data)){
            ((isset($data['background_img']) && $data['background_img'] != '') ? ($out .= ''
                . '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'
                . '<img src="' . (self::fixURL($data["background_img"]) !== false ? self::fixURL($data["background_img"]) : $data["background_img"]) . '" style="width:auto; margin-bottom:25px; margin-top:5px; max-height:400px;">'
                . '</div>') : $out .= '');

            ((isset($data['name']) && $data['name'] != '' && !isset($data["profile_img"])) ? ($out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("name", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">'                
                . ucfirst($data['name'])
                . '</div>')
                : $out .= '');
            
            ((isset($data['name']) && $data['name'] != '' && isset($data["profile_img"])) ? ($out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("name", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">'
                . '<img src="' . (self::fixURL($data["profile_img"]) !== false ? self::fixURL($data["profile_img"]) : $data["profile_img"]) . '" style="width:18px;height:18px;cursor:pointer;margin-right:6px;margin-top:-2px;">'
                . ucfirst($data['name'])
                . '</div>')
                : $out .= '');

            (isset($data['linkedin']) && $data['linkedin'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><img src="' . self::$imgfolder . 'technologies/LinkedIn Platform API.png" style="margin-right:6px;margin-top:-2px;width: 18px;height: 18px;"></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">'
                . '<a href="' . (self::fixURL($data["linkedin"]) !== false ? self::fixURL($data["linkedin"]) : $data["linkedin"]) . '" target="_blank">' . $data['linkedin'] . '</a>'
                . '</div>' : $out .= '';

            (isset($data['type']) && $data['type'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("type", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . ucfirst($data['type']) . '</div>' : $out .= '';

            (isset($data['description']) && $data['description'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("description", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . $data['description'] . '</div>' : $out .= '';

            (isset($data['specialties']) && $data['specialties'] != '') ?
                $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("specialties", $factor) . ':</b></div>'
                    . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . $data['specialties'] . '</div>' : $out .= '';

            (isset($data['industry']) && $data['industry'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("industry", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . $data['industry'] . '</div>' : $out .= '';

            (isset($data['size']) && $data['size'] != '') ? $out .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><b>' . self::translate("size", $factor) . ':</b></div>'
                . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . $data['size'] . '</div>' :
                $out .= '';
        }else {
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">' . self::translate("model_red", $factor) . '</div>';
        }

        $out .= '</div>';

        return $out;
    }

}