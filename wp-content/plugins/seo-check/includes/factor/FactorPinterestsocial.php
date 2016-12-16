<?php

//require 'interface.eranker.php';


class FactorPinterestsocial
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {

        $out = '<div class="row guipinterestsocial">';

        if(!empty($data)){
//            (isset($data["img_profile"]) && !empty($data["img_profile"])) ?
//                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'
//                            .'<img src="'. (self::fixURL($data["img_profile"]) !== false ? self::fixURL($data["img_profile"]) : $data["img_profile"]) .'" style="width:100%;margin-bottom:25px;margin-top:5px; max-height: 550px;">'
//                        .'</div>'
//            : $out .= '';

            (isset($data["name"]) && !empty($data["name"])) ?
                $out .= '<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 nopaddingleft">'
                    .html_entity_decode(self::translate("name_key", $factor))
                    .'</div>'
                    .'<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 nopaddingleft">'
                    .$data['name']
                    .'</div>'
                : $out .= '';

            (isset($data["about"]) && !empty($data["about"])) ?
                $out .= '<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 nopaddingleft">'
                    .html_entity_decode(self::translate("about_key", $factor))
                    .'</div>'
                    .'<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 nopaddingleft">'
                    .$data['about']
                    .'</div>'
                : $out .= '';

            (isset($data["pinterest"]) && !empty($data["pinterest"])) ?
                $out .= '<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 nopaddingleft">'
                    .'<img src="'. self::$imgfolder .'technologies/Pinterest.png" style="margin-right:6px;margin-top:-2px;width: 18px;height: 18px;">'
                    .'</div>'
                    .'<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 nopaddingleft">'
                    .'<a href="'. (self::fixURL($data["pinterest"]) !== false ? self::fixURL($data["pinterest"]) : $data["pinterest"]) .'" target="_blank">'. $data['pinterest'] ."</a>"
                    .'</div>'
                : $out .= '';

            (isset($data["location"]) && !empty($data["location"])) ?
                $out .= '<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 nopaddingleft">'
                    .html_entity_decode(self::translate("location_key", $factor))
                    .'</div>'
                    .'<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 nopaddingleft">'
                    .$data['location']
                    .'</div>'
                : $out .= '';

            (isset($data["followers"]) && !empty($data["followers"])) ?
                $out .= '<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 nopaddingleft">'
                    .html_entity_decode(self::translate("followers_key", $factor))
                    .'</div>'
                    .'<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 nopaddingleft">'
                    .$data['followers']
                    .'</div>'
                : $out .= '';

            (isset($data["following"]) && !empty($data["following"])) ?
                $out .= '<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 nopaddingleft">'
                    .html_entity_decode(self::translate("following_key", $factor))
                    .'</div>'
                    .'<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 nopaddingleft">'
                    .$data['following']
                    .'</div>'
                : $out .= '';

            (isset($data["likes"]) && !empty($data["likes"])) ?
                $out .= '<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 nopaddingleft">'
                    .html_entity_decode(self::translate("likes_key", $factor))
                    .'</div>'
                    .'<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 nopaddingleft">'
                    .$data['likes']
                    .'</div>'
                : $out .= '';

            (isset($data["pins"]) && !empty($data["pins"])) ?
                $out .= '<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 nopaddingleft">'
                    .html_entity_decode(self::translate("pins_key", $factor))
                    .'</div>'
                    .'<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 nopaddingleft">'
                    .$data['likes']
                    .'</div>'
                : $out .= '';
        }else{
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'. $endModel .'</div>';
        }

        $out .= '</div>';

        return $out;
    }

}