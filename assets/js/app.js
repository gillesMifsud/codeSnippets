/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
var $ = require('jquery');
require('../scss/app.scss');
require('select2');
require('select2/dist/css/select2.min.css');
require('what-input');
require('foundation-sites');

$(document).foundation();
$('select').select2();

//console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
