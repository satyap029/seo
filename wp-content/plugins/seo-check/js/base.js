jQuery(document).ready(function ($) {
    jQuery(function () {
        $("#seocheck_error-modal").dialog({
            modal: true,
            width: 450,
            buttons: {
                Ok: function () {
                    $(this).dialog("close");
                }
            }
        });
    });

    
});

