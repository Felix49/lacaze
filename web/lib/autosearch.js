$(document).ready(function(){
  $('.autosearch').focus().keyup(function(event){
    var input = $(this);
    var val  = input.val();
    var elmt = $(this).attr('src');
    var nbres = 0;

    // Si rien est tapé, on affiche tout
    if(val == ''){
      $(elmt).show();
      input.removeClass('insearch');
    }else{
    	input.addClass('insearch');
    }

    // On construit l'expression à partir de ce qui est tapé (.*)e(.*)x(.*)e(.*)m(.*)p(.*)l(.*)e(.*)
    var regexp = '\\b(.*)';
    for(var i in val){
      regexp += '('+val[i]+')';
    }
    regexp += '(.*)\\b';

    $(elmt).show();

    // On parcourt chaque élément de la liste
    $(elmt).each(function(){
      var span = $(this);
      var resultats = span.text().match(new RegExp(regexp,'i'));
      // le text match
      if(resultats){
        nbres ++;
      }else{
        span.hide();
      }
    })
    if(nbres != $(elmt).length || val != ''){
      $('span.searchres').text(' / Recherche : '+nbres+' résultats');
    }else{
      $('span.searchres').text('');
    }

  });

});