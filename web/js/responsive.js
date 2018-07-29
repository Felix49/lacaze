$(document).ready(function(){$

    // MENU HEADER
    if(window.innerWidth < 701){
        $('header ul').addClass('hidden');
    }

    $(window).on('resize',function(){
        if(window.innerWidth < 701){
            $('header ul').addClass('hidden');
        }
    })

    $('.btn-menu').click(function(){
        $('header ul').toggleClass('hidden');
    })

})