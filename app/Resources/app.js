var app = angular.module('myApp', []);
app.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('myCtrl',['$scope','$http', function($scope, $http) {
    $http({
        method : "GET",
        url : "http://localhost:8000/getuser/"
    }).then(function mySuccess(response) {
        $scope.user = response.data;
        console.log(response.data);
    }, function myError(response) {
        console.log(response);
    });
}]);
