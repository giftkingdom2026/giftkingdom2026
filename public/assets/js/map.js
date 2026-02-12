let data

let map;
let marker;
let geocoder;

function initAutocomplete() {
    geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 24.1837447, lng: 55.296249 },
        zoom: 13,
        mapTypeId: "roadmap",
    });
    marker = new google.maps.Marker({
        position: { lat: 24.1837447, lng:  55.296249},
        map: map,
        draggable: true,
        title: "Drag me!",
    });
    marker.addListener("dragend", (event) => {
        const position = marker.getPosition();
        const lat = event.latLng.lat();
        const lng = event.latLng.lng();

        const latLng = { lat, lng };
        geocoder.geocode({ location: latLng }, (results, status) => {
            if (status === "OK") {
                if (results[0]) {
                            // document.getElementById("place-details").textContent =
                            //     `Place Details: ${results[0].formatted_address}`;
                    console.log(results)
                    document.getElementById("showStep2Btn").disabled = false;

                    jQuery('#showStep2Btn').attr('data',JSON.stringify(results[0]))
                } else {
                            // document.getElementById("place-details").textContent =
                            //     "No place details available.";
                }
            } else {
                        // console.error("Geocoder failed due to:", status);
                        // document.getElementById("place-details").textContent =
                        //     "Geocoder failed.";
            }
        });
        // const places = marker.getPlaces();
        // console.log(marker)
        // alert(`New location: Latitude: ${position.lat()}, Longitude: ${position.lng()}`);
    });
    const input = document.getElementById("pac-input");
    const searchBox = new google.maps.places.SearchBox(input);

    map.addListener("bounds_changed", () => {
        searchBox.setBounds(map.getBounds());
    });

    let markers = [];

    searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        markers.forEach((marker) => {
            marker.setMap(null);
        });
        markers = [];

        const bounds = new google.maps.LatLngBounds();

        places.forEach((place) => {

            if (!place.geometry || !place.geometry.location) {
                console.log("Returned place contains no geometry");
                return;
            }

            // const icon = {
            //     url: place.icon,
            //     size: new google.maps.Size(71, 71),
            //     origin: new google.maps.Point(0, 0),
            //     anchor: new google.maps.Point(17, 34),
            //     scaledSize: new google.maps.Size(25, 25),
            // };

            // markers.push(
            //     new google.maps.Marker({
            //         map,
            //         icon,
            //         title: place.name,
            //         position: place.geometry.location,
            //     }), );
            marker.setPosition(place.geometry.location);
            if (place.geometry.viewport) {

                bounds.union(place.geometry.viewport);

            } else {

                bounds.extend(place.geometry.location);

            }

            document.getElementById("showStep2Btn").disabled = false;

            jQuery('#showStep2Btn').attr('data',JSON.stringify(place))

        });

        map.fitBounds(bounds);

    });

    // $("#map").append('<button  class="btn mb-4 p-2 ms-3 position-absolute start-0 bottom-0" style="min-width:auto;" onclick="getLocation()"><svg height="20" viewBox="0 0 48 48" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h48v48h-48z" fill="none"/><path d="M24 16c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm17.88 6c-.92-8.34-7.54-14.96-15.88-15.88v-4.12h-4v4.12c-8.34.92-14.96 7.54-15.88 15.88h-4.12v4h4.12c.92 8.34 7.54 14.96 15.88 15.88v4.12h4v-4.12c8.34-.92 14.96-7.54 15.88-15.88h4.12v-4h-4.12zm-17.88 16c-7.73 0-14-6.27-14-14s6.27-14 14-14 14 6.27 14 14-6.27 14-14 14z"/></svg></button>');
}
function getLocation() {
    const status = document.getElementById('status');

            // Check if Geolocation is supported
    if (!navigator.geolocation) {
     alert= 'Geolocation is not supported by your browser.';
     return;
 }

            // Request location
 alert = 'Requesting location...';

 navigator.geolocation.getCurrentPosition(
    (position) => {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;

                    // Move the map and marker to the current location
        const currentLocation = { lat, lng };
        map.setCenter(currentLocation);
        marker.setPosition(currentLocation);
        const latLng = { lat, lng };
        geocoder.geocode({ location: latLng }, (results, status) => {
            if (status === "OK") {
                if (results[0]) {
                                    // document.getElementById("place-details").textContent =
                                    //     `Place Details: ${results[0].formatted_address}`;
                    console.log(results)
                    document.getElementById("showStep2Btn").disabled = false;

                    jQuery('#showStep2Btn').attr('data',JSON.stringify(results[0]))
                } else {
                                    // document.getElementById("place-details").textContent =
                                    //     "No place details available.";
                }
            } else {
                                // console.error("Geocoder failed due to:", status);
                                // document.getElementById("place-details").textContent =
                                //     "Geocoder failed.";
            }
        });
                    // alert = `Latitude: ${latitude}, Longitude: ${longitude}`;
    },
    (error) => {
        switch (error.code) {
        case error.PERMISSION_DENIED:
            alert = 'User denied the request for Geolocation.';
            break;
        case error.POSITION_UNAVAILABLE:
            alert = 'Location information is unavailable.';
            break;
        case error.TIMEOUT:
            alert = 'The request to get user location timed out.';
            break;
        default:
            alert = 'An unknown error occurred.';
            break;
        }
    }
    );
}
window.initAutocomplete = initAutocomplete;



jQuery('body').delegate('.map-overlap','click',function() {

    jQuery('#addresses').hide()

})

jQuery('body').delegate('.addressess-select .wrap','click',function() {

    let check = jQuery(this).parents('#current-address')

    let check2 = jQuery(this).parents('.acc-right')

    if( check.length == 0 && check2.length == 0 ){

        jQuery('.addressess-select .wrap').removeClass('selected')

        jQuery(this).addClass('selected');

        if( jQuery('.addressess-select .wrap.selected').length != 0 ){

         if( jQuery(this).find('.form').hasClass('active') ){

            jQuery('#confirm-address').attr('disabled','true')
        }
        else{

            jQuery('#confirm-address').removeAttr('disabled')

        }

    }

}

})

jQuery('body').delegate('#addressModal .btn-close','click',function() {

    jQuery('.add_form_address').find('.wrap').each(function() {

        if( jQuery(this).find('.form').hasClass('active') ){

            if( jQuery(this).find('.map-url').length == 0 ){

                jQuery(this).remove()
            }
        }
    })

})

jQuery('body').delegate('#confirm-address','click',function() {

    jQuery('#current-address .wrap').html( jQuery('.addressess-select .wrap.selected').html() )

    jQuery('#current-address .wrap').find('.edit-form').before('<a href="javascript:;" class="edit change-address" data-bs-toggle="modal" data-bs-target="#addresses">Change</a>')
    
    jQuery('#addresses').modal('hide')
    
    jQuery('#current-address .wrap').removeClass('selected')


})

if( jQuery('.addressess-select').length != 0 ){

    if( loggedin == 1 ){

        if( jQuery('.addressess-select .wrap').length == 0 ){

            jQuery('#addresses').hide()
            setTimeout(function() {

                jQuery('.add-address').trigger('click');                
                jQuery('#addresses').hide().attr('style','opacity:0');

                jQuery('#addresses').modal('show')


                setTimeout(function() {

                    jQuery('#addresses').hide()



                },1000)


            },1000)
        }
    }

}