<!DOCTYPE html>
<html>
    <head>
        <title>MauMau Online</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
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
                font-weight:normal;
                font-size:96px;
                margin:0 0 15px 0;
            }

            .play {
                font-weight:normal;
                font-size:20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1 class="title">Bem-vindo ao maumau</h1>
                <p class="play">Clique <a href="{{ route('jogar') }}">aqui</a> para jogar</p>
            </div>
        </div>
    </body>
</html>
