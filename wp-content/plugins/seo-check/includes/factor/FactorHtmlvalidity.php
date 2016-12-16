<?php

//require 'interface.eranker.php';


class FactorHtmlvalidity
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '<div class="row">';

        if (!empty($data)) {
            if (!empty($data['error'])) {
                $out .= '<div class="col-xs-12 col-sm-3 col-md-1 col-lg-2 nopaddingleft">' . html_entity_decode(self::translate("error_text", $factor)) . '</div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-11 col-lg-10 nopaddingleft">' . $data['error'] . '<br /></div>';
            }

            if (!empty($data['warning'])) {
                $out .= '<div class="col-xs-12 col-sm-3 col-md-1 col-lg-2 nopaddingleft">' . html_entity_decode(self::translate("warning_text", $factor)) . '</div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-11 col-lg-10 nopaddingleft">' . $data['warning'] . '<br /></div>';
            }

            if (!empty($data['info'])) {
                $out .= '<div class="col-xs-12 col-sm-3 col-md-1 col-lg-2 nopaddingleft">' . html_entity_decode(self::translate("info_text", $factor)) . '</div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-11 col-lg-10 nopaddingleft">' . $data['info'] . '<br /></div>';
            }

            if (!empty($data['url'])) {
                $z = stripslashes(html_entity_decode(str_replace('%link_text', self::fixURL($data['url']) != false ? self::fixURL($data['url']) : $data['url'], self::translate("link_text", $factor))));
                $q = explode('<a href', $z);
                $a1 = $q[0];
                $a2 = isset($q[1]) ? '<a href' . $q[1] : '';
//                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'
//                            .stripslashes(html_entity_decode(str_replace('%link_text', self::fixURL($data['url']) != false ? self::fixURL($data['url']) : $data['url'], self::translate("link_text", $factor))))
//                        .'</div>';
                $out .= '<div class="col-xs-12 col-sm-3 col-md-1 col-lg-2 nopaddingleft">' . $a1 . '</div>'
                    . '<div class="col-xs-12 col-sm-9 col-md-11 col-lg-10 nopaddingleft">' . $a2 . '</div>';
            }
        }

        $out .= '</div>';

        return (!empty($data)) ? $out : $endModel;
    }

}