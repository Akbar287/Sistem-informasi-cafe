<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kedai Akbar</title>
        <style>
            body {
                overflow-x: hidden;
            }
            .col {
                margin-top: -50px;
            }
            @keyframes bgColor {
                0% {background-color: red;}
                20% {background-color: aqua;}
                40% {background-color: blue;}
                60% {background-color: green;}
                80% {background-color: teal;}
                100% {background-color: brown;}
            }
            .jumbotron {
                animation-name: bgColor;
                animation-iteration-count: infinite;
                animation-direction: alternate-reverse;
                animation-duration: 10s;
            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </head>
    <body>
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">{{ config('app.name', 'Laravel') }}</h1>
                <p class="lead">Sistem Informasi Cafe untuk Admin dan Kasir.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-10 col-sm-10 col-md-6 col-lg-4 text-center col">
                <div class="card">
                    <div class="card-body">
                        @if (Route::has('login'))
                        <div class="top-right links">
                            @auth
                                <a href="{{ url('/home') }}" type="button" class="btn btn-block btn-outline-primary ">Home</a>
                            @else
                                <a href="{{ route('login') }}" type="button" class="btn btn-block btn-outline-primary">Login</a>
                            @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center mt-3 mading"></div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script>
            for(let i=0; i < 3; i++) {
                $('.mading').append('<div class="col-sm-10 col-md-6 col-lg-4 mt-2 mb-2"><div class="card"><div class="card-body"><h5 class="card-title">Pengumuman</h5><p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto pariatur ullam ipsum dicta esse delectus enim atque quasi non aliquid.</p></div></div></div>');
            }
        </script>
    </body>
</html>
