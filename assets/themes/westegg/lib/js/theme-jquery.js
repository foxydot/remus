jQuery(document).ready(function($) {	
    $('*:first-child').addClass('first-child');
    $('*:last-child').addClass('last-child');
    $('*:nth-child(even)').addClass('even');
    $('*:nth-child(odd)').addClass('odd');
	
	var numwidgets = $('#footer-widgets div.widget').length;
	$('#footer-widgets').addClass('cols-'+numwidgets);
	$.each(['show', 'hide'], function (i, ev) {
        var el = $.fn[ev];
        $.fn[ev] = function () {
          this.trigger(ev);
          return el.apply(this, arguments);
        };
      });

	$('.nav-footer ul.menu>li').after(function(){
		if(!$(this).hasClass('last-child') && $(this).hasClass('menu-item') && $(this).css('display')!='none'){
			return '<li class="separator">|</li>';
		}
	});
	
	$('.nav-primary .remus-logo').html('').append($('.site-header .title-area .site-title'));
	$('.nav-primary li.menu-item.dot a').append('<span class="separator-dot">&nbsp;</span>');
	
	$(".go-up").click(function(){
        $("html,body").animate({scrollTop:0},500);
        return false;
    });
    if(jQuery(this).scrollTop() > 600 ) {
            jQuery(".go-up").css("right","40px");
        }else {
            jQuery(".go-up").css("right","-60px");
        }
        
    //hacky moves to get the html to work in WP
    $('.page-title-area .wrap').append($('.section-move-into-header .section-body .wrap'));
    $('.section-move-into-header').detach();
    $('.section-handcrafted-recipes,.section-contact-george-remus').wrapInner('<div class="col-lg-6 col-lg-offset-6 col-md-6 col-md-offset-6 col-sm-6 col-sm-offset-6 col-xs-12 col-xs-offset-0"></div>');
    
    Cufon.replace('.franchise-bold', { fontFamily:'Franchise Bold', hover:true });
    Cufon('.recipebtn', {
    hover: { color: '#f99b01'},
    color: '#ffffff',
    });
});


jQuery(window).scroll(function () {
        if(jQuery(this).scrollTop() > 600 ) {
            jQuery(".go-up").css("right","40px");
        }else {
            jQuery(".go-up").css("right","-60px");
        }
    });
    
