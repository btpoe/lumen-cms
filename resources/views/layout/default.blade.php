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
                <li><a href="{{ route('settings-templates')}}">Template Settings</a></li>
                <li><a href="{{ route('settings-modules')}}">Module Settings</a></li>
                <li><a href="{{ route('settings-fields')}}">Field Settings</a></li>
                <li><a href="{{ route('settings-field-types')}}">Field Type Settings</a></li>
                <li><a href="{{ route('singles')}}">Single Listing</a></li>
                <li><a href="{{ route('modules')}}">Module Listing</a></li>
            </ul>
        </nav>
    </header>
    @yield('content')
    <footer></footer>
</body>
</html>