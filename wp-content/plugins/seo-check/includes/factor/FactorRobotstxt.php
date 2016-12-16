<?php

//require 'interface.eranker.php';


class FactorRobotstxt
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $html = $endModel;

        if (!is_null($data)) {
            $content = 'Disallow Content:<br>';
            if ($data['valid'] && $data['robotstxt']) {
                if (strcasecmp(gettype($data['content']), "string") === 0 && !empty($data['content'])) {
                    if (strstr($data['content'], PHP_EOL) !== false) {
                        $a = explode(PHP_EOL, $data['content']);
                        $content .= implode("<br>", $a);
                    } else {
                        $content .= $data['content'];
                    }
                } else if (strcasecmp(gettype($data['content']), "array") === 0) {
                    foreach ($data['content'] as $cont) {
                        $content .= $cont . '<br>';
                    }
                }

                if (!is_null($data['url']) && !empty($data['url'])) {
                    $html .= '<br><a href="' . (self::fixURL($data['url']) !== false ? self::fixURL($data['url']) : $data['url']) . '" style="color:#555" target="_blank">' . $data['url'] . '</a><br><div class="trickydiv"><div class="robotstxtcontainer robotstoggle rttoggledown">' . $content . '</div></div>';
                } else {
                    $html .= '<br><div class="trickydiv"><div class="robotstxtcontainer robotstoggle rttoggledown">' . $content . '</div></div>';
                }

                if (strlen($content) > 250) {
                    $html .= '<a class="robotstxt" href="javascript:void(0);" onclick="'
                        . 'if(jQuery(\'.robotstoggle\').hasClass(\'rttoggledown\')){'
                        . 'robotsTxtToggle(\' ' . html_entity_decode(self::translate("show-less", $factor)) . '\');}'
                        . 'else if(jQuery(\'.robotstoggle\').hasClass(\'rttoggleup\')){'
                        . 'robotsTxtToggle(\' ' . html_entity_decode(self::translate("show-more", $factor)) . '\')}"> '
                        . html_entity_decode(self::translate("show-more", $factor))
                        . '</a>';
                }
            }
        }

        return $html;
    }

}