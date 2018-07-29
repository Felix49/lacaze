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

marker = null;
map = new google.maps.Map(document.getElementById('mapalentours'), options);

$(document).ready(function(){
    initMap();
});

function initMap(){

    var lat = $('input[name=latitude]').val();
    var lng = $('input[name=longitude]').val();

    if(lat.length > 1 && lng.length > 1){
        var latlng = new google.maps.LatLng(lat,lng);
        map.setCenter(latlng);
        map.setZoom(12);
        marker = new google.maps.Marker({
            map : map,
            position : latlng
        });
    }

}