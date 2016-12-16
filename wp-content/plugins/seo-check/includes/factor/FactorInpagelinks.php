<?php

//require 'interface.eranker.php';


class FactorInpagelinks
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '<div class="row">';

        if (!empty($data)) {
            if (isset($data['info']) && is_array($data['info']) && (int)$data['info']['total'] !== 0) {
                $attr = '';

                $total = 0;

                foreach ($data['info'] as $key => $value) {
                    $attr .= 'data-' . $key . '=' . $value . ' ';
                    if (strcasecmp($key, "total") === 0) {
                        $total += (int) $value;
                    }
                }

                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft"><b>' . self::translate('total', $factor) . ':</b> ' . $total . '</div>';
                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 chartinpagelinks nopaddingleft paddingupdown" data-chartready="false" ' . $attr . '></div>';


                if (isset($_GET["pdf"])) {

                    $total = $data["info"]["total"];

                    $plots = array();
                    foreach ($data['info'] as $k => $v) {
                        if ($k == "total") continue;

                        $plots[$k] = (100*$v) / $total;
                    }
                    $out .= self::__draw_pie_chart($plots, 60);

                }

                //legend
                //bootstrap html
                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft" style="margin-top: 8px;font-size: 12px;">'
                    . '<div class="row">'
                    . '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft"><p><b>' . self::translate('legend', $factor) . '</b></p></div>'
                    . '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft"><p><i class="fa fa-link" style="font-size:15px;"></i>: ' . self::translate('internal-link', $factor) . '</p></div>'
                    . '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft"><p><i class="fa fa-external-link" style="font-size:15px;"></i>: ' . self::translate('external-link', $factor) . '</p></div>'
                    . '</div>'
                    . '</div>';
                //end legend

                if(is_array($data['page_links']) && !empty($data['page_links'])){
                    $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft paddingupdown">';
                    $out .= "<table class='table table-condensed table-bordered tabletocollapse'>"
                        . "<thead>"
                        . '<tr style="background-color: #C2C0C0;"><th><strong>' . self::translate('anchor', $factor) . '</strong></th>
                                    <th class="hidden-xs hidden-sm"><strong>' . self::translate('type', $factor) . '</strong></th>
                                    <th class="hidden-xs hidden-sm"><strong>' . self::translate('follow', $factor) . '</strong></th>
                             </tr>'
                        . "</thead>"
                        . "<tbody>";
                    $howmuchtoshow = 0;

                    foreach($data['page_links'] as $link) {
                        $howmuchtoshow++;

                        $out .= '<tr' . ($link['type'] === 1 ? ' style="background-color: #ECECEC;"' : '')
                            . ' '
                            . ($howmuchtoshow > 10 ? 'class="hiderows"' : '')
                            . '>';

                        if ($link['type'] === 1) {
                            $icon = '<i class="fa fa-link" style="font-size:15px;padding: 10px;"></i>';
                        } else if ($link['type'] === 2) {
                            $icon = '<i class="fa fa-external-link" style="font-size:15px;padding: 10px;"></i>';
                        }

                        if (strlen($link['anchor']) > 37) {
                            $urlanchor = substr($link['anchor'], 0, 37) . '...';
                        } else {
                            $urlanchor = $link['anchor'];
                        }

                        if (isset($link['text']) && strlen($link['text']) > 35) {
                            $textanchor = substr($link['text'], 0, 35) . '...';
                        } else if (isset($link['text'])) {
                            $textanchor = $link['text'];
                        } else {
                            $textanchor = '';
                        }

                        $out .= '<td>' . $icon
                            . '<a href="' . (self::fixURL($link['anchor']) !== false ? self::fixURL($link['anchor']) : $link['anchor']) . '" target="_blank">'
                            . (isset($link['text']) ? $textanchor : $urlanchor)
                            . '</a>'
                            . '</td>';

                        if ($link['type'] === 1) {
                            $out .= '<td class="hidden-xs hidden-sm">' . self::translate('internal-link', $factor) . '</td>';
                        } else if ($link['type'] === 2) {
                            $out .= '<td class="hidden-xs hidden-sm">' . self::translate('external-link', $factor) . '</td>';
                        }
                        if (isset($link['follow'])) {
                            if ($link['follow'] === 1) {
                                $out .= '<td class="hidden-xs hidden-sm">' . self::translate('no-follow', $factor) . '</td>';
                            } else if ($link['follow'] === 2) {
                                $out .= '<td class="hidden-xs hidden-sm">' . self::translate('follow', $factor) . '</td>';
                            }
                        } else {
                            $out .= '<td class="hidden-xs hidden-sm">' . self::translate('no-follow', $factor) . '</td>';
                        }

                        $out .= '</tr>';
                    }

                    $out .=         '</tbody>'
                        . '</table>'
                        . '</div>';

                    if ($howmuchtoshow > 10) {
                        $out .= '<div class="despicableme col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">'
                            . '<a class="inpagelinksshowmore expandtable" href="javascript:void(0);">'. html_entity_decode(stripslashes(self::translate('showmore', $factor))) .'</a>'
                            . '<a class="inpagelinksshowless expandtable" href="javascript:void(0);">'. html_entity_decode(stripslashes(self::translate('showless', $factor))) .'</a>'
                            . '</div>';
                    }
                }
            }else {
                $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">' . self::translate("model_red", $factor) . '</div>';
            }
        }else {
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft">' . self::translate("model_red", $factor) . '</div>';
        }

        $out .= '</div>';

        return $out;
    }

}