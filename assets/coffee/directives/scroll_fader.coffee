djh.directive "djhScrollFader", [() ->

  calcOpacity = (top) ->
    0.0 + (top / 300)
  
  djhScrollFader = 
    restrict: "A"
    link: (scope, ele, attrs) ->
      update = (evt, top) ->
        opacity = calcOpacity(top)
        ele.css opacity: opacity
        return
      scope.$on "scroll", update

]


