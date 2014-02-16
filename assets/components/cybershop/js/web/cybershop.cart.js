cybershop.cart = {
	add: function(id, count, options) {
		params = {
			action: 'cart/add'
			,ctx: cybershopConfig.ctx
			,id: id
			,count: count || 1
			,options: options || []
		};

		$.post(cybershopConfig.actionUrl, params, function(response) {
			response = $.parseJSON(response);
			if (response.success) {
				if (response.message) {
					cybershop.message.success(response.message);
				}
				cybershop.cart.status(response.data);
			}
			else {
				cybershop.message.error(response.message);
			}
		});
	}
	,remove: function(key) {
		$.post(cybershopConfig.actionUrl, {action:"cart/remove", key: key, ctx: cybershopConfig.ctx}, function(response) {
			response = $.parseJSON(response);
			if (response.success) {
				if (response.message) {
					cybershop.message.success(response.message);
				}
				cybershop.cart.remove_position(key);
				cybershop.cart.status(response.data);
			}
			else {
				cybershop.message.error(response.message);
			}
		});
	}
	,change: function(key, count) {
		$.post(cybershopConfig.actionUrl, {action:"cart/change", key: key, count: count, ctx: cybershopConfig.ctx}, function(response) {
			response = $.parseJSON(response);
			if (response.success) {
				if (response.message) {

					cybershop.message.success(response.message);
				}
				if (typeof(response.data.key) == 'undefined') {
					cybershop.cart.remove_position(key);
				}
				else {
					$('#'+key).find('')
				}
				cybershop.cart.status(response.data);
			}
			else {
				cybershop.message.error(response.message);
			}
		});
	}
	,status: function(status) {
		if (status.total_count < 1) {
			document.location = document.location;
		}
		else {
			var cart = $('#cs_cart');
			if (status.total_count > 0 && $('.empty', cart).is(':visible')) {
				$('.empty', cart).hide();
				$('.not_empty', cart).show();
			}
			$('.cs_total_weight').text(cybershop.utils.formatWeight(status.total_weight));
			$('.cs_total_count').text(status.total_count);
			$('.cs_total_cost').text(cybershop.utils.formatPrice(status.total_cost));
			$(document).trigger('cartstatus', status);
		}
	}
	,clean: function() {
		$.post(cybershopConfig.actionUrl, {action:"cart/clean", ctx: cybershopConfig.ctx}, function(response) {
			response = $.parseJSON(response);
			if (response.success) {
				if (response.message) {
					cybershop.message.success(response.message);
				}
				cybershop.cart.status(response.data);
			}
			else {
				cybershop.message.error(response.message);
			}
		});
	}
	,remove_position: function(key) {
		$('#'+key).remove();
	}
};