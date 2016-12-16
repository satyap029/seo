<?php

class FactorAdwords
    extends eRankerBase
    implements FactorDisplay
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '<div class="row">';

        $technologies = [
            (object)["name" => "Google AdWords Conversion (conversion.js)", "url" => "adwords.png", "position" => 1],
            (object)["name" => "Google AdWords Remarketing (conversion.js)", "url" => "adwords.png", "position" => 2],
            (object)["name" => "Asynchronous AdWords Remarketing Tag (conversion_async.js)", "url" => "adwords.png", "position" => 3],
            (object)["name" => "Google AdWords Phone Conversion (loader.js)", "url" => "adwords.png", "position" => 4],
            (object)["name" => "Google DoubleClick", "url" => "adwords.png", "position" => 5],
            (object)["name" => "Google DoubleClick Floodlight", "url" => "adwords.png", "position" => 6]
        ];

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marginbottom15">';
                $imglink = '';

                $isin = false;
                $name = '';

                foreach ($technologies as $tehno) {
                    if ($tehno->position === $value["google_adword"]) {
                        $imglink .= $tehno->url;
                        $isin = true;
                        $name .= $tehno->name;
                        break;
                    }
                }

                if ($isin === false) {
                    $imglink = 'adwords.png';
                }

                $tagimg = '';

                if (!empty($imglink)) {
                    $tagimg .= '<img src="' . self::$imgfolder . 'technologies/' . $imglink . '"  height="22" width="23" style="margin-right: 10px;">';
                }

                $out .= '<div class="imgandtitle">' . $tagimg . '' . $name . '</div>';


                $out .= '</div>';
            }
        } else {
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">' . html_entity_decode(stripslashes(self::translate("model_red", $factor))) . '</div>';
        }

        $out .= '</div>';

        return $out;
    }

}

