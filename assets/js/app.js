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
	var $window = $(window);

	checkWidth(window);

	$(window).resize(checkWidth);
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

function checkWidth(window) {
	var windowsize = $(window).width();
    if (windowsize < 751) {
		detabify();
	} else {
		tabify()
	}
}

function detabify() {
	var tables = $(document).find(".mobile-table").each(function(i, e) {
		console.log(e);
	})
}

function tabify() {

}