<?php

class FactorCrawlable
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '<div class="row crawlablerow">';
        
        if(!empty($data)){
            $out .= '<table class="table table-bordered"><tbody>';
            
            foreach($data as $key => $value){
                if($key === "robots" || $key === "googlebot" || $key === "googlebot_news" || $key === "googlebot_images" || $key === "slurp" || $key === "msn_bot" || $key === "teoma" || $key === "robots_header"){
                    $out .= '<tr>'
                                .'<td class="crawlablemd4">'. self::translate($key, $factor) ."</td>";
                            

                    if(gettype($value) === "array"){
                        $out .= '<td class="crawlablemd8">';

                        foreach($value as $elem){
                            $out .= ucfirst($elem). "<br>";
                        }

                        $out .= '</td>';
                    }
                    
                    $out .= '</tr>';
                }
            }
            
            $out .= '</tbody></table>';
        }else{
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'.self::translate("model_red", $factor).'</div>';
        }

        $out .= '</div>';
        
        return $out;
    }

}

