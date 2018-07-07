require('../css/app.css');

var $ = require('jquery');
// JS is equivalent to the normal "bootstrap" package
// no need to set this to a variable, just require it
require('bootstrap-sass');

// or you can include specific pieces
// require('bootstrap-sass/javascripts/bootstrap/tooltip');
// require('bootstrap-sass/javascripts/bootstrap/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

function logout() {
	document.location.href = "/logout";
}

function profile() {
	document.location.href = "/user/";
}

function userList() {
	document.location.href = "/admin/user/list"
}