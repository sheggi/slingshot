app.directive('recordlist', function(){
	return {
		restrict: 'E',
		templateUrl: frontendUrl+'record-list.html'
	};
});

app.directive('accountlist', function(){
	return {
		restrict: 'E',
		templateUrl: frontendUrl+'account-list.html'
	};
});