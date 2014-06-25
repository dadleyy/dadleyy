djh.factory "DiddelViewManager", ["$rootScope", ($rootScope) ->

  triggerSwaps = ->
    i = 0
    while i < _swapFns.length
      _swapFns[i]()
      i++

  _swapFns = []

  $rootScope.$on "viewReady", triggerSwaps

  ViewManager =
    registerSwapFn: (fn) ->
      _swapFns.push fn  if angular.isFunction(fn)

]


