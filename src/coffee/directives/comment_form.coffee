djh.directive "djhCommentForm", ["$rootScope", "DadleyAPI", ($rootScope, DadleyAPI) ->

  djhCommentForm = 
    restrict: "E"
    replace: true
    templateUrl: "/templates/commentForm.html"
    scope:
      item: "="
    link: (scope, element, attrs) ->
      waitTick = ->
        scope.wait--
        if scope.wait < 0
          clearInterval waitTO
          scope.wait = 0
          scope.$digest()
        return

      validate = ->
        angular.isString(scope.comment) and scope.comment.length > 1

      send = ->
        return err("wait a little longer")  if scope.wait > 0
        comment = new DadleyAPI.Comment(
          comment: scope.comment
          post_id: scope.item.post_id
        )
        comment.$save().then ->
          comment.user = $rootScope.usr
          return

        scope.item.comments.push comment
        scope.wait = 4
        waitTO = setInterval(waitTick, 1000)

      err = (msg) ->
        scope.comment = msg
        return

      waitTO = null
      scope.comment = ""
      scope.wait = 0

      scope.send = ->
        if validate()
          send()
        else
          err()
]


