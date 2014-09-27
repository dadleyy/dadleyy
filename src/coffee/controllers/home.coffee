djh.controller "HomeController", ["$scope", "$rootScope", 'projects', ($scope, $rootScope, projects) ->

  loaded = ->
    $rootScope.$broadcast "viewReady"

  $scope.items = projects

  loaded()
]

