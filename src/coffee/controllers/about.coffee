djh.controller "AboutController", ["$scope", "$rootScope", "DadleyAPI", ($scope, $rootScope, DadleyAPI) ->
  
  finish = () ->
    $rootScope.$broadcast "viewReady"
  
  updateItems = ->
    $scope.techs = DadleyAPI.Technology.query null, finish

  $scope.techs = []
  updateItems()

]
