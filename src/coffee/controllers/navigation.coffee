djh.controller 'NavigationController', ['$scope', '$route', ($scope, $route) ->

  $scope.exclude = 'home'

  updateScope = () ->
    currentRoute = $route.current
    routeLocals = currentRoute.locals
    routeTitle = routeLocals.title
    routeItemKind = routeLocals.itemKind

    $scope.exclude = routeTitle;
    $scope.itemKind = routeItemKind;
  
  $scope.$on '$routeChangeSuccess', updateScope

]

