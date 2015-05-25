<html>
<head>
    <title>Lumen CMS</title>
    <link rel="stylesheet" href="/css/screen.css"/>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    Lumen CMS
                </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-gear"></span> Settings</a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('settings-templates')}}">Templates</a></li>
                            <li><a href="{{ route('settings-modules')}}">Modules</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ route('settings-fields')}}">Fields</a></li>
                            <li><a href="{{ route('settings-field-types')}}">Field Types</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="sidebar col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation" class="{{ Request::is('singles') ? 'active' : '' }}"><a href="{{ route('singles')}}">Singles</a></li>
                <li class="nav-divider"></li>
                <li class="nav-header">Modules</li>
                @foreach($modules as $module)
                    <li role="presentation" class="{{ Request::is('modules/'.$module->handle.'*') ? 'active' : '' }}"><a href="{{ route('module-list', ['handle' => $module->handle]) }}">{{ $module->title }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="main col-md-9">
            @yield('content')
        </div>
    </div>

    <footer></footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/bundle.js"></script>
</body>
</html>