@extends('layouts.callbacks')

@section('scripts')
<script type="text/javascript">
djh.run(['$window', '$timeout', function($window, $timeout) {

  function close() {
    window.close();
  }

  if(!$window.opener || !$window.opener.auth)
    return close();

  $window.opener.auth("{{ $email }}");

  $timeout(close, 1000);

}]);
</script>
@endsection
