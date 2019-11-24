<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortenRequest;
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
    public function update(ShortenRequest $request, Shorten $shorten)
    {
        $urlRequested = $request->url;
        $word = isset($request->word) ? $request->word : null;


        $url = $shorten
            ->where('url', $urlRequested)
            ->orWhere('word', $urlRequested)
            ->first();

        // URL already registered
        if ($url) {
            $url->touch();

            return $this->responseWithAttributes($url);
        }

        // URL is typed shortened
        if (!preg_match('/[^a-z]/', $urlRequested)) {

            $url = $shorten
                ->where('word', $urlRequested)
                ->where('url', null)
                ->first();

            if ($url) {

                $url->url = $urlRequested;
                $url->save();
                return $this->responseWithAttributes($url);
            }
        }

        // If word not selected get an radon free word
        if (!$word) {
            $shortenModel = $shorten
                ->whereNull('url')
                ->inRandomOrder()
                ->first();

            $shortenModel->update([
                'url' => $urlRequested
            ]);

            return $this->responseWithAttributes($shortenModel);
        }

        //{"message":"The given data was invalid.","errors":{"url":["The url format is invalid."]}}

        $shorten->word = $request->word;
        $shorten->url = $request->url;

        $shorten->save();

        return $this->responseWithAttributes($shorten);
    }

    private function responseWithAttributes($param)
    {
        return response()->json([
            'data' => $param
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

    public function fetchRecentLinks()
    {
        $data = Shorten::whereNotNull('url')->orderBy('updated_at', 'DESC')->get();

        return response()->json($data);
    }
}
