$(document).ready(function(){

	$('.notif').on('click','.cross, button.close',function(){
		notifHide();
	});

	$(document).on('keydown',function(ev){
		if(ev.keyCode == 27) notifHide();
	})

})
var basisOptions = {
	'title' 	: 'Notification',
	'type'		: '',
	'button'	: 'ok',
	'buttonText': 'Ok'
};

function notif(options){
	$('.notif').removeClass('errror success');
	options = $.extend({},basisOptions,options);

	var rend = '';
	if(typeof options.msg != 'string'){
		for(m in options.msg){
			rend += options.msg[m]+'<br>';
		}
	}else rend = options.msg;

	// RENDU -----------------------
	$('.notif').removeClass().addClass('notif '+options.type);
	$('#textover').text(rend);
	$('.notif h3').text(options.title);
	if(options.button) $('.notif button').addClass('close').text(options.buttonText).css('display','block');

	notifShow();
};

function notifShow(){
	$('.over').addClass('active');
};

function notifHide(){
	$('.over').removeClass('active');

}