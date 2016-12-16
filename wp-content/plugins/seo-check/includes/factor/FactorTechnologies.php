<?php

//require 'interface.eranker.php';


class FactorTechnologies
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        //technologies
        $technologies1 = array('Google Postini Services', 'Time Warner', 'Yahoo Web Analytics', 'Network Solutions DNS', 'Network Solutions SSL Wildcard', 'Adobe Dreamweaver',
            'Google Adsense Asynchronous', 'Reg.ru DNS', 'qTranslate', 'Explorer Canvas', 'JBoss', 'ATInternet', 'Lunar Pages', 'Amazon Elastic Load Balancing', 'GlobalSign', 'Verizon DNS',
            'Oracle Application Server', 'Symantec.cloud', 'Akamai DNS', 'Akamai SSL', 'jQuery Autocomplete', 'Joomla!', 'Level 3 Communications', 'Websense', 'ATT DNS', 'Comodo EliteSSL',
            'GeoTrust QuickSSL Premium', 'Google App Engine', 'Hostway', 'Mailgun', 'Return Path', 'Proofpoint', 'Netscape Enterprise Server', 'Namecheap', 'Namecheap DNS', 'Linode', 'Adap.TV',
            'Adblade', 'Add to Any', 'AddThis', 'Adobe ColdFusion', 'Adobe CQ', 'Adobe Dynamic Tag Management', 'Adobe Target Standard', 'Adobe', 'Adometry', 'AdRoll', 'Aggregate Knowledge',
            'AJAX Libraries API', 'Akamai Edge', 'Akamai Hosted', 'Akamai', 'Alexa Certified Site Metrics', 'Alexa Metrics', 'Amazon Ad System', 'Amazon Associates', 'Amazon Elastic Beanstalk',
            'Amazon Oregon Region', 'Amazon Route 53', 'Amazon S3', 'Amazon SES', 'Amazon Virginia Region', 'Amazon', 'Angular JS', 'Apache 2.2', 'Apache 2.4', 'Apache Tomcat Coyote', 'Apache',
            'Apple Mobile Web App Capable', 'Apple Mobile Web App Status Bar Style', 'Apple Mobile Web Clips Icon', 'Apple Mobile Web Clips Startup', 'AppNexus Segment Pixel', 'AppNexus',
            'ASP.NET', 'AT Internet', 'Atlas', 'aWeber', 'Backbone.js', 'BBC Glow', 'BIG-IP', 'Bing Conversion Tracking', 'Bing Universal Event Tracking', 'BloomReach', 'Blue Box Group', 'Blue State Digital',
            'BlueKai', 'Bootstrap Sortable', 'Braintree Mail', 'Burst Media', 'Campaign Monitor', 'Canada Post', 'carouFredSel', 'Casale Media', 'CDN JS', 'Cedexis', 'Certona', 'Chango', 'ChannelAdvisor',
            'Choopa', 'Classic ASP', 'CloudFlare DNS', 'CloudFlare Hosting', 'CloudFlare SSL', 'CloudFront', 'Commission Junction', 'Comodo Essential SSL WildCard', 'Comodo PositiveSSL Wildcard',
            'Comodo PositiveSSL', 'Comodo SSL', 'comScore', 'Constant Contact', 'Contact Form 7', 'ContextWeb', 'Conversant', 'Convertro', 'CrazyEgg', 'Criteo', 'cufón', 'Datalogix', 'DataXu', 'Dedicated Media',
            'Device Height', 'Device Width', 'Didit', 'Digg', 'DigiCert SSL', 'DNS Made Easy DNS', 'DNS Prefetch', 'DOSarrest', 'dotCMS', 'Dotomi', 'DoubleClick Floodlight', 'DoubleClick.Net',
            'DoubleVerify', 'Dreamhost DNS', 'DreamHost Hosting', 'Drupal 7', 'Drupal Version 7.3x', 'Drupal', 'Dyn DNS', 'Dyn', 'Dynatrace', 'Efficient Frontier', 'Eloqua', 'Emarsys', 'EPiServer',
            'Equal Heights', 'eranker', 'EssentialSSL', 'Everest Technologies', 'Evidon', 'ExactTarget Email', 'ExpressionEngine', 'Facebook Custom Audiences', 'Facebook Domain Insights', 'Facebook Exchange FBX',
            'Facebook for Websites', 'Facebook Like Box', 'Facebook Like Button', 'Facebook Like', 'Facebook Page Administration', 'Facebook SDK', 'Facebook', 'Fancybox', 'FastClick', 'Fastly',
            'FedEx', 'Fingerprint', 'Flashtalking', 'Flattr', 'FlexSlider', 'Font Awesome', 'ForeSee Results', 'Friends Network', 'GeoTrust QuickSSL', 'GeoTrust SSL', 'GetResponse', 'GitHub Hosting', 'GoDaddy DNS',
            'GoDaddy Email', 'GoDaddy SSL', 'GoDaddy', 'Google Analytics Ecommerce', 'Google Analytics Multiple Trackers', 'Google Analytics', 'Google API', 'Google Apps for Business', 'Google Chrome IE Frame', 'Google Chrome Webstore Application',
            'Google Conversion Tracking', 'Google DNS', 'Google Font API', 'Google Hosted jQuery UI'
        );

        $technologies2 = array('Google Hosted jQuery', 'Google Hosted Libraries', 'Google JS Api', 'Google Maps API', 'Google Maps',
            'Google Plus One Button', 'Google Plus One Platform', 'Google Plus One Publisher', 'Google Remarketing', 'Google SSL', 'Google Universal Analytics', 'Google Website Optimizer', 'Google', 'GSAP',
            'Handheld Friendly', 'Hetzner', 'Highcharts', 'HostEurope DNS', 'Hostgator Mail', 'HREF Lang', 'HTML5 Boilerplate', 'html5shiv', 'Humans TXT', 'IBM HTTP Server', 'IE Pinning', 'IIS 6', 'IIS 7',
            'IIS 8', 'IIS', 'Imgur', 'Impact Radius', 'Incapsula CDN', 'Incapsula', 'InsightExpress', 'Integral Ad Science', 'Intercom Mail', 'Internap', 'IPhone  Mobile Compatible', 'IponWeb BidSwitch', 'Isotope',
            'J2EE', 'jQuery 1.3.2', 'jQuery CDN', 'jQuery Cookie', 'jQuery Cycle', 'jQuery Form', 'jQuery Mousewheel', 'jQuery prettyPhoto', 'jQuery UI', 'jQuery Watermark', 'jQuery', 'Kenshoo', 'KISSmetrics',
            'KnockoutJS', 'Level3', 'Lijit Widget', 'LinkedIn Platform API', 'Liquid Web', 'LiteSpeed', 'Live Writer Support', 'Livestream', 'LocaWeb DNS', 'Locaweb Mail', 'Locaweb SSL', 'Lotame Crowd Control', 'MailChimp SPF',
            'MailChimp', 'MailJet', 'Mandrill', 'matchMedia', 'Maxymiser', 'McAfee SaaS Email', 'MediaMind', 'Mediaplex', 'Message Bus', 'Microdata for Google Shopping', 'Microsoft Ajax Content Delivery Network', 'Microsoft Azure CDN',
            'Microsoft Azure DNS', 'Microsoft Exchange Online', 'Microsoft Personal Web Server', 'Microsoft SharePoint Server 2013', 'Microsoft', 'MidPhase', 'Mixpanel', 'Moat', 'Mobify', 'Mobile Non Scaleable Content',
            'Mobile Optimized', 'Modernizr', 'Moment JS', 'Monetate', 'Mustache', 'Netmining', 'Network Solutions Email Hosting', 'New Relic', 'nginx 1.1', 'nginx', 'Ning', 'NTT America', 'Omniture Adobe Test and Target',
            'Omniture SiteCatalyst', 'One.com', 'OneAll', 'Open Graph Protocol', 'Openads OpenX', 'OpenSSL', 'Optimize Press', 'Orientation', 'OVH', 'OwnerIQ', 'Perl', 'PHP', 'Phusion Passenger', 'Pinterest',
            'pjax', 'Post Affiliate Pro', 'PowWeb', 'Prototype', 'Pubmatic', 'Qualtrics Site Intercept', 'Quantcast Measurement', 'RapidSSL', 'Rapleaf', 'Really Simple Discovery', 'reCAPTCHA', 'Register.com DNS',
            'RequireJS', 'Resolution', 'Retina JS', 'Rubicon Project', 'Ruby on Rails Token', 'Ruby on Rails', 'Safe Count', 'Salesforce SPF', 'Satellite', 'Savvis', 'script.aculo.us', 'Search Everything', 'Sendgrid', 'Shareaholic',
            'ShareASale', 'ShareThis', 'Shockwave Flash Embed', 'ShopTab', 'Sidecar', 'Sitelinks Search Box', 'Smart App Banner', 'SPF', 'Spotify Play Button', 'SpotXchange', 'Starfield Technologies', 'StatCounter',
            'Symantec VeriSign', 'TeaLeaf', 'Tealium', 'Thawte Seal', 'Thawte SSL Certificate', 'Thawte SSL', 'The Trade Desk', 'TownNews.com', 'TRUSTe', 'Trustwave Seal', 'Trustwave SSL', 'Tumblr Buttons', 'Turn', 'Twemoji',
            'Twenty Twelve', 'Twitter Bootstrap', 'Twitter Cards', 'Twitter Follow Button', 'Twitter Platform', 'Twitter Timeline', 'Typekit', 'Ubuntu', 'UltraDNS neustar', 'UPS', 'USPS', 'Varnish', 'VideoJS', 'Viewport Meta', 'Vimeo',
            'VINDICO', 'Visual Revenue', 'VoiceFive', 'W3 Total Cache', 'WebTrends', 'Windows 8 Pinning', 'Wistia', 'WordPress 4.0', 'Wordpress 4.2', 'Wordpress Daily Activity', 'WordPress DNS', 'Wordpress Monthly Activity', 'Wordpress SSL',
            'WordPress Weekly Activity', 'WordPress', 'World Now', 'WP Retina 2x', 'X-Frame-Options', 'XiTi', 'X-UA-Compatible', 'X-XSS-Protection', 'Yahoo Buzz', 'Yahoo Dot', 'Yahoo Image CDN', 'Yahoo Small Business', 'Yahoo User Interface', 'Yahoo',
            'yepnope', 'Yield Manager', 'Yoast Plugins', 'Yoast WordPress SEO Plugin', 'YouTube', 'YUI3', 'Zendesk', 'ZeroClipboard', 'Zerolag'
        );
        //all technologies with image in technologies folder

        $html = '<p>' . self::translate("foundtechnologies", $factor) . '</p>';
        $html .='<br />'
            . '<div class="row">';

        if (!empty($data)) {
            foreach ($data as $singleTec) {
                $imglink = '';

                if (in_array($singleTec, $technologies1) || in_array($singleTec, $technologies2)) {
                    $imglink .= $singleTec . '.png';
                } else {
                    $imglink .= 'eranker.png';
                }

                $tagimg = '';

                if (!empty($imglink)) {
                    $tagimg .= '<img src="' . self::$imgfolder . 'technologies/' . $imglink . '"  height="24" width="24">';
                }

                $html .='<div class=" col-xs-12 col-sm-6 col-md-4 col-lg-4 nopaddingleft paddingupdown"> ' . $tagimg . ' ' . $singleTec . '</div>';

                $tagimg = '';
            }
        } else {
            $html .= '<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 nopaddingleft"> ' . $endModel . '</div>';
        }

        $html .= '</div>';

        return !empty($html) ? $html : self::translate('notfoundduplicatecontent', $factor);
    }

}