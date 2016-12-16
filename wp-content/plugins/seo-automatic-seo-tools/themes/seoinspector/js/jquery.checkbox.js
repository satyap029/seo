jQuery(document).ready(function() {
	jQuery("input[type='checkbox']").click(
		function()
		{
			var checkid = jQuery(this).attr("id");
			var checkclass = jQuery(this).attr("class");
			if (checkclass == "tog-imp"){
				if (jQuery("#" + checkid).is(":checked"))
					jQuery("#p-" + checkid).addClass("important");
				else
					jQuery("#p-" + checkid).removeClass("important");
				jQuery(this).blur();
			}
			if (checkclass == "tog-enable"){
				if (jQuery("#" + checkid).is(":checked"))
					jQuery("#e-" + checkid).show();
				else
					jQuery("#e-" + checkid).hide();
				jQuery(this).blur();
			}
		}
	);
});
jQuery(document).ready(function() 
	{ 
		jQuery("#urls").tablesorter({
			sortList: [[1,1]] 
		}); 
	} 
); 