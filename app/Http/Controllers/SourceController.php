<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Model\Source;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;


class SourceController extends Controller
{
    public function getCategories(Request $request) {
        try {
            $data = Source::distinct('category')->pluck('category')->toArray();

            return $this->okResponse('Categories fetched successfully', $data);

        } catch(Exception $e) {
            return $this->serverErrorResponse("Exception: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
        }
    }

    public function getSources(Request $request) {
        try {
            $data = Source::distinct('news_source')->pluck('news_source')->toArray();

            return $this->okResponse('News Sources fetched successfully', $data);

        } catch(Exception $e) {
            return $this->serverErrorResponse("Exception: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
        }
    }

  
}