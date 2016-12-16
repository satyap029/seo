<?php

class FactorHttp2check
    extends eRankerBase 
    implements FactorDisplay 
{

    public static function getDisplay($endModel, $data, $report, $factor) {
        $html = "";

        if (isset($data) && isset($data['valid']) && !empty($data['valid'])) {
            $html .= "<h4><i class='fa fa-check-circle greentext'></i> " . self::translate('valid', $factor) . "</h4>";
        } else if (isset($data) && isset($data['valid']) && empty($data['valid'])) {
            $html .= "<h4><i class='fa fa-info-circle redtext'></i> " . self::translate('invalid', $factor) . "</h4>";
        }

        if (isset($data['http2_status']) && !empty($data['http2_status'])) {
            $html .= "<div class='row'>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('http2status', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['http2_status'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['ssl'])) {
            $html .= "<div class='row '>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('ssl_enabled', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . (empty($data['ssl']) ? '<i class="fa fa-times-circle redtext"></i>' : '<i class="fa fa-check-square-o greentext"></i>') . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['ssl_status']) && !empty($data['ssl_status'])) {
            $html .= "<div class='row '>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('sslstatus', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['ssl_status'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['ssl_certificate_valid'])) {
            $html .= "<div class='row '>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('certificate', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . (empty($data['ssl_certificate_valid']) ? '<i class="fa fa-times-circle redtext"></i>' : '<i class="fa fa-check-square-o greentext"></i>') . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }


        if (isset($data['content-length']) && !empty($data['content-length'])) {
            $html .= "<div class='row '>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('total_length', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['content-length'] . " Bytes</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['server']) && !empty($data['server'])) {
            $html .= "<div class='row '>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('server', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['server'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }
        $statusString = '';
        $colorStatus = '';


        $text = 'Unknown http status code';
        if (isset($data['status_code']) && !empty($data['status_code'])) {

            if ($data['status_code'] <= 299) {
                $colorStatus = "style='color:green;'";
            }
            if ($data['status_code'] >= 299) {
                $colorStatus = "style='color:#E7711B;'";
            }
            if ($data['status_code'] >= 399) {
                $colorStatus = "style='color:#ED1111;'";
            }

            switch ($data['status_code']) {
                case 100: $text = 'Continue';
                    break;
                case 101: $text = 'Switching Protocols';
                    break;
                case 200: $text = 'OK';
                    break;
                case 201: $text = 'Created';
                    break;
                case 202: $text = 'Accepted';
                    break;
                case 203: $text = 'Non-Authoritative Information';
                    break;
                case 204: $text = 'No Content';
                    break;
                case 205: $text = 'Reset Content';
                    break;
                case 206: $text = 'Partial Content';
                    break;
                case 300: $text = 'Multiple Choices';
                    break;
                case 301: $text = 'Moved Permanently';
                    break;
                case 302: $text = 'Moved Temporarily';
                    break;
                case 303: $text = 'See Other';
                    break;
                case 304: $text = 'Not Modified';
                    break;
                case 305: $text = 'Use Proxy';
                    break;
                case 400: $text = 'Bad Request';
                    break;
                case 401: $text = 'Unauthorized';
                    break;
                case 402: $text = 'Payment Required';
                    break;
                case 403: $text = 'Forbidden';
                    break;
                case 404: $text = 'Not Found';
                    break;
                case 405: $text = 'Method Not Allowed';
                    break;
                case 406: $text = 'Not Acceptable';
                    break;
                case 407: $text = 'Proxy Authentication Required';
                    break;
                case 408: $text = 'Request Time-out';
                    break;
                case 409: $text = 'Conflict';
                    break;
                case 410: $text = 'Gone';
                    break;
                case 411: $text = 'Length Required';
                    break;
                case 412: $text = 'Precondition Failed';
                    break;
                case 413: $text = 'Request Entity Too Large';
                    break;
                case 414: $text = 'Request-URI Too Large';
                    break;
                case 415: $text = 'Unsupported Media Type';
                    break;
                case 500: $text = 'Internal Server Error';
                    break;
                case 501: $text = 'Not Implemented';
                    break;
                case 502: $text = 'Bad Gateway';
                    break;
                case 503: $text = 'Service Unavailable';
                    break;
                case 504: $text = 'Gateway Time-out';
                    break;
                case 505: $text = 'HTTP Version not supported';
                    break;
                default: $text = 'Unknown http status code';
                    break;
            }
        }

        if (isset($data['status_code']) && !empty($data['status_code'])) {
            $html .= "<div class='row '>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('status', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span $colorStatus>" . $data['status_code'] . " - " . $text . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }


        if (isset($data['url']) && !empty($data['url'])) {
            $html .= "<div class='row '>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>URL</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span><a href='" . $data['url'] . "' target='_blank'>" . $data['url'] . "</a></span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['protocol']) && !empty($data['protocol'])) {
            $html .= "<div class='row '>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('protocol', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['protocol'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['host_name']) && !empty($data['host_name'])) {
            $html .= "<div class='row '>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('host_name', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['host_name'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['content_type']) && !empty($data['content_type'])) {
            $html .= "<div class='row '>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('content_type', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['content_type'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }


        if (isset($data['client_real_ip']) && !empty($data['client_real_ip'])) {
            $html .= "<div class='row'>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('client_real_ip', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['client_real_ip'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['client_ip']) && !empty($data['client_ip'])) {
            $html .= "<div class='row'>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('client_ip', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['client_ip'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if (isset($data['host_ip']) && !empty($data['host_ip'])) {
            $html .= "<div class='row'>";
            $html .= "<div class='col-md-4'>";
            $html .= "<span><strong>" . self::translate('host_ip', $factor) . "</strong></span>";
            $html .= "</div>";
            $html .= "<div class='col-md-8 stayniceatlowdim'>";
            $html .= "<span>" . $data['host_ip'] . "</span>";
            $html .= "</div>";
            $html .= "</div>";
        }

        if ($data === null) {
            $html .= "<h4><i class='fa fa-info-circle redtext'></i> " . self::translate('model_red', $factor) . "</h4>";
        }

        return $html;
    }

}