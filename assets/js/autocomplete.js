function initializeAutocomplete(id) {
    let element = document.getElementById(id);
    if (element) {
        let autocomplete = new google.maps.places.Autocomplete(element, { types: ['geocode'] });
        google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged);
    }
}

function onPlaceChanged() {
    let place = this.getPlace();

    // console.log(place);  // Uncomment this line to view the full object returned by Google API.

    for (let i in place.address_components) {
        let component = place.address_components[i];
        for (let j in component.types) {  // Some types are ["country", "political"]
            let type_element = document.getElementById(component.types[j]);
            if (type_element) {
                type_element.value = component.long_name;
            }
        }
    }
}

google.maps.event.addDomListener(window, 'load', function() {
    initializeAutocomplete('appbundle_activity_address');
    initializeAutocomplete('appbundle_organization_address');
});
