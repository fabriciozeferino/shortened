<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortenRequest;
use App\Shorten;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ShortenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ShortenRequest $request
     * @param Shorten $shorten
     * @return JsonResponse
     */
    public function update(ShortenRequest $request, Shorten $shorten)
    {
        $word = $request->has('word') ? $request->word : null;
        $mainUrl = config('app.url');
        $data = [];

        $shortenAlreadyInUse = $shorten->checkUrl($request->url);

        // URL already in use
        if ($shortenAlreadyInUse) {

            $shortenAlreadyInUse->touch();

            $data['shortened'] = $shortenAlreadyInUse;
            $data['message'][] = 'URL ' . $mainUrl . '/' . $shortenAlreadyInUse->url . ' already in use as ' . $mainUrl . '/' . $shortenAlreadyInUse->word . ', register updated';

            return $this->responseWithData($data);
        }

        // URL is a single word can be a shortened word
        if (!preg_match('/[^a-z]/', $request->url) || !$word) {

            $url = $shorten->checkUrl($request->url, $request->url);

            if ($url) {

                info('url');


                $url->update([
                    'url' => $request->url
                ]);

                $data['shortened'] = $shortenAlreadyInUse;
                $data['message'][] = 'URL ' . $mainUrl . '/' . $url->url . ' shortened to ' . $mainUrl . '/' . $url->word;

                return $this->responseWithData($data);
            }
        }

        // If word is null get an radon free word
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

        // Create a new shortened URL
        $shorten->where('word', $request->word)
            ->update(['url' => $request->url]);

        $data['shortened'] = $shorten;
        $data['message'][] = 'URL ' . $mainUrl . '/' . $request->url . ' shortened to ' . $mainUrl . '/' . $request->word;

        return $this->responseWithData($data);
    }

    /**
     * @return JsonResponse
     */
    public function fetchWords()
    {
        $data = Shorten::whereNull('url')->pluck('word');

        return response()->json($data);
    }

    /**
     * @return JsonResponse
     */
    public function fetchRecentLinks()
    {
        $data = Shorten::whereNotNull('url')->orderBy('updated_at', 'DESC')->limit(10)->get();

        return response()->json($data);
    }


    /**
     * @param $data
     * @return JsonResponse
     */
    private function responseWithData($data)
    {
        return response()->json($data);
    }


    /**
     * Return list of URL's already in use
     *
     * @return Factory|View
     */
    public function list()
    {
        $links = Shorten::whereNotNull('url')->orderBy('visited', 'DESC')->get();

        return view('list', compact('links'));
    }

    public function listWord($word)
    {
        $shorten = New Shorten;
        if ($word) {
            $shorten->visited($word);
        }

        $links = $shorten->whereNotNull('url')->orderBy('visited', 'DESC')->get();

        return view('list', compact('links', 'word'));
    }
}
