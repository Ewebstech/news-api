<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Model\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;


class ArticleController extends Controller
{
    public function getAuthors(Request $request) {
        try {
            $data = Article::distinct('author')->pluck('author')->toArray();

            return $this->okResponse('Categories fetched successfully', $data);

        } catch(Exception $e) {
            return $this->serverErrorResponse("Exception: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
        }
    }
}