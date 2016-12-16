<?PHP

global $seocheck_settings, $erapi, $seocheck_accountcachetime, $seocheck_leadsettings, $erroragent, $msgerror;

// Check if Wordpress is Loaded
if (!function_exists('add_action')) {
    exit('Sorry, you can not execute this file without wordpress.');
}

// Only load if the page is right  
if (!isset($_GET['page']) || strcasecmp($_GET['page'], 'seocheck_page_leadgenerator') !== 0) {
    return; //This will stop the execution is it is not the rigth page
}

// Read the post an same
global $seocheck_leadsettings_saved, $seocheck_leadsettings;
if (isset($_POST) && isset($_POST['seocheck_leadgeneratorsettings']) && !empty($_POST['seocheck_leadgeneratorsettings']) && is_admin() && current_user_can('manage_options')) {
    $erroragent = FALSE;
    $seocheck_leadsettings = get_option('seocheck_leadsettings');
    $msgerror = '';


    if (empty($seocheck_leadsettings) || !is_array($seocheck_leadsettings)) {
        $seocheck_leadsettings = array();
    }
    $seocheck_leadsettings['useleadgenerator'] = isset($_POST['seocheck_useleadgenerator']) ? (int) $_POST['seocheck_useleadgenerator'] : FALSE;
    $seocheck_leadsettings['layout'] = isset($_POST['seocheck_layout']) ? trim(strtoupper($_POST['seocheck_layout'])) : 'POPUP';
    $seocheck_leadsettings['howshowthemodal'] = isset($_POST['seocheck_howshowthemodal']) ? trim(strtoupper($_POST['seocheck_howshowthemodal'])) : 'report20';
    $seocheck_leadsettings['adminemail'] = isset($_POST['seocheck_adminemail']) ? trim(strtolower($_POST['seocheck_adminemail'])) : get_option('admin_email');
    $seocheck_leadsettings['forcefillform'] = isset($_POST['seocheck_forcefillform']) ? trim(strtolower($_POST['seocheck_forcefillform'])) : 0;
    $seocheck_leadsettings['agents']['default']['name'] = isset($_POST['seocheck_defaultagent_name']) && !empty($_POST['seocheck_defaultagent_name']) ? $_POST['seocheck_defaultagent_name'] : 'Support';
    $seocheck_leadsettings['agents']['default']['position'] = isset($_POST['seocheck_defaultagent_position']) && !empty($_POST['seocheck_defaultagent_position']) ? $_POST['seocheck_defaultagent_position'] : '';
    $seocheck_leadsettings['agents']['default']['image'] = isset($_POST['seocheck_defaultagent_image']) && !empty($_POST['seocheck_defaultagent_image']) ? $_POST['seocheck_defaultagent_image'] : '';
    $seocheck_leadsettings['agents']['default']['text'] = isset($_POST['seocheck_defaultagent_text']) && !empty($_POST['seocheck_defaultagent_text']) ? $_POST['seocheck_defaultagent_text'] : '';
    $seocheck_leadsettings['agents']['default']['text_button'] = isset($_POST['seocheck_defaultagent_text_button']) && !empty($_POST['seocheck_defaultagent_text_button']) ? $_POST['seocheck_defaultagent_text_button'] : '';
    $seocheck_leadsettings['agents']['default']['logo'] = isset($_POST['seocheck_defaultagent_logo']) && !empty($_POST['seocheck_defaultagent_logo']) ? $_POST['seocheck_defaultagent_logo'] : '';
    $seocheck_agents = array();
	if(isset($_POST['seocheck_additional_agents_referer']) && !empty($_POST['seocheck_additional_agents_referer'])){
	if (count($_POST['seocheck_additional_agents_referer']) !== count(array_unique($_POST['seocheck_additional_agents_referer']))) {
        $erroragent = TRUE;
        $msgerror = 'The referer not can be equal';
    }	
	}
    
    if ($erroragent !== TRUE) {
		if(!empty($_POST['seocheck_additional_agents_name']) && isset($_POST['seocheck_additional_agents_name'])){
        for ($i = 0; $i < count($_POST['seocheck_additional_agents_name']); $i++) {
            $name = (!empty($_POST['seocheck_additional_agents_name'][$i])) ? $_POST['seocheck_additional_agents_name'][$i] : null;
            $position = (!empty($_POST['seocheck_additional_agents_position'][$i])) ? $_POST['seocheck_additional_agents_position'][$i] : null;
            $image = (!empty($_POST['seocheck_additional_agents_image'][$i])) ? $_POST['seocheck_additional_agents_image'][$i] : null;
            $text = (!empty($_POST['seocheck_additional_agents_text'][$i])) ? $_POST['seocheck_additional_agents_text'][$i] : null;
            $text_button = (!empty($_POST['seocheck_additional_agents_text_button'][$i])) ? $_POST['seocheck_additional_agents_text_button'][$i] : null;
            $logo = (!empty($_POST['seocheck_additional_agents_logo'][$i])) ? $_POST['seocheck_additional_agents_logo'][$i] : null;
            $referer = (!empty($_POST['seocheck_additional_agents_referer'][$i])) ? $_POST['seocheck_additional_agents_referer'][$i] : null;

            if (empty($referer)) {
                $erroragent = TRUE;
                $msgerror = 'The referer not can be empty';
            }

            $seocheck_agents[] = array('name' => $name, 'position' => $position, 'image' => $image, 'text' => $text, 'logo' => $logo, 'referer' => $referer, 'text_button' => $text_button);
        }
		}
        $seocheck_leadsettings['agents']['additional_agents'] = $seocheck_agents;

        //Save the new data
        //print_r($seocheck_leadsettings);
        if ($erroragent !== TRUE) {
            update_option('seocheck_leadsettings', $seocheck_leadsettings);
            $seocheck_leadsettings_saved = true;
            $seocheck_leadsettings = get_option('seocheck_leadsettings');
        }
    }
} else {
    $seocheck_leadsettings_saved = false;
}

