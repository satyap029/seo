<?php

class FactorBacklinks
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '';
        $chartsData = array();

        $chartsData[] = array(array("id" => "image", "title" => "Images"), array("id" => "text", "title" => "Text"),);
//        $chartsData[] = array(array("id" => "pages", "title" => "Unique Pages"), array("id" => "refpages", "title" => "Referal Pages"));
        $chartsData[] = array(array("id" => "nofollow", "title" => "NoFollow"), array("id" => "dofollow", "title" => "DoFollow"));
        $chartsData[] = array(array("id" => "sitewide", "title" => "Site Wide"), array("id" => "not_sitewide", "title" => "Not Site Wide"));
        $chartsData[] = array(array("id" => "links_external", "title" => "Outbound links"), array("id" => "links_internal", "title" => "Internal links"));
        $chartsData[] = array(array("id" => "redirect", "title" => "Redirect"), array("id" => "canonical", "title" => "Canonical"));
        $chartsData[] = array(array("id" => "alternate", "title" => "Alternate"), array("id" => "html_pages", "title" => "HTML Pages"));

        //array('gov' => 'Gov', 'edu' => 'Edu', 'rss' => 'Rss'),

        $charts = "";
        $pdf_charts ="";
        foreach ($chartsData as $chartNumber => $singleChart) {
            if (isset($data[$singleChart[0]["id"]]) && isset($data[$singleChart[1]["id"]]) && ($data[$singleChart[0]["id"]] + $data[$singleChart[1]["id"]]) > 0) {
                $charts .= "<div class='col-xs-12 col-sm-12 col-md-6 col-lg-4'>"
                    . "<div style='width: 100%;margin: 0 auto' class='backlinkchart' data-chartready='false' "
                    . "data-id1='" . $singleChart[0]["id"] . "' data-id2='" . $singleChart[1]["id"] . "' "
                    . "data-title1='" . $singleChart[0]["title"] . "' data-title2='" . $singleChart[1]["title"] . "' "
                    . "data-value1='" . $data[$singleChart[0]["id"]] . "'  data-value2='" . $data[$singleChart[1]["id"]] . "'></div>"
                    . "</div><!-- .backlinkchartwrapper -->";



                if (isset($_GET["pdf"])) {
                    $pdf_charts .= '<div class="multiple-pdf-charts">';
                    $total = $data[$singleChart[0]["id"]] + $data[$singleChart[1]["id"]];

                    $plots = array(
                        $singleChart[0]["id"] => (100*$data[$singleChart[0]["id"]]) / $total,
                        $singleChart[1]["id"] => (100*$data[$singleChart[1]["id"]]) / $total,
                    );

                    $pdf_charts .= sprintf('<h3>%s vs %s<br><small>Total: %d</small></h3>',
                        $singleChart[0]["title"], $singleChart[1]["title"], $total);
                    $pdf_charts .= self::__draw_pie_chart($plots, 30);

                    $pdf_charts .= '</div>';
                }
            }
        }
        $charts .= $pdf_charts;

//        if (is_array($data)) {
//            foreach ($pairs as $pair) {
//                $chart = '<div class="hidden piechart" data-labels="true" data-donut="false" data-pos-values="true">';
//                foreach ($pair as $key => $label) {
//                    $chart .= '<div class="data-chart" id="' . $key . '" data-label="' . $label . '" data-value="' . $data[$key] . '"></div>';
//                }
//                $chart .= '</div>';
//                $out .= $chart;
//            }
//        }

        $translate1 = self::translate("totalbacklinks", $factor);

        $translate2 = self::translate("totalhefpage", $factor);
        
        if(empty($data['total'])){
            $data['total'] = 0;
        }
        
        if(empty($data['refpages'])){
            $data['refpages'] = 0;
        }
        
        $top = "<h4 class='marginbottom0'>" . html_entity_decode(sprintf(stripslashes($translate1), stripslashes($data['total']))) . "</h4>"
            . html_entity_decode(sprintf(stripslashes($translate2), stripslashes($data['refpages'])))
            . "</div><div class='clearfix col factor-special'>"; // trick div

        $domain = $report->url;


        return $top
        . '<div class="row" id="backlinkscharts">' . $out . '</div>'
        . '<div id="backlinkspie" class="row">' . $charts . '</div><!-- #backlinkspie -->'
        . '<div class="poweredbyout" onclick="window.open(\'https://ahrefs.com/site-explorer/overview/subdomains?target=' . urlencode($domain) . '\')"  style="display:block;text-align:center;" > '
        . '<span>Check deep link analysis on ahrefs</span><br /><img src="' . self::$imgfolder . 'ahrefs_logoSmall.png" alt="ahrefs">'
        . '</div>';
    }

}