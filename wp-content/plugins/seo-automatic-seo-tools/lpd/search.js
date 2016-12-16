$(function () {
    var search = $(".lpd");
    var results = $(".results", search);
    var loading = $(".loader", results);
    var loader = $('span', loading);

    var csv = $("textarea", results).bind('click focus', function () {
        this.select();
    });
    var resultsTable = $("table", results);

    var timer = 0;
    var keywords = [];
    var domain = '';
    var timeout = 0;
    var sleep = 0;
    var active = false;

    function tick()
    {
        if(!keywords.length)
        {
            $(".stop", search).click();

            return;
        }

        if(!timeout)
        {
            var word = keywords.shift();
            loader.html("Searching for <b>" + word + "</b>");

            clearInterval(timer);
            $.post(lpdparse, {
                'word': word,
                'domain': domain
            }, function (data) {
                if(!active)
                {
                    return;
                }

                var tr = $("<tr/>", {
                    'class': "row"
                });

                tr.append($("<td>").html(data.word));
				var _csv = "\"" + data.word + "\"";
				for(var j=0; j<data.urls.length; j++)
				{
					var x = data.urls[j];
					tr.append($("<td>").html($("<a/>", {
						href: x
					}).html(x)));
					
					_csv += "," + x;
				}
					
                resultsTable.append(tr);

                csv.append(_csv + "\n");

                timer = setInterval(tick, 1000);
                timeout = sleep;
            }, 'json');
            
        }
        else
        {
            loader.html("Waiting <b>" + timeout + "</b> sec.");
            timeout--;
        }
    }
    
    $(".clear", search).click(function () {
        results.hide();
    });

    $(".stop", search).click(function () {
        active = false;
        if(timer)
        {
            clearInterval(timer);
        }
        loading.hide();

        $(".go", search).removeAttr("disabled");
        $(this).attr('disabled', 'disabled');
    }).attr('disabled', 'disabled');

    $(".go", search).click(function () {
        domain = $.trim($(".domain", search).val());
        var tmp = $.trim($(".keywords", search).val());

        domain = domain.replace(/^(https?|ftp):\/\//, "");
        domain = domain.replace(/([^/]+).*/, "$1");
        if(!domain || !tmp)
        {
            alert("Please fill form data");
            return;
        }

        tmp = tmp.split(/[\n\r]+/);
        keywords = [];
        for(var i =0; i<tmp.length; i++)
        {
            if($.trim(tmp[i]))
            {
                keywords.push($.trim(tmp[i]));
            }
        }

        if(!keywords.length)
        {
            alert("Please enter keywords");
            return;
        }
        active = true;

        csv.html('');
        resultsTable.find("tr.row").remove();

        results.show();

        loading.show();
        loader.html("Initializing ...");

        $(".stop", search).removeAttr("disabled");
        $(this).attr("disabled", 'disabled');

        timer = setInterval(tick, 1000);
    });
});