djh.directive "djhTitle", ["$route", ($route) ->

  titleBase = "Danny Hadley"
  titleDelimeteter = " | "
  defaultTitle = "software engineer"

  djhTitle = 
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

      scope.$on "$routeChangeSuccess", updateTitle
      scope.$on "titleChange", updateTitle

]
