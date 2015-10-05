<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

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

        #error{
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        {!! Form::open(array('route' => 'sendReset', 'method' => 'POST')) !!}
        <h1>Password reset</h1>

        <!-- if there are login errors, show them here -->
        <p id="error">
            {{ (string)Session::get('message') }}
        </p>

        <p>
            {!! Form::text('email', Input::old('email'),['placeholder' => 'E-mail adres']) !!}
        </p>


        <p> {!! Form::submit('Reset link versturen') !!}</p>
        {!! Form::close() !!}

    </div>
</div>
</body>
</html>
