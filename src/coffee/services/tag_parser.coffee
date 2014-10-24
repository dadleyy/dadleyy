djh.service 'TagParser', ['$q', '$filter', '$http', 'URLS', ($q, $filter, $http, URLS) ->

  video_tag_rgx = /vid:(\d+)/i
  url_tag_rgx = /url:(\w+)/i

  filter = $filter 'filter'
  media_url = [URLS.blog, 'media'].join '/'

  getTags = (post) ->
    (post.terms and post.terms.post_tag) or []

  videoFilter = (tag) ->
    video_tag_rgx.test tag.name

  urlFilter = (tag) ->
    url_tag_rgx.test tag.name

  tagValue = (tag) ->
    parts = tag.split ':'
    parts[1]

  TagParser =

    projectUrl: (post) ->
      deferred = $q.defer()
      post_tags = getTags post
      url_tags = filter post_tags, urlFilter

      if url_tags.length < 1
        deferred.reject
      else
        encoded_url = tagValue url_tags[0].name
        based = atob encoded_url
        deferred.resolve decodeURIComponent based

      deferred.promise

    videoUrl: (post) ->
      deferred = $q.defer()
      post_tags = getTags post
      video_tags = filter post_tags, videoFilter

      finish = (response) ->
        deferred.resolve response.data.source

      if video_tags.length < 1
        deferred.reject false
      else
        video_id = tagValue video_tags[0].name
        video_media_url = [media_url, video_id].join '/'
        load_promise = $http.get video_media_url
        load_promise.then finish, deferred.reject

      deferred.promise

]
