<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shipro Internacional</title>

    <!-- Bootstrap -->
    <link href="{{asset('gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('gentelella-master/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('gentelella-master/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{asset('gentelella-master/vendors/animate.css/animate.min.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('gentelella-master/build/css/custom.min.css')}}" rel="stylesheet">

    <link href="{{asset('css/style.css')}}" rel="stylesheet">
</head>

<body class="">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <div><a href="#" class="navbar-center"><img src="{{asset('img/logo.png')}}"></a></div><br>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <h1 class="white">Ingreso</h1>
                        <div>
                            <input id="username" type="username" class="form-control" placeholder="username" name="username" value="" required autofocus /> 
                            @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div>
                            <input id="password" name="password" type="password" class="form-control" placeholder="Password" required="" />                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span> @endif
                        </div>
                        <div>
                            {{-- <a class="btn btn-default submit" href="index.html">Log in</a> --}} <button type="submit"
                                class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            {{-- <a class="reset_pass" href="#">Lost your password?</a> --}}
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            {{-- <p class="change_link white">Nuevo usuario?
                                <a href="{{ route('register') }}" class="to_register white"> Crear cuenta </a>
                            </p> --}}

                            <div class="clearfix"></div>
                            <br />

                            <div>
                                <h1 class="white">Shipro Internacional</h1>
                                <p></p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>

</html>