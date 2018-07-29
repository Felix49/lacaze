(function($){

	var xhr;

	$.fn.dropable = function(o){

		this.each(function(){

			$(this).bind({
				dragenter : function(e){
					e.preventDefault();
				},
				dragover : function(e){
					e.preventDefault();
					$(this).addClass('hover');
				},
				dragleave : function(e){
					e.preventDefault();
					$(this).removeClass('hover');
				}
			});
			
			this.addEventListener('drop',function(e){
				e.preventDefault();
                var cat = '';
                if(typeof $(this).attr('categorie') !== 'undefined'){
                    cat = $(this).attr('categorie');
                }
                console.log($(this));
				$(this).removeClass('hover');
				upload(e.dataTransfer.files,0,cat);
				$('button.abort').fadeIn();
			},false);

		});

		function upload(files,index,categorie){
			var file = files[index];
            xhr = new XMLHttpRequest();

			xhr.open('post','/admin/ajaxphoto/'+categorie,true);
			xhr.setRequestHeader('content-type', 'multipart/form-data');
			xhr.setRequestHeader('x-file-type', file.type);
			xhr.setRequestHeader('x-file-size', file.size);
			xhr.setRequestHeader('x-file-name', file.name);
			
			xhr.onreadystatechange = function(e){
				if(xhr.readyState == 4 && xhr.status == 200 ){

					$('#newphoto .percentage').css('width','0%');
					$('#newphoto p span').text('Nouvelle photo');

					var newimg = $('<a title="Supprimer la photo" href="/admin/deletephoto/'+btoa(file.name)+'.jpg"><img class="zoomIn animated" src="/web/img/gallerie/miniature/'+btoa(file.name)+'.jpg" alt=""></a>');

                    $('.photos').append(newimg);

                    newimg.find('img').load(function(){
                        console.log(newimg);
						$('.photos').append(newimg);
					})

					//new upload
					if((index+1) < files.length){
						upload(files,index+1,categorie);
					}else{
						$('#newphoto button.abort').fadeOut();
					}
				}
			};

			xhr.upload.addEventListener('progress',function(e){
				var perc = Math.round((e.loaded/e.total)*100);
				$('#newphoto p span').text('Photo '+(index+1)+'/'+files.length+'  ('+perc+' %)');
				$('#newphoto .percentage').css('width',perc+'%');
			},false);

			xhr.send(file);
		}

		$('button.abort').on('click',function(){
			aborte();
		});

		aborte = function(){
			xhr.abort();
			$('#newphoto .percentage').css('width','0%');
			$('#newphoto p span').text('Nouvelle photo');
			$('#newphoto button.abort').fadeOut();
		}
	}

})(jQuery);