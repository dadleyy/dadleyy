djh.directive 'dTitle', ['$rootScope', 'Analytics', ($rootScope, Analytics) ->

  default_title = "danny hadley"
  title_base = "software"

  dTitle =
    replace: false
    restrict: 'A'
    link: ($scope, $element, $attrs) ->
      update = (evt, route) ->
        if route.$$route
          route_title = route.$$route.title || default_title
          Analytics.track route.$$route.originalPath
        else
          route_title = default_title
        $element.text [title_base, route_title].join(' | ')

      $rootScope.$on '$routeChangeSuccess', update

]
