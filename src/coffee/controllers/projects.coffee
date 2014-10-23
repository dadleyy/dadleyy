djh.controller 'ProjectController', ["$scope", "$rootScope", 'projects', ($scope, $rootScope, projects) ->

  $scope.projects = projects

]

