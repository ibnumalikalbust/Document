$(window).scroll(function(){
    var wScroll = $(this).scrollTop();
    $('h1').css({
        'transform' : 'translate(0px, '+ wScroll/2 +'%)'
    });

    $('.kotak').css({
        'transform' : 'translate(0px, '+ wScroll/10 +'%)'
    })
});