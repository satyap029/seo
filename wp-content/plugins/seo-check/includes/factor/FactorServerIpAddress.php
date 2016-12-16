<?php

class FactorServerIpAddress
    extends eRankerBase 
    implements FactorDisplay 
{
    public static function getDisplay($endModel, $data, $report, $factor) {        
        $out = '<div class="row">';
        
            if(isset($data['is_canonized'])){
                if($data['is_canonized'] === true || $data['is_canonized'] === "true"){
                    if(isset($data['ip']) && !empty($data['ip'])){
                        $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'
                                .sprintf(html_entity_decode(stripslashes(self::translate("response_true", $factor))),"<span class='show-ip-address'>".$data['ip']."</span>");
                        
                        $out .= "</div>";
                    }else{
                        $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'.html_entity_decode(stripslashes(self::translate("model_orange", $factor)))."</div>";
                    }                    
                }else{
                    if(isset($data['ip']) && !empty($data['ip'])){
                        $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'
                            .sprintf(html_entity_decode(stripslashes(self::translate("response_false", $factor))),"<span class='show-ip-address-red'>".$data['ip']."</span>");

                        $out .= "</div>";
                    }else{
                        $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'.html_entity_decode(stripslashes(self::translate("model_orange", $factor)))."</div>";
                    }
                }
            }else{
                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'.html_entity_decode(stripslashes(self::translate("model_red", $factor)))."</div>";
            }
            
        $out .= '</div>';
        
        return $out;
    }
}
