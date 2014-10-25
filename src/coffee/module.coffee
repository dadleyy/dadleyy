djh = do () ->
  djh = angular.module 'djh', ['ngRoute', 'ngResource']

  loaded_config = (response) ->
    data = response.data
    djh.value 'URLS', data.urls
    djh.value 'GOOGLE', data.google
    angular.bootstrap document, ['djh']

  injector = angular.injector ['ng']
  http = injector.get '$http'
  http.get('/app.conf').then loaded_config
  djh
