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
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Shorten $shorten
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ShortenRequest $request, Shorten $shorten)
    {
        $word = isset($request->word) ? $request->word : null;
        $mainUrl = config('app.url');
        $data = [];

        $shortenAlreadyCreated = $shorten
            ->where('url', $request->url)
            ->orWhere('word', $request->url)
            ->first();

        // URL already registered
        if ($shortenAlreadyCreated) {

            $shortenAlreadyCreated->touch();

            $data['shortened'] = $shortenAlreadyCreated;
            $data['message'][] = 'URL ' . $mainUrl . '/' . $shortenAlreadyCreated->url . ' already in use, register updated';

            return $this->responseWithData($data);
        }

        // URL is a single word shortened word
        if (!preg_match('/[^a-z]/', $request->url)) {

            $url = $shorten
                ->where('word', $request->url)
                ->where('url', null)
                ->first();

            if ($url) {
                $url->updata([
                    'url' => $request->url
                ]);

                $data['shortened'] = $shortenAlreadyCreated;
                $data['message'][] = 'URL ' . $mainUrl . '/' . $request->url . ' shortened to ' . $mainUrl . '/' . $shortenAlreadyCreated->word;

                return $this->responseWithData($data);
            }
        }

        // If word not selected get an radon free word
        if (!$word) {
            $shortenModel = $shorten
                ->whereNull('url')
                ->inRandomOrder()
                ->first();

            $shortenModel->update([
                'url' => $request->url
            ]);

            $data['shortened'] = $shortenModel;
            $data['message'][] = 'URL ' . $mainUrl . '/' . $request->url . ' shortened to ' . $mainUrl . '/' . $shortenModel->word;

            return $this->responseWithData($data);
        }

        $shorten
            ->where('word', $request->word)
            ->update(['url' => $request->url]);

        $data['shortened'] = $shorten;
        $data['message'][] = 'URL ' . $mainUrl . '/' . $request->url . ' shortened to ' . $mainUrl . '/' . $request->word;

        return $this->responseWithData($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchWords()
    {
        $data = Shorten::whereNull('url')->pluck('word');

        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchRecentLinks()
    {
        $data = Shorten::whereNotNull('url')->orderBy('updated_at', 'DESC')->limit(10)->get();

        return response()->json($data);
    }


    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    private function responseWithData($data)
    {
        return response()->json($data);
    }


    public function list()
    {
        $links = Shorten::whereNotNull('url')->get();
        return view('list', compact('links'));
    }
}
