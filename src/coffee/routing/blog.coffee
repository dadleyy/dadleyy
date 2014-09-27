djh.config ['$routeProvider', ($routeProvider) ->

  blogRoute =
    controller: "BlogController"
    templateUrl: "views.blog"
    resolve:
      title: ->
        "blog"
      itemKind: ->
        "posts"

  $routeProvider.when '/blog', blogRoute 

]
