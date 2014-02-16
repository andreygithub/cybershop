cybershop.message = {
	success: function(message) {
		if (message) {
			$.jGrowl(message, {theme: 'cs-message-success'});
		}
	}
	,error: function(message) {
		if (message) {
			$.jGrowl(message, {theme: 'cs-message-error', sticky: true});
		}
	}
	,info: function(message) {
		if (message) {
			$.jGrowl(message, {theme: 'cs-message-info'});
		}
	}
	,close: function() {
		$.jGrowl('close');
	}
};