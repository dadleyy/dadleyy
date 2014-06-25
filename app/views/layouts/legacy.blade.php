<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Danny Hadley | {{ $title }}</title>
@include('globals.headinfo')

@include('globals.styles')
<script src="{{ asset('js/modernizr.js') }}"></script>
<script>
;(function( features ){ 
  if( !!features['canvas'] || !!features['csstransforms3d'] || !!features['csstransforms3d'] )
    return document.location = "/home";
})( window.Modernizr || { } );
</script>
    
</head>
<body>    

<div class="page">
  <div class="middle pw">
    <h1>Uh oh.</h1>
  </div>
</div>

</body>
</html>
