<?PHP

//Avoid re-include this file
if (class_exists("eRankerBase")) {
    return;
}

class eRankerBase {

//    const NAME = "eRankerCommons";
    const MISSING = "MISSING";
    const NEUTRAL = "NEUTRAL";
    const GREEN = "GREEN";
    const ORANGE = "ORANGE";
    const RED = "RED";
    const BIG = "BIG";
    const BASE_ER = "fad6kh9uo3xltjn48erw5qc20gm7szbi1vpy";
    const BASE_10 = "0123456789";   

    public static $imgfolder = "/content/themes/eranker/img/";
    public static $factorCreateImageFolder = "/content/themes/eranker/libs/";
    public static $folderLibs = "/content/themes/eranker/libs/";
    public static $urlLeadGenerator = "/content/themes/eranker/libs/leadgenerator.php";
    public static $useleadgenerator = FALSE;
    public static $layoutLeadGenerator = "POPUP";
    public static $howshowthemodal = "report20";
    //TRUE FOR PLUGIN!!!
    public static $isPlugin = TRUE;
    public static $agent = array('image' => '/content/themes/eranker/img/lead-generator-pop-up-user-default-man-bg.png', 'text' => 'Fill in the data to get the full report', 'name' => 'eRanker Support', 'position' => '', 'logo' => '/content/themes/eranker/img/logo-blue.png', 'referer' => '', 'text_button' => 'Unlock Report Data');

    /**
     * Decode a report id from eranker base
     * @param string $id The report id
     */
    public static function decodeReportId($id) {
        return self::convBase($id, self::BASE_10, self::BASE_10); //disabled for now...
    }/**
     * translate the text on eranker
     * @param string $key The text
     */
    public static function translate($key, $factor = null, $default = null) {
        $arrayF = (array) $factor;

        if (empty($arrayF) || !isset($arrayF['text']) || empty($arrayF['text'])) {
            return ($default !== null) ? $default : $key;
        } else {
            $arrayT = (array) $arrayF['text'];

            if (isset($arrayT[$key])) {
                return $arrayT[$key];
            }
        }
        return ($default !== null) ? $default : $key;
    }

    /**
     * Decode a report id from eranker base
     * @param string $id The report id
     */
    public static function encodeReportId($id) {
        return self::convBase($id, self::BASE_10, self::BASE_10);
    }

    /**
     * Based on a string. we add the data using the model inside the string. 
     * Normally we use sprintf but if the data is an array or object, we replace using %keyname
     * @param Any $data The data from the factor
     * @param String $string The base string
     * @return The new string with the value data values in it (if needed)
     */
    public static function replaceValue($data, $string) {
        if (empty($string)) {
            return "";
        }
        if (is_array($data) || is_object($data)) {
            $data = (array) $data;
            $out = $string;
            foreach ($data as $key => $value) {
                if (is_string($value) || is_int($value) || is_float($value) || is_numeric($value)) {
                    $out = str_replace("%" . $key, $value, $out);
                } else {
                    $out = str_replace("%" . $key, is_object($value) ? "[OBJECT]" : "[ARRAY]", $out);
                }
            }
            return $out;
        } else {
            try {
                return @sprintf($string, $data);
            } catch (Exception $ex) {
                return "XXX";
            }
        }
    }

    /**
     * Based on a status, get the rigth model array (status, model and description) from a factor
     * @param Any $data The data Object
     * @param String $status The factor Status Text. Ex: RED, MISSING, ORANGE, etc
     * @param Object $fullFactor The full factor Object. Must contain the texts
     * @return Array The array with the right text models for the status.
     */
    public static function getFactorStatusText($data, $status, $fullFactor) {
        $out = array();
        switch ($status) {
            case self::RED:
                $out['model'] = self::replaceValue($data, self::translate("model_red", $fullFactor));
                $out['description'] = self::replaceValue($data, self::translate("description_red", $fullFactor));
                break;
            case self::ORANGE:
                $out['model'] = self::replaceValue($data, self::translate("model_orange", $fullFactor));
                $out['description'] = self::replaceValue($data, self::translate("description_orange", $fullFactor));
                break;
            case self::GREEN:
                $out['model'] = self::replaceValue($data, self::translate("model_green", $fullFactor));
                $out['description'] = self::replaceValue($data, self::translate("description_green", $fullFactor));
                break;
            case self::NEUTRAL:
                $out['model'] = self::replaceValue($data, self::translate("model_neutral", $fullFactor));
                $out['description'] = self::replaceValue($data, self::translate("description_neutral", $fullFactor));
                break;
            case self::MISSING;
            default;
                $out['model'] = self::replaceValue($data, self::translate("model_missing", $fullFactor));
                $out['description'] = self::replaceValue($data, self::translate("description_missing", $fullFactor));
        }


        return $out;
    }

    /**
     * Based on the factor value, return the rigth factor status based on the limits and the function
     * @param Any $value The value of the factor.
     * @param Object $fullFactor The full factor Object. Must contain the texts
     * @return String The factor status
     */
    public static function getFactorStatus($value, $fullFactor) {
        if ($value === NULL) {
            return self::MISSING;
        }
        switch ($fullFactor->function) {
            case ">":
                if ($value > $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if ($value > $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case ">=":
                if ($value >= $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if ($value >= $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "<":
                if ($value < $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if ($value < $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "<=":
                if ($value <= $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if ($value <= $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "<>":
                if ($value != $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if ($value != $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "==":
                if ($value == $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if ($value == $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "strlen()>=":
                if (strlen($value) >= $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if (strlen($value) >= $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "strlen()>":
                if (strlen($value) > $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if (strlen($value) > $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "strlen()<=":
                if (strlen($value) <= $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if (strlen($value) <= $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "strlen()<":
                if (strlen($value) < $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if (strlen($value) < $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "strlen()==":
                if (strlen($value) == $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if (strlen($value) == $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "strlen()<>":
                if (strlen($value) != $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if (strlen($value) != $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "count()>=":
                if (count($value) >= $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if (count($value) >= $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "count()>":
                if (count($value) > $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if (count($value) > $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "count()<=":
                if (count($value) <= $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if (count($value) <= $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "count()<":
                if (count($value) < $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if (count($value) < $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "count()==":
                if (count($value) == $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if (count($value) == $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "count()<>":
                if (count($value) != $fullFactor->limit_green) {
                    return self::GREEN;
                } else {
                    if (count($value) != $fullFactor->limit_orange) {
                        return self::ORANGE;
                    } else {
                        return self::RED;
                    }
                }
                break;
            case "red":
            case "RED":
                return self::RED;
            case "orange":
            case "ORANGE":
                return self::ORANGE;
            case "green":
            case "GREEN":
                return self::GREEN;
            case "missing":
            case "MISSING":
                return self::MISSING;
            case "neutral":
            case "NEUTRAL":
            default:
                return self::NEUTRAL;
        }
        return self::NEUTRAL;
    }

    /**
     * Convert a database full factor to a object in the API format
     * @param Object $factor The full factor object that came from database
     * @return Object the factor formated to be shown on the API
     */
    public static function getFactorExternalObj($factor) {

        if (empty($factor)) {
            return array();
        }
        $tmpitem = array();
        if ($factor->is_active) {
            $tmpitem['id'] = $factor->id;
            $tmpitem['is_active'] = $factor->is_active;
            $tmpitem['order'] = $factor->order;
            $tmpitem['type'] = $factor->type;
            $tmpitem['gui_type'] = $factor->gui_type;
            $tmpitem['limit_red'] = $factor->limit_red;
            $tmpitem['limit_orange'] = $factor->limit_orange;
            $tmpitem['limit_green'] = $factor->limit_green;
            $tmpitem['limit_neutral'] = $factor->limit_neutral;

            //Compatibility only
            $tmpitem['friendly_name'] = self::translate("friendly_name", $factor, "");
            $tmpitem['model_red'] = self::translate("model_red", $factor, "");
            $tmpitem['model_orange'] = self::translate("model_orange", $factor, "");
            $tmpitem['model_green'] = self::translate("model_green", $factor, "");
            $tmpitem['model_neutral'] = self::translate("model_neutral", $factor, "");
            $tmpitem['model_missing'] = self::translate("model_missing", $factor, "");
            $tmpitem['description_red'] = self::translate("description_red", $factor, "");
            $tmpitem['description_orange'] = self::translate("description_orange", $factor, "");
            $tmpitem['description_green'] = self::translate("description_green", $factor, "");
            $tmpitem['description_neutral'] = self::translate("description_neutral", $factor, "");
            $tmpitem['description_missing'] = self::translate("description_missing", $factor, "");
            $tmpitem['article'] = self::translate("article", $factor, "");
            $tmpitem['solution'] = self::translate("solution", $factor, "");
            //End of compatibility functions

            $tmpitem['correlation'] = $factor->correlation;
            $tmpitem['path'] = $factor->path;
            $tmpitem['pro_only'] = isset($factor->pro_only) && !empty($factor->pro_only) ? TRUE : FALSE;
            $tmpitem['free'] = isset($factor->free) && !empty($factor->free) ? TRUE : FALSE;

            $tmpitem['difficulty_level'] = $factor->difficulty_level;
            $tmpitem['category_id'] = $factor->category_id;
            $tmpitem['category_order'] = $factor->category_order;
            $tmpitem['category_icon'] = $factor->category_icon;
            $tmpitem['category_friendly_name'] = isset($factor->category_friendly_name) ? $factor->category_friendly_name : NULL;
            $tmpitem['category_description'] = isset($factor->category_description) ? $factor->category_description : NULL;
            $tmpitem['category_bg_color'] = isset($factor->category_bg_color) ? strtoupper($factor->category_bg_color) : NULL;
            $tmpitem['category_hover_color'] = isset($factor->category_hover_color) ? strtoupper($factor->category_hover_color) : NULL;
            $tmpitem['group_id'] = isset($factor->group_id) ? $factor->group_id : NULL;
            $tmpitem['group_friendly_name'] = isset($factor->group_friendly_name) ? $factor->group_friendly_name : NULL;
            $tmpitem['group_description'] = isset($factor->group_description) ? $factor->group_description : NULL;
            $tmpitem['group_order'] = $factor->group_order;
            $tmpitem['text'] = $factor->text;
        }
        return $tmpitem;
    }

    /**
     * Filter the factor name to make sure it does not have suspicius characters
     * @param String $s The factor name to be filtred
     * @return String the filtred factor name (with only letters, numbers and underline
     */
    public static function sanitizeFactorName($s) {
        return preg_replace("/[^a-zA-Z0-9-_]+/", "", $s);
    }

    /**
     * Convert a type from the factor table to the sql type that will be used to create the factor table
     * @param String $type Type from the factors table. Values: 'BOOLEAN', 'INTEGER', 'FLOAT', 'JSON', 'TEXT', 'BIGINT', 'DATETIME', 'STRING'
     * @return String The SQL type string. By default it returns a varchar.
     */
    public static function getFactorSQLType($type) {
        switch (trim(strtoupper((string) $type))) {
            case 'BOOLEAN':
                return "BOOLEAN";
            case 'INTEGER':
                return "INT";
            case 'FLOAT':
                return "FLOAT";
            case 'JSON':
                return "TEXT";
            case 'BIGINT':
                return "BIGINT";
            case 'DATETIME':
                return "DATETIME";
            case 'TEXT':
                return "TEXT";
            case 'STRING':
            default:
                return "VARCHAR(255) COLLATE utf8_bin";
        }
    }

    /**
     * Convert a factor value to a given Type
     * @param Any $value The factor value
     * @param String $type The type of the variable
     * @return Any The variable casted to the right type
     */
    public static function convertFactor($value, $type) {
        if (is_null($value)) {
            return NULL;
        }
        switch ($type) {
            case 'INTEGER':
                return (int) $value;
            case 'STRING':
                return (string) $value;
            case 'BOOLEAN':
                return (boolean) $value;
            case 'FLOAT':
                return (float) $value;
            case 'JSON':
                return json_decode($value);
            default:
                return $value;
        }
    }

    /**
     * FIx a URL by adding the protocol and lowercase the hostname and replace the spaces
     * @param String $url The original url to be fixed
     * @return boolean|string The fixed URL. False if the url is invalid
     */
    public static function fixURL($url) {

        if (strpos($url, "//") === 0) {
            $url = "http:" . $url;
        } else {
            if (strpos(strtolower($url), "http") !== 0) {
                $url = "http://" . $url;
            }
        }
        $parsed = parse_url($url);

        if (!isset($parsed['scheme']) || empty($parsed['scheme'])) {
            return false;
        }
        if (!isset($parsed['host']) || empty($parsed['host'])) {
            return false;
        }

        $url = strtolower($parsed['scheme']) . "://" . strtolower($parsed['host'])
                . ( (isset($parsed['path']) && !empty($parsed['path'])) ? $parsed['path'] : "/" )
                . ( (isset($parsed['query']) && !empty($parsed['query'])) ? "?" . $parsed['query'] : "" );

        if (filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED)) {
            return str_replace(' ', '%20', $url);
        } else {
            return false;
        }
    }

    /**
     * Prepare a factor array, remove duplicates, sort,  strtolower and trim for each item
     * @param array $arr The input array
     * @return array The filtred array
     */
    public static function prepareFactorArray($arr) {
        $out = array();
        if (empty($arr)) {
            return $out;
        }
        foreach ($arr as $value) {
            $newvalue = strtolower(trim($value));
            if (!empty($newvalue)) {
                $out[] = trim($newvalue);
            }
        }
        sort($out);
        return array_unique($out);
    }

    /**
     * Get a ORDERED TREE of full factors
     * This function 
     * The tree look likes this:
     *  [category_id] 
     *      [group_id1] 
     *              factor1
     *              factor2
     *              factor3
     *      [group_id2]
     *              factor4
     *              factor5
     *              factor6
     * @param array $fullfactors The full factors from the database
     * @return array The Tree as an array
     */
    public static function getFactorTree($fullfactors) {

        //Create an order for each thing
        $categories_order = array();
        $groups_order = array();
        $factors_order = array();

        //Create the unordered tree
        $unorderedTree = array();

        if (!empty($fullfactors)) {
            foreach ($fullfactors as $factor) {
                $factor = (object) $factor;
                if (!isset($categories_order[$factor->category_id])) {
                    $categories_order[$factor->category_id] = $factor->category_order;
                }

                if (!isset($groups_order[$factor->group_id])) {
                    $groups_order[$factor->group_id] = $factor->group_order;
                }

                if (!isset($factors_order[$factor->id])) {
                    $factors_order[$factor->id] = $factor->order;
                }

                if (!isset($unorderedTree[$factor->category_id])) {
                    $unorderedTree[$factor->category_id] = array();
                }

                if (!isset($unorderedTree[$factor->category_id][$factor->group_id])) {
                    $unorderedTree[$factor->category_id][$factor->group_id] = array();
                }
                $unorderedTree[$factor->category_id][$factor->group_id][] = $factor->id;
            }
        }
        //Sort the individual items
        asort($categories_order);
        asort($groups_order);
        asort($factors_order);


        $orderedTree = array();

        //Create the ordered tree by navigate each item in order and comparing with the unordered tree.
        if (!empty($categories_order)) {
            foreach ($categories_order as $category_id => $category_order) {
                $orderedTree[$category_id] = array();
                if (!empty($groups_order)) {
                    foreach ($groups_order as $group_id => $group_order) {
                        if (in_array($group_id, array_keys($unorderedTree[$category_id]))) {
                            $orderedTree[$category_id][$group_id] = array();
                            if (!empty($factors_order)) {
                                foreach ($factors_order as $factor_id => $factor_order) {
                                    if (in_array($factor_id, $unorderedTree[$category_id][$group_id])) {
                                        $orderedTree[$category_id][$group_id][] = $factor_id;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        //Debug!
        //echo "<pre>" . print_r($unorderedTree, true) . "</pre>";
        //echo "<pre>" . print_r($orderedTree, true) . "</pre>";
        return $orderedTree;
    }

    /**
     * Convert a object to an array using recurssion
     * @param obejct $obj The object to be converted
     * @return array The array
     */
    public static function objectToArray($obj) {
        if (is_object($obj)) {
            $obj = (array) $obj;
        }
        if (is_array($obj)) {
            $new = array();
            foreach ($obj as $key => $val) {
                $new[$key] = self::objectToArray($val);
            }
        } else {
            $new = $obj;
        }
        return $new;
    }

    /**
     * Convert an arbitrarily large number from any base to any base.
     * examples for $fromBaseInput and $toBaseInput
     * '0123456789ABCDEF' for Hexadecimal (Base16)
     * '0123456789' for Decimal (Base10)
     * '01234567' for Octal (Base8)
     * '01' for Binary (Base2) 
     * You can really put in whatever you want and the first character is the 0.
     * @param string $numberInput number to convert as a string
     * @param string $fromBaseInput base of the number to convert as a string
     * @param string $toBaseInput base the number should be converted to as a string
     * @return string The output on the new base
     */
    public static function convBase($numberInput, $fromBaseInput, $toBaseInput) {
        if ($fromBaseInput == $toBaseInput) {
            return $numberInput;
        }
        $fromBase = str_split($fromBaseInput, 1);
        $toBase = str_split($toBaseInput, 1);
        $number = str_split($numberInput, 1);
        $fromLen = strlen($fromBaseInput);
        $toLen = strlen($toBaseInput);
        $numberLen = strlen($numberInput);
        $retval = '';
        if ($toBaseInput == '0123456789') {
            $retval = 0;
            for ($i = 1; $i <= $numberLen; $i++) {
                $retval = bcadd($retval, bcmul(array_search($number[$i - 1], $fromBase), bcpow($fromLen, $numberLen - $i)));
            }
            return $retval;
        }
        if ($fromBaseInput != '0123456789') {
            $base10 = self::convBase($numberInput, $fromBaseInput, '0123456789');
        } else {
            $base10 = $numberInput;
        }
        if ($base10 < strlen($toBaseInput)) {
            return $toBase[$base10];
        }
        while ($base10 != '0') {
            $retval = $toBase[bcmod($base10, $toLen)] . $retval;
            $base10 = bcdiv($base10, $toLen, 0);
        }
        return $retval;
    }
    
    /**
     * Return the time using the user timezone.
     * @param string $timezone the timezone from the user
     * @param date $date_time the time
     * @return String with the time
     */
    public static function convertDateTime($date_time, $timezone) {
        if (empty($timezone)) {
            $timezone = 'UTC';
        }
        $newtimezone = new DateTimeZone($timezone);
        $newdate = new DateTime($date_time);
        $newdate->setTimezone($newtimezone);
        $generate_time = $newdate->format('H:i');
        $generate_date = $newdate->format('d/m/y');
        return $generate_date . ',' . $generate_time;
    }
        
    public static function getFactorHTMLHelper($report, $factor, $endModel, $data, $status, $is_loggedin){
        $html = "";

        $factor = self::objectToArray($factor);
        
        //use html_entity_decode(stripslashes($endModel))        
        $endModel = html_entity_decode(stripslashes($endModel));
        
        $factorName = sprintf('Factor%s', ucfirst($factor['gui_type']));
        
        if ($is_loggedin || (!$is_loggedin && $factor['free'])) {
            if(class_exists($factorName)){
                $html .= forward_static_call(array($factorName, 'getDisplay'), $endModel, $data, $report, $factor);
            }else{
                $html .= forward_static_call(array("FactorDefault", 'getDisplay'), $endModel, $data, $report, $factor);
            }
        } else {
            $html .= '<div class="has-blur"></div>';
        }

        return $html;
    }

    static function __draw_pie_chart($plots, $r = 25, $has_legend = true, $custom_colors = array(), $set_total = null) {

        $output = "";
        if (!is_array($plots) || !is_int($r)) {
            return;
        }

        $width = $height = $r * 4;
        $arc = pi() * $r * 2;
        $deg = $arc / 100;

        $circle = '<circle r="%d" cx="%d" cy="%d" fill="none" '
                . 'stroke="%s" '
                . 'stroke-width="%d" '
                . 'stroke-dasharray="%f %f">'
                . '</circle>';
        
        if (is_int($set_total) || is_float($set_total)) {
            $total = $set_total;
        } else {
            $total = 0;
            foreach ($plots as $plot) {
                $total += (float) $plot;
            }
        }

        asort($plots); // asc
        $offset = 0;
        $plots_output = array();
        foreach ($plots as $label => $percent) {
            if ($percent > 0) {
                $value = $deg * (($percent * 100) / $total);
            } else {
                $value = 0;
            }

            $plots_output[$label] = $value + $offset;
            $offset += $value;
        }
        
        arsort($plots_output); // desc
        
        $output .= '<div class="pie-chart-svg">';

        if (count($custom_colors) > 0) {
            $colors = $custom_colors;
        } else {
            $colors = array('#FF9000', '#0281C4', '#04B974', '#F45B5B', '#444444', 
                '#5F65E0');
            $colors = array_reverse($colors);
        }
        
        $color = 'red';
        $plot_legend = array();
        
        $output .= sprintf('<svg width="%d" height="%d" class="pie-chart">', 
                $width, $height);
        foreach ($plots_output as $label => $percent) {

            if (!empty($colors)) {
                $color = array_pop($colors);
            } else {
                $color = '#' . dechex(rand(0x000000, 0xFFFFFF));
            }

            $legend_key = sprintf("%s%d", $label, $percent);
            $plot_legend[$legend_key] = array(
                "label" => $label,
                "color" => $color,
                "value" => (float) $plots[$label]
            );

            $output .= sprintf($circle,
                $r, $r * 2, $r * 2, 
                $color,
                $r * 2,
                $percent, $arc);

        }
   
        $output .= '</svg>';
        
        if ($has_legend) {
            $output .= '<ul class="plots_legend">';
            foreach ($plot_legend as $legend) {
                $output .= sprintf('<li>'
                        . '<i class="fa fa-square" style="color: %s;"></i> %s (%.1f%%)'
                        . '</li>', $legend["color"], $legend["label"], $legend["value"]);
            }
            $output .= '</ul>';
        }
        
        $output .= '</div>';

        return $output;
    }
}
