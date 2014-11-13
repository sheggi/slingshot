(function(){
var app = angular.module('money', ['ui.bootstrap']);

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
	
	req_data = {c:"Money", f:"getRecordList", a: {accountId:"a01"}};
	$http.post("http://localhost/slingshot/backend/handle.php", req_data).
	success( function(data, status){
		//alert(data || status || "success");
		
		$scope.records = data.response;
		console.log(data.log);
		$scope.records.sort(compareDatetime);
		
	}).
    error(function(data, status) {
		alert( status || "Request failed");
    });
 
	$scope.datetime = new Date();
 
	$scope.newRecord = function(){
		var date = $filter('date')($scope.datetime, 'yyyy-MM-ddTHH:mm:ssZ');
		record = {datetime:date, amount: $scope.amount, hint: $scope.hint};
		$scope.datetime = new Date();
		$scope.amount = 0;
		$scope.hint = "";
		
		req_data = {
			c:"money",
			f:"addRecord",
			a:{accountId:"a01", record: record}
		}
		
		$http.post("http://localhost/slingshot/backend/handle.php", req_data).
		success( function(data, status){
			
			$scope.records = data.response;
			$scope.records.sort(function (a, b) {
			if (a.datetime > b.datetime) {
				return 1;
			}
			if (a.datetime < b.datetime) {
				return -1;
			}
			// a must be equal to b
			return 0;
			});
			
			console.log(data);
			console.log(data.log);
			
		}).
		error(function(data, status) {
			alert( status || "Request failed");
		});
		
		//$scope.records.push();
		
	};
	
	$scope.deleteRecord = function(index, id){
		$scope.records.splice(index, 1);
		
		req_data = {
			c:"money",
			f:"deleteRecord",
			a:{accountId:"a01", record: {id: id}}
		}
		
		$http.post("http://localhost/slingshot/backend/handle.php", req_data).
		success( function(data, status){
			
			console.log(data);
			console.log(data.log);
			
		}).
		error(function(data, status) {
			alert( status || "Request failed");
		});
	};
}]);

})();