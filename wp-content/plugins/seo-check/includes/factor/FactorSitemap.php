<?php

//require 'interface.eranker.php';


class FactorSitemap
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '';

        if (!empty($data)) {
            if ($data['status']) {
                $out .= '<span>' . (is_null($endModel) ? $data['status'] : $endModel) . '</span><br /><br />';

                $out .= '<div class="trickydiv"><ul class="sitemaptoggle sitemaptoggledown" style="text-overflow: ellipsis; white-space: nowrap;">';

                $count = 0;

                foreach ($data['sitemap'] as $value) {
                    $count ++;

                    if ($count == 5) {
                        $out .= '<li class="lastnotoggle">';
                    } else {
                        $out .= '<li>';
                    }

                    $out .= '<a href="' . (self::fixURL($value) !== false ? self::fixURL($value) : $value) . '" target="_blank">' . $value . '</a>';
                    $out .= '</li>';
                }

                $out .= '</ul></div>';

                if ($count > 5) {
                    $out .= '<a class="showmoresitemap" href="javascript:void(0);" onclick="if(jQuery(\'.sitemaptoggle\').hasClass(\'sitemaptoggledown\')){sitemapToggle(\' '. html_entity_decode(self::translate("show-less", $factor)) . '\');}else if(jQuery(\'.sitemaptoggle\').hasClass(\'sitemaptoggleup\')){sitemapToggle(\' '. html_entity_decode(self::translate("show-more", $factor)).'\')}"> '
                        . html_entity_decode(self::translate("show-more", $factor)) .'</a>';
                }
            } else {
                $out .= self::translate("model_neutral", $factor);
            }
        } else {
            $out .= self::translate("model_red", $factor);
        }

        return $out;
    }

}