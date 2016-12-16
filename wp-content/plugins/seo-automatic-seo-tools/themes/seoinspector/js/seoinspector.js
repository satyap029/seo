jQuery(document).ready(function(){
hideLoading();
	var url = jQuery("input.seo-url");
	var ref = jQuery("input[name=ref]");
	var seoautorun = jQuery("input[name=seoautorun]").val();
	var url_form = jQuery("form[id=analyze]");
	var seoautoresults = jQuery("#seoautoresults");
	var throbber = jQuery('#throbber');
// seourl variable is defined in the header of the site. I didn't know how to transfer the plugin path using php combined with jQuery. But you can  alert it and see that it's set correctly.

	url_form.submit(function(e){
		showLoading();
		jQuery("#seoautoresults").empty();
		jQuery.get(seoautorun, {"url": url.val(), "output": "html", "ref": ref.val()}, function(results){
		  jQuery("#seoautoresults").append(results);
		  hideLoading();
		  jQuery("#seoautoresults").show();
		});

		jQuery(document).bind("ajaxError.seoresults", onError);

		//we need to cancel the default submit action of the form.
		return false;
	});
	
	//there's something wrong with the form url. I keep getting a 404 error,
	//but it still returns something. maybe it's a redirect? jQuery.ajaxError
	//seems to catch it though.
	function onError(e, xhr) {
		jQuery(document).unbind("ajaxError.seoresults");
		
		jQuery("#seoautoresults").empty().append(xhr.responseText).css({"display":"block"});
		hideLoading();
	}
	
	function showLoading() {
	  jQuery("#throbber").show();
	}

	function hideLoading() {
	  jQuery("#throbber").hide();
	}

});