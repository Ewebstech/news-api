<?php
namespace App\Services;

use Carbon\Carbon;
use App\Model\Source;
use App\Model\Article;
use GuzzleHttp\Client;
use App\Contracts\NewsApiServices;
use Illuminate\Support\Facades\Log;


class NewsApiOrg extends NewsApiServices
{
    protected const NEWS_SOURCE = "newsapi.org";
    public function fetchSources(): array
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
                    'news_source'    => NewsApiOrg::NEWS_SOURCE,
                    'last_updated'   => time()
                ]);
            });

            $sources = Source::where('news_source', NewsApiOrg::NEWS_SOURCE)->get()->toArray();
            return $sources;
        } catch(Exception $e){
            return handleException();
        }
        
    }

    public function fetchArticles(array $sources): string
    {
        try{
            $sources = array_slice($sources, 0, NewsApiOrg::RATE_LIMIT);
            foreach($sources as $source){
                $client = new Client();
                $req = $client->request('GET','https://newsapi.org/v1/articles', [
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                    'query' => [
                        'source'       => $source['id'],
                        'apiKey'       => env('NEWSAPI_API_KEY'),
                    ],
                ]);
        
                $stream   = $req->getBody();
                $contents = json_decode($stream->getContents());
                $articles = collect($contents->articles);
        
                $articles->each(function ($article) use ($source) {
                    $ng_article = Article::updateOrCreate(['url' => $article->url],
                    [
                        'source_id'      => $source['id'],
                        'author'         => $article->author,
                        'title'          => $article->title,
                        'description'    => $article->description ?? 'No data',
                        'url'            => $article->url,
                        'urlToImage'     => $article->urlToImage ?? 'No data',
                        'publishedAt'    => Carbon::parse($article->publishedAt)
                    ]);
                });

            }
            return NewsApiOrg::OK;
        } catch(Exception $e){
            return handleException();
        }
  
    }
    
}



