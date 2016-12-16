<?php

//require 'interface.eranker.php';


class FactorSpeedanalysis
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        if (empty($data)) {
            return $model;
        }
        if (!isset($data['grades']) || empty($data['grades'])) {
            return self::translate('Speed Anlysis failed to run');
        }
        $factors_labels = array(
            'numreq' => self::translate('numreq', $factor),
            'expires' => self::translate('expires', $factor),
            'jsbottom' => self::translate('jsbottom', $factor),
            'xhr' => self::translate('xhr', $factor),
            'compress' => self::translate('compress', $factor),
            'favicon' => self::translate('favicon', $factor),
            'csstop' => self::translate('csstop', $factor),
            'dns' => self::translate('dns', $factor),
            'mindom' => self::translate('mindom', $factor),
            'cdn' => self::translate('cdn', $factor),
            'cookiefree' => self::translate('cookiefree', $factor),
            'emptysrc' => self::translate('emptysrc', $factor),
            'imgnoscale' => self::translate('imgnoscale', $factor),
            'redirects' => self::translate('redirects', $factor),
            'dupes' => self::translate('dupes', $factor),
            'no404' => self::translate('no404', $factor),
            'xhrmethod' => self::translate('xhrmethod', $factor),
            'mincookie' => self::translate('mincookie', $factor),
            'etags' => self::translate('etags', $factor),
        );


        $statsNames = array(
            'doc' => 'HTML',
            'js' => 'JavaScript',
            'css' => 'CSS',
            'image' => 'Image',
            'json' => 'Json',
            'redirect' => 'Redirect'
        );

        //style='width: 50%; height: 300px;margin: 0 auto; float: left;'
        $html = "

            <h4 class='marginbottom0'>" . self::translate('overallscore', $factor) . ": <b>" . $data['score'] . "</b> " . self::translate('outof', $factor) . " 100</h4>
            <p>" . self::translate('pagetotalof', $factor) . " <b>" . $data['requests'] . "</b> " . self::translate('httprequest', $factor) . " <b>" . round($data['size'] / 1024) . "Kb</b> " . self::translate('withemptycache', $factor) . "</p>

            <div class='row' id='speedanalysispiegroup'>
                <div id='speedanalysispiechartsrequest' class='col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft' data-chartready='false'></div>
                <div id='speedanalysispiechartsweight' class='col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft' data-chartready='false'></div>
            </div><!-- #speedanalysispiegroup -->

            <script type='text/javascript'>

                function speedanalysispiechartsweight() {                
                    var datachart = [";

                    $countStats = 0;

                    foreach ($statsNames as $statKey => $statName) {
                        if (!isset($data['stats']) || !isset($data['stats'][$statKey]) || !isset($data['stats'][$statKey]['w'])) {
                            continue;
                        }
                        $statValue = max(0, round($data['stats'][$statKey]['w'] / 1024));
                        if ($statValue == 0) {
                            continue;
                        }
                        if ($countStats > 0) {
                            $html .= ",";
                        }

                        $html .= "{name: '$statName', y: " . $statValue . ", sliced: " . ($countStats > 0 ? "false" : "true") . ", selected: " . ($countStats > 0 ? "false" : "true") . " }";
                        $countStats++;

                    }


                    $html .= "
                        ];

                    if(datachart.length > 0){
                        $('#speedanalysispiechartsweight[data-chartready=\"false\"]').highcharts({
                            chart: {
                                animation: false,
                                plotBackgroundColor: 'transparent',
                                plotBorderWidth: null,
                                plotShadow: false,
                                backgroundColor: 'transparent'
                            },
                            title: {
                                text: 'Requests Size',
                                margin: 0
                            },
                            colors: ['#FF9000', '#0281C4', '#04B974',  '#F45B5B', '#444444', '#5F65E0'],
                            tooltip: {
                                pointFormat: '{series.name}: <b>{point.y}Kb ({point.percentage:.1f}%)</b>'
                            },
                            credits: {
                                enabled: false
                            },
                            legend: {
                                layout: 'vertical',
                                align: 'right',
                                verticalAlign: 'bottom',
                                enabled: false
                            },
                            exporting:{
                                enabled: false
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                        enabled: true,
                                        format: '<b>{point.name}</b>: {point.y}Kb',
                                        color: 'white',
                                        distance: 20,
                                        color: 'black'
                                    }
                                }
                            },
                            series: [{
                                type: 'pie',
                                name: 'Request Size',
                                showInLegend: true,
                                data: datachart
                            }]
                        });

                        $('#speedanalysispiechartsweight').attr('data-chartready', 'true');
                    }
                }

                function speedanalysispiechartsrequest() {
                    var datachart = [";

                    $countStats = 0;

                    foreach ($statsNames as $statKey => $statName) {        
                        if (!isset($data['stats']) || !isset($data['stats'][$statKey]) || !isset($data['stats'][$statKey]['r'])) {
                            continue;
                        }
                        $statValue = max(0, round($data['stats'][$statKey]['r']));
                        if ($statValue == 0) {
                            continue;
                        }
                        if ($countStats > 0) {
                            $html .= ",";
                        }

                        $html .= "{name: '$statName', y: " . $statValue . ", sliced: " . ($countStats > 0 ? "false" : "true") . ", selected: " . ($countStats > 0 ? "false" : "true") . " }";
                        $countStats++;
                    }

                    $html .= "
                                ];

                    if(datachart.length > 0){
                        $('#speedanalysispiechartsrequest[data-chartready=\"false\"]').highcharts({
                            chart: {
                                animation: false,
                                plotBackgroundColor: 'transparent',
                                plotBorderWidth: null,
                                plotShadow: false,
                                backgroundColor: 'transparent'
                            },
                            title: {
                                text: 'HTTP Requests',
                                margin: 0
                            },
                            colors: ['#FF9000', '#0281C4', '#04B974',  '#F45B5B', '#444444', '#5F65E0'],
                            tooltip: {
                                pointFormat: '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>'
                            },
                            credits: {
                                enabled: false
                            },
                            legend: {
                                layout: 'vertical',
                                align: 'right',
                                verticalAlign: 'bottom',
                                enabled: false
                            },
                            exporting:{
                                enabled: false
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                        enabled: true,
                                        format: '<b>{point.name}</b>: {point.y}',
                                        color: 'white',
                                        distance: 20,
                                        color: 'black'
                                    }
                                }
                            },
                            series: [{
                                type: 'pie',
                                name: 'HTTP Requests',
                                showInLegend: true,
                                data: datachart
                            }]
                        });

                        $('#speedanalysispiechartsrequest').attr('data-chartready', 'true');
                    }
                }
             </script>";

        foreach(array("w", "r") as $chart) {
            $pdf_charts = "";
            if (isset($_GET["pdf"])) {

                $total = 0;

                foreach ($statsNames as $statKey => $statName) {
                    if (!isset($data['stats']) || !isset($data['stats'][$statKey]) || !isset($data['stats'][$statKey][$chart])) {
                        continue;
                    }
                    $statValue = max(0, round($data['stats'][$statKey][$chart] / ($chart == "w" ? 1024 : 1)));
                    if ($statValue == 0) {
                        continue;
                    }

                    $total += (int) $statValue;

                }

                $pdf_charts .= '<div class="pdf-chart-speed">';
                $pdf_charts .= '<h3>';
                switch ($chart) {
                    case "w": {
                        $pdf_charts .= html_entity_decode(self::translate("request-size", $factor));
                        break;
                    }
                    case "r": {
                        $pdf_charts .= html_entity_decode(self::translate("http-request", $factor));
                        break;
                    }
                }
                $pdf_charts .= '</h3>';

                $plots = array();


                foreach ($statsNames as $statKey => $statName) {
                    if (!isset($data['stats']) || !isset($data['stats'][$statKey]) || !isset($data['stats'][$statKey][$chart])) {
                        continue;
                    }
                    $statValue = max(0, round($data['stats'][$statKey][$chart] / ($chart == "w" ? 1024 : 1)));
                    if ($statValue == 0) {
                        continue;
                    }

                    $label = $statName;
                    $percent = (100 * (int) $statValue) / $total;
                    $plots[$label] = $percent;
                }

                $pdf_charts .= self::__draw_pie_chart($plots, 70);
                $pdf_charts .= '</div>';
                $html .= $pdf_charts;
            }
        }

        foreach ($data['grades'] as $label => $grade) {
            $invgrade = min(98, max(0, 100 - $grade));  //grade is inversed


            if ($grade < 31) {
                $color = "#FE0000";
                $icon = 'fa-times';
            } else {
                if ($grade < 71) {
                    $icon = 'fa-minus';
                    $color = "#FF9000";
                } else {
                    $icon = 'fa-check';
                    $color = "#04B974";
                }
            }

            $html .= '<div class="row">';
            $html .= '<div class="col-sm-12 col-md-5 speed-label">' . $factors_labels[$label] . '</div>'
                . '<div class="col-sm-12 col-md-7 speed-progress">' . '<i class="fa ' . $icon . '" style="background-color: ' . $color . '"></i>'
                . '<div class="progress-wrapper" style="background-color: ' . $color . '"><div class="load-progress-grade" style="width:' . $invgrade . '%">&nbsp;</div></div>'
                . '<small>' . $grade . '%</small></div>';
            //. '<div class="col can-float speed-grade" style="color: ' . $color . '" >' . $grade . '%</div>';
            $html .= '<div class="clearfix"></div>'
                . '</div>';
        }
        return $html;
    }

}