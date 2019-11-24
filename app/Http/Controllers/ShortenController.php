<?php

namespace App\Http\Controllers;

use App\Shorten;
use Illuminate\Http\Request;

class ShortenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Shorten $shorten
     * @return \Illuminate\Http\Response
     */
    public function show(Shorten $shorten)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Shorten $shorten
     * @return \Illuminate\Http\Response
     */
    public function edit(Shorten $shorten)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Shorten $shorten
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shorten $shorten)
    {
        /*$validatedData = $request->validate([
            'url' => 'required|url',
        ]);*/
        $globalURL = config('app.url');
        $errors = [];
        $urlRequest = $request->url;
        $word = $request->word ?? null;

        $url = $shorten->where('url', $urlRequest)->first();

        // URL already registered
        if (!$url){
            $url->updated_at = now();
        }


        if ($word){

            $urlRequest;

        }




        // URL is typed shortened
        // WORD is not selected
        // WORD is selected


        //{"message":"The given data was invalid.","errors":{"url":["The url format is invalid."]}}

       /* if (!$validatedData) {

            return response()->json($validatedData);
        }

        if (!$validatedData) {

            return response()->json($validatedData);
        }*/

        $shorten->url = $request->url;

        $shorten->save();

        return response()->json([
            'shorten' => $shorten,
            'errors' => $errors
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Shorten $shorten
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shorten $shorten)
    {
        //
    }

    public function fetchWords()
    {
        $data = Shorten::whereNull('url')->pluck('word');

        return response()->json($data);
    }
}
