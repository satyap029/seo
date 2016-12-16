<?php

//require 'interface.eranker.php';


class FactorImgemptyalt
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '';
        if (!empty($data)) {

            if (!empty($data['total']) && $data['total'] > 0) {
                $out .= '<div>' . str_replace('%total', $data['total'], html_entity_decode(self::translate("model_orange", $factor))) . '</div>';

                $url_href = '';
                foreach ($data['image'] as $value) {
                    if (strpos($value, "://")) {
                        $domain = explode('/', $value);
                        $url_href .= $domain[2];
                        break;
                    }
                }

                if ($url_href === '') {
                    $url_href = $report->url;
                }

                $out .= '<div class="trickydiv"><ul style="text-overflow: ellipsis;white-space: nowrap; max-width: 90%;" class="imgalttoggle imgalttoggledown">';

                if (!empty($data['image'])) {
                    $count = 0;
                    foreach ($data['image'] as $value) {
                        $count ++;
                        if ($count == 5) {
                            $out .= '<li class="lastnotoggle">';
                        } else {
                            $out .= '<li>';
                        }

                        if (strpos($value, "://") === false) {
                            $url_href = rtrim($url_href, '/');
                            $value = ltrim($value, '/');
                            $url = $url_href . '/' . $value;
                        } else {
                            $url = $value;
                        }

                        $out .= '<a href="' . (self::fixURL($url) !== false ? self::fixURL($url) : $url) . '" target="_blank">' . $value . '</a>';
                        $out .= '</li>';
                    }
                }

                $out .= '</ul></div>';

                if ($count > 5) {
                    $out .= '<a class="showmoreimgalt" href="javascript:void(0);" onclick="if(jQuery(\'.imgalttoggle\').hasClass(\'imgalttoggledown\')){imgAltToggle(\' '. html_entity_decode(self::translate("show-less", $factor)) .'\');}else if(jQuery(\'.imgalttoggle\').hasClass(\'imgalttoggleup\')){imgAltToggle(\' '. html_entity_decode(self::translate("show-more", $factor)) .'\')}"> '
                        . html_entity_decode(self::translate("show-more", $factor)) .'</a>';
                }
            } else {
                $out .= $endModel;
            }
        }else{
            $out .= html_entity_decode(self::translate("model_red", $factor));
        }

        return $out;

    }

}