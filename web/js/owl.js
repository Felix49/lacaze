$(document).ready(function(){

	$('.small-picture').owlCarousel({
		pagination : true,
		items : 3,
		itemsScaleUp : true,
        autoWidth: true
	});

	$(document).on('click','.small-picture .owl-item',function(e){

		var oldimg = $('.big-picture img');
		var name = $(this).find('img').attr('imgname');

		$('.small-picture .owl-item').removeClass('active');
		$(this).addClass('active');
		
		$('.loader').addClass('active');
		var img = $('<img src="/web/img/gallerie/'+name+'" alt="" />');
		
		img.load(function(){
			$('.loader').removeClass('active');
            $('.big-picture img').remove();
			$('.big-picture').prepend(img);
		});

	})

})