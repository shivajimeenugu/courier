<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="{{ asset('js/toastify.js') }}" defer></script>
    <link href="{{ asset('js/toastify.css') }}" rel="stylesheet">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>
<body>
    <div id="app">


        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script type="text/javascript">


        function loadCourierData(id)
        {
            if(id=="New")
            {
              var billname = prompt("Please Enter New Bill Name");
              if(billname!="" && billname!=null)
              {
                $.ajax({
                type: 'GET',
                url: "http://127.0.0.1:8000/api/createbill?billname="+billname,
                success:function(data){
                // $('#courierdatatable').html(data["data"]);
                 console.log(data["message"]);
                }
            });
                // $('#billsselect').value=data["data"];
                loadBillData();

              }

            }
            else{
            $.ajax({
                type: 'GET',
                url: "http://127.0.0.1:8000/api/getcourier?billid="+id,
                success:function(data){
                    $('#billtitle').html(data["message"]);
                $('#courierdatatable').html(data["data"]);
                 console.log(data["message"]);
                }
            });
        }
        }

        function loadBillData()
        {
            $.ajax({
                type: 'GET',
                url: "http://127.0.0.1:8000/api/getbills",
                success:function(data){

                $('#billsselect').html(data["data"]);
                 console.log(data["message"]);
                }
            });
        }


        function addcourier(billid,awb)
        {
            // alert(billid+"---"+awb)
            $.ajax({
                type: 'GET',
                url: "http://127.0.0.1:8000/api/addcourier?billid="+billid+"&awb="+awb,
                success:function(data){

                // $('#billsselect').html(data["data"]);
                 console.log(data["message"]);

                 Toastify({
                    text: data["message"],
                    className: "info",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    }
                }).showToast();

                }
            });
            loadCourierData(billid);
        }


        $(document).ready(function(){

            // $("#getcourierdata").click(function(){
            // $.ajax({
            //     type: 'GET',
            //     url: "http://127.0.0.1:8000/api/getcourier?billid=1",
            //     success:function(data){
            //     $('#courierdatatable').html(data["data"]);
            //      console.log(data["message"]);
            //     }
            // });

            loadCourierData(null);
            loadBillData();
        return false;
        });

    </script>

</body>
</html>
