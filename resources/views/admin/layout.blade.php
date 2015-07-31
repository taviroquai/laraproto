<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="icon" href="../../favicon.ico">

    <title>LaraProto</title>

    <!-- CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
    @section('style')
    @show
    <link href="{{ asset('assets/css/backoffice.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ url('/admin/dashboard') }}">{{ App\Brand::where('active', 1)->first()->name }}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar">
                <li><a href="{{ url('/admin/contents/list') }}">Content</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#">System <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/admin/pages/list') }}">Pages</a></li>
                        <li><a href="{{ url('/admin/users/list') }}">Users</a></li>
                        <li><a href="{{ url('/admin/roles/list') }}">Roles</a></li>
                        <li><a href="{{ url('/admin/permissions/list') }}">Permission</a></li>
                        <li><a href="{{ url('/admin/brands/list') }}">Site Brand</a></li>
                        <li><a href="{{ url('/admin/visits/list') }}">Visits</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a target="_blank" href="{{ url('/') }}">View Site</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#">{{ \Auth::user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('admin/profile') }}">Settings</a></li>
                        <li><a href="{{ url('auth/logout') }}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
      </div>
    </nav>

    <div class="container" id="mainContent">
      
        @if(Session::has('status'))
            <div class="alert alert-success">
                {{ Session::pull('status') }}
            </div>
        @endif
        
        @section('content')
        @show
        
        <div class="row">
            <div class="col-md-12 main">
                <hr>
                <p class="pull-right">&copy; LaraProto 2015 - {{ date('Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/knockout-3.3.0.debug.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    
    @section('script')
    @show
    
  </body>
</html>
