<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Auth Zone</title>
</head>
<body>
<script type="text/javascript">
(function( global ) { 
  @if( !Input::get('error') )
  if( window.opener && window.opener.closed === false )
  	window.opener.diddelAuth({{ json_encode( Auth::user( )->decorate( ) ) }});
  @endif
  window.close( );
})( window );
</script>
</body>