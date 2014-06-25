djh.directive "djhCsrf", ["$http", "$rootScope", ($http, $rootScope) ->

  djhCsrf = 
    restrict: "EA"
    priority: 200
    terminal: true
    link: (scope, element, attrs) ->
      csrf_token = attrs["token"]
      $http.defaults.headers.common["X-CSRF"] = csrf_token;

]
