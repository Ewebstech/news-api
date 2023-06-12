<?php
namespace App\Services;

use Carbon\Carbon;
use App\Model\Source;
use App\Model\Article;
use GuzzleHttp\Client;
use App\Contracts\NewsApiServices;
use Illuminate\Support\Facades\Log;


class NYTimes extends NewsApiServices
{
    protected const NEWS_SOURCE = "nytimes.com";
    public function fetchSources(): array
    {
        $year = 2018;
        $month = 9;
        try{
            $client = new Client();
            $req = $client->request('GET', "https://api.nytimes.com/svc/search/v2/articlesearch.json", [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'query' => [
                    'api-key'  => env('NY_TIMES_API_KEY'),
                ]
            ]);
        
            $stream   = $req->getBody();
            $contents = json_decode($stream->getContents());

            $contents = $contents->response->docs;
            foreach($contents as $source){
                $ng_source = Source::updateOrCreate(['id' => substr($source->_id, 0, 10)],
                [
                    'category'       => $source->section_name,
                    'description'    => $source->snippet,
                    'url'            => $source->web_url,
                    'language'       => 'en',
                    'country'        => 'sp',
                    'news_source'    => NYTimes::NEWS_SOURCE,
                    'last_updated'   => time()
                ]);
            }
       
            $sources = Source::where('news_source', NYTimes::NEWS_SOURCE)->get()->toArray();
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
                $req = $client->request('GET','https://api.nytimes.com/svc/search/v2/articlesearch.json', [
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                    'query' => [
                        'section_name'  => $source['category'],
                        'api-key'       => env('NY_TIMES_API_KEY'),
                    ],
                ]);
        
                $stream   = $req->getBody();
                $contents = json_decode($stream->getContents());
                $contents = $contents->response->docs;
        
                foreach($contents as $article){
                    $ng_article = Article::updateOrCreate(['url' => $article->web_url],
                    [
                        'source_id'      => $source['id'],
                        'author'         => $article->byline->original,
                        'title'          => $article->abstract,
                        'description'    => $article->lead_paragraph ?? 'No data',
                        'url'            => $article->web_url,
                        'urlToImage'     => $article->multimedia[0]->url ?? 'No data',
                        'publishedAt'    => Carbon::parse($article->pub_date)
                    ]);
                };

            }
            return TheGuardian::OK;
        } catch(Exception $e){
            return handleException();
        }
  
    }
    
}



