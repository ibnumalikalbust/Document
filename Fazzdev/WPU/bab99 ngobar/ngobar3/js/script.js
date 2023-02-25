// event pada saat link di klik
$('.page-scroll').on('click', function(e){

    // ambil isi href
    var tujuan = $(this).attr('href');
    // tangkap elemen yang bersangkutan
    var elemenTujuan = $(tujuan);
    // pindahkan scroll
    $('html').animate({
        scrollTop: elemenTujuan.offset().top - 50
    },1000, 'easeInOutExpo');
    // menampilkan debug
    console.log(elemenTujuan.offset().top - 50)
    e.preventDefault();
});

// parallax scroll
$(window).scroll(function() {
    var wScroll = $(this).scrollTop();

    // parallax img
    $('.jumbotron img').css({
        'transform' : 'translate(0px, '+ wScroll/4 +'%)'
    });
    // parallax h1
    $('.jumbotron h1').css({
        'transform' : 'translate(0px, '+ wScroll/2 +'%)'
    });
    // parallax p
    $('.jumbotron p').css({
        'transform' : 'translate(0px, '+ wScroll/1 +'%)'
    });
    // parallax portofolio
    if (wScroll > $('.portofolio').offset().top - 250) {
        $('.portofolio .thumbnail').each(function(i) {
            setTimeout(function() {
                $('.portofolio .thumbnail').eq(i).addClass('muncul');
            }, 300 * (i+1));
        })
    }
});

// parallax load
$(window).on('load', function() {
    $('.pkiri').addClass('pmuncul');
    $('.pkanan').addClass('pmuncul')
});