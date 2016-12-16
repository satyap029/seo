<?php

require_once 'eRankerBase.php';

require_once 'factor/interface.eranker.php';

require_once 'factor/import.factors.php';


//Avoid re-include this file
if (class_exists("eRankerCommons")) {
    return;
}

class eRankerCommons extends eRankerBase {
    
    /**
     * Generate the report HTML code
     * @param object $report the report row. Factors cols shall be already converted to array
     * @param object $reportScores The array with the report data and scores
     * @param array $fullfactors The full factors from the database
     * @param boolean $logged_in Tell if the user is logged in or not
     * @param boolean $is_pdf Tell if we are generating a pdf or not
     * @return string The html of the report. 
     */
    public static function getReportHTML($report, $reportScores, $fullfactors, $logged_in = false, $is_pdf = false, $disable_pdf = false, $show_header = TRUE, $show_title = TRUE, $show_category = TRUE,$user_plan='') {
        //Make sure that the factors is on the array format        
        $fullfactors = self::objectToArray($fullfactors);
        
        $thumbnailFactor = array();
        if(isset($fullfactors['thumbnail'])){
            //remove thumbnail from factors
            $thumbnailFactor['is_active'] = (int)$fullfactors['thumbnail']["is_active"];
            unset($fullfactors['thumbnail']);
        }else{
            $thumbnailFactor['is_active'] = '';
        }
        
        //Make sure that the scores is on the array format
        $reportScores = self::objectToArray($reportScores);
        
        //get thumbnail data if exist
        if(isset($reportScores['thumbnail']) && !empty($reportScores['thumbnail'])){
            $thumbnailFactor['data'] = $reportScores['thumbnail']['data'];
        }else{
            $thumbnailFactor['data'] = '';
        }
        
        $categories = array();
        $groups = array();

        //Remove the factors that are not used on the report:
        foreach ($fullfactors as $factor_id => $factor) {
            if (!in_array($factor_id, $report->factors)) {
                unset($fullfactors[$factor_id]);
            }
            $categories[$factor['category_id']] = array(
                "friendly_name" => $factor['category_friendly_name'],
                "description" => $factor['category_description'],
                "order" => $factor['category_order'],
                "hover_color" => $factor['category_hover_color'],
                "bg_color" => $factor['category_bg_color'],
                "icon" => $factor['category_icon']
            );

            $groups[$factor['group_id']] = array(
                "friendly_name" => $factor['group_friendly_name'],
                "description" => $factor['group_description'],
                "order" => $factor['group_order']
            );
            
            $mygroups[$factor['group_id']] = array(
                "group_id" => $factor['group_id'],
                "friendly_name" => $factor['group_friendly_name'],
                "description" => $factor['group_description'],
                "order" => $factor['group_order'],
                "cat_id" => $factor['category_id']    
            );
        }
        
        //Navigate menu
        $mycategories = array_unique($categories,SORT_REGULAR);
        $mygroups = array_unique($mygroups,SORT_REGULAR);
        
        //sort categories
        $ordercat = array();
        foreach($mycategories as $categ){
            array_push($ordercat, $categ['order']);
        }
        array_multisort($ordercat, SORT_ASC, $mycategories);        
        
        //merge categories with groups
        foreach($mycategories as $id => $categ){
            $ordergrin = array();
            $order = array();
            foreach($mygroups as $group){
                if($id == $group['cat_id']){
                    array_push($ordergrin,$group);
                    array_push($order,$group['order']);
                }
            } 
            array_multisort($order, SORT_ASC, $ordergrin);  
            $mycategories[$id]['groups'] = $ordergrin;
        }
        
        //firstdiv
        $out = "<div class='superreport-seo'>";
        
        if (!isset($_GET['pdf']) && empty($_GET['pdf']) && self::$isPlugin === false) {
            //first list width >
            $out .= "<div class='navimenu row ". (!empty($_GET['mobileapp']) ? 'hiddenall' : '') ."'>";
                $out .= "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft'>";
                    $out .= "<ul class='naviul'>";  

                    foreach($mycategories as $key => $value){                    
                        $out .= "<li class='navilist' id='". $key ."' style='background-color:#". $value['bg_color'] ."; margin: 8px 0px;'><img src='". $value['icon'] ."' class='naviimg'>". $value['friendly_name'] ."</li>";  
                        foreach($value['groups'] as $keygr => $valuegr){                               
                            if($valuegr['cat_id'] === $key && !empty($valuegr['friendly_name'])){
                                $out .= "<li class='navilist grlist' id='". $valuegr['group_id'] ."'>". $valuegr['friendly_name'] ."</li>";  
                            }                                                                      
                        }
                    }   

                    $out .= "</ul>";                   
                $out .=  "</div>";
            $out .=  "</div>";
            //end first list

            //second list < width
            $out .= "<div class='row navimenuminwidth ". (!empty($_GET['mobileapp']) ? 'staytopzero' : '') ."'>";                 
            $i = 0;
            foreach($mycategories as $key => $value){
                $out .= "<div class='col-xs-1 col-sm-2 col-md-2 col-lg-2 nopaddingleft navilist secondlist ".($i == 0 ? 'addmargin' : '')."' id='". $key ."'>";                
                        $out .= "<img src='". $value['icon'] ."' class='naviimg'  style='background-color:#". $value['bg_color'] ."' title='". $value['friendly_name'] ."'>";    
                        $out .= "<span class='namespan'>". $value['friendly_name'] ."</span>";    
                $out .= "</div>";  
                $i++;
            }

            $out .=  "</div>";
            //end second list
            //Navigate menu
        }
        
        //begin report        
        $out .= "<div id='erreport'>";
        $out .= self::getReportScoreHTML($report, $reportScores['score'], self::BIG, $disable_pdf, $show_header, $show_title, $show_category,$thumbnailFactor);

        $factorTree = self::getFactorTree($fullfactors);

        //Navigate down the factor tree to this report
        if (!empty($factorTree)) {
            foreach ($factorTree as $category_id => $category_array) {
                if (!empty($category_array)) {

                    $out .= "\r\n";
                    $out .= '<div class="ercategory" data-category_id="' . $category_id . '" >';
                    $out .= '<div class="ercategoryheadline">';
                    if ($show_category) {
                        $out .= '<h2 onclick="jQuery(\'.ercategorydescription[data-category_id=' . $category_id . ']\').slideToggle();" class="ercategoryname" style="border-color: #' . $categories[$category_id]['bg_color'] . '">';
                        $out .= '<img src="' . $categories[$category_id]['icon'] . '" class="ercategoryicon" alt="{icon}" /> ';
                        $out .= $categories[$category_id]['friendly_name'];
                        $out .= '</h2>';
                    }

                    $out .= '<div class="ercategoryprogressbar"></div>';
                    $out .= '</div><!-- .ercategoryheadline -->';
                    $out .= '<div class="ercategorydescription beautifyfactor-info" data-category_id="' . $category_id . '" style="display:block">' . $categories[$category_id]['description'] . '</div>';

                    $is_odd_row = true;
                    foreach ($category_array as $group_id => $group_array) {
                        if (!empty($group_array)) {
                            $out .= "\r\n";
                            $out .= '<div class="ergroup row ' . ($show_title ? 'append-title-margin' : '') . '" data-group_id="' . $group_id . '" >';
                            $title = null;
                            if ($show_title) {
                                $title = '<h3 class="ergroupname ' . (($is_odd_row) ? 'eroddrow' : '') . '">' . $groups[$group_id]['friendly_name'] . '</h3>';
                            }
                            $is_even = false;
                            foreach ($group_array as $factor_id) {
                                if(self::$isPlugin === false){
                                    $out .= self::getFactorHTML($report, $fullfactors[$factor_id], $reportScores[$factor_id], $is_even, $logged_in, $show_header, $show_title, $show_category, $title,$user_plan);
                                }else{
                                    $out .= self::getFactorHTML($report, $fullfactors[$factor_id], $reportScores[$factor_id], $is_even, $logged_in, $show_header, $show_title, $show_category, $title);
                                }
                                                                
                                $is_even = !$is_even;
                                $title = null;
                            }
                            $out .= "</div><!-- .ergroup -->\r\n";
                        }
                    }

                    $out .= "</div><!-- .ercategory -->\r\n";
                }
            }
        }

        //DEBUG!
        //$out .= "<pre>ORDERED FACTOR TREE: " . print_r($factorTree, true) . "</pre>";
        
        //Footer Form
        if ((!isset($_COOKIE['leadgenerated']) || empty($_COOKIE['leadgenerated'])) && self::$useleadgenerator !== FALSE && strcasecmp(self::$layoutLeadGenerator, 'POPUP') !== 0) {
            $out .= '<div class="row" id="leadGeneratorFooter">';
            $out .= '<div class="row" id="msgleadgenerator">';
            $out .= '</div>';
            $out .= '<div class="row">';
            $out .= '<div class="col-md-3" style="margin-top: 40px;">';
            $out .= '<div class="toprrightimgemptymodalFooter">';
            $out .= '<div class="toprrightimgmodalFooter"></div>';
            $out .= '</div>';
            if (!empty(self::$agent['logo']) || !empty(self::$agent['name']) || !empty(self::$agent['position'])) {
                $out .= '<div style="">';
                $out .= '<div style="text-align: center; font-size: 16px;">' . self::$agent['name'] . ' <br />' . self::$agent['position'] . '<br /><img src="' . self::$agent['logo'] . '" style="max-height: 50px; max-width: 175px;" /> </div>';
                $out .= '</div>';
            }
            $out .= '</div>';
            $out .= '<div class="col-md-9">';
            $out .= '<form id="formLeadGenerator" method="post" action="' . self::$folderLibs . 'leadgenerator.php">';
            $out .= '<div class="">';
            if (!empty(self::$agent['text'])) {
                $out .= ' <h5>' . self::$agent['text'] . ' </h5>';
            }
            $out .= '<div class="form-group">';
            $out .= '<label for="name_leadgenerator">Full Name</label>';
            $out .= '<input id="name_leadgenerator" type="text" class="form-control" name="name_leadgenerator" placeholder="Full Name">';
            $out .= '</div>';
            $out .= '<div class="form-group">';
            $out .= '<label for="companyname_leadgenerator">Company Name</label>';
            $out .= '<input id="companyname_leadgenerator" type="text" class="form-control" name="companyname_leadgenerator" placeholder="Company Name">';
            $out .= '</div>';
            $out .= '<div class="form-group">';
            $out .= '<label for="email_leadgenerator">Email</label>';
            $out .= '<input id="email_leadgenerator" type="text" class="form-control" name="email_leadgenerator" placeholder="E-Mail Address">';
            $out .= '</div>';
            $out .= '<div class="form-group">';
            $out .= '<label for="phone_leadgenerator">Phone</label>';
            $out .= '<input id="phone_leadgenerator" type="text" class="form-control" name="phone_leadgenerator" placeholder="Phone Number">';
            $out .= '<input type="hidden" name="reporturl" value="' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . '">';
            $out .= '</div>';
            $out .= ' <button id="saveleadgenerator" type="submit" class="btn btn-primary" style="width: 100%;">' . self::$agent['text_button'] . '</button>';
            $out .= ' </div>';

            $out .= '</form>';
            $out .= '</div>';
            $out .= '</div>';
            $out .= '</div>';

            $out .= '<style>';
            if (!empty(self::$agent['image'])) {
                $out .= '#leadGeneratorFooter .toprrightimgmodalFooter { background: transparent url("' . self::$agent['image'] . '") center no-repeat; height: 160px; border-radius: 150px; width: 160px;}';
                $out .= '#leadGeneratorFooter .toprrightimgemptymodalFooter { background: transparent url("' . self::$imgfolder . 'lead-generator-pop-up-user-bg.png") center no-repeat; height: 160px; margin-right: auto; width: 160px; margin-left: auto;}';
            } else {
                $out .= '#leadGeneratorFooter .toprrightimgmodalFooter { background: transparent url("' . self::$imgfolder . 'lead-generator-pop-up-user-default-man-bg.png") center no-repeat; height: 160px; border-radius: 150px; width: 160px;}';
            }

            $out .= '</style>';
            $out .= '<script>jQuery(document).ready(function () {urlLeadGenerate = "' . self::$urlLeadGenerator . '";});</script>';
        }
        
        if(self::$isPlugin === FALSE && empty($_GET['mobileapp'])){
            $out .= '<div class="row createmonitorinreport">';
            
            $out .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 containerformmonitor">';        
                
                $out .= '<div class="insidecontainerform">';
                    $out .= '<form id="createMonitorInsideReport" method="POST" data-action="/content/themes/eranker/ajax/monitors-actions.php" action="/content/themes/eranker/ajax/monitors-actions.php">';
                    
                    $urlreceived = trim(strtolower($report->domain));
                    //sanitize url received    
                    if(strpos($urlreceived,'https://') === 0){
                        $urlreceived = substr($urlreceived,8);
                    }else if(strpos($urlreceived,'http://') === 0){
                        $urlreceived = substr($urlreceived,7);
                    }

                    $urlreceived = trim($urlreceived,'/');
                    
                    $out .= '<div class="labeldivreport">'. __('Do you want to activate a site healthcheck monitor for this domain?','er'). '<span class="labelspanreport">' . __(' Enter your e-mail address below:','er') .'</span></div>';
                    $out .= '<input type="hidden" value="createmonitorfromreport" name="createmonitorfromreport">';
                    $out .= '<input type="hidden" name="linkmonitorfromreport" value="'. $urlreceived .'">';
                    $out .= '<div class="parentvalidate">';
                        if(is_user_logged_in()){
                            global $current_user;
                            get_currentuserinfo();
                            
                            $out .= '<input type="text" name="emailmonitortocreate" id="emailmonitortocreate" value="'. $current_user->user_email .'">';
                        }else{
                            $out .= '<input type="text" name="emailmonitortocreate" id="emailmonitortocreate">';
                        }                        
                    $out .= '</div>';
                    if(is_user_logged_in()){
                        $out .= '<button type="submit" class="btn btn-success successreportmonitor">'. __('Create monitor','er') .'</button>';
                    }else{
                        $out .= '<a href="javascript:void(0);" class="btn btn-success successreportmonitor registerbeforecreatemonitor">'. __('Create monitor','er') .'</a>';
                        $out .= '<em class="emforcedtoappear hiddenall">'. __('You must enter a valid email, or comma separate multiple','er') .'</em>';
                    }
                    
//                    $out .= '<button type="button" class="btn btn-primary hideformreportmonitor">'. __('Cancel','er') .'</button>';
                    
                    if(function_exists('createMonitor') && is_user_logged_in()){
                        echo createMonitor(true);
                    }
                    
                    $out .= '</form>';
                $out .= '</div>';
                
                
            $out .= '</div>';
            
            $out .= '</div>';
        }

        $out .= "</div><!-- #erreport -->";
        $out .= "</div><!-- .superreport-seo -->";
        
        //POPUP
        if ((!isset($_COOKIE['leadgenerated']) || empty($_COOKIE['leadgenerated'])) && self::$useleadgenerator !== FALSE && strcasecmp(self::$layoutLeadGenerator, 'POPUP') === 0) {
            $out .= '<div id="howshowthemodal" data-howshowthemodal="' . self::$howshowthemodal . '"></div>';
            $out .= '<div class="modal fade" id="leadGenerator" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="display:none;">';
            $out .= '<div class="modal-dialog" role="document" style="padding: 0px!important; width: 543px!important; top:190px;!important;">';
            $out .= '<form id="formLeadGenerator" method="post" action="' . self::$folderLibs . 'leadgenerator.php">';
            $out .= '<div class="modal-content">';
            $out .= '<div class="modal-body" style="height: 250px; padding-right: 0px;">';
            $out .= '<div class="form-left-positon" style="width: 306px; margin:0px;">';
            if (!empty(self::$agent['text'])) {
                $out .= ' <h5 class="titleup">' . self::$agent['text'] . ' </h5>';
            }
            $out .= '<div id="msgleadgenerator" class="popupmsg">';
            $out .= '</div>';
            $out .= '<div class="form-group">';
//            $out .= '<label for="name_leadgenerator">Full Name</label>';
            $out .= '<input id="name_leadgenerator" type="text" class="form-control" name="name_leadgenerator" placeholder="Full Name">';
            $out .= '</div>';
//            $out .= '<div class="form-group">';
////            $out .= '<label for="companyname_leadgenerator">Company Name</label>';
//            $out .= '<input id="companyname_leadgenerator" type="text" class="form-control" name="companyname_leadgenerator" placeholder="Company Name">';
//            $out .= '</div>';
            $out .= '<div class="form-group">';
//            $out .= '<label for="email_leadgenerator">Email</label>';
            $out .= '<input id="email_leadgenerator" type="text" class="form-control" name="email_leadgenerator" placeholder="E-Mail Address">';
            $out .= '</div>';
            $out .= '<div class="form-group">';
//            $out .= '<label for="phone_leadgenerator">Phone</label>';
            $out .= '<input id="phone_leadgenerator" type="text" class="form-control" name="phone_leadgenerator" placeholder="Phone Number">';
            $out .= '<input type="hidden" name="reporturl" value="' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . '">';
            $out .= '</div>';
            $out .= ' <button id="saveleadgenerator" type="submit" class="btn btn-primary"> ' . self::$agent['text_button'] . '</button>';
            $out .= ' </div>';
            if (!empty(self::$agent['logo']) || !empty(self::$agent['name']) || !empty(self::$agent['position'])) {
                $out .= '<div style="float: right;height: 200px;width: 205px;margin-top: -200px;">';
                $out .= '<div style="float: left;height: 100px;width: 205px;"></div>';
                $out .= '<div style="float: left;height: 69px;width: 205px; text-align: center; font-size: 16px;">' . self::$agent['name'] . ' <br />' . self::$agent['position'] . '<br /><img src="' . self::$agent['logo'] . '" style="max-height: 50px; max-width: 175px;" /> </div>';
                $out .= '</div>';
            }
            
            $agent_ref = "";
            if (empty($agent_ref) && !empty(self::$agent["referer"])) {
                $agent_ref = self::$agent["referer"];
            }
            if (empty($agent_ref) && !empty($_COOKIE["leadreferer"])) {
                $agent_ref = $_COOKIE["leadreferer"];
            }
            if (empty($agent_ref) && !empty(self::$agent["name"])) {
                $agent_ref = self::$agent["name"];
            }

            $out .= '<input type="hidden" name="agent" value="' . $agent_ref . '" />';
            
            $out .= '<div class="toprrightimgemptymodal"></div>';
            $out .= '<div class="toprrightimgmodal"></div>';


            $out .= '</div>';
//            $out .= '<div class="modal-footer">';
//            
//            $out .= ' </div>';
            $out .= ' </div>';
            $out .= '</form>';
            $out .= ' </div>';
            $out .= '</div>';
            $out .= '<style>';
            $out .= '#leadGenerator .modal-content { background: transparent url("' . self::$imgfolder . 'lead-generator-pop-up-main-bg.png") center no-repeat;}';
            if (!empty(self::$agent['image'])) {
                $out .= '#leadGenerator .toprrightimgmodal { background: transparent url("' . self::$agent['image'] . '") center no-repeat; position: absolute; top: -62px; right: 24px; height: 160px; border-radius: 150px; width: 160px}';
                $out .= '#leadGenerator .toprrightimgemptymodal { background: transparent url("' . self::$imgfolder . 'lead-generator-pop-up-user-bg.png") center no-repeat; position: absolute; top: -62px; right: 24px; height: 160px; border-radius: 150px; width: 160px}';
            } else {
                $out .= '#leadGenerator .toprrightimgmodal { background: transparent url("' . self::$imgfolder . 'lead-generator-pop-up-user-default-man-bg.png") center no-repeat; position: absolute; top: -62px; right: 24px; height: 160px; border-radius: 150px; width: 160px}';
            }

            $out .= '</style>';
            $out .= '<script>jQuery(document).ready(function () {urlLeadGenerate = "' . self::$urlLeadGenerator . '";});</script>';
        }

        return $out;
    }
    
    /**
     * Render a single factor to html
     * @param object $report The report object
     * @param object $factor The full factor object
     * @param array $score The score for this factor for this report
     * @param boolean $is_even If the row is even or not
     * @param boolean $is_loggedin If the user is logged in
     * @return string the HTML of the rendered factor
     */
    public static function getFactorHTML($report, $factor, $score, $is_even = false, $is_loggedin = false, $show_header, $show_title, $show_category, $title = null,$user_plan='') {
        //For this to aways be tru for now
        $is_loggedin = true;

        $factor = (object) $factor;

        $out = "";
        switch ($score['model']['status']) {
            case 'MISSING':
            case 'RED': {
                    $status = 'times';
                    break;
                }
            case 'ORANGE': {
                    $status = 'minus';
                    break;
                }
            case 'GREEN': {
                    $status = 'check';
                    break;
                }
            case 'NEUTRAL': {
                    $status = 'info-circle';
                    break;
                }
            default: {
                    $status = 'question-circle';
                    break;
                }
        }
        $available = in_array($factor->id, $report->factors_available);

        $status = $is_loggedin ? $status : 'question-circle';
        $statuscolor = $is_loggedin ? strtolower($score['model']['status']) : '';

        $out .= '<div data-id="' . $factor->id . '" data-factorready="' . ($available ? '1' : '0') . '" class="noselect erfactor ' . ($is_even ? 'even' : 'odd') . '" id="factor-' . $factor->id . '" data-status="' . $score['model']['status'] . '" '
                . 'onclick="' . ( $is_loggedin ? 'niceToggle(jQuery(this).attr(\'id\'))' : '' ) . '">';
        $out .=!is_null($title) ? $title : "";
        $out .= '<div class="row">';
        $out .= '<div class="factor-name col-xs-12 col-sm-12 col-md-4 col-lg-3">';
        $out .= '<div class="factor-name-inside">';

        if ($available) {
            $out .= ( $status ? '<i class="erankerreporticonspacer fa fa-' . $status . ' ' . $statuscolor . '"></i>' : '' ) . (isset($factor->text["friendly_name"]) ? $factor->text["friendly_name"] : '');
        } else {
            $out .= '<i class="erankerreporticonspacer fa fa-cog fa-spin"></i>' . (isset($factor->text["friendly_name"]) ? $factor->text["friendly_name"] : '');
        }
        $out .= '</div><!-- .factor-name-inside -->';


        $out .= '<div class="ericonsrow">';

        $totalIcons = 3;


        $impactTitle = "High Impact";
        $impact = 3;
        if ($factor->correlation < 0.1) {
            $impactTitle = "Low Impact";
            $impact = 1;
        } else {
            if ($factor->correlation < 0.25) {
                $impactTitle = "Medium Impact";
                $impact = 2;
            }
        }


        $out .= '<div title="' . $impactTitle . '" class="erankertooltip errankerreportficons errankerreportficons-red">';
        for ($i = 0; $i < $totalIcons; $i++) {
            if ($i < $impact) {
                $out .= '<i class="fa fa-heart"></i>';
            } else {
                $out .= '<i class="fa fa-heart-o"></i>';
            }
        }
        $out .= '</div><!-- .erankertooltip.errankerreportficons.errankerreportficons-red -->';


        $dificulty = 1;
        $dificultTitle = "Easy to Solve";
        if (strcasecmp($factor->difficulty_level, "MEDIUM") === 0) {
            $dificultTitle = "Moderate difficulty";
            $dificulty = 2;
        }
        if (strcasecmp($factor->difficulty_level, "HARD") === 0) {
            $dificultTitle = "Hard to Solve";
            $dificulty = 3;
        }

        $out .= '<div title="' . $dificultTitle . '" class="erankertooltip errankerreportficons errankerreportficons-yellow" >';
        for ($i = 0; $i < $totalIcons; $i++) {
            if ($i < $dificulty) {
                $out .= '<i class="fa fa-star"></i>'; //fa-star-half-o
            } else {
                $out .= '<i class="fa fa-star-o"></i>';
            }
        }

        $out .= '</div><!-- .erankertooltip.errankerreportficons.errankerreportficons-yellow -->';

        $out .= '</div><!-- .ericonsrow -->';

        $out .= '</div><!-- .factor-name -->';

        $out .= '<div class="factor-data col-xs-12 col-sm-12 col-md-8 col-lg-9 noselect">';

        if ($available) {
            $out .= self::getFactorHTMLHelper($report, $factor, $score['model']['model'], $score['data'], $score['model']['status'], $is_loggedin);
        } else {
            $out .= '<i class="fa fa-cog fa-spin"></i> Loading...';
        }

        //if not anchors-text or responsiveness or page in links
        //close div else div is closed in guiAnchorstext function and responsiveness                   
        if ((strcasecmp($factor->id, 'anchors-text') !== 0 && strcasecmp($factor->id, 'responsiveness') !== 0) || (strcasecmp($factor->id, 'anchors-text') !== 0 && strcasecmp($factor->id, 'responsiveness') !== 0 && $available) || !$available || (isset($_SESSION['nullDisplay']) && strcasecmp($_SESSION['nullDisplay'], "nullDisplay") === 0 && strcasecmp($factor->id, 'anchors-text') === 0)) {

            $out .= '</div><!-- .factor-data -->';
        }

        if (strcasecmp($factor->id, 'backlinks') == 0) {
            $out .= '<div class="col can-float factor-data-backlinks">';
            $out .= '</div>';
        }       
         
        $plan = '';
        
        if($is_loggedin && !empty($user_plan) && self::$isPlugin === false){
            $plan = $user_plan;
        }else if(self::$isPlugin === true){
            //plugin work just for premium plan 
            $plan = 'eranker enterprise subscription';
        }
        
        $out .= (($is_loggedin && !empty($plan) && strcasecmp($plan,"free") != 0)
                ? '<div class="clearfix col factor-info" style="display:block;"><p class="beautifyfactor-info">' . stripslashes(html_entity_decode(stripslashes($score['model']['description']))) . '</p>'
                        . (($is_loggedin && !empty($plan) && strcasecmp($plan,"free") != 0) ? ((html_entity_decode(stripslashes(self::translate("howtofixfactor", $factor))) === "howtofixfactor") ? '' : '<p class="beautifyfactor-info">'.html_entity_decode(stripslashes(self::translate("howtofixfactor", $factor))).'</p>') : '') .'</div>'
                : '');

        $out .= '<div class="clearfix"></div>'
                . '</div><!-- .row -->'
                . '<i class="fa fa-minus expandtoggle show-details"></i>'
                . '</div><!-- .erfactor -->';

        return $out;
    }

    /**
     * Get the ajax report object
     * @param object $report the report object
     * @param array $reportFactors all factors object from report
     * @param object $score the report scores
     * @param string $factorsList string list the factors (comma)
     * @param boolean $is_userloggedin if the user is loggedin;
     */
    public static function ajaxReport($report, $reportFactors, $score, $factorsList, $is_userloggedin,$thumbnail=NULL) {
        $ajax_factors = explode(',', trim($factorsList));
        $reportFactors = self::objectToArray($reportFactors);
        $output = array();
        //Add the base report score
        $output['score'] = $score->score;
        $output['status'] = $report->status;
        $output['thumbnailimage'] = self::$imgfolder . "loading-page-preview.gif";
        //get thumbnail
        if(isset($thumbnail) && !empty($thumbnail)){
            $output['thumbnailimage'] = $thumbnail;
        }
        
        //Add on the output data, if the factor is avaiable, factor name, status and the HTML
        if (!empty($ajax_factors)) {
            foreach ($ajax_factors as $ajax_factor_id) {
                if (!in_array($ajax_factor_id, $report->factors_available)) {
                    continue;
                }
                $output[$ajax_factor_id] = array();
                $scoreobj = self::objectToArray($score->$ajax_factor_id);
                
                $output[$ajax_factor_id]['friendly_name'] = $scoreobj['model']['friendly_name'];
                $output[$ajax_factor_id]['status'] = $scoreobj['model']['status'];
                $output[$ajax_factor_id]['html'] = self::getFactorHTMLHelper($report, $reportFactors[$ajax_factor_id], $scoreobj["model"]["model"], $scoreobj["data"], $scoreobj["model"]["status"], $is_userloggedin);
            }
        }
        
        return $output;
    }
    
    /**
     * Generate the report score row HTML
     * @param object $report the report row. Factors cols shall be already converted to array
     * @param object $generalscore The array with the report generic score
     * @param string $format The format/theme we shall output. Default: BIG
     * @return string The html of the report score (the top part of a report). 
     */
    public static function getReportScoreHTML($report, $generalscore, $format = self::BIG, $disable_pdf = false, $show_header = TRUE, $show_title = TRUE, $show_category = TRUE, $thumbnailFactor = NULL) {
        $out = "";
        
        if ($show_header) {
            $report_url = trim(str_replace("http://", "", str_replace("https://", "", $report->url)), " /\\");

            $score_raw_total = $generalscore['factors']['missing'] + $generalscore['factors']['green'] + $generalscore['factors']['orange'] + $generalscore['factors']['red'];

//            if (isset($_GET['pdf']) && !empty($_GET['pdf'])) {
//                $classResponsiveFactorsPercent = 'width: 25% !important; float: left !important;';
//                $classResponsiveScores = 'width: 41.66666667% !important; float: left !important;';
//                $classResponsiveFactorSite = 'width: 33.33333333% !important; float: left !important;';
//            } else {
                $classResponsiveFactorsPercent = '';
                $classResponsiveScores = '';
                $classResponsiveFactorSite = '';
//            }
            //improve that?!?!?!?!?!?!?!?!?!?            
            $translatedwords = array();

            if ((isset($_GET["pdf"]) && isset($_GET["detectedLanguage"])) || isset($_COOKIE['detectedLanguage'])) {
                $detectedLanguage = @$_GET["detectedLanguage"];
                
                if (!$detectedLanguage) {
                    $detectedLanguage = $_COOKIE['detectedLanguage'];
                }
                
                switch ($detectedLanguage) {
                    case 'en':
                        $translatedwords['overall'] = 'Overall';
                        $translatedwords['outof'] = 'out of';
                        $translatedwords['updatenow'] = 'Update now';
                        $translatedwords['downloadpdfreport'] = 'Download PDF Report';
                        $translatedwords['successfullypased'] = 'Successfully passed';
                        $translatedwords['reportforurl'] = 'Report for URL';
                        $translatedwords['roomforimprovement'] = 'Room for improvement';
                        $translatedwords['errors'] = 'Errors';
                        $translatedwords['generatedon'] = 'Generated on';
                        break;
                    case 'ro':
                        $translatedwords['overall'] = 'Total';
                        $translatedwords['outof'] = 'din';
                        $translatedwords['updatenow'] = 'Actualizati acum';
                        $translatedwords['downloadpdfreport'] = 'Descarcati raportul ca PDF';
                        $translatedwords['successfullypased'] = 'Trecut cu succes';
                        $translatedwords['reportforurl'] = 'Raport pentru URL-ul';
                        $translatedwords['roomforimprovement'] = 'De imbunatatit';
                        $translatedwords['errors'] = 'Erori';
                        $translatedwords['generatedon'] = 'Generat la';
                        break;
                    case 'de':
                        $translatedwords['overall'] = 'Insgesamt';
                        $translatedwords['outof'] = 'von';
                        $translatedwords['updatenow'] = 'Jetzt aktualisieren';
                        $translatedwords['downloadpdfreport'] = 'Download PDF Bericht';
                        $translatedwords['successfullypased'] = 'Erfolgreich bestanden';
                        $translatedwords['reportforurl'] = 'Bericht für URL';
                        $translatedwords['roomforimprovement'] = 'Raum für Verbesserung';
                        $translatedwords['errors'] = 'Fehler';
                        $translatedwords['generatedon'] = 'Generiert am';
                        break;
                    case 'fr':
                        $translatedwords['overall'] = 'Globale';
                        $translatedwords['outof'] = 'sur';
                        $translatedwords['updatenow'] = 'Mettre à jour maintenant';
                        $translatedwords['downloadpdfreport'] = 'Télécharger le PDF Rapport';
                        $translatedwords['successfullypased'] = 'Passé avec succès';
                        $translatedwords['reportforurl'] = 'Rapport pour URL';
                        $translatedwords['roomforimprovement'] = 'Marge d\'amélioration';
                        $translatedwords['errors'] = 'Les erreurs';
                        $translatedwords['generatedon'] = 'Généré le';
                        break;
                    default:
                        $translatedwords['overall'] = 'Overall';
                        $translatedwords['outof'] = 'out of';
                        $translatedwords['updatenow'] = 'Update now';
                        $translatedwords['downloadpdfreport'] = 'Download PDF Report';
                        $translatedwords['successfullypased'] = 'Successfully passed';
                        $translatedwords['reportforurl'] = 'Report for URL';
                        $translatedwords['roomforimprovement'] = 'Room for improvement';
                        $translatedwords['errors'] = 'Errors';
                        $translatedwords['generatedon'] = 'Generated on';
                }
            } else {
                $translatedwords['overall'] = 'Overall';
                $translatedwords['outof'] = 'out of';
                $translatedwords['updatenow'] = 'Update now';
                $translatedwords['downloadpdfreport'] = 'Download PDF Report';
                $translatedwords['successfullypased'] = 'Successfully passed';
                $translatedwords['reportforurl'] = 'Report for URL';
                $translatedwords['roomforimprovement'] = 'Room for improvement';
                $translatedwords['errors'] = 'Errors';
                $translatedwords['generatedon'] = 'Generated on';
            }

            
            $classPercent = //(isset($_GET['pdf']) && !empty($_GET['pdf'])) ? '' : 
                    'col-sm-4 col-md-2';
            $divLoadingCircle = '<div class="loadingCircle"></div>';
            $out .= '<div class="row score-table">';
            $score = (int) $generalscore['percentage'] > 1 ? round($generalscore['percentage']) : "&nbsp;";
            $out .= '<div class="' . $classPercent . ' col-lg-3 col-lg-3 factors-percent" style="padding:0 ' . $classResponsiveFactorsPercent . '">' // factors-percent
                    . '<aside>'
                    . '<div class="overall-score" id="overall-score">'
                    . '<p style="padding-bottom: 0px">' . $translatedwords['overall'] . '</p>'
                    . '<h5 class="reportfinalscore" style="padding-bottom: 0px">' . $score . '</h5>'
                    . '<p style="padding-bottom: 0px">' . $translatedwords['outof'] . ' 100</p>'
                    . '<div class="circle" id="circles" data-percent="' . $generalscore['percentage'] . '" ></div>' // percentage chart
                    . '<div class="loadingCircleExternal"><div class="loadingCircle" style="display:none;"></div>'
                    . '</div>'
                    . '</div><!-- #overall-score -->' // overall
                    . '<div class="additional-ratings">'
                    . '<span>' . $translatedwords['generatedon'] . ' ' . self::convertDateTime($report->date_created, 'UTC') . '</span>';
            if ($disable_pdf == FALSE) {
                $out .= '<a id="update-now" onclick="hasSupport()">' . $translatedwords['updatenow'] . '</a></span>';
            }
            $out .= '<ul id="rating-stars">';
            
            $ratings = array('starsbg' => 'star-o', 'stars' => 'star'); // store rating stars
            
            foreach ($ratings as $position => $stars):
                $out .= '<li class="rating-' . $position . '" style="' . ( $position == 'stars' ? 'width:' . round($generalscore['percentage']) / 10 * 10.6 . 'px' : '' ) . '"><div>';
                for ($i = 0; $i < 5; $i++): // 5 stars
                    $out .= '<i class="fa fa-' . $stars . '"></i>';
                endfor;
                $out .= '</div></li>';
            endforeach;
            $out .= '</ul>'
                    . '</div>'; // additional ratings
            
            if (isset($_GET["pdf"])){
                $out .= self::__draw_pie_chart(array(
                    "score" => $generalscore['percentage']
                ), 35, false, array('#0281C4'), 100);
                $out .= '<div id="mask-score-overall"></div>';
            }
            
            $out .= '</aside>';

            if ($disable_pdf || self::$isPlugin){
                if (!isset($_GET['pdf']) && empty($_GET['pdf'])) {
                    if(self::$isPlugin === true){                        
                        $out .= '<div><a data-enabled="true" href="https://www.eranker.com/pdf/?id=' . $report->id . '&lang=' . (isset($detectedLanguage) ? $detectedLanguage : 'en') . '&plugin=set" id="download-pdf">Download PDF Report</a></div>';                        
                    }else{
                        $out .= '<div><a data-enabled="true" href="/pdf/?id=' . $report->id . '&lang=' . (isset($detectedLanguage) ? $detectedLanguage : 'en') . '" id="download-pdf">Download PDF Report</a></div>';
                    }
//                    $out .= '<div><a href="https://www.eranker.com/export?id=' . $report->id . '&amp;type=pdf" id="download-pdf">'. $translatedwords['downloadpdfreport'] .'</a></div>';
                }
            } else {
//                $out .= '<div><a href="/' . $report->domain . '/' . $report->id .
//                        $out .= '<div><a download id="download-pdf" onclick="hasSupport()">'. $translatedwords['downloadpdfreport'] .'</a></div>';
            }

            if(!empty($thumbnailFactor) && (int)$thumbnailFactor['is_active'] === 1){
                if(!isset($thumbnailFactor['data']) || empty($thumbnailFactor['data'])){
                    $thumb_URL = self::$imgfolder . "loading-page-preview.gif";
                }else{                    
                    $thumb_URL = $thumbnailFactor['data'];
                }
            }else{
                $thumb_URL = self::$imgfolder . "loading-page-preview.gif";
            }
            
//            if (!isset($generalscore['thumbnail']) || empty($generalscore['thumbnail'])) {
//                $thumb_URL = self::$imgfolder . "loading-page-preview.gif";
//            } else {
//                $thumb_URL = $generalscore['thumbnail'];
//            }
            $classfactorSite = (isset($_GET['pdf']) && !empty($_GET['pdf'])) ? ' ' : 'col-md-5 hidden-xs hidden-sm';
            $classScores = (isset($_GET['pdf']) && !empty($_GET['pdf'])) ? ' ' : 'col-sm-8 col-md-5';

            if (isset($report->status) && strcasecmp($report->status,"WAITING") === 0) {
                $generalscore['factors']['green'] = 0;
                $generalscore['factors']['missing'] = 0;
                $generalscore['factors']['orange'] = 0;
                $generalscore['factors']['red'] = 0;
            }

            $out .= '</div>' // end factors-percent
                    . '<div class="' . $classScores . ' col-lg-5 factors-score" style="' . $classResponsiveScores . '">' // factors score
                    . '<p>' . $translatedwords['reportforurl'] . ':</p>'
                    . '<h1>' . $report_url . '</h1>'
                    . '<ul>'
                    . '<li class="col green"><i class="fa fa-check"></i><b class="factor-score">' . $translatedwords['successfullypased'] . '<span>' . $generalscore['factors']['green'] . '</span></b><div class="factorbar" style="width:' . ($generalscore['factors']['green'] * 100 / $score_raw_total) . '%"></div></li>'
                    . '<li class="col orange"><i class="fa fa-minus"></i><b class="factor-score">' . $translatedwords['roomforimprovement'] . '<span>' . $generalscore['factors']['orange'] . '</span></b><div class="factorbar" style="width:' . ($generalscore['factors']['orange'] * 100 / $score_raw_total) . '%"></div></li>'
                    . '<li class="col red"><i class="fa fa-times"></i><b class="factor-score">' . $translatedwords['errors'] . '<span>' . ( $generalscore['factors']['red'] + $generalscore['factors']['missing'] ) . '</span></b><div class="factorbar" style="width:' . ($generalscore['factors']['red'] * 100 / $score_raw_total) . '%"></div></li>'
                    . '</ul>'
                    . '<div class="clearfix"></div>'
                    . '</div>' // end factors-score
                    . '<div class="' . $classfactorSite . ' col-lg-4 factors-site" style="' . $classResponsiveFactorSite . '">' // site screen
                    . '<div class="printscreen">'
                    . '<img id="sitescreen" src="' . $thumb_URL . '">' // actual site screen //alt="Website Screenshot: ' . $report_url . '"
                    . '</div>'
                    . '</div>'; // end factors-site
            $out .= '</div><div class="clearfix"></div>'; // end score-table            
        }

        return $out;
    }
    
    /**
     * Get the scores array for the report
     * @param Object $report The report object
     * @param Object $reportData The report data
     * @param Array $reportFactors The list of factors
     * @param boolean $debug The debug flag.
     * @return Array The scores generated
     */
    public static function getScores($report, $reportData, $reportFactors, $thumb = NULL, $debug = false) {
        $out = array();

        $maxScore = 0;
        $currentScore = 0;
        $totalRed = 0;
        $totalGreen = 0;
        $totalOrange = 0;
        $totalMissing = 0;
        $totalNeutral = 0;


        $out["score"] = array(); //Init the score. **See code after the foeach

        $out["url"] = isset($report->url) ? $report->url : NULL;

        if (!empty($reportFactors)) {
            foreach ($reportFactors as $factor) {
                $valueToUse = isset($reportData[$factor->id]) ? $reportData[$factor->id] : NULL;
                if (!empty($factor->path)) {
                    $pathArr = explode("->", trim($factor->path));
                    if (!empty($pathArr)) {
                        foreach ($pathArr as $currentPath) {
                            $valueToUse = (array) $valueToUse;
                            $valueToUse = isset($valueToUse[$currentPath]) ? $valueToUse[$currentPath] : NULL;
                        }
                    }
                }
                /*
                 * Bug report:
                 *      The adsense code, must be NEUTRAL if found a adsense CODE
                 *      And it must be GREEN if any is found
                 *      So, if the String Lenght is above 1 then it should return NEUTRAL
                 * 
                 * Bug patched. Should be fixed someday in a better manner
                 */
                if ($factor->id == "adsense-code") {
                    if (!isset($reportData[$factor->id]) || is_null($reportData[$factor->id])) {
                        $valueToUse = ""; 
                    }
                    if (isset($reportData[$factor->id]) && !empty($reportData[$factor->id])) {
                        if (isset($factor->function)) {
                            $factor->function = self::NEUTRAL;
                        }
                    }
                }
                $statusCode = self::getFactorStatus($valueToUse, $factor);
                $status = self::getFactorStatusText(isset($reportData[$factor->id]) ? $reportData[$factor->id] : NULL, $statusCode, $factor);

                $out[$factor->id] = array();
                $out[$factor->id]['data'] = isset($reportData[$factor->id]) ? $reportData[$factor->id] : NULL;
                $out[$factor->id]['model'] = array();
                //$out[$factor->id]['model']['name'] = isset($factor->id) ? $factor->id : NULL;
                $out[$factor->id]['model']['friendly_name'] = isset($factor->text["friendly_name"]) ? $factor->text["friendly_name"] : NULL;
                $out[$factor->id]['model']['type'] = isset($factor->type) ? $factor->type : NULL;
                /*
                 * Bug report:
                 *      The adsense code, must be NEUTRAL if found a adsense CODE
                 *      And it must be GREEN if any is found
                 *      So, if the String Lenght is above 1 then it should return NEUTRAL
                 * 
                 * Bug patched. Should be fixed someday in a better manner
                 */
                if ($factor->id == "adsense-code") {
                    if (!isset($reportData[$factor->id]) || is_null($reportData[$factor->id])) {
                        $statusCode = self::NEUTRAL; 
                    }
                }
                $out[$factor->id]['model']['status'] = $statusCode;
                $out[$factor->id]['model']['model'] = $status['model'];
                $out[$factor->id]['model']['description'] = $status['description'];
                $out[$factor->id]['model']['path'] = isset($factor->path) ? $factor->path : NULL;
                //$out[$factor->id]['model']['pro_only'] = isset($factor->pro_only) && !empty($factor->pro_only) ? TRUE : FALSE;
                //$out[$factor->id]['model']['free'] = isset($factor->free) && !empty($factor->free) ? TRUE : FALSE;
                $out[$factor->id]['model']['order'] = !isset($factor->order) ? 0 : $factor->order;
                $out[$factor->id]['model']['correlation'] = !isset($factor->correlation) ? null : $factor->correlation;
                $out[$factor->id]['model']['difficulty_level'] = !isset($factor->difficulty_level) ? null : $factor->difficulty_level;
                $out[$factor->id]['model']['article'] = isset($factor->article) ? $factor->article : NULL;
                $out[$factor->id]['model']['solution'] = isset($factor->solution) ? $factor->solution : NULL;
                //Add the factor to the score system
                if ($statusCode === self::RED) {
                    $maxScore += $factor->correlation; //Receive score 0 for this factor
                    $totalRed++;
                }
                if ($statusCode === self::MISSING) {
                    $maxScore += $factor->correlation; //Receive score 0 for this factor
                    $totalMissing++;
                }
                if ($statusCode === self::ORANGE) {
                    $maxScore += $factor->correlation;
                    $currentScore += $factor->correlation * 0.5; //Receive 50% of total score for this factor
                    $totalOrange++;
                }
                if ($statusCode === self::GREEN) {
                    $maxScore += $factor->correlation;
                    $currentScore += $factor->correlation; //Receive 100% of total score for this factor
                    $totalGreen++;
                }
                if ($statusCode === self::NEUTRAL) {
                    $totalNeutral++; //Neutral are ignored on the score
                }

                $out[$factor->id]['model']['category'] = array();
                $out[$factor->id]['model']['category']['order'] = isset($factor->category_order) ? $factor->category_order : NULL;
                $out[$factor->id]['model']['category']['friendly_name'] = isset($factor->category_friendly_name) ? $factor->category_friendly_name : NULL;
                $out[$factor->id]['model']['category']['description'] = isset($factor->category_description) ? $factor->category_description : NULL;
                $out[$factor->id]['model']['category']['bg_color'] = isset($factor->category_bg_color) ? strtoupper($factor->category_bg_color) : NULL;
                $out[$factor->id]['model']['category']['hover_color'] = isset($factor->category_hover_color) ? strtoupper($factor->category_hover_color) : NULL;
                $out[$factor->id]['model']['category']['group'] = array();
                $out[$factor->id]['model']['category']['group']['friendly_name'] = isset($factor->group_friendly_name) ? $factor->group_friendly_name : NULL;
                $out[$factor->id]['model']['category']['group']['description'] = isset($factor->group_description) ? $factor->group_description : NULL;
                $out[$factor->id]['model']['category']['group']['order'] = isset($factor->group_order) ? $factor->group_order : NULL;

                if ($debug) {
                    $out[$factor->id]['model']['debug'] = array(
                        'limit_red' => $factor->limit_red,
                        'limit_orange' => $factor->limit_orange,
                        'limit_green' => $factor->limit_green,
                        'limit_neutral' => $factor->limit_neutral,
                        'function' => $factor->function
                    );
                }
            }
        }
        //Merge the scode data
        $out["score"]["percentage"] = (double) number_format(($currentScore / max(1, $maxScore)) * 100, 1);
        $out["score"]["raw"] = (double) number_format($currentScore, 1);
        $out["score"]["raw_total"] = (double) number_format(max(1, $maxScore), 1);
        $out["score"]["factors"] = (object) array("red" => $totalRed, "orange" => $totalOrange, "green" => $totalGreen, "missing" => $totalMissing, "neutral" => $totalNeutral);
        $out["score"]["thumbnail"] = $thumb;

        return (object) $out;
    }
}