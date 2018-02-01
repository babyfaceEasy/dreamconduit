<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

     
    <!-- Latest compiled and minified CSS -->
   
    <link href="{{asset('css/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="{{asset('css/freelancer.min.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{asset('css/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">


    <!-- Theme CSS -->
    <link href="{{asset('css/freelancer.min.css')}}" rel="stylesheet">



    <!-- Custom Fonts -->
    <link href="{{asset('css/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- jquery Data tables-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body   style="background-image: url({{asset('img/bg.jpg')}});background-size:cover;" >

    <div id="page-top" class="index">
        <!-- Navigation -->
        <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom" style="background: rgba(89, 70, 132, 0);">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span> Tools <i class="fa fa-bars"></i>
                    </button>
                    
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                         @if(Auth::guest() == false)                    
                        <li class="page-scroll">
                        <a style="font-size: 11px" href="{{ url('/candidate/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                        @endif
                        
                    </ul>
                    
                    <form id="logout-form" action="{{ url('/candidate/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                    </form>
                    
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
        <div class="col-lg-2"><!--<img src="{{asset('img/bg.jpg')}}">--></div>
        <div class="col-lg-8 col-lg-offset-5 col-md-offset-2 col-sm-12 col-xs-12" align="center" style="padding-top: 40px;"><a class="navbar-brand" href="#"><img src="{{asset('img/logo.png')}}" class="img-responsive" style="width: auto" /></a></div>
        <div class="col-lg-2"></div>


<br/><br/>
        @yield('content')
    </div>

        <!-- Footer -->
    <footer class="text-center navbar-fixed-bottom" >
        <div class="footer-below" style="background-color: #000; color: #fff;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4" style="padding-top:  10px; padding-left: 0px;">
                        Dream Mesh Ltd. &copy; Dream Mesh 2017 All right reserved.
                    </div>
                    <div class="col-lg-8">
                        <img src="{{asset('img/dream_logo.png')}}" class="pull-right" style="height: 80px;">
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- jquery data -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Datatables -->
    <script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>


    <!-- Falz code -->
    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="{{asset('js/jqBootstrapValidation.js')}}"></script>
    <script src="{{asset('js/contact_me.js')}}"></script>

    <!-- Theme JavaScript -->
    <script src="{{asset('js/freelancer.min.js')}}"></script>

    <!-- end of his code -->

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    @stack('scripts')
</body>
</html>
