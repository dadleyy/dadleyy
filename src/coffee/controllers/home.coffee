djh.controller "HomeController", ["$scope", "$rootScope", "DadleyAPI", ($scope, $rootScope, DadleyAPI) ->

  loaded = ->
    $rootScope.$broadcast "viewReady"

  updateItems = ->
    $scope.items = DadleyAPI.Project.query null, loaded

  $scope.items = []

  updateItems()
]

