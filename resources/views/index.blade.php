<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shortened</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="font-body bg-lightgray text-gray w-full m-0 p-0 leading-normal tracking-normal">
<div class="bg-white">
    <div class="container max-w-6xl mx-auto h-navbar flex items-center">
        <img class="h-logo" src="{{ url('images/hn-bit-logo.png') }}" alt="">
    </div>
</div>
<div class="container max-w-6xl mx-auto">
    <div id="shorten">
        <shorten-component global-url="{{ $globalURL }}"></shorten-component>
    </div>
</div>
</body>
<script src="{{ mix('js/app.js') }}"></script>
</html>
