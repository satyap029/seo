<?php
define("NO_RESULTS", "No Results");
$config = parse_ini_file("config.ini");
$json = array();

$q = "site:$_POST[domain] $_POST[word]";
$cache = "cache/" . md5($q);

if (!is_file($cache))
{
    $q = rawurlencode($q);
    $url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=$q&key=$config[apikey]&userip=$_SERVER[REMOTE_ADDR]";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_REFERER, $config['referer']);
    $data = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($data);

    $results = $data->responseData->results;
    file_put_contents($cache, serialize($results));
}
else
{
    $results = unserialize(file_get_contents($cache));
}

$urls = array();
$urls[] = $results[0] ? $results[0]->unescapedUrl : NO_RESULTS;
$urls[] = $results[1] ? $results[1]->unescapedUrl : NO_RESULTS;
$urls[] = $results[2] ? $results[2]->unescapedUrl : NO_RESULTS;


$json['urls'] = $urls;
$json['word'] = $_POST['word'];

die(json_encode($json));