djh.value "$anchorScroll", () ->
  ''

djh.directive "djhProject", ->
  restrict: "E"
  replace: true
  templateUrl: "/templates/items/project.html"
  scope:
    item: "="
  link: (scope, element, attrs) ->


djh.directive "djhCommentForm", [
  "$rootScope"
  "DiddelAPI"
  ($rootScope, DiddelAPI) ->
    return (
      restrict: "E"
      replace: true
      templateUrl: "/templates/commentForm.html"
      scope:
        item: "="

      link: (scope, element, attrs) ->
        waitTick = ->
          scope.wait--
          console.log scope.wait
          if scope.wait < 0
            clearInterval waitTO
            scope.wait = 0
            scope.$digest()
          return
        validate = ->
          angular.isString(scope.comment) and scope.comment.length > 1
        send = ->
          return err("wait a little longer")  if scope.wait > 0
          comment = new DiddelAPI.Comment(
            comment: scope.comment
            post_id: scope.item.post_id
          )
          comment.$save().then ->
            comment.user = $rootScope.usr
            return

          scope.item.comments.push comment
          scope.wait = 4
          waitTO = setInterval(waitTick, 1000)
          return
        err = (msg) ->
          scope.comment = msg
          return
        waitTO = null
        scope.comment = ""
        scope.wait = 0
        scope.send = ->
          if validate()
            send()
          else
            err()

        return
    )
]

djh.directive "djhCsrf", [
  "$http"
  "$rootScope"
  ($http, $rootScope) ->
    authenticate = (usrInfo) ->
      $rootScope.usr = usrInfo
      try
        $rootScope.$digest()
      return
    
    # ignore angular warnings
    window.djhAuth = authenticate
    return (
      restrict: "E"
      priority: 200
      terminal: true
      link: (scope, element, attrs) ->
        csrfToken = attrs["token"]
        usrToken = false
        $http.defaults.headers.common["X-CSRF"] = csrfToken
        try
          usrToken = JSON.parse(element.text())
        catch e
          usrToken = false
        authenticate usrToken  if usrToken
        return
    )
]

djh.directive "djhScroller", [
  "$rootScope"
  "DiddelViewManager"
  ($rootScope, DiddelViewManager) ->
    return (
      restrict: "A"
      scope: true
      link: (scope, ele, attrs) ->
        scroll = (evt) ->
          top = ele[0].scrollTop
          if top > 310
            ele.addClass "locked"
          else
            ele.removeClass "locked"
          $rootScope.$broadcast "scroll", top
          return
        ele.bind "scroll", scroll
        scope.$on "$routeChangeSuccess", scroll
        DiddelViewManager.registerSwapFn scroll
        return
    )
]
djh.directive "djhScrollFader", [->
  calcOpacity = (top) ->
    0.0 + (top / 300)
  restrict: "A"
  link: (scope, ele, attrs) ->
    update = (evt, top) ->
      opacity = calcOpacity(top)
      ele.css opacity: opacity
      return
    scope.$on "scroll", update
    return
]
djh.directive "djhTitle", [
  "$route"
  ($route) ->
    titleBase = "Danny Hadley"
    titleDelimeteter = " | "
    defaultTitle = "software engineer"
    return (
      restrict: "A"
      link: (scope, ele) ->
        updateTitle = ->
          currentRoute = $route.current
          routeLocals = currentRoute.locals
          currentTitle = routeLocals.title or defaultTitle
          scope.title = [
            titleBase
            currentTitle
          ].join(titleDelimeteter)
          return
        scope.$on "$routeChangeSuccess", updateTitle
        scope.$on "titleChange", updateTitle
        return
    )
]

djh.controller "HomeController", [
  "$scope"
  "$route"
  "$rootScope"
  "DiddelAPI"
  ($scope, $route, $rootScope, DiddelAPI) ->
    updateItems = ->
      $scope.items = DiddelAPI.Project.query(null, ->
        $rootScope.$broadcast "viewReady"
        return
      )
      return
    $scope.items = []
    updateItems()
]

djh.controller "AboutController", [
  "$scope"
  "$rootScope"
  "DiddelAPI"
  ($scope, $rootScope, DiddelAPI) ->
    updateItems = ->
      $scope.techs = DiddelAPI.Technology.query(null, ->
        $rootScope.$broadcast "viewReady"
        return
      )
      return
    $scope.techs = []
    updateItems()
]

djh.factory "DiddelViewManager", [
  "$rootScope"
  ($rootScope) ->
    triggerSwaps = ->
      i = 0

      while i < _swapFns.length
        _swapFns[i]()
        i++
      return
    ViewManager = {}
    _swapFns = []
    ViewManager.registerSwapFn = (fn) ->
      _swapFns.push fn  if angular.isFunction(fn)
      return

    $rootScope.$on "viewReady", triggerSwaps
    return ViewManager
]

djh.factory "DiddelAPI", [
  "$resource"
  "$rootScope"
  ($resource, $rootScope) ->
    BlogPostDecorator = (response) ->
      posts = response.resource
      angular.forEach posts, (post) ->
        angular.forEach post.comments, (comment, indx) ->
          post.comments[indx] = new Comment(comment)
          return

        return

      return
    Project = undefined
    BlogPost = undefined
    Technology = undefined
    Comment = undefined
    API = {}
    Project = $resource("/api/projects/:project_id", {})
    BlogPost = $resource("/api/posts/:post_id", {},
      query:
        method: "GET"
        isArray: true
        interceptor:
          response: BlogPostDecorator
    )
    Technology = $resource("/api/techs/:tech_id", {})
    Comment = $resource("/api/comments/:comment_id/:fn", {},
      delete:
        method: "POST"
        params:
          comment_id: "@comment_id"
          fn: "delete"
    )
    API.Project = Project
    API.BlogPost = BlogPost
    API.Technology = Technology
    API.Comment = Comment
    return API
]

