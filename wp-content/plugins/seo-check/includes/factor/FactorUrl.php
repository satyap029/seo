<?php

//require 'interface.eranker.php';


class FactorUrl
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {

        $out = '';

        if (!empty($data)) {

            $out .= '<a href="' . $data . '" target="_blank">' . $data . '</a>';
        } else {
            $out = $endModel;
        }


        return $out;
    }

}