<!-- head info -->
<meta name="description" content="{{ isset($description) ? $description : Lang::get('global.description') }}">
<meta name="keywords" content="{{ isset($keywords) ? $keywords : Lang::get('global.keywords') }}">
<link rel="icon" href="{{ asset('img/logo.ico') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('img/logo.ico') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('img/logo-medium.png') }}" type="image/png">
<meta property="og:image" content="{{ asset('img/logo-large.png') }}"> 
<meta property="og:title" content="Danny Hadley">
<meta property="og:description" content="{{ isset($description) ? $description : Lang::get('global.description') }}">
<meta property="og:site_name" content="diddel.me">
<meta property="og:url" content="http://diddel.me/home">
<meta name = "viewport" content = "initial-scale = 1.0, user-scalable = no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="apple-touch-icon" href="{{ asset('img/logo-small.png') }}" />
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/logo-medium.png') }}" />
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/logo-large.png') }}" />
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/logo-big.png') }}" />