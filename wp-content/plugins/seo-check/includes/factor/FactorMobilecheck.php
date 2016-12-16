<?php

//require 'interface.eranker.php';


class FactorMobilecheck 
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '<div class="row">';

        if(!empty($data)){
            if(isset($data['mobile_compatibility']) && !empty($data['mobile_compatibility']) && is_array($data['mobile_compatibility'])){
                $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft">'
                    . ((isset($data['mobile_compatibility']['compatible']) && $data['mobile_compatibility']['compatible'] === true) ? '<i class="fa fa-check-square-o greentext"></i> ' : '<i class="fa fa-times-circle-o redtext"></i> ')
                    . self::translate("mobile_compatibility", $factor)
                    .'</div>';

                if(isset($data['mobile_compatibility']['compatible']) && $data['mobile_compatibility']['compatible'] === true){
                    $out .= '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'. html_entity_decode(self::translate("mob_compatibility_gr", $factor)) .'</div>';
                }else{
                    $datatotal = '';

                    foreach($data['mobile_compatibility'] as $key => $value){
                        if($value === true && $key === 'java_plugin'){
                            $a = explode("_",$key);

                            $datatotal .= ucfirst($a[0]).' '. ucfirst($a[1]) .' '. self::translate("and_key",$factor) .' ';
                        }else if($value === true){
                            $datatotal .= ucfirst($key).' '. self::translate("technology_word",$factor) .' '. self::translate("and_key",$factor) .' ';
                        }
                    }

                    $datatotal = rtrim($datatotal, " ". self::translate("and_key",$factor) ." ");

                    $out .= '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'
                        . html_entity_decode(str_replace("%data_total",$datatotal,self::translate("red_mobilecompatibil", $factor)))
                        .'</div>';
                }
                $out .= '<br><br>';
            }

            if(isset($data['touchscreen_target']) && !empty($data['touchscreen_target']) && is_array($data['touchscreen_target'])){
                if(isset($data['touchscreen_target']['results']['touchable']) && !empty($data['touchscreen_target']['results']['touchable'])){
                    $val = $data['touchscreen_target']['results']['touchable'];

                    $font = '';
                    $seconddiv = '';
                    if(round($val) >= 0 && $val < 60){
                        $font .= '<i class="fa fa-times-circle-o redtext"></i>';

                        $seconddiv .= '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'
                            . html_entity_decode(self::translate("red_ts_readiness", $factor))
                            .'</div>';
                    }else if(round($val) >= 60 && $val < 80){
                        $font .= '<i class="fa fa-minus-circle orangetext"></i>';

                        $seconddiv .= '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'
                            . html_entity_decode(self::translate("orange_ts_readiness", $factor))
                            .'</div>';
                    }else if(round($val) >= 80){
                        $font .= '<i class="fa fa-check-square-o greentext"></i>';

                        $seconddiv .= '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'
                            . html_entity_decode(self::translate("green_ts_readiness", $factor))
                            .'</div>';
                    }

                    $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft">'. $font .' '. self::translate("ts_readiness", $factor) .'</div>';
                    $out .= $seconddiv;
                    $out .= '<br><br>';
                }
            }

            if(isset($data['font_sizes']) && !empty($data['font_sizes']) && is_array($data['font_sizes'])){
                if(isset($data['font_sizes']['results']['readeable']) && !empty($data['font_sizes']['results']['readeable'])){
                    $val = $data['font_sizes']['results']['readeable'];

                    $font = '';
                    $seconddiv = '';
                    if(round($val) >= 0 && $val < 60){
                        $font .= '<i class="fa fa-times-circle-o redtext"></i>';

                        $seconddiv .= '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'
                            . html_entity_decode(self::translate("red_font_size", $factor))
                            .'</div>';
                    }else if(round($val) >= 60 && $val < 80){
                        $font .= '<i class="fa fa-minus-circle orangetext"></i>';

                        $seconddiv .= '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'
                            . html_entity_decode(self::translate("orange_font_size", $factor))
                            .'</div>';
                    }else if(round($val) >= 80){
                        $font .= '<i class="fa fa-check-square-o greentext"></i>';

                        $seconddiv .= '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'
                            . html_entity_decode(self::translate("green_font_size", $factor))
                            .'</div>';
                    }

                    $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft">'. $font .' '. self::translate("font_size_legibility", $factor) .'</div>';
                    $out .= $seconddiv;
                    $out .= '<br><br>';
                }
            }

            if(isset($data['meta_viewport']) && !empty($data['meta_viewport']) && is_array($data['meta_viewport'])){
                $out .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 nopaddingleft">'
                    . ((isset($data['meta_viewport']['viewport']) && $data['meta_viewport']['viewport'] === true) ? '<i class="fa fa-check-square-o greentext"></i> ' : '<i class="fa fa-times-circle-o redtext"></i> ')
                    . self::translate("mobile_viewport", $factor)
                    .'</div>';

                //div open
                if(isset($data['meta_viewport']['viewport']) && $data['meta_viewport']['viewport'] === true){
                    $out .= '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'. html_entity_decode(self::translate("green_mv", $factor)).'<br/>';
                }else{
                    $out .= '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 nopaddingleft">'. html_entity_decode(self::translate("red_mv", $factor)).'<br/>';
                }

                if(isset($data['meta_viewport']['messages']) && !empty($data['meta_viewport']['messages']) && is_array($data['meta_viewport']['messages'])){
                    foreach($data['meta_viewport']['messages'] as $key => $message){
                        $val = (int)round($message);

                        switch($val){
                            case 1:
                                $out .= '<p class="font14"><i class="fa fa-minus-circle orangetext"></i> '. html_entity_decode(self::translate("mv_m1orange", $factor)).'</p>';
                                break;
                            case 2:
                                $out .= '<p class="font14"><i class="fa fa-times-circle-o redtext"></i> '. html_entity_decode(self::translate("mv_m2red", $factor)).'</p>';
                                break;
                            case 3:
                                $out .= '<p class="font14"><i class="fa fa-times-circle-o redtext"></i> '. html_entity_decode(self::translate("mv_m3red", $factor)).'</p>';
                                break;
                            case 4:
                                $out .= '<p class="font14"><i class="fa fa-minus-circle orangetext"></i> '. html_entity_decode(self::translate("mv_m4orange", $factor)).'</p>';
                                break;
                            case 5:
                                $out .= '<p class="font14"><i class="fa fa-minus-circle orangetext"></i> '. html_entity_decode(self::translate("mv_m5orange", $factor)).'</p>';
                                break;
                            case 6:
                                $out .= '<p class="font14"><i class="fa fa-minus-circle orangetext"></i> '. html_entity_decode(self::translate("mv_m6orange", $factor)).'</p>';
                                break;
                            default: $out .= '';
                        }
                    }
                }

                if(isset($data["meta_viewport"]['meta_parser']) && is_array($data["meta_viewport"]['meta_parser']) && !empty($data["meta_viewport"]['meta_parser'])){
                    $flaggreen = true;
                    $flagred = false;
                    $flagorange = false;

                    foreach($data["meta_viewport"]['meta_parser'] as $dataparse){
                        if(!empty($dataparse['invalid_values'])){
                            $flagred = true;
                        }

                        if(!empty($dataparse['unknown_properties']) && empty($dataparse['invalid_values'])){
                            $flagorange = true;
                        }
                    }

                    foreach($data["meta_viewport"]['meta_parser'] as $dataparse){
                        if(!empty($dataparse['valid_properties']) && empty($dataparse['unknown_properties']) && empty($dataparse['invalid_values'])){
                            $flaggreen = true;
                        }else{
                            $flaggreen = false;
                            break;
                        }
                    }

                    if($flagred === true){
                        $out .= '<p class="font14"><i class="fa fa-times-circle-o redtext"></i> '. html_entity_decode(self::translate("mv_specialm2red", $factor)).'</p>';
                    }

                    if($flaggreen === true){
                        $out .= '<p class="font14"><i class="fa fa-check-square-o greentext"></i> '. html_entity_decode(self::translate("mv_specialm1green", $factor)).'</p>';
                    }

                    if($flagorange === true){
                        $out .= '<p class="font14"><i class="fa fa-minus-circle orangetext"></i> '. html_entity_decode(self::translate("mv_specialm3orange", $factor)).'</p>';
                    }
                }

                //close div
                $out .= '</div>';
            }
        }else{
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'. self::translate("model_red", $factor) .'</div>';
        }

        $out .= "</div>";

        return $out;
    }

}