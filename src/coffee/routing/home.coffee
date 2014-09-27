djh.config ['$routeProvider', ($routeProvider) ->

  homeRoute = 
    templateUrl: 'views.home'
    controller: 'HomeController'
    resolve:
      title: ->
        "home"
      itemKind: ->
        "projects"


  $routeProvider.when '/home', homeRoute

]
