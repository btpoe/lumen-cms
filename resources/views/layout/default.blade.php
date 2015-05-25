<html>
<head>
    <title>Lumen CMS</title>
    <link rel="stylesheet" href="/css/screen.css"/>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    Lumen CMS
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="sidebar col-md-3">
            <ul class="nav nav-stacked nav-pills">
                <li role="presentation"><a href="{{ route('settings-templates')}}">Template Settings</a></li>
                <li role="presentation"><a href="{{ route('settings-modules')}}">Module Settings</a></li>
                <li role="presentation"><a href="{{ route('settings-fields')}}">Field Settings</a></li>
                <li role="presentation"><a href="{{ route('settings-field-types')}}">Field Type Settings</a></li>
                <li role="presentation"><a href="{{ route('singles')}}">Single Listing</a></li>
                <li role="presentation"><a href="{{ route('modules')}}">Module Listing</a></li>
            </ul>
        </div>
        <div class="main col-md-9">
            @yield('content')
        </div>
    </div>

    <footer></footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="/js/bundle.js"></script>
</body>
</html>