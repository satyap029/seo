jQuery(function() {

	jQuery.fn.bindFirst = function(name, fn) {
	    // bind as you normally would
	    // don't want to miss out on any jQuery magic
	    this.bind(name, fn);
	    var events = this.data('events') || jQuery._data(this[0], 'events');
	    var handlers = events[name];
	    // take out the handler we just inserted from the end
	    var handler = handlers.splice(handlers.length - 1)[0];
	    // move it at the beginning
	    handlers.splice(0, 0, handler);
	};

	//Rainmaker
	var Rainmaker = function() {
	}

	Rainmaker.prototype = {

		init : function(form){
			// var that = form;

			if(jQuery(form).closest('.rainmaker_form').length < 1) return;

			if(jQuery(form).closest('.rainmaker_form').hasClass('rm_init_done') ) return;

			if(jQuery(form).find('.rm_required_field, .ig_form_required_field').length < 1){
				jQuery(form).append('<div style="position:absolute; left: -5000px"><input type="text" class="rm_required_field" value="" tabindex="-1"/></div>');
			}

			jQuery(form).closest('.rainmaker_form').addClass(jQuery(form).closest('.rainmaker_form').data('type') || '');


			jQuery(form).bindFirst('submit', function(e){
				window.rainmaker.addLead(e, jQuery(e.target));
			}); // submit Event
			jQuery(form).closest('.rainmaker_form').addClass('rm_init_done');
		},

		addLead  : function(e, form, icg_msg){
			var form = form || undefined;
			if(typeof(form) !== 'undefined'){
				var icg_msg = icg_msg || undefined;
				var fm_parent = form.closest('.rainmaker_form');
				fm_parent.find('.rm-loader').show();
				// TODO :: Quick fix - Allowing mailchimp 4 WP form submission even if the action is blank.
				var mc4wpform = form.find('input[name="_mc4wp_form_id"]') && form.find('input[name="_mc4wp_form_id"]').length > 0;
				if(!fm_parent.hasClass('rm_custom') || (!form.attr('action') && !mc4wpform) ){
					e.preventDefault();	
				}

				if(form.find('.rm_required_field').val() || form.find('.ig_form_required_field').val()){
					fm_parent.find('.rm-loader').hide();
			        form.slideUp("slow");
				    fm_parent.find('div.rm_form_message').show();
					return;
				}

				var formData = {};
				jQuery.each((form.serializeArray() || {}), function(i, field){
					formData['rmfpx_'+ field.name] = field.value;
				});

				formData['rmfpx_added'] = true;
				formData['rmfpx_rm_nonce_field'] = rm_pre_data.rm_nonce_field;
				formData['rmfpx_rm_form-id'] = fm_parent.data('form-id');

				// Send Icegram Data To Rainmaker
				if(typeof icegram !== 'undefined'){
					formData['rmfpx_ig_mode'] = icegram.mode;
					formData['rmfpx_ig_remote_url'] =  window.location.href;
					if(typeof icg_msg === 'undefined'){
						var msg_id = (jQuery(form.closest('[id^=icegram_message_]') || {}).attr('id') || '').split('_').pop() || 0 ;
						icg_msg = icegram.get_message_by_id(msg_id) || {};
					}
					if(typeof icg_msg.data !== 'undefined'){
						formData['rmfpx_ig_message_id'] = icg_msg.data.id;
						formData['rmfpx_ig_campaign_id'] = icg_msg.data.campaign_id;
					}
				}

				action = rm_pre_data.ajax_url + '?action=rm_rainmaker_add_lead';
				jQuery.ajax({
					type: 'POST',
				    url: action,
				    data: formData,
				    dataType: 'json',
					success: function(response){
						// TODO :: submission erros can be logged in console 
						// response['Error'] OR throw error from backend
						if(response && typeof response.success !== 'undefined'){
							form[0].reset(); 
							form.trigger('success.rm', [form, response]);
						 	fm_parent.find('.rm-loader').hide();
					        //TODO :: Later Move this in success callback
					        if(jQuery.trim(fm_parent.next('div.rm_form_message').html()) !== ''){
						        fm_parent.slideUp("slow");
							    fm_parent.next('div.rm_form_message').show();
					        }
					        //TODO :: Later Move this in success callback
					        if (typeof(response.redirection_url) === 'string' && response.redirection_url != '') {
							    if (!/^https?:\/\//i.test(response.redirection_url) ) {
							    	response.redirection_url = "http://"+response.redirection_url;
							    }
							    setTimeout(function(){
							    	window.location.href = response.redirection_url;
							    },200);
						    }

						}else{
						 	fm_parent.find('.rm-loader').hide();
						}
					},
					error: function(err){
						console.log(err);
					},
				});
			}
		},

		
	};

	if(typeof window.rainmaker === 'undefined'){
		window.rainmaker = new Rainmaker();
	}
	jQuery('.rainmaker_form form').each(function(i, v){
		window.rainmaker.init(v);
	});

	// Start : For Icegram Compatibility

	jQuery( window ).on( "init.icegram", function(e, ig) {
	  	// Find and init all RM forms within Icegram messages/divs
	  	// if(typeof ig !== 'undefined'){
  		if(typeof ig !== 'undefined' && typeof ig.messages !== 'undefined' ){
		  	jQuery.each(ig.messages, function(i, msg){
		  		var forms = jQuery(msg.el).find('.rainmaker_form form');
		  		forms.each(function(i, form){
			  		if(!jQuery(form).hasClass('rm_init_done')){
						window.rainmaker.init(form);
			  			jQuery(form).addClass('rm_init_done');
			  		}
		  		});
		  	});
	  	}

  	}); // init.icegram
	
	//Handle CTA function(s) after successful submission of form
  	jQuery( window ).off('success.rm');
  	jQuery( window ).on('success.rm', function(e, form, response) {
  		if( typeof icegram !== 'undefined'){
  			var msg_id = ((jQuery(e.target).closest('[id^=icegram_message_]') || {}).attr('id') || '').split('_').pop() || 0 ;
			var msg = icegram.get_message_by_id(msg_id) || undefined;
		  	if(typeof msg !== 'undefined'){
		  		if(msg.data.cta === 'form_via_ajax' && msg.el.find('.rm_subscription').length > 0){
			  		// TODO::test this , causing duplicate messages
		  			msg.el.trigger('form_success.ig_cta', [msg]);
			  	} else if(msg.data.cta === 'form' || !msg.data.cta){
			  		if(msg.data.use_form == undefined){
				  		msg.data.response_text = '';
			  		} 
			  		response_text = '<div class="ig_form_response_text">'+ (msg.data.response_text || msg.el.find('.rm_form_message').html() || '') +'</div>';
					msg.el.find('.ig_form_container, .ig_message, .ig_headline').hide();
					var	appendTo = msg.el.filter('.ig_container');
					if(jQuery.inArray(msg.data.type, ['interstitial', 'messenger']) !== -1){
						appendTo = msg.el.find('.ig_message');
						appendTo.show();
						msg.el.find('.ig_headline').text('').show();
					}else if(msg.data.type === 'tab'){
						//TODO :: hide is not working 
						appendTo = msg.el.find('.ig_data');
						msg.el.find('.ig_headline').show();
					}
					try{
						appendTo.append(response_text);
					}catch(err){
						console.log(err);
					}
			  	}
	  		}

  		}
	}); //success.rm

	// addLead on IG-CTA form submit event
	jQuery(window).off('form_submit.ig_cta');
	jQuery(window).on('form_submit.ig_cta', window.rainmaker.addLead);

});
