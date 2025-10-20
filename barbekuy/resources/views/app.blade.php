<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') | Admin Berbekuy</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

  <div class="container" style="display:flex; min-height:100vh;">
    {{-- Sidebar --}}
    @include('partials.sidebar')

    {{-- Main Content --}}
    <div class="main-content" style="flex:1; display:flex; flex-direction:column;">
      {{-- Topbar --}}
      <div class="topbar">
        <img src="{{ asset('images/notif.png') }}" alt="Notif">
        <div class="profile">
          <div class="avatar">A</div>
          Admin
        </div>
      </div>

      {{-- Page Content --}}
      <div class="content">
        @yield('content')
      </div>
    </div>
  </div>

</body>
</html>
