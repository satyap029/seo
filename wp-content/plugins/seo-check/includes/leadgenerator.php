<?php

header('Content-Type: application/json');


$out = array();

$parse_uri = explode('content', __FILE__);
require_once($parse_uri[0] . 'load.php' );
$wp->init();


require_once ('../seo-check.php');

global $seocheck_leadsettings;

if (!isset($_POST['name_leadgenerator']) || empty($_POST['name_leadgenerator'])) {
    $out['msg'] = ' You need enter your name';
    $out['error'] = 1;
    echo json_encode((object) $out);
    exit;
}

if (!isset($_POST['email_leadgenerator']) || empty($_POST['email_leadgenerator']) || strstr($_POST['email_leadgenerator'], '@') == FALSE || strlen($_POST['email_leadgenerator']) <= 5) {
    $out['msg'] = '  You need enter your email';
    $out['error'] = 1;
    echo json_encode((object) $out);
    exit;
}

if (!isset($_POST['phone_leadgenerator']) || empty($_POST['phone_leadgenerator'])) {
    $out['msg'] = ' You need enter the phone number';
    $out['error'] = 1;
    echo json_encode((object) $out);
    exit;
}

$name = $_POST['name_leadgenerator'];
$company_name = (isset($_POST['companyname_leadgenerator']) && !empty($_POST['companyname_leadgenerator'])) ? $_POST['companyname_leadgenerator'] : '';
$email = $_POST['email_leadgenerator'];
$phone = $_POST['phone_leadgenerator'];
$reporturl = $_POST['reporturl'];

$admin_email = $seocheck_leadsettings['adminemail'];



$sc_subject = 'Lead Generator info';
$sc_message .= "<html>";
$sc_message .= "<head>";
$sc_message .= "</head>";
$sc_message .= "<body>";
$sc_message .= "Hi,<br/><br/>You got a new Lead on your website:<br>";
$sc_message .="<div style='background-color:#f3f3f3;padding:20px;border-radius:5px;'>";
$sc_message .="<b>Name</b>: $name<br>";
$sc_message .="<b>Company Name</b>: $company_name<br>";
$sc_message .="<b>Phone</b>: $phone<br>";
$sc_message .="<b>Email</b>: $email<br>";
$sc_message .="<b>Report Url</b>: $reporturl<br>";
$sc_message .="</div>";
$sc_message .= "</body>";
$sc_message .= "</html>";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers  = 'From: '.get_option('admin_email'). "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//$admin_email = get_option('admin_email');


if (!empty($_POST['name_leadgenerator'])) {
    $sendemail = mail($admin_email, $sc_subject, $sc_message, $headers);
    if ($sendemail) {
        setcookie("leadgenerated", '1', time()+60*60*24*30,"/"); 
        $out['msg'] = ' Your contact was sent successfully';
        $out['error'] = 0;
    } else {
        $out['msg'] = ' Error ao enviar o email';
        $out['error'] = 0;
    }
} else {
    $out['msg'] = 'errou';
    $out['error'] = 0;
}
echo json_encode((object) $out);

