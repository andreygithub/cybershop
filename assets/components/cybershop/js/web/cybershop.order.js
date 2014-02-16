cybershop.order = {
	element: null
	,initialize: function(selector) {
		var order = this.element = $(selector);
		if (!order.length) {return false;}

		var deliveries = $('#deliveries', order);
		var payments = $('#payments', order);

		order.on('change', 'input,textarea', function(e) {
			var key = $(this).attr('name');
			var value = $(this).val();
			cybershop.order.add(key,value);
		});

		$(document).on('cartstatus', '', function(e,status) {
			cybershop.order.getcost();
		});

		$(document).ajaxStart(function() {
			$("#orderSubmit").attr('disabled',true);
		})
		.ajaxComplete(function() {
			$("#orderSubmit").attr('disabled',false);
		});

		this.updatePayments($('input[name="delivery"]:checked', this.element).data('payments'));
		return true;
	}
	,updatePayments: function(payments) {
            if (payments !=null) {
		$('input[name="payment"]', this.element).attr('disabled',true).parent().hide();
		if (payments.length > 0) {
			for (i in payments) {
				$('input#payment_'+payments[i]).attr('disabled',false).parent().show();
			}
		}
		if ($('input[name="payment"]:visible:checked', this.element).length == 0) {
			$('input[name="payment"]:visible:first', this.element).trigger('click');
		}
            }
	}
	,add: function(key, value) {
		var old_value = value;
		$.post(cybershopConfig.actionUrl, {action:"order/add", key: key, value: value, ctx: cybershopConfig.ctx}, function(response) {
			response = $.parseJSON(response);
			if (response.success) {
				if (response.message) {
					cybershop.message.success(response.message);
				}
				var field = $('[name="'+key+'"]');
				switch (key) {
					case 'delivery':
						field = $('#delivery_'+response.data[key]);
						if (response.data[key] != old_value) {
							field.trigger('click');
						}
						else {
							cybershop.order.updatePayments(field.data('payments'));
							$(document).trigger('cartstatus', response.data);
						}
					break;
					case 'payment':
						field = $('#payment_'+response.data[key]);
						if (response.data[key] != old_value) {
							field.trigger('click');
						}
					break;
					default: field.val(response.data[key]);
				}
			}
			else {
				cybershop.message.error(response.message);
				field.val('');
			}
		});
	}
	,getcost: function() {
		$.post(cybershopConfig.actionUrl, {action:"order/getcost", ctx: cybershopConfig.ctx}, function(response) {
			response = $.parseJSON(response);
			if (response.success) {
				if (response.message) {
					cybershop.message.success(response.message);
				}
				$('#cs_order_cost').text(cybershop.Utils.formatPrice(response.data['cost']));
			}
			else {
				cybershop.message.error(response.message);
			}
		});
	}
	,clean: function() {
		$.post(cybershopConfig.actionUrl, {action:"order/clean", ctx: cybershopConfig.ctx}, function(response) {
			response = $.parseJSON(response);
			if (response.success) {
				if (response.message) {
					cybershop.message.success(response.message);
				}
				document.location = document.location;
			}
			else {
				cybershop.message.error(response.message);
			}
		});
	}
    ,submitForm: function(form_id) {
    	var data = $(form_id).serializeObject()
        data.action = "order/submit";
        data.ctx = cybershopConfig.ctx;
        $.post(cybershopConfig.actionUrl, data, function(response) {
        	response = $.parseJSON(response);
        	if (response.success) {
				if (response.message) {
					cybershop.message.success(response.message);
				}
				if (response.data['redirect']) {
					document.location.href = response.data['redirect'];
				}
				else if (response.data['csorder']) {
					document.location.href = /\?/.test(document.location.href) ? document.location.href + 'csorder=' + response.data['csorder'] : document.location.href + '?csorder=' +  response.data['csorder'];
				}
				else {
					document.location = document.location;
				}
			}
			else {
				cybershop.message.error(response.message);
				$('[name]', this.element).removeClass('error');
                $('.help-inline', this.element).remove();
				for (i in response.data) {
					var field = $('[name="'+response.data[i]+'"]', this.element);
					if (field.attr('type') == 'checkbox' || field.attr('type') == 'radio') {
						field.parent().addClass('error');
					}
					else {
                        field.parent().parent().addClass('error');
                        field.after('<span class="help-inline">Это поле обязательно!</span>');
						//field.addClass('error');
					}
				}
			}
		});	
     }
	,submit: function() {
		cybershop.message.close();

		// Checking for active ajax request
		if (ajaxProgress) {
			$(document).ajaxComplete(function() {
				ajaxProgress = false;
				$(document).unbind('ajaxComplete');
				cybershop.order.submit();
			});
			return false;
		}

		$.post(cybershopConfig.actionUrl, {action:"order/submit", ctx: cybershopConfig.ctx}, function(response) {
			response = $.parseJSON(response);
			if (response.success) {
				if (response.message) {
					cybershop.message.success(response.message);
				}
				if (response.data['redirect']) {
					document.location.href = response.data['redirect'];
				}
				else if (response.data['csorder']) {
					document.location.href = /\?/.test(document.location.href) ? document.location.href + 'csorder=' + response.data['csorder'] : document.location.href + '?csorder=' +  response.data['csorder'];
				}
				else {
					document.location = document.location;
				}
			}
			else {
				cybershop.message.error(response.message);
				$('[name]', this.element).removeClass('error');
                $('.help-inline', this.element).remove();
				for (i in response.data) {
					var field = $('[name="'+response.data[i]+'"]', this.element);
					if (field.attr('type') == 'checkbox' || field.attr('type') == 'radio') {
						field.parent().addClass('error');
					}
					else {
                        field.parent().parent().addClass('error');
                        field.after('<span class="help-inline">Это поле обязательно!</span>');
						//field.addClass('error');
					}
				}
			}
		});
	}
};