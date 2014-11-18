app.controller('moneyCtrl',['$scope', '$http', '$filter', 'Data', function($scope, $http, $filter, Data){
	$scope.records = [];
	$scope.accounts = [];
	
	$scope.logonAdmin = function () {
        Data.post({
			method: "User.find",
            nick: "admin",
			LIMIT: "1"
        }).then(function (results) {
            var user = results.response[0];
			$scope.user = user;
			
			Data.post({
				method: "Account.find",
				userId: user.id
			}).then(function (results) {
				var accounts = results.response;
				console.log(accounts);
				$scope.accounts = accounts;
				
				
			});
			
        });
    }
	
	$scope.selectAccount = function(id){
        Data.post({
			method: "Account.find",
            id: id,
			LIMIT: "1"
        }).then(function (results) {
            var account = results.response[0];
			$scope.account = account;
			
			Data.post({
				method: "Record.find",
				accountId: account.id
			}).then(function (results) {
				var records = results.response;
				$scope.records = records;
				
				
			});
			
        });
	};


	$scope.datetime = new Date();
 
	$scope.newRecord = function(){
		var date = $filter('date')($scope.datetime, 'yyyy-MM-ddTHH:mm:ssZ');
		if($scope.amount == undefined){
			alert("gültige Zahl eingeben");
		} else {
			record = {accountId: $scope.account.id, datetime:date, amount: $scope.amount, hint: $scope.hint};
			$scope.datetime = new Date();
			$scope.amount = 0;
			$scope.hint = "";
			
			req_data = record;
			req_data.method = "Record.save";
			
			$http.post(urlHandle, req_data).
			success(function(data, status){
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
			
		}
	};
	
	$scope.deleteRecord = function(index, id){
		
		if(!confirm("Eintrag wirklich löschen?")) {
			return;
		}
		
		
		req_data = {method:"Record.delete", id: id};
		
		$http.post(urlHandle, req_data).
		success(function(data, status){
			
			console.log(data);
			console.log(data.log);
			$scope.records.splice(index, 1);
			
		}).
		error(function(data, status) {
			alert( status || "Request failed");
		});
	};
}])