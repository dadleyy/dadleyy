djh.config ['$routeProvider', ($routeProvider) ->

  projectRoute =
    templateUrl: 'views.projects'
    controller: 'ProjectController'
    title: 'projects'
    resolve:
      projects: ['$http', '$q', 'URLS', ($http, $q, URLS) ->
        promise = $q.defer()
        blog_home = URLS.blog

        posts_url = [blog_home, 'posts'].join '/'
        projects_query = "filter[category_name]=project"

        finish = (response) ->
          projects = response.data
          promise.resolve projects

        fail = () ->

        blog_posts = $http.get [posts_url, projects_query].join('?')
        blog_posts.then finish, fail
        promise.promise
      ]

  $routeProvider.when '/projects', projectRoute

]
