<?php

//require 'interface.eranker.php';


class FactorGooglepreview
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $outString = '';
        if (isset($data) && !empty($data)) {
            foreach ($data as $key => $value) {
                if (strcasecmp($key, 'title') === 0) {
                    $title = $value;
                }

                if (strcasecmp($key, 'meta_description') === 0) {
                    $meta_description = $value;
                }
                if (strcasecmp($key, 'url_href') === 0) {
                    $url_href = parse_url($value);

                    if (strcasecmp($url_href['scheme'], 'http') === 0) {
                        $url_href = $url_href['host'];
                    } else {
                        $url_href = $value;
                    }
                }
            }
        }

        if (!empty($url_href) && !empty($title)) {
            $outString .= "<div class='outgooglepreview'>";
            $outString .= "<h3 class='title-googlepriview'>";
            $outString .= "<a rel='nofollow' href='" . (self::fixURL($url_href) !== false ? self::fixURL($url_href) : "http://$url_href") . "' target='_blank'> $title </a>";
            $outString .= "</h3>";
            $outString .= "<div class='insidegooglepreview'>";
            $outString .= "<div class='url-googlepreview'>";
            $outString .= "<a href='" . (self::fixURL($url_href) !== false ? self::fixURL($url_href) : "http://$url_href") . "' target='_blank' style='cursor:pointer;color: #006621;'>" . $url_href . "</a>";
            $outString .= "</div>";
            if (!empty($meta_description)) {
                $outString .= "<div class='description-googlepreview'>";
                $outString .= "$meta_description";
                $outString .= "</div>";
            }
            $outString .= "</div>";
            $outString .= "</div>";
        } else if ((!empty($url_href) && empty($title)) || (empty($url_href) && !empty($title))) {
            //for some sites $data not contain title
            //show partials data
            $outString .= "<div class='announcement'>" . self::translate('notcompletedata', $factor) . "</div>";
            $outString .= "<div class='outgooglepreview'>";

            if (!empty($url_href) && !empty($title)) {
                $outString .= "<h3 class='title-googlepriview'>";
                $outString .= "<a rel='nofollow' href='" . (self::fixURL($url_href) !== false ? self::fixURL($url_href) : "http://$url_href") . "' target='_blank'> $title </a>";
                $outString .= "</h3>";
            }

            $outString .= "<div class='insidegooglepreview'>";

            if (!empty($url_href)) {
                $outString .= "<div class='url-googlepreview'>";
                $outString .= "<a href='" . (self::fixURL($url_href) !== false ? self::fixURL($url_href) : "http://$url_href") . "' target='_blank' style='cursor:pointer;color: #006621;'>" . $url_href . "</a>";
                $outString .= "</div>";
            }

            if (!empty($meta_description)) {
                $outString .= "<div class='description-googlepreview'>";
                $outString .= "$meta_description";
                $outString .= "</div>";
            }
            $outString .= "</div>";
            $outString .= "</div>";
        }

        return !empty($outString) ? $outString : self::translate('notfoundgoogleprevie', $factor);
    }

}