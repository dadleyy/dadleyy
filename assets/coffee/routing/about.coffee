djh.config ['$routeProvider', ($routeProvider) ->

    aboutRoute =
      controller: "AboutController"
      templateUrl: "views.about"
      resolve:
        title: ->
          "about"

    $routeProvider.when '/about', aboutRoute

]
