import '../css/app.css';
import 'select2/dist/css/select2.css';
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css';

import $ from 'jquery';
import 'select2';
import 'slick-carousel';
import Places from 'places.js';
import Map from './map';

$('select').select2();

$('#contactButton').click(e => {
  e.preventDefault();
  $('#contactForm').slideDown();
  $(e.target).slideUp();
});

const searchAddress = document.getElementById('search_address');
if (searchAddress){
  const searchLatitude = document.getElementById('lat');
  const searchLongitude = document.getElementById('lng');
  const place = Places({
    container: searchAddress
  });
  place.on('change', event => {
    searchLatitude.value = event.suggestion.latlng.lat;
    searchLongitude.value = event.suggestion.latlng.lng;
  });
}

const inputAddress = document.getElementById('property_address');
if (inputAddress){
  const inputCity = document.getElementById('property_city');
  const inputPostalCode = document.getElementById('property_postal_code');
  const inputLatitude = document.getElementById('property_lat');
  const inputLongitude = document.getElementById('property_lng');
  const place = Places({
    container: inputAddress
  });
  place.on('change', event => {
    inputCity.value = event.suggestion.city
    inputPostalCode.value = event.suggestion.postcode;
    inputLatitude.value = event.suggestion.latlng.lat;
    inputLongitude.value = event.suggestion.latlng.lng;
  });
}

Map.init();

$('[data-slider]').slick({
  dots: true,
  arrows: true
});
