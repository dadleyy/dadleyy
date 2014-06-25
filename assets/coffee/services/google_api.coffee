djh.service 'GoogleApi', ['$q', '$http', '$window', ($q, $http, $window) ->

  auth_url = null
  auth_promise = null

  getAuthUrl = () ->
    promise = $q.defer()

    if auth_url == null
      req = $http.get('/auth/google/url')

      req.success (data) ->
        auth_url = data.auth_url
        promise.resolve data.auth_url

      req.error (data) ->
        promise.reject data

    else
      promise.resolve auth_url

    promise.promise

  GoogleApi =

    finish: (user_info) ->
      auth_promise.resolve user_info
      delete $window.auth

    prompt: () ->
      auth_promise = $q.defer()

      getAuthUrl().then (url) ->
        _handle = $window.open url, 'login', 'width=800,height=600'
        $window.auth = GoogleApi.finish
        _handle != null

      auth_promise.promise

]
