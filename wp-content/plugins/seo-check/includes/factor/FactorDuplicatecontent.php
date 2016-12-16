<?php

//require 'interface.eranker.php';


class FactorDuplicatecontent
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $outString = '';

        $urlsString = '';

        if (isset($data) && !empty($data)) {
            $outString = '' . self::translate("wefound", $factor) . ' <strong>' . count($data) . ' </strong> ' . self::translate("websitecontent", $factor) . '<hr></hr>';
            foreach ($data as $value) {
                $title = $value;
                if (!empty($title)) {
                    $urlsString .= "<li><a href='". (self::fixURL($title) !== false ? self::fixURL($title) : $title) ."' target='_blank'>". $title ."</a><br /> </li>";
                }
            }
            $outString .= "<ul>$urlsString</ul>";
        }

        return !empty($outString) ? $outString : self::translate('notfindcontent', $factor);
    }

}