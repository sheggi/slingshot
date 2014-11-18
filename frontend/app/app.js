var app = angular.module('myApp',['ui.bootstrap']);

var handleUrl = location.origin +"/slingshot/backend/handle.php";
var frontendUrl = location.origin +"/slingshot/frontend/";


var compareDatetime = function (a, b) {
	if (a.datetime > b.datetime) {
		return 1;
	}
	if (a.datetime < b.datetime) {
		return -1;
	}
	// a must be equal to b
	return 0;
};



