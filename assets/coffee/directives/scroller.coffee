djh.directive "djhScroller", ["$rootScope", "DiddelViewManager", ($rootScope, DiddelViewManager) ->

  djhScroller = 
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

      ele.bind "scroll", scroll
      scope.$on "$routeChangeSuccess", scroll
      DiddelViewManager.registerSwapFn scroll

]

