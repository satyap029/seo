<?php

//require 'interface.eranker.php';


class FactorOngooglemaps
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $html = "";

        if (!empty($data)) {
            $html .= "<div class='external-onmaps' >";
            if (isset($data['latitude']) && isset($data['longitude'])) {
                if (isset($_GET['pdf'])) {
                    $html .= '<img src="https://maps.googleapis.com/maps/api/staticmap?zoom=15&size=950x250&maptype=roadmap'
                        . '&markers=color:red%7Clabel:G%7C' . $data['latitude'] . ',' . $data['longitude'] . '" id="map-googlemaps" width="100%">';
                } else {
                    $html .= "<div style='height: 250px;width:100%' id='map-googlemaps' data-gmapsmapready='false' data-googlemaps-latitude='"
                        . $data['latitude'] . "' data-googlemaps-longitude='" . $data['longitude']
                        . "' data-googlemaps-accuracy='' data-googlemaps-title='" . $data['name'] . "' ></div>";
                }
                //$html .= "<h5 style='margin-bottom: 0;'><strong>" . ucfirst($data['name']) . "</strong></h5>";
            }

            if (isset($data['photo']) && !empty($data['photo'])) {
                $htmlphoto = '
                <div style="background-color: #fafafa; background-image: url(\'' . $data['photo'] . '\'), url(\'' . self::$imgfolder . 'establishment-no-thumbnail-80px.png\'); border: 3px solid #DA4336;  position: absolute; top: -38px;  right: 0px; border-radius: 5px!important; width: 80px; height: 80px; background-repeat: no-repeat; background-size: cover; border-top-left-radius: 20px!important; background-position: center; border-bottom-right-radius: 20px !important;"></div>';
            } else {
                $htmlphoto = "";
            }
            if (isset($data['place_url']) && !empty($data['place_url'])) {
                $onclick = "onclick='window.open(\"" . $data['place_url'] . "\")'";
            } else {
                $onclick = "onclick='window.open(\"" . $data['website'] . "\")'";                
            }
            $html .= "<div $onclick style='cursor:pointer; position:relative; border-bottom: 1px solid #EEE;  background-color: #DA4336; color: white; padding: 5px; font-family: arial,sans-serif-light,sans-serif; font-size: 20px;'>"
                . $htmlphoto . $data['name'] .
                "</div>";

            $html .= "<div class='footer-map-onmaps row'>";
            if (isset($data['address']) && !empty($data['address'])) {
                $html .= "<div class='col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft'><strong>" . self::translate('address', $factor) . ":</strong></div>"
                    . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . $data['address'] . "<br/></div>";
            }

            //i'm not sure if is phones
            if (isset($data['phones']) && !empty($data['phones'])) {
                foreach ($data['phones'] as $value) {
                    $html .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft"><strong>' . self::translate("phone", $factor) . ':</strong></div>'
                        . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft"><img title="Phone" src="' . self::$factorCreateImageFolder . 'createimage.php?size=11&amp;transparent=1&amp;padding=0&amp;bgcolor=250&amp;textcolor=50&amp;text=' . urlencode(strrev(base64_encode($value))) . '" alt="Phone Number"> <br /></div>';
                }
            }

            if (isset($data['phone'])) {
                $html .= "<div class='col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft'><strong>" . self::translate('phone', $factor) . ":</strong></div>"
                    . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft"><img title="Phone" src="' . self::$factorCreateImageFolder . 'createimage.php?size=11&amp;transparent=1&amp;padding=0&amp;bgcolor=250&amp;textcolor=50&amp;text=' . urlencode(strrev(base64_encode($data['phone']))) . '" alt="Phone Number"></br></div>';
            }

            if (isset($data['reviews'])) {
                $html .= "<div class='col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft'><strong>" . self::translate('reviews', $factor) . ":</strong></div>"
                    . '<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft">' . $data['reviews'] . "<br/></div>";
            }

            if (isset($data['rating'])) {
                $html .= "<div class='col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft'><strong>" . self::translate('rating', $factor) . ":</strong></div>";
                $html .= "<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft'><span class='errankerreportficons-yellow'>";
                if ($data['rating'] !== 0) {
                    $html .= '<span>' . round($data['rating'], 1) . '</span> ';
                }
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= round($data['rating'])) {
                        $html .= '<i class="fa fa-star"></i>'; //fa-star-half-o
                    } else {
                        $html .= '<i class="fa fa-star-o"></i>';
                    }
                }
                $html .= "</span><br/></div>";
            }
            if (isset($data['website'])) {
                $html .= "<div class='col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft'><strong>" . self::translate('website', $factor) . ":</strong></div>"
                    . "<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft'><a href='" . $data['website'] . "' rel='nofollow' TARGET='_blank'>" . $data['website'] . "</a><br/></div>";
            }
            if (isset($data['description'])) {
                $html .= "<div class='col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft'><strong>" . self::translate('description', $factor) . ":</strong></div>"
                    . "<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft'>" . $data['description'] . "<br/></div>";
            }
            if (isset($data['industry'])) {
                $html .= "<div class='col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft'><strong>" . self::translate('industry', $factor) . ":</strong></div>"
                    . "<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft'>" . $data['industry'] . "<br/></div>";
            }

            if (isset($data['opened'])) {
                $html .= "<div class='col-xs-12 col-sm-2 col-md-2 col-lg-2 nopaddingleft'><strong>" . self::translate('opened', $factor) . ":</strong></div>"
                    . "<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10 nopaddingleft'>" . $data['opened'] . "<br/></div>";
            }

            $html .= "</div>";
            $html .= "</div>";
        } else {
            $html .= $endModel;
        }

        return $html;
    }

}