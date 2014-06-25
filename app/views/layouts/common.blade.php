<!DOCTYPE html>
<html ng-app="djh">
<head>
  <meta charset="utf-8">
  <title djh-title ng-bind="title">Danny Hadley</title>
  @include('globals.headinfo')
  @include('globals.styles')
</head>
<body>    
<section class="page" ng-cloak>
  <div class="track middle pw">
    <div class="scroll" djh-scroller>
      <section class="title" ng-controller="NavigationController">
    	  <span class="shadow" djh-scroll-fader></span>
        <div class="content">
          <div class="cf branding">
            <a href="http://twitter.com/dadleyy" class="f social b-grad" target="_blank">
              <img src="{{ asset('img/twitter.svg') }}" alt="" width="16px" height="16px">
            </a>
            <a href="http://github.com/dadleyy" class="f social b-grad" target="_blank">
              <img src="{{ asset('img/github.svg') }}" alt="" width="16px" height="16px">
            </a>
            <div class="oh f">
              <div class="socials t cf">
                <div class="google f">
                  <div class="g-plusone" data-annotation="bubble" data-size="medium"></div>
                </div>
                <div class="twitter f">
                  <a href="https://twitter.com/share" class="twitter-share-button" data-via="dadleyy" data-lang="en">tweet</a>
                </div>
              </div>
            	<h3 class="f-bold"><a href="/home">Danny Hadley</a></h3>
              <h5 class="up f-reg">software engineer</h5>
              <p class="t scroll-text" ng-hide="exclude == 'about' || exclude == 'whoops!'">scroll for {= itemKind =}</p>
            </div>
            <a href="mailto:danny@dadleyy.com" class="f social b-grad">
              <img src="{{ asset('img/email.svg') }}" alt="" width="16px" height="16px">
            </a>
            <a href="https://maps.google.com/?q=Boston" class="f social b-grad" target="_blank">
              <img src="{{ asset('img/pin.svg') }}" alt="" width="16px" height="16px">
            </a>
          </div>
          <div class="navigator cf">
            <ul>
              <li ng-hide="exclude == 'blog'" class="f"><a href="/blog" class="t f blog_link">blog</a></li>
              <li ng-hide="exclude == 'home'" class="f"><a href="/home" class="t f blog_link">home</a></li>
              <li ng-hide="exclude == 'about'" class="f"><a href="/about" class="t f blog_link">about</a></li>
            </ul>
          </div>
        </div>
      </section>
      <div class="view">
        <span class="shadow" djh-scroll-fader></span>
        <div djh-view-buffer class="lt"></div>
        <div djh-view-buffer class="lt"></div>
      </div>
    </div>
  </div>
</section>
<djh-csrf token="{{ Session::token( ) }}" @if( Auth::check( ) ) usr-token="{{ Auth::user( )->id }}" usr-image="{{ Auth::user( )->image_url }}" usr-display="{{ Auth::user( )->display_name }}" @endif>
@if( Auth::check( ) ){{ json_encode( Auth::user( )->decorate( ) ) }}@endif
</djh-csrf>
@include('globals.scripts')
</body>
</html>