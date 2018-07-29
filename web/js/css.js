$(document).ready(function(){

    // PHOTOS
    $('a.box').on('mouseenter',function(){
        $('a.box').addClass('nb');
        $(this).removeClass('nb');
    }).on('mouseleave',function(){
        $('a.box').removeClass('nb');
    })

})