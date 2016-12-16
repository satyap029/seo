<?php

//require 'interface.eranker.php';


class FactorAnchorstext
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $html = "";
        $count = 0;
        $attr = '';
        $displayAtNull = '';


        $pdf_charts = "";
        if (isset($_GET["pdf"])) {
            $pdf_charts .= '<div id="pdf-chart-backlinks">';
            $plots = array();
            $total = 0;
            foreach ($data['anchors'] as $anchors) {
                $total += (int) $anchors['backlinks'];
            }

            foreach ($data['anchors'] as $anchors) {
                $label = $anchors['anchor'];
                $percent = (100 * (int) $anchors['backlinks']) / $total;
                $plots[$label] = $percent;
            }

            $pdf_charts .= self::__draw_pie_chart($plots, 60);
            $pdf_charts .= '</div>';
        }

        if (!empty($data['anchors'])) {
            $count = count($data['anchors']);
            foreach ($data['anchors'] as $key => $value) {
                $attr .= "data-anchor-" . $key . "='" . $value['anchor'] . "' data-backlinks-" . $key . "='" . $value['backlinks'] . "' ";
            }
        } else {
            $displayAtNull .= self::translate("cannotfindanchors", $factor);
            $_SESSION['nullDisplay'] = "nullDisplay";
        }

        if (isset($_SESSION['nullDisplay']) && strcasecmp($_SESSION['nullDisplay'], "nullDisplay") === 0) {
            return $html . "<div class='clearfix row noselect anchorsconstruct'><div class='anchorschart col-xs-12 col-sm-12' id='anchorschart' data-chartready='false' data-totali=" . $count . " " . $attr . ">" . $displayAtNull . "</div></div>";
        }

        //close factor-data div
        return $html . "</div>" . $pdf_charts
        . "<div class='clearfix row noselect anchorsconstruct'>"
        . "<div class='anchorschart col-xs-12 col-sm-12' data-chartready='false' data-totali=" . $count . " " . $attr . " id='anchorschart'>"
        . $displayAtNull
        . "</div><!-- #anchorschart -->"
        . "</div>";
    }

}