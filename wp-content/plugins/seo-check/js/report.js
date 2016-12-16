//USE $ INSTEAD OF JQUERY
var $ = jQuery.noConflict();

var urlLeadGenerate = "/content/themes/eranker/libs/leadgenerator.php";
var flagAppend1 = false;
var flagAppend2 = false;
var flagAppend3 = false;
var appendFlag = false;
var reportScoreCircle;
var reportDownloadRetries = 0;
var ssnotavailable_icon = "data:image/png;base64,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";
var ssloading_icon = "data:image/gif;base64,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";
var downloadlink = null;

if(typeof messageerreport === "undefined"){
    var messageerreport = {};
    
    messageerreport.required = 'This field is required ';
    messageerreport.multiemail = 'You must enter a valid email, or comma separate multiple ';
    messageerreport.fail = 'Fail! ';
    messageerreport.fail_content = 'Your action have no effect! ';
    messageerreport.success = 'Success! ';
    messageerreport.success_content = 'The monitor was created! ';
    messageerreport.submit_err_title = 'Fail!';
    messageerreport.submit_err_content = 'Your action has no effect! ';
}

function isMobileBrowser() {
    if (/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) === true) {
        return true;
    } else {
        return false;
    }
}

if (window.location.host.indexOf('dev.eranker.com') !== -1 || window.location.host.indexOf('www.eranker.com') !== -1) {
    var erankerhost = true;
} else {
    var erankerhost = false;
}

function clickMenu() {    
    $('.navilist').click(function () {        
        localStorage.setItem('clickActive', 'true');
        
        $('.navilist').each(function(){
            $(this).removeClass('naviliactive');
        });    
        
        if (typeof clicked != "undefined" && clicked.hasClass('naviliactive')) {
            clicked.removeClass('naviliactive');
        }
        
        $(this).addClass('naviliactive');
        
        clicked = $(this);
        
        if ($('.navimenuminwidth').is(':visible')) {
            $('.navimenuminwidth').css('position','fixed');           
            $('.navimenuminwidth').removeClass('forcetop').addClass('forcetop');
        }else if($('.navimenu').is(':visible')){
            $('.navimenu').css('position','fixed');           
            $('.navimenu').removeClass('forcetop').addClass('forcetop');
        }
        
        var pos;
        if ($(this).hasClass('secondlist')){
            pos = $('.ercategory[data-category_id=' + $(this).attr('id') + ']').offset().top - $('.navimenuminwidth').height();
        } else {
            if ($(this).hasClass('grlist')) {
                pos = $('.ergroup[data-group_id=' + $(this).attr('id') + ']').offset().top;
            } else {
                pos = $('.ercategory[data-category_id=' + $(this).attr('id') + ']').offset().top;
            }
        }
        
        pos = pos + 1;
        
        $('html, body').animate({scrollTop:pos}, 'slow',function(){            
            setTimeout(function(){                
                localStorage.removeItem('clickActive');
            }, 200);            
        });
        
        //$(window).scrollTop(pos);
    });
}

function detectTopOffset(who) {
    var items = [];

    if (who == "navimenuminwidth") {
        $('.' + who + ' .navilist').each(function () {
            var val;
            if ($('.ergroup[data-group_id=' + $(this).attr('id') + ']').length != 0) {
                val = $('.ergroup[data-group_id=' + $(this).attr('id') + ']').offset().top - $('.navimenuminwidth').height();
            } else if ($('.ercategory[data-category_id=' + $(this).attr('id') + ']').length != 0) {
                val = $('.ercategory[data-category_id=' + $(this).attr('id') + ']').offset().top - $('.navimenuminwidth').height();
            }

            var item = {};
            item[$(this).attr('id')] = {min: val};
            items.push(item);
        });
    } else {
        $('.' + who + ' .navilist').each(function () {
            var val;
            if ($('.ergroup[data-group_id=' + $(this).attr('id') + ']').length != 0) {
                val = $('.ergroup[data-group_id=' + $(this).attr('id') + ']').offset().top;
            } else if ($('.ercategory[data-category_id=' + $(this).attr('id') + ']').length != 0) {
                val = $('.ercategory[data-category_id=' + $(this).attr('id') + ']').offset().top;
            }

            var item = {};
            item[$(this).attr('id')] = {min: val};
            items.push(item);
        });
    }

    for (var i = 0; i < items.length; i++) {
        items[i][Object.keys(items[i])[0]]["max"] = items[items.length - 1][Object.keys(items[items.length - 1])[0]].min;
    }

    for (var i = 0; i < items.length; i++){
        try{
            if (i === 0) {
                items[i][Object.keys(items[i])[0]].min = 0;
            }
            
            if(i < (items.length - 1)){
                items[i][Object.keys(items[i])[0]].max = items[i + 1][Object.keys(items[i + 1])[0]].min;
            }            
            
            if(i === (items.length - 1)){                
                if($('.ergroup[data-group_id="'+ Object.keys(items[i])[0] +'"]').length > 0){                   
                    var toadd = $('.ergroup[data-group_id="'+ Object.keys(items[i])[0] +'"]').height();                    
                    items[i][Object.keys(items[i])[0]].max = items[i][Object.keys(items[i])[0]].min + toadd;
                }else if($('.ercategory[data-category_id="'+ Object.keys(items[i])[0] +'"]').length > 0){
                    var toadd = $('.ercategory[data-category_id="'+ Object.keys(items[i])[0] +'"]').height();                    
                    items[i][Object.keys(items[i])[0]].max = items[i][Object.keys(items[i])[0]].min + toadd;
                }                
            }

        }catch (e) {
            console.log("Error:",e);
        }
    }
    
    return items;
}

function mainLogicQuickNav(){    
    if ($('.navimenu').is(':visible')) {
        var items = detectTopOffset('navimenu');
        var currentitem = Object.keys(items[0])[0];            
    }

    if ($('.navimenuminwidth').is(':visible')) {
        var seconditems = detectTopOffset('navimenuminwidth');            
        var secondcurrentitem = Object.keys(seconditems[0])[0];
    }
    
    //if menu exist calculate all else fix min menu and hide max menu
    if($('.mega-menu') !== null && $('.mega-menu').length > 0){
        var increase = parseInt($('.mega-menu').height()) + parseInt($('.navimenuminwidth').height()) + parseInt($('.superreport-seo').css('margin-top').split('px')[0]); 
        
        if($('.helpnavimenuwidth').is(':visible') && $('.navbar-responsive-collapse').height() > 0){
            var addvalue = increase;
        }else if($('.helpnavimenuwidth').is(':visible') && $('.navbar-responsive-collapse').height() <= 0){        
            var addvalue = $('.navbar-header').offset().top + $('.navbar-header').height();
        }else{
            if($('.navbar-responsive-collapse').length > 0){
                var addvalue = $('.navbar-responsive-collapse').offset().top + $('.navbar-responsive-collapse').height();
            }
        }

        if ($(document).scrollTop() > increase) {
            $('.navimenu').addClass('forcetop');

            if($('.helpnavimenuwidth').is(':visible')){            

                $('.navimenuminwidth').css('top',addvalue+'px');


                if($(document).scrollTop() > increase){                
                    $('.navimenuminwidth').css('position','fixed');
                    $('.navimenuminwidth').addClass('forcetop');
                }else{                
                    $('.navimenuminwidth').css('position','absolute');
                }                        
            }else{
                $('.navimenuminwidth').css('position','fixed');           
                $('.navimenuminwidth').addClass('forcetop');
            }               
        }else{
            $('.navimenu').removeClass('forcetop');
            $('.navimenuminwidth').css('position','absolute');

            if($('.helpnavimenuwidth').is(':visible')){
                $('.navimenuminwidth').css('top',addvalue+'px');
            }else{
                if($(document).width() < 360){
                    $('.navimenuminwidth').css('top',addvalue);
                }else{
                    $('.navimenuminwidth').css('top',addvalue+'px');
                }
            } 

            $('.navimenuminwidth').removeClass('forcetop');
        }
    }
        
    if (localStorage.getItem('clickActive') !== null) {
        //NOP        
    }else{
        if ($('.navimenuminwidth').is(':visible')) {
            for (var i = 0; i < seconditems.length; i++) {
                if ($(window).scrollTop() >= seconditems[i][Object.keys(seconditems[i])[0]].min && $(window).scrollTop() <= seconditems[i][Object.keys(seconditems[i])[0]].max) {
                    $('.navilist').removeClass('naviliactive');

                    if (secondcurrentitem != Object.keys(seconditems[i])[0]) {
                        secondcurrentitem = Object.keys(seconditems[i])[0];                            
                    }

                    $('.navilist#' + secondcurrentitem).addClass('naviliactive');                        
                    break;
                }
            }
        }else if ($('.navimenu').is(':visible')) {            
            for (var i = 0; i < items.length; i++) {                
                if ($(window).scrollTop() >= items[i][Object.keys(items[i])[0]].min && $(window).scrollTop() <= items[i][Object.keys(items[i])[0]].max) {
                    $('.navilist').removeClass('naviliactive');
                    
                    if (currentitem != Object.keys(items[i])[0]) {
                        currentitem = Object.keys(items[i])[0];                            
                    }

                    $('.navilist#' + currentitem).addClass('naviliactive');                        
                    break;
                }
            }
        }
    }
}

function quickNav(a) {   
    if(typeof a !== "undefined" && a === true){        
        $(window).scroll(function () {            
            if(localStorage.getItem('clickActive') === null){
                mainLogicQuickNav();              
            }            
        });
    }else{        
        mainLogicQuickNav();
    }    
}

function sendLeadGenerate() {
    console.log(urlLeadGenerate);
    $.ajax({
        type: "POST",
        dataType: "json",
        url: urlLeadGenerate,
        data: $('#formLeadGenerator').serialize(),
        success: function (data) {
            if (data && !data.error) {
                $('#msgleadgenerator').html(data.msg);
                $('#leadGenerator').modal('hide');
                $('#leadGeneratorFooter').hide();
                $('#externalLeadGeneratorFooter').hide();
                $('#msgleadgenerator').hide();
                $('#howshowthemodal').removeClass('howshowthemodalfix');                
            } else {
                $('#msgleadgenerator').html('<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error: </span> ' + data.msg + '</div>');
            }
        },
        fail: function (data) {
            $('#msgleadgenerator').html('Occurred internal error while sending data');
        }
    });

}

function reportinit() {

    try {
        var divGoogleMaps = '#map-googlemaps';
        googleMapsMapInit(divGoogleMaps, $(divGoogleMaps).attr("data-googlemaps-latitude"),
                $(divGoogleMaps).attr("data-googlemaps-longitude"), $(divGoogleMaps).attr("data-googlemaps-title"),
                $(divGoogleMaps).html());
    } catch (e) {
        console.log(e);
    }

    try {
        var divServerLocationMap = '#mapserverlocation';
        serverLocationMapInit(divServerLocationMap, $(divServerLocationMap).attr("data-serverlocation-latitude"),
                $(divServerLocationMap).attr("data-serverlocation-longitude"), $(divServerLocationMap).attr("data-serverlocation-accuracy"),
                $(divServerLocationMap).attr("data-serverlocation-title"), $(divServerLocationMap).html());
    } catch (e) {
        console.log(e);
    }

    try {
        //backlinkspiecharts();
        setTimeout(backlinkspiecharts, 1000);
    } catch (e) {
        console.log(e);
    }
    try {
        //anchorschart();
        setTimeout(anchorschart, 1000);
    } catch (e) {
        console.log(e);
    }

    try {
        //speedanalysispiechartsrequest();
        //speedanalysispiechartsweight already in this function, also in reportinit
        setTimeout(speedanalysispiechartsrequest, 500);
    } catch (e) {
        console.log("Error speedanalysispiechartsrequest: ",e);
    }

    try {
        //inpagelinkspiecharts();
        setTimeout(inpagelinkspiecharts, 500);
    } catch (e) {
    }

    
    try {
        //speedanalysispiechartsweight();
        setTimeout(speedanalysispiechartsweight, 500);
    } catch (e) {
        console.log("Error speedanalysispiechartsweight: ",e);
    }

    try {
        if ($('#circles') && $('#circles').attr('data-circle-started') != "1") {
            var options = {
                id: 'circles',
                radius: 70,
                value: $('#circles').attr('data-percent'),
                maxValue: 100,
                width: 10,
                text: "",
                colors: ['#E5E5E5', '#0281C4'],
                duration: 400,
                wrpClass: 'circles-wrp',
                textClass: 'circles-text'
            };

            reportScoreCircle = Circles.create(options);
            $('#circles').attr('data-circle-started', 1);
        }
    } catch (e) {
        console.log(e);
    }

    try {
        $(".erankertooltip[title]").tooltip({
            show: {
                effect: "slideDown",
                delay: 250
            },
            position: {
                my: "left top",
                at: "left bottom"
            },
            placement: "bottom"
        });
    } catch (e) {
        console.log(e);
    }       
}

function googleMapsMapInit(div, lat, lon, title, content) {
    $(".erfactor[data-factorready='1'] " + div + "[data-gmapsmapready='false']").each(function (i, e) {
        // Create map
        var mapGoogleMaps = new GMaps({
            div: div,
            scrollwheel: true,
            zoom: 15,
            lat: lat,
            lng: lon
        });

        if (lat !== null && lon !== null) {
            // Create infoWindow
//            var infoWindowGmapsLocation = new google.maps.InfoWindow({
//                content: content
//            });

            var markerGoogleMaps = mapGoogleMaps.addMarker({
                lat: lat,
                lng: lon,
                title: title,
                icon: "//www.eranker.com/content/themes/eranker/img/establishment_location-32.png",
                infoWindow: content
            });

            // This opens the infoWindow
//            try {
//                //infoWindowGmapsLocation.open(mapGoogleMaps, markerGoogleMaps);
//            } catch (e) {
//                console.log(e);
//            }
        }
    });
    $(div).attr('data-gmapsmapready', 'true');
}

function serverLocationMapInit(div, lat, lon, accuracy, title, content) {

    $(".erfactor[data-factorready='1'] " + div + "[data-mapready='false']").each(function (i, e) {
        // Create map
        var mapServerLocation = new GMaps({
            div: div,
            scrollwheel: true,
            zoom: 7,
            lat: lat,
            lng: lon
        });

        if (lat !== null && lon !== null) {
            // Create infoWindow
//            var infoWindowServerLocation = new google.maps.InfoWindow({
//                content: content
//            });


            //Fix accuracy
            if (accuracy <= 0) {
                accuracy = 30000;
            }

            // Add the circle for this city to the map.
            new google.maps.Circle({
                center: new google.maps.LatLng(lat, lon),
                radius: accuracy,
                strokeColor: "#4293e5",
                strokeOpacity: 0.3,
                strokeWeight: 1,
                fillColor: "#4293e5",
                fillOpacity: 0.2,
                map: mapServerLocation.map
            });


            var markerServerLocation = mapServerLocation.addMarker({
                lat: lat,
                lng: lon,
                title: title,
                icon: "//www.eranker.com/content/themes/eranker/img/datacenter_location-32.png",
                infoWindow: content
            });

            // This opens the infoWindow
//            try {
//                infoWindowServerLocation.open(mapServerLocation, markerServerLocation);
//            } catch (e) {
//                console.log(e);
//            }
        }

    });

    $(div).attr('data-mapready', 'true');
}

function shuffleArray(array) {
    var currentIndex = array.length, temporaryValue, randomIndex;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        // And swap it with the current element.
        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
    }

    return array;
}

function downloadFactorsHTML() {
    if(downloadlink === null){
        //retain download link url until report is done
        downloadlink = $('#download-pdf').attr('href');
        $('#download-pdf').attr('href','javascript:void(0)');
    }
    
    reportDownloadRetries++;
    if (reportDownloadRetries > 120 || $(".erfactor[data-factorready='0']").size <= 0) { // retry until finished or 10 minutes
        reportinit();
        return;
    }
    if (console) {
        console.log("Downloading missing factors...");
    }
    var factorList = "";
    var totalDownload = Math.floor(1 + (20 * Math.random()));
    var arrayFactorNotReady = [];
    $(".erfactor[data-factorready='0']").each(function (idx, el) {
        arrayFactorNotReady.push($(el).attr('data-id'));
    });

    shuffleArray(arrayFactorNotReady);

    for (var i = 0; i < arrayFactorNotReady.length && i < totalDownload; i++) {
        factorList += arrayFactorNotReady[i] + ",";
    }
    factorList = factorList.substring(0, factorList.length - 1);

    if (erankerhost === true || (window.location.href.indexOf("sc_url") === -1 && window.location.href.indexOf("subaction") !== -1)) {
        var jsonURL = updateQueryStringParameter(updateQueryStringParameter(window.location.href, "factors", factorList), "ajax", "1");
    }

    if (typeof jsonURL != "undefined") $.getJSON(jsonURL, function (data) {
        console.log("Downloaded: " + jsonURL);
        //updateReportScore(data.score);
                
        if (data === null) {
            console.log('The data object was null');
            //window.location.reload();
        } else {
            $.each(data, function (index, value) {
                console.log("Factor '" + index + "' loaded from ajax...");

                $('.erfactor[data-id="' + index + '"]').attr('data-factorready', '1');

                if (index === "score" || index === "status") {
                    return;
                }
                var section = $('.erfactor[data-id="' + index + '"]');

                if (index == 'backlinks') {
                    section.find(".factor-data").html('');
                    section.find(".factor-data-backlinks").html(value.html);
                } else {
                    section.find(".factor-data").html(value.html);
                }
                
                if(data.thumbnailimage.indexOf("loading-page-preview.gif") === -1){
                    $(".printscreen").html('<img id="sitescreen" alt="Website Screenshot" src="' + data.thumbnailimage + '">');
                }
                
                var statusclass = "info";
                
                switch (value.status) {
                    case "RED":
                    case "MISSING":
                        statusclass = 'times';
                        break;
                    case "ORANGE":
                        statusclass = 'minus';
                        break;
                    case "GREEN":
                        statusclass = 'check';
                        break;
                    case "NEUTRAL":
                        statusclass = 'info';
                        break;
                    default:
                        statusclass = "question-circle";
                        break;
                }
                if(typeof value.status !== "undefined"){
                    var statuscolor = value.status.toLowerCase();
                }else{
                    //force to red when no value.status found
                    var statuscolor = 'red';
                }

                section.find(".factor-name-inside").html('<i class="fa fa-' + statusclass + ' ' + statuscolor + '"></i> ' + value.friendly_name);

            });
        }
          
        if ($(".erfactor[data-factorready='0']").size() > 0) {
            $(".loadingCircle").show();
            $('#circles').css('visibility', 'hidden');
            $('.overall-score > p').css('visibility', 'hidden');
            $('.overall-score > h5').css('visibility', 'hidden');
            if (appendFlag == false) {
                appendFlag = true;
                //$('.overall-score > p').css('visibility', 'hidden');
                //$('.overall-score > h5').css('visibility', 'hidden');
                $('#circles').css('visibility', 'hidden');
                $('.loadingCircleExternal').prepend('<div class="loadingmessage">Loading...</div>');
            }

            //Try download again in 5 seconds
            setTimeout(function dfact() {
                downloadFactorsHTML();
            }, 3000);

        } else {
            updateReportScore(data.score);
            $('#circles').css('visibility', 'visible');
            $('.overall-score > p').css('visibility', 'visible');
            $('.overall-score > h5').css('visibility', 'visible');
            $(".loadingCircle").hide();
            $('.loadingmessage').hide();
            console.log("QWERTY",downloadlink);
            $('#download-pdf').attr('href',downloadlink);
            
            if (console) {
                console.log("Finished download the factors data.");
            }
        }

        if (factorList === "") {
            if (typeof data === "underfined" || data === null || typeof data.status === "underfined") {
                console.log("Data is null");
            } else {
                updateReportScore(data.score);
            }

            $('#circles').css('visibility', 'visible');
            $('.overall-score > p').css('visibility', 'visible');
            $('.overall-score > h5').css('visibility', 'visible');
            $(".loadingCircle").hide();
            $('.loadingmessage').hide();
            console.log("QWER",downloadlink);
            $('#download-pdf').attr('href',downloadlink);
            
            if (console) {
                console.log("Finished download the factors data.");
            }
            reportinit();
            return;
        }
        
        reportinit();
        pdfIsmobileCond();
    }).fail(function (jqXHR, textStatus, errorThrown) {        
        if(jqXHR.status !== 200){
            console.log("Failed: " + jsonURL,jqXHR, textStatus, errorThrown);
        }else{
            console.log("Failed: " + jsonURL+" Last call, no factors:"+jqXHR.statusText);
            //recreate pdf download when fail at no factors to load
            if($('#download-pdf').attr('href') === "javascript:void(0)"){
                $('#download-pdf').attr('href',downloadlink);
            }            
        }                
        //console.log("Errors and messages: ",jqXHR.responseText, textStatus, errorThrown);
        
        //If an error happens and factors are not ready, try download again in 5 seconds
        if ($(".erfactor[data-factorready='0']").size() > 0) {
            setTimeout(function dfact() {
                downloadFactorsHTML();
            }, 5000);
        }
        reportinit();
    });
}


function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        return uri + separator + key + "=" + value;
    }
}

function updateReportScore(value) {
    if (console) {
        console.log("Updating scores...");
    }
    if (reportScoreCircle) {
        reportScoreCircle.update(Math.round(value.percentage), 300);
    }

    $('.superreport-seo .overall-score .reportfinalscore').html(Math.round(value.percentage));
    $('#rating-stars .rating-stars').css('width', (Math.round(value.percentage) / 10 * 10.6) + 'px');
    //Multi colors not implemented yet....
    //reportScoreCircle.updateColors(['#E5E5E5', '#0281C4']);

    var total = value.factors.green + value.factors.orange + value.factors.red + value.factors.missing;

    $('.score-table .factors-score .green .factor-score span').html(value.factors.green);
    $('.score-table .factors-score .green .factorbar').css('width', Math.round((value.factors.green / total) * 100) + '%');
    $('.score-table .factors-score .orange .factor-score span').html(value.factors.orange);
    $('.score-table .factors-score .orange .factorbar').css('width', Math.round((value.factors.orange / total) * 100) + '%');
    $('.score-table .factors-score .red .factor-score span').html(value.factors.red);
    $('.score-table .factors-score .red .factorbar').css('width', Math.round((value.factors.red / total) * 100) + '%');
}

function printSeoReport() {
    $("#erreport").print();
}

function backlinkspiecharts() {
    if (isMobileBrowser()) {
        var pieOptions = {size: '100px',
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false,
                format: '<b>{point.name}</b>: {point.y}',
                distance: 20,
                color: 'black'
            }
        };
    } else {
        var pieOptions = {
            minSize: '100px',
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false,
                format: '<b>{point.name}</b>: {point.y}',
                distance: 20,
                color: 'black'}
        };
    }

    $(".backlinkchart[data-chartready='false']").each(function (i, e) {

        $(this).highcharts({
            chart: {
                animation: false,
                plotBackgroundColor: 'transparent',
                plotBorderWidth: null,
                plotShadow: false,
                backgroundColor: 'transparent'
            },
            title: {
                text: $(this).attr('data-title1') + ' vs ' + $(this).attr('data-title2'),
                margin: 5
            }, colors: ['#0281C4', '#FF9000', '#04B974', '#F45B5B'], credits: {
                enabled: false
            },
            subtitle: {
                text: "Total: " + (parseInt($(this).attr('data-value1')) + parseInt($(this).attr('data-value2')))
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'bottom',
                enabled: true
            },
            exporting: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<b>{point.y} ({point.percentage:.1f}%)</b>'},
            plotOptions: {
                pie: pieOptions
            },
            series: [{
                    type: 'pie',
                    name: $(this).attr('data-title1') + ' ' + $(this).attr('data-title2'),
                    showInLegend: true,
                    data: [
                        {
                            name: $(this).attr('data-title1'), y: parseInt($(this).attr('data-value1')),
                            sliced: true,
                            selected: true
                        },
                        {
                            name: $(this).attr('data-title2'),
                            y: parseInt($(this).attr('data-value2')),
                            sliced: false,
                            selected: false
                        }
                    ]
                }]
        });

        $(this).attr("data-chartready", "true");
    });
}

function inpagelinkspiecharts() {
    if (typeof $('.chartinpagelinks').attr('data-total') !== "undefined" && $('.chartinpagelinks').attr('data-total') !== "0") {
        var datachart = Array();

        if (typeof $('.chartinpagelinks').attr('data-external_follow') != "undefined") {
            datachart.push(['External Follow', parseInt($('.chartinpagelinks').attr('data-external_follow'))]);
        }

        if (typeof $('.chartinpagelinks').attr('data-external_nofollow') != "undefined") {
            datachart.push(['External NoFollow', parseInt($('.chartinpagelinks').attr('data-external_nofollow'))]);
        }

        if (typeof $('.chartinpagelinks').attr('data-internal') != "undefined") {
            datachart.push(['Internal Follow', parseInt($('.chartinpagelinks').attr('data-internal'))]);
        }

        if (typeof $('.chartinpagelinks').attr('data-internal_nofollow') != "undefined") {
            datachart.push(['Internal NoFollow', parseInt($('.chartinpagelinks').attr('data-internal_nofollow'))]);
        }

        $('.chartinpagelinks[data-chartready=\"false\"]').highcharts({
            chart: {
                animation: false,
                plotBackgroundColor: 'transparent',
                plotBorderWidth: null,
                plotShadow: false,
                backgroundColor: 'transparent'
            },
            title: {
                text: 'In Page Links',
                margin: 0
            },
            colors: ['#FF9000', '#0281C4', '#04B974', '#F45B5B', '#444444', '#5F65E0'],
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            credits: {
                enabled: false
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'bottom',
                enabled: false
            },
            exporting: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f}%',
                        color: 'black',
                        distance: 20
                    }
                }
            },
            series: [{
                    type: 'pie',
                    name: 'In Page Links',
                    showInLegend: false,
                    data: datachart
                }]
        });

        $('.chartinpagelinks').attr('data-chartready', 'true');
    }
}

function anchorschart() {
    if (isMobileBrowser()) {
        var pieOptions = {
            size: '70px',
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                formatter: function () {
                    return '<b>' + this.point.name.toString().substring(0, 10) + '...</b>: ' + this.point.y;
                },
                distance: 20,
                color: 'black'
            }
        };
        var chartOptions = {
            margin: [0, 0, 0, 0],
            spacingTop: 0,
            spacingBottom: 0,
            spacingLeft: 0,
            spacingRight: 0,
            animation: false,
            plotBackgroundColor: 'transparent',
            plotBorderWidth: null,
            plotShadow: false,
            backgroundColor: 'transparent'
        };
    } else {
        var pieOptions = {
            minSize: 80,
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: !isMobileBrowser(),
                //format: '<b>{point.name}</b>: {point.y}',                    
                formatter: function () {
                    var ret = '';
                    if (this.point.name.toString().length > 28) {
                        ret = '<b>' + this.point.name.toString().substring(0, 28) + '...</b>: ' + this.point.y;
                    } else {
                        ret = '<b>' + this.point.name + '</b>: ' + this.point.y;
                    }
                    return ret;
                },
                distance: 20,
                color: 'black'
            }
        };
        var chartOptions = {
            animation: false,
            plotBackgroundColor: 'transparent',
            plotBorderWidth: null,
            plotShadow: false,
            backgroundColor: 'transparent'
        };
    }

    if ($(".anchorschart").attr("data-totali") !== "0") {
        $(".anchorschart[data-chartready='false']").each(function (i, e) {
            var dataCharts = [];

            for (i = 0; i < $(this).attr('data-totali'); i++) {
                if (typeof $(this).attr('data-backlinks-' + i) !== "undefined" && $(this).attr('data-backlinks-' + i).length > 0) {
                    dataCharts[i] = [$(this).attr('data-anchor-' + i), parseInt($(this).attr('data-backlinks-' + i))];
                }
            }

            $(this).highcharts({
                chart: chartOptions,
                title: {
                    text: 'Anchors Text',
                    margin: 5
                },
                credits: {
                    enabled: false
                },
                legend: {
                    layout: 'vertical',
                    align: 'center',
                    verticalAlign: 'bottom',
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: '<b>{point.y} ({point.percentage:.1f}%)</b>'
                },
                plotOptions: {
                    pie: pieOptions
                },
                series: [{
                        type: 'pie',
                        name: 'Anchors Text',
                        showInLegend: true,
                        data: dataCharts
                    }]
            });

            $(this).attr("data-chartready", "true");
        });
    }
}

$(document).ready(function () {

    Highcharts.setOptions({
        plotOptions: {
            series: {
                animation: false
            }
        }
    });
    
//******************************************
    reportinit();   
    
    if($('#factor-page-in-links').length > 0){
        var observer = new MutationObserver(function () {
            clickExpandTable();        
            observer.disconnect();
        });

        // pass in the target node, as well as the observer options
        observer.observe(document.querySelector('#factor-page-in-links'), {attributes: true, childList: true});
    }   

    if($('#factor-structured-data').length > 0){
        //guistructureddata
        var observer2 = new MutationObserver(function () {
            clickExpandTableStructuredData();
            observer2.disconnect();
        });

        // pass in the target node, as well as the observer options
        observer2.observe(document.querySelector('#factor-structured-data'), {attributes: true, childList: true});
    }
    
    if($('#factor-url-underscore').length > 0){
        var observer3 = new MutationObserver(function () {
            clickShowUrlUnderscore();
            observer3.disconnect();
        });

        observer3.observe(document.querySelector('#factor-url-underscore'), {attributes: true, childList: true});
    }
    
    try{
        clickExpandTable();
    }catch (e) {
        console.log(e);
    }

    try{
        clickExpandTableStructuredData();
    }catch (e) {
        console.log(e);
    }

    try{
        clickShowUrlUnderscore();
    }catch (e) {
        console.log(e);
    }
    
    try{
        if (erankerhost === true) {
            setTimeout(function(){
                quickNav(true);
            }, 2000);
        }
    }catch (e) {
        console.log(e);
    }    
//******************************************
    function secondMenuDetails(){
        if($('.helpnavimenuwidth').is(':visible')){
            setTimeout(function(){                
                if($('.navbar-nav').height() > 100){
                    var increase = $('.mega-menu').height()+50;
                
                    $('.navimenuminwidth').css('top',increase+'px');

                    if($(document).scrollTop() > increase){
                        $('.navimenuminwidth').css('position','fixed');
                        $('.navimenuminwidth').addClass('forcetop');
                    }else{
                        $('.navimenuminwidth').css('position','absolute');
                    }
                }else{

                    //var add = parseInt($('.mega-menu').height()) + parseInt($('.navimenuminwidth').height()) + parseInt($('.superreport-seo').css('margin-top').split('px')[0]); 
                    if($('.navbar-responsive-collapse').height() <= 0){
                        var add = $('.navbar-header').offset().top + $('.navbar-header').height();
                    }else{
                        var add = $('.navbar-responsive-collapse').offset().top + $('.navbar-responsive-collapse').height();
                    }                    
                    
                    $('.navimenuminwidth').css('position','fixed');
                    $('.navimenuminwidth').css('top',add+'px');
                    $('.navimenuminwidth').removeClass('forcetop');
                }                
            }, 500);                              
        }else{           
            $('.navimenuminwidth').css('position','absolute');
            $('.navimenuminwidth').removeClass('forcetop');
        }
    }
    
    $(window).resize(function () {
        if (erankerhost === true) {
            mainLogicQuickNav();
        }        
    });
    
    if(erankerhost === true){
        $('.hometoggleadvance').click(function(){        
            secondMenuDetails();
        });
    }
    
    //MODAL LEAD
    //modal lead assure is seen by all
    function checkModalLead() {
        if ($("#howshowthemodal").attr("data-howshowthemodal") === "REPORT20") {
            var leadsent = false;
        
            if (window.pageYOffset >= 600 && !leadsent
            && document.cookie.match(new RegExp("leadgenerated=[^;]+")) === null) {
                $('#leadGenerator').modal('show');              
                
                $('#howshowthemodal').addClass('howshowthemodalfix');
            }
            
            if(window.pageYOffset >= 600){
                $('#leadGenerator').css('top','0px');
            }else{
                $('#leadGenerator').css('top','130px');
            }
        } else {
            $('#leadGenerator').modal('show');
            if(window.pageYOffset >= 600){
                $('#leadGenerator').css('top','0px');
            }else{
                $('#leadGenerator').css('top','130px');
            }
            
            $('#howshowthemodal').addClass('howshowthemodalfix');
        }        
    }
    
    checkModalLead();
    
    $(window).scroll(checkModalLead);
    //MODAL LEAD
    
    $("#formLeadGenerator").submit(function (e) {
        e.preventDefault();
        sendLeadGenerate();
        return false;
    });
            
    if (erankerhost === true) {
        clickMenu();  
        setTimeout(function(){            
            quickNav();
        },1500);
    }  
    
    downloadFactorsHTML();

    pdfIsmobileCond();


//    $('#download-pdf').click(function () {
//        var downloadPdf = $(this);
//        var text = $(this).text();
//
//        if (downloadPdf.attr('data-enabled') != 'true') {
//            return;
//        }
//
//        downloadPdf.attr('data-enabled', 'false');
//        $(this).text("Generating report...");
//
//        if (typeof _e === "undefined") {
//            var urlhost = 'www.eranker.com';
//            var langused = 'en';
//        }else {
//            var urlhost = _e.url;
//            var langused = _e.lang;
//        }
//        
//        var data = {
//            "patch_lang": langused,
//            "patch_backlinks": ($('#backlinkspie').length > 0 ? encodeURIComponent($('#backlinkspie').html()) : ''),
//            "patch_anchors": ($('#anchorschart').length > 0 ? encodeURIComponent($('#anchorschart').html()) : ''),
//            "patch_speedanalysispie": ($('#speedanalysispiegroup').length > 0 ? encodeURIComponent($('#speedanalysispiegroup').html()) : ''),
//            "patch_overallscore": ($('#overall-score').length > 0 ? encodeURIComponent($('#overall-score').html()) : '')
//        };
//        
//        $.post([urlhost, $(this).attr('data-href')].join(''),data, function (pdf) {
//            try {
//                pdf = JSON.parse(pdf);
//                downloadPdf.attr('data-enabled', 'true');
//                window.open(urlhost + pdf.link, '_blank');
//                $.post(urlhost + '/ping', {
//                    "remove": pdf.link
//                }, null);
//            } catch (e) {
//                console.warn("Bad response");
//                downloadPdf.text("Report failed. Try again");
//            }
//
//            setTimeout(function () {
//                downloadPdf.text(text);
//            }, 4000);
//        });
//    });


    if(erankerhost === true ){
        $.validator.addMethod(
            "multiemail",
            function (value, element) {
                var email = value.split(/[,]+/); // split element by ,
                valid = true;
                for (var i in email) {
                    value = email[i];
                    valid = valid && $.validator.methods.email.call(this, $.trim(value), element);
                }
                return valid;
            },
            $.validator.messages.multiemail
        );
        
        $('#createMonitorInsideReport').validate(createMonitorOnReport());

//        $('.hideformreportmonitor').click(function(){
//            $('.createmonitorinreport').addClass('hiddenall');
//        });

        //simulate same layout as what is in monitor
        if($('#createmonitor').length > 0){
            $('#gettypeofmonitor').change(function () {                
                var optionSelected = $(this).find("option:selected");
                var valueSelected  = optionSelected.val();

                if(valueSelected === "PORT"){
                    $('.div_port_monitor').removeClass('hidden');
                    $('.labelport').removeClass('hidden');
                    $('.labelkeyword').removeClass('hidden').addClass('hidden');
                    $('.div_keyword_monitor').removeClass('hidden').addClass('hidden');
                    $('.alertlabel').removeClass('hidden').addClass('hidden');
                    $('.alertcontent').removeClass('hidden').addClass('hidden');                    
                    $('.divprotocol_keyword_monitor').removeClass('hidden').addClass('hidden');                    
                    $('.divprotocol_http_monitor').removeClass('hidden').addClass('hidden');
                }else if(valueSelected === "KEYWORD"){
                    $('.labelkeyword').removeClass('hidden');
                    $('.div_keyword_monitor').removeClass('hidden');
                    $('.alertlabel').removeClass('hidden');
                    $('.alertcontent').removeClass('hidden');                    
                    $('.divprotocol_keyword_monitor').removeClass('hidden');
                    $('.div_port_monitor').removeClass('hidden').addClass('hidden');
                    $('.labelport').removeClass('hidden').addClass('hidden');
                    
                    $('.divprotocol_http_monitor').removeClass('hidden').addClass('hidden');
                }else if(valueSelected === "HTTP"){
                    $('.divprotocol_http_monitor').removeClass('hidden');
                    $('.labelkeyword').removeClass('hidden').addClass('hidden');
                    $('.div_keyword_monitor').removeClass('hidden').addClass('hidden');
                    $('.alertlabel').removeClass('hidden').addClass('hidden');
                    $('.alertcontent').removeClass('hidden').addClass('hidden');                    
                    $('.divprotocol_keyword_monitor').removeClass('hidden').addClass('hidden');
                }else{
                    $('.div_port_monitor').removeClass('hidden').addClass('hidden');
                    $('.labelport').removeClass('hidden').addClass('hidden');                    
                    $('.divprotocol_http_monitor').removeClass('hidden').addClass('hidden');
                    $('.labelkeyword').removeClass('hidden').addClass('hidden');
                    $('.div_keyword_monitor').removeClass('hidden').addClass('hidden');
                    $('.alertlabel').removeClass('hidden').addClass('hidden');
                    $('.alertcontent').removeClass('hidden').addClass('hidden');                    
                    $('.divprotocol_keyword_monitor').removeClass('hidden').addClass('hidden');
                }
            });
            
            if($("#intervalmonitor")){
                var interval = parseInt($('#intervalforuser').val());
                var plan = $('#planforuser').val();

                if(plan === "free"){            
                    $('#getvaluecron').val("1440");          
                }else{
                    $('#getvaluecron').val(interval);

                    $("#intervalmonitor").slider({
                        min: (interval > 5 ? 60 : 5),
                        max: 1440,
                        step: interval,
                        value:interval,
                        orientation: "horizontal",
                        range: "min",
                        animate: true,
                        change: function(event,ui){
                            $('.createupdatenumber').html('every '+ui.value+' minutes');
                            $('#getvaluecron').val(ui.value);
                        }
                    });
                }
            }
            
            $('#createmonitor').validate(validateAddMonitorForm());
        }else{
            $('.registerbeforecreatemonitor').click(function(){
                if(validateFormOnReportNoLoggedIn() !== false){
                    $('.emforcedtoappear').removeClass('hiddenall').addClass('hiddenall');
                    var datasend = validateFormOnReportNoLoggedIn();
                    window.location = "/register?registeremail="+datasend;
                }else{
                    $('.emforcedtoappear').removeClass('hiddenall');
                }
            });
        }
    }
});

function createMonitorOnReport() {
    var v = {}, n = {};
    
    // uncomment for debug
    v.debug = true;
    
    // n for notification
    n.timeout = 15000;
    
    // validation rules
    v.rules = {
        emailmonitortocreate: { 
            required: true,
            multiemail: true
        }
    };
    
    v.messages = {
        emailmonitortocreate: {
            multiemail: messageerreport.multiemail           
        }
    };
    
    // validation handler
    v.submitHandler = function(form) {        
        $.post($(form).attr('data-action'), $(form).serialize(), function(data) {
            if(data.error === null && data.errorinput === null && typeof data.url != "undefined" && typeof data.emails != "undefined"){
                $('.monitorfromreporttrue').val(''+data.url);
                $('#url_monitorfromreport').val(''+data.url);
                $('#emails_monitorfromreport').val(''+data.emails);
                $('#createMonitor').modal('show');
            }else{
                // set notification
                n.title = messageerreport.fail;
                n.content = messageerreport.fail_content + data.errorinput;
                n.color = '#A65858';
                n.icon = 'fa fa-warning swing animated';

                // notification system
                $.smallBox(n);
            }

            return false;
        }).fail(function() {
            // set notification
            n.title = messageerreport.fail;
            n.content = messageerreport.fail_content;
            n.color = '#A65858';
            n.icon = 'fa fa-warning swing animated';

            // notification system
            $.smallBox(n);
            return false;
        });              
    };

    // validation error
    v.errorPlacement = function(error, element) {        
        error.insertAfter(element.parent());
    };
    
    return v;
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateFormOnReportNoLoggedIn(){
    var val = $('#emailmonitortocreate').val();
    var emails = val.split(',');
    var fail = false;
    
    for(var i=0;i<emails.length;i++){
        if(validateEmail(emails[i]) === false){
            fail = true;
           break; 
        }
    }
    
    if(fail === true){
        return false;
    }
    
    return emails[0];
}

function validateAddMonitorForm() {
    var v = {}, n = {};
   
    v.debug = true;
   
    n.timeout = 15000;
   
    v.rules = {
        friendly_name_monitor: { 
            required: true            
        },
        url_monitor: {
            required: true            
        },
        port_monitor: {
            required: true            
        },
        keyword_monitor: {
            required: true
        }
    };
    
    // validation messages
    v.messages = {
        friendly_name_monitor: {
            required: messageerreport.required           
        },
        url_monitor: {
            required: messageerreport.required
        },
        port_monitor: {
            required: messageerreport.required
        },
        keyword_monitor: {
            required: messageerreport.required
        }
    };
    
    // validation handler
    v.submitHandler = function(form) {        
        $.post($(form).attr('data-action'), $(form).serialize(), function(data) {
            if(data.error === null && data.errorinput === null){                    
                n.title = messageerreport.success;
                n.content = messageerreport.success_content;
                n.color = '#58A658';
                n.icon = 'fa fa-info-circle bounce animated';                    
                $.smallBox(n);

                if(typeof data.monitor_id !== "undefined"){
                    window.location = '/monitor?monitor_id='+data.monitor_id;
                }else{
                    window.location.reload();
                }                    
            }else{
                // set notification
                n.title = messageerreport.submit_err_title;
                n.content = messageerreport.submit_err_content + data.errorinput;
                n.color = '#A65858';
                n.icon = 'fa fa-warning swing animated';

                $.smallBox(n);
            }

            return false;
        }).fail(function() {
            // set notification
            n.title = messageerreport.submit_err_title;
            n.content = messageerreport.submit_err_content;
            n.color = '#A65858';
            n.icon = 'fa fa-warning swing animated';

            $.smallBox(n);
            return false;
        });             
    };

    // validation error
    v.errorPlacement = function(error, element) {
        error.insertAfter(element.parent());
    };
    
    return v;
}

function niceToggle(id) {
    if ($('#' + id + ' i.expandtoggle').hasClass('show-details')) {
        $('#' + id + ' i.expandtoggle').removeClass('fa-minus').addClass('fa-plus');
    } else {
        $('#' + id + ' i.expandtoggle').removeClass('fa-plus').addClass('fa-minus');
    }
    $('#' + id + ' i.expandtoggle').toggleClass('show-details');
    $('#' + id + ' .factor-info').toggle();
}

function robotsTxtToggle(text) {
    if ($('.robotstoggle').hasClass('rttoggledown')) {
        $('.robotstoggle').removeClass('rttoggledown').addClass('rttoggleup');
        $('.robotstoggle').css('height', 'auto');
        $('.robotstxt').text(text);
        $('.robotstxt').prepend('<i class="fa fa-angle-up"></i>');
    } else if ($('.robotstoggle').hasClass('rttoggleup')) {
        $('.robotstoggle').removeClass('rttoggleup').addClass('rttoggledown');
        $('.robotstoggle').css('height', '167px');
        $('.robotstxt').text(text);
        $('.robotstxt').prepend('<i class="fa fa-angle-down"></i>');
    }
}

function imgAltToggle(text) {
    if ($('.imgalttoggle').hasClass('imgalttoggledown')) {
        $('.imgalttoggle').removeClass('imgalttoggledown').addClass('imgalttoggleup');
        $('.imgalttoggle').css('height', 'auto');
        $('ul.imgalttoggle li.lastnotoggle').addClass('toggledlist').removeClass('lastnotoggle');
        $('.showmoreimgalt').text(text);
        $('.showmoreimgalt').prepend('<i class="fa fa-angle-up"></i>');
    } else if ($('.imgalttoggle').hasClass('imgalttoggleup')) {
        $('.imgalttoggle').removeClass('imgalttoggleup').addClass('imgalttoggledown');
        $('.imgalttoggle').css('height', '105px');
        $('ul.imgalttoggle li.toggledlist').addClass('lastnotoggle').removeClass('toggledlist');
        $('.showmoreimgalt').text(text);
        $('.showmoreimgalt').prepend('<i class="fa fa-angle-down"></i>');
    }
}

function sitemapToggle(text) {
    if ($('.sitemaptoggle').hasClass('sitemaptoggledown')) {
        $('.sitemaptoggle').removeClass('sitemaptoggledown').addClass('sitemaptoggleup');
        $('.sitemaptoggle').css('height', 'auto');
        $('ul.sitemaptoggle li.lastnotoggle').addClass('toggledlist').removeClass('lastnotoggle');
        $('.showmoresitemap').text(text);
        $('.showmoresitemap').prepend('<i class="fa fa-angle-up"></i>');
    } else if ($('.sitemaptoggle').hasClass('sitemaptoggleup')) {
        $('.sitemaptoggle').removeClass('sitemaptoggleup').addClass('sitemaptoggledown');
        $('.sitemaptoggle').css('height', '105px');
        $('ul.sitemaptoggle li.toggledlist').addClass('lastnotoggle').removeClass('toggledlist');
        $('.showmoresitemap').text(text);
        $('.showmoresitemap').prepend('<i class="fa fa-angle-down"></i>');
    }
}

function clickExpandTable() {
    if($('.expandtable')){
        $('.expandtable').click(function () {
            if ($('.inpagelinksshowmore').is(':visible')) {
                $('.inpagelinksshowmore').hide();
                $('.inpagelinksshowless').show();
            } else if ($('.inpagelinksshowless').is(':visible')) {
                $('.inpagelinksshowless').hide();
                $('.inpagelinksshowmore').show();
            }

            var count = 0;

            $('.tabletocollapse > tbody > tr').each(function () {
                count++;
                if ($(this).hasClass('hiderows') && count > 10) {
                    $(this).removeClass('hiderows');
                } else if (count > 10) {
                    $(this).addClass('hiderows');
                }
            });
        });
    }
}

function clickExpandTableStructuredData() {
    if($('.expandtablestructdata')){
        $('.expandtablestructdata').click(function () {
            if ($('.showmorestructdata').is(':visible')) {
                $('.showmorestructdata').hide();
                $('.showlessstructdata').show();
            } else if ($('.showlessstructdata').is(':visible')) {
                $('.showlessstructdata').hide();
                $('.showmorestructdata').show();
            }

            var count = 0;

            $('.tabletocollapsestructureddata > tbody > tr').each(function () {
                count++;
                if ($(this).hasClass('hiderows') && count > 5) {
                    $(this).removeClass('hiderows');
                } else if (count > 5) {
                    $(this).addClass('hiderows');
                }
            });
        });
    }
}

function clickShowUrlUnderscore() {
    if($('.hideunhidelink')){
        $('.hideunhidelink').click(function () {
            if ($('.urlunderscoreshowmore').is(':visible')) {
                $('.urlunderscoreshowmore').hide();
                $('.urlunderscoreshowless').show();
            } else if ($('.urlunderscoreshowless').is(':visible')) {
                $('.urlunderscoreshowless').hide();
                $('.urlunderscoreshowmore').show();
            }

            var count = 0;

            $('.guiurlunderscore .linksurlunderscore').each(function () {
                count++;
                if ($(this).hasClass('urlunderscorehide') && count > 5) {
                    $(this).removeClass('urlunderscorehide');
                } else if (count > 5) {
                    $(this).addClass('urlunderscorehide');
                }
            });
        });
    }
}

function pdfIsmobileCond() {
    if ($('.robotstxtcontainer').text().length < 250) {
        $('.robotstoggle').css('height', 'auto');
        $('.robotstxt').css('display', 'none');
    } else {
        $('.robotstoggle').css('height', '167px');
        if (flagAppend1 === false) {
            $('.robotstxt').prepend('<i class="fa fa-angle-down"></i>');
            flagAppend1 = true;
        }
        $('.robotstxt').css('display', 'block');
    }

    if ($('.imgalttoggle li').length <= 5) {
        $('.imgalttoggle').css('height', 'auto');
        $('.showmoreimgalt').css('display', 'none');
    } else {
        $('.imgalttoggle').css('height', '105px');
        if (flagAppend2 === false) {
            $('.showmoreimgalt').prepend('<i class="fa fa-angle-down"></i>');
            flagAppend2 = true;
        }
        $('.showmoreimgalt').css('display', 'block');
    }

    if ($('.sitemaptoggle li').length <= 5) {
        $('.sitemaptoggle').css('height', 'auto');
        $('.showmoresitemap').css('display', 'none');
    } else {
        $('.sitemaptoggle').css('height', '105px');
        if (flagAppend3 === false) {
            $('.showmoresitemap').prepend('<i class="fa fa-angle-down"></i>');
            flagAppend3 = true;
        }
        $('.showmoresitemap').css('display', 'block');
    }

    if (isMobileBrowser()) {
        $('#erreport .robotstxt').css({'font-size': '11px', 'margin-bottom': '12px'});
        $('#erreport .showmoreimgalt').css({'font-size': '11px'});
    }    
}