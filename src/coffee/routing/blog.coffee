djh.config ['$routeProvider', ($routeProvider) ->

  blogRoute =
    templateUrl: 'views.blog'
    controller: 'BlogController'
    title: 'thoughts'
    resolve:
      posts: ['$http', '$q', 'URLS', ($http, $q, URLS) ->
        promise = $q.defer()
        blog_home = URLS.blog

        posts_url = [blog_home, 'posts'].join '/'
        projects_query = "filter[category_name]=blogpost"

        finish = (response) ->
          projects = response.data
          promise.resolve projects

        fail = () ->

        blog_posts = $http.get [posts_url, projects_query].join('?')
        blog_posts.then finish, fail
        promise.promise
      ]

  $routeProvider.when '/blog', blogRoute

]
