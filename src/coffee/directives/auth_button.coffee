djh.directive "djhAuthBtn", ["GoogleApi", (GoogleApi) ->

  djhAuthBtn =
    restrict: "EA"
    templateUrl: "directives.auth_button"
    scope: { }
    link: (scope, element, attrs) ->

      success = (data) ->
        console.log data

      scope.launchAuth = ->
        GoogleApi.prompt().then success

]
