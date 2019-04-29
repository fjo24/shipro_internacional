
<html>
    <head>
        <title>Ha ocurrido un error</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href="{{asset('gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
        <style>
            html, body {
                height: 100%;
            }
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
                background-color: #2A3F54;
            }
            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }
            .content {
                text-align: center;
                display: inline-block;
            }
            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container center">
            <div class="content">
                    <div class="menu_section">
                            <div class="logo">
                              <a class="brand-logo" href="{{route('home')}}" id="logo-container">
                                  <img alt="" class="responsive-img" src="{{ asset('img/logo.png') }}"/>
                              </a>
                          </div>
                <div class="title">Ha ocurrido un error inesperado</div>
                <a href="{{ URL::previous() }}"><button class="btn info btn-info">Volver a la pagina anterior</button></a>
            </div>
        </div>
    </body>
</html>
