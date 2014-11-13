(function(){
var model = angular.module("model", []);
model.factory('Record', ['$http' ,function($http){
	var find = function(data){ //FIXXX complete
		var list = [ { "id": "1h989", "account_id": "a01", "amount": "100", "datetime": "2014-11-09T12:13:15+0100", "hint": "Start Saldo" }, { "id": "1lo86", "account_id": "a01", "amount": "-50", "datetime": "2014-11-09T13:45:12+0100", "hint": "Bezug" }, { "id": "19shh", "account_id": "a01", "amount": "60", "datetime": "2014-11-09T13:45:13+0100", "hint": "Einzahlung" }, { "id": "1QP7z", "account_id": "a01", "amount": "234", "datetime": "2014-11-13T14:02:49+0100", "hint": "asdf" }, { "id": "1TScg", "account_id": "a01", "amount": "233456", "datetime": "2014-11-13T16:40:29+0100", "hint": "asss" }, { "id": "1nGFD", "account_id": "a01", "amount": "-6544", "datetime": "2014-11-13T16:40:42+0100", "hint": "fsdg" } ];

		return list;
	}
	
	var Model = function() {
		var id = "",
		account_id = "",
		datetime = "",
		hint = "",
		amount = 0;
		var find = this.find;
	};
	
	return {
		Model: Model,
		find: find
	}
}])
model.factory('Account', ['$http', 'Record' ,function($http, Record){
	var current = null;
	
	var find = function(data){ //FIXXX complete
		var account = new Model();
		account.id = "a01";
		account.title = "Portemonaie";
		account.records = Record.find({account_id:account.id});
		return [account];
	}
	
	var Model = function() {
		var id = "",
		nick = "",
		forename = "",
		surname = "",
		email = "",
		password = "",
		additional = "",
		records = [];
		var find = this.find;
	};
	
	return {
		current: current,
		Model: Model,
		find: find
	}
}]);
model.factory('User', ['$http', 'Account' ,function($http, Account){
	var current = null;
	
	
	var find = function(data){ //FIXXX complete
		var user = new Model();
		user.id = "u01";
		user.nick = "admin";
		user.accounts = Account.find({user_id:user.id});//FIXXX C //[{id:"a01", user_id:"u01", title:"Portemonaie"}];
		return [user];
	}
	
	var Model = function() {
		var id = "",
		user_id = "",
		title = "",
		description = "",
		find = this.find;
	};
	
	var selectAccount = function (identifier){
		//FIXXX improve
		console.log(this.current.accounts);
		Account.current = this.current.accounts[identifier];
	}
	
	return {
		current: current,
		Model: Model,
		find: find,
		selectAccount: selectAccount
	}
}]);
model.factory('Session',
['$http', 'User' ,function($http, User){

	var logonUser = function (nick, password){
		//FIXXX do login
		User.current = User.find({nick:nick, password:password})[0];
		return User.current;
	}

	return {
		logonUser: logonUser
	}
}]);



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



angular.module('money', ['ui.bootstrap', 'model']).controller('MoneyController',
['$scope', '$http', '$filter', 'Session', 'User', 'Account', function($scope, $http, $filter, Session, User, Account){
	$scope.records = [];
	
	Session.logonUser();
	User.selectAccount(0);
	
	$scope.session = {};
	$scope.session.user = User.current;
	$scope.session.account = Account.current; 
	console.log($scope.session);
	
	
	req_data = {c:"Money", f:"getRecordList", a: {accountId:"a01"}};
	$http.post("http://localhost/slingshot/backend/handle.php", req_data).
	success( function(data, status){
		//alert(data || status || "success");
		
		$scope.records = data.response;
		console.log(data.response);
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
			$scope.records.sort(compareDatetime);
			
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