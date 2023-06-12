<?php

namespace App\Http\Controllers;

use Exception;
use App\Model\User;
use App\Model\Source;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;


class SourceController extends Controller
{
    /**
     * Fetch All News Categories
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories(Request $request): JsonResponse
    {
        try {
            $data = Source::distinct('category')->pluck('category')->toArray();

            return $this->okResponse('Categories fetched successfully', $data);

        } catch(Exception $e) {
            return $this->serverErrorResponse("Exception: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
        }
    }

    /**
     * Fetch all sources
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSources(Request $request): JsonResponse 
    {
        try {
            $data = Source::distinct('news_source')->pluck('news_source')->toArray();

            return $this->okResponse('News Sources fetched successfully', $data);

        } catch(Exception $e) {
            return $this->serverErrorResponse("Exception: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
        }
    }

  
}