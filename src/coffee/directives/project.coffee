djh.directive "djhProject", ['$sce', ($sce) ->

  djhProject = 
    restrict: "EA"
    replace: true
    templateUrl: "directives.project"
    scope:
      item: "="
    link: (scope, element, attrs) ->
      scope.safe = () ->
        return $sce.trustAsHtml scope.item.post_content

]
