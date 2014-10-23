djh.directive 'dTitle', ['$rootScope', ($rootScope) ->

  default_title = "engineer"
  title_base = "danny hadley"

  dTitle =
    replace: false
    restrict: 'A'
    link: ($scope, $element, $attrs) ->
      update = (evt, route) ->
        route_title = route.$$route.title || default_title
        $element.text [title_base, route_title].join(' | ')

      $rootScope.$on '$routeChangeSuccess', update

]
