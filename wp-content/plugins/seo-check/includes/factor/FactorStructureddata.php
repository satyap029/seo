<?php

class FactorStructureddata
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '<div class="row">';

        if (!empty($data) && is_array($data)) {
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft" style="margin-top: 6px;">'
                .'<table class="table table-condensed table-bordered tabletocollapsestructureddata">'
                .'<thead>'
                . '<tr class="structureddatatable">'
                . '<th class="minwidth"><b>'. self::translate('type', $factor) .'</b></th>'
                . '<th class="hidden-xs"><b>'. self::translate('key', $factor) .'</b></th>'
                . '<th class="hidden-xs"><b>'. self::translate('value', $factor) .'</b></th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>';
            $count = 0;
            foreach($data as $elements){
                if(gettype($elements) != "array"){
                    $notarray = true;
                    break;
                }
                $count ++;
                $out .= '<tr'. ($count > 5 ? ' class="hiderows"' : '') .'>';

                $out .= '<td class="minwidth">'. (isset($elements['type']) ? htmlentities($elements['type']) : self::translate('notavailable', $factor)) .'</td>';
                $out .= '<td class="hidden-xs">'. (isset($elements['key']) ? htmlentities($elements['key']) : self::translate('notavailable', $factor)) .'</td>';
                $out .= '<td class="hidden-xs">'. (isset($elements['value']) ? htmlentities($elements['value']) : self::translate('notavailable', $factor)) .'</td>';

                $out .= '</tr>';
            }

            $out .=      '</tbody>'
                . '</table>'
                . '</div>';

            if ($count > 5) {
                $out .= '<div class="despicableme col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'
                    . '<a class="showmorestructdata expandtablestructdata" href="javascript:void(0);" >'. html_entity_decode(stripslashes(self::translate('showmore', $factor))) .'</a>'
                    . '<a class="showlessstructdata expandtablestructdata" href="javascript:void(0);" >'. html_entity_decode(stripslashes(self::translate('showless', $factor))) .'</a>'
                    . '</div>';
            }

            if(isset($notarray) && $notarray === true){
                $out = '<div class="row">';
                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">' . implode(", ", $data) . '</div>';
            }
        }else{
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">' . self::translate("model_red", $factor) . '</div>';
        }

        $out .= '</div>';

        return $out;
    }
}