djh.directive "djhBlogpost", ["$sce", ($sce) ->
  
  djhBlogpost = 
    restrict: "EA"
    replace: true
    templateUrl: "directives.blog_post"
    scope:
      item: "="
    link: (scope, element, attrs) ->
      scope.safe = () ->
        $sce.trustAsHtml scope.item.post_content


]
