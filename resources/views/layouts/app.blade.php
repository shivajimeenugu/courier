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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<style>

    .optionhoverred:hover{
        color: red;
    }
    .optionhoverblue:hover{
        color: blue;
    }
    .greentick{
        color: green;
    }

    .redtick{
        color: red;
    }

</style>

</head>
<body>
    <div id="app">


        <nav class="navbar  navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button"  aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <i onclick="reloadall()" class="fa-solid fa-rotate"></i>
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
                url: "{{ config('app.apiurl') }}createbill?billname="+billname,
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
                url: "{{ config('app.apiurl') }}getcourier?billid="+id,
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
                url: "{{ config('app.apiurl') }}getbills",
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
                url: "{{ config('app.apiurl') }}addcourier?billid="+billid+"&awb="+awb,
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
                document.getElementById('courierIdEntered').value="";
                loadCourierData(billid);
                }
            });

            loadCourierData(billid);
        }

        function deletebill(id)
        {
            $.ajax({
                type: 'GET',
                url: "{{ config('app.apiurl') }}deletebill?billid="+id,
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
            loadBillData();
            loadCourierData(null);
        }

        function exportbill(id)
        {
            // $.ajax({
            //     type: 'GET',
            //     url: "/api/export?billid="+id,
            //     success:function(data){
            //         console.log(data["data"]);
            //     // $('#billsselect').html(data["data"]);
            //      console.log(data["message"]);

            //      Toastify({
            //         text: data["message"],
            //         className: "info",
            //         style: {
            //             background: "linear-gradient(to right, #00b09b, #96c93d)",
            //         }
            //     }).showToast();

            //     }
            // });

            var w=window.open("{{ config('app.apiurl') }}export?billid="+id, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=1000,width=50,height=50");

            loadBillData();
            loadCourierData(null);
        }


        function getcourierstatus(cid)
        {
            if(cid.length>=6)
            {
            $.ajax({
                type: 'GET',
                url: "{{ config('app.apiurl') }}isCourierExists?cid="+cid,
                success:function(data){
                if(data["data"])
                {
                    $('#couriersts').removeClass().addClass('fa-solid fa-circle-xmark redtick');
                }
                else{
                    $('#couriersts').removeClass().addClass('fa-solid fa-circle-check greentick');
                }

                 console.log(data["message"]);
                }
            });
            }
        }

        $(document).ready(function(){

            // $("#getcourierdata").click(function(){
            // $.ajax({
            //     type: 'GET',
            //     url: "/api/getcourier?billid=1",
            //     success:function(data){
            //     $('#courierdatatable').html(data["data"]);
            //      console.log(data["message"]);
            //     }
            // });
            loadBillData();
            loadCourierData(null);

        return false;
        });


        function reloadall()
        {
            loadBillData();
            loadCourierData(null);
        }


    //   google.charts.load('current', {'packages':['table']});
    //   google.charts.setOnLoadCallback(drawTable);

    //   function drawTable() {
    //     var data = new google.visualization.DataTable();
    //     data.addColumn('number', 'SI.NO');
    //     data.addColumn('string', 'ID');
    //     data.addColumn('string', 'Date');
    //     data.addColumn('number', 'Amount');
    //     data.addColumn('string', 'From');
    //     data.addColumn('string', 'To');
    //     data.addRows([
    //       [1,  "521234", "02-06-2000",100,"Vizag","Vijayawada"],
    //       [2,  "521234", "02-06-2000",69,"Tiruvuru","Vijayawada"],
    //       [3,  "521234", "02-06-2000",50,"Kuppam","Vijayawada"]
    //     ]);

    //     var table = new google.visualization.Table(document.getElementById('table_div'));

    //     table.draw(data, {showRowNumber: false, width: '100%', height: '100%'});
    //   }
    </script>

</body>
</html>
