
/*
$.fn.slideNextPage = function(options){
  var opt = $.extend({'docId':0,'tpl':''},options);
  var thisParent = $(this);
  
}
*/

function showTipMessage(left,right,top,text){
  var posStyle = right==false ? 'left:'+left+'px;top:'+top+'px;' : 'right:'+right+'px;top:'+top+'px;';
  var lines = text.length>35 ? 'two' : 'one';
  var mess = '<div class="tip-bubble" id="tipBubble" style="'+posStyle+'">'
    +'<div class="'+lines+'-line">'+text+'</div>'
  +'</div>';
  $(document).bind('ready',function(){
    $(document.body).append(mess);
    setTimeout(function(){
      $('#tipBubble').fadeOut(500,function(){
        $('#tipBubble').remove();
      });
    },3000);
  });
}


function setCartActionsCallback(){
  //if(typeof(inCartProducts)=='undefined') var inCartProducts = new Array();
  var SHKparent = jQuery(shkOptions.stuffCont);
  var stuffContForm = jQuery('form',SHKparent);
  jQuery.each(stuffContForm,function(ii){
   var SHKcurId_arr = (jQuery('input[name=shk-id]',this).val()).split('__');
   var SHKcurId = SHKcurId_arr[0];
   var SHKcurPrice = jQuery('input[name=shk-price]',this).val();
   if(jQuery.inArray(SHKcurId+'_'+SHKcurPrice,inCartProducts)>-1){
     jQuery('input.rent',this)
     .attr({'src':'assets/templates/blu-ray/img/but_tocart2_h.gif'})
     .addClass('disabled')
     .click(function(){return false;});
   }else{
     jQuery('input.rent',this)
     .removeAttr('disabled')
      .attr({'src':'assets/templates/blu-ray/img/but_tocart2.gif'})
     .removeClass('disabled')
     .unbind('click');
   }
  });
}


function getDittoContent(dfparams,selector,action_url,href){
  
  var data = href.indexOf('?')>-1 ? href.substr(href.indexOf('?')+1,href.length) : '';
  var params = data+dfparams;
  
  var d_next = '';
  
  $(selector)
  .before('<div class="separator"></div>')
  .prev('div')
  .css('background','url(assets/templates/blu-ray/img/progressbar2.gif) center center no-repeat')
  .animate({
    'height': '50px'
  },function(){
    var thisSelf = $(this);
    
    $.ajax({
      url: action_url,
      type: "GET",
      data: params+'&no_title=1',
      cache: false,
      success: function(data){
        setTimeout(function(){
          thisSelf
          .css({'height':'auto','background':'none'})
          .after(data);
          $(selector).last().remove();
        },300);
      }
    });
    
  });
  
}



$(document).bind('ready',function(){
  
  if($('#treeMenu').size()>0) $('#treeMenu').menuTree();
  
  var fancyOptions = {
    'type': 'ajax',
    'width': 800,
    'height': 500,
    'hideOnContentClick': false,
    'autoScale': false,
    'autoDimensions': false,
    'centerOnScroll': true,
    'scrolling': 'yes'
  }
  
  //$('a','div.product').fancybox(fancyOptions);
  
  //$('a.lightbox,area.lightbox').fancybox();
  
  $('div.chat-but:first')
  .css({'opacity':0.6})
  .mouseover(function(){
    $(this).stop().animate({'opacity':1});
  })
  .mouseout(function(){
    $(this).stop().animate({'opacity':0.6});
  });
  
});



if($.browser.msie && $.browser.version=='6.0'){
  document.execCommand("BackgroundImageCache",false,true);
}




function showHideBlock(target,self){
  if($(target).is(':visible')){
    $(target).hide();
    $(self).text('открыть');
  }else{
    $(target).show();
    $(self).text('скрыть');
  }
}



$.fn.accordion = function(){
  var thisParent = $(this);
  $('p',thisParent).not(':first').hide();
  $('h3',thisParent)
  .click(function(){
    $('p',thisParent).slideUp();
    $(this).next('p').slideDown();
  })
  .css({'margin-top':'25px'})
  .wrapInner('<span></span>')
  .children('span')
  .css({'cursor':'pointer','border-bottom':'1px dashed #515151'});
}





