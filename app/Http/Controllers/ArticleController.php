<?php

namespace App\Http\Controllers;

use App\Article;
use App\Source;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ArticleController extends Controller
{
    public function index(Request $request, Source $source) {
        $client = new Client();
        $req = $client->request('GET','https://newsapi.org/v1/articles', [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
            'query' => [
                'source'       => $source->id,
                'apiKey'       => env('NEWSAPI_API_KEY'),
            ],
        ]);

        $stream   = $req->getBody();
        $contents = json_decode($stream->getContents());
        $articles = collect($contents->articles);

        $articles->each(function ($article) use ($source) {
            $ng_article = Article::updateOrCreate(['url' => $article->url],
            [
                'source_id'      => $source->id,
                'author'         => $article->author,
                'title'          => $article->title,
                'description'    => $article->description,
                'url'            => $article->url,
                'urlToImage'     => $article->urlToImage,
                'publishedAt'    => Carbon::parse($article->publishedAt),
                'NG_Description' => 'www',
                'NG_Review'      => 'zzz',
            ]);
        });


        return Article::where('source_id', $source->id)->get();
    }

    public function show(Request $request, Source $source, Article $article) {
        return $article;
    }
}
