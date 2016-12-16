<?php

class FactorDefault 
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        
        return is_null($endModel) ? $data : $endModel;
    }

}