djh.directive "djhRepeater", [() ->
  
  djhRepeater = 
    restrict: "EA"
    scope:
      items: "="
    templateUrl: "directives.repeater"
    link: (scope, element, attrs) ->
      scope.template = attrs["itemTemplate"]

]

