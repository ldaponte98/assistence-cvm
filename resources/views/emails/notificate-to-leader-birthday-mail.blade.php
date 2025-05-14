<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notificacion</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>
    <center>
        <img src="{{asset('images/logo.png')}}" alt="cvm">
        <h2>Hoy esta de cumpleaños</h2>
        <h1><b>{{ $data->peopleName }}</b></h1>
        <p><b>Por favor en lo posible llamalo o comunicate con el para felicitarlo, es nuestro deber como hermanos en cristo</b></p>
        <span>Bendiciones</span>
    </center>
</body>
</html>