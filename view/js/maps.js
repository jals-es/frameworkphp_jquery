// function set_api() {
//     if ($(".map_content") != null) {
//         $("<div></div>").attr({ "id": "map" }).appendTo(".map_content");
//         $("<script></script>").attr({ "id": "api_map", "src": "https://maps.googleapis.com/maps/api/js?key=" + keymaps + "&callback=initMap&libraries=&v=weekly", "async": "true", "defer": "true" }).appendTo(".map_content");
//         $("script")[0].parentNode.appendChild("#api_map");
//         initMap();
//     }
// }

function set_api() {
    var language = localStorage.getItem("lang");
    if ($(".map_content") != null) {
        $("<div></div>").attr({ "id": "map" }).appendTo(".map_content");
        var script = document.createElement('script');
        script.src = "https://maps.googleapis.com/maps/api/js?key=" + keymaps + "&language=" + language + "&callback=initMap";
        script.async;
        script.defer;
        document.getElementsByTagName('script')[0].parentNode.appendChild(script);
    }
}

function initMap() {
    friendlyURL("?page=general&op=locales").then(function(data) {
        $.ajax({
            type: "POST",
            url: data,
            dataType: "JSON"
        }).done(function(response) {
            // console.log(response);

            posicion_cliente(response);

        }).fail(function(response) {
            console.log(response);
        });
    });
}

function showMap(response, cliente) {
    var markers = [];

    const uluru = [];

    for (row in response) {
        uluru.push([response[row].name, response[row].lng, response[row].lat]);
    }

    // console.log(cliente.lng + " <---> " + cliente.lat);

    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: cliente.zoom,
        center: new google.maps.LatLng(cliente.lat, cliente.lng),
        // center: new google.maps.LatLng(38.818481212251086, -0.608961771238333),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    for (var i = 0; i < uluru.length; i++) {

        var newMarker = new google.maps.Marker({
            position: new google.maps.LatLng(uluru[i][1], uluru[i][2]),
            map: map,
            title: uluru[i][0]
        });

        google.maps.event.addListener(newMarker, 'click', (function(newMarker, i) {
            return function() {
                map.panTo(this.getPosition());
                map.setZoom(17);
                infowindow.setContent(uluru[i][0]);
                infowindow.open(map, newMarker);
            }
        })(newMarker, i));

        markers.push(newMarker);
    }
}


function posicion_cliente(response) {
    navigator.geolocation.getCurrentPosition(function(posi) {

        var lng = posi.coords.longitude;
        var lat = posi.coords.latitude;
        var zoom = 10;

        var cliente = { "lng": lng, "lat": lat, "zoom": zoom };

        showMap(response, cliente);

    }, function() {
        var lng = 0;
        var lat = 0;
        var zoom = 0;

        var cliente = { "lng": lng, "lat": lat, "zoom": zoom };

        showMap(response, cliente);

    });
}