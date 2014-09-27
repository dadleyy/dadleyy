djh.directive "djhCommentzone", ['$rootScope', ($rootScope) ->

  djhCommentzone =
    restrict: "EA"
    replace: true
    templateUrl: "directives.comment_zone"
    scope:
      item: "="
    link: (scope, element, attrs) ->

      updateAuth = (usr) ->
        scope.authorized = "true"  if usr and usr.id

      scope.authorized = false
      scope.isActiveUserComment = (user) ->
        user and user.plus_id is $rootScope.usr.plus_id

      scope.removeComment = (comment) ->
        comment.$delete().then ->
          i = 0
          while i < scope.item.comments.length
            scope.item.comments.splice i, 1  if scope.item.comments[i].comment_id is comment.comment_id
            i++

      $rootScope.$watch "usr", updateAuth

]
