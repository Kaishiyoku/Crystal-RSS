<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!--[if mso]>
    <style>
        * {
            font-family: sans-serif !important;
        }
    </style>
    <![endif]-->

    <!--[if !mso]><!-->
    <link href='https://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <!--<![endif]-->

    <style type="text/css">
        html, body {
            font-family: 'Lato', sans-serif;
        }

        .footer {
            font-size: 9pt;
            padding-top: 20px;
            margin-top: 30px;
            text-align: center;
        }
    </style>

</head>
<body>
<h1>@yield('title')</h1>

<div>
    @yield('content')
</div>

<hr/>

<div class="footer">
    {{ getYearsFrom(2017) }},

    {{ config('app.author') }},

    v{{ config('app.version_number') }}

    @yield('footer')
</div>
</body>
</html>
