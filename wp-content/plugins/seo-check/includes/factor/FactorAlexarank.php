<?php

//require 'interface.eranker.php';


class FactorAlexarank
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '<div class="row alexadiv">';

        if(!empty($data)){
            if(isset($data['chart']) && !empty($data['chart'])){
                $image = $data['chart'];
                if(@file_get_contents($image) !== false){
                    $out .= '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 nopaddingleft">';
                    // Read image path, convert to base64 encoding
                    $imageData = base64_encode(file_get_contents($image));
                    //Format the image SRC:  data:{mime};base64,{data};
                    $src = 'data: image/png;base64,'.$imageData;
                    $chart = '<img src="' . $src . '" class="chartalexa">';

                    $out .= $chart;

                    $out .= '</div>';
                }else{
                    $found404 = true;
                }
            }

            if(isset($found404)){
                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft halfalexa">';
                unset($found404);
            }else{
                $out .= '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 nopaddingleft halfalexa">';
            }

            if((isset($data['rank']) && !empty($data['rank'])) && isset($data['delta'])){
                $out .= '<div class="firstpartalexa">'
                    . '<label class="alexarank">'
                    . self::translate("globalrank", $factor)
                    . '</label>'
                    . '<p>'
                    . '<i class="fa fa-globe"></i>'
                    . '<span class="spanimprovealexa">'
                    .number_format($data['rank'])
                    .'</span>'
                    . '<span class="borderradiusactive" style="'. ($data['delta'] >= 0 ? 'background-color:#E41F26;' : 'background-color:#5FD45F;' ) .'">'
                    . ($data['delta'] >= 0 ? '<i class="fa fa-caret-down ialexa"></i>  ' : '<i class="fa fa-caret-up ialexa"></i>  ' ) .number_format(abs((int)$data['delta']))
                    . '</span>'
                    . '</p>'
                    . '</div>';
            }

            if(isset($data['countries']) && is_array($data['countries'])){
                $out .= '<div class="secondpartalexa">';

                foreach($data['countries'] as $country){
                    $out .= '<label class="alexarank">'
                        . self::translate("rankin", $factor).' '
                        .'<a href="'
                        . (self::fixURL("http://www.alexa.com/topsites/countries/".strtoupper($country['code'])) !== false ? self::fixURL("http://www.alexa.com/topsites/countries/".strtoupper($country['code'])) : "http://www.alexa.com/topsites/countries/".strtoupper($country['code'])) .'" target="_blank">'.(isset($country['name']) ? $country['name'] : '')
                        . '</a>'
                        . '</label>'
                        . '<p>'
                        . '<span class="fontspan">'
                        . "<img src='" . self::$imgfolder . "flags/24/".$country['code'].".png' class='flagspan' alt='". $country['code'] ."'/>"
                        .'</span>'
                        . '<span class="spanimprovealexa">'
                        . (!empty($country['rank']) ? number_format($country['rank']) : 'Not Available')
                        . '</span>'
                        . '</p>';
                }

                $out .= '</div>';
            }

            $out .= '</div>';
        }

        $out .= '</div>';

        return $out;
    }

}