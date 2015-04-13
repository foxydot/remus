jQuery(document).ready(function($) {    
    var desktopLogo = $('.site-header .title-area .site-title').clone();
    $('.site-header .title-area').addClass('mobile-logo').removeClass('title-area');
    $('.nav-primary .remus-logo').html('').append(desktopLogo);
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
    $('.page.recipes .sectioned-page-wrapper .section').wrapInner('<div class="wrap"><div class="row"><div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 contentBlock"></div></div></div>');
    $('.page.recipes .sectioned-page-wrapper .section .section-body img').each(function(){
        var side = $(this).css('float');
        $(this).wrap('<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 imgBlock"></div>');
        if(side == 'left'){
            $(this).parents('.contentBlock').before($(this).parents('.imgBlock'));
        } else {
            $(this).parents('.contentBlock').after($(this).parents('.imgBlock'));
        }
    });
    $('.page.contact .site-inner').addClass('section-contact-george-remus').wrapInner('<div class="col-lg-6 col-lg-offset-6 col-md-6 col-md-offset-6 col-sm-6 col-sm-offset-6 col-xs-12 col-xs-offset-0"></div>');
    //oh cufon, why are you so awful?
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
    
