<?php

//require 'interface.eranker.php';


class FactorFacebooksocial
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '<div class="row guifacebooksocial">';

        if (!empty($data) && count($data) > 1) {
            if (isset($data['img_background']) && !empty($data['img_background'])) {
                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft facebooksocialfactor">'
                    . '<a href="' . (self::fixURL($data['img_background']) !== false ? self::fixURL($data['img_background']) : $data['img_background']) . '" target="_blank">'
                    . '<img src="' . (self::fixURL($data['img_background']) !== false ? self::fixURL($data['img_background']) : $data['img_background']) . '" class="imgbgrdfacebooksocial">'
                    . '</a>'
                    . '</div>';
            }

            if (isset($data['img_profile']) && !empty($data['img_profile'])) {
                if (isset($data['facebook']) && !empty($data['facebook'])) {
                    $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft"><img src="' . self::$imgfolder . 'technologies/Facebook Like Button.png" style="margin-right:6px;margin-top:-2px;width: 18px;height: 18px;"></div>'
                        . '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'
                        . '<a href="' . (self::fixURL($data["facebook"]) !== false ? self::fixURL($data["facebook"]) : $data["facebook"]) . '" target="_blank">'
                        . $data['facebook']
                        . '<img src="' . (self::fixURL($data["img_profile"]) !== false ? self::fixURL($data["img_profile"]) : $data["img_profile"]) . '" style="width:18px;height:18px;cursor:pointer;margin-left:10px;margin-top:-2px;">'
                        . '</a>'
                        . '</div>';
                }
            } else {
                if (isset($data['facebook']) && !empty($data['facebook'])) {
                    $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft"><img src="' . self::$imgfolder . 'technologies/Facebook Like Button.png" style="margin-right:6px;margin-top:-2px;width:18px;height:18px;"></div>'
                        . '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'
                        . '<a href="' . (self::fixURL($data["facebook"]) !== false ? self::fixURL($data["facebook"]) : $data["facebook"]) . '" target="_blank">' . $data['facebook']
                        . '</a>'
                        . '</div>';
                }
            }

            if (isset($data['company_type']) && !empty($data['company_type'])) {
                $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft"><b>' . self::translate("company_type", $factor) . ':</b></div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">' . $data['company_type'] . '</div>';
            }

            if (isset($data['short_description']) && !empty($data['short_description'])) {
                $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft"><b>' . self::translate("short_description", $factor) . ':</b></div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">' . $data['short_description'] . '</div>';
            }

            if (isset($data['website']) && !empty($data['website'])) {
                $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft"><b>' . self::translate("website", $factor) . ':</b></div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'. $data['website'] . '</div>';
            }

            if (isset($data['email']) && !empty($data['email'])) {
                $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft"><b>' . self::translate("email", $factor) . ':</b></div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'. $data['email'] . '</div>';
            }

            if (isset($data['mission']) && !empty($data['mission'])) {
                $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft"><b>' . self::translate("mission", $factor) . ':</b></div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'. htmlentities($data['mission']) . '</div>';
            }

            if (isset($data['general_information']) && !empty($data['general_information'])) {
                $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft"><b>' . self::translate("general_information", $factor) . ':</b></div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'. htmlentities($data['general_information']) . '</div>';
            }

            if (isset($data['start_date']) && !empty($data['start_date'])) {
                $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft"><b>' . self::translate("start_date", $factor) . ':</b></div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'. $data['start_date'] . '</div>';
            }

            if (isset($data['products']) && !empty($data['products'])) {
                $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft"><b>' . self::translate("products", $factor) . ':</b></div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'. htmlentities($data['products']) . '</div>';
            }

            if (isset($data['overview']) && !empty($data['overview'])) {
                $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft"><b>' . self::translate("overview", $factor) . ':</b></div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'. htmlentities($data['overview']) . '</div>';
            }

            if (isset($data['phone']) && !empty($data['phone'])) {
                $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft"><b>' . self::translate("phone", $factor) . ':</b></div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft"><img src="' . self::$factorCreateImageFolder . 'createimage.php?size=11&amp;transparent=1&amp;padding=0&amp;bgcolor=250&amp;textcolor=50&amp;text=' . urlencode(strrev(base64_encode($data['phone']))) . '" alt="Website Phone Number"></div>';
            }

            if (isset($data['address']) && !empty($data['address'])) {
                $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft"><b>' . self::translate("address", $factor) . ':</b></div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'. $data['address'] . '</div>';
            }

            if (isset($data['review_number']) && !empty($data['review_number'])) {
                $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft"><b>' . self::translate("reviews", $factor) . ':</b></div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">' . $data['review_number'] . '</div>';
            }

            if (isset($data['review_stars']) && !empty($data['review_stars'])) {
                $stars = '';

                for ($i = 0; $i < round((int) $data['review_stars']); $i++) {
                    $stars .= '<i class="fa fa-star" style="color: #8DBE56"></i>';
                }

                $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft"><b>' . self::translate("rating", $factor) . ':</b></div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">' . $stars . '</div>';
            }
        } else {
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">' . self::translate("model_red", $factor) . '</div>';
        }

        $out .= '</div>';

        return $out;
    }

}