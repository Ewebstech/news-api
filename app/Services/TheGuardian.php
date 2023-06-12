<?php
namespace App\Services;

use Carbon\Carbon;
use App\Model\Source;
use App\Model\Article;
use GuzzleHttp\Client;
use App\Contracts\NewsApiServices;
use Illuminate\Support\Facades\Log;


class TheGuardian extends NewsApiServices
{
    protected const NEWS_SOURCE = "theguardian.com";
    public function fetchSources(): array
    {
        try{
            $client = new Client();
            $req = $client->request('GET',"https://content.guardianapis.com/sections", [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'query' => [
                    'api-key'  => env('THE_GUARDIAN_API_KEY'),
                ]
            ]);
        
            $stream   = $req->getBody();
            $contents = json_decode($stream->getContents());

            $contents = $contents->response->results;
            foreach($contents as $source){
                $ng_source = Source::updateOrCreate(['id' => substr($source->id, 0, 10)],
                [
                    'category'       => $source->webTitle,
                    'description'    => $source->webTitle,
                    'url'            => $source->webUrl,
                    'language'       => 'en',
                    'country'        => 'sp',
                    'news_source'    => TheGuardian::NEWS_SOURCE,
                    'last_updated'   => time()
                ]);
            }
       
            $sources = Source::all()->toArray();
            return $sources;
        } catch(Exception $e){
            return handleException();
        }
        
    }

    public function fetchArticles(array $sources): string
    {
        try{
            $sources = array_slice($sources, 0, TheGuardian::RATE_LIMIT);
            foreach($sources as $source){
                $client = new Client();
                $req = $client->request('GET','https://content.guardianapis.com/search', [
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                    'query' => [
                        'sectionId'       => $source['id'],
                        'api-key'       => env('THE_GUARDIAN_API_KEY'),
                    ],
                ]);
        
                $stream   = $req->getBody();
                $contents = json_decode($stream->getContents());
                $contents = $contents->response->results;
        
                foreach($contents as $article){
                    $ng_article = Article::updateOrCreate(['url' => $article->webUrl],
                    [
                        'source_id'      => $source['id'],
                        'author'         => $article->pillarName,
                        'title'          => $article->webTitle,
                        'description'    => $article->description ?? 'No data',
                        'url'            => $article->webUrl,
                        'urlToImage'     => $article->urlToImage ?? 'No data',
                        'publishedAt'    => Carbon::parse($article->webPublicationDate)
                    ]);
                };

            }
            return TheGuardian::OK;
        } catch(Exception $e){
            return handleException();
        }
  
    }
    
}



