djh.directive 'dHeader', ['$rootScope', '$timeout', '$window', ($rootScope, $timeout, $window) ->

  dHeader =
    replace: true
    templateUrl: 'directives.header'
    link: ($scope, $element, $attrs) ->
      $scope.stage = 0
      $scope.locked = false
      last_top = 0

      start = () ->
        $scope.stage = 2

      end = () ->
        $scope.stage = 0

      finish = () ->
        $scope.stage--
        $timeout end, 2000

      scroll = (evt) ->
        scroll_y = $window.pageYOffset
        height = $element[0].offsetHeight
        if scroll_y > 0
          $scope.locked = true
        else
          $scope.locked = false
        $scope.$digest()

      $rootScope.$on '$routeChangeStart', start
      $rootScope.$on '$routeChangeSuccess', finish
      angular.element($window).bind "scroll", scroll

]
