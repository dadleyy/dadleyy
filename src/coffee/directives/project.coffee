djh.directive 'dProject', ['$sce', 'TagParser', ($sce, TagParser) ->

  dProject =
    replace: true
    templateUrl: 'directives.project'
    scope:
      project: '='
    link: ($scope, $element, $attrs) ->
      $scope.video_url = false
      $scope.project_url = false

      $scope.content = () ->
        $sce.trustAsHtml $scope.project.content

      $scope.toggle = () ->
        $scope.open = !$scope.open
        if $scope.open
          $scope.$broadcast 'video_stop'
        else
          $scope.$broadcast 'video_start'

      do () =>
        update = (video_url) ->
          $scope.video_url = video_url

        promise = TagParser.videoUrl $scope.project
        promise.then update

      do () =>
        update = (project_url) ->
          $scope.project_url = project_url

        promise = TagParser.projectUrl $scope.project
        promise.then update

]
