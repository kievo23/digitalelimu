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
    <link href="/css/jquery.dataTables.css" rel="stylesheet">
    <link href="/css/jodit.min.css" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    @yield('css')
    
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
            	@if (Auth::check())
                <div class="col-md-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Menu</div>
                        <div class="panel-body">
                            <a class="btn" href="{{ url('/category/index') }}">Main</a>
                            <a class="btn" href="{{ url('/class/index') }}">Classes</a>
                            <a class="btn" href="{{ url('/book/index') }}">Books</a>
                            <a class="btn" href="{{ url('/content/index') }}">Content</a>
                            <a class="btn" href="{{ url('/subscriptions/index') }}">Subscriptions</a>
                            <a class="btn" href="{{ url('/reports/index') }}">Reports</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    @yield('content')
                </div>
                @else
                	@yield('content')
                @endif
            </div>
        </div>
    </div>

    <!-- Scripts -->
    
    <script src="/js/app.js"></script>
    <script src="/js/jquery.dataTables.js"></script> 
    <script src="/js/jodit.min.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script> 
    <script src="/js/moment.min.js"></script>
    <script src="/js/daterangepicker.js"></script> 
    <script>
    //CKEDITOR.replace( 'details' ); 
    
    $(document).ready(function(){
        $('textarea').ckeditor({
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            toolbar :
                [
                    { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                    { name: 'editing', items: [ 'Scayt' ] },
                    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                    { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ] },
                    { name: 'tools', items: [ 'Maximize' ] },
                    { name: 'document', items: [ 'Source' ] },
                    { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'TextColor', 'BGColor','-', 'RemoveFormat','fontSize_sizes' ] },
                    { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
                    { name: 'styles', items: [ 'Styles', 'Format' ,'Font', 'FontSize'] }
                ]
          });

        
        });
        
        // $('.textarea').ckeditor(); // if class is prefered.
        @yield('js');
    </script>
</body>
</html>
