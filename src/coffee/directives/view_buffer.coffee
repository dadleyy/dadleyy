djh.directive "djhViewBuffer", ["$route", "$compile", "$controller", "DiddelViewManager"

  ($route, $compile, $controller, DiddelViewManager) ->

    _buffers = []
    _container = null
    _initialized = false
    _scope = null
    _ready = false
    _firstCall = true
    _lastScope = null
  
    checkReady = ->
      _buffers.length >= 2

    initializeEngine = (scope) ->
      scope.$on "$routeChangeSuccess", updateBuffers
      _scope = scope
      _initialized = true
      _container = _buffers[0].parent()
      DiddelViewManager.registerSwapFn swapBuffers

    swapBuffers = ->
      frontBuffer = _buffers[0]
      backBuffer = _buffers[1]
      frontBuffer.addClass("back").removeClass("front").css "position", "absolute"
      backBuffer.addClass("front").removeClass("back").css "position", "relative"

      clear_front = () ->
        frontBuffer.html ""

      setTimeout clear_front, 600

      _buffers.reverse()

    updateBuffers = ->
      return false  unless _ready
      currentRoute = $route.current
      routeLocals = currentRoute and currentRoute.locals
      routeTemplate = routeLocals and routeLocals.$template
      templateWrap = angular.element("<div></div>")
      templateEle = undefined
      linkerFn = undefined
      controller = undefined
      backBuffer = _buffers[1]
      return false  unless routeTemplate
      if _lastScope
        _lastScope.$destroy()
        _lastScope = null
      
      # clear out the back buffer
      templateEle = templateWrap.html(routeTemplate).contents()
      
      # add the template ele into the back buffer
      backBuffer.html("").append templateEle
      linkerFn = $compile(templateEle)
      _lastScope = currentRoute.scope = _scope.$new()
      if currentRoute.controller
        routeLocals.$scope = _lastScope
        controller = $controller(currentRoute.controller, routeLocals)
        _lastScope[currentRoute.controllerAs] = controller  if currentRoute.controllerAs
        backBuffer.children().data "$ngControllerController", controller
      linkerFn _lastScope

    djhViewBuffer =
      restrict: "A"
      terminal: true
      link: (scope, element, attr) ->
        bufferName = attr["djhViewBuffer"]
        _buffers.push element
        initializeEngine scope unless _initialized
        _ready = checkReady()

]

