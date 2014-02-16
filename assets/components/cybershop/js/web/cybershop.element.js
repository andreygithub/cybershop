cybershop.element = {
    options: {
        action_url: '#cs_action_url'
        ,action: 'element'
    }
    ,initialize: function() {
        $(document).on('click', '#comlects_row', function(event){
            event.preventDefault();
            params = {};
            params.complectid = $(this).val();
            cybershop.Element.get(params)
        });
        
        $('.minus').click(function () {
            var $input = $('.nam');
            var count = parseInt($input.val()) - 1;
            count = count < 1 ? 1 : count;
            $input.val(count);
            $input.change();
            return false;
        });
        
        $('.plus').click(function () {
            var $input = $('.nam');
            $input.val(parseInt($input.val()) + 1);
            $input.change();
            return false;
        });
        
    }
    ,get: function(params) {
        params.action = this.options.action;
        params.ctx = 'cybershopConfig.ctx';
        $.post($(this.options.action_url).val(), params, function(response) {
                response = $.parseJSON(response);
                if (response.success) {
                        if (response.message) {
                                cybershop.Message.success(response.message);
                        }
                        cybershop.element.show(response.data);


                }
                else {
                        cybershop.message.error(response.message);
                }
        });
    }
    ,show: function(data) {
        $('#main_foto_palceholder').html(data.foto);
        $('#active_complect_name_palceholder').html(data.complect_name);
        $('[name="complectid"]').val(data.complect_id);
        $('#main_foto_palceholder').show( "fold", 1000 );
    }
        
}