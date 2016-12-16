<?php

class FactorCitations
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {

        $out = '';
        if (!empty($data)) {
            if (!empty($data['citations'])) {
                $out .= '<div>' . $endModel . '</div>';
                if (!empty($data['link'])) {
                    $out .= '<div style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden; max-width: 90%;"><a href="' . $data['link'] . '" target="_blank">' . $data['link'] . '</a></div>';
                }
            } else {
                $out = '<div>' . $endModel . '</div>';
            }
        }

        return (!empty($out)) ? $out : $endModel;
    }

}