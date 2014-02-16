/*
*
*  Mega-Carousel 1.0
*  
*  
*
*/

var winWidth = $(window).width();

//Проверка события resize для IE 6
function resizeCheck(){
  if($.browser.msie && $.browser.version == "6.0"){
    if($(window).width() != winWidth && winWidth-$(window).width()!=16){
      winWidth = $(window).width();
      return true;
    }else{
      return false;
    }
  }else{
    winWidth = $(window).width();
    return true;
  }
}


(function($) {

$.fn.carousel = function(options){

settings = $.extend({
  parent: 'carousel',
  carouselTitle: 'carousel-title',
  carouselName: 'carousel-name',
  buttons: 'carousel-buts',
  imgsBox: 'carousel-imgs',
  descrBox: 'carousel-descr',
  carouselArrow: 'carousel-arrow',
  carouselBody: 'carousel-body'
}, options);


var dataList = $(this);
var oneWidth = Math.round(mainWidth/3);
//var mainWidth;
var mainWidth = $('div.'+settings.carouselBody,'div.'+settings.parent).eq(0).width();
var oneWidth = Math.round(mainWidth/3);

$('div.'+settings.parent).each(function(index){
  var listParent = $(dataList).eq(index);
  var listSize = $('li',listParent).size();
  var list = $('li',listParent);
  var parent = $(this);
  var buttons = $('div.'+settings.buttons,this);
  var carouselBody = $('div.'+settings.carouselBody,parent);
  var imgsBox = $('div.'+settings.imgsBox,this);
  var carouselName = $('strong.'+settings.carouselName,this);
  var descrBox = $('div.'+settings.descrBox,this);
  var carouselArrow = $('div.'+settings.carouselArrow,this);
  mainWidth = carouselBody.width();
  oneWidth = Math.round(mainWidth/3);
  
  if(listSize==0) return true;
  
//Крутим вперед
function moveForward(){
  var mainWidth = $('.'+settings.carouselBody,parent).width();
  var oneWidth = Math.round(mainWidth/3);
  $('img',imgsBox).unbind('click');
  $('a:eq(1)',buttons).unbind();
  $('a:eq(1)',buttons).click(function(){return false;});
  var curPos = curPosition();
  title = $('strong:first',list).eq(curPos).html();
  link = $('strong:first a',list).eq(curPos).attr('href');
  descr = $('p:first',list).eq(curPos).html();
  //alert(curPos+' - '+listSize);
  carouselName.fadeOut(300,function(){
    if(curPos==1){
      carouselArrow.css('background-position','50% 0%');
      $('a:eq(0)',buttons).show();
      if(curPos==listSize-1){
        $('a:eq(1)',buttons).hide();
      }
    }else if(curPos==listSize-1){
      carouselArrow.css('background-position','84% 0%');
      $('a:eq(1)',buttons).hide();
    }
      var curMarg = parseInt($(imgsBox).css('margin-left').replace('px',''));
      carouselName.fadeOut(300,function(){
        carouselName.html(title);
        carouselName.fadeIn(300,function(){
          $('h2.'+settings.carouselTitle+' span:first',parent).text('('+(curPos+1)+'/'+listSize+')');
          $('#imgLink'+index).replaceWith($('#imgLink'+index).html());
          //$('img:eq('+curPos+')',imgsBox).wrap('<a id="imgLink'+index+'" href="'+link+'"></a>');
          clickOnImgs(curPos,index,link);
          if(curPos!=listSize-1 && curPos>1){
            imgsBox.animate({marginLeft:curMarg-oneWidth+'px'}, 500, changePos(curPos,'fw'));
          }else{
            changePos(curPos,'fw');
          }
        });
      });
  });
}

//Крутим назад
function moveBackward(){
  var mainWidth = $('.'+settings.carouselBody,parent).width();
  var oneWidth = Math.round(mainWidth/3);
  $('img',imgsBox).unbind('click');
  $('a:eq(0)',buttons).unbind();
  $('a:eq(0)',buttons).click(function(){return false;});
  var curPos = curPosition();
  title = $('strong:first',list).eq(curPos-2).html();
  link = $('strong:first a',list).eq(curPos-2).attr('href');
  descr = $('p:first',list).eq(curPos-2).html();
  //alert(curPos+' - '+listSize);
  if(curPos!=1){
    carouselName.fadeOut(300,function(){
      if(curPos==2){
        carouselArrow.css('background-position','16% 0%');
        changePos(curPos,'bw');
        $('a:eq(0)',buttons).hide();
        if(curPos==listSize){
          $('a:eq(1)',buttons).show();
        }
      }else if(curPos==listSize){
        carouselArrow.css('background-position','50% 0%');
        changePos(curPos,'bw');
        $('a:eq(1)',buttons).show();
      }else if(curPos==1){
        carouselArrow.css('background-position','50% 0%');
        $('a:eq(0)',buttons).show();
      }
        var curMarg = parseInt(imgsBox.css('margin-left').replace('px',''));
        carouselName.html(title);
        carouselName.fadeIn(300,function(){
          $('h2.'+settings.carouselTitle+' span:first',parent).text('('+(curPos-1)+'/'+listSize+')');
           $('#imgLink'+index).replaceWith($('#imgLink'+index).html());
           //$('img:eq('+(curPos-2)+')',imgsBox).wrap('<a id="imgLink'+index+'" href="'+link+'"></a>');
           
           clickOnImgs(curPos-2,index,link);
           
        });
        if(curPos!=2 && curPos!=listSize){
          imgsBox.animate({marginLeft:curMarg+oneWidth+'px'}, 500, changePos(curPos,'bw'));
        }else if(curPos==2){
          imgsBox.animate({marginLeft:'0px'}, 200);
        }
    });
  }
}


function clickOnImgs(pos,index,link){
  $('img:eq('+pos+')',imgsBox).wrap('<a id="imgLink'+index+'" href="'+link+'"></a>');
  $('img:eq('+(pos+1)+')',imgsBox).click(moveForward);
  $('img:eq('+(pos-1)+')',imgsBox).click(moveBackward);
}


//Изменяем выделение позиции
function changePos(curPos,direct){
  var startHeight = descrBox.height();
  descrBox.html('<div>'+descr+'</div>');
  var finishHeight = $('div',descrBox).height();
    
  $('div:first',descrBox)
    .css('height',startHeight+'px')
    .animate({
      height: finishHeight+'px'
    },500,function(){
      if(direct=='fw'){
        $('a:eq(1)',buttons).click(function(){
          moveForward();
          return false;
        });
      }else{
        $('a:eq(0)',buttons).click(function(){
          moveBackward();
          return false;
        });
      }
  });

  $('img',imgsBox).removeClass('active');
  var i = direct=='fw' ? curPos : curPos-2;
  $('img:eq('+i+')',imgsBox).addClass('active');
}

//Опредиление текущей позиции
function curPosition(){
  var curMarg = parseInt(imgsBox.css('margin-left').replace('px',''));
  if(listSize>3){
    var curPos = carouselArrow.css('backgroundPosition')!='50% 0%' && curMarg==0
    ? 1
    : carouselArrow.css('backgroundPosition')!='50% 0%' && curMarg<0
    ? Math.round((Math.abs(curMarg)/oneWidth)+3)
    : Math.round((Math.abs(curMarg)/oneWidth)+2);
  }else{
    var curPos = carouselArrow.css('backgroundPosition')=='16% 0%'
    ? 1
    : curPos = carouselArrow.css('backgroundPosition')=='50% 0%'
    ? 2
    : 3;
  }
  return curPos;
}

//Проходим по списку и добавляем фотографии в карусель
$('li',listParent).each(function(i){
  var img = $('img:eq(0)',this).attr('src');
  var act;
  if(i==0){
    title = $('strong:first',this).html();
    link = $('strong:first a',this).attr('href');
    descr = $('p:first',this).html();
    act = ' class="active"';
  }
  imgsBox.append('<div class="col"><img src="'+img+'"'+act+' /></div>');
});

$('img:first',imgsBox).wrap('<a id="imgLink'+index+'" href="'+link+'"></a>');

$('img:eq(1)',imgsBox).click(moveForward);

//Первоначальные значения
$('div.'+settings.carouselBody,parent).css({'width':'100%','overflow':'hidden'});
//$('.'+settings.carouselBody,parent).css('width',mainWidth);
imgsBox.css({
  'margin-left':'0px',
  width: (oneWidth*listSize)+'px'
});
$('div',imgsBox).css('width',oneWidth);
carouselArrow.css('background-position','16% 0%');
carouselName.html(title);
descrBox.html('<div>'+descr+'</div>');
$('div:first',descrBox).css('overflow','hidden');
$('h2.'+settings.carouselTitle).eq(index).append(' <span>(1/'+listSize+')</span>');
$('a:eq(0)',buttons).hide();

//Кнопка назад
$('a:eq(0)',buttons).one("click", function(){
  var curPos = curPosition();
  if(curPos!=1){
    moveBackward();
    return false;
  }
});

//Кнопка вперед
$('a:eq(1)',buttons).one("click", function(){
  var curPos = curPosition();
  if(curPos!=listSize){
    moveForward();
    return false;
  }
});

$(window).bind('resize',function(){
  var delta = carouselBody.width() / mainWidth;
  mainWidth = carouselBody.width();
  var curMarg = parseInt($(imgsBox).css('margin-left').replace('px',''));
  imgsBox.css({
    'width': (oneWidth*delta*listSize+20)+'px',
    'margin-left': Math.round(curMarg*delta)+'px'
  });
  $('div', imgsBox).each(function(){
    $(this).css('width',oneWidth*delta+'px');
  });
  oneWidth = oneWidth*delta;
});


});

return this;

}


})(jQuery);