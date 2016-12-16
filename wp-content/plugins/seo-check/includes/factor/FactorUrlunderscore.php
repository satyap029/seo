<?php

//require 'interface.eranker.php';


class FactorUrlunderscore
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '<div class="row guiurlunderscore">';

        $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">' . $endModel . '</div>';

        if(isset($data['links']) && !empty($data['links']) && isset($data['count']) && $data['count'] > 0){
            $i = 0;
            foreach($data['links'] as $link){
                $i++;
                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft margin-bottom-10 linksurlunderscore '. ($i > 5 ? 'urlunderscorehide' : '') .'"><a href="'. (self::fixURL($link) !== false ? self::fixURL($link) : $link) .'" target="_blank" class="breakwordlink">' . $link . '</a></div>';
            }

            if($i > 5){
                $out .= '<div class="despicableme col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'
                    . '<a class="urlunderscoreshowmore hideunhidelink" href="javascript:void(0);">'. html_entity_decode(stripslashes(self::translate('showmore', $factor))) .'</a>'
                    . '<a class="urlunderscoreshowless hideunhidelink" href="javascript:void(0);">'. html_entity_decode(stripslashes(self::translate('showless', $factor))) .'</a>'
                    . '</div>';
            }
        }

        $out .= '</div>';

        return $out;
    }

}