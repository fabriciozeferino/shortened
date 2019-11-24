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
    <div class="w-full">
        <h1 class="text-title mb-2"><a href="shorten/list">Recent Links</a></h1>

        @foreach ($links as $key => $link)
            <div class="p-4 border bg-white">

                <a class="block text-link text-blue" href="{{ $globalURL .'/'. $link->word }}">{{ $globalURL .'/'. $link->word }}</a>
                <span class="block text-base">{{ $link->updated_at }}</span>
                <span class="block">{{ $globalURL .'/'. $link->url }}</span>

            </div>
        @endforeach
    </div>
</div>
</body>
</html>
