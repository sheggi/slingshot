var urlHandle = location.origin +"/slingshot/backend/handle.php";


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


