<?php

class FactorResponsiveness
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        //close factor-data div
        $out = '</div>';
        
        if (empty($data)) {
            $out .= '<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">'.$endModel.'</div>';
            
            return $out;
        }
        
        $out .= '<div class="responsivenessfactor clearfix row" style="margin-top: 10px;">';
        
        $output  = '';
        $output .= self::helperResponsiveness("phone", $data, $factor);
        $output .= self::helperResponsiveness("tablet", $data, $factor);
        $output .= self::helperResponsiveness("notebook", $data, $factor);
        $output .= self::helperResponsiveness("desktop", $data, $factor);
        
        if(empty($output)){
            $output .= $endModel;
        }        
        
        $out .= $output;
        
        $out .= '</div>';
        
        return $out;
    }

	
	private static function helperResponsiveness($key, $data, $factor){
        $out = '';
        if (isset($data[$key]) && !empty($data[$key])) {
            if (isset($data[$key]['preview']) && !empty($data[$key]['preview'])) {

                $color = (isset($data[$key]['pass']) && $data[$key]['pass']) ? "#04B974" : "#F00101";
                $icon = (isset($data[$key]['pass']) && $data[$key]['pass']) ? "fa-check" : "fa-times";

                //var_dump($data[$key]['preview']);
                $out .= "  <div class='responsivenesswrapper col-xs-12 col-sm-12 col-md-6 col-lg-6'>"
                        . "     <div class='responsivenesstop responsiveness$key'>"
                        . "         <img src='" . $data[$key]['preview'] . "' alt='Website Preview: $key' />"
                        . "         <i class='fa $icon' style='background-color: $color'></i>"
                        . "     </div>"
                        . "     <div class='responsivenessdetails row'>"
                        . "         <div class='responsivenesslabel col-xs-12 col-sm-5 col-md-4 col-lg-4'>Browser:</div><div class='responsivenesslabelcontent col-xs-12 col-sm-7 col-md-8 col-lg-8'><img src='" . self::$imgfolder . "/icons/" . (strtolower(str_replace(' ', '', $data[$key]['browser']))) . ".png' alt='Browser Icon' /> " . (isset($data[$key]['browser']) ? $data[$key]['browser'] : "") . "</div>"
                        . "         <div class='responsivenesslabel col-xs-12 col-sm-5 col-md-4 col-lg-4'>OS:</div><div class='responsivenesslabelcontent col-xs-12 col-sm-7 col-md-8 col-lg-8'><img src='" . self::$imgfolder . "/icons/" . (strtolower(str_replace(' ', '', $data[$key]['os']))) . ".png' alt='OS Icon' /> " . (isset($data[$key]['os']) ? $data[$key]['os'] : "") . "</div>"
                        . "         <div class='responsivenesslabel col-xs-12 col-sm-5 col-md-4 col-lg-4'>Resolution:</div><div class='responsivenesslabelcontent col-xs-12 col-sm-7 col-md-8 col-lg-8'>" . $data[$key]['screen']["width"] . "x" . $data[$key]['screen']["height"] . "</div>"
                        . "         <div class='responsivenesslabel col-xs-12 col-sm-5 col-md-4 col-lg-4' title='Vertical Scrollbar'>V. Scrollbar:</div><div class='responsivenesslabelcontent col-xs-12 col-sm-7 col-md-8 col-lg-8'>" . ($data[$key]['scrollbar']["vertical"] ? "Yes" : "No") . "</div>"
                        . "         <div class='responsivenesslabel col-xs-12 col-sm-5 col-md-4 col-lg-4' title='Horizontal Scrollbar'>H. Scrollbar:</div><div class='responsivenesslabelcontent col-xs-12 col-sm-7 col-md-8 col-lg-8' style='" . ($data[$key]['scrollbar']["horizontal"] ? "color:" . $color : "") . "' >" . ($data[$key]['scrollbar']["horizontal"] ? "Yes" : "No") . "</div>"
                        . "         <div class='responsivenesslabel col-xs-12 col-sm-5 col-md-4 col-lg-4'>User Redirected:</div><div class='responsivenesslabelcontent col-xs-12 col-sm-7 col-md-8 col-lg-8'>" . ($data[$key]['redirected'] ? ("Yes - " . (isset($data[$key]['url']) ? $data[$key]['url'] : "")) : "No") . "</div>";
//                if (TRUE || (isset($data[$key]['redirected']) && $data[$key]['redirected'])) {
//                    $out .= "         <div class='responsivenesslabel'>Dst. URL:</div><div class='responsivenesslabelcontent' title='" . (isset($data[$key]['url']) ? $data[$key]['url'] : "") . "'>" . (isset($data[$key]['url']) ? $data[$key]['url'] : "") . "</div>";
//                }
                $out .= "      </div>"
                        . "</div>";
            }
        }
        return $out;
    }
	
}