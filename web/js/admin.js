$(document).ready(function(){

	$(document).on('propertychange input paste', 'input, textarea, select',function(){
		$(this).closest('form').find('input[type=submit]').show();
	});

	$('.confirm').on('click',function(){
		return confirm('Êtes-vous sûr ?');
	})


})