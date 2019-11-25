@extends('layout')
@section('content')

    <div id="shorten">
        <shorten-component global-url="{{ $globalURL }}"></shorten-component>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
@endsection
