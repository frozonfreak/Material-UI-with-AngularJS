var angularMaterialUI = angular.module('angularMaterialUI',['ui.bootstrap','ui.router','ngGrid','ngCookies','angular-md5']);

//Routing
angularMaterialUI.config(function($stateProvider, $urlRouterProvider,$httpProvider) {
  
  //Allow for CORS
  $httpProvider.defaults.useXDomain = true;

  // Now set up the states
  $stateProvider
    .state('home', {
      url: "/",
      templateUrl: "partials/home.html",
      controller: 'appHomeController',
    })
    .state('Not Found', {
      url: "/404",
      templateUrl: "partials/404.html",

    })
    // For any unmatched url, redirect to /state1
     $urlRouterProvider.otherwise("/404");

});

//Handle all HTTP calls to server
angularMaterialUI.factory('appSession', function($http){
    return {
       	updateNewTask: function(name, detail, deadLine) {
        	return $http.post('server/updateTask.php',{
        		type		: 'newTask',
        		taskName	: name,
        		taskDetail 	: detail,
        		deadLine 	: deadLine
        	});
        }        
    }
});


angularMaterialUI.controller('appHomeController', function($scope, $location, $cookieStore, appSession){
  $scope.alerts = [];

  $scope.closeAlert = function(index) {
      $scope.alerts.splice(index, 1);
  };
  
  $scope.displayError = function(data, status){
      $scope.alerts = [];
      $scope.alerts.push({type:'warning',msg: data});
  };

  $scope.displaySuccess = function(data, status){
      $scope.alerts = [];
      if(data["status"] == 0)
        $scope.alerts.push({type:'success',msg: data});
      else
        $scope.alerts.push({type:'warning',msg: data});
  };

  $scope.connectToServer = function(){
    appSession.updateNewTask('123','456','789s').success($scope.displaySuccess).error($scope.displayError);
  };

  init();
  function init(){
    
  };

});