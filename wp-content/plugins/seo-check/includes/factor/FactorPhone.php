<?php

//require 'interface.eranker.php';


class FactorPhone
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        if (empty($data)) {
            return self::translate("notfoundphones", $factor);
        }

        $out = '';
        if (isset($data) && !empty($data)) {
            foreach ($data as $singlePhone) {
                $country_code = $singlePhone['region'];
                $out .= "<img src='" . self::$imgfolder . "/flags/24/$country_code.png' style='height:24px;vertical-align:bottom;' alt='$country_code' title='$country_code' /> ";
                $type = ucfirst(strtolower(str_replace("_", " ", $singlePhone['type'])));
                $out .= '<img title="Type: ' . $type . '" src="' . self::$factorCreateImageFolder . 'createimage.php?size=11&amp;transparent=1&amp;padding=0&amp;bgcolor=250&amp;textcolor=50&amp;text=' . urlencode(strrev(base64_encode($singlePhone['phone']))) . '" alt="Website Phone Number"> <br />';
            }
        }

        return $out;
    }

}