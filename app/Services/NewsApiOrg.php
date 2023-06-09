<?php

use App\Source;
use App\Article;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Contracts\NewsApiServices;


class NewsApiOrg extends NewsApiServices
{
    public function fetchSources()
    {
        try{
            $client = new Client();
            $req = $client->request('GET','https://newsapi.org/v1/sources', [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ]);
        
            $stream   = $req->getBody();
            $contents = json_decode($stream->getContents());
            $sources = collect($contents->sources);
        
            $sources->each(function ($source) {
                $ng_source = Source::updateOrCreate(['id' => $source->id],
                [
                    'category'       => $source->category,
                    'description'    => $source->description,
                    'url'            => $source->url,
                    'language'       => $source->language,
                    'country'        => $source->country,
                    'last_updated'   => time()
                ]);
            });

            return Source::all();
        } catch(Exception $e){
            return handleException();
        }
        
    }

    public function fetchArticles()
    {
        try{
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
                    'publishedAt'    => Carbon::parse($article->publishedAt)
                ]);
            });

            return NesApiOrg::OK;
        } catch(Exception $e){
            return handleException();
        }
  
    }
    
}



