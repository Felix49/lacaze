var options = {

    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center: new google.maps.LatLng(45.9,1.64),
    streetViewControlOptions: { style: google.maps.ZoomControlStyle.SMALL, position: google.maps.ControlPosition.RIGHT_BOTTOM },
    scrollwheel: true,
    mapTypeControl: true,
    mapTypeControlOptions: { style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR },
    zoomControl: true,
    zoomControlOptions: { style: google.maps.ZoomControlStyle.SMALL, position: google.maps.ControlPosition.TOP_RIGHT },
    scaleControl: true,
    scaleControlOptions: { style: google.maps.ZoomControlStyle.SMALL, position: google.maps.ControlPosition.TOP_RIGHT },
    zoom: 5,
    minZoom: 3,
    maxZoom: 25

};

var cazell = new google.maps.LatLng(44.3543723,2.1462377);
marker = null;
map = new google.maps.Map(document.getElementById('map'), options);

$(document).ready(function(){
    initMap();
})


function initMap(){

    google.maps.event.addListener(map, 'rightclick',function(e){
        setRepere(e.latLng);
        setTimeDistance(e.latLng);
    })

    var lo = $('input[name=longitude]').val();
    var la = $('input[name=latitude]').val();

    if (lo.length > 0 && la.length > 0) {

        var center = new google.maps.LatLng(la, lo);

        marker = new google.maps.Marker({
            position: center,
            map: map
        });

        map.setCenter(center);
        map.setZoom(9);
    }

    $('input[name=mapsearch]').on('keydown',function(e){
        if(e.keyCode == 13){
            e.preventDefault();

            var srch = $('input[name=mapsearch]').val();
            searchPlace(srch);
        }
    });
    $('button#mapsearch').on('click',function(e){
        e.preventDefault();
        var srch = $('input[name=mapsearch]').val();
        searchPlace(srch);
    });

}

function searchPlace(str){
    console.log('Recherche pour : '+str);

    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({
        address : str
    },function(res,status){
        if(status == 'OK'){
            console.log(status);
            console.log('Résultats : ');
            console.log(res[0]);
            var resLl = res[0].geometry.location;
            var place = res[0].formatted_address;
            // GESTION DES RESULTATS
            $('input[name=mapsearch]').val(place);
            map.setCenter(resLl);
            map.setZoom(14);
        }else{
            Messenger().post('Aucun résultat pour la recherche : '+str);
        }
    });
}

function setRepere(ll){
    console.log(ll);
    console.log(ll.lat());
    console.log(ll.lng());
    if(marker == null){
        marker = new google.maps.Marker({
            position: ll,
            map: map
        });
    }else{
        marker.setPosition(ll);
    }
    $('input[name=latitude]').val(ll.lat());
    $('input[name=longitude]').val(ll.lng());
}

function setTimeDistance(ll){
    var matrix = new google.maps.DistanceMatrixService();
    matrix.getDistanceMatrix({
        origins : [cazell],
        destinations : [ll],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
        //transitOptions : {},
        //durationInTraffic : false,
        avoidHighways: false,
        avoidTolls: false
    },function(res,status){
        console.log(res);
        console.log(status);
        if(status == 'OK' && res.rows[0].elements[0].status == 'OK'){
            var distance = res.rows[0].elements[0].distance;
            var temps = res.rows[0].elements[0].duration;
            console.log(res.rows[0].elements[0].distance);
            console.log(res.rows[0].elements[0].duration);
            $('input[name=km]').val(((distance.value)/1000).toFixed(2));
            $('input[name=minute]').val(Math.floor((temps.value)/60));
        }else{
            Messenger().post({
                message : 'Calcul distance et temps impossible. Google pas content',
                type  : 'error'
            })
        }
    })
}