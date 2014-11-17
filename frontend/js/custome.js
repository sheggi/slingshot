(function(){
var app = angular.module('money', ['ui.bootstrap']);
var urlHandle = location.origin +"/slingshot/backend/handle.php";
console.log(urlHandle);

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

	app.controller('MoneyController', ['$scope', '$http', '$filter', function($scope, $http, $filter){
	$scope.records = [];
	
	req_data = {method:"Record.find", accountId:"a01"};
	$http.post(urlHandle, req_data).
	success( function(data, status){
		//alert(data || status || "success");
		
		console.log(data);
		$scope.records = data.response;
		$scope.records.sort(compareDatetime);
		
	}).
    error(function(data, status) {
		alert( status || "Request failed");
    });
 
	$scope.datetime = new Date();
 
	$scope.newRecord = function(){
		var date = $filter('date')($scope.datetime, 'yyyy-MM-ddTHH:mm:ssZ');
		if($scope.amount == undefined){
			alert("gültige Zahl eingeben");
		} else {
			record = {accountId: "a01", datetime:date, amount: $scope.amount, hint: $scope.hint};
			$scope.datetime = new Date();
			$scope.amount = 0;
			$scope.hint = "";
			
			req_data = record;
			req_data.method = "Record.save";
			
			$http.post(urlHandle, req_data).
			success( function(data, status){
				if(!data.error){
					$scope.records.push(data.response);
					$scope.records.sort(compareDatetime);
				}
				
				console.log(data);
				console.log(data.log);
				
			}).
			error(function(data, status) {
				alert( status || "Request failed");
			});
			
			//$scope.records.push();
		}
	};
	
	$scope.deleteRecord = function(index, id){
		
		if(!confirm("Eintrag wirklich löschen?")) {
			return;
		}
		
		
		req_data = {method:"Record.delete", id: id};
		
		$http.post(urlHandle, req_data).
		success( function(data, status){
			
			console.log(data);
			console.log(data.log);
			$scope.records.splice(index, 1);
			
		}).
		error(function(data, status) {
			alert( status || "Request failed");
		});
	};
}]);

})();