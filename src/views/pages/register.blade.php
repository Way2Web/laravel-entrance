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

        .title {
            font-size: 96px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        {!! Form::open(array('route' => 'postRegister', 'method' => 'POST')) !!}
            <h1>Register</h1>
            <!-- if there are login errors, show them here -->
            <p id="error">
                {{ (string)Session::get('message') }}
                @if($errors->count())
                    <ul class="alert alert-danger">
                        <h4><strong>Whoops!</strong> There were some problems with your input.</h4>
                        <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </ul>
                @endif
            </p>
            <p>
                {!! Form::text('email', Input::old('email'),['placeholder' => 'E-mail adres']) !!}<br>
                {!! Form::password('password', ['placeholder' => 'Password']) !!}<br>
                {!! Form::password('password_confirmation', ['placeholder' => 'Confirm Password']) !!}
            </p>
            <p> {!! Form::submit('Submit!') !!}</p>
        {!! Form::close() !!}
    </div>
</div>
</body>
</html>
