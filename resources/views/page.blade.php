<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> @yield('title') </title>
        <style type="text/css">
        @section('style')
            body {
                background-color: gray;
            }
            .container {
                width: 80%;
                margin: 0 auto;
                background-color: white;
            }
        @show
        </style>
    </head>
    <body>
        <div class="container">
          @yield('content')
        </div>
    </body>
</html>
