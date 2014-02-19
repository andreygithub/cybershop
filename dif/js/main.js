$(document).ready(function () {
	$(".scrollable").scrollable({
		circular: true, 
		mousewheel: false, 
		wheelSpeed: 1400
	}).navigator().autoscroll(4000);
	$('.navi').addClass('background-' + $('.navi a').size());

	$('.slider .navi').css({
		'margin-right': ($('.slider .info').width() - $('.slider .navi').width()) / 2 + 'px'
	});
	$('.menu .block ul li:first-child').css({
		'margin-left': '0px'
	}).hover(function () {
		$(this).css({
			'margin-left': '-1px'
		});
	}, function () {
		if(! $(this).attr('rel')) 
		{
			$(this).css({
				'margin-left': '0px'
			});
		}
	});
	
	
	
	$('.catalog_block .item:first-child').css({
		'margin': '0px'
	});

	$('.contact_page .block .location:first-child').css({
		'background': 'none'
	});
	$('.popup_menu .block .items ul li:last-child').css({
		'border': 'none'
	});
    
	
	$(".item_page .block .model .images .big").fancybox();
	
	
	

	$('.item_page .block .model .images .small img').click(function () {
		//$('.item_page .block .model .images .big_show').attr('href', $(this).attr('rel'));
		//$('.item_page .block .model .images .big img.item_img').attr('src', $(this).attr('rel'));
		$('.item_page .block .model .images .big').removeClass('big_show');
		$('.item_page .block .model .images .big#' + $(this).attr('rel')).addClass('big_show');
		
	});
	
	$('.menu .block ul li a[rel]').click(function(){
		var self = this;	
		
		$('.popup_menu#' + $(this).attr('rel') + ' .block').css({
			'height': $('.popup_menu#' + $(this).attr('rel')).height() - 25 + 'px'
		});
		if($(this).parent().attr('rel') == 'active'){
			$(this).parent().removeClass('active  sub_active');
			$(this).parent().attr('rel', '');
			$('.popup_menu#' + $(self).attr('rel')).slideUp(500);
			
		}else{
			$('.menu .block ul li a[rel]').parent().removeClass('active  sub_active').attr('rel', '');
			$('.popup_menu').slideUp(500);
			$(this).parent().addClass('active sub_active');
			$(this).parent().attr('rel', 'active');
			$('.popup_menu#' + $(self).attr('rel')).slideDown(700);
		}
	});
	
	$('.menu .block .search .click').click(function(){
		$('.menu .block .search').animate({
			'width' : '228px'
		}, 500);
		$('.menu .block ul li').animate({
			'margin-right' : '1px', 
			'margin-left' : '1px'
		}, 500);
		$('.menu .block ul li:first-child').animate({
			'margin-right' : '0px', 
			'margin-left' : '-1px'
		}, 500);
		
		
		$('.menu .block .search .find').animate({
			'right' : '36px'
		}, 500, function(){
			$(this).css({
				'z-index' : '4'
			});
		})
		$('.menu').addClass('minimize');
		
		
		
		
		$('.minimize .block ul li').hover(function(){
			$(this).hasClass('active') ? $.noop() : $(this).css({
				'margin-left' : '0px', 
				'margin-right' : '0px'
			});
		}, function(){
			$(this).hasClass('active') ? $.noop() : $(this).css({
				'margin-left' : '1px', 
				'margin-right' : '1px'
			});	
		});
	});
	
	$('.header .block .language .choose').click(function(){
		$('.header .block .language .sel').slideDown(100);
	});
	
	$('.header .block .language .sel ul li div').click(function(){
		$('.header .block .language .sel').animate({
			'opacity' : '0'
		}, 100, function(){
			$(this).css({
				'opacity' : '1', 
				'display' : 'none'
			});	
		});
	});
	
	 
	


});

var fix_scroll = 0;
function loadPlacesCatalog() {
	var filters = new Array();
	$('[name="filter"]:checked').each(
		function()
		{
			
			filters.push($(this).val());
		}
		)
			
	var brands = new Array();
	$('[name="brend"]:checked').each(
		function()
		{
			brands.push($(this).val());
		}
		)		
		
	var types = new Array();
	$('[name="type"]:checked').each(
		function()
		{
			types.push($(this).val());
		}
		)	
			
	var pageId = 1;
	var filter_string = filters.join(',');
	var brands_string = brands.join(',');
	var types_string = types.join(',');
	//alert(filter_string);
	//alert( $('#filtersInput').val());
	if(filter_string != $('#filtersInput').val() || brands_string != $('#brandsInput').val() || types_string != $('#typesInput').val()){
		$('#filtersInput').val(filter_string);
		$('#brandsInput').val(brands_string);
		$('#typesInput').val(types_string);
		pageId = 1;
	}
	else
	{
		pageId = $('#pageId').val();
	}
	
	

	if(fix_scroll == 0){
		fix_scroll = 1;
		var city_id = 1;
		var itemsPerPage = $('#itemsPerPage').val();
		
		var searchval = $('#searchval').val();
		var defval = $('#default_search').val();
		
		if(searchval == defval)
		{
			searchval = '';
		}
		
		if(pageId == 1){
			$('#catalog_placeholder').animate({
				opacity: 0.5
			});
		}
		$.getJSON(
			'/catalog/load-places',
			{
				city_id:city_id,
				itemsPerPage: itemsPerPage,
				pageId: pageId,
				filters: filter_string,
				brands: brands_string,
				types: types_string,
				searchval: searchval
			},
			function (results) {
				if (results.result == 'success') {
					$('#nothing_found').css('display', 'none');
					if(pageId == 1)
					{
						$('#catalog_placeholder').html(results.output);
					}
					else{
						$('#catalog_placeholder').append(results.output);
					}
					$('[items_num="items_num"]').html(results.items_num);
				
				
					var nextPage = parseInt(pageId) + 1;
					
					$('#pageId').val(nextPage);
					$('#catalog_placeholder').animate({
						opacity: 1
					});
					fix_scroll = 0;
					
					if(results.filters_block)
					{
						$('#filters_block').css('display', 'block');
						$('#filters_placeholder').html(results.filters_block);
					}
					else
					{
						$('#filters_block').css('display', 'none');
					}
					
					if(results.filters_div)
					{
						$('#filters_placeholder_div').css('display', 'block');
						$('#filters_placeholder_div').html(results.filters_div);
					}
					else
					{
						$('#filters_placeholder_div').css('display', 'none');
					}
					
				} else {
					if(results.result == 'end')
					{
						fix_scroll = 1;
					}
					if(results.result == 'nothing_found')
					{
						fix_scroll = 1;
						$('#nothing_found').css('display', 'block');
						$('#catalog_placeholder').html('');
						$('[items_num="items_num"]').html(0);
						
						if(results.filters_block)
						{
							$('#filters_block').css('display', 'block');
							$('#filters_placeholder').html(results.filters_block);
						}
						else
						{
							$('#filters_block').css('display', 'none');
						}
					}
				}
			}
			);
	}
}

function setItemsPerPage(count){
	$('#itemsPerPage').val(count);
	loadPlacesCatalog();
}

function changeCheckbox(filter_id, filter_name)
{
	jQuery(".niceCheck").each(
		function() {
     
			changeCheckCustom(jQuery(this), filter_id, filter_name);
     
		});
}

function unsetFilters()
{
	jQuery(".niceCheck").each(
		function() {
			uncheckCheckboxes(jQuery(this))
		});
}