jQuery(function() {

	//Tab click
	jQuery('#rm-form-tabs').tabs({
        activate: function(event ,ui){
        	if(ui.newTab.index() == 1){
	            var style = jQuery('#rm_style_selector').val() || 'rm-form-style0';
	            jQuery('.rm_grid').find('.rm_grid_item[data-style="'+style+'"]').addClass('rm_style_selected');
            }else if(ui.newTab.index() == 2){
	            jQuery(this).find('#rm_enable_list').trigger('change');
	            jQuery(this).find('#rm-list-provider').trigger('change');
            }
        }

	}).addClass('ui-tabs-vertical ui-helper-clearfix');
	jQuery('.rm_grid').on('click','.rm_grid_item',function(){
		jQuery('.rm_grid_item').removeClass('rm_style_selected');
		jQuery(this).addClass('rm_style_selected');
		jQuery('#rm_style_selector').val(jQuery(this).data('style'));
	});
	
	//hover states on the static widgets
	jQuery('#dialog_link, ul#icons li').hover(
		function() { jQuery(this).addClass('ui-state-hover'); },
		function() { jQuery(this).removeClass('ui-state-hover'); }
	);

	//get data from list provider
	jQuery(document).on('change' , '#rm-list-provider',function(){
		var val = jQuery(this).val().toLowerCase();
		jQuery('#rm-list-details-container').html('');
		if(val == 'email_subscribers'){
			return;
		}
		jQuery('#rm-list-details').find('.rm-loader').show();
		var action = 'rm_get_'+val+'_data';
		var form_id = jQuery('#post_ID').val();
		var data = 'action='+action+'&form_id='+form_id;
		jQuery.ajax({
			url: ajaxurl,
			data: data,
			method: "POST",
			dataType: "JSON",
			success: function(result){
				jQuery('#rm-list-details').find('.rm-loader').hide();
				jQuery('#rm-list-details-container').html(result.data);
				jQuery(".help_tip").tipTip({'attribute' : 'data-tip'});
			},
			error: function(err){
				console.log(err);
			}
		});

	});
	// TODO ::check this later
	jQuery('#rm-list-provider').trigger('change');


	/************** JQuery change events *************/

	jQuery(document).on("change", "#rm_enable_list", function(e) {
		if(jQuery(this).is(':checked') == true){
			jQuery('#mailchimp_api_key').attr('required','required');
		}else{
			jQuery('#mailchimp_api_key').removeAttr('required');
		}
	});

	jQuery(document).on("change", ".form_type", function(e) {
		form_selected = jQuery('.'+(jQuery('input:radio[name="form_data[type]"]:checked').val() || 'subscription' )+ '_settings');
		jQuery('.subscription_settings, .custom_settings, .contact_settings').not(form_selected).slideUp();
		form_selected.slideDown();
	});
	jQuery(".form_type").change();

	jQuery(document).on("change keyup paste keydown",".auth-text-input", function(e) {
			var val = jQuery(this).val();
			if( val !== "" )
				jQuery(".auth-button").removeAttr('disabled');
			else
				jQuery(".auth-button").attr('disabled','true');
	});


	// Disconnect From account
	jQuery("body").on( "click", ".disconnect-mailer", function(){
		var mailerName = jQuery(this).data("mailerslug");
		console.log(jQuery(this), "in disconnect mailer");
		if(confirm("Are you sure? If you disconnect, your previous campaigns syncing with "+mailerName+" will be disconnected as well.")) {

			var mailer = jQuery(this).data('mailer');	
			var action = 'rm_disconnect_'+mailer;
			var data = {action:action};
			jQuery.ajax({
				url: ajaxurl,
				data: data,
				type: 'POST',
				dataType: 'JSON',
				success: function(result){
					jQuery("#save-btn").attr('disabled','true');
					
					if(result.message == "disconnected"){
						showAuthenticationView(mailer);
					}

					jQuery('.rm-form-row').fadeIn('300');
					jQuery(".rm-mailer-help").show();
				}
			});
		}
		else {
			return false;
		}
	});

    function showAuthenticationView(mailer){

        switch(mailer){

        	case "mailchimp":   jQuery("#mailchimp_api_key").show().val('');
								jQuery(".mailchimp-list").html('');
								jQuery(".mailchimp-double-optin").html('');
								jQuery("#disconnect-mailchimp").replaceWith('<button id="auth-mailchimp" class="button button-secondary auth-button" disabled="true">Verify</button><br/><a href="http://kb.mailchimp.com/accounts/management/about-api-keys" target="_blank">Find / Generate your MailChimp API key</a>');
								jQuery("#auth-mailchimp").attr('disabled','true');
        						break;

        	case "campaignmonitor":

			    				jQuery("#campaignmonitor_api_key").show().val('');
								jQuery('#campaignmonitor_client_id').val('');
								jQuery(".campaignmonitor-list").html('');
								jQuery("#disconnect-campaignmonitor").replaceWith('<button id="auth-campaignmonitor" class="button button-secondary auth-button" disabled>Authenticate Campaign Monitor</button><span class="spinner" style="float: none;"></span>');
								jQuery("#auth-campaignmonitor").attr('disabled','true');
        						break;
        }
       
    }
   


	//mailchimp authentication
	jQuery("body").on( "click", "#auth-mailchimp", function(e){
		e.preventDefault();
		var auth_token = jQuery("#mailchimp_api_key").val();
		var action = 'rm_update_mailchimp_authentication';
		var option = jQuery('input.mailchimp-double-optin:checked').val();
		var data = {action:action,authentication_token:auth_token,mailchimp_double_optin:option};
		jQuery.ajax({
			url: ajaxurl,
			data: data,
			type: 'POST',
			dataType: 'JSON',
			success: function(result){
				if(result.status == "success" ){
					jQuery('#rm-list-details-container').html(result.message);
					jQuery(".help_tip").tipTip({'attribute' : 'data-tip'});
				} 
			},
			error : {
				
			}
		});
	});
// Campaign Monitor authentication
jQuery("body").on( "click", "#auth-campaignmonitor", function(e){

	e.preventDefault();
	jQuery('#rm-list-details').find('.rm-loader').show();
	var auth_token = jQuery("#campaignmonitor_api_key").val();
	var clientID = jQuery('#campaignmonitor_client_id').val();
	var action = 'rm_update_campaignmonitor_authentication';
	var data = {action:action,clientID:clientID,authentication_token:auth_token};
	jQuery.ajax({
		url: ajaxurl,
		data: data,
		type: 'POST',
		dataType: 'JSON',
		success: function(result){
			if(result.status == "success" ){
				jQuery("#save-btn").removeAttr('disabled');
				jQuery("#campaignmonitor_client_id").closest('.rm-form-row').hide();
				jQuery("#campaignmonitor_api_key").closest('.rm-form-row').hide();
				jQuery("#auth-campaignmonitor").closest('.rm-form-row').hide();
				jQuery(".campaignmonitor-list").html(result.message);
				jQuery(".help_tip").tipTip({'attribute' : 'data-tip'});
			} /*else {
				jQuery(".campaignmonitor-list").html('<span class="rm-mailer-error">'+result.message+'</span>');
			}*/
			jQuery('#rm-list-details').find('.rm-loader').hide();
		}
	});
	e.preventDefault();
});


jQuery("body").on( "click", "#auth-hubspot", function(e){

	e.preventDefault();
	jQuery('#rm-list-details').find('.rm-loader').show();
	var api_key = jQuery("#hubspot_api_key").val();
	var action = 'rm_update_hubspot_authentication';
	var data = {action:action,api_key:api_key};
	jQuery.ajax({
		url: ajaxurl,
		data: data,
		type: 'POST',
		dataType: 'JSON',
		success: function(result){
			if(result.status == "success" ){
				jQuery("#save-btn").removeAttr('disabled');
				jQuery("#hubspot_api_key").closest('.rm-form-row').hide();
				jQuery("#auth-hubspot").closest('.rm-form-row').hide();
				jQuery(".hubspot-list").html(result.message);
			} 
			jQuery('#rm-list-details').find('.rm-loader').hide();
		}
	});
	e.preventDefault();
});

jQuery("body").on( "click", "#auth-icontact", function(e){

	e.preventDefault();
	jQuery('#rm-list-details').find('.rm-loader').show();
	var appID = jQuery("#icontact_app_id").val();
	var appUser = jQuery('#icontact_email').val();
	var appPass = jQuery('#icontact_pass').val();
	var action = 'rm_update_icontact_authentication';
	var data = {action:action,appID:appID,appUser:appUser,appPass:appPass};
	jQuery.ajax({
		url: ajaxurl,
		data: data,
		type: 'POST',
		dataType: 'JSON',
		success: function(result){
			if(result.status == "success" ){
				jQuery("#save-btn").removeAttr('disabled');
				jQuery("#icontact_app_id").closest('.rm-form-row').hide();
				jQuery("#icontact_email").closest('.rm-form-row').hide();
				jQuery("#icontact_pass").closest('.rm-form-row').hide();
				jQuery("#auth-icontact").closest('.rm-form-row').hide();
				jQuery(".icontact-list").html(result.message);
			} 
			// else {
			// 	jQuery(".icontact-list").html('<span class="rm-mailer-error">'+result.message+'</span>');
			// }
			jQuery('#rm-list-details').find('.rm-loader').hide();
		}
	});
	e.preventDefault();
});


});