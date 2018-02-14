<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>
      @hasSection ('title')
          @yield('title') - {{env('APP_NAME')}}
      @else
          {{ env('APP_NAME') }}
      @endif
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link media="all" rel="stylesheet" href="{{$themeAssets}}/bootstrap.min.css" media="screen">
    <link media="all" rel="stylesheet" href="{{$assets}}/plugins/font-awesome/css/font-awesome.min.css">
    <link media="all" rel="stylesheet" href="{{$themeAssets}}/custom.min.css">
    <link media="all" rel="stylesheet" href="{{$assets}}/custom.css">

    @yield('custom-style')

  </head>
  <body>
    <div class="container">
      @yield('content')
    </div>

    <script src="{{$themeAssets}}/jquery.min.js"></script>
    <script src="{{$themeAssets}}/bootstrap.min.js"></script>
    
    <!-- Theme's Custom Script-->
    <script src="{{$themeAssets}}/custom.js"></script>

    <!-- Custom Script-->
    <script src="{{$assets}}/custom.js"></script>

    @yield('custom-script')

  </body>
</html>
