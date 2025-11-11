@include('sweetalert::alert')

@if (isset($content))
    @include($content)
@endif
