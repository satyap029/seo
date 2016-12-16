<?php

class FactorSslcheck
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $html = "";

        if ((isset($data) && !empty($data['trusted']) && $data['trusted']) || (isset($data['return_error']) && strcasecmp($data['return_error'],"ok") === 0)) {
            $html .= "<h4><i class='fa fa-check-circle greentext'></i> " . self::translate('validssl', $factor) . "</h4>";
        } else if (($data != null && (isset($data['return_error']) && strcasecmp($data['return_error'], "ok") !== 0))) {
            $html .= "<h4><i class='fa fa-info-circle redtext'></i> " . self::translate('invalidsll', $factor) . "</h4>";
            $html .= "<span>" . ucfirst($data['return_error']) . "</span>";
        }

        if (isset($data['common_name']) && !empty($data['common_name'])) {
            $html .= "<div class='row'>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('commonname', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['common_name'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['organizational_unit']) && !empty($data['organizational_unit'])) {
            $html .= "<div class='row'>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('organizational', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['organizational_unit'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['country']) && !empty($data['country'])) {
            $html .= "<div class='row'>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('countrysslcheck', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['country'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['state']) && !empty($data['state'])) {
            $html .= "<div class='row'>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('statesslcheck', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['state'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['locality']) && !empty($data['locality'])) {
            $html .= "<div class='row'>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('locality', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['locality'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['issuer_name']) && !empty($data['issuer_name'])) {
            $html .= "<div class='row'>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('issuername', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['issuer_name'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['issuer_url']) && !empty($data['issuer_url'])) {
            $html .= "<div class='row'>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('issuerurl', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['issuer_url'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['key_strength']) && !empty($data['key_strength'])) {
            $html .= "<div class='row'>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('keystrength', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['key_strength'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['protocol']) && !empty($data['protocol'])) {
            $html .= "<div class='row'>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('protocol', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['protocol'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if ($data === null) {
            $html .= "<h4><i class='fa fa-info-circle missing'></i> " . self::translate('missingssl', $factor) . "</h4>";
        }

        return $html;
    }

}