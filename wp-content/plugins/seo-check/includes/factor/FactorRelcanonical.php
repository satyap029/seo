<?php

//require 'interface.eranker.php';


class FactorRelcanonical
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '<div class="row">';

        if(!empty($data)){
            foreach($data as $link){
                if(isset($link['relative_path']) && $link['relative_path']){
                    $find = true;
                    break;
                }
            }

            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'. (!isset($find) ? $endModel : self::translate("model_orange", $factor)) .'</div>';

            if(is_array($data)){
                foreach($data as $link){
                    if(!empty($link)){
                        $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'
                            . (!isset($find) ?
                                '<a href="'. (self::fixURL($link['path']) !== false ? self::fixURL($link['path']) : $link['path']) .'" target="_blank">'
                                . $link['path']
                                . '</a>'
                                : $link['path'])
                            .'</div>';
                    }
                }
            }
        }else{
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'. self::translate("model_red", $factor) .'</div>';
        }

        $out .= '</div>';

        return $out;
    }

}