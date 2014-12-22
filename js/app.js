var myApp = angular.module('todoApp', ['todoApp.service','ui.router']);


  myApp.controller('TodoController', ['$scope','Member',function($scope,Member) {

  	// Member.connectDb(function(data){
   //      $scope.connect = data;
   //  });


    $scope.addUser=function(user,pass)
    {
    	Member.addUser(user,pass,function(data){ 
        Member.connectDb(function(data){
         $scope.connect = data;
         });

    	});
    }

    $scope.Del = function(id)
    {
      Member.Delete(id);
        Member.connectDb(function(data){
         $scope.connect = data;
         });
     
    }

  }]);

 myApp.config(function($stateProvider, $urlRouterProvider) {
  //
  // For any unmatched url, redirect to /state1
  $urlRouterProvider.otherwise("/home");
  //
  // Now set up the states
  $stateProvider
    .state('state1', {
      url: "/home",
      templateUrl: "home.html",
      controller : "getController",
       resolve:{
        promiseObj:  function($http){
            var test = $http.get('service/checkConn').then(function (data) {
                   return data.data;
               });
            return test;
       }
     }

    })
    .state('state2', {
      url: "/edit/:ID",
      templateUrl: "editUser.html",
      controller : "EditController"
    });
    
});

 myApp.controller('EditController',['$scope','$stateParams','Member','$rootScope',
  function($scope,$stateParams,Member,$rootScope){

  $scope.member = {};

  for (var i = 0; i < $rootScope.connect.length; i++) {

      if ($scope.connect[i].ID == $stateParams.ID)
       {
          $scope.member.id    = $rootScope.connect[i].ID,
          $scope.member.user  = $rootScope.connect[i].userName,
          $scope.member.phone = $rootScope.connect[i].Phone
       }

     $scope.Edituser = function(member)
     {
       Member.Edituser(member);
     }  

  };

}]);

 myApp.controller('getController',['$scope','Member','promiseObj','$rootScope',
  function($scope,Member,promiseObj,$rootScope){

        $rootScope.connect = promiseObj;

 }]);