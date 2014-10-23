djh.directive 'dProject', ['$sce', ($sce) ->

  dProject =
    replace: true
    templateUrl: 'directives.project'
    scope:
      project: '='
    link: ($scope, $element, $attrs) ->
      $scope.content = () ->
        $sce.trustAsHtml $scope.project.content

]
