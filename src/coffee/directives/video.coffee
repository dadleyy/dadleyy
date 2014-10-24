djh.directive 'dVideo', ['Loop', (Loop) ->

  create = (tag_name) ->
    document.createElement tag_name

  dVideo =
    replace: true
    templateUrl: 'directives.video'
    scope:
      src: '='
    link: ($scope, $element, $attrs) ->
      element = $element[0]
      loop_id = null

      video_el = create 'video'
      video_url = $scope.src

      canvas_el = create 'canvas'
      context = canvas_el.getContext '2d'

      update = () ->
        width = element.offsetWidth
        height = element.offsetHeight

        canvas_el.width = width
        canvas_el.height = height

        context.drawImage video_el, 0, 0, width, height

        if !loop_id
          loop_id = Loop.add update

      start = () ->
        video_el.play()

      stop = () ->
        video_el.stop()

      video_el.src = video_url
      video_el.addEventListener 'play', update
      video_el.addEventListener 'ended', start
      start()

      $element.append canvas_el
      $scope.$on 'video_stop', stop
      $scope.$on 'video_start', start

]
