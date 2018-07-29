var notif = {
	options : {},
	basisOptions : {
		animate : {
			in : 'fadeIn',
			out : 'fadeOut'
		}
	},
	types : ['success','error'],
	basisData : {
		title	 	: 'Notification',
		type		: '',
		button		: true,
		buttonText 	: 'Ok',
		type 		: ''
	},
	data : {},

	/* ######## METHODS ############# */

	init : function(opts){
		this.options = $.extend({},this.basisOptions,opts);
		var self = this;

		var ov = $('<div class="over"></div>');
		ov.append($('<div class="notif"><h3></h3><p id="textover"></p><button class="close"></button><div class="cross">X</div></div>'));
		$('body').prepend(ov);

		$('.notif').on('click','.cross, button.close',function(){
			self.hide();
		});

		$(document).on('keydown',function(ev){
			if(ev.keyCode == 27) self.hide();
		});

		if(this.options.animate != ''){
			$('.notif').addClass('animated');
		}
	},
	pop : function(param){
		this.data = $.extend({},this.basisData,param);
		console.log($('.notif').attr('class'));
		$('.notif').removeClass(this.types.join(' '));
		console.log($('.notif').attr('class'));
		
		if(this.types.indexOf(this.data.type) != -1){
			$('.notif').addClass(this.data.type);
		}
		console.log($('.notif').attr('class'));

		var rend = '';

		if(typeof this.data.msg != 'string'){
			for(m in this.data.msg){
				rend += this.data.msg[m]+'<br>';
			}
		}else rend = this.data.msg;
		console.log(this.data);
		// RENDU -----------------------
		$('#textover').text(rend);
		$('.notif h3').text(this.data.title);
		if(this.data.button) $('.notif button').addClass('close').text(this.data.buttonText).css('display','block');
		
		this.show();
	},
	show : function(){
		$('.over').addClass('active');
		if(this.options.animate != ''){
			$('.notif').removeClass(this.options.animate.out);
			$('.notif').addClass(this.options.animate.in);
		}
	},
	hide : function(){
		$('.over').removeClass('active');
		if(this.options.animate != ''){
			$('.notif').removeClass(this.options.animate.in);
			$('.notif').addClass(this.options.animate.out);
		}
	}

}