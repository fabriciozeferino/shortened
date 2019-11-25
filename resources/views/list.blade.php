@extends('layout')
@section('content')
    <div class="container w-full flex flex-wrap mx-auto px-2 pt-4 mt-8">
        <div class="w-full lg:w-1/5 lg:px-6 text-xl text-gray leading-normal">
            <p class="text-base font-bold text-gray">Menu</p>
            <div
                class="w-full sticky inset-0 h-64 lg:h-auto overflow-x-hidden overflow-y-auto lg:overflow-y-hidden lg:block mt-0 border border-gray lg:border-transparent bg-white shadow lg:shadow-none lg:bg-transparent z-20"
            >
                <ul class="list-reset">

                    @foreach ($links as $key => $link)
                        <li class="py-2 md:my-0 hover:bg-gray hover:bg-blue">
                            <a href="{{ $globalURL . '/' . $link->word }}"
                               class="block pl-4 align-middle text-gray no-underline hover:text-white border-l-4 border-transparent hover:border-blue">
                                <span
                                    class="pb-1 md:pb-0 text-sm text-gray-900 font-bold uppercase">{{$link->word}}</span>
                                <span
                                    class="inline-block bg-blue text-white text-xs px-2 rounded-full uppercase font-semibold tracking-wide">{{ $link->visited }}</span>
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
        <div
            class="w-full lg:w-4/5 p-8 mt-6 lg:mt-0 text-gray-900 leading-normal bg-white border border-gray-400 border-rounded">
            <!--Title-->
            <div>
                <h1 class="font-sans break-normal text-gray-900 pt-6 pb-2 text-xl">{{ isset($word) ? $word : 'Welcome!!' }}</h1>
            </div>

        </div>
    </div>
@endsection
