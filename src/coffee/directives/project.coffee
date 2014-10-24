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
