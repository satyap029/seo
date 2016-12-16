<?php

//require 'interface.eranker.php';


class FactorEmails
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $out = '';
        if (!empty($data)) {
            foreach ($data as $singleEmail) {
                $out .= '<img src="' . self::$factorCreateImageFolder . 'createimage.php?size=11&amp;transparent=1&amp;padding=0&amp;bgcolor=250&amp;textcolor=50&amp;text=' . urlencode(strrev(base64_encode($singleEmail))) . '" alt="' . self::translate('sitecontactmail', $factor) . '"><br />';
            }
        }

        return empty($out) ? '<div class="emails-style">' . self::translate("emailnotfound", $factor) . '.</div>' : $out;
    }

}