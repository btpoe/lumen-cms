<html>
<head>
    <title>Lumen CMS</title>
    <script id="webplate-stack" src="/webplate/stack.js"></script>
</head>
<body style="display:none;"
      data-ui="stripe"
      data-icon-font="font-awesome"
      data-project-css="screen.css"
      data-project-js="app.js">
    <header>
        <a href="#" class="navigation-trigger">Show Navigation</a>
        <nav class="navigation">
            <ul>
                <li><a href="{{ route('settings-channels')}}">Channels</a></li>
                <li><a href="{{ route('settings-templates')}}">Templates</a></li>
                <li><a href="{{ route('settings-modules')}}">Modules</a></li>
                <li><a href="{{ route('settings-fields')}}">Fields</a></li>
                <li><a href="{{ route('settings-field-types')}}">Field Types</a></li>
            </ul>
        </nav>
    </header>
    @yield('content')
    <footer></footer>
</body>
</html>