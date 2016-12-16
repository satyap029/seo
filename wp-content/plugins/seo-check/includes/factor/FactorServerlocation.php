<?php

//require 'interface.eranker.php';


class FactorServerlocation
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '';

        $latitude = !empty($data) && isset($data['latitude']) ? $data['latitude'] : null;
        $longitude = !empty($data) && isset($data['longitude']) ? $data['longitude'] : null;
        $ip = !empty($data) && isset($data['ip']) ? $data['ip'] : null;

        $host = !empty($data) && isset($data['host']) ? $data['host'] : null;
        $city = !empty($data) && isset($data['city']) ? $data['city'] : null;
        $state = !empty($data) && isset($data['state']) ? $data['state'] : null;
        $country_name = !empty($data) && isset($data['country_name']) ? $data['country_name'] : null;
        $zip = !empty($data) && isset($data['zip']) ? $data['zip'] : null;
        $country_code = !empty($data) && isset($data['country_code']) ? $data['country_code'] : null;
        $accuracy_radius = !empty($data) && isset($data['accuracy_radius']) ? $data['accuracy_radius'] : null;
        $timezone = !empty($data) && isset($data['timezone']) ? $data['timezone'] : null;


        $content = "";
        if (!empty($host)) {
            $content .= "<h4 style='margin-bottom: 0;'><strong>" . ucfirst($host) . "</strong></h4>";
        }

        if (!empty($ip)) {
            $content .= "<strong>" . self::translate('serverip', $factor) . ":</strong> " . $ip . "<br />";
        }
        if (!empty($city)) {
            $content .= "<strong>" . self::translate('city', $factor) . ":</strong> " . $city . "<br />";
        }
        if (!empty($state)) {
            $content .= "<strong>" . self::translate('stateserverlocation', $factor) . ":</strong> " . $state . "<br />";
        }
        if (!empty($zip)) {
            $content .= "<strong>" . self::translate('zipcode', $factor) . ":</strong> " . $zip . "<br />";
        }
        if (!empty($country_code)) {
            $content .= "<strong>" . self::translate('countryserverlocatio', $factor) . ":</strong> <img src='" . self::$imgfolder . "/flags/24/$country_code.png' style='height: 16px;vertical-align: sub;' alt='$country_code' /> " . $country_name . "<br />";
        }
        if (!empty($timezone)) {
            $content .= "<strong>" . self::translate('timezone', $factor) . ":</strong> " . $timezone;
        }
//        if (!isset($_GET['pdf']) && empty($_GET['pdf'])) {
//            $idMap = "mapserverlocation";
//        } else {
//            $idMap = 'emptymap';
//        }
        if (isset($_GET['pdf'])) {
            $out .= '<img src="https://maps.googleapis.com/maps/api/staticmap?zoom=9&size=950x450&maptype=roadmap'
                . '&markers=color:red%7Clabel:G%7C' . str_replace(",", ".", $latitude) . ',' . str_replace(",", ".", $longitude) . '" id="mapserverlocation" width="100%">'
                . $content;
        } else {
            $out .= '<div id="mapserverlocation" data-mapready="false" style="height: 450px;width: 100%;" data-serverlocation-title="' . $host
                . '" data-serverlocation-accuracy="' . $accuracy_radius . '" data-serverlocation-latitude="' . str_replace(",", ".", $latitude)
                . '" data-serverlocation-longitude="' . str_replace(",", ".", $longitude) . '" >' . $content . '</div>';
        }

        return !empty($data) ? $out : self::translate('servernotfound', $factor);
    }

}