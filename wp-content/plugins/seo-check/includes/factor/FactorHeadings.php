<?php

//require 'interface.eranker.php';


class FactorHeadings
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '';

        if (!is_null($data)) {
            $obj = (object) $data;
            $out .= '<table class="report_headingtable">';

            for ($i = 1; $i <= 6; $i++) {
                $out .= $i == 1 ? '<tr class="report_headingtable_firstrow">' : '';
                $out .= '<th>&lt;H' . $i . '&gt;</th>';
                $out .= $i == 6 ? '<th>' . self::translate("total", $factor) . '</th></tr>' : '';
            }

            for ($i = 1; $i <= 6; $i++) {
                $out .= $i == 1 ? '<tr>' : '';
                $hd_i = 'h' . $i;
                $out .= '<td>' . (isset($obj->$hd_i) ? $obj->$hd_i : "?") . '</td>';
                $out .= $i == 6 ? '<td>' . (isset($obj->total) ? $obj->total : "?") . '</td></tr>' : '';
            }

            $out .= '</table>';

            if (isset($obj->tags) && !empty($obj->tags)) {
                $out .="<div class='headings_taglist'>";
                $count = 0;
                foreach ($obj->tags as $aTag) {
                    $aTag = (object) $aTag;
                    $out .="<div class='headings_tagitem headings_taglist_" . $aTag->type . "'>";
                    $out .="<div class='headingtype'>&lt;" . strtoupper($aTag->type) . "&gt;</div>";
                    $out .="<div class='headingspacer'></div>";
                    $out .=strip_tags($aTag->text);
                    $out .="</div>";
                    $count++;

                    if ($count == 10) {
                        $out .="<div class='headings_taglist_more' style='display:none'>"; // > 10 wrapper
                    }
                }

                if ($count >= 10) {
                    $out .="</div>"; // > 10 wrapper close
                    $out .="<a onclick='javascript:jQuery(\"#erreport .headings_taglist_more\").slideDown();jQuery(\"#erreport .headings_taglist_showmore\").hide();jQuery(\"#erreport .headings_taglist_showless\").show();' class='headings_taglist_showmore' style='display:block'><i class=\"fa fa-angle-down\"></i>  " . self::translate('showmore', $factor) . "</a>";
                    $out .="<a onclick='javascript:jQuery(\"#erreport .headings_taglist_more\").slideUp();jQuery(\"#erreport .headings_taglist_showmore\").show();jQuery(\"#erreport .headings_taglist_showless\").hide();' class='headings_taglist_showless' style='display:none'><i class=\"fa fa-angle-up\"></i> " . self::translate('showless', $factor) . "</a>";
                }

                $out .="</div>";
            }
        }

        return empty($out) ? false : '<div class="headings-style">' . $out . '</div>';
    }

}