var myapp = angular.module('mainApp', []);
myapp.controller('mainController',function($scope,$http){

    $scope.data = {
        agents: ''
    };
    $scope.dateStart = '2015-08';
    $scope.dateEnd = '2015-10';
    // $scope.getTopAgents = function(){
    //     try{

    //         $http.get('/stats/agents/'+$scope.dateStart+'/'+$scope.dateEnd)
    //             .then(
    //                 function(success){
    //                     console.log("SUCCESS");
    //                     $scope.data.agents = success.data
                        
                        
    //                 },
    //                 function(error){
    //                     console.log("ERR");
    //                     console.log(error);
    //                 }
    //             );
                
    //         }
    //     catch(err){
    //         console.log(err.name + ":" + err.message);
    //     }     
    //     console.log($scope.data.agents);
    // }
    // $scope.getTopAgents();

    $scope.propertyName = 'kills';
  $scope.reverse = true;

  $scope.sortBy = function(propertyName) {
    $scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
    $scope.propertyName = propertyName;
  };
    // $scope.contents = [{heading:"Content heading", description:"The actual content"}];
    //Just a placeholder. All web content will be in this format
});

