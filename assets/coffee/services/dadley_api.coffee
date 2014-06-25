djh.factory "DadleyAPI", ["$resource", "$rootScope", ($resource, $rootScope) ->

  BlogPostDecorator = (response) ->

  Project = $resource "/api/projects/:project_id", {}

  BlogPost = $resource "/api/posts/:post_id", {},
    query:
      method: "GET"
      isArray: true
      interceptor:
        response: BlogPostDecorator

  Technology = $resource "/api/techs/:tech_id", {}

  Comment = $resource "/api/comments/:comment_id/:fn", {},
    delete:
      method: "POST"
      params:
        comment_id: "@comment_id"
        fn: "delete"

  DadleyAPI = 
    Project: Project
    BlogPost: BlogPost 
    Technology: Technology 
    Comment: Comment 

]

