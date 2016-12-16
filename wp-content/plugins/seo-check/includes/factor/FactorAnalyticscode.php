<?php

//require 'interface.eranker.php';


class FactorAnalyticscode
    extends eRankerBase
    implements FactorDisplay
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '<div class="row">';

        $technologies = [
            (object)["name" => "Google Analytics", "url" => "Google Analytics.png", "position" => 1],
            (object)["name" => "Google Analytics Remarketing", "url" => "Google Remarketing.png", "position" => 2],
            (object)["name" => "Google Universal Analytics", "url" => "Google Universal Analytics.png", "position" => 3],
            (object)["name" => "Google Tag Manager", "url" => "Google Universal Analytics.png", "position" => 4],
            (object)["name" => "Google Analytics Experiments", "url" => "Google Universal Analytics.png", "position" => 5],
            (object)["name" => "Piwik", "url" => "piwik.png", "position" => 6],
            (object)["name" => "Chartbeat", "url" => "chartbeat.png", "position" => 7],
            (object)["name" => "getClicky", "url" => "", "position" => 8],
            (object)["name" => "Adobe Analytics Omniture SiteCatalyst", "url" => "Omniture Adobe Test and Target.png", "position" => 9],
            (object)["name" => "Mixpanel", "url" => "Mixpanel.png", "position" => 10],
            (object)["name" => "Quantcast", "url" => "Quantcast Measurement.png", "position" => 11],
            (object)["name" => "Bugsnag", "url" => "bugsnag.png", "position" => 12],
            (object)["name" => "ComScore", "url" => "comScore.png", "position" => 13],
            (object)["name" => "NewRelic", "url" => "New Relic.png", "position" => 14],
            (object)["name" => "Adobe Dynamic TagManagement", "url" => "Adobe Dynamic Tag Management.png", "position" => 15],
            (object)["name" => "Yahoo Web Analytics", "url" => "Yahoo Web Analytics.png", "position" => 16],
            (object)["name" => "Yandex.Metrica", "url" => "yandexmetrika.png", "position" => 17],
            (object)["name" => "Woopra", "url" => "woopra.png", "position" => 18],
            (object)["name" => "Webtrends", "url" => "WebTrends.png", "position" => 19],
            (object)["name" => "Webtrekk", "url" => "webtrekk.png", "position" => 20],
            (object)["name" => "Bugsense", "url" => "bugsense.png", "position" => 21],
            (object)["name" => "W3Counter", "url" => "w3counter.png", "position" => 22],
            (object)["name" => "TrackJS", "url" => "trackjs.png", "position" => 23],
            (object)["name" => "Tealeaf", "url" => "TeaLeaf.png", "position" => 24],
            (object)["name" => "Statcounter", "url" => "StatCounter.png", "position" => 25],
            (object)["name" => "Snoobi", "url" => "snoobi.png", "position" => 26],
            (object)["name" => "Site Meter", "url" => "site-meter.png", "position" => 27],
            (object)["name" => "Shiny Stat", "url" => "shinystat.png", "position" => 28],
            (object)["name" => "Kissmetrics", "url" => "KISSmetrics.png", "position" => 29],
            (object)["name" => "Reinvigorate", "url" => "reinvigorate.png", "position" => 30],
            (object)["name" => "Parse.ly", "url" => "parsely.png", "position" => 31],
            (object)["name" => "Optimizely", "url" => "optimizely.png", "position" => 32],
            (object)["name" => "Open Web Analytics", "url" => "open-web-analytics.png", "position" => 33],
            (object)["name" => "Netstat", "url" => "", "position" => 34],
            (object)["name" => "Mint", "url" => "mint.png", "position" => 35],
            (object)["name" => "Kampyle", "url" => "kampyle.png", "position" => 36],
            (object)["name" => "Jifare", "url" => "jirafe.png", "position" => 37],
            (object)["name" => "Intercom", "url" => "intercom.png", "position" => 38],
            (object)["name" => "IBM Coremetrics", "url" => "ibm-coremetrics.png", "position" => 39],
            (object)["name" => "GoStats", "url" => "gostats.png", "position" => 40],
            (object)["name" => "Gauges", "url" => "gauges.png", "position" => 41],
            (object)["name" => "Crazy Egg", "url" => "crazy-egg.png", "position" => 42],
            (object)["name" => "ClickTale", "url" => "clicktale.png", "position" => 43],
            (object)["name" => "CO2Stats", "url" => "co2stats.png", "position" => 44],
            (object)["name" => "AWStats", "url" => "awstats.png", "position" => 45],
            (object)["name" => "AT Internet XiTi", "url" => "at-internet-xiti.png", "position" => 46],
            (object)["name" => "Advanced Web Stats", "url" => "advanced-web-stats.png", "position" => 47],
            (object)["name" => "ClickHeat", "url" => "clickheat.png", "position" => 48],
            (object)["name" => "ConversionLab", "url" => "conversionlab.png", "position" => 49],
            (object)["name" => "Cross Pixel", "url" => "cross-pixel.png", "position" => 50],
            (object)["name" => "Gravity Insights", "url" => "gravity-insights.png", "position" => 51],
            (object)["name" => "Koego", "url" => "koego.png", "position" => 52],
            (object)["name" => "Netmonitor", "url" => "netmonitor.png", "position" => 53],
            (object)["name" => "Oracle Recomendations On Demand", "url" => "oracle-recommendations-on-demand.png", "position" => 54]
        ];

        if (!empty($data)) {
            foreach ($data as $objdata) {
                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marginbottom15">';

                if (isset($objdata['code_type'])) {
                    $imglink = '';

                    $isin = false;
                    $name = '';

                    foreach ($technologies as $tehno) {
                        if ($tehno->position === $objdata['code_type']) {
                            $imglink .= $tehno->url;
                            $isin = true;
                            $name .= $tehno->name;
                            break;
                        }
                    }

                    if ($isin === false) {
                        $imglink = 'eranker.png';
                    }

                    $tagimg = '';

                    if (!empty($imglink)) {
                        $tagimg .= '<img src="' . self::$imgfolder . 'technologies/' . $imglink . '"  height="22" width="23" style="margin-right: 10px;">';
                    }

                    $out .= '<div class="imgandtitle">' . $tagimg . '' . $name . '</div>';

                    if (isset($objdata['code'])) {
                        $out .= '<div class="codesee">' . self::translate("analytics_code", $factor) . ' ' . $objdata['code'] . '</div>';
                    }
                }

                $out .= '</div>';
            }
        } else {
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">' . html_entity_decode(stripslashes(self::translate("model_red", $factor))) . '</div>';
        }

        $out .= '</div>';

        return $out;
    }
}