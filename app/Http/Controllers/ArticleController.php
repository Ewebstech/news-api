<?php

namespace App\Http\Controllers;

use Exception;
use App\Model\User;
use App\Model\Source;
use App\Model\Article;
use Illuminate\Http\Request;
use App\Model\UserPreference;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;


class ArticleController extends Controller
{
    /**
     * Endpoint to return feeds based on filter params
     * 
     * @param query author
     * @param query keyword
     * @param query category
     * @param query source
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function requestFeeds(Request $request): JsonResponse
    {

        $Query_ = Article::where('title','LIKE',"%{$request->query('keyword')}%");

        if( $request->has('author') ) {
            $Query_ = $Query_->where('author', '=', $request->query('author'));
        }

        if( $request->has('date') ) {
            $Query_ = $Query_->whereDate('publishedAt', '=', date('Y-m-d', strtotime($request->query('date'))));
        }

        if( $request->has('category') || $request->has('source') ) {
            $category = $request->query('category') ?? null;
            $source = $request->query('source') ?? null;

            $Query_ = $Query_->whereHas('source', function($query) use ($category, $source) {
                if($category !== null){
                    $query->where('category', $category);
                } 

                if($source !== null) {
                    $query->where('news_source', $source);
                }
            });
        }

        $Query_ = $Query_->get();

        return $this->okResponse('Feed Fetched Successfully', $Query_);

    }

    public function feeds(Request $request){
        $data = UserPreference::where('user_id', auth()->user()->id)->first()->toArray();
        $sources = explode(',', $data['sources']);
        $authors = explode(',', $data['authors']);
        $categories = explode(',', $data['categories']);

        $newsFeed = Article::whereIn('author', $authors)
                    ->whereHas('source', function($query) use ($categories, $sources) {
                            $query->whereIn('category', $categories);
                            $query->whereIn('news_source', $sources);
                        })->get();

        return $this->okResponse('Feed Fetched Successfully', $newsFeed);
    }

    public function getAuthors(Request $request) {
        try {
            $data = Article::distinct('author')->pluck('author')->toArray();

            return $this->okResponse('Categories fetched successfully', $data);

        } catch(Exception $e) {
            return $this->serverErrorResponse("Exception: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
        }
    }
}