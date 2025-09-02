<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>@yield('title', 'Domain Checker')</title>
  @vite('resources/js/app.js')
</head>
<body style="font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;">
  <div style="max-width: 960px; margin: 24px auto; padding: 0 16px;">
    <nav style="display:flex; gap:12px; margin-bottom:16px;">
      <a href="{{ route('domain') }}">Checker</a>
      <a href="{{ route('login') }}">Login</a>
      <a href="{{ route('register') }}">Register</a>
    </nav>

    @yield('content')
  </div>
</body>
</html>