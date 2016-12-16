<?php

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

function spam_tool() {

$spamclientid = get_option('seo_tools_spamclientid');
$spampublickey = get_option('seo_tools_spampublickkey');

if (get_option('seo_tools_spamwording') != 'on') {
    $spamwording = '<p>Get started by clicking the initialize button below. You will be asked to authorize access to your Google Analytics data, and you will then see the available domains for filter importation. Use CTRL to select multiple domains.</p>';
}
    
$spamfiltertool = '

  <div class="jumbotron coverbox clearfix">
    <div id="progress"></div>
        '.$spamwording.'
    <div id="info" class="clearfix">
      <p class="text-center"><button type="button" class="btn btn-primary btn-lg" id="init">Initialize</button></p>
    </div>
    <div class="col-md-6 form-group" id="accounts"></div>
    <div class="col-md-6 form-group" id="profiles"></div>
    <div class="col-md-12 text-center" id="action"></div>
    <!--<div class="col-md-12"><a href="http://www.google.com/analytics"><img src="google-analytics-logo.png" style="float:right;"/></a></div>-->
  </div>

<script type="text/javascript">
var clientId = "'.$spamclientid.'";
var apiKey = "'.$spampublickey.'";
var scopes = "https://www.googleapis.com/auth/analytics.readonly https://www.googleapis.com/auth/analytics.manage.users.readonly https://www.googleapis.com/auth/analytics.edit";

function handleClientLoad() {
  var initButton = document.getElementById(\'init\');
  initButton.onclick = function() {
    gapi.client.setApiKey(apiKey);
    window.setTimeout(checkAuth, 1);
  }
}

function checkAuth() {
  gapi.auth.authorize({
    client_id: clientId, scope: scopes, immediate: false}, handleAuthResult);
}

function handleAuthResult(authResult) {
  if (authResult) {
    gapi.client.load(\'analytics\', \'v3\', spamFilter.initialize);
  } else {
    spamFilter.showError({
      \'reason\' : {
        \'result\' : {
          \'error\' : {
            \'message\' : \'Authentication failed.\'
          }
        }
      }
    });
  }
}
</script>

<script src="' . plugins_url( 'spam-filter-tool/js/spamfilter.js', dirname(__FILE__) ) . '"></script>
<script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
';

return $spamfiltertool;
}

add_shortcode( 'spamtool', 'spam_tool' );
?>