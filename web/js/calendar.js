$(document).ready(function(){

    var timeData = {
        'days': ['LUN', 'MAR', 'MER', 'JEU', 'VEN', 'SAM', 'DIM'],
        'month': ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
    };
    var today = new Date();
    var currentmonth = new Date();
    var seldate1 = null;
    var seldate2 = null;
    var td1 = null;
    var td2 = null;
    var price = {
        emplacement : 12,
        sup_pers : 2,
        elec : 2
    };

    updateRenderingCalendar();

    // EVENTS
    $(document).on('click','span.navmonth',function(e){
        if($(this).hasClass('next')){
            currentmonth.setMonth(currentmonth.getMonth()+1);
        }else{
            currentmonth.setMonth(currentmonth.getMonth()-1);
        }

        $('span.m').html(timeData.month[currentmonth.getMonth()]);
        $('span.year').html(currentmonth.getFullYear());

        updateRenderingCalendar();
    });

    $(document).on('click','table.calendar td',function(){
        if($(this).hasClass('empty')) return false;

        var seldate = didToDate($(this).attr('did'));

        // AFFECTATION A LA BONNE VARIABLE
        if(seldate2 == null && seldate1 == null){
            seldate1 = seldate;
            seldate2 = null;
        }else if(seldate2 == null && seldate1 != null){
            if(seldate1 < seldate){
                seldate2 = seldate;
            }else{
                seldate2 = null;
                seldate1 = seldate;
            }
        }else if(seldate1 != null && seldate2 != null){
            seldate1 = seldate;
            seldate2 = null;
        }

        if(seldate1 != null){
            $('form.resa input[name=da]').val(seldate1.toLocaleDateString());
        }else{
            $('form.resa input[name=da]').val('');
        }
        if(seldate2 != null) {
            $('form.resa input[name=dd]').val(seldate2.toLocaleDateString());
        }else{
            $('form.resa input[name=dd]').val('');
        }

        updatePrice();
        displaySeldate();
    });

    $(document).on('click change paste keyup','input',function(){
        updatePrice();
    });

    $(document).on('click','p.reset',function(){
        seldate1 = null;
        seldate2 = null;
        displaySeldate();
        $('table.calendar td').removeClass('selected dd da');
        $('form.resa input[name=dd]').val('');
        $('form.resa input[name=da]').val('');
    });

    function didToDate(did){
        return new Date(did);
    }

    function dateToDid(date){
        return (date.getMonth()+1)+'-'+date.getDate()+'-'+date.getFullYear();
    }

    function updateRenderingCalendar(){
        var firstdate = new Date(currentmonth.getFullYear(), currentmonth.getMonth(), 1);
        var current_date_rendering = firstdate;

        if(firstdate.getDay() == 0){
            current_date_rendering.setDate(current_date_rendering.getDate()-6);
        }else{
            current_date_rendering.setDate(current_date_rendering.getDate()-
                (firstdate.getDay()-1)
            );
        }

        for(td = 1; td <= 7*6; td++){
            var nthtr = Math.floor((td-1)/7)+2;
            var nthtd = (td%7!=0)?td%7:7;
            var $td = $('table.calendar tr:nth-child(' +nthtr +') td:nth-child(' +nthtd +')');

            $td.removeClass();
            $td.attr('did',(current_date_rendering.getMonth()+1)+'-'+(current_date_rendering.getDate())+'-'+current_date_rendering.getFullYear());

            if(current_date_rendering.getMonth() != currentmonth.getMonth()){
                $td.addClass('otmonth');
            }else{

            }
            $td.html(current_date_rendering.getDate());
            current_date_rendering.setDate(current_date_rendering.getDate()+1);
        }

        updateFullDays();
        displaySeldate();
    }

    function updateFullDays(){
        getResaByMonth({
            success:function(res){
                
            }
        });
    }

    function getResaByMonth(callbacks){
        // $.ajax('/re',{
        //
        // })
    }

    function colorInter(){
        if(seldate1 != null && seldate2!=null){
            var tempdate = new Date(seldate1);
            while(tempdate < seldate2){
                $('table.calendar td[did="'+dateToDid(tempdate)+'"]').addClass('intm');
                tempdate.setDate(tempdate.getDate()+1);
            }
        }
    }

    function displaySeldate(){
        $('table.calendar td').removeClass('selected da dd intm');
        // AFFICHAGE
        if(seldate1 != null){
            $('table.calendar td[did="'+dateToDid(seldate1)+'"]').addClass('selected da');
        }else{
            $('table.calendar td.da').removeClass('selected da dd');
        }
        if(seldate2 != null) {
            $('table.calendar td[did="'+dateToDid(seldate2)+'"]').addClass('selected dd');
        }else{
            $('table.calendar td.dd').removeClass('selected da dd');
        }

        colorInter();

    }

    function updatePrice(){
        if(seldate1 != null && seldate2 != null){
            $('.est-price').addClass('active');
            var timeDiff = Math.abs(seldate2.getTime() - seldate1.getTime());
            var days = Math.ceil(timeDiff / (3600 * 1000 * 24));
            var withelec = $('input[name=elec]').is(':checked');
            var nbemp = $('input[name=nb_emp]').val();
            var nbpers = $('input[name=nb_pers]').val();
            var estprice = (days*(nbemp*price.emplacement+(withelec?price.elec:0)))+(price.sup_pers*nbpers*days);

            $('.est-price span.price').html(estprice+' €');
        }else{
            $('.est-price span.price').html('');
            $('.est-price').removeClass('active');
        }
    }

});