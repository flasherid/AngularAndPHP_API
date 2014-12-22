angular.module('todoApp.service', ['ui.router'])
  .factory('Member', ['$http', function($http) {

  	return{

	 	connectDb : function(callback){
	 	 $http.get('service/checkConn')
	 	  .success(function(data){
	 	  	callback(data);
	 	  }).
	 	  error(function(data){

	 	  });	
	 	},
	 	addUser   : function(user,pass,callback){
	 		
	 	 var members={
	 	 	username : user,
	 	 	password : pass
	 	 };

	 	 $http.post('service/insertUser',{params : members})
	 	  .success(function(data){
	 	  	callback(data);
	 	  	console.log(data);
	 	  }).
	 	  error(function(data){

	 	  });	
	 	},
	 	Delete    : function(id)
	 	{
	 	  $http.delete('service/deleteUser?id=' + id)
	 	  .success(function(data){
	 	  	console.log(data);
	 	  }).
	 	  error(function(data){

	 	  });	
	 	},
	 	Edituser   : function(member,callback)
	 	{
	 	console.log(member);
	 	   $http.post('service/Edituser',{params:member})
	 	  .success(function(data,status){  
	 	  	 callback(status);
	 	  }).
	 	  error(function(data){

	 	  });	
	 	}
	}


  }]);