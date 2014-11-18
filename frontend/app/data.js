app.factory("Data", ['$http',
    function ($http) { // This service connects to our REST API

        var serviceBase = location.origin +"/slingshot/backend/handle.php";

        var obj = {};
        obj.get = function (q) {
            return $http.post(serviceBase, q).then(function (results) {
                return results.data;
            });
        };
        obj.post = function (q) {
            return $http.post(serviceBase, q).then(function (results) {
                return results.data;
            });
        };
        obj.put = function (q) {
            return $http.post(serviceBase, q).then(function (results) {
                return results.data;
            });
        };
        obj.delete = function (q) {
            return $http.delete(serviceBase, q).then(function (results) {
                return results.data;
            });
        };

        return obj;
}]);