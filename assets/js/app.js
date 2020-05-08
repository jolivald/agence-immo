import '../css/app.css';
import '../../node_modules/select2/dist/css/select2.css';

import $ from 'jquery';
import 'select2';

$('select').select2();

$('#contactButton').click(e => {
  e.preventDefault();
  $('#contactForm').slideDown();
  $(e.target).slideUp();
});
