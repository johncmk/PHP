<!DOCTYPE html>
<html lang="en">

<head>

    <!-- The Purpose of using '{{ asset('/exam/ple') }} -->
    <!-- Because you're expected to use php artisan serve or Homestead for development, 
        and a proper server config in production. public should never be in 
        your URLs (if it is, your app is potentially vulnerable to compromise) 
        and Laravel is typically run at the root of a domain name, 
        so /css/app.css is a perfectly fine default for sensible setups. – -->
   
    <!-- DataTables CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.css') }}"> -->
   
     <!-- JQuery -->
    <script type="text/javascript" charset="utf-8" src="{{ asset('js/jquery-1.11.3.js') }}"></script>

     <!-- DataTables -->
    <!--script type="text/javascript" charset="utf-8" src="{{ asset('js/jquery.min.js') }}"></script> 
    <script type="text/javascript" charset="utf-8" src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('js/jquery.dataTables.min.js') }}"></script-->

    <script type="text/javascript" charset="utf-8" src="{{ asset('js/jquery.bpopup.js') }}"></script>

    <!-- JQueryUI  -->
    <!--link rel="stylesheet" href="css/jquery-ui.min.css">
    <script src="js/jquery-ui.min.js"></script-->
    <!-- JQueryUI  -->
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <script src="{{ asset('js/jquery-ui.js') }}"></script>

    <!-- End  -->

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- Custom Theme JavaScript -->
    <!-- script src="{{ asset('js/clean-blog.min.js') }}"></script-->

    <!-- tinyMCE CDN -->
    <script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>

    <!-- CSRF -->
    <!--script type="text/javascript">
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
    </script-->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF  -->
    <meta name="_token" content="{!! csrf_token() !!}"/>

    <title>Clean Blog</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/clean-blog.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom_style.css') }}" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
        function init_progress() {
            $('body').append("<div id='div_processing' style='display:none'>Processing... <img src='/images/ajax-loader.gif'/></div>");

            $('#div_processing').dialog({
                width: 300,
                height: 200,
                modal: true,
                autoOpen: false,
                zindex: 99999999
            })
        }

        function show_progress() {
            $('#div_processing').dialog("open");
        }

        function hide_progress() {
            $('#div_processing').dialog("close");
        }
    </script>


</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll" style="background-color:#FFFFFF">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">My Blog</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li>
                        <a href="/about">About</a>
                    </li>
                    <li>
                        <a href="/post">Post</a>
                    </li>
                    <!-- <li>
                        <a href="/contact">Contact</a>
                    </li> -->
                    @if(auth()->guest())
                        @if(!Request::is('auth/login'))
                            <li><a href="/auth/login">Login</a></li>
                        @endif
                        <!-- @if(!Request::is('auth/register'))
                            <li><a href="/auth/register">Register</a></li>
                        @endif -->
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ auth()->user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/auth/logout">Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

	@yield('content')
</body>
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <ul class="list-inline text-center">
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <p class="copyright text-muted">Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>