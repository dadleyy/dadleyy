djh.controller "BlogController", ["$scope", "$route", "$rootScope", "DiddelAPI", ($scope, $route, $rootScope, DiddelAPI) ->

  socialRefresh = ->
    refresh = () ->
      window.twttr.widgets.load()
      window.FB.XFBML.parse()

    setTimeout refresh, 600

  ready = ->
    console.log $scope.posts
    $scope.posts.push single_post if single_post isnt false
    $rootScope.$broadcast "viewReady"
    socialRefresh()

  updateItems = ->
    currentRoute = $route.current
    routeParams = currentRoute and currentRoute.params
    postId = routeParams and parseInt(routeParams.post_id, 10)
    $scope.posts = DiddelAPI.BlogPost.query(null, ready)

  $scope.posts = []
  single_post = false
  updateItems()

]
