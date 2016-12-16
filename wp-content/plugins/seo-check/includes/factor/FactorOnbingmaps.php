<?php


class FactorOnbingmaps
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $html = "<div class='row'>";

        if(!empty($data) && !empty($data['latitude']) && !empty($data['longitude']) && !empty($data['address']) && !empty($data['name'])){
            $address = $data['address'];
            $latitude = $data['latitude'];
            $longitude = $data['longitude'];  
            
            $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">';
            
                $html .= '<div id="bingmapviewer">';

                    $html .= '<iframe width="100%" height="400" scrolling="no" frameborder="0" src="http://www.bing.com/maps/embed/viewer.aspx?v=3&cp='. $latitude .'~'. $longitude .'&lvl=15&w=800&h=400&sty=r&typ=d&pp=~'. $address .'~'. $latitude .'~'. $longitude .'&ps=&dir=&mkt=en-us&src=SHELL&form=BMEMJS"></iframe>';
                    
                    $html .= '<div class="bing-prop"><a target="_blank" href="http://www.bing.com/maps/?cp='. $latitude .'~'. $longitude .'&amp;sty=r&amp;lvl=9&amp;sp=&amp;mm_embed=map">View Larger Map</a>&nbsp; |&nbsp; <a target="_blank" href="http://www.bing.com/maps/?cp='. $latitude .'~'. $longitude .'&amp;sty=r&amp;lvl=9&amp;rtp=~pos.'. $latitude .'_'. $longitude .'____&amp;mm_embed=dir">Get Directions</a>&nbsp; |&nbsp; <a target="_blank" href="http://www.bing.com/maps/?cp='. $latitude .'~'. $longitude .'&amp;sty=b&amp;lvl=18&amp;sp=&amp;mm_embed=be">View Bird\'s Eye</a></div>';
                    
                $html .= '</div>';
            
            $html .= '</div>';  
            
            $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">';
                $html .= '<div class="row">';
                
                    if(!empty($data['image'])){
                        $image = $data['image'];
                        $out = '';
                        
                        if(@file_get_contents($image) !== false){
                            // Read image path, convert to base64 encoding
                            $imageData = base64_encode(file_get_contents($image));
                            //Format the image SRC:  data:{mime};base64,{data};
                            $src = 'data: image/png;base64,'.$imageData;
                            $chart = '<img src="' . $src . '" class="">';

                            $out .= $chart;                            
                        }
                        
                        $html .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">';
                            if(!empty($out)){
                                $html .= '<div class="bingimage">'. $out .'</div>';
                            }
                        $html .= '</div>';

                        $html .= '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">';
                        
                            if(!empty($data['name'])){
                                $html .= '<div class="inside-details-bing font-bold">'.$data['name'] .'</div>';
                            }
                            
                            if(!empty($data['website'])){
                                $html .= '<div class="inside-details-bing"><a href="'.(strpos($data['website'],"http") !== false ? $data['website'] : 'http://'.$data['website']).'" target="_blank">'.$data['website'] .'</a></div>';
                            }
                            
                            if(!empty($data['address'])){
                                $html .= '<div class="inside-details-bing">'.$data['address'] .'</div>';
                            }
                            
                            if(!empty($data['phone'])){
                                $html .= '<div class="inside-details-bing">'
                                        . '<img title="Phone" src="' . self::$factorCreateImageFolder . 'createimage.php?size=11&amp;transparent=1&amp;padding=0&amp;bgcolor=250&amp;textcolor=50&amp;text=' . urlencode(strrev(base64_encode($data['phone']))) . '" alt="Phone Number">' 
                                    .'</div>';
                            }
                            
                        $html .= '</div>';
                    }else{
                        $html .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">';
                            
                            $html .= '<div class="bingimage"><img src="'.self::$imgfolder . 'technologies/'.'bing.png"></div>';
                            
                        $html .= '</div>';
                        
                        $html .= '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">';
                        
                            if(!empty($data['name'])){
                                $html .= '<div class="inside-details-bing font-bold">'.$data['name'] .'</div>';
                            }
                            
                            if(!empty($data['website'])){                                
                                $html .= '<div class="inside-details-bing"><a href="'.(strpos($data['website'],"http") !== false ? $data['website'] : 'http://'.$data['website']).'" target="_blank">'.$data['website'] .'</a></div>';
                            }
                            
                            if(!empty($data['address'])){
                                $html .= '<div class="inside-details-bing">'.$data['address'] .'</div>';
                            }
                            
                            if(!empty($data['phone'])){
                                $html .= '<div class="inside-details-bing">'
                                        . '<img title="Phone" src="' . self::$factorCreateImageFolder . 'createimage.php?size=11&amp;transparent=1&amp;padding=0&amp;bgcolor=250&amp;textcolor=50&amp;text=' . urlencode(strrev(base64_encode($data['phone']))) . '" alt="Phone Number">' 
                                    .'</div>';
                            }   
                            
                        $html .= '</div>';
                    }
                    
                $html .= '</div>';
            $html .= '</div>';
        }else{
            $html .= "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft'>".$endModel."</div>";
        }    

        $html .= '</div>';
        
        return $html;
    }
}