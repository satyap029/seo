<?php

//require 'interface.eranker.php';


class FactorMobileusability
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $totalFail = 0;
        $totalWarn = 0;
        $html = '';
        $htmlContentTable = "";
//
//        foreach ($data as $valueArray) {
//            if (isset($valueArray["fail-count"])) {
//                $totalFail = $valueArray["fail-count"];
//            }
//            if (isset($valueArray['warn-count'])) {
//                $totalWarn = $valueArray["warn-count"];
//            }
//            if (!isset($valueArray["warn-count"]) || !isset($valueArray["fail-count"])) {
//                $htmlContentTable .= "<tr>";
//                $first = TRUE;
//                foreach ($valueArray as $key => $value) {
//                    if ($first) {
//                        $icon = (strcasecmp($value, 'FAIL') === 0) ? "<i class='fa fa-times'></i>" : "<i class='fa fa-exclamation-triangle'></i>";
//                        if (strcasecmp($key, "warn-count") !== 0 || strcasecmp($key, "fail-count") !== 0) {
//                            $htmlContentTable .= "<td>" . $icon . "</td>";
//                        }
//                    } else {
//                        if (strcasecmp($key, "warn-count") !== 0 || strcasecmp($key, "fail-count") !== 0) {
//                            $htmlContentTable .= "<td>" . $value . "</td>";
//                        }
//                    }
//                    $first = FALSE;
//                }
//                $htmlContentTable .= "</tr>";
//            }
//        }
//
//        $html .= "<div class='row'>";
//        $html .= "<div class='col-lg-6'>";
//        $html .= "<h4 class='marginbottom0'><i class='fa fa-times'></i> Fails " . $totalFail . "</h4>";
//        $html .= "</div>";
//        $html .= "<div class='col-lg-6'>";
//        $html .= "<h4 class='marginbottom0'><i class='fa fa-exclamation-triangle'></i> Warns " . $totalWarn . "</h4>";
//        $html .= "</div>";
//        $html .= "</div>";
//
//        $html .= "<table class='table'>";
//        $html .= "<thead>";
//        $html .= "<tr>";
//        $html .= "<th>Severety</th>";
//        $html .= "<th>Description</th>";
//        $html .= "<th>Best Pratice</th>";
//        $html .= "</tr>";
//        $html .= "</thead>";
//        $html .= "<tbody>";
//        $html .= $htmlContentTable;
//        $html .= "</tbody>";
//
//        $html .= "</table>";
//
        return $endModel;
    }

}