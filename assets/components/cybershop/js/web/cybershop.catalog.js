cybershop.catalog = {
    options: {
        categorys: '#categorysInput'
        ,brands: '#brandsInput'
        ,filters: '#filtersInput'
        ,categorysgroup: '#categorysgroup'
        ,pricemin: '#pricemin'
        ,pricemax: '#pricemax'
        ,slider: '#slider-range'
        ,amount: '#amount'
        ,sortname: '#sortname'
        ,sortdirection: '#sortdirection'
        ,limit: '#limit'
        ,min_slider_range: '#cs_min_range'
        ,max_slider_range: '#cs_max_range'
        ,pagination: '#pagination_placeholder'
        ,pagination_link: '#pagination_placeholder a'
        ,action_url: '#cs_action_url'
        ,page: '#page'
        ,result_placeholder: '#catalog_placeholder'
        ,navigation_placeholder: '#catalog_nav_placeholder'
        ,pagination_placeholder: '#pagination_placeholder'
        ,id_sortname: '#cs_catalog_sortname'
        ,id_sortdirection: '#cs_catalog_sortdirection'
        ,id_limit: '#cs_catalog_limit'
        
        ,action: 'filter'
        ,active_class: 'active'
	,disabled_class: 'disabled'
    }
    
    ,initialize: function() {
//        var vmin = Number($(this.options.min_slider_range).val());
//        var vmax = Number($(this.options.max_slider_range).val());
//        $( this.options.slider ).slider({
//            range: true
//            ,min: vmin
//            ,max: vmax
//            ,values: [ vmin, vmax ]
//            ,stop: function( event, ui ) {
//                $(cybershop.Catalog.options.pricemin).val($(this).slider('values',0));
//                $(cybershop.Catalog.options.pricemax).val($(this).slider('values',1));
//                $(cybershop.Catalog.options.page).val('');
//                cybershop.Catalog.get();
//            }
//            ,slide: function( event, ui ) {
//                $( cybershop.Catalog.options.amount ).val( ui.values[ 0 ] + " сом. - " + ui.values[ 1 ] + " сом.");
//                
//            }
//        });
//        $( this.options.amount ).val( vmin + " сом. - " + vmax + " сом.");
//        $('<img id="loadingsrc="ajax-loader.gif" alt="Ajax-loading">').appendTo('body');
//        $.ajaxStart(function() {
//            $(this.options.result_placeholder).css();
//            $('#loading').show();
//        });
//        $.ajaxStop(function(){
//            $('#loading').hide();
//        }); 
        this.handlePagination();
        this.handleSortdirection();
        this.handleLimit();
        
//        var currentRequsts = {};
//        $.ajaxPrefilter(function(options, originalOptions, jqXHR ) {
//           if (currentRequsts[options.url]) {
//               currentRequsts[options.url].abort();
//           }
//           currentRequsts[options.url] = jqXHR;           
//            
//        });

    }
    ,handlePagination: function() {
        $(document).on('click', cybershop.catalog.options.pagination + " li" , function(event) {
            event.preventDefault();
            $(cybershop.catalog.options.page).val($(this).val());
            cybershop.catalog.get();
        });
    }
    
    ,handleSortdirection: function() {
        $(document).on('click', '#cs_catalog_sortdirection', function(event) {
            event.preventDefault();
            if ($('#sortdirection').val() != $('#cs_catalog_sortdirection select option:selected').val()) {
                $('#sortdirection').val($('#cs_catalog_sortdirection select option:selected').val());
                cybershop.catalog.get();
            }
        });
    }
    ,handleLimit: function() {
        $(document).on('click', cybershop.catalog.options.id_limit , function(event) {
            event.preventDefault();
            if ($('#limit').val() != $('#cs_catalog_limit select option:selected').val()) {
                $('#limit').val($('#cs_catalog_limit select option:selected').val());
                cybershop.catalog.get();
            }
        });
    }
    ,get: function() {
        var categorys = new Array();
        $('[name="category"]:checked').each(
            function(){
                categorys.push($(this).val());
            })

        var brands = new Array();
        $('[name="brand"]:checked').each(
            function(){
                brands.push($(this).val());
            })

        var filters = new Array();
        $('[name="filter"]:checked').each(
            function(){
                filters.push($(this).val());                
            })


            var categorysgroup_string = $(this.options.categorysgroup).val();
            var page = $(this.options.page).val();
            var limit = $(this.options.limit).val();
            var sortname = $(this.options.sortname).val();
            var sortdirection = $(this.options.sortdirection).val();
            var categorys_string = categorys.join(',');
            var brands_string = brands.join(',');
            var filters_string = filters.join(',');	

        if(filters_string != $(this.options.filters).val() || brands_string != $(this.options.brands).val() || categorys_string != $(this.options.categorys).val())
            {

            $(this.options.categorys).val(categorys_string);
            $(this.options.brands).val(brands_string);
            $(this.options.filters).val(filters_string);
            $(this.options.page).val('');
//            $(this.options.limit).val('');
//            $(this.options.sortname).val('');
//            $(this.options.sortdirection).val('');
            }

        params = {};  
        if (categorysgroup_string != '') { params.categorysgroup = categorysgroup_string; }
        if (categorys_string != '') { params.categorys = categorys_string; }
        if (brands_string != '') { params.brands = brands_string; }
        if (filters_string != '') { params.filters = filters_string; }
        if (page != '') { params.page = page; }
        if (limit != '') { params.limit = limit; }
        if (sortdirection != '') { params.sortdirection = sortdirection; }
        if (sortname != '') { params.sortname = sortname; }
        if ($(this.options.pricemin).val() != '') {params.pricemin = $(this.options.pricemin).val();}
        if ($(this.options.pricemax).val() != '') {params.pricemax = $(this.options.pricemax).val();}
        
        cybershop.hash.set(params);
        

        params.action = this.options.action;
        params.ctx = 'cybershopConfig.ctx';

        $.post($(this.options.action_url).val(), params, function(response) {
                    response = $.parseJSON(response);
                    if (response.success) {
                            if (response.message) {
                                    cybershop.message.success(response.message);
                            }
                            cybershop.catalog.show(response.data);


                    }
                    else {
                            cybershop.message.error(response.message);
                    }
            });

        }
        ,show: function(data){
            $(this.options.result_placeholder).html(data.result);
            $(this.options.navigation_placeholder).html(data.navigation);
            $(this.options.pagination_placeholder).html(data.pagination);
        }
}



