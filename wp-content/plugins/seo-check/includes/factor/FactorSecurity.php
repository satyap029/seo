<?php

class FactorSecurity
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {        
        $out = '<div class="row">';
        
        if(!empty($data) && gettype($data) === "array"){
            if(!empty($data['general_status'])){
                if($data['general_status'] === true){
                    $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 firstdivsecurity">'. html_entity_decode(stripslashes(self::translate("result_green", $factor))) .'</div>';
                }else if($data['general_status'] === false){
                    $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 firstdivsecurity">'. html_entity_decode(stripslashes(self::translate("result_red", $factor))) .'</div>';
                }
            }
            
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 statusdiv"><table class="table"><tbody>';
            
            if(!empty($data['malware_status'])){
                $out .= '<tr>'
                        .'<td>'.self::translate("malware_alert", $factor).'</td>'
                        .'<td>'
                            ."<b>".ucfirst($data['malware_status'])."</b>"
                            .($data['malware_status'] === "unlisted" ? '<i class="fa fa-check-square securitygreen"></i>' : ($data['malware_status'] === "partial" ? '<i class="fa fa-exclamation-circle securityorange"></i>' : ''))
                        .'</td>'
                    .'</tr>';
            }

            if(!empty($data['uws_status'])){
                $out .= '<tr>'
                            .'<td>'.self::translate("spam_alert", $factor).'</td>'
                            .'<td>'    
                                ."<b>".ucfirst($data['uws_status'])."</b>"
                                .($data['uws_status'] === "unlisted" ? '<i class="fa fa-check-square securitygreen"></i>' : ($data['uws_status'] === "partial" ? '<i class="fa fa-exclamation-circle securityorange"></i>' : ''))
                            .'</td>'
                    .'</tr>';
            }

            if(!empty($data['social_status'])){
                $out .= '<tr>'
                            .'<td>'.self::translate("social_harm_alert", $factor).'</td>'
                            .'<td>'
                                ."<b>".ucfirst($data['social_status'])."</b>"
                                .($data['social_status'] === "unlisted" ? '<i class="fa fa-check-square securitygreen"></i>' : ($data['social_status'] === "partial" ? '<i class="fa fa-exclamation-circle securityorange"></i>' : ''))
                            .'</td>'
                    .'</tr>';
            }
            
            $out .= '</tbody></table></div>';

            if(!empty($data['attack_sites'])){
                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 malwaredcontent">';

                $out .= html_entity_decode(stripslashes(self::translate("attack_sites", $factor)));

                if(gettype($data['attack_sites']) === "array"){
                    foreach($data['attack_sites'] as $site){
                        $out .= '<span class="securityspan">'.$site. "</span>";
                    }
                }else if(gettype($data['attack_sites']) === "string"){
                    $out .= '<span class="securityspan">'.$data['attack_sites']. "</span>";                    
                }

                $out .= '</div>';
            }

            if(!empty($data['intermediary_sites'])){
                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 malwaredcontent">';

                $out .= html_entity_decode(stripslashes(self::translate("intermediary_sites", $factor)));

                if(gettype($data['intermediary_sites']) === "array"){
                    foreach($data['intermediary_sites'] as $site){
                        $out .= '<span class="securityspan">'.$site. "</span>";
                    }
                }else if(gettype($data['intermediary_sites']) === "string"){
                    $out .= '<span class="securityspan">'.$data['intermediary_sites']. "</span>";
                }

                $out .= '</div>';
            }

            if(!empty($data['receives_traffic'])){
                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 malwaredcontent">';

                $out .= html_entity_decode(stripslashes(self::translate("receives_traffic", $factor)));

                if(gettype($data['receives_traffic']) === "array"){
                    foreach($data['receives_traffic'] as $site){
                        $out .= '<span class="securityspan">'.$site. "</span>";
                    }
                }else if(gettype($data['receives_traffic']) === "string"){
                    $out .= '<span class="securityspan">'.$data['receives_traffic']. "</span>";
                }

                $out .= '</div>';
            }            
        }else{
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'.self::translate("model_red", $factor).'</div>';
        }

        $out .= '</div>';
        
        return $out;
    }
}
