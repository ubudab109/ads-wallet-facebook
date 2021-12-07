@extends('layout.base')

@section('body')
    <body class="main">
        @include('sweetalert::alert')
        <div id="content">

            @yield('content')
        </div>
        @include('layout.components.dark-mode-switcher')
        
        <!-- BEGIN: JS Assets-->
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script>
        <script src="{{ mix('dist/js/app.js') }}"></script>
        <!-- END: JS Assets-->
        <script src="{{asset('js/tabulator.min.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
        {{-- <script>
            document.onreadystatechange = function () {
                var state = document.readyState
                if (state == 'interactive') {
                    document.getElementById('contents').style.visibility="hidden";
                } else if (state == 'complete') {
                    setTimeout(function(){
                        document.getElementById('interactive');
                        document.getElementById('load').style.visibility="hidden";
                        document.getElementById('contents').style.visibility="visible";
                    },1000);
                }
            }
        </script> --}}
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        @yield('script')
        
    </body>
@endsection