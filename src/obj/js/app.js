var djh;

djh = angular.module('djh', ['ngRoute', 'ngResource']);

djh.config([
  '$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('{=');
    return $interpolateProvider.endSymbol('=}');
  }
]);

djh.config([
  '$locationProvider', function($locationProvider) {
    return $locationProvider.html5Mode(true);
  }
]);

djh.controller("AboutController", [
  "$scope", "$rootScope", "DadleyAPI", function($scope, $rootScope, DadleyAPI) {
    var finish, updateItems;
    finish = function() {
      return $rootScope.$broadcast("viewReady");
    };
    updateItems = function() {
      return $scope.techs = DadleyAPI.Technology.query(null, finish);
    };
    $scope.techs = [];
    return updateItems();
  }
]);

djh.controller("BlogController", [
  "$scope", "$route", "$rootScope", "DadleyAPI", function($scope, $route, $rootScope, DadleyAPI) {
    var ready, single_post, socialRefresh, updateItems;
    socialRefresh = function() {
      var refresh;
      refresh = function() {
        window.twttr.widgets.load();
        return window.FB.XFBML.parse();
      };
      return setTimeout(refresh, 600);
    };
    ready = function() {
      if (single_post !== false) {
        $scope.posts.push(single_post);
      }
      $rootScope.$broadcast("viewReady");
      return socialRefresh();
    };
    updateItems = function() {
      var currentRoute, postId, routeParams;
      currentRoute = $route.current;
      routeParams = currentRoute && currentRoute.params;
      postId = routeParams && parseInt(routeParams.post_id, 10);
      return $scope.posts = DadleyAPI.BlogPost.query(null, ready);
    };
    $scope.posts = [];
    single_post = false;
    return updateItems();
  }
]);

djh.controller("HomeController", [
  "$scope", "$rootScope", "DadleyAPI", function($scope, $rootScope, DadleyAPI) {
    var loaded, updateItems;
    loaded = function() {
      return $rootScope.$broadcast("viewReady");
    };
    updateItems = function() {
      return $scope.items = DadleyAPI.Project.query(null, loaded);
    };
    $scope.items = [];
    return updateItems();
  }
]);

djh.controller('NavigationController', [
  '$scope', '$route', function($scope, $route) {
    var updateScope;
    $scope.exclude = 'home';
    updateScope = function() {
      var currentRoute, routeItemKind, routeLocals, routeTitle;
      currentRoute = $route.current;
      routeLocals = currentRoute.locals;
      routeTitle = routeLocals.title;
      routeItemKind = routeLocals.itemKind;
      $scope.exclude = routeTitle;
      return $scope.itemKind = routeItemKind;
    };
    return $scope.$on('$routeChangeSuccess', updateScope);
  }
]);

djh.directive("djhAuthBtn", [
  "GoogleApi", function(GoogleApi) {
    var djhAuthBtn;
    return djhAuthBtn = {
      restrict: "EA",
      templateUrl: "directives.auth_button",
      scope: {},
      link: function(scope, element, attrs) {
        var success;
        success = function(data) {
          return console.log(data);
        };
        return scope.launchAuth = function() {
          return GoogleApi.prompt().then(success);
        };
      }
    };
  }
]);

djh.directive("djhBlogpost", [
  "$sce", function($sce) {
    var djhBlogpost;
    return djhBlogpost = {
      restrict: "EA",
      replace: true,
      templateUrl: "directives.blog_post",
      scope: {
        item: "="
      },
      link: function(scope, element, attrs) {
        return scope.safe = function() {
          return $sce.trustAsHtml(scope.item.post_content);
        };
      }
    };
  }
]);

djh.directive("djhCommentForm", [
  "$rootScope", "DadleyAPI", function($rootScope, DadleyAPI) {
    var djhCommentForm;
    return djhCommentForm = {
      restrict: "E",
      replace: true,
      templateUrl: "/templates/commentForm.html",
      scope: {
        item: "="
      },
      link: function(scope, element, attrs) {
        var err, send, validate, waitTO, waitTick;
        waitTick = function() {
          scope.wait--;
          if (scope.wait < 0) {
            clearInterval(waitTO);
            scope.wait = 0;
            scope.$digest();
          }
        };
        validate = function() {
          return angular.isString(scope.comment) && scope.comment.length > 1;
        };
        send = function() {
          var comment, waitTO;
          if (scope.wait > 0) {
            return err("wait a little longer");
          }
          comment = new DadleyAPI.Comment({
            comment: scope.comment,
            post_id: scope.item.post_id
          });
          comment.$save().then(function() {
            comment.user = $rootScope.usr;
          });
          scope.item.comments.push(comment);
          scope.wait = 4;
          return waitTO = setInterval(waitTick, 1000);
        };
        err = function(msg) {
          scope.comment = msg;
        };
        waitTO = null;
        scope.comment = "";
        scope.wait = 0;
        return scope.send = function() {
          if (validate()) {
            return send();
          } else {
            return err();
          }
        };
      }
    };
  }
]);

djh.directive("djhCommentzone", [
  '$rootScope', function($rootScope) {
    var djhCommentzone;
    return djhCommentzone = {
      restrict: "EA",
      replace: true,
      templateUrl: "directives.comment_zone",
      scope: {
        item: "="
      },
      link: function(scope, element, attrs) {
        var updateAuth;
        updateAuth = function(usr) {
          if (usr && usr.id) {
            return scope.authorized = "true";
          }
        };
        scope.authorized = false;
        scope.isActiveUserComment = function(user) {
          return user && user.plus_id === $rootScope.usr.plus_id;
        };
        scope.removeComment = function(comment) {
          return comment.$delete().then(function() {
            var i, _results;
            i = 0;
            _results = [];
            while (i < scope.item.comments.length) {
              if (scope.item.comments[i].comment_id === comment.comment_id) {
                scope.item.comments.splice(i, 1);
              }
              _results.push(i++);
            }
            return _results;
          });
        };
        return $rootScope.$watch("usr", updateAuth);
      }
    };
  }
]);

djh.directive("djhCsrf", [
  "$http", "$rootScope", function($http, $rootScope) {
    var djhCsrf;
    return djhCsrf = {
      restrict: "EA",
      priority: 200,
      terminal: true,
      link: function(scope, element, attrs) {
        var csrf_token;
        csrf_token = attrs["token"];
        return $http.defaults.headers.common["X-CSRF"] = csrf_token;
      }
    };
  }
]);

djh.directive("djhProject", [
  '$sce', function($sce) {
    var djhProject;
    return djhProject = {
      restrict: "EA",
      replace: true,
      templateUrl: "directives.project",
      scope: {
        item: "="
      },
      link: function(scope, element, attrs) {
        return scope.safe = function() {
          return $sce.trustAsHtml(scope.item.post_content);
        };
      }
    };
  }
]);

djh.directive("djhRepeater", [
  function() {
    var djhRepeater;
    return djhRepeater = {
      restrict: "EA",
      scope: {
        items: "="
      },
      templateUrl: "directives.repeater",
      link: function(scope, element, attrs) {
        return scope.template = attrs["itemTemplate"];
      }
    };
  }
]);

djh.directive("djhScrollFader", [
  function() {
    var calcOpacity, djhScrollFader;
    calcOpacity = function(top) {
      return 0.0 + (top / 300);
    };
    return djhScrollFader = {
      restrict: "A",
      link: function(scope, ele, attrs) {
        var update;
        update = function(evt, top) {
          var opacity;
          opacity = calcOpacity(top);
          ele.css({
            opacity: opacity
          });
        };
        return scope.$on("scroll", update);
      }
    };
  }
]);

djh.directive("djhScroller", [
  "$rootScope", "DiddelViewManager", function($rootScope, DiddelViewManager) {
    var djhScroller;
    return djhScroller = {
      restrict: "A",
      scope: true,
      link: function(scope, ele, attrs) {
        var scroll;
        scroll = function(evt) {
          var top;
          top = ele[0].scrollTop;
          if (top > 310) {
            ele.addClass("locked");
          } else {
            ele.removeClass("locked");
          }
          return $rootScope.$broadcast("scroll", top);
        };
        ele.bind("scroll", scroll);
        scope.$on("$routeChangeSuccess", scroll);
        return DiddelViewManager.registerSwapFn(scroll);
      }
    };
  }
]);

djh.directive("djhTitle", [
  "$route", function($route) {
    var defaultTitle, djhTitle, titleBase, titleDelimeteter;
    titleBase = "Danny Hadley";
    titleDelimeteter = " | ";
    defaultTitle = "software engineer";
    return djhTitle = {
      restrict: "A",
      link: function(scope, ele) {
        var updateTitle;
        updateTitle = function() {
          var currentRoute, currentTitle, routeLocals;
          currentRoute = $route.current;
          routeLocals = currentRoute.locals;
          currentTitle = routeLocals.title || defaultTitle;
          return scope.title = [titleBase, currentTitle].join(titleDelimeteter);
        };
        scope.$on("$routeChangeSuccess", updateTitle);
        return scope.$on("titleChange", updateTitle);
      }
    };
  }
]);

djh.directive("djhViewBuffer", [
  "$route", "$compile", "$controller", "DiddelViewManager", function($route, $compile, $controller, DiddelViewManager) {
    var checkReady, djhViewBuffer, initializeEngine, swapBuffers, updateBuffers, _buffers, _container, _firstCall, _initialized, _lastScope, _ready, _scope;
    _buffers = [];
    _container = null;
    _initialized = false;
    _scope = null;
    _ready = false;
    _firstCall = true;
    _lastScope = null;
    checkReady = function() {
      return _buffers.length >= 2;
    };
    initializeEngine = function(scope) {
      scope.$on("$routeChangeSuccess", updateBuffers);
      _scope = scope;
      _initialized = true;
      _container = _buffers[0].parent();
      return DiddelViewManager.registerSwapFn(swapBuffers);
    };
    swapBuffers = function() {
      var backBuffer, clear_front, frontBuffer;
      frontBuffer = _buffers[0];
      backBuffer = _buffers[1];
      frontBuffer.addClass("back").removeClass("front").css("position", "absolute");
      backBuffer.addClass("front").removeClass("back").css("position", "relative");
      clear_front = function() {
        return frontBuffer.html("");
      };
      setTimeout(clear_front, 600);
      return _buffers.reverse();
    };
    updateBuffers = function() {
      var backBuffer, controller, currentRoute, linkerFn, routeLocals, routeTemplate, templateEle, templateWrap;
      if (!_ready) {
        return false;
      }
      currentRoute = $route.current;
      routeLocals = currentRoute && currentRoute.locals;
      routeTemplate = routeLocals && routeLocals.$template;
      templateWrap = angular.element("<div></div>");
      templateEle = void 0;
      linkerFn = void 0;
      controller = void 0;
      backBuffer = _buffers[1];
      if (!routeTemplate) {
        return false;
      }
      if (_lastScope) {
        _lastScope.$destroy();
        _lastScope = null;
      }
      templateEle = templateWrap.html(routeTemplate).contents();
      backBuffer.html("").append(templateEle);
      linkerFn = $compile(templateEle);
      _lastScope = currentRoute.scope = _scope.$new();
      if (currentRoute.controller) {
        routeLocals.$scope = _lastScope;
        controller = $controller(currentRoute.controller, routeLocals);
        if (currentRoute.controllerAs) {
          _lastScope[currentRoute.controllerAs] = controller;
        }
        backBuffer.children().data("$ngControllerController", controller);
      }
      return linkerFn(_lastScope);
    };
    return djhViewBuffer = {
      restrict: "A",
      terminal: true,
      link: function(scope, element, attr) {
        var bufferName;
        bufferName = attr["djhViewBuffer"];
        _buffers.push(element);
        if (!_initialized) {
          initializeEngine(scope);
        }
        return _ready = checkReady();
      }
    };
  }
]);

djh.config([
  '$routeProvider', function($routeProvider) {
    var aboutRoute;
    aboutRoute = {
      controller: "AboutController",
      templateUrl: "views.about",
      resolve: {
        title: function() {
          return "about";
        }
      }
    };
    return $routeProvider.when('/about', aboutRoute);
  }
]);

djh.config([
  '$routeProvider', function($routeProvider) {
    var blogRoute;
    blogRoute = {
      controller: "BlogController",
      templateUrl: "views.blog",
      resolve: {
        title: function() {
          return "blog";
        },
        itemKind: function() {
          return "posts";
        }
      }
    };
    return $routeProvider.when('/blog', blogRoute);
  }
]);

djh.config([
  '$routeProvider', function($routeProvider) {
    var homeRoute;
    homeRoute = {
      templateUrl: 'views.home',
      controller: 'HomeController',
      resolve: {
        title: function() {
          return "home";
        },
        itemKind: function() {
          return "projects";
        }
      }
    };
    return $routeProvider.when('/home', homeRoute);
  }
]);

djh.factory("DadleyAPI", [
  "$resource", "$rootScope", function($resource, $rootScope) {
    var BlogPost, BlogPostDecorator, Comment, DadleyAPI, Project, Technology;
    BlogPostDecorator = function(response) {};
    Project = $resource("/api/projects/:project_id", {});
    BlogPost = $resource("/api/posts/:post_id", {}, {
      query: {
        method: "GET",
        isArray: true,
        interceptor: {
          response: BlogPostDecorator
        }
      }
    });
    Technology = $resource("/api/techs/:tech_id", {});
    Comment = $resource("/api/comments/:comment_id/:fn", {}, {
      "delete": {
        method: "POST",
        params: {
          comment_id: "@comment_id",
          fn: "delete"
        }
      }
    });
    return DadleyAPI = {
      Project: Project,
      BlogPost: BlogPost,
      Technology: Technology,
      Comment: Comment
    };
  }
]);

djh.service('GoogleApi', [
  '$q', '$http', '$window', function($q, $http, $window) {
    var GoogleApi, auth_promise, auth_url, getAuthUrl;
    auth_url = null;
    auth_promise = null;
    getAuthUrl = function() {
      var promise, req;
      promise = $q.defer();
      if (auth_url === null) {
        req = $http.get('/auth/google/url');
        req.success(function(data) {
          auth_url = data.auth_url;
          return promise.resolve(data.auth_url);
        });
        req.error(function(data) {
          return promise.reject(data);
        });
      } else {
        promise.resolve(auth_url);
      }
      return promise.promise;
    };
    return GoogleApi = {
      finish: function(user_info) {
        auth_promise.resolve(user_info);
        return delete $window.auth;
      },
      prompt: function() {
        auth_promise = $q.defer();
        getAuthUrl().then(function(url) {
          var _handle;
          _handle = $window.open(url, 'login', 'width=800,height=600');
          $window.auth = GoogleApi.finish;
          return _handle !== null;
        });
        return auth_promise.promise;
      }
    };
  }
]);

djh.factory("DiddelViewManager", [
  "$rootScope", function($rootScope) {
    var ViewManager, triggerSwaps, _swapFns;
    triggerSwaps = function() {
      var i, _results;
      i = 0;
      _results = [];
      while (i < _swapFns.length) {
        _swapFns[i]();
        _results.push(i++);
      }
      return _results;
    };
    _swapFns = [];
    $rootScope.$on("viewReady", triggerSwaps);
    return ViewManager = {
      registerSwapFn: function(fn) {
        if (angular.isFunction(fn)) {
          return _swapFns.push(fn);
        }
      }
    };
  }
]);
