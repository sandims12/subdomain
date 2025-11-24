@include('sweetalert::alert')

@if (isset($content))
    {{-- Jika controller mengirim nama view ke variabel $content --}}
    @include($content)
@else
    {{-- Jika view langsung pakai @section('content') --}}
    @yield('content')
@endif
